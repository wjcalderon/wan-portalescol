<?php

namespace Drupal\liberty_claims\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * DownloadPdfController class.
 */
class DownloadPdfController extends ControllerBase {

  /**
   * Download controller.
   *
   * @param Symfony\Component\HttpFoundation\Request $request
   *   Page request object.
   * @param int $number
   *   The claim id.
   */
  public function download(Request $request, $number) {
    global $base_root, $base_path;

    $data = json_decode($request->getContent(), TRUE);
    $build = [
      '#theme' => 'download_pdf',
      '#data' => [
        'url' => $base_root . $base_path . drupal_get_path('module', 'liberty_claims'),
        'number' => $number,
        'radicate_date' => date('d / m / Y'),
        'year' => date('Y'),
      ] + $data,
    ];

    $html = \Drupal::service('renderer')->render($build);

    $options = new Options();
    $options->setIsRemoteEnabled(TRUE);
    $options->setIsPhpEnabled(TRUE);
    $options->setIsHtml5ParserEnabled(FALSE);
    $options->setIsJavascriptEnabled(FALSE);
    $options->setTempDir('/tmp');

    $dompdf = new Dompdf($options);

    $contxt = \stream_context_create([
      'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed' => TRUE,
      ]
    ]);
    $dompdf->setHttpContext($contxt);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter', 'portrait');
    $dompdf->render();
    $dompdf->stream('Report.pdf', ["Attachment" => TRUE]);
    exit();
  }
}