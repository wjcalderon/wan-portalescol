<?php

namespace Drupal\hdi_internal\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use \Drupal\Core\File\FileExists;

/**
 * Class WallpaperUploadForm.
 */
class HdiInternalForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'hdi_internal_form';
  }

   /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    //Wallpaper
    $form['hdi_wallpaper'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Wallpaper'),
      '#upload_location' => 'temporary://',
      '#upload_validators' => [
        'file_validate_extensions' => ['png'],
      ],
      '#description' => 'Solo archivos <strong>PNG</strong>',
    ];

    //Screensaver
    $form['hdi_screensaver'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Screensaver'),
      '#upload_location' => 'temporary://',
      '#upload_validators' => [
        'file_validate_extensions' => ['scr'],
      ],
      '#description' => 'Solo archivos <strong>SCR</strong>',
    ];

    // Botón de envío para el formulario.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Cargar Archivos'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $wallpaper = $form_state->getValue('hdi_wallpaper', 0);
    $screensaver = $form_state->getValue('hdi_screensaver', 0);

    //Wallpaper
    if (isset($wallpaper[0]) && !empty($wallpaper[0]))
    {
      $file = File::load($wallpaper[0]);
      $file_extension = pathinfo($file->getFileName(), PATHINFO_EXTENSION);

      //Modifica que siempre sea Wallpaper el nombre
      $default_filename = 'wallpaper'. '.' . $file_extension;

      // Directorio de destino para el wallpaper siempre debe ser la carpeta /sites/default/files.
      $destination = 'public://hdi/internal/';
      $file_system = \Drupal::service('file_system');
      $file_path = $destination . $default_filename;

      // Si ya existe un archivo con el mismo nombre, se elimina y se reemplaza con el nuevo.
      if (file_exists($file_path)) {
        $file_system->delete($file_path);
      }
      $file_system->copy($file->getFileUri(), $file_path, FileExists::Replace);

      // Cargar el archivo nuevamente y actualizar su URL.
      $file->setFileUri($file_path);
      $file->setPermanent(TRUE);
      $file->save();
    }

    //Screensaver
    if (isset($screensaver[0]) && !empty($screensaver[0]))
    {
      $file = File::load($screensaver[0]);
      $file_extension = pathinfo($file->getFileName(), PATHINFO_EXTENSION);

      //Modifica que siempre sea Screensaver el nombre
      $default_filename = 'screensaver'. '.' . $file_extension;;

      // Directorio de destino para el wallpaper siempre debe ser la carpeta /sites/default/files.
      $destination = 'public://hdi/internal/';
      $file_system = \Drupal::service('file_system');
      $file_path = $destination . $default_filename;

      // Si ya existe un archivo con el mismo nombre, se elimina y se reemplaza con el nuevo.
      if (file_exists($file_path)) {
        $file_system->delete($file_path);
      }
      $file_system->copy($file->getFileUri(), $file_path, FileExists::Replace);

      // Cargar el archivo nuevamente y actualizar su URL.
      $file->setFileUri($file_path);
      $file->setPermanent(TRUE);
      $file->save();
    }

    // Se retorna mensaje
     \Drupal::messenger()->addMessage($this->t('Se cargaron Wallpaper y/o Screensaver correctamente.'));
  }
}
