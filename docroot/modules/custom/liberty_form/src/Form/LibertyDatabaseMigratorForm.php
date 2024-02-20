<?php
<<<<<<< HEAD
/**
 * @file
 * Contains Drupal\liberty_form\Form\LibertyDatabaseMigratorForm.
 */
namespace Drupal\liberty_form\Form;

use Drupal;
=======

namespace Drupal\liberty_form\Form;

>>>>>>> main
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

<<<<<<< HEAD
class LibertyDatabaseMigratorForm extends ConfirmFormBase
{
    public $campaingID;
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'LibertyDatabaseMigratorForm';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'Liberty_form.admin_settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCancelUrl()
    {
        $url = Url::fromUri('internal:/admin/content/campaings');
        return $url;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestion()
    {
        return $this->t('¿Desea importar la base de datos?');
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        //Busqueda en la base de datos de campañas para impresión en el select
        $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => 'sponsors']);
        foreach ($query as $spons => $item) {
            $sid = $item->tid->value;
            $data = $item->name->value;
            $sponsors[$sid] = $data;
        }


        $form = [
            '#attributes' => ['enctype' => 'multipart/form-data'],
        ];
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

        $sponsor_id = null;
        $branch_id = null;

        $sponsor_id = $form_state->getValue('sponsors');
        // if (!empty($sponsor_id)) {
        $form['ramos_wrapper']['ramos'] = [
            '#type' => 'select',
            '#title' => $this->t('Ramos'),
            '#options' => $this->getBranches($sponsor_id),
            '#empty_option' => $this->t('- Selecciona ramo -'),
            '#required' => true,
            '#validated' => true,
            '#ajax' => [
                'callback' => '::updateCampaigns',
                'wrapper' => 'campaings-wrapper',
            ],
            '#states' => [
                'visible' => array(
                    ':input[name="sponsors"]' => array('filled' => true),
                ),
            ],
        ];
        // }

        $form['campaings_wrapper'] = [
            '#type' => 'container',
            '#attributes' => ['id' => 'campaings-wrapper'],
        ];

        $branch_id = $form_state->getValue('ramos');
        // if (!empty($sponsor_id) && !empty($branch_id)) {
        $form['campaings_wrapper']['campaing'] = [
            '#type' => 'select',
            '#title' => $this->t('Campaña'),
            '#options' => $this->getCampaigns($sponsor_id, $branch_id),
            '#empty_option' => $this->t('- Selecciona campaña -'),
            '#required' => true,
            '#validated' => true,
            '#states' => [
                'visible' => array(
                    ':input[name="ramos"]' => array('filled' => true),
                ),
            ],
        ];
        // }

        $form['csv'] = [
            '#type' => 'managed_file',
            '#title' => $this->t('Base de datos'),
            '#name' => 'csv_file',
            '#upload_location' => 'public://content/csv_files/',
            '#description' => $this->t('Cargue una base de datos con formato CSV'),
            '#upload_validators' => [
                'file_validate_extensions' => ['csv'],
            ],
            '#required' => true,
        ];

        $form['warninng'] = [
            '#type' => "markup",
            '#markup' => '<div class="font_major"> Recuerda que esta base reemplazará la actual!</div>',
        ];
        // kint($form_state);
        return parent::buildForm($form, $form_state);
    }

    /**
     * Ajax callback for the ramos dropdown.
     */
    public function updateRamos(array $form, FormStateInterface $form_state)
    {
        return $form['ramos_wrapper'];
    }

    public function updateCampaignID(array $form, FormStateInterface $form_state)
    {
        $this->campaingID = $form_state->getValue('campaing');
        return $this->campaingID;
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
        $branch = [];
        if ($id_sponsor != null) {
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
        }

        return $branch;
    }

    public function getCampaigns($id_sponsor, $id_ramo)
    {
        $camp = [];
        if ($id_sponsor > 0 && $id_ramo > 0) {
            $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'campaign', 'field_sponsor' => $id_sponsor, 'field_campaing_tax' => $id_ramo, 'field_private' => '1']);
            foreach ($query as $campaings => $campaign) {
                $nid = $campaign->nid->value;
                $data = $campaign->title->value;
                $camp[$nid] = $data;
            }
        }

        return $camp;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // parent::submitForm($form, $form_state);/

        $fid = $form_state->getValue('csv');
        $bid = $form_state->getValue('ramos');
        $cid = $form_state->getValue('campaing');

        $query_initial = Drupal::entityTypeManager()->getStorage('node')->getQuery();

        $res_initial = $query_initial->condition('type', 'customer')
            ->condition('field_campaign_id', $cid)
            ->execute();

        if ($res_initial) {
            $nids = $res_initial;
            foreach ($nids as $key => $nid) {
                $node = Node::load($nid);
                $status = $node->get('field_status')->getValue();
                if (count($status) == 0) {
                    $node = Node::load($nid);
                    $node->field_status->value = 0;
                    $node->save();
                } elseif ($status[0]['value'] == "1") {
                    $node = Node::load($nid);
                    $node->field_status->value = 0;
                    $node->save();
                }

            }

        }

        //$query = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
        $destination = \Drupal\file\Entity\File::load($fid[0]);
        $num = 0;
        $uriFile = $destination->getFileUri();
        $file = fopen($uriFile, 'r');
        $delimiter = ';';
        $errors = 0;
        $empty_fields = 0;
        $id_failed = [];
        $file_name = 'failed' . date('d-m-Y-h:ia') . '.csv';
        $uri = 'public://content/csv_files/' . $file_name;
        $file_handle = fopen($uri, 'w');
        $delimiter = ';';
        $enclosure = '"';
        $error_data = 1;
        while (($customers = fgetcsv($file, 1000, $delimiter)) !== false) {
            $field_errors = 0;
            if ($num >= 1) {
                $country = $customers[0];
                $sponsor = $form_state->getValue('sponsors');
                $business_key = $customers[2];
                $campaign = $customers[4];
                $doc_type = $customers[5];
                $doc_number = $customers[6];
                $name = $customers[7];
                $lastname = $customers[8];
                $email = $customers[9];
                $phone = $customers[10];
                $city = $customers[11];
                $birthday = $customers[12];
                $gender = $customers[13];
                $id_failed['país'] = 'país';
                $id_failed['clave de negocio'] = 'Clave de negocio';
                $id_failed['sponsor'] = 'sponsor';
                $id_failed['campaña'] = 'campaña';
                $id_failed['ramo'] = 'ramo';
                $id_failed['tipo de documento'] = 'tipo de documento';
                $id_failed['numero de documento'] = 'numero de documento';
                $id_failed['nombre'] = 'nombre';
                $id_failed['apellido'] = 'apellido';
                $id_failed['email'] = 'correo';
                $id_failed['telefono'] = 'teléfono';
                $id_failed['error'] = 'ERROR';
                $error_log[0] = $id_failed;

                $query2 = Drupal::entityTypeManager()->getStorage('node')->getQuery();
                $res = $query2->condition('type', 'customer')
                    ->condition('field_id_number', $doc_number)
                    ->condition('field_document_type', $doc_type)
                    ->condition('field_campaign_id', $cid)
                    ->condition('field_status', 1)
                    ->execute();
                if ($res == []) {
                    if (empty($country) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe el País';
                        $field_errors++;
                    }
                    if (empty($sponsor) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe el Sponsor';
                        $field_errors++;
                    }
                    if (empty($business_key) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe la clave de negocio';
                        $field_errors++;
                    }
                    //if(empty($branch)&& $field_errors == 0){
                    //   $field_errors ++;
                    //}
                    if (empty($campaign) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe la campaña';
                        $field_errors++;
                    }
                    if (empty($doc_number) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe el número de documento';
                        $field_errors++;
                    }
                    if (empty($name) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe el nombre';
                        $field_errors++;
                    }
                    if (empty($lastname) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe el apellido';
                        $field_errors++;
                    }
                    if (empty($email) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe el correo';
                        $field_errors++;
                    }
                    if (empty($phone) && $field_errors == 0) {
                        $id_failed['error'] = 'no existe el teléfono';
                        $field_errors++;
                    }
                    if (!is_numeric($phone) && $field_errors == 0) {
                        $id_failed['error'] = 'El teléfono debe ser sólo numérico';
                        $field_errors++;
                    }

                    if ($field_errors == 0) {
                        $node = Node::create([
                            'type' => 'customer',
                            'title' => $name . $lastname,
                            'field_country' => $country,
                            'field_sponsor_name' => $sponsor,
                            'field_bussiness_key' => $business_key,
                            'field_branch' => $bid,
                            'field_campaign' => $campaign,
                            'field_id_number' => $doc_number,
                            'field_document_type' => $doc_type,
                            'field_customer_name' => $name,
                            'field_lastname' => $lastname,
                            'field_email' => $email,
                            'field_phone' => $phone,
                            'field_city' => $city,
                            'field_birth_day' => $birthday,
                            'field_gender' => $gender,
                            'field_campaign_id' => $cid,
                            'field_send_mails' => false,
                            'field_status' => true,
                        ]);
                        $saver[] = $node->save();
                    }
                    if ($field_errors >= 1) {
                        $empty_fields++;
                        $id_failed['país'] = $country;
                        $id_failed['clave de negocio'] = $doc_type;
                        $id_failed['sponsor'] = $sponsor;
                        $id_failed['campaña'] = $campaign;
                        $id_failed['ramo'] = $customers[3];
                        $id_failed['tipo de documento'] = $doc_type;
                        $id_failed['numero de documento'] = $doc_number;
                        $id_failed['nombre'] = $name;
                        $id_failed['apellido'] = $lastname;
                        $id_failed['email'] = $email;
                        $id_failed['telefono'] = $phone;
                        $error_log[$num] = $id_failed;
                    }
                } else {
                    $errors++;
                }

            }
            $num++;
        }
        foreach ($error_log as $log) {
            fputcsv($file_handle, $log, $delimiter, $enclosure);
        }
        fclose($file_handle);

        // $file_path = \Drupal::service('file_system')->realpath($uri);
        $file = File::create([
            'filename' => $file_name,
            'uri' => $uri,
        ]);
        $file->save();
        $file_path = \Drupal::service('file_system')->realpath($uri);

        if ($errors >= 1) {
            $error_data = ($error_data + $errors);
            Drupal::messenger()->addError($errors . ' Clientes ya existían previamente, así que no han sido ingresados nuevamente.');
        }
        if ($empty_fields >= 1) {
            $error_data = ($error_data + $empty_fields);
            Drupal::messenger()->addError($empty_fields . ' Clientes no han sido creados debido a que les hace falta información requerida por la base de datos.');
            $host = \Drupal::request()->getSchemeAndHttpHost();
            $link = $host . '/sites/default' . $file_path;
            //$response = Url::fromRoute('/sites/default'.$file_path);
            Drupal::messenger()->addWarning(t('Para descargar el registro de errores por favor dar click : <a  href="/sites/sponsors/files/content/csv_files/' . $file_name . '">aquí</a>'));
            //$form_state->setRedirect($link);
        }
        Drupal::messenger()->addMessage('Se han ingresado exitosamente ' . ($num - $error_data) . ' Clientes');

        

    }

=======
/**
 * Class custom liberty database migrator .
 */
class LibertyDatabaseMigratorForm extends ConfirmFormBase {

  /**
   * Id campaing.
   *
   * @var int
   */
  public $campaingID;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'LibertyDatabaseMigratorForm';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'Liberty_form.admin_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    $url = Url::fromUri('internal:/admin/content/campaings');
    return $url;
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('¿Desea importar la base de datos?');
  }

  /**
   * Custom build form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Busqueda en la base de datos de campañas para impresión en el select.
    $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => 'sponsors']);
    foreach ($query as $item) {
      $sid = $item->tid->value;
      $data = $item->name->value;
      $sponsors[$sid] = $data;
    }

    $form = [
      '#attributes' => ['enctype' => 'multipart/form-data'],
    ];
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

    $sponsor_id = NULL;
    $branch_id = NULL;

    $sponsor_id = $form_state->getValue('sponsors');
    // If (!empty($sponsor_id)) {.
    $form['ramos_wrapper']['ramos'] = [
      '#type' => 'select',
      '#title' => $this->t('Ramos'),
      '#options' => $this->getBranches($sponsor_id),
      '#empty_option' => $this->t('- Selecciona ramo -'),
      '#required' => TRUE,
      '#validated' => TRUE,
      '#ajax' => [
        'callback' => '::updateCampaigns',
        'wrapper' => 'campaings-wrapper',
      ],
      '#states' => [
        'visible' => [
          ':input[name="sponsors"]' => ['filled' => TRUE],
        ],
      ],
    ];
    // }
    $form['campaings_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'campaings-wrapper'],
    ];

    $branch_id = $form_state->getValue('ramos');
    // If (!empty($sponsor_id) && !empty($branch_id)) {.
    $form['campaings_wrapper']['campaing'] = [
      '#type' => 'select',
      '#title' => $this->t('Campaña'),
      '#options' => $this->getCampaigns($sponsor_id, $branch_id),
      '#empty_option' => $this->t('- Selecciona campaña -'),
      '#required' => TRUE,
      '#validated' => TRUE,
      '#states' => [
        'visible' => [
          ':input[name="ramos"]' => ['filled' => TRUE],
        ],
      ],
    ];
    // }
    $form['csv'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Base de datos'),
      '#name' => 'csv_file',
      '#upload_location' => 'public://content/csv_files/',
      '#description' => $this->t('Cargue una base de datos con formato CSV'),
      '#upload_validators' => [
        'file_validate_extensions' => ['csv'],
      ],
      '#required' => TRUE,
    ];

    $form['warninng'] = [
      '#type' => "markup",
      '#markup' => '<div class="font_major"> Recuerda que esta base reemplazará la actual!</div>',
    ];
    // kint($form_state);
    return parent::buildForm($form, $form_state);
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
    $branch = [];
    if ($id_sponsor != NULL) {
      $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(
        [
          'type' => 'campaign',
          'field_sponsor' => $id_sponsor,
        ]
      );
      foreach ($query as $campaign) {
        $tid = $campaign->field_campaing_tax;
        $bid = $tid[0]->target_id;
        $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['tid' => $bid]);
        foreach ($query as $i) {
          $data = $i->name->value;
        }
        $branch[$bid] = $data;
      }
    }

    return $branch;
  }

  /**
   * Get campaigns.
   */
  public function getCampaigns($id_sponsor, $id_ramo) {
    $camp = [];
    if ($id_sponsor > 0 && $id_ramo > 0) {
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
    }

    return $camp;
  }

  /**
   * Submit form custom.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // parent::submitForm($form, $form_state);/.
    $fid = $form_state->getValue('csv');
    $bid = $form_state->getValue('ramos');
    $cid = $form_state->getValue('campaing');

    $query_initial = \Drupal::entityTypeManager()->getStorage('node')->getQuery();

    $res_initial = $query_initial->condition('type', 'customer')
      ->condition('field_campaign_id', $cid)
      ->execute();

    if ($res_initial) {
      $nids = $res_initial;
      foreach ($nids as $nid) {
        $node = Node::load($nid);
        $status = $node->get('field_status')->getValue();
        if (count($status) == 0) {
          $node = Node::load($nid);
          $node->field_status->value = 0;
          $node->save();
        }
        elseif ($status[0]['value'] == "1") {
          $node = Node::load($nid);
          $node->field_status->value = 0;
          $node->save();
        }

      }

    }

    // $query = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    $destination = File::load($fid[0]);
    $num = 0;
    $uriFile = $destination->getFileUri();
    $file = fopen($uriFile, 'r');
    $delimiter = ';';
    $errors = 0;
    $empty_fields = 0;
    $id_failed = [];
    $file_name = 'failed' . date('d-m-Y-h:ia') . '.csv';
    $uri = 'public://content/csv_files/' . $file_name;
    $file_handle = fopen($uri, 'w');
    $delimiter = ';';
    $enclosure = '"';
    $error_data = 1;
    while (($customers = fgetcsv($file, 1000, $delimiter)) !== FALSE) {
      $field_errors = 0;
      if ($num >= 1) {
        $country = $customers[0];
        $sponsor = $form_state->getValue('sponsors');
        $business_key = $customers[2];
        $campaign = $customers[4];
        $doc_type = $customers[5];
        $doc_number = $customers[6];
        $name = $customers[7];
        $lastname = $customers[8];
        $email = $customers[9];
        $phone = $customers[10];
        $city = $customers[11];
        $birthday = $customers[12];
        $gender = $customers[13];
        $id_failed['país'] = 'país';
        $id_failed['clave de negocio'] = 'Clave de negocio';
        $id_failed['sponsor'] = 'sponsor';
        $id_failed['campaña'] = 'campaña';
        $id_failed['ramo'] = 'ramo';
        $id_failed['tipo de documento'] = 'tipo de documento';
        $id_failed['numero de documento'] = 'numero de documento';
        $id_failed['nombre'] = 'nombre';
        $id_failed['apellido'] = 'apellido';
        $id_failed['email'] = 'correo';
        $id_failed['telefono'] = 'teléfono';
        $id_failed['error'] = 'ERROR';
        $error_log[0] = $id_failed;

        $query2 = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
        $res = $query2->condition('type', 'customer')
          ->condition('field_id_number', $doc_number)
          ->condition('field_document_type', $doc_type)
          ->condition('field_campaign_id', $cid)
          ->condition('field_status', 1)
          ->execute();
        if ($res == []) {
          if (empty($country) && $field_errors == 0) {
            $id_failed['error'] = 'no existe el País';
            $field_errors++;
          }
          if (empty($sponsor) && $field_errors == 0) {
            $id_failed['error'] = 'no existe el Sponsor';
            $field_errors++;
          }
          if (empty($business_key) && $field_errors == 0) {
            $id_failed['error'] = 'no existe la clave de negocio';
            $field_errors++;
          }

          if (empty($campaign) && $field_errors == 0) {
            $id_failed['error'] = 'no existe la campaña';
            $field_errors++;
          }
          if (empty($doc_number) && $field_errors == 0) {
            $id_failed['error'] = 'no existe el número de documento';
            $field_errors++;
          }
          if (empty($name) && $field_errors == 0) {
            $id_failed['error'] = 'no existe el nombre';
            $field_errors++;
          }
          if (empty($lastname) && $field_errors == 0) {
            $id_failed['error'] = 'no existe el apellido';
            $field_errors++;
          }
          if (empty($email) && $field_errors == 0) {
            $id_failed['error'] = 'no existe el correo';
            $field_errors++;
          }
          if (empty($phone) && $field_errors == 0) {
            $id_failed['error'] = 'no existe el teléfono';
            $field_errors++;
          }
          if (!is_numeric($phone) && $field_errors == 0) {
            $id_failed['error'] = 'El teléfono debe ser sólo numérico';
            $field_errors++;
          }

          if ($field_errors == 0) {
            $node = Node::create([
              'type' => 'customer',
              'title' => $name . $lastname,
              'field_country' => $country,
              'field_sponsor_name' => $sponsor,
              'field_bussiness_key' => $business_key,
              'field_branch' => $bid,
              'field_campaign' => $campaign,
              'field_id_number' => $doc_number,
              'field_document_type' => $doc_type,
              'field_customer_name' => $name,
              'field_lastname' => $lastname,
              'field_email' => $email,
              'field_phone' => $phone,
              'field_city' => $city,
              'field_birth_day' => $birthday,
              'field_gender' => $gender,
              'field_campaign_id' => $cid,
              'field_send_mails' => FALSE,
              'field_status' => TRUE,
            ]);
            $saver[] = $node->save();
          }
          if ($field_errors >= 1) {
            $empty_fields++;
            $id_failed['país'] = $country;
            $id_failed['clave de negocio'] = $doc_type;
            $id_failed['sponsor'] = $sponsor;
            $id_failed['campaña'] = $campaign;
            $id_failed['ramo'] = $customers[3];
            $id_failed['tipo de documento'] = $doc_type;
            $id_failed['numero de documento'] = $doc_number;
            $id_failed['nombre'] = $name;
            $id_failed['apellido'] = $lastname;
            $id_failed['email'] = $email;
            $id_failed['telefono'] = $phone;
            $error_log[$num] = $id_failed;
          }
        }
        else {
          $errors++;
        }

      }
      $num++;
    }
    foreach ($error_log as $log) {
      fputcsv($file_handle, $log, $delimiter, $enclosure);
    }
    fclose($file_handle);

    // $file_path = \Drupal::service('file_system')->realpath($uri);
    $file = File::create([
      'filename' => $file_name,
      'uri' => $uri,
    ]);
    $file->save();
    $file_path = \Drupal::service('file_system')->realpath($uri);

    if ($errors >= 1) {
      $error_data = ($error_data + $errors);
      \Drupal::messenger()->addError($errors . ' Clientes ya existían previamente, así que no han sido ingresados nuevamente.');
    }
    if ($empty_fields >= 1) {
      $error_data = ($error_data + $empty_fields);
      \Drupal::messenger()->addError($empty_fields . ' Clientes no han sido creados debido a que les hace falta información requerida por la base de datos.');
      $host = \Drupal::request()->getSchemeAndHttpHost();
      $host . '/sites/default' . $file_path;
      \Drupal::messenger()->addWarning(
      $this->t('Para descargar el registro de errores por favor haga clic <a href=":link">aquí</a>', [':link' => '/sites/sponsors/files/content/csv_files/' . $file_name])
      );

    }
    \Drupal::messenger()->addMessage('Se han ingresado exitosamente ' . ($num - $error_data) . ' Clientes');

  }

>>>>>>> main
}
