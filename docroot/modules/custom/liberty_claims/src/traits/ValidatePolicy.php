<?php

namespace Drupal\liberty_claims\traits;

use Drupal\Component\Serialization\Yaml;
use Drupal\liberty_claims\traits\GetPersonalData;

trait ValidatePolicy {
  private $config;

  use GetPersonalData;

  public function validatePolicy($polizas, $index_vigencia, $type) {
    $this->config = $this->configFactory->get('liberty_claims.settings');
    $return = $this->policyBasicData($polizas, $index_vigencia, $type);

    if (array_key_exists('token', $return)) {
      if (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaNatural'])) {
        $return['personalInfo'] = $this->personalInfo($polizas, $index_vigencia);
      } elseif (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaJuridica'])) {
        $return['personalInfo'] = $this->personalInfo($polizas, $index_vigencia, true);
      }

      $matches = \explode(' /', $return['personalInfo']['address']);

      foreach ($matches as $item) {
        if (strlen($item) > 2) {
          $return['personalInfo']['address'] = substr($item, 0, 50);
        }
      }

      $this->validateChevrolet($polizas, $index_vigencia, $return);

      if (isset($polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'])) {
        $brand = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
        if (strpos($brand, 'GREAT WALL') !== false) {
          $return['personalInfo']['brand'] = 'GREAT WALL MOTOR';
        }
      }

      // Previus policy from HDI
      $return['previusPolicy'] = $polizas[$index_vigencia]['polizaAnterior'] ?? '';

      return $return;
    }

    $this->logger->set('consulta_placa', json_encode([
      'resultadoOperacion' => [
        'date' => date('Y-m-d\TH:i:s'),
        'message' => 'no hay garantias para la el caso',
        'estado' => 'no-guarantee',
      ],
    ]), $this->tokenLog);

    return 'no-guarantee';
  }

  private function policyBasicData ($polizas, $index_vigencia, $type): array {
    $codes = Yaml::decode($this->config->get('insured_codes'));
    $data = [];

    foreach ($polizas[$index_vigencia]['riesgoAuto']['garantiasPoliza'] as $item) {
      if (
        $item['codigoGarantia'] == $codes[$type] ||
        (is_array($codes[$type]) && in_array($item['codigoGarantia'], $codes[$type]))
      ) {
        $dataToEncrypt = $polizas[$index_vigencia]['codigoProducto'] . '|' .
          $polizas[$index_vigencia]['numeroInternoSeguro'] . '|' .
          $polizas[$index_vigencia]['numeroPoliza'];
        $data['token'] = $this->crypt($dataToEncrypt, 'en');
        $brokers = Yaml::decode($this->config->get('brokers'));
        if (is_array($brokers) && in_array($polizas[$index_vigencia]['codigoBroker'], $brokers)) {
          $data['broker'] = true;
        }
      } elseif ($item['codigoGarantia'] == 756 || $item['codigoGarantia'] == 9036) {
        $data['guarantees']['rc1'] = $item['codigoGarantia'];
      } elseif ($item['codigoGarantia'] == 757 || $item['codigoGarantia'] == 9037) {
        $data['guarantees']['rc3'] = $item['codigoGarantia'];
      }
    }

    return $data;
  }

  private function validateChevrolet($polizas, $index_vigencia, &$return): void {
    $config2 = $this->configFactory->get('liberty_claims_email.settings');

    $model = $polizas[$index_vigencia]['riesgoAuto']['automovil']['version'];
    $model_base = date('Y');
    $model_actual = date('Y-m-d', strtotime($model_base . '+ 1 year'));

    $six_year = date('Y', strtotime($this->config->get('last_model') . '- 6 year'));

    if ($polizas[$index_vigencia]['codigoBroker'] == $config2->get('cod_chevrolet')) {
      $marca_poliza = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
      if (
        $this->checkInRange($six_year, $model_actual, $model) && strtoupper($marca_poliza) === "CHEVROLET"
      ) {
        $return['GMFChevrolet']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
        $_SESSION['GMFChevrolet'] = $return['GMFChevrolet'];
      } else {
        if (isset($_SESSION['GMFChevrolet'])) {
          unset($_SESSION['GMFChevrolet']);
        }
      }
    } else {
      if (isset($_SESSION['GMFChevrolet'])) {
        unset($_SESSION['GMFChevrolet']);
      }
    }
  }
}
