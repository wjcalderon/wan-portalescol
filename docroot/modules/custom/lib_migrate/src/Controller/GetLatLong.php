<?php

namespace Drupal\lib_migrate\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for get latitude and longitude.
 */
class GetLatLong extends ControllerBase {

  /**
<<<<<<< HEAD
   * Get_lat_long_by_address.
   *
   * @param [type] $address
   *   [description].
   *
   * @return [type]          [description]
   */
  public function get_lat_long_by_address($address, $cc) {

    $api_key = $this->get_api_key();
=======
   * GetLatLongByAddress.
   */
  public function getLatLongByAddress($address, $cc) {

    $api_key = $this->getApiKey();
>>>>>>> main
    $lat = $long = NULL;
    $msg_pref = 'Google WS Lat-Long';
    $msg = $msg_pref . ' - No hay api key configurada en la plataforma';

    if (!empty($api_key)) {
      /*$client = new \GuzzleHttp\Client();
      $resp = $client->get(
      'https://maps.googleapis.com/maps/api/geocode/json',
      array(
      'query' => array(
      'address' => $address,
      'key' => $api_key,
      )
      )
      );
      $resp_content = json_decode($resp->getBody()->getContents());
      if (!empty($resp_content)) {
      $results = $resp_content->results[0];
      if (!empty($results)) {
      $lat = $results->geometry->location->lat;
      $long = $results->geometry->location->lng;
      $msg = NULL;
      }
      if (isset($resp_content->error_message)) {
      $msg = $msg_pref . ' - ' . $resp_content->error_message;
      }
      }*/
<<<<<<< HEAD
      $this->save_log_in_txt_file($address, $cc);
      $this->save_counter();
=======
      $this->saveLogInTxtFile($address, $cc);
      $this->saveCounter();
>>>>>>> main
    }

    // Borrar.
    $msg = NULL;
    $lat = '-12.2222';
    $long = '-76.2222';
    // Fin Borrar.
    return [
      'lat' => $lat,
      'long' => $long,
      'msg' => $msg,
    ];

  }

  /**
<<<<<<< HEAD
   * Save_counter.
   *
   * @return [type] [description]
   */
  private function save_counter() {
=======
   * SaveCounter.
   */
  private function saveCounter() {
>>>>>>> main
    $config = \Drupal::config('lib_migrate.settings');
    $count = $config->get('config.count_reqs_lat_lng');
    $tot = $count + 1;
    \Drupal::service('config.factory')
      ->getEditable('lib_migrate.settings')
      ->set('config.count_reqs_lat_lng', $tot)
      ->save();
  }

  /**
<<<<<<< HEAD
   * Save_log_in_txt_file.
   *
   * @param [type] $address
   *   [description].
   * @param [type] $cc
   *   [description].
   *
   * @return [type]          [description]
   */
  private function save_log_in_txt_file($address, $cc) {
=======
   * SaveLogInTxtFile.
   */
  private function saveLogInTxtFile($address, $cc) {
>>>>>>> main
    $serv_system = \Drupal::service('file_system');
    $dir_file = $serv_system->realpath(\Drupal::config('system.file')->get('default_scheme') . "://");
    $name_txt = 'log';
    $name_txt .= '_' . $_SESSION['date_log_latlng'];
    $name_txt .= '_' . $_SESSION['time_log_latlng'] . '.txt';
    $path_file = $dir_file . '/logs_migrate/' . $name_txt;
    file_put_contents(
      $path_file,
      $address . '|' . $cc . "\n",
      FILE_APPEND | LOCK_EX
    );
  }

  /**
<<<<<<< HEAD
   * Get_api_key.
   *
   * @return [string] $api_key
   */
  private function get_api_key() {
=======
   * GetApiKey.
   */
  private function getApiKey() {
>>>>>>> main
    $config = \Drupal::config('lib_migrate.settings');
    $api_key = $config->get('config.api_key_lat_lng');
    return $api_key;
  }

}
