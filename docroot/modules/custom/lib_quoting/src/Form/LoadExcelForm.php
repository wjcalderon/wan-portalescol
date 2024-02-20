<?php

namespace Drupal\lib_quoting\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Load exccel form custom.
 */
class LoadExcelForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'excel_facecolda_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['import_excel'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload file here'),
      '#upload_location' => 'public://',
      '#default_value' => '',
      "#upload_validators"  => ["file_validate_extensions" => ["xlsx"]],
      '#required' => TRUE,
    ];

    $form['type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Tipo de carga'),
      '#required' => TRUE,
      '#options' => [
        'brand_line' => $this->t('Cargar taxonomías marca|línea vehículos'),
        'ref2' => $this->t('Cargar taxonomías ref2 vehículos'),
        'code_facecolda' => $this->t('Cargar códigos FACECOLDA vehículos'),
        'code_facecolda_price' => $this->t('Cargar precios de vehículos'),
      ],
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Upload'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $excel_file = $form_state->getValue('import_excel');
    $typeLoad = $form_state->getValue('type');
    $file = File::load($excel_file[0]);
    if ($file) {
      $file->setPermanent();
      $file->save();
    }
    else {
      \Drupal::messenger()->addStatus('Error al cargar archivo');
    }

    $type = IOFactory::identify($file->getFileUri());
    $reader = IOFactory::createReader($type);
    $reader->setReadDataOnly(TRUE);
    $pFilename = \Drupal::service('file_system')->realpath($file->getFileUri());
    $workbook = $reader->load($pFilename);
    $sheetData = $workbook->getActiveSheet();
    $rowIterator = $sheetData->getRowIterator();

    $row = $operations = [];
    foreach ($rowIterator as $row) {
      if ($row->getRowIndex() == 1) {
        continue;
      }
      $cellIterator = $row->getCellIterator();
      foreach ($cellIterator as $cell) {
        $data[$row->getRowIndex()][$cell->getColumn()] = $cell->getCalculatedValue();
      }
      $row = $data[$row->getRowIndex()];
      $row['typeLoad'] = $typeLoad;
      $operations[] = [
        '\Drupal\lib_quoting\ImportFacecoldaCodes::addImportContentItem',
         [
           $row,
         ],
      ];
    }

    $batch = [
      'title' => $this->t('Importing Data...'),
      'operations' => $operations,
      'init_message' => $this->t('Import is starting.'),
      'finished' => '\Drupal\lib_quoting\ImportFacecoldaCodes::addImportContentItemCallback',
    ];
    batch_set($batch);
  }

}
