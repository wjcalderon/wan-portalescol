<?php
<<<<<<< HEAD
/**
 * Created by PhpStorm.
 * User: esinergia1
 * Date: 6/5/19
 * Time: 3:23 PM
 */

namespace Drupal\lib_quoting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\lib_quoting\Controller\QuotingApi;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Dompdf\Dompdf;
use Dompdf\Options;

class GeneratePDF extends ControllerBase {

=======

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
>>>>>>> main
  public function generate() {

    $data = \Drupal::request()->request->all();
    if (count($data) == 0) {
      return new RedirectResponse('/cotiza-en-linea/cotizador-autos');
    }
    $counter = rand(10000, 50000);

    $vid = 'policy';
<<<<<<< HEAD
    $terms =\Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vid, 0, null, true);
=======
    $terms = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vid, 0, NULL, TRUE);
>>>>>>> main

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
<<<<<<< HEAD
    $options->setIsRemoteEnabled(true);
    $options->setIsHtml5ParserEnabled(true);
    $options->setIsJavascriptEnabled(false);
    $options->set('tempDir', '/tmp');

// echo $html;
// die();
=======
    $options->setIsRemoteEnabled(TRUE);
    $options->setIsHtml5ParserEnabled(TRUE);
    $options->setIsJavascriptEnabled(FALSE);
    $options->set('tempDir', '/tmp');

    // Echo $html;
    // die();
>>>>>>> main
    $dompdf = new Dompdf($options);

    $contxt = \stream_context_create([
      'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
<<<<<<< HEAD
        'allow_self_signed'=> TRUE
      ]
=======
        'allow_self_signed' => TRUE,
      ],
>>>>>>> main
    ]);
    $dompdf->setHttpContext($contxt);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter', 'portrait');
    $dompdf->render();
    $date = date('d-m-Y');
<<<<<<< HEAD
    $dompdf->stream('poliza-' . $date .'.pdf');
    exit();
    return true;
  }
=======
    $dompdf->stream('poliza-' . $date . '.pdf');
    exit();
    return TRUE;
  }

>>>>>>> main
}
