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
      }
      elseif (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaJuridica'])) {
        $return['personalInfo'] = $this->personalInfo($polizas, $index_vigencia, TRUE);
      }

      $matches = \explode(' /', $return['personalInfo']['address']);

      foreach ($matches as $item) {
        if (strlen($item) > 2) {
          $return['personalInfo']['address'] = substr($item, 0, 50);
        }
      }

      $this->validateChevrolet($polizas, $index_vigencia, $return);
      $this->validateNissan($polizas, $index_vigencia, $return);
      $this->validateRenault($polizas, $index_vigencia, $return);
      $this->validateChevyPlan($polizas, $index_vigencia, $return);

      if (isset($polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'])) {
        $brand = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
        if (strpos($brand, 'GREAT WALL') !== FALSE) {
          $return['personalInfo']['brand'] = 'GREAT WALL MOTOR';
        }
      }

      // Previus policy from HDI.
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

  /**
   * Verify model range is correct.
   *
   * @param $oldest_model string
   *    Oldest model for GMFChevrolet
   * @param $latest_model string
   *    New model for GMFChevrolet
   * @param $model string
   *    Actual vehicle model
   *
   * @return bool
   */
  private function checkInRange($oldest_model, $latest_model, $model) {
    $oldest_model = strtotime($oldest_model);
    $latest_model = strtotime($latest_model);
    $model = strtotime($model);

    if ($model >= $oldest_model && $model <= $latest_model) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Get basic data for selected policy.
   *
   * @param $polizas array
   * @param $index_vigencia string
   * @param $type string
   *
   * @return array
   */
  private function policyBasicData($polizas, $index_vigencia, $type): array {
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
          $data['broker'] = TRUE;
        }
      }
      elseif ($item['codigoGarantia'] == 756 || $item['codigoGarantia'] == 9036) {
        $data['guarantees']['rc1'] = $item['codigoGarantia'];
      }
      elseif ($item['codigoGarantia'] == 757 || $item['codigoGarantia'] == 9037) {
        $data['guarantees']['rc3'] = $item['codigoGarantia'];
      }
    }

    return $data;
  }

  private function validateChevrolet($polizas, $index_vigencia, &$return): void {
    $config2 = $this->configFactory->get('liberty_claims_email.settings');

    $model = $polizas[$index_vigencia]['riesgoAuto']['automovil']['version'];
    $model_base = date('Y');
    $latest_model = date('Y-m-d', strtotime($model_base . '+ 1 year'));

    $oldest_model = date('Y', strtotime($this->config->get('last_model') . '- 8 year'));

    if ($polizas[$index_vigencia]['codigoBroker'] == $config2->get('cod_chevrolet')) {
      $marca_poliza = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
      if (
        $this->checkInRange($oldest_model, $latest_model, $model) && strtoupper($marca_poliza) === "CHEVROLET"
      ) {
        $return['GMFChevrolet']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
        $_SESSION['GMFChevrolet'] = $return['GMFChevrolet'];
      }
      else {
        if (isset($_SESSION['GMFChevrolet'])) {
          unset($_SESSION['GMFChevrolet']);
        }
      }
    }
    else {
      if (isset($_SESSION['GMFChevrolet'])) {
        unset($_SESSION['GMFChevrolet']);
      }
    }
  }

  private function validateNissan($polizas, $index_vigencia, &$return): void {
    $config2 = $this->configFactory->get('liberty_claims_email.settings');

    $model = $polizas[$index_vigencia]['riesgoAuto']['automovil']['version'];
    $model_base = date('Y');
    $latest_model = date('Y-m-d', strtotime($model_base . '+ 1 year'));

    $oldest_model = date('Y', strtotime($this->config->get('last_model') . '- 5 year'));

    if ($polizas[$index_vigencia]['codigoBroker'] == $config2->get('cod_nissan')) {
      $marca_poliza = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
      if (
        $this->checkInRange($oldest_model, $latest_model, $model) && strtoupper($marca_poliza) === "NISSAN"
      ) {
        $return['RCINissan']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
        $_SESSION['RCINissan'] = $return['RCINissan'];
      }
      else {
        if (isset($_SESSION['RCINissan'])) {
          unset($_SESSION['RCINissan']);
        }
      }
    }
    else {
      if (isset($_SESSION['RCINissan'])) {
        unset($_SESSION['RCINissan']);
      }
    }
  }

  private function validateRenault($polizas, $index_vigencia, &$return): void {
    $config2 = $this->configFactory->get('liberty_claims_email.settings');

    $model = $polizas[$index_vigencia]['riesgoAuto']['automovil']['version'];
    $model_base = date('Y');
    $latest_model = date('Y-m-d', strtotime($model_base . '+ 1 year'));

    $oldest_model = date('Y', strtotime($this->config->get('last_model') . '- 5 year'));

    if ($polizas[$index_vigencia]['codigoBroker'] == $config2->get('cod_renault')) {
      $marca_poliza = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
      if (
        $this->checkInRange($oldest_model, $latest_model, $model) && strtoupper($marca_poliza) === "RENAULT"
      ) {
        $return['RCIRenault']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
        $_SESSION['RCIRenault'] = $return['RCIRenault'];
      }
      else {
        if (isset($_SESSION['RCIRenault'])) {
          unset($_SESSION['RCIRenault']);
        }
      }
    }
    else {
      if (isset($_SESSION['RCIRenault'])) {
        unset($_SESSION['RCIRenault']);
      }
    }
  }

  private function validateChevyplan($polizas, $index_vigencia, &$return): void {
    $config2 = $this->configFactory->get('liberty_claims_email.settings');

    $model = $polizas[$index_vigencia]['riesgoAuto']['automovil']['version'];
    $model_base = date('Y');
    $latest_model = date('Y-m-d', strtotime($model_base . '+ 1 year'));

    $oldest_model = date('Y', strtotime($this->config->get('last_model') . '- 8 year'));

    if ($polizas[$index_vigencia]['codigoBroker'] == $config2->get('cod_chevyplan')) {
      $marca_poliza = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
      if (
        $this->checkInRange($oldest_model, $latest_model, $model) && strtoupper($marca_poliza) === "CHEVROLET"
      ) {
        $return['RCIChevyplan']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
        $_SESSION['RCIChevyplan'] = $return['RCIChevyplan'];
      }
      else {
        if (isset($_SESSION['RCIChevyplan'])) {
          unset($_SESSION['RCIChevyplan']);
        }
      }
    }
    else {
      if (isset($_SESSION['RCIChevyplan'])) {
        unset($_SESSION['RCIChevyplan']);
      }
    }
  }

}
