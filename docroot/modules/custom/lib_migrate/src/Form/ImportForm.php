<?php

namespace Drupal\lib_migrate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Form custom import form.
 */
class ImportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'csv_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['import_csv'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload file here'),
      '#upload_location' => 'public://',
      '#default_value' => '',
      "#upload_validators" => [
        "file_validate_extensions" => [
          "xls xlsx",
        ],
      ],
      '#states' => [
        'visible' => [
          ':input[name="File_type"]' => [
            'value' => $this->t('Upload Your File'),
          ],
        ],
      ],
    ];

    $form['inicializar'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Borra los prestadores actuales'),
      '#default_value' => 0,
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Upload'),
      '#button_type' => 'primary',
    ];

    $form['description'] = [
      '#markup' => '<div class="ayudas">
        <p>Tenga en cuenta estas instrucciones para cuando vaya a realizar un cargue o actualización de registros</p>
        <ul>
        <li>Si se sube el excel nuevamente actualiza los registros</li>
        <li>Si se desea crear solo nuevos registros, use la plantilla y agréguelos para subir</li>
        <li>Si desea actualizar un registro use la plantilla y registre los cambios</li>
        <li>El campo llave es el nombre columna D</li>
        <li>Descargue la plantilla base <a  href="/sites/default/files/2019-01/plantilla-red-medica.xlsx" target="_blank" rel="noreferrer">Aquí</a></li>
        </ul>
        </div>',
    ];

    $form['download'] = [
      '#type' => 'markup',
      '#markup' => '<span><a href="/red-medica/export">Descargar base de datos existente</a></span>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $csv_file = $form_state->getValue('import_csv');
    $file = File::load($csv_file[0]);
    if ($file) {
      $file->setPermanent();
      $file->save();
    }
    else {
      \Drupal::messenger()->addMessage('Error al cargar archivo');
    }

    if ($form_state->getValue('inicializar') == 1) {
      $operations = [];
      $query = \Drupal::entityQuery('node')->condition('type', 'lender');

      $result = $query->count()->execute();
      $residuo = $result % 1000;
      $result = round($result / 1000, 0, PHP_ROUND_HALF_ODD);
      if ($residuo > 0) {
        $result++;
      }

      for ($i = 0; $i < $result; $i++) {
        $operations[] = [
          '\Drupal\lib_migrate\AddImportContentRedMedica::removeImportContentItem',
          [
            $i,
          ],
        ];
      }

      $batch = [
        'title' => $this->t('Removiendo Data...'),
        'operations' => $operations,
        'init_message' => $this->t('Removiendo is starting.'),
        'finished' => '\Drupal\lib_migrate\AddImportContentRedMedica::addImportContentItemCallback',
      ];
      batch_set($batch);
      return TRUE;
    }

    $type = IOFactory::identify($file->getFileUri());
    $reader = IOFactory::createReader($type);
    $reader->setReadDataOnly(TRUE);
    $pFilename = \Drupal::service('file_system')->realpath($file->getFileUri());
    $workbook = $reader->load($pFilename);
    $sheetData = $workbook->getActiveSheet();
    $rowIterator = $sheetData->getRowIterator();

    $row = [];
    foreach ($rowIterator as $row) {
      if ($row->getRowIndex() == 1) {
        continue;
      }
      $cellIterator = $row->getCellIterator();
      foreach ($cellIterator as $cell) {
        $data[$row->getRowIndex()][$cell->getColumn()] = $cell->getCalculatedValue();
      }
      $row = $data[$row->getRowIndex()];
      $operations[] = [
        '\Drupal\lib_migrate\AddImportContentRedMedica::addImportContentItem',
        [
          $row,
        ],
      ];
    }

    $_SESSION['time_log_latlng'] = time();
    $_SESSION['date_log_latlng'] = date('d_m_Y', time());

    $batch = [
      'title' => $this->t('Importing Data...'),
      'operations' => $operations,
      'init_message' => $this->t('Import is starting.'),
      'finished' => '\Drupal\lib_migrate\AddImportContentRedMedica::addImportContentItemCallback',
    ];
    batch_set($batch);
  }

}
