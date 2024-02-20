<?php

namespace Drupal\liberty_form\Services;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use phpseclib\Net\SFTP;

/**
 * Class liberty services sftp .
 */
class LibertySftpMarketingController extends ControllerBase {

  /**
   * Does something.
   *
   * @return string
   *   Some value.
   */
  public function doSomething($cid) {

    // Variables conexion sftp mk.
    $config = \Drupal::config('liberty_form.marketing_cloud');
    if ($config) {
      $user_sftp = $config->get('user_sftp');
      $pass_sftp = $config->get('pass_sftp');
      $path_sftp = $config->get('path_sftp');
      $host_sftp = $config->get('host_sftp');
      $sftp = new SFTP($host_sftp);

      // Crea la carpeta si no existe para guardar el csv y le aplica permiso.
      $path = 'public://content/csv_mk';
      if (!file_exists($path)) {
        mkdir($path, 0777, TRUE);
      }

      // Crea el archivo csv  con la fecha y hora en la
      // genera el archivo y le aplica permisos.
      $ruta = "public://content/csv_mk/CargueLanding.csv";
      $file_handle = fopen($ruta, 'w');
      fclose($file_handle);

      $options = ['absolute' => TRUE];
      $url = Url::fromRoute('entity.node.canonical', ['node' => $cid], $options);
      $url = $url->toString();

      $nodess = \Drupal::entityTypeManager()->getStorage('node')->load($cid);

      // Traemos la data del campaña creada.
      $query = \Drupal::entityQuery('node')
        ->condition('type', 'customer')
        ->condition('field_campaign_id', $cid)
        ->condition('field_status', 1);
      $results_customer = $query->execute();

      if (count($results_customer) == 0) {
        $status['message'] = "La campaña no tiene clientes asignados";
        $status['type'] = "error";
        return $status;
      }
      else {

        $count = 1;
        $submission_data2 = [];
        $submission_data2[0] = [
          "Pais",
          "NombreSponsor",
          "ClaveNegocio",
          "Ramo",
          'Campaña',
          'Tipodocumento',
          'Numerodocumento',
          'SubscriberKey',
          'Nombres',
          'Apellidos',
          'EmailCliente',
          'Telefono',
          'Ciudad',
          'FechaNacimiento',
          'Genero',
          'Fechadecarguecampaña',
          'UrlSponsor',
          'CampaignLanding',
        ];

        foreach ($results_customer as $item_customer) {
          $entity = \Drupal::entityTypeManager()->getStorage('node')->load($item_customer);
          $array_single = [];

          $field_id_number = $entity->get('field_id_number')->getValue()[0]['value'];
          $campana = $nodess->label();
          $field_document_type = $entity->get('field_document_type')->getValue()[0]['value'];
          $name = $entity->get('field_customer_name')->getValue()[0]['value'];
          $last_name = $entity->get('field_lastname')->getValue()[0]['value'];
          $email = $entity->get('field_email')->getValue()[0]['value'];
          $phone = $entity->get('field_phone')->getValue()[0]['value'];
          $url_landing = $url;
          $term_name_sponsor = Term::load($entity->get('field_sponsor_name')->getValue()[0]['target_id'])->getName();
          $term_name_ramo = Term::load($entity->get('field_branch')->getValue()[0]['target_id'])->getName();
          $country = $entity->get('field_country')->getValue()[0]['value'] ? strtoupper($entity->get('field_country')->getValue()[0]['value']) : "";
          $field_bussiness_key = $entity->get('field_bussiness_key')->getValue()[0]['value'];
          $field_city = $entity->get('field_city')->getValue()[0]['value'];
          $field_birth_day = $entity->get('field_birth_day')->getValue()[0]['value'];
          $field_gender = $entity->get('field_gender')->getValue()[0]['value'];
          $created = date("Y-m-d H:i:s", $entity->get('created')->getValue()[0]['value']);
          $term_name_sponsor = $term_name_sponsor ? strtoupper($term_name_sponsor) : "";
          $term_name_ramo = $term_name_ramo ? strtoupper($term_name_ramo) : "";
          switch ($field_document_type) {
            case '1':
              $field_document_type = "Cédula de ciudadanía";
              break;

            case '2':
              $field_document_type = "Cédula de extrangería";
              break;

            case '3':
              $field_document_type = "Pasaporte";
              break;

          }
          array_push($array_single, $country, $term_name_sponsor, $field_bussiness_key, $term_name_ramo, $campana, $field_document_type, $field_id_number, $field_document_type . $field_id_number, $name, $last_name, $email, $phone, $field_city, $field_birth_day, $field_gender, $created, $url_landing, $campana);

          $submission_data2[$count] = $array_single;
          $count++;

          $node = Node::load($item_customer);
          $node->set("field_send_mails", TRUE);
          $node->save();

        }

        $delimitador = ',';
        $encapsulador = '"';

        $file_handle = fopen($ruta, 'w');
        foreach ($submission_data2 as $linea) {
          fputcsv($file_handle, $linea, $delimitador, $encapsulador);
        }
        rewind($file_handle);
        fclose($file_handle);

        // Conecta al servidor y deja el archivo en el path predeterminado.
        if (!$sftp->login($user_sftp, $pass_sftp)) {
          \Drupal::logger('SFTP Marteking Cloud')->error($sftp->getLastSFTPError());
          $status['message'] = $sftp->getLastSFTPError();
          $status['type'] = "error";
        }
        else {
          \Drupal::logger('SFTP Marteking Cloud')->notice('Login success SFTP.');
          $data = file_get_contents($ruta);
          $sftp->put($path_sftp . '/CargueLanding.csv', $data);
          if ($sftp->getLastSFTPError()) {
            \Drupal::logger('SFTP Marteking Cloud')->error($sftp->getLastSFTPError());
            $status['message'] = $sftp->getLastSFTPError();
            $status['type'] = "error";
          }
          else {
            $status['message'] = 'Carga Completada archivo CSV Marketing Cloud';
            $status['type'] = "success";
            \Drupal::logger('SFTP Marteking Cloud')->notice('Carga Completada archivo CSV Marketing Cloud');
          }
        }

        return $status;
      }
    }
  }

}
