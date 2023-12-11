<?php

namespace Drupal\lib_core\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\lib_core\Controller\LibCoreController;

/**
 * Pqr form.
 */
class PqrForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'pqr_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // $form['#action'] =
    // 'https://webto.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8';
    $config = \Drupal::config('lib_core.environmentvars.settings');

    $orgid = '00D0t0000008cUH';
    $pqr = '00N0t000000fmGY';
    $case_number = '00N0t000000f5zQ';
    $names = '00N0t000000f5xA';
    $product = '00n4a00000fkil2';

    if ($_ENV['AH_SITE_ENVIRONMENT'] == 'prod') {
      // Prod <input type=hidden name="orgid" value="00DA0000000AD5W">.
      $orgid = '00DA0000000AD5W';
      $pqr = $config->get('PQRRegistroWebToCase') ?? '';
      $case_number = '00n4a00000fkikp';
      $names = '00n4a00000fkiko';
      $product = '00N4A00000FkiL2';
      $lgtbi = '00n05000000y1hp';
    }
    else {
      // Staging <input type=hidden name="orgid" value="00D040000004eAH">.
      $orgid = $config->get('ENDPOINT_ORGID') ?? '';
      // $orgid = '00D040000004eAH';
      $pqr = $config->get('PQRRegistroWebToCase') ?? '';
      $case_number = '00n4a00000fkikp';
      $names = '00n4a00000fkiko';
      $product = '00N4A00000FkiL2';
      // $lgtbi = '00N04000000j8M3';
      $lgtbi = '00n05000000y1hp';

    }

    $form['#attached']['library'][] = 'lib_core/pqr_version_new';
    $form['#attributes']['cdtype-form'] = 'insured';
    $form['#attributes']['class'] = ['form-ctn-notif-sinister'];

    $form['title'] = [
      '#prefix' => '<h2>',
      '#suffix' => '</h2>',
      '#markup' => 'Escribe tu queja o reclamo',
    ];

    // Hidden fields.
    $form['orgid'] = [
      '#type' => 'hidden',
      '#name' => 'orgid',
      '#value' => $orgid,
    ];

    // Entidad vigilada.
    $form['00N04000000j8M2'] = [
      '#type' => 'hidden',
      '#name' => '00N04000000j8M2',
      '#value' => 'Entidad vigilada',
    ];

    // Entidad vigilada.
    $form['00N04000000j8Ly'] = [
      '#type' => 'hidden',
      '#name' => '00N04000000j8Ly',
      '#value' => 'Internet',
    ];

    // Entidad vigilada.
    $form['00N04000000jZQi'] = [
      '#type' => 'hidden',
      '#name' => '00N04000000jZQi',
      '#value' => 'Pendiente Creación',
    ];

    if ($_ENV['AH_SITE_ENVIRONMENT'] != 'prod') {
      // Test.
      $form['debug'] = [
        '#type' => 'hidden',
        '#value' => 1,
        '#name' => 'debug',
      ];

      $form['debugEmail'] = [
        '#type' => 'hidden',
            // '#value' => 'lmacea@avanxo.com',
        '#value' => 'katiuska.lacruz@liberty.cl',
        '#name' => 'debugEmail',
      ];
      // ------- Fin test ----------
    }

    $form[$pqr] = [
      '#type' => 'hidden',
      '#name' => $pqr,
      '#value' => 'PQR',
      '#attributes' => [
        'id' => $pqr,
      ],
    ];

    $form['00N4A00000G91wx'] = [
      '#type' => 'hidden',
      '#name' => '00N4A00000G91wx',
      '#value' => 'COLOMBIA',
    ];

    global $base_url;
    $current_path = \Drupal::service('path.current')->getPath();
    $current_alias = \Drupal::service('path_alias.manager')->getAliasByPath(
          $current_path
      );
    $retURL = $base_url . $current_alias . '?resp=1';
    $form['retURL'] = [
      '#type' => 'hidden',
      '#name' => 'retURL',
      '#value' => $retURL,
    ];

    $form['00N04000000j8M2'] = [
      '#type' => 'hidden',
      '#name' => '00N04000000j8M2',
      '#value' => 'Entidad vigilada',
    ];

    $form['00N04000000j8Ly'] = [
      '#type' => 'hidden',
      '#name' => '00N04000000j8Ly',
      '#value' => 'Internet',
    ];

    $form['00N04000000jZQi'] = [
      '#type' => 'hidden',
      '#name' => '00N04000000jZQi',
      '#value' => 'Pendiente Creación',
    ];

    // Identification type.
    $form['pais'] = [
      '#type' => 'select',
      '#title' => 'País del evento',
      '#name' => 'pais',
      '#options' => [
        'Andorra' => 'Andorra',
        'Emiratos Árabes Unidos' => 'Emiratos Árabes Unidos',
        'Afganistán' => 'Afganistán',
        'Antigua y Barbuda' => 'Antigua y Barbuda',
        'Anguila' => 'Anguila',
        'Albania' => 'Albania',
        'Armenia' => 'Armenia',
        'Antillas Neerlandesas' => 'Antillas Neerlandesas',
        'Angola' => 'Angola',
        'Antártida' => 'Antártida',
        'Argentina' => 'Argentina',
        'Samoa Americana' => 'Samoa Americana',
        'Austria' => 'Austria',
        'Australia' => 'Australia',
        'Aruba' => 'Aruba',
        'Islas Áland' => 'Islas Áland',
        'Azerbaiyán' => 'Azerbaiyán',
        'Bosnia y Herzegovina' => 'Bosnia y Herzegovina',
        'Barbados' => 'Barbados',
        'Bangladesh' => 'Bangladesh',
        'Bélgica' => 'Bélgica',
        'Burkina Faso' => 'Burkina Faso',
        'Bulgaria' => 'Bulgaria',
        'Bahréin' => 'Bahréin',
        'Burundi' => 'Burundi',
        'Benin' => 'Benin',
        'San Bartolomé' => 'San Bartolomé',
        'Bermudas' => 'Bermudas',
        'Brunéi' => 'Brunéi',
        'Bolivia' => 'Bolivia',
        'Brasil' => 'Brasil',
        'Bahamas' => 'Bahamas',
        'Bhután' => 'Bhután',
        'Isla Bouvet' => 'Isla Bouvet',
        'Botsuana' => 'Botsuana',
        'Belarús' => 'Belarús',
        'Belice' => 'Belice',
        'Canadá' => 'Canadá',
        'Islas Cocos' => 'Islas Cocos',
        'República Centro-Africana' => 'República Centro-Africana',
        'Congo' => 'Congo',
        'Suiza' => 'Suiza',
        'Costa de Marfil' => 'Costa de Marfil',
        'Islas Cook' => 'Islas Cook',
        'Chile' => 'Chile',
        'Camerún' => 'Camerún',
        'China' => 'China',
        'Colombia' => 'Colombia',
        'Costa Rica' => 'Costa Rica',
        'Cuba' => 'Cuba',
        'Cabo Verde' => 'Cabo Verde',
        'Islas Christmas' => 'Islas Christmas',
        'Chipre' => 'Chipre',
        'República Checa' => 'República Checa',
        'Alemania' => 'Alemania',
        'Yibuti' => 'Yibuti',
        'Dinamarca' => 'Dinamarca',
        'Domínica' => 'Domínica',
        'República Dominicana' => 'República Dominicana',
        'Argel' => 'Argel',
        'Ecuador' => 'Ecuador',
        'Estonia' => 'Estonia',
        'Egipto' => 'Egipto',
        'Sahara Occidental' => 'Sahara Occidental',
        'Eritrea' => 'Eritrea',
        'España' => 'España',
        'Etiopía' => 'Etiopía',
        'Finlandia' => 'Finlandia',
        'Fiji' => 'Fiji',
        'Islas Malvinas' => 'Islas Malvinas',
        'Micronesia' => 'Micronesia',
        'Islas Faroe' => 'Islas Faroe',
        'Francia' => 'Francia',
        'Gabón' => 'Gabón',
        'Reino Unido' => 'Reino Unido',
        'Granada' => 'Granada',
        'Georgia' => 'Georgia',
        'Guayana Francesa' => 'Guayana Francesa',
        'Guernsey' => 'Guernsey',
        'Ghana' => 'Ghana',
        'Gibraltar' => 'Gibraltar',
        'Groenlandia' => 'Groenlandia',
        'Gambia' => 'Gambia',
        'Guinea' => 'Guinea',
        'Guadalupe' => 'Guadalupe',
        'Guinea Ecuatorial' => 'Guinea Ecuatorial',
        'Grecia' => 'Grecia',
        'Georgia del Sur e Islas Sandwich del Sur' => 'Georgia del Sur e Islas Sandwich del Sur',
        'Guatemala' => 'Guatemala',
        'Guam' => 'Guam',
        'Guinea-Bissau' => 'Guinea-Bissau',
        'Guayana' => 'Guayana',
        'Hong Kong' => 'Hong Kong',
        'Islas Heard y McDonald' => 'Islas Heard y McDonald',
        'Honduras' => 'Honduras',
        'Croacia' => 'Croacia',
        'Haití' => 'Haití',
        'Hungría' => 'Hungría',
        'Indonesia' => 'Indonesia',
        'Irlanda' => 'Irlanda',
        'Israel' => 'Israel',
        'Isla de Man' => 'Isla de Man',
        'India' => 'India',
        'Territorio Británico del Océano Índico' => 'Territorio Británico del Océano Índico',
        'Irak' => 'Irak',
        'Irán' => 'Irán',
        'Islandia' => 'Islandia',
        'Italia' => 'Italia',
        'Jersey' => 'Jersey',
        'Jamaica' => 'Jamaica',
        'Jordania' => 'Jordania',
        'Japón' => 'Japón',
        'Kenia' => 'Kenia',
        'Kirguistán' => 'Kirguistán',
        'Camboya' => 'Camboya',
        'Kiribati' => 'Kiribati',
        'Comoros' => 'Comoros',
        'San Cristóbal y Nieves' => 'San Cristóbal y Nieves',
        'Corea del Norte' => 'Corea del Norte',
        'Corea del Sur' => 'Corea del Sur',
        'Kuwait' => 'Kuwait',
        'Islas Caimán' => 'Islas Caimán',
        'Kazajstán' => 'Kazajstán',
        'Laos' => 'Laos',
        'Líbano' => 'Líbano',
        'Santa Lucía' => 'Santa Lucía',
        'Liechtenstein' => 'Liechtenstein',
        'Sri Lanka' => 'Sri Lanka',
        'Liberia' => 'Liberia',
        'Lesotho' => 'Lesotho',
        'Lituania' => 'Lituania',
        'Luxemburgo' => 'Luxemburgo',
        'Letonia' => 'Letonia',
        'Libia' => 'Libia',
        'Marruecos' => 'Marruecos',
        'Mónaco' => 'Mónaco',
        'Moldova' => 'Moldova',
        'Montenegro' => 'Montenegro',
        'Madagascar' => 'Madagascar',
        'Islas Marshall' => 'Islas Marshall',
        'Macedonia' => 'Macedonia',
        'Mali' => 'Mali',
        'Myanmar' => 'Myanmar',
        'Mongolia' => 'Mongolia',
        'Macao' => 'Macao',
        'Martinica' => 'Martinica',
        'Mauritania' => 'Mauritania',
        'Montserrat' => 'Montserrat',
        'Malta' => 'Malta',
        'Mauricio' => 'Mauricio',
        'Maldivas' => 'Maldivas',
        'Malawi' => 'Malawi',
        'México' => 'México',
        'Malasia' => 'Malasia',
        'Mozambique' => 'Mozambique',
        'Namibia' => 'Namibia',
        'Nueva Caledonia' => 'Nueva Caledonia',
        'Níger' => 'Níger',
        'Islas Norkfolk' => 'Islas Norkfolk',
        'Nigeria' => 'Nigeria',
        'Nicaragua' => 'Nicaragua',
        'Países Bajos' => 'Países Bajos',
        'Noruega' => 'Noruega',
        'Nepal' => 'Nepal',
        'Nauru' => 'Nauru',
        'Niue' => 'Niue',
        'Nueva Zelanda' => 'Nueva Zelanda',
        'Omán' => 'Omán',
        'Panamá' => 'Panamá',
        'Perú' => 'Perú',
        'Polinesia Francesa' => 'Polinesia Francesa',
        'Papúa Nueva Guinea' => 'Papúa Nueva Guinea',
        'Filipinas' => 'Filipinas',
        'Pakistán' => 'Pakistán',
        'Polonia' => 'Polonia',
        'San Pedro y Miquelón' => 'San Pedro y Miquelón',
        'Islas Pitcairn' => 'Islas Pitcairn',
        'Puerto Rico' => 'Puerto Rico',
        'Palestina' => 'Palestina',
        'Portugal' => 'Portugal',
        'Islas Palaos' => 'Islas Palaos',
        'Paraguay' => 'Paraguay',
        'Qatar' => 'Qatar',
        'Reunión' => 'Reunión',
        'Rumanía' => 'Rumanía',
        'Serbia y Montenegro' => 'Serbia y Montenegro',
        'Rusia' => 'Rusia',
        'Ruanda' => 'Ruanda',
        'Arabia Saudita' => 'Arabia Saudita',
        'Islas Solomón' => 'Islas Solomón',
        'Seychelles' => 'Seychelles',
        'Sudán' => 'Sudán',
        'Suecia' => 'Suecia',
        'Singapur' => 'Singapur',
        'Santa Elena' => 'Santa Elena',
        'Eslovenia' => 'Eslovenia',
        'Islas Svalbard y Jan Mayen' => 'Islas Svalbard y Jan Mayen',
        'Eslovaquia' => 'Eslovaquia',
        'Sierra Leona' => 'Sierra Leona',
        'San Marino' => 'San Marino',
        'Senegal' => 'Senegal',
        'Somalia' => 'Somalia',
        'Surinam' => 'Surinam',
        'Santo Tomé y Príncipe' => 'Santo Tomé y Príncipe',
        'El Salvador' => 'El Salvador',
        'Siria' => 'Siria',
        'Suazilandia' => 'Suazilandia',
        'Islas Turcas y Caicos' => 'Islas Turcas y Caicos',
        'Chad' => 'Chad',
        'Territorios Australes Franceses' => 'Territorios Australes Franceses',
        'Togo' => 'Togo',
        'Tailandia' => 'Tailandia',
        'Tanzania' => 'Tanzania',
        'Tayikistán' => 'Tayikistán',
        'Tokelau' => 'Tokelau',
        'Timor-Leste' => 'Timor-Leste',
        'Turkmenistán' => 'Turkmenistán',
        'Túnez' => 'Túnez',
        'Tonga' => 'Tonga',
        'Turquía' => 'Turquía',
        'Trinidad y Tobago' => 'Trinidad y Tobago',
        'Tuvalu' => 'Tuvalu',
        'Taiwán' => 'Taiwán',
        'Ucrania' => 'Ucrania',
        'Uganda' => 'Uganda',
        'Estados Unidos de América' => 'Estados Unidos de América',
        'Uruguay' => 'Uruguay',
        'Uzbekistán' => 'Uzbekistán',
        'Ciudad del Vaticano' => 'Ciudad del Vaticano',
        'San Vicente y las Granadinas' => 'San Vicente y las Granadinas',
        'Venezuela' => 'Venezuela',
        'Islas Vírgenes Británicas' => 'Islas Vírgenes Británicas',
        'Islas Vírgenes de los Estados Unidos de América' => 'Islas Vírgenes de los Estados Unidos de América',
        'Vietnam' => 'Vietnam',
        'Vanuatu' => 'Vanuatu',
        'Wallis y Futuna' => 'Wallis y Futuna',
        'Samoa' => 'Samoa',
        'Yemen' => 'Yemen',
        'Mayotte' => 'Mayotte',
        'Sudáfrica' => 'Sudáfrica',
      ],
      '#required' => TRUE,
      '#default_value' => 'Colombia',
      '#attributes' => [
        'id' => 'pais',
        'class' => ['form__input--activo'],
      ],
    ];

    // Reconsideration.
    $form['00ng000000fwyn9'] = [
      '#type' => 'select',
      '#title' => '¿Este caso es una reconsideración?',
      '#name' => '00ng000000fwyn9',
      '#options' => [
        'NO' => 'No',
        'SI' => 'Si',
      ],
      '#required' => TRUE,
      '#attributes' => [
        'id' => '00ng000000fwyn9',
      ],
    ];

    // Case number.
    $form[$case_number] = [
      '#type' => 'textfield',
      '#title' => 'Número de caso',
      '#name' => $case_number,
      '#attributes' => [
        'id' => $case_number,
      ],
    ];

    // Names - lastnames.
    $form[$names] = [
      '#type' => 'textfield',
      '#title' => 'Nombres y Apellidos',
      '#name' => $names,
      '#required' => TRUE,
      '#attributes' => [
        'id' => $names,
      ],
    ];

    // Identification type.
    $form['00ng000000fwyow'] = [
      '#type' => 'select',
      '#title' => 'Tipo de identificación',
      '#name' => '00ng000000fwyow',
      '#options' => [
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Cédula de Extranjería' => 'Cédula de Extranjería',
        'NIT' => 'NIT',
        'NUIP' => 'NUIP',
        'Pasaporte' => 'Pasaporte',
        'Registro Civil' => 'Registro Civil',
        'Tarjeta de Identidad' => 'Tarjeta de Identidad',
        'No Válido' => 'No Válido',
        'Carnet Diplomático' => 'Carnet Diplomático',
        'Permiso de proteccion temporal PPT' => 'Permiso de protección temporal PPT',
      ],
      '#required' => TRUE,
      '#attributes' => [
        'id' => '00ng000000fwyow',
      ],
    ];

    // Identification number.
    $form['00ng000000fwyoi'] = [
      '#type' => 'textfield',
      '#title' => 'Número de identificación',
      '#name' => '00ng000000fwyoi',
      '#required' => TRUE,
      '#maxlength' => 12,
      '#attributes' => [
        'id' => '00ng000000fwyoi',
      ],
    ];

    // Mail.
    $form['mail'] = [
      '#type' => 'textfield',
      '#title' => 'Correo electrónico',
      '#name' => 'mail',
      '#required' => TRUE,
      '#attributes' => [
        'id' => 'mail',
      ],
    ];

    // City.
    $libCoreController = new LibCoreController();
    $opts_cities = $libCoreController->sinistersCitiesSelect();
    $form['step1']['ins_veh_info']['00ng000000fwynf'] = [
      '#type' => 'select',
      '#title' => 'Ciudad y departamento de reparación',
      '#options' => $opts_cities,
      '#name' => '00ng000000fwynf',
      '#attributes' => [
        'id' => '00ng000000fwynf',
      ],
    ];

    // Address if.
    $form['00ng000000fwynx'] = [
      '#type' => 'textfield',
      '#title' => 'Dirección',
      '#name' => '00ng000000fwynx',
      '#required' => TRUE,
      '#attributes' => [
        'id' => '00ng000000fwynx',
      ],
    ];

    // Telephone fixed.
    $form['00NG000000FWyoU'] = [
      '#type' => 'textfield',
      '#title' => 'Telefono fijo contacto',
      '#name' => '00NG000000FWyoU',
      '#maxlength' => 10,
      '#attributes' => [
        'id' => '00NG000000FWyoU',
      ],
    ];

    // Cellphone.
    $form['00NG000000FWynB'] = [
      '#type' => 'textfield',
      '#title' => 'Celular contacto',
      '#name' => '00NG000000FWynB',
      '#required' => TRUE,
      '#maxlength' => 10,
      '#attributes' => [
        'id' => '00NG000000FWynB',
      ],
    ];

    // Gender.
    $form['00n05000000xuss'] = [
      '#type' => 'select',
      '#title' => 'Género',
      '#name' => '00n05000000xuss',
      '#options' => [
        'Masculino' => 'Masculino',
        'Femenino' => 'Femenino',
        'Trans' => 'Trans',
        'No Binario' => 'No Binario',
        'No aplica' => 'No aplica',
      ],
      '#required' => TRUE,
      '#attributes' => [
        'id' => '00n05000000xuss',
      ],
    ];

    // Terms and conditions.
    $form['00n05000001ccds'] = [
      '#type' => 'checkbox',
      '#title' => 'Aceptas el <span class="title_terms "><u>tratamiento y uso de datos sensibles.</u></span>',
      '#name' => '00n05000001ccds',
      '#attributes' => [
        'id' => '00n05000001ccds',
        'class' => ['terms_checkbox'],
      ],
    ];

    // Modal.
    $form['modal'] = [
      '#prefix' => '
            <div class="terms-modal-wrap">
                <div class="terms-modal-overlay">
                    <div class="terms-modal-box">
                        <div class="terms-modal-close">Cerrar</div>
                        <div class="accordion-term">
                            <h3>Tratamiento y uso de datos sensibles</h3>
                            <p class="text-modal">Autorizo a <strong>Liberty Seguros S.A. y La Libertad Compañía de Servicios e Inversiones SAS (Las Compañías)</strong> el uso de mi información personal y sensible para efectos relacionados con la atención de mi reclamación. Declaro que he sido informado de la existencia de las Políticas de Tratamiento de datos personales, las cuales se encuentran publicadas en <strong>www.libertycolombia.com.co</strong> y también pueden ser solicitadas a <strong>atencionalcliente@libertycolombia.com</strong> o al teléfono <strong>57 1 307 7050</strong> de Bogotá.</p>
                        </div><br>
                        <div class="container-buttons">
                            <span id="modal_acept_terms">Aceptar términos y condiciones</span>
                        </div>
                    </div>
                </div>
            </div>
            ',
      '#suffix' => '',
      '#attributes' => [
        'id' => 'modal',
      ],
    ];

    // Separator.
    $form['separator'] = [
      '#prefix' => '<hr>',
      '#suffix' => '',
      '#attributes' => [
        'id' => 'separator',
      ],
    ];

    // LGBTI.
    $form[$lgtbi] = [
      '#type' => 'radios',
      '#title' => '¿Perteneces a la comunidad LGBTIQ+<div class="tooltip top">?<span class="tiptext">Lesbiana, Gay, Transgénero, Transexual,
            Travesti, Intersexual y Queer y todos los colectivos que no están representados en las siglas anteriores</span></div>',
      '#options' => [
        'true' => 'Si',
        'false' => 'No',
      ],
      '#name' => $lgtbi,
      '#attributes' => [
        'id' => $lgtbi,
        'class' => ['itemsLg'],
      ],
    ];

    // Separator.
    $form['separator2'] = [
      '#type' => 'markup',
      '#markup' => '<hr class="separador is-hidden"/>',
    ];

    // Gender.
    $form['cond_especial'] = [
      '#type' => 'select',
      '#title' => '¿Tienes alguna condición especial?',
      '#name' => 'cond_especial',
      '#options' => [
        '' => '- Seleccionar -',
        'NO' => 'No',
        'SI' => 'Si',
      ],
      '#attributes' => [
        'id' => 'cond_especial',
      ],
    ];

    // Special condition.
    $form['00n05000000y11p'] = [
      '#type' => 'select',
      '#title' => 'Condición Especial',
      '#name' => '00n05000000y11p',
      '#options' => [
        '' => '- Seleccionar -',
        'adulto mayor' => 'Adulto mayor',
        'afrocolombiano' => 'Afrocolombiano',
        'desplazado' => 'Desplazado',
        'discapacidad auditiva' => 'Discapacidad auditiva',
        'discapacidad cognitiva' => 'Discapacidad cognitiva',
        'discapacidad física' => 'Discapacidad física',
        'discapacidad visual' => 'Discapacidad visual',
        'indígena' => 'Indígena',
        'madre cabeza de familia' => 'Madre cabeza de familia',
        'menor de edad' => 'Menor de edad',
        'mujer embarazada' => 'Mujer embarazada',
        'no aplica' => 'No aplica',
        'otra' => 'Otra',
        'pensionado' => 'Pensionado',
        'periodista' => 'Periodista',
        'receptor de subsidio' => 'Receptor de subsidio',
        'reinsertado' => 'Reinsertado',
        'sordomudo' => 'Sordomudo',
        'víctima del conflicto armado' => 'Víctima del conflicto armado',
      ],
      '#attributes' => [
        'id' => '00n05000000y11p',
        'class' => ['condEspecial'],
      ],
    ];

    // Description.
    $form['description'] = [
      '#type' => 'textarea',
      '#title' => 'Descripción',
      '#name' => 'description',
    ];

    // Product.
    $form[$product] = [
      '#type' => 'select',
      '#title' => 'Producto',
      '#name' => $product,
      '#options' => [
        'VIDA GRUPO' => 'VIDA GRUPO',
        'AUTOS' => 'AUTOS',
        'ARL' => 'ARL',
        'GENERALES' => 'GENERALES',
        'SALUD' => 'SALUD',
        'SOAT' => 'SOAT',
        'FIANZAS' => 'FIANZAS',
        'VIDA R.M.' => 'VIDA R.M.',
      ],
      '#required' => TRUE,
      '#attributes' => [
        'id' => $product,
      ],
    ];

    // Plate.
    $form['00NG000000998UR'] = [
      '#type' => 'textfield',
      '#title' => 'Placa',
      '#name' => '00NG000000998UR',
      '#maxlength' => 6,
      '#attributes' => [
        'id' => '00NG000000998UR',
      ],
    ];

    // Reason SFC.
    $form['00n05000001bn7q'] = [
      '#type' => 'select',
      '#title' => 'Motivo SFC',
      '#name' => '00n05000001bn7q',
      '#options' => [
        'demora o no emisión de la póliza' => 'Demora o no emisión de la póliza',
        'demora en el servicio requerido para emisión de póliza' => 'Demora en el servicio requerido para emisión de póliza',
        'demora o no entrega de recibo de pago' => 'Demora o no entrega de recibo de pago',
        'error en la facturación o cobro no pactado' => 'Error en la facturación o cobro no pactado',
        'demora o no realización de modificación de financiación de póliza' => 'Demora o no realización de modificación de financiación de póliza',
        'error en modificación de financiación de póliza' => 'Error en modificación de financiación de póliza',
        'demora o no confirmación de pago' => 'Demora o no confirmación de pago',
        'demora o error en devolución de prima o aporte' => 'Demora o error en devolución de prima o aporte',
        'demora o no aplicación del recaudo' => 'Demora o no aplicación del recaudo',
        'error en la aplicación del recaudo' => 'Error en la aplicación del recaudo',
        'cambios no informados en coberturas' => 'Cambios no informados en coberturas',
        'incrementos no pactados o informados de la prima' => 'Incrementos no pactados o informados de la prima',
        'inconformidad por cobros de terceros' => 'Inconformidad por cobros de terceros',
        'cobros a póliza terminada' => 'Cobros a póliza terminada',
        'demora en atención del siniestro' => 'Demora en atención del siniestro',
        'no atención del siniestro' => 'No atención del siniestro',
        'fallas en el registro del siniestro' => 'Fallas en el registro del siniestro',
        'asesoría incorrecta o imprecisa en la atención del siniestro' => 'Asesoría incorrecta o imprecisa en la atención del siniestro',
        'demora en la definición de indemnización' => 'Demora en la definición de indemnización',
        'demora en la autorización de servicios' => 'Demora en la autorización de servicios',
        'demora en dictamen de calificación de pérdida de capacidad laboral o enfermedad grave' => 'Demora en dictamen de calificación de pérdida de capacidad laboral o enfermedad grave',
        'inconformidad con la definición, autorización, dictamen o diagnóstico' => 'Inconformidad con la definición, autorización, dictamen o diagnóstico',
        'inconformidad con el valor de indemnización o suma asegurada' => 'Inconformidad con el valor de indemnización o suma asegurada',
        'demora en el pago de la indemnización o suma asegurada' => 'Demora en el pago de la indemnización o suma asegurada',
        'demora en el pago de mesada' => 'Demora en el pago de mesada',
        'error en el pago de la indemnización o suma asegurada' => 'Error en el pago de la indemnización o suma asegurada',
        'error en el pago de la mesada' => 'Error en el pago de la mesada',
        'inconformidad con documentos exigidos para presentar reclamación' => 'Inconformidad con documentos exigidos para presentar reclamación',
        'rescisión del título sin autorización' => 'Rescisión del título sin autorización',
        'error en la nivelación de títulos' => 'Error en la nivelación de títulos',
        'fallas en la asignación de posición para sorteo' => 'Fallas en la asignación de posición para sorteo',
        'demora en la prestación del servicio' => 'Demora en la prestación del servicio',
        'no prestación del servicio' => 'No prestación del servicio',
        'inconformidad con el servicio prestado por el proveedor' => 'Inconformidad con el servicio prestado por el proveedor',
        'incumplimiento de obligaciones en prestación del servicio' => 'Incumplimiento de obligaciones en prestación del servicio',
        'mal trato por parte el proveedor' => 'Mal trato por parte el proveedor',
        'no cumplimiento con los servicios de valor agregado ofrecidos' => 'No cumplimiento con los servicios de valor agregado ofrecidos',
        'cambio de asesor' => 'Cambio de asesor',
        'demora o no modificación de la póliza' => 'Demora o no modificación de la póliza',
        'error en la modificación de la póliza' => 'Error en la modificación de la póliza',
        'póliza terminada sin justificación' => 'Póliza terminada sin justificación',
        'no devolución de contragarantías' => 'No devolución de contragarantías',
        'error en la emisión de la póliza' => 'Error en la emisión de la póliza',
        'envío erroneo de cobro o factura' => 'Envío erroneo de cobro o factura',
        'demora o no cancelación de la póliza' => 'Demora o no cancelación de la póliza',
        'emisión poliza de la seriedad de la candidatura' => 'Emisión poliza de la seriedad de la candidatura',
        'otros motivos' => 'Otros motivos',
        'publicidad engañosa' => 'Publicidad engañosa',
        'dificultad en el acceso a la información' => 'Dificultad en el acceso a la información',
        'información o asesoría incompleta y/o errada' => 'Información o asesoría incompleta y/o errada',
        'información inoportuna' => 'Información inoportuna',
        'dificultad en la comunicación con la entidad' => 'Dificultad en la comunicación con la entidad',
        'mal trato por parte de un funcionario' => 'Mal trato por parte de un funcionario',
        'mal trato por parte del asesor comercial o proveedor' => 'Mal trato por parte del asesor comercial o proveedor',
        'presunta actuación fraudulenta o no ética del personal' => 'Presunta actuación fraudulenta o no ética del personal',
        'incumplimiento de los términos del contrato' => 'Incumplimiento de los términos del contrato',
        'presunta suplantación de personas' => 'Presunta suplantación de personas',
        'cotización errada' => 'Cotización errada',
        'demora o no entrega de la cotización y/o simulación' => 'Demora o no entrega de la cotización y/o simulación',
        'demora o no entrega del contrato o de la póliza' => 'Demora o no entrega del contrato o de la póliza',
        'error o falta de claridad en las cláusulas del contrato o de la póliza' => 'Error o falta de claridad en las cláusulas del contrato o de la póliza',
        'diferencia del producto expedido con el solicitado o cotizado o simulado' => 'Diferencia del producto expedido con el solicitado o cotizado o simulado',
        'vinculación no autorizada' => 'Vinculación no autorizada',
        'condicionamiento a la adquisición de productos o servicios' => 'Condicionamiento a la adquisición de productos o servicios',
        'no cancelación o terminación de los productos' => 'No cancelación o terminación de los productos',
        'fallas en débito automático' => 'Fallas en débito automático',
        'demora o no modificación de datos personales' => 'Demora o no modificación de datos personales',
        'actualización equivocada de datos personales' => 'Actualización equivocada de datos personales',
        'inadecuado tratamiento de datos personales' => 'Inadecuado tratamiento de datos personales',
        'inconformidad con procesos internos de conocimiento del cliente y sarlaft' => 'Inconformidad con procesos internos de conocimiento del cliente y SARLAFT',
      ],
      '#required' => TRUE,
      '#attributes' => [
        'id' => '00n05000001bn7q',
      ],
    ];

    // Type Send.
    $form['00ng000000fwynl'] = [
      '#type' => 'select',
      '#title' => 'Medio envio',
      '#name' => '00ng000000fwynl',
      '#options' => [
        'Digital' => 'Digital',
      ],
      '#required' => TRUE,
      '#attributes' => [
        'id' => '00ng000000fwynl',
      ],
    ];

    // Adjuntar archivos.
    $form['adjuntar_archivos'] = [
      '#title' => $this->t('Adjuntar archivos'),
      '#name' => 'adjuntar_archivos',
      '#type' => 'managed_file',
      '#description' => t(
              'Máximo 1 fichero. límite de 20 MB. Tipos permitidos: pdf.'
      ),
      '#upload_location' => 'public://pqr',
      '#default_value' => NULL,
      '#upload_validators' => [
        'file_validate_extensions' => ['pdf'],
      ],
      '#required' => FALSE,
      '#attributes' => [
        'id' => 'attached_file',
        'class' => 'attached_file',
      ],
    ];

    $form['my_captcha_element'] = [
      '#type' => 'captcha',
      '#captcha_type' => 'recaptcha/reCAPTCHA',
    ];

    $form['ctn_submits'] = [
      '#prefix' => '<div class="form-item form-actions">',
      '#suffix' => '</div>',
    ];

    $form['ctn_submits']['send'] = [
      '#type' => 'submit',
      '#value' => 'Enviar',
      '#name' => 'next',
      '#attributes' => [
        'class' => ['btn-submit-step btn-next button--primary'],
        'cdtype' => 'next',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // adjuntar_archivos.
    if ($_ENV['AH_SITE_ENVIRONMENT'] == 'prod') {
      $fid = $form_state->getValue(['adjuntar_archivos', 0]);
      $form_state->setValue(['adjuntar_archivos'], $fid);
      $values = $form_state->getValues();
      $form_state->setRebuild(TRUE);
      // Post to webform and sales force.
      $coreController = new LibCoreController();
      return $coreController->webformRestPost('pqr_webform', $values);
    }
    else {
      // Staging.
      $fid = $form_state->getValue(['adjuntar_archivos', 0]);
      $form_state->setValue(['adjuntar_archivos'], $fid);
      $values = $form_state->getValues();
      $form_state->setRebuild(TRUE);
      // Post to webform and sales force.
      $coreController = new LibCoreController();
      return $coreController->webformRestPost('pqr_webform', $values);
    }
  }

}
