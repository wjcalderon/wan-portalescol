<?php

namespace Drupal\liberty_claims\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\entity\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Import Data to Taxonomies.
 */
class ImportFormRenault extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'liberty_claims_import_renault';
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
      '#upload_validators' => ['file_validate_extensions' => ['csv']],
      '#description' => $this->t('Upload an Excel file containing the taxonomy terms to insert (fields only in CSV).'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Upload'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Puedes agregar validaciones específicas si es necesario.
    if (empty($form_state->getValue('import_csv'))) {
      $form_state->setErrorByName('import_csv', $this->t('You must upload an CSV Excel file.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $csv_file = $form_state->getValue('import_csv');
    $file = File::load($csv_file[0]);

    if ($file) {
      try {
        // Obtener el tipo de archivo
        $type = IOFactory::identify($file->getFileUri());
        $reader = IOFactory::createReader($type);
        $reader->setReadDataOnly(TRUE);

        // Obtener la ruta real del archivo
        $pFilename = \Drupal::service('file_system')->realpath($file->getFileUri());

        // Cargar el archivo
        $workbook = $reader->load($pFilename);
        $sheetData = $workbook->getActiveSheet();

        // Obtener las filas
        $rows = $sheetData->getRowIterator();

        // El nombre de la taxonomía
        $vocabulary_machine_name = 'talleres_renault';
        $inserted_count = 0;

        // Recorrer cada fila del archivo
        foreach ($rows as $row) {
          // Obtener las celdas de la fila usando el iterador de celdas
          $cellIterator = $row->getCellIterator();
          $cellIterator->setIterateOnlyExistingCells(TRUE);

          $rowData = [];
          foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getValue();
          }

          // Asignar valores de las celdas a las variables
          $term_name = isset($rowData[0]) ? $rowData[0] : ''; // Nombre del término
          $field_cod_taller_renault = isset($rowData[1]) ? $rowData[1] : '';
          $field_aixis_renault = isset($rowData[2]) ? $rowData[2] : '';
          $field_direccion_renault = isset($rowData[3]) ? $rowData[3] : '';
          $field_nit_renault = isset($rowData[4]) ? $rowData[4] : '';
          $field_sucursal_renault = isset($rowData[5]) ? $rowData[5] : '';
          $field_telefono_renault = isset($rowData[6]) ? $rowData[6] : '';
          $field_ciudad_renault = isset($rowData[7]) ? $rowData[7] : '';
          $field_cod_ciudad_renault = isset($rowData[8]) ? $rowData[8] : '';

          // Buscar el término existente por su Id del taller en el vocabulario
          $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties([
            'field_cod_taller_renault' => $field_cod_taller_renault,
            'vid' => $vocabulary_machine_name,
          ]);

          // Si el término no existe, crear un nuevo término
          if (empty($terms)) {
            $term = Term::create([
              'name' => $term_name,
              'vid' => $vocabulary_machine_name,
              'field_cod_taller_renault' => $field_cod_taller_renault,
              'field_aixis_renault' => $field_aixis_renault,
              'field_direccion_renault' => $field_direccion_renault,
              'field_nit_renault' => $field_nit_renault,
              'field_sucursal_renault' => $field_sucursal_renault,
              'field_telefono_renault' => $field_telefono_renault,
              'field_ciudad_renault' => $field_ciudad_renault,
              'field_cod_ciudad_renault' => $field_cod_ciudad_renault,
            ]);
            $term->save();
            $inserted_count++;
            \Drupal::messenger()->addMessage($this->t('Term @term_name inserted successfully.', ['@term_name' => $term_name]));

          }
        }
        \Drupal::messenger()->addMessage($this->t('@count terms were successfully inserted.', ['@count' => $inserted_count]));
      } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        // Error al leer el archivo Excel
        \Drupal::messenger()->addError($this->t('Error reading the Excel file: @message', ['@message' => $e->getMessage()]));
        \Drupal::logger('liberty_claims')->error($e->getMessage());  // Registrar el error en los logs
      } catch (\Exception $e) {
        // Otros errores inesperados
        \Drupal::messenger()->addError($this->t('An unexpected error occurred: @message', ['@message' => $e->getMessage()]));
        \Drupal::logger('liberty_claims')->error($e->getMessage());  // Registrar el error en los logs
      }
    } else {
      \Drupal::messenger()->addError($this->t('There was an issue with the file upload.'));
    }
  }

}
