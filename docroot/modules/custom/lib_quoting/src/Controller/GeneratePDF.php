<?php

namespace Drupal\lib_quoting\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class GeneratePDF.
 */
class GeneratePDF extends ControllerBase {

  /**
   * Create PDF.
   */
  public function generate() {

    $data = \Drupal::request()->request->all();
    if (count($data) == 0) {
      return new RedirectResponse('/cotiza-en-linea/cotizador-autos');
    }
    $counter = rand(10000, 50000);

    $vid = 'policy';
    $terms = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vid, 0, NULL, TRUE);

    $build = [
      '#theme' => 'quote_pdf',
      '#quotation' => $counter,
      '#protections' => $terms,
      '#data' => $data,
      '#from' => date('Y-m-d', time()),
      '#host' => \Drupal::request()->getSchemeAndHttpHost(),
      '#to' => date('Y-m-d', time() + (86400 * 30)),
    ];

    $html = \Drupal::service('renderer')->render($build);

    $options = new Options();
    $options->setIsRemoteEnabled(TRUE);
    $options->setIsHtml5ParserEnabled(TRUE);
    $options->setIsJavascriptEnabled(FALSE);
    $options->set('tempDir', '/tmp');

    // Echo $html;
    // die();
    $dompdf = new Dompdf($options);

    $contxt = \stream_context_create([
      'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed' => TRUE,
      ],
    ]);
    $dompdf->setHttpContext($contxt);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter', 'portrait');
    $dompdf->render();
    $date = date('d-m-Y');
    $dompdf->stream('poliza-' . $date . '.pdf');
    exit();
    return TRUE;
  }

}
