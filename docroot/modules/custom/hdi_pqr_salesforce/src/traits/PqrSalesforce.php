<?php

namespace Drupal\hdi_pqr_salesforce\traits;

/**
 * Handle submit into Salesforce.
 */
trait PqrSalesforce {

  /**
   * Submit data into Salesforce API.
   *
   * @param array $form_data
   *   Form data from react app.
   *
   * @return array
   *   Response from Salesforce API.
   */
  public function submitDataSalesforce(array $form_data): array {
    $token = $this->getToken();

    // Create case in Salesforce.
    $response = json_decode($this->submitData($form_data, $token), TRUE);

    // Upload files if exist.
    if ($response['code'] === 200 && count($form_data['files']) > 0) {
      $this->uploadFiles($form_data['files'], $token, $response['caseId']);
    }

    return [
      'status' => $response['code'],
      'message' => $response['message'],
      'caseNumber' => $response['caseNumber'],
    ];
  }

  /**
   * Get token to authenticate request.
   *
   * @return string
   *   Salesforce auth token.
   */
  private function getToken(): string {
    $config = $this->configFactory->get('pqrsalesforce.settings');

    $request = $this->httpClient->post(
      $config->get('salesforce_token_endpoint'),
      [
        'query' => [
          'grant_type' => 'password',
          'client_id' => $config->get('salesforce_client_id'),
          'client_secret' => $config->get('salesforce_client_secret'),
          'username' => $config->get('salesforce_username'),
          'password' => $config->get('salesforce_password'),
        ],
      ])->getBody()->getContents();

    $response = json_decode($request, TRUE);

    return $response['access_token'];
  }

  /**
   * Submit data to Salesforce API.
   *
   * @param array $form_data
   *   Form data from react app.
   * @param string $token
   *   Token to authenticate request.
   *
   * @return string
   *   Response from Salesforce API.
   */
  private function submitData(array $form_data, string $token): string {
    $config = $this->configFactory->get('pqrsalesforce.settings');

    // Remove files to send to Salesforce.
    unset($form_data['files']);

    foreach ($form_data as $field => $value) {
      if (
        $field === 'SSP_TieneAlgunaCondicionEspecial__c'
        || $field === 'PQR_CasoReconsideracion__c'
      ) {
        $form_data[$field] = $value === FALSE ? 'No' : 'Si';
      }
    }

    // Add required data.
    $form_data['PQR_DescripcionMedioEnvio__c'] = 'Digital';
    $form_data['SSP_InstanciaRecepcion__c'] = 'Entidad vigilada';
    $form_data['SFPQR_TipoRegistroWebToCase__c'] = 'PQR';
    $form_data['SSP_Canal__c'] = 'Internet';
    $form_data['Estatus_SFC__c'] = 'Pendiente Creación';
    $form_data['LMG_PaisWebtoCase__c'] = 'COLOMBIA';
    $form_data['Origin'] = 'Portal Web';

    return $this->httpClient->post(
      $config->get('salesforce_endpoint') . '/apexrest/SSP/createCase',
      [
        'headers' => [
          'Content-Type' => 'application/json',
          'Authorization' => "Bearer $token",
        ],
        'body' => json_encode($form_data),
      ]
    )->getBody()->getContents();
  }

  /**
   * Save files into Salesforce API.
   *
   * @param array $form_data
   *   Files sent from react app.
   * @param string $token
   *   Authentication token.
   * @param string $case_id
   *   Case ID from Salesforce API.
   */
  private function uploadFiles(array $form_data, string $token, string $case_id) {
    $config = $this->configFactory->get('pqrsalesforce.settings');

    foreach ($form_data as $key => $file) {
      $form_data[$key]['FirstPublishLocationId'] = $case_id;
      $form_data[$key]['LGM_DocType__c'] = 'Documentos de radicación';
      $form_data[$key]['LGM_Process__c'] = 'PQR';
    }

    $data = [
      "allOrNone" => false,
      "records" => $form_data,
    ];

    $result = $this->httpClient->post(
      $config->get('salesforce_endpoint') . '/data/v58.0/composite/sobjects/',
      [
        'headers' => [
          'Content-Type' => 'application/json',
          'Authorization' => "Bearer $token",
        ],
        'body' => json_encode($data),
      ]
    )->getBody()->getContents();
  }

}
