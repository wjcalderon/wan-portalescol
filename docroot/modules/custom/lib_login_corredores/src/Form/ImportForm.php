<?php

namespace Drupal\lib_login_corredores\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\entity\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Provides a Login User to Blog form.
 */
class ImportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lib_login_corredores_import';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['import_csv'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload file here'),
    // Cambiado el directorio de destino a 'public://'.
      '#upload_location' => 'public://',
      '#upload_validators' => ['file_validate_extensions' => ['xls xlsx']],
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Puedes agregar validaciones específicas si es necesario.
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
      $real_path_to_file = \Drupal::service('file_system')->realpath($file->getFileUri());

      $type = IOFactory::identify($real_path_to_file);

      $reader = IOFactory::createReader($type);
      $reader->setReadDataOnly(TRUE);
      $pFilename = \Drupal::service('file_system')->realpath($file->getFileUri());
      $workbook = $reader->load($pFilename);
      $sheetData = $workbook->getActiveSheet();
      $rowIterator = $sheetData->getRowIterator();

      $schema = [
        'fields' => [
          'numero_documento' => [
            'type' => 'varchar',
            'length' => 255,
            'description' => 'Número de Documento',
            'not null' => TRUE,
          ],
          'nombre' => [
            'type' => 'varchar',
            'length' => 255,
            'description' => 'Nombre',
          ],
          'campo_booleano' => [
            'type' => 'int',
            'size' => 'tiny',
            'description' => 'Campo Booleano',
          ],
        ],
        'primary key' => ['numero_documento'],
      ];

      $table_name = 'custom_import_table';
      $database = \Drupal::database();

      if (!$database->schema()->tableExists($table_name)) {
        $database->schema()->createTable($table_name, $schema);
      }

      $database->truncate($table_name)->execute();
      foreach ($rowIterator as $row) {
        if ($row->getRowIndex() == 1) {
          continue;
        }
        $cellIterator = $row->getCellIterator();
        $data = [];

        foreach ($cellIterator as $cell) {
          $cell_value = $cell->getCalculatedValue();
          if (!empty($cell_value)) {
            $data[] = $cell_value;
          }
        }

        $this->messenger()->addMessage($this->t('Data count: @count', ['@count' => count($data)]));
        if (count($data) == 2) {
          $this->messenger()->addMessage($this->t('inserta'));
          try {
            $database->insert($table_name)
              ->fields(['numero_documento', 'nombre'])
              ->values($data)
              ->execute();
            $this->messenger()->addMessage('Data inserted successfully: ' . print_r($data, TRUE));
          }
          catch (\Exception $e) {
            $this->messenger()->addMessage('Error inserting data: ' . $e->getMessage());
          }
        }
      }

      $this->messenger()->addMessage($this->t('Data imported successfully.'));
    }
    else {
      $this->messenger()->addError($this->t('Error al cargar archivo.'));
    }
  }

}
