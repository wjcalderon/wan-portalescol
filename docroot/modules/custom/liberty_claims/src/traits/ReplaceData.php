<?php

namespace Drupal\liberty_claims\traits;

trait ReplaceData
{
  private function replaceBasicData ($data, $source): array|string
  {
    $lastnameExploded = explode(' ', $source['lastname']);
    $nameExploded = explode(' ', $source['name']);
    $dateExploded = explode(' ', $source['date']);

    $replacements = [
      '_#@_lastname' => $lastnameExploded[0] ?? $source['lastname'],
      '_#@_firstname' => $nameExploded[0] ?? $source['name'],
      '_#@_secondlastname' => $lastnameExploded[1] ?? $source['lastname'],
      '_#@_secondname' => $nameExploded[1] ?? $source['name'],
      '_#@_claimdate' => date('d/m/Y', strtotime($dateExploded[0])),
    ];

    foreach ($replacements as $key => $value) {
      $data = str_replace($key, $value, $data);
    }

    $replacements = [
      '_#@_currentday' => date('d/m/Y'),
      '_#@_time' => date('H:i', strtotime($source['date'])),
      '_#@_city' => (int)substr($source['city'], 2, 3),
      '_#@_provcode' => substr($source['city'], 0, 2),
    ];

    foreach ($replacements as $key => $value) {
      $data = str_replace($key, $value, $data);
    }

    $replacements = [
      '_#@_wherename' => trim(\explode(' ', $source['whereAddress'])[1] ?? $source['whereAddress']),
      '_#@_withMoreInjureddesc' => $source['casualties'] === 'more' ? 'si' : 'no',
      '_#@_withMoreInjuredval' => $source['casualties'] === 'more' ? 1 : 0,
      '_#@_withMoreDeathsdesc' => $source['deaths'] === 'more' ? 'si' : 'no',
      '_#@_withMoreDeathsval' => $source['deaths'] === 'more' ? 1 : 0,
      '_#@_withInjureddesc' => $source['withInjured'] ? 'si' : 'no',
      '_#@_withInjuredval' => $source['withInjured'] ? 1 : 0,
      '_#@_withDeathsdesc' => $source['withDeaths'] ? 'si' : 'no',
      '_#@_withDeathsval' => $source['withDeaths'] ? 1 : 0,
      '_#@_withPolicedesc' => $source['withPolice'] ? 'si' : 'no',
      '_#@_withPoliceval' => $source['withPolice'] ? 1 : 2,
      '_#@_description' => wordwrap(trim($source['description']), 50, "\n\r"),
      '_#@_previusPolicy' => $source['previusPolicy'],
    ];

    foreach ($replacements as $key => $value) {
      $data = str_replace($key, $value, $data);
    }

    return $data;
  }

  private function damages($source): array
  {
    $damages = [];
    $damage_labels = [
      'Sección delantera',
      'Lateral delantero izquierdo',
      'Lateral delantero derecho',
      'Lateral trasero izquierdo',
      'Lateral trasero derecho',
      'Sección posterior',
      'Techo',
      'Por debajo',
    ];

    foreach ($source['damages'] as $key) {
      $damages[] = [
        'numeroRespuestaAPreguntaAsociadaAGarantia' => $key + 1,
        'descripcionRespuestaAPreguntaAsociadaAGarantia' => $damage_labels[$key],
      ];
    }

    return $damages;
  }

  private function withDeathsInjuries ($source): array {
    $codigoGarantia = [];
    $rc1 = (int)$source['guarantees']['rc1'];
    $withInjured = $source['withInjured'];
    $casualties = $source['casualties'];
    $deaths = $source['deaths'];
    $withDeaths = $source['withDeaths'];

    $condition1 = $withInjured && $casualties === 1 && $deaths !== 'more';
    $condition2 = $withDeaths && $deaths === 1 && $casualties !== 'more';

    if ($rc1 && ($condition1 || $condition2)) {
      $codigoGarantia = [
        'codigoGarantia' => $rc1,
      ];
    } elseif ((int)$source['guarantees']['rc3']) {
      $codigoGarantia = [
        'codigoGarantia' => (int)$source['guarantees']['rc3'],
      ];
    }

    return $codigoGarantia;
  }

  private function withInvolved ($source): array {
    $preguntasExtraGarantia = [];

    if ($source['withInvolved']) {
      $keys = [
        'plateThirdPartyInvolved',
        'plateThirdPartyInvolvedName',
        'plateThirdPartyInvolvedTypeIdentificaction',
        'plateThirdPartyInvolvedIdentificaction',
      ];

      foreach ($keys as $index => $key) {
        $questionNumber = 7826 + $index;

        $pregunta = [
          'preguntaAsociadaAGarantia' => [
            'descripcionPregunta' => $index === 0
              ? 'HUBO TERCERO INVOLUCRADO EN EL SINIESTRO'
              : ucwords(str_replace('plateThirdPartyInvolved', '', $key)),
            'numeroPregunta' => $questionNumber,
          ],
          'respuestasAPreguntasAsociadasAGarantia' => [
            [
              'descripcionRespuestaAPreguntaAsociadaAGarantia' => $source[$key],
              'numeroRespuestaAPreguntaAsociadaAGarantia' => '0',
            ],
          ],
        ];
        $preguntasExtraGarantia[] = $pregunta;
      }
    } else {
      $preguntas = [
        "HUBO TERCERO INVOLUCRADO EN EL SINIESTRO",
        "PLACA",
        "NOMBRE TERCER INVOLUCRADO",
        "TIPO IDENTIFICACION TERCERO",
        "NUMERO IDENTIFICACION TERCERO",
      ];

      foreach ($preguntas as $index => $pregunta) {
        $preguntasExtraGarantia[] = [
          "preguntaAsociadaAGarantia" => [
            "descripcionPregunta" => $pregunta,
            "numeroPregunta" => 7825 + $index,
          ],
          "respuestasAPreguntasAsociadasAGarantia" => [
            [
              "descripcionRespuestaAPreguntaAsociadaAGarantia" => "NO",
              "numeroRespuestaAPreguntaAsociadaAGarantia" => "0",
            ],
          ],
        ];
      }
    }

    return $preguntasExtraGarantia;
  }
}
