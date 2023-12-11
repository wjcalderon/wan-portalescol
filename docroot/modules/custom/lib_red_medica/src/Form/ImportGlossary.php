<?php

namespace Drupal\lib_red_medica\Form;

use Drupal\Core\File\FileSystem;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Import glossary.
 */
class ImportGlossary extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'import_glossary_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['import_file'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Subir archivo'),
      '#upload_location' => 'public://',
      '#default_value' => '',
      "#upload_validators" => [
        "file_validate_extensions" => ["xls xlsx"],
      ],
      '#states' => [
        'visible' => [
          ':input[name="File_type"]' => [
            'value' => $this->t('Subir archivo'),
          ],
        ],
      ],
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Importar'),
      '#button_type' => 'primary',
    ];

    $form['description'] = [
      '#markup' => '<div class="ayudas">
        <p>Tenga en cuenta estas instrucciones para cuando vaya a realizar un cargue de registros</p>
        <ul>
        <li><b>NO</b> se van a actulizar registros.</li>
        <li>Si se desea crear nuevos registros, use la plantilla y agréguelos para subir</li>
        <li>Descargue la plantilla base <a  href="/modules/custom/lib_red_medica/data/glosario-especialidades.xlsx" target="_blank" rel="noreferrer">Aquí</a></li>
        </ul>
        </div>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $csv_file = $form_state->getValue('import_file');
    $file = File::load($csv_file[0]);

    if ($file) {
      // File realpath.
      $import_file = FileSystem::realpath($file->getFileUri());

      // Create reader.
      $type = IOFactory::identify($import_file);
      $reader = IOFactory::createReader($type);
      $reader->setReadDataOnly(TRUE);

      $workbook = $reader->load($import_file);
      $sheetData = $workbook->getActiveSheet();
      $rowIterator = $sheetData->getRowIterator();

      // Set batch operations.
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
          '\Drupal\lib_red_medica\Import\Glossary::importItem',
              [$row],
        ];
      }

      // Run batch job.
      $batch = [
        'title' => $this->t('Importing Data...'),
        'operations' => $operations,
        'init_message' => $this->t('Import is starting.'),
        'finished' => '\Drupal\lib_red_medica\Import\Glossary::importItemCallback',
      ];
      batch_set($batch);
    }
    else {
      \Drupal::messenger()->addStatus('Error al cargar archivo');
    }
  }

}
