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

      // Simplificación de la manipulación de la dirección.
      $matches = \explode(' /', $return['personalInfo']['address']);
      foreach ($matches as $item) {
        if (strlen($item) > 2) {
          $return['personalInfo']['address'] = substr($item, 0, 50);
        }
      }

      $key_brand = $polizas[$index_vigencia]['codigoBroker'];
      $brand = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];

      $this->validateBrand($polizas, $index_vigencia, $return, $brand, $key_brand);

      // Si la marca es "GREAT WALL", modificar el nombre de la marca.
      if (isset($polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'])) {
        $brand = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
        if (strpos($brand, 'GREAT WALL') !== FALSE) {
          $return['personalInfo']['brand'] = 'GREAT WALL MOTOR';
        }
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

  private function checkInRange($oldest_model, $latest_model, $model) {
    $oldest_model = strtotime($oldest_model);
    $latest_model = strtotime($latest_model);
    $model = strtotime($model);

    return ($model >= $oldest_model && $model <= $latest_model);
  }

  private function policyBasicData($polizas, $index_vigencia, $type): array {
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
      }
      elseif (in_array($item['codigoGarantia'], [756, 9036])) {
        $data['guarantees']['rc1'] = $item['codigoGarantia'];
      }
      elseif (in_array($item['codigoGarantia'], [757, 9037])) {
        $data['guarantees']['rc3'] = $item['codigoGarantia'];
      }
    }

    return $data;
  }

  private function validateBrand($polizas, $index_vigencia, &$return, $brand, $key_brand): void {

    $config2 = $this->configFactory->get('liberty_claims_email.settings');
    $cod_brand_colectivo = 'cod_' . strtolower($brand). '_colectivo';
    $cod_brand_chevy = 'cod_chevyseguro_colectivo';
    if($polizas[$index_vigencia]['codigoBroker'] == $config2->get($cod_brand_colectivo) || $polizas[$index_vigencia]['codigoBroker'] == $config2->get($cod_brand_chevy))
    {
      $marca_poliza = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
            if ($marca_poliza === 'CHEVROLET') {
        if ($polizas[$index_vigencia]['codigoBroker'] == $config2->get($cod_brand_chevy)) {
          $brands = ['RCIRenault', 'RCINissan'];
          foreach ($brands as $brand) {
            if (isset($_SESSION[$brand])) {
              $this->unsetSessionForBrand($brand);
            }
          }
          $this->handleChevrolet($polizas, $index_vigencia, $return, true);
        } else {
          $brands = ['RCIRenault', 'RCINissan'];
          foreach ($brands as $brand) {
            if (isset($_SESSION[$brand])) {
              $this->unsetSessionForBrand($brand);
            }
          }
          $this->handleChevrolet($polizas, $index_vigencia, $return, false);
        }
      }
      else if ($marca_poliza != 'CHEVROLET' && $polizas[$index_vigencia]['codigoBroker'] == $config2->get($cod_brand_chevy)) {
        $brands = ['GMFChevrolet', 'RCIRenault', 'RCINissan'];
        foreach ($brands as $brand) {
          if (isset($_SESSION[$brand])) {
            $this->unsetSessionForBrand($brand);
          }
        }

        $this->handleOtherBrands($polizas, $index_vigencia, $return, $marca_poliza, false);
      }
      else if ($marca_poliza === 'NISSAN' || $marca_poliza === 'RENAULT') {
        if ($polizas[$index_vigencia]['codigoBroker'] != $config2->get($cod_brand_colectivo)) {
          $brands = ['GMFChevrolet', 'RCIRenault', 'RCINissan'];
          foreach ($brands as $brand) {
            if (isset($_SESSION[$brand])) {
              $this->unsetSessionForBrand($brand);
            }
          }
          $_SESSION[$marca_poliza]['colectivo'] = false;
          $this->handleOtherBrands($polizas, $index_vigencia, $return, $marca_poliza, false);
        }
        else
        {
          $brands = ['GMFChevrolet', 'RCIRenault', 'RCINissan'];
          foreach ($brands as $brand) {
            if (isset($_SESSION[$brand])) {
              $this->unsetSessionForBrand($brand);
            }
          }
          $_SESSION[$marca_poliza]['colectivo'] = true;
          $this->handleOtherBrands($polizas, $index_vigencia, $return, $marca_poliza, true);
        }
      }
    } else {
      if($brand === 'RENAULT')
      {
        if ($this->claimServices->validateBrokerInTaxonomy($polizas[$index_vigencia]['codigoBroker']))
        {
          $marca_poliza = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
          $brands = ['GMFChevrolet', 'RCIRenault', 'RCINissan'];
          foreach ($brands as $brand) {
            if (isset($_SESSION[$brand])) {
              $this->unsetSessionForBrand($brand);
            }
          }
          $_SESSION[$marca_poliza]['colectivo'] = false;
          $this->handleOtherBrands($polizas, $index_vigencia, $return, $marca_poliza, false);
        }
        else
        {
          $brands = ['GMFChevrolet', 'RCIRenault', 'RCINissan'];
          foreach ($brands as $brand) {
            if (isset($_SESSION[$brand])) {
              $this->unsetSessionForBrand($brand);
            }
          }
        }

      }
      else{
        $brands = ['GMFChevrolet', 'RCIRenault', 'RCINissan'];
        foreach ($brands as $brand) {
          if (isset($_SESSION[$brand])) {
            $this->unsetSessionForBrand($brand);
          }
        }
      }

    }
  }

private function handleChevrolet($polizas, $index_vigencia, &$return, $chevy): void {

    if($chevy === false){
      $model = $polizas[$index_vigencia]['riesgoAuto']['automovil']['version'];
      $model_base = date('Y');
      $latest_model = date('Y-m-d', strtotime($model_base . '+ 1 year'));
      $oldest_model = date('Y', strtotime($this->config->get('last_model') . '- 8 year'));

      if ($this->checkInRange($oldest_model, $latest_model, $model)) {
          $return['GMFChevrolet']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
          $_SESSION['GMFChevrolet'] = $return['GMFChevrolet'];
      } else {
          $this->unsetSessionForBrand('GMFChevrolet');
      }
    }
    else
    {
      $return['GMFChevrolet']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
      $_SESSION['GMFChevrolet'] = $return['GMFChevrolet'];
    }
  }

private function handleOtherBrands($polizas, $index_vigencia, &$return, $brand, $collective): void {

    if($collective === true)
    {
      $sessionKey = 'RCI' . ucfirst(strtolower($brand));
      $return[$sessionKey]['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
      $_SESSION[$sessionKey] = $return[$sessionKey];
    }
    else{
      $sessionKey = 'RCI' . ucfirst(strtolower($brand));
      $return[$sessionKey]['codigoConcesionario'] = $polizas[$index_vigencia]['codigoBroker'];
      $_SESSION[$sessionKey] = $return[$sessionKey];
    }
  }

private function unsetSessionForBrand($brandSessionKey): void {
    if (isset($_SESSION[$brandSessionKey])) {
        unset($_SESSION[$brandSessionKey]);
    }
  }
}
