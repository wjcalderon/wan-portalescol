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

    dump($token);

    $response = json_decode($this->submitData($form_data, $token), TRUE);

    $this->uploadFiles($form_data, $response['caseId']);

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
   *   Form data from react app.
   * @param string $case_id
   *   Case ID from Salesforce API.
   */
  private function uploadFiles(array $form_data, string $case_id) {

  }

}
