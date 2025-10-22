<?php

namespace Drupal\hdi_pqr_salesforce\traits;

/**
 * Handle submit data into webform.
 */
trait PqrWebform {

  /**
   * Base uri to portal.
   *
   * @var string
   */
  private $baseUri = 'http://127.0.0.1';

  /**
   * Submit form data into webform.
   *
   * @param array $form_data
   *   Form data from react app.
   */
  public function submitWebform(array $form_data, array $sfResponse) {
    $form_values = [];
    unset($form_data['files']);

    foreach ($form_data as $field => $value) {
      if ($field === 'SSP_LGBTIQ__c'
        || $field === 'SSP_AutorizacionTratamientoDatoSensibles__c'
        || $field === 'SSP_TieneAlgunaCondicionEspecial__c'
      ) {
        $value = $value === FALSE ? 'No' : 'Si';
      }

      $form_values[strtolower($field)] = $value;
    }

    // Add additional data to submit into webform.
    $form_values['webform_id'] = 'pqr_salesforce';
    $form_values['entity_type'] = NULL;
    $form_values['entity_id'] = NULL;
    $form_values['in_draft'] = FALSE;
    $form_values['salesforce_numero_caso'] = $sfResponse['caseNumber'] ?? 0;

    $body = [
      'headers' => [
        'Content-Type' => "application/json",
        'X-CSRF-Token' => $this->getCsrfToken(),
      ],
      'body' => (json_encode($form_values)),
      'verify' => FALSE,
    ];

    $this->httpClient->post(
      $this->baseUri . '/webform_rest/submit?_format=json',
      $body,
    );
  }

  /**
   * Get CSRF token to authenticate request.
   *
   * @return string
   *   CSRF token.
   */
  private function getCsrfToken(): string {
    return $this->httpClient->get($this->baseUri . '/session/token', [
      'headers' => ['Content-Type' => "application/json"],
      'verify' => FALSE,
    ])->getBody()->getContents();
  }

}
