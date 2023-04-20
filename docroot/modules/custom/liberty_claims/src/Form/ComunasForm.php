<?php

namespace Drupal\liberty_claims\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Messenger\Messenger;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides a Liberty GPS Request form.
 */
class ComunasForm extends FormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Messenger service.
   *
   * @var Drupal\Core\Messenger\Messenger
   */
  protected $messenger;

  /**
   * Constructs a UserApprovalForm object.
   *
   * @param \Drupal\Core\Messenger\Messenger $messenger
   *   The Messenger.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(Messenger $messenger, EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
          $container->get('messenger'),
          $container->get('entity_type.manager')
      );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lib_gps_comunas';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['csv'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Base de datos'),
      '#name' => 'csv_file',
      '#upload_location' => 'public://content/csv_files/',
      '#description' => $this->t(
            'Cargue una base de datos con formato CSV'
      ),
      '#upload_validators' => [
        'file_validate_extensions' => ['csv'],
      ],
      '#required' => TRUE,
    ];

    $form['help'] = [
      '#type' => 'markup',
      '#markup' => '<span>Descargue la plantilla de carga <a href="/modules/custom/lib_gps/file/plantilla.csv">aqui</a</span><hr/>',

    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Importar',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $fid = $form_state->getValue('csv');
    $destination = $this->entityTypeManager->getStorage('file')->load($fid[0]);
    $num = 0;
    $uriFile = $destination->getFileUri();
    $file = fopen($uriFile, 'r');
    $delimiter = ';';
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

        $codTaller = $customers[0];
        $aixis = $customers[1];
        $nit = $customers[2];
        $name = $customers[3];
        $direccion = $customers[4];
        $ciudad = $customers[5];
        $cod_ciudad = $customers[6];
        $email = $customers[7];
        $telefono = $customers[8];
        $sucursal = $customers[9];

        if ($field_errors == 0) {
        
            $term = $this->entityTypeManager->getStorage('taxonomy_term')->create([
              'name' => $name,
              'field_codtaller' => $codTaller,
              'field_aixis' => $aixis ,
              'field_nit' => $nit,
              'field_direccion' => $direccion,
              'field_ciudad' => $ciudad,
              'field_cod_ciudad' => $cod_ciudad,
              'field_email' => $email,
              'field_telefono' => $telefono,
              'field_sucursal' => $sucursal,
              'vid' => 'talleres_chevrolet',
            ])->save();
          
        }
        else {
          if ($field_errors >= 1) {
            $empty_fields++;
            $id_failed['code'] = $code;
            $id_failed['city'] = $city;
            $id_failed['region'] = $region;
            $id_failed['name'] = $name;
            $error_log[$num] = $id_failed;
          }
        }
      }
      $num++;

      $this->messenger()->addMessage('Importación terminada');
    }
    if ($empty_fields >= 1) {
      foreach ($error_log as $log) {
        fputcsv($file_handle, $log, $delimiter, $enclosure);
      }
      fclose($file_handle);
      $file = $this->entityTypeManager->getStorage('file')->create([
        'filename' => $file_name,
        'uri' => $uri,
      ]);
      $file->save();

      $error_data = ($error_data + $empty_fields);
      $this->messenger()->addWarning($empty_fields . ' Comuna no han sido creada(s) debido a que les hace falta información requerida por la base de datos.');
      $replacements['@info_file'] = $file_name;
      $this->messenger()->addWarning($this->t('Para descargar el registro de errores por favor dar click : <a href="/sites/default/files/content/csv_files/@info_file">aquí</a>', $replacements));

    }

  }

}
