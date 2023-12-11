<?php

namespace Drupal\liberty_claims\Form;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Yaml\Exception\ExceptionInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  const SAMPLES = [
    'common',
    'CLAIM_TYPE_PTH',
    'CLAIM_TYPE_PPH',
    'CLAIM_TYPE_PPD',
    'CLAIM_TYPE_PL',
    'CLAIM_TYPE_LR',
    'CLAIM_TYPE_AC',
  ];

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'liberty_claims.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('liberty_claims.settings');

    $form['endpoint_settings'] = [
      '#title' => $this->t('Endpoint Settings'),
      '#type'  => 'details',
      '#open' => TRUE,
    ];

    $form['endpoint_settings']['test'] = [
      '#title' => $this->t('Test settings'),
      '#type' => 'details',
      '#open' => TRUE,
      '#tree' => TRUE,
    ];

    $form['endpoint_settings']['test']['base_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Base URL (UAT Endpoint)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('test')['base_uri'],
    ];
    $form['endpoint_settings']['test']['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User name (CESVI Authorization)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('test')['username'],
    ];
    $form['endpoint_settings']['test']['password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Password (CESVI Authorization)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('test')['password'],
    ];
    $form['endpoint_settings']['test']['policy_base_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Policy Base URL'),
      '#maxlength' => 256,
      '#size' => 64,
      '#default_value' => $config->get('test')['policy_base_uri'],
    ];

    $form['endpoint_settings']['test']['validate_plate_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Validate Plate Token'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('test')['validate_plate_token'],
    ];

    $form['endpoint_settings']['test']['client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client secret (Mutual)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('test')['client_secret'],
    ];

    $form['endpoint_settings']['test']['token_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Token URL (Mutual)'),
      '#maxlength' => 256,
      '#size' => 64,
      '#default_value' => $config->get('test')['token_uri'],
    ];

    $form['endpoint_settings']['live'] = [
      '#title' => $this->t('Live settings'),
      '#type' => 'details',
      '#open' => TRUE,
      '#tree' => TRUE,
    ];

    $form['endpoint_settings']['live']['base_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Base URL (Live Endpoint)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('live')['base_uri'],
    ];
    $form['endpoint_settings']['live']['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User name (CESVI Authorization)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('live')['username'],
    ];
    $form['endpoint_settings']['live']['password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Password (CESVI Authorization)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('live')['password'],
    ];
    $form['endpoint_settings']['live']['policy_base_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Policy Base URL'),
      '#maxlength' => 256,
      '#size' => 64,
      '#default_value' => $config->get('live')['policy_base_uri'],
    ];

    $form['endpoint_settings']['live']['validate_plate_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Validate Plate Token'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('live')['validate_plate_token'],
    ];

    $form['endpoint_settings']['live']['client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client_secret (Mutual)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('test')['client_secret'],
    ];

    $form['endpoint_settings']['live']['token_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Token URL (Mutual)'),
      '#maxlength' => 256,
      '#size' => 64,
      '#default_value' => $config->get('live')['token_uri'],
    ];

    $form['endpoint_settings']['mode'] = [
      '#type'    => 'radios',
      '#title'   => $this->t('Mode'),
      '#options' => [
        'test' => $this->t('Test'),
        'live' => $this->t('Live'),
      ],
      '#default_value' => $config->get('mode'),
    ];

    $form['file_limits'] = [
      '#title' => $this->t('Files limit'),
      '#type' => 'fieldset',
    ];

    $form['file_limits']['image_size'] = [
      '#title' => $this->t('Image size'),
      '#type' => 'textfield',
      '#size' => 4,
      '#suffix' => 'MB',
      '#default_value' => $config->get('image_size'),
    ];
    $form['file_limits']['document_size'] = [
      '#title' => $this->t('Document size'),
      '#type' => 'textfield',
      '#size' => 4,
      '#suffix' => 'MB',
      '#default_value' => $config->get('document_size'),
    ];

    $form['claims_type'] = [
      '#title' => $this->t('Claims type'),
      '#type' => 'fieldset',
    ];

    $form['claims_type']['ramo_104'] = [
      '#type'    => 'checkboxes',
      '#title'   => $this->t('Types available for 104'),
      '#default_value' => $config->get('ramo_104'),
    ];

    $form['claims_type']['ramo_105'] = [
      '#type'    => 'checkboxes',
      '#title'   => $this->t('Types available for 105'),
      '#default_value' => $config->get('ramo_105'),
    ];

    foreach ($this::SAMPLES as $item) {
      if ($item !== 'common') {
        $form['claims_type']['ramo_104']['#options'][$item] = $item;
        $form['claims_type']['ramo_105']['#options'][$item] = $item;
      }
    }

    $form['guarantees'] = [
      '#title' => $this->t('Guarantee codes'),
      '#type' => 'fieldset',
    ];

    $form['guarantees']['last_model'] = [
      '#title' => $this->t("Last model"),
      '#type' => 'number',
      '#default_value' => $config->get('last_model'),
      '#min' => 2000,
      '#max' => date('Y') + 2,
    ];

    $form['guarantees']['brokers'] = [
      '#title' => $this->t("Brokers"),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('brokers'),
    ];

    $form['guarantees']['insured_codes'] = [
      '#title' => $this->t("Insured's Guarantee code"),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('insured_codes'),
    ];

    $help = $this->t('Tokens available @tokens', [
      '@tokens' => $this->getTokens(),
    ]);

    $form['SIPO'] = [
      '#type' => 'details',
      '#title'  => $this->t('Service SIPO settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    $form['SIPO']['tabs'] = [
      '#type' => 'vertical_tabs',
      '#title' => $this->t('Claim Types samples.'),
      '#description' => $help,
    ];

    $form['SIPO']['request_tab'] = [
      '#type'  => 'details',
      '#title' => $this->t("SIPO Request."),
      '#group' => 'tabs',
    ];

    $form['SIPO']['request_tab']['sipo_sample'] = [
      '#title' => $this->t("SIPO Sample code."),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('sipo_sample'),
      '#description' => $help,
    ];

    $form['SIPO']['request_tp_tab'] = [
      '#type'  => 'details',
      '#title' => $this->t("SIPO Request Affected."),
      '#group' => 'tabs',
    ];

    $form['SIPO']['request_tp_tab']['sipo_third_party'] = [
      '#title' => $this->t("SIPO Request Affected."),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('sipo_third_party'),
      '#description' => $help,
    ];

    $form['SIPO']['protection_tab'] = [
      '#type'  => 'details',
      '#title' => $this->t("Protection texts"),
      '#group' => 'tabs',
    ];

    $form['SIPO']['protection_tab']['sipo_protection'] = [
      '#title' => $this->t("SIPO Protection texts."),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('sipo_protection'),
    ];

    $form['SIPO']['third_party_tab'] = [
      '#type'  => 'details',
      '#title' => $this->t("SIPO Affected settings"),
      '#group' => 'tabs',
    ];

    $form['SIPO']['third_party_tab']['third_party_cities_carshops'] = [
      '#title' => $this->t("SIPO Third party cities for carshops."),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('third_party_cities_carshops'),
    ];

    $form['SIPO']['ramo_tab'] = [
      '#type'  => 'details',
      '#title' => $this->t("Ramos SIPO"),
      '#group' => 'tabs',
    ];

    $form['SIPO']['ramo_tab']['sipo_ramos'] = [
      '#title' => $this->t("Ramos SIPO."),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('sipo_ramos'),
    ];

    $form['IAXIS'] = [
      '#type' => 'details',
      '#title'  => $this->t('Service IAXIS settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    $form['IAXIS']['samples'] = [
      '#type' => 'vertical_tabs',
      '#title' => $this->t('Claim Types samples.'),
      '#description' => $help,
    ];

    $data = $config->get('samples');

    foreach ($this::SAMPLES as $item) {

      $form['IAXIS'][$item] = [
        '#type'  => 'details',
        '#title' => $item,
        '#group' => 'samples',
        '#tree'  => TRUE,
      ];

      $form['IAXIS'][$item]['data'] = [
        '#type' => 'textarea',
        '#cols' => 3,
        '#rows' => 30,
        '#attributes' => ['data-yaml-editor' => 'true'],
        '#default_value' => $data[$item]['data'],
      ];
    }

    $form['IAXIS']['policy_request'] = [
      '#title'  => $this->t('Policy Request'),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('policy_request'),
    ];

    $form['IAXIS']['policy_ramos'] = [
      '#title'  => $this->t('Policy Ramos'),
      '#type' => 'textarea',
      '#cols' => 3,
      '#rows' => 30,
      '#attributes' => ['data-yaml-editor' => 'true'],
      '#default_value' => $config->get('policy_ramos'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    try {
      foreach ($this::SAMPLES as $item) {
        Yaml::decode($form_state->getValue($item)['data']);
      }

      Yaml::decode($form_state->getValue('sipo_sample'));
      Yaml::decode($form_state->getValue('insured_codes'));
      Yaml::decode($form_state->getValue('policy_ramos'));
      Yaml::decode($form_state->getValue('policy_request'));
    }
    catch (ExceptionInterface $e) {
      $form_state->setErrorByName('commonds', $this->t('This is not a correct YML format.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $samples = [];

    foreach ($this::SAMPLES as $item) {
      $samples[$item] = $form_state->getValue($item);
    }

    $this->config('liberty_claims.settings')
      ->set('test', $form_state->getValue('test'))
      ->set('live', $form_state->getValue('live'))
      ->set('mode', $form_state->getValue('mode'))
      ->set('document_size', $form_state->getValue('document_size'))
      ->set('image_size', $form_state->getValue('image_size'))
      ->set('policy_request', $form_state->getValue('policy_request'))
      ->set('policy_ramos', $form_state->getValue('policy_ramos'))
      ->set('insured_codes', $form_state->getValue('insured_codes'))
      ->set('last_model', $form_state->getValue('last_model'))
      ->set('brokers', $form_state->getValue('brokers'))
      ->set('sipo_sample', $form_state->getValue('sipo_sample'))
      ->set('sipo_third_party', $form_state->getValue('sipo_third_party'))
      ->set('sipo_protection', $form_state->getValue('sipo_protection'))
      ->set('sipo_ramos', $form_state->getValue('sipo_ramos'))
      ->set('ramo_104', $form_state->getValue('ramo_104'))
      ->set('ramo_105', $form_state->getValue('ramo_105'))
      ->set('third_party_cities_carshops', $form_state->getValue('third_party_cities_carshops'))
      ->set('samples', $samples)
      ->save();
  }

  /**
   * Method to get the tokens availables.
   *
   * @return string
   *   List of tokens.
   */
  protected function getTokens() {
    return '_#@plate
    _#@date
    _#@ip
    _#@_lastname
    _#@_fistname
    _#@_secondlastname
    _#@_secondname
    _#@_claimdate
    _#@_currentday
    _#@_time
    _#@_city
    _#@_provcode
    _#@_wherename
    _#@_withInjureddesc
    _#@_withInjuredval
    _#@_withDeathsdesc
    _#@_withDeathsval
    _#@_withPolicedesc
    _#@_withPoliceval
    _#@_damages
    _#@codTaller
    _#@email
    _#@direccion
    _#@sucursal
    _#@city
    _#@description
    _#@driverName
    _#@driverPhone
    _#@driverDocType
    _#@driverDocumentId
    _#@declarantName
    _#@declarantPhone
    _#@whereAddress
    _#@isDriver
    _#@isDeclarant
    _#@withDeaths
    _#@withInjured
    _#@withPolice
    _#@casualties
    _#@deaths
    _#@damages
    _#@lastname
    _#@phone
    _#@documentId
    _#@address
    _#@docType
    _#@vehicleType
    _#@model
    _#@brand
    _#@plate
    _#@date
    _#@tellus
    _#@policy';
  }

}
