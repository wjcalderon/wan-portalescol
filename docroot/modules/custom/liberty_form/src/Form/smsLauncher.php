<?php
<<<<<<< HEAD
/**
 * @file
 * Contains Drupal\liberty_form\Form\smsLauncher.
 */
namespace Drupal\liberty_form\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class smsLauncher extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'smsLauncher';
    }
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        //Busqueda en la base de datos de campañas para impresión en el select

        $form['country'] = [
            '#title' => $this->t('País'),
            '#type' => 'select',
            '#options' => [
                '+57' => 'Colombia',
                '+56' => 'Chile',
                '+593' => 'Ecuador',
            ],
            '#empty_option' => $this->t('- Selecciona el país -'),
            '#ajax' => [
                'callback' => '::updateRamos',
                'wrapper' => 'ramos-wrapper',
            ],
            '#required' => true,
        ];

        $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => 'sponsors']);
        foreach ($query as $spons => $item) {
            $sid = $item->tid->value;
            $data = $item->name->value;
            $sponsors[$sid] = $data;
        }

        $form['sponsors'] = [
            '#title' => $this->t('Sponsors'),
            '#type' => 'select',
            '#options' => $sponsors,
            '#empty_option' => $this->t('- Selecciona sponsor -'),
            '#ajax' => [
                'callback' => '::updateRamos',
                'wrapper' => 'ramos-wrapper',
            ],
            '#required' => true,
        ];

        $form['ramos_wrapper'] = [
            '#type' => 'container',
            '#attributes' => ['id' => 'ramos-wrapper'],
        ];

        $sponsor_id = $form_state->getValue('sponsors');
        if (!empty($sponsor_id)) {
            $form['ramos_wrapper']['ramos'] = [
                '#type' => 'select',
                '#title' => $this->t('Ramos'),
                '#options' => $this->getBranches($sponsor_id),
                '#empty_option' => $this->t('- Selecciona ramo -'),
                '#required' => true,
                '#ajax' => [
                    'callback' => '::updateCampaigns',
                    'wrapper' => 'campaings-wrapper',
                ],
            ];
        }

        $form['campaings_wrapper'] = [
            '#type' => 'container',
            '#attributes' => ['id' => 'campaings-wrapper'],
        ];
        $branch_id = $form_state->getValue('ramos');
        if (!empty($sponsor_id) && !empty($branch_id)) {
            $form['campaings_wrapper']['campaing'] = [
                '#type' => 'select',
                '#title' => $this->t('Campaña'),
                '#options' => $this->getCampaigns($sponsor_id, $branch_id),
                '#empty_option' => $this->t('- Selecciona campaña -'),
                '#required' => true,
            ];
        }

        /*$campaing = $form_state->getValue('campaing');
        if (!empty($sponsor_id) && !empty($branch_id)) {
        $form['campaingsURL_wrapper']['campaingURL'] = [
        '#type' => 'textfield',
        '#title' => $this->t('url de campaña'),
        '#value' => $this->getCampaignURL($campaing),
        '#required' => TRUE,
        '#ajax' => [
        'callback' => '::updateCampaigns',
        'wrapper' => 'campaings-wrapper',
        ],
        ];
         */
        $form['cuerpo_del_mensaje'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Cuerpo del mensaje'),
            '#description' => $this->t('Ingrese el cuerpo de su mensaje max 160 caracteres.'),
            '#maxlength' => 160,
            '#required' => true,
        ];

        $form['aviso'] = [
            '#type' => 'markup',
            '#markup' => "<h5>Este proceso puede tomar mucho tiempo, por favor no cierre esta página ni abandone el proceso ...</h5>",
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Enviar mensaje',
        ];
        return $form;
    }

    /**
     * Ajax callback for the ramos dropdown.
     */
    public function updateRamos(array $form, FormStateInterface $form_state)
    {
        return $form['ramos_wrapper'];
    }

    /**
     * Ajax callback for the campaigns dropdown.
     */
    public function updateCampaigns(array $form, FormStateInterface $form_state)
    {
        return $form['campaings_wrapper'];
    }

    public function getBranches($id_sponsor)
    {

        $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'campaign', 'field_sponsor' => $id_sponsor]);
        foreach ($query as $campaings => $campaign) {
            $tid = $campaign->field_campaing_tax;
            $bid = $tid[0]->target_id;
            $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['tid' => $bid]);
            foreach ($query as $taxonomy => $i) {
                $data = $i->name->value;
            }
            $branch[$bid] = $data;
        }

        return $branch;
    }

    public function getCampaigns($id_sponsor, $id_ramo)
    {

        $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'campaign', 'field_sponsor' => $id_sponsor, 'field_campaing_tax' => $id_ramo, 'field_private' => '1']);
        foreach ($query as $campaings => $campaign) {
            $nid = $campaign->nid->value;
            $data = $campaign->title->value;
            $camp[$nid] = $data;
        }

        return $camp;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = \Drupal::config('liberty_form.msn_api');
        $country = $form_state->getValue('country');
        $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'customer', 'field_campaign_id' => $form_state->getValue('campaing'),'field_status'=> 1]);
        $url_api = $config->get('url_fetch');
        $url_token = $config->get('url_token');
        $client_id = $config->get('client_id');
        $provider = $config->get('provider');
        $sender_id = $config->get('sender_id');
        $sms_type = $config->get('sms_type');
        $client_secret_key = $config->get('client_secret_key');
        $message = $form_state->getValue('cuerpo_del_mensaje');
        $content = "grant_type=client_credentials";
        $authorization = base64_encode("$client_id:$client_secret_key");
        $header = array("Authorization: Basic {$authorization}", "Content-Type: application/x-www-form-urlencoded");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_token,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $content,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $access_token = json_decode($response)->access_token;
        foreach ($query as $customer) {
            $header = array("Authorization: Bearer {$access_token}", "Content-Type: application/json");
            $data = [
                "infoRequest" => [
                    "mobileNumber" => $customer->field_phone->value,
                    "smsText" => $message,
                    "country" => $country,
                    "provider" => $provider,
                    "smsType" => $sms_type,
                    "senderId" => $sender_id,
                ],
            ];
            $json_data = json_encode($data);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url_api,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $json_data,
            ));
            $res = curl_exec($curl);
            $err = curl_error($curl);
            $launcher = curl_close($curl);
        }
        Drupal::messenger()->addMessage('Se han enviado exitosamente los mensajes a los clientes');
    }
=======

namespace Drupal\liberty_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class sms launcher.
 */
class SmsLauncher extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'smsLauncher';
  }

  /**
   * Build form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Busqueda en la base de datos de campañas para impresión en el select.
    $form['country'] = [
      '#title' => $this->t('País'),
      '#type' => 'select',
      '#options' => [
        '+57' => $this->t('Colombia'),
        '+56' => $this->t('Chile'),
        '+593' => $this->t('Ecuador'),
      ],
      '#empty_option' => $this->t('- Selecciona el país -'),
      '#ajax' => [
        'callback' => '::updateRamos',
        'wrapper' => 'ramos-wrapper',
      ],
      '#required' => TRUE,
    ];

    $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(
      [
        'vid' => 'sponsors',
      ]
    );
    foreach ($query as $item) {
      $sid = $item->tid->value;
      $data = $item->name->value;
      $sponsors[$sid] = $data;
    }

    $form['sponsors'] = [
      '#title' => $this->t('Sponsors'),
      '#type' => 'select',
      '#options' => $sponsors,
      '#empty_option' => $this->t('- Selecciona sponsor -'),
      '#ajax' => [
        'callback' => '::updateRamos',
        'wrapper' => 'ramos-wrapper',
      ],
      '#required' => TRUE,
    ];

    $form['ramos_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'ramos-wrapper'],
    ];

    $sponsor_id = $form_state->getValue('sponsors');
    if (!empty($sponsor_id)) {
      $form['ramos_wrapper']['ramos'] = [
        '#type' => 'select',
        '#title' => $this->t('Ramos'),
        '#options' => $this->getBranches($sponsor_id),
        '#empty_option' => $this->t('- Selecciona ramo -'),
        '#required' => TRUE,
        '#ajax' => [
          'callback' => '::updateCampaigns',
          'wrapper' => 'campaings-wrapper',
        ],
      ];
    }

    $form['campaings_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'campaings-wrapper'],
    ];
    $branch_id = $form_state->getValue('ramos');
    if (!empty($sponsor_id) && !empty($branch_id)) {
      $form['campaings_wrapper']['campaing'] = [
        '#type' => 'select',
        '#title' => $this->t('Campaña'),
        '#options' => $this->getCampaigns($sponsor_id, $branch_id),
        '#empty_option' => $this->t('- Selecciona campaña -'),
        '#required' => TRUE,
      ];
    }

    /*$campaing = $form_state->getValue('campaing');
    if (!empty($sponsor_id) && !empty($branch_id)) {
    $form['campaingsURL_wrapper']['campaingURL'] = [
    '#type' => 'textfield',
    '#title' => $this->t('url de campaña'),
    '#value' => $this->getCampaignURL($campaing),
    '#required' => TRUE,
    '#ajax' => [
    'callback' => '::updateCampaigns',
    'wrapper' => 'campaings-wrapper',
    ],
    ];
     */
    $form['cuerpo_del_mensaje'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Cuerpo del mensaje'),
      '#description' => $this->t('Ingrese el cuerpo de su mensaje max 160 caracteres.'),
      '#maxlength' => 160,
      '#required' => TRUE,
    ];

    $form['aviso'] = [
      '#type' => 'markup',
      '#markup' => "<h5>Este proceso puede tomar mucho tiempo, por favor no cierre esta página ni abandone el proceso ...</h5>",
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Enviar mensaje',
    ];
    return $form;
  }

  /**
   * Ajax callback for the ramos dropdown.
   */
  public function updateRamos(array $form, FormStateInterface $form_state) {
    return $form['ramos_wrapper'];
  }

  /**
   * Ajax callback for the campaigns dropdown.
   */
  public function updateCampaigns(array $form, FormStateInterface $form_state) {
    return $form['campaings_wrapper'];
  }

  /**
   * Get branchs.
   */
  public function getBranches($id_sponsor) {

    $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(
      [
        'type' => 'campaign',
        'field_sponsor' => $id_sponsor,
      ]
      );
    foreach ($query as $campaign) {
      $tid = $campaign->field_campaing_tax;
      $bid = $tid[0]->target_id;
      $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(
        [
          'tid' => $bid,
        ]
      );
      foreach ($query as $i) {
        $data = $i->name->value;
      }
      $branch[$bid] = $data;
    }

    return $branch;
  }

  /**
   * Get campaings custom.
   */
  public function getCampaigns($id_sponsor, $id_ramo) {

    $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(
      [
        'type' => 'campaign',
        'field_sponsor' => $id_sponsor,
        'field_campaing_tax' => $id_ramo,
        'field_private' => '1',
      ]
        );
    foreach ($query as $campaign) {
      $nid = $campaign->nid->value;
      $data = $campaign->title->value;
      $camp[$nid] = $data;
    }

    return $camp;
  }

  /**
   * Submit custom form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::config('liberty_form.msn_api');
    $country = $form_state->getValue('country');
    $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(
      [
        'type' => 'customer',
        'field_campaign_id' => $form_state->getValue('campaing'),
        'field_status' => 1,
      ]
    );
    $url_api = $config->get('url_fetch');
    $url_token = $config->get('url_token');
    $client_id = $config->get('client_id');
    $provider = $config->get('provider');
    $sender_id = $config->get('sender_id');
    $sms_type = $config->get('sms_type');
    $client_secret_key = $config->get('client_secret_key');
    $message = $form_state->getValue('cuerpo_del_mensaje');
    $content = "grant_type=client_credentials";
    $authorization = base64_encode("$client_id:$client_secret_key");
    $header = [
      "Authorization: Basic {$authorization}",
      "Content-Type: application/x-www-form-urlencoded",
    ];
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => $url_token,
      CURLOPT_HTTPHEADER => $header,
      CURLOPT_SSL_VERIFYPEER => FALSE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_POST => TRUE,
      CURLOPT_POSTFIELDS => $content,
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    $access_token = json_decode($response)->access_token;
    foreach ($query as $customer) {
      $header = [
        "Authorization: Bearer {$access_token}",
        "Content-Type: application/json",
      ];
      $data = [
        "infoRequest" => [
          "mobileNumber" => $customer->field_phone->value,
          "smsText" => $message,
          "country" => $country,
          "provider" => $provider,
          "smsType" => $sms_type,
          "senderId" => $sender_id,
        ],
      ];
      $json_data = json_encode($data);
      $curl = curl_init();
      curl_setopt_array($curl, [
        CURLOPT_URL => $url_api,
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $json_data,
      ]);
      curl_exec($curl);
      curl_error($curl);
      curl_close($curl);
    }
    \Drupal::messenger()->addMessage('Se han enviado exitosamente los mensajes a los clientes');
  }
>>>>>>> main

}
