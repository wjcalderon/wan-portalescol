<?php

namespace Drupal\liberty_claims\traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;

trait ErrorEmails {
  /**
   * Send notificacion error email for IAXIS.
   *
   * @param array
   * @return JsonResponse Mail rendered.
   */
  public function sendEmailErrorIaxis($info): JsonResponse {
    $path = \Drupal::request()->getSchemeAndHttpHost();
    $client = new Client(['base_uri' => $path]);

    $response = $client->request('GET', '/claim-data/cities-carshops', [
      'http_errors' => true,
    ]);

    $data_cities = json_decode($response->getBody()->getContents(), true);

    $quetepaso = [
      'CLAIM_TYPE_PPD' => 'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.',
      'CLAIM_TYPE_PPH' => 'Hurto de cualquier parte o accesorio de su vehículo.',
      'CLAIM_TYPE_PTH' => 'Hurto de su vehículo.',
      'CLAIM_TYPE_AC' => 'Pequeños accesorios.',
      'CLAIM_TYPE_PL' => 'Pérdida de llaves.',
      'CLAIM_TYPE_LR' => 'Llantas estalladas.',
      'CLAIM_TYPE_CL' => 'Cobertura de llaves.',
      'CLAIM_TYPE_CR' => 'Rotura de cristales.',
    ];

    $subject = 'Error creación flujo asegurado IAXIS - ' . $info['plate'];

    $body = "Buen día,
        Al momento de crear el siniestro en IAXIS en el flujo de asegurado hubo un error." .
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
        Nombre declarante: {$info['personalData']['name']}
        Teléfono declarante: {$info['phone']}
        Ciudad: " . ($data_cities[$info['city']] ?? 'Ciudad no encontrada') . "
        Dirección de ocurrencia: {$info['whereAddress']}
        Taller seleccionado: {$info['nombre']}";

    $params = [
      'subject2' => $subject,
      'subject' => 'Error radicacion Iaxis',
      'message' => nl2br($body),
    ];

    $config = $this->configFactory->get('liberty_claims_email.settings');
    $module = 'liberty_claims';
    $to = $config->get('email_send');
    $langcode = 'es';
    $send = true;

    $result = $this->mailManager->mail($module, 'send_email', $to, $langcode, $params, null, $send);

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }

  /**
   * Send notificacion error email for SIPO.
   * @param array $data
   * @param string $data_taller
   * @return JsonResponse
   */
  public function sendEmailErrorSipo($data, $data_taller): JsonResponse {
    $date = date('d/m/Y');

    $subject = 'Error creación siniestro SIPO - #' . $data['caso']['numeroSiniestroiAxis'];

    $body = "Buen día,
        Al momento de crear el siniestro en SIPO, el flujo de asegurado presentó un error." .
    " La información relevante para su creación manual es:
        Número de caso de Iaxis: {$data['caso']['numeroSiniestroiAxis']}
        Datos del asegurado: {$data['asegurado']['nombre']}
        Placa: {$data['vehiculo']['placa']}
        Taller Escogido:  {$data_taller}
        Fecha de creación del siniestro: {$date}
        Número Celular: {$data['asegurado']['celular']}
        Correo: {$data['asegurado']['email']}
        Fecha siniestro: {$data['caso']['fechaSiniestro']}
        Enviado desde el portal Liberty Seguros Colombia";

    $params = [
      'subject2' => $subject,
      'subject' => 'Error radicacion Sipo',
      'message' => nl2br($body),
    ];

    $config = $this->configFactory->get('liberty_claims_email.settings');
    $module = 'liberty_claims';
    $to = $config->get('email_send');
    $langcode = 'es';
    $send = true;

    $result = $this->mailManager->mail($module, 'send_email', $to, $langcode, $params, null, $send);

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }
}
