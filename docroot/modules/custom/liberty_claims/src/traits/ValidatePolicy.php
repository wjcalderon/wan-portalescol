<?php

namespace Drupal\liberty_claims\traits;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Component\Serialization\Yaml;
use Drupal\liberty_claims\traits\GetPersonalData;
use function explode;

trait ValidatePolicy
{
  private $config;

  use GetPersonalData;

  /**
   * @throws InvalidPluginDefinitionException
   * @throws PluginNotFoundException
   */
  public function validatePolicy($polizas, $index_vigencia, $type): array|string
  {
    $this->config = $this->configFactory->get('liberty_claims.settings');
    $return = $this->policy_basic_data($polizas, $index_vigencia, $type);

    if (array_key_exists('token', $return)) {
      if (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaNatural'])) {
        $return['personalInfo'] = $this->personalInfo($polizas, $index_vigencia);
      } elseif (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaJuridica'])) {
        $return['personalInfo'] = $this->personalInfo($polizas, $index_vigencia, TRUE);
      }

      // Simplificación de la manipulación de la dirección.
      $matches = explode(' /', $return['personalInfo']['address']);
      foreach ($matches as $item) {
        if (strlen($item) > 2) {
          $return['personalInfo']['address'] = substr($item, 0, 50);
        }
      }

      $policy_broker_code = $polizas[$index_vigencia]['codigoBroker'];
      $policy_brand = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];

      $this->validate_brand($polizas, $index_vigencia, $return, $policy_brand, $policy_broker_code);

      // Si la marca es "GREAT WALL", modificar el nombre de la marca.
      if (isset($polizas[$index_vigencia]['riesgoAuto']['automovil']['marca']) && str_contains($policy_brand, 'GREAT WALL')) {
        $return['personalInfo']['brand'] = 'GREAT WALL MOTOR';
      }

      // Política anterior.
      $return['previusPolicy'] = $polizas[$index_vigencia]['polizaAnterior'] ?? '';

      return $return;
    }

    // Registro en log si no se encuentran garantías.
    $this->logger->set('consulta_placa', json_encode([
      'resultadoOperacion' => [
        'date' => date('Y-m-d\TH:i:s'),
        'message' => 'no hay garantias para la el caso',
        'estado' => 'no-guarantee',
      ],
    ]), $this->tokenLog);

    return 'no-guarantee';
  }

  private function check_in_range($oldest_model, $latest_model, $model): bool
  {
    $oldest_model = strtotime($oldest_model);
    $latest_model = strtotime($latest_model);
    $model = strtotime($model);

    return $model >= $oldest_model && $model <= $latest_model;
  }

  private function policy_basic_data($polizas, $index_vigencia, $type): array
  {
    $codes = Yaml::decode($this->config->get('insured_codes'));
    $data = [];

    foreach ($polizas[$index_vigencia]['riesgoAuto']['garantiasPoliza'] as $item) {
      if ($item['codigoGarantia'] == $codes[$type] || (is_array($codes[$type]) && in_array($item['codigoGarantia'], $codes[$type]))) {
        $dataToEncrypt = $polizas[$index_vigencia]['codigoProducto'] . '|' .
          $polizas[$index_vigencia]['numeroInternoSeguro'] . '|' .
          $polizas[$index_vigencia]['numeroPoliza'];
        $data['token'] = $this->crypt($dataToEncrypt, 'en');
        $brokers = Yaml::decode($this->config->get('brokers'));
        if (is_array($brokers) && in_array($polizas[$index_vigencia]['codigoBroker'], $brokers)) {
          $data['broker'] = TRUE;
        }
      } elseif (in_array($item['codigoGarantia'], [756, 9036])) {
        $data['guarantees']['rc1'] = $item['codigoGarantia'];
      } elseif (in_array($item['codigoGarantia'], [757, 9037])) {
        $data['guarantees']['rc3'] = $item['codigoGarantia'];
      }
    }

    return $data;
  }

  /**
   * @throws InvalidPluginDefinitionException
   * @throws PluginNotFoundException
   */
  private function validate_brand($polizas, $index_vigencia, &$return, $policy_brand, $policy_broker_code): void
  {
    $config = $this->configFactory->get('liberty_claims_email.settings');

    $this->unset_session_for_brand('RCIRenault');
    $this->unset_session_for_brand('RCINissan');
    $this->unset_session_for_brand('GMFChevrolet');
    // $this->unset_session_for_brand('RCIChevrolet');

    $brokers_codes = [
      'RCIRenault' => trim($config->get('cod_renault_colectivo')),
      'RCINissan' => trim($config->get('cod_nissan_colectivo')),
      'GMFChevrolet' => trim($config->get('cod_chevrolet')),
    ];

    switch ($policy_brand) {
      case 'CHEVROLET':
        // if ($policy_broker_code  !== $brokers_codes['GMFChevrolet'] && $this->validate_broker_in_taxonomy($policy_broker_code , $policy_brand)) {
        //   $_SESSION[$policy_brand]['colectivo'] = FALSE;
        //   $this->handle_other_brands($polizas, $index_vigencia, $return, $policy_brand, FALSE);
        // }

        if ($policy_broker_code === $brokers_codes['GMFChevrolet']) {
          $this->handle_chevrolet($polizas, $index_vigencia, $return, FALSE);
        }
        break;
      case 'NISSAN':
      case 'RENAULT':
        if ($policy_broker_code === $brokers_codes['RCIRenault'] ||
          $policy_broker_code === $brokers_codes['RCINissan']) {
          $this->handle_other_brands($polizas, $index_vigencia, $return, $policy_brand, TRUE);
        }
        if ($this->validateBrokerInTaxonomy($polizas[$index_vigencia]['codigoBroker'], $policy_brand)) {
          $_SESSION[$policy_brand]['colectivo'] = FALSE;
          $this->handle_other_brands($polizas, $index_vigencia, $return, $policy_brand, FALSE);
        }
        break;
      default:
        $this->unset_session_for_brand('RCIRenault');
        $this->unset_session_for_brand('RCINissan');
        $this->unset_session_for_brand('GMFChevrolet');
        // $this->unset_session_for_brand('RCIChevrolet');
        break;
    }
  }

  private function handle_chevrolet(array $polizas, int $index_vigencia, array &$return, bool $chevy): void
  {
    $return['GMFChevrolet']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
    $_SESSION['GMFChevrolet'] = $return['GMFChevrolet'];

    if (!$chevy) {
      $model = $polizas[$index_vigencia]['riesgoAuto']['automovil']['version'];
      $model_base = date('Y');
      $latest_model = date('Y-m-d', strtotime($model_base . '+ 1 year'));
      $oldest_model = date('Y', strtotime($this->config->get('last_model') . '- 8 year'));

      if (!$this->check_in_range($oldest_model, $latest_model, $model)) {
        $this->unset_session_for_brand('GMFChevrolet');
      }
    }
  }

  private function handle_other_brands($polizas, $index_vigencia, &$return, $brand, $collective): void
  {
    $sessionKey = 'RCI' . ucfirst(strtolower($brand));
    $codigoConcesionario = $polizas[$index_vigencia]['codigoBroker'];

    if ($collective) {
      $codigoConcesionario = $polizas[$index_vigencia]['codigoConcesionario'];
    }

    $return[$sessionKey]['codigoConcesionario'] = $codigoConcesionario;

    $_SESSION[$sessionKey] = $return[$sessionKey];
  }

  private function unset_session_for_brand($brandSessionKey): void
  {
    if (isset($_SESSION[$brandSessionKey])) {
      unset($_SESSION[$brandSessionKey]);
    }
  }
}
