<?php

namespace Drupal\liberty_claims\traits;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Send email in case a request fail.
 */
trait ErrorEmails {

  /**
   * Send notificacion error email for IAXIS.
   *
   * @param array $info
   *   Request data.
   * @param string $error
   *   Error throw by original request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Response for email trasaction.
   */
  public function sendEmailErrorIaxis(array $info, string $error): JsonResponse {
    $path = 'http://127.0.0.1';
    $client = new Client(['base_uri' => $path]);

    $response = $client->request('GET', '/claim-data/cities-carshops', [
      'http_errors' => TRUE,
    ]);

    $data_cities = json_decode($response->getBody()->getContents(), TRUE);

    $quetepaso = [
      'CLAIM_TYPE_PPD' => 'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.',
      'CLAIM_TYPE_PPH' => 'Hurto de cualquier parte o accesorio de su vehículo.',
      'CLAIM_TYPE_PTH' => 'Hurto de su vehículo.',
      'CLAIM_TYPE_AC' => 'Pequeños accesorios.',
      'CLAIM_TYPE_LR' => 'Llantas estalladas.',
      'CLAIM_TYPE_CL' => 'Cobertura de llaves.',
    ];

    $subject = 'Error creación flujo asegurado IAXIS - ' . $info['plate'];

    $body = "Buen día,\n
        Al momento de crear el siniestro en IAXIS en el flujo de asegurado hubo un error.\n" .
    " La información relevante para su creación manual es:
        Que te pasó: " . ($quetepaso[$info['tellus']] ?? 'Tipo de reclamo desconocido') . "
        Fecha y hora: {$info['date']}
        Siniestro: 0
        Placa: {$info['plate']}
        Celular: {$info['driverPhone']}
        Correo: {$info['email']}
        Descripción de los hechos: {$info['description']}
        Nombre del conductor: {$info['driverName']}
        Cédula del conductor: {$info['driverDocumentId']}
        Teléfono del conductor: {$info['driverPhone']}
        Nombre declarante: {$info['personalData']['name']} {$info['personalData']['lastname']}
        Teléfono declarante: {$info['phone']}
        Ciudad: " . ($data_cities[$info['city']] ?? 'Ciudad no encontrada') . "
        Dirección de ocurrencia: {$info['whereAddress']}
        Taller seleccionado: {$info['nombre']}\n\n";
    if (str_contains($error, '#17')) {
      $body .= "<b>Error: Siniestro duplicado, con fecha y causa de siniestro</b>.\n\n";
    }
    $body .= "Error IAXIS: <pre style=\"background-color:lightgray;padding:1rem;white-space:pre-wrap;\">";
    $body .= "$error</pre>";

    $params = [
      'subject2' => $subject,
      'subject' => 'Error radicación IAXIS',
      'message' => nl2br($body),
    ];

    $config = $this->configFactory->get('liberty_claims_email.settings');
    $module = 'liberty_claims';
    $to = $config->get('email_send');
    $langcode = 'es';
    $send = TRUE;

    $result = $this->mailManager->mail($module, 'send_email', $to, $langcode, $params, NULL, $send);

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }

  /**
   * Send notificacion error email for SIPO.
   *
   * @param array $data
   *   Request data.
   * @param string $data_taller
   *   Workshop selected by user.
   * @param string $error
   *   Error throw by original request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Response for email trasaction.
   */
  public function sendEmailErrorSipo(array $data, string $data_taller, string $error): JsonResponse {
    $date = date('d/m/Y');

    $subject = 'Error creación siniestro SIPO - #' . $data['caso']['numeroSiniestroiAxis'];

    $body = "Buen día,\n
        Al momento de crear el siniestro en SIPO, el flujo de asegurado presentó un error.\n" .
    " La información relevante para su creación manual es:
        Número de caso de Iaxis: {$data['caso']['numeroSiniestroiAxis']}
        Datos del asegurado: {$data['asegurado']['nombre']}
        Placa: {$data['vehiculo']['placa']}
        Taller Escogido:  {$data_taller}
        Fecha de creación del siniestro: {$date}
        Número Celular: {$data['asegurado']['celular']}
        Correo: {$data['asegurado']['email']}
        Fecha siniestro: {$data['caso']['fechaSiniestro']}\n\n";
    $body .= "Error SIPO: <pre style=\"background-color:lightgray;padding:1rem;white-space:pre-wrap;\">";
    $body .= "$error</pre>";

    $params = [
      'subject2' => $subject,
      'subject' => 'Error radicación SIPO',
      'message' => nl2br($body),
    ];

    $config = $this->configFactory->get('liberty_claims_email.settings');
    $module = 'liberty_claims';
    $to = $config->get('email_send');
    $langcode = 'es';
    $send = TRUE;

    $result = $this->mailManager->mail($module, 'send_email', $to, $langcode, $params, NULL, $send);

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }

}
