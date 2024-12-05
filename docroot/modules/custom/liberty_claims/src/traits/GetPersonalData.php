<?php

namespace Drupal\liberty_claims\traits;

trait GetPersonalData {

  private $docTypes = [
    'CC' => 36,
    'CE' => 33,
    'CD' => 44,
    'PAS' => 40,
    'RC' => 35,
    'TI' => 34,
    'NI' => 37,
  ];

  public function personalInfo ($polizas, $index_vigencia, $is_juridic = false) {
    $person_field = $is_juridic ? 'aseguradoPersonaJuridica' : 'aseguradoPersonaNatural';
    $personal_data = $polizas[$index_vigencia]['riesgoAuto'][$person_field];
    $conductor_data = $polizas[$index_vigencia]['riesgoAuto']['conductorPersonaNatural'][0] ?? null;
    $driverData = null;

    // If personal_data have more than one array index, then use
    // conductorPersonalData.
    if (isset($personal_data[0]) && count($personal_data) > 1) {
      $driverData = $this->driverData($conductor_data ?? $personal_data[0]);
    } else {
      $driverData = $this->driverData($personal_data, $is_juridic);
    }

    return [
      'name' => $driverData['name'] ?? '',
      'lastname' => $driverData['last_name'] ?? '',
      'documentId' => $driverData['document_id'] ?? '',
      'docType' => $driverData['doc_type'] ?? '',
      'email' => $driverData['email'] ?? '',
      'address' => $driverData['address'] ?? '',
      'brand' => isset($polizas[$index_vigencia])
        ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca']
        : '',
      'model' => isset($polizas[$index_vigencia])
        ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['version']
        : '',
      'phone' => $driverData['phone'] ?? '',
      'isJuridic' => $is_juridic,
    ];
  }

  private function driverData ($driver_data, $is_juridic = false) {
    if (isset($driver_data['email'])) {
      $email = trim($driver_data['email']);
    } elseif (isset($driver_data['mail'])) {
      $email = trim($driver_data['mail']);
    }

    if ($is_juridic) {
      $name = $driver_data['razonSocial'] ?? '';
      $last_name = ' ';
    } else {
      $name = isset($driver_data['primerNombre'])
        ? $driver_data['primerNombre'] . ' ' . @$driver_data['segundoNombre']
        : '';
      $last_name = isset($driver_data['primerApellido'])
        ? $driver_data['primerApellido'] . ' ' . @$driver_data['segundoApellido']
        : '';
    }

    return [
      'name' => $name,
      'last_name' => $last_name,
      'document_id' => $driver_data['numeroDocumento'] ?? '',
      'doc_type' => isset($driver_data['tipoDocumento']) && $driver_data['tipoDocumento']
        ? $this->docTypes[$driver_data['tipoDocumento']['codigo']]
        : 0,
      'email' => $email,
      'address' => isset($driver_data['direccion']) ? $driver_data['direccion']['direccion'] : '',
      'phone' => isset($driver_data['telefono']) && $driver_data['telefono']['numero'] != 0
        ? $driver_data['telefono']['numero']
        : ''
    ];
  }
}
