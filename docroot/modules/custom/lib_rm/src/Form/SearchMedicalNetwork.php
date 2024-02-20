<?php
<<<<<<< HEAD
namespace Drupal\lib_rm\Form;

use Drupal;
=======

namespace Drupal\lib_rm\Form;

>>>>>>> main
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\lib_rm\Controller\LibRmController;
<<<<<<< HEAD
use Drupal\taxonomy\Entity\Term;

class SearchMedicalNetwork extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        // Nombre del formulario
        return 'search_medical_network_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['#attached']['library'][] = 'lib_rm/lib_rm';
        $lib_rm = new LibRmController();

        $opts_plans = $lib_rm->_lib_rm_get_options_by_vocabulary('tipo_de_plan', false);
        $keys_opts_plans = array_keys($opts_plans);
        $dflt_plan = 0;
        if (isset($_GET['pt']) && !empty($_GET['pt'])) {
            $dflt_plan = $_GET['pt'];
        }

        $bool_dflt_vals = false;
        if ((isset($_GET['c']) && is_numeric($_GET['c'])) || (isset($_GET['t']) && !empty($_GET['t']))) {
            $bool_dflt_vals = true;
        }

        $form['ctn'] = array(
            '#prefix' => '<div class="wrapper-form-search">',
            '#suffix' => '</div>',
        );

        $form['ctn']['plan_type'] = array(
            '#type' => 'radios',
            '#options' => $opts_plans,
            '#attributes' => array(
                'class' => array('plan-types'),
            ),
            '#default_value' => $dflt_plan,
        );

        $key_gp = 'gp_form';
        $key_form = 'form';
        $form['ctn'][$key_gp] = array(
            '#type' => 'container',
            '#attributes' => array(
                'id' => $key_gp,
                'class' => array('content-fields-rm active is-desktop'),
            ),
        );

        // Default city
        if (isset($_GET['c']) && is_numeric($_GET['c'])) {
            $tid_city = $_GET['c'];
            $term = Term::load($tid_city);
            $name_city = $term->getName();
        }
        $form['ctn'][$key_gp]['city'] = array(
            '#type' => 'textfield',
            '#title' => 'Ciudad',
            '#default_value' => isset($name_city) ? $name_city : null,
            '#disabled' => $dflt_plan > 0 ? false : true,
            '#attributes' => array(
                'class' => array('city-rm'),
                'autocomplete' => 'off',
            ),
            '#name' => 'lib-rm-city',
        );
        $form['ctn'][$key_gp]['h_city'] = array(
            '#type' => 'hidden',
            '#default_value' => isset($tid_city) ? $tid_city : null,
            '#attributes' => array(
                'class' => array('h-city-rm'),
            ),
        );
        $form['ctn'][$key_gp]['is_mobile'] = array(
            '#type' => 'hidden',
            '#default_value' => 0,
            '#attributes' => array(
                'class' => array('is_mobile'),
                'id' => 'is_mobile',
            ),
        );

/*    $form['ctn'][$key_gp]['specialty'] = array(
'#type' => 'select',
'#title' => 'Especialidad',
'#options' => array(
'none' => 'Seleccionar',
),
'#disabled' => TRUE,
'#attributes' => array(
'class' => array('specialty-rm'),
)
);
 */
        // Default specialty
        if (isset($_GET['e']) && is_numeric($_GET['e'])) {
            $tid_speciality = $_GET['e'];
            $term = Term::load($tid_speciality);
            $name_speciality = $term->getName();
        }

        $form['ctn'][$key_gp]['specialty'] = array(
            '#type' => 'textfield',
            '#title' => 'Especialidad',
            '#default_value' => isset($name_speciality) ? $name_speciality : null,
            '#disabled' => isset($name_speciality) ? false : true,
            '#attributes' => array(
                'class' => array('speciality-rm-sr'),
                'autocomplete' => 'off',
            ),
            '#name' => 'lib-rm-specialty',
        );

        $form['ctn'][$key_gp]['h_specialty'] = array(
            '#type' => 'hidden',
            '#default_value' => isset($tid_speciality) ? $tid_speciality : null,
            '#attributes' => array(
                'class' => array('h-specialty-rm'),
            ),
        );

        $form['ctn'][$key_gp]['search_word'] = array(
            '#type' => 'textfield',
            '#title' => 'Nombre de la institución o especialista',
            '#size' => 60,
            '#default_value' => isset($_GET['t']) && !empty($_GET['t']) ? $_GET['t'] : null,
            '#maxlength' => 128,
            '#attributes' => array(
                'class' => array('search-word-rm'),
                'autocomplete' => 'off',
            ),
        );

        $form['ctn']['view_mode_results'] = array(
            '#type' => 'hidden',
            '#default_value' => 'list',
            '#attributes' => array(
                'class' => array('h-view_mode_results'),
            ),
        );

        $form['ctn']['lat'] = array(
            '#type' => 'hidden',
            '#attributes' => array(
                'class' => array('h-lat'),
            ),
        );
        $form['ctn']['long'] = array(
            '#type' => 'hidden',
            '#attributes' => array(
                'class' => array('h-long'),
            ),
        );

        $form['ctn']['search'] = array(
            '#prefix' => '<div class="content ctn-footer is-desktop"><div class="form-item">',
            '#suffix' => '</div>',
            '#type' => 'submit',
            '#value' => 'Buscar',
            '#attributes' => $bool_dflt_vals ? array('class' => array('btn button--primary vals-dflt')) : array('class' => array('btn button--primary')),
        );

        $form['ctn']['around_me'] = array(
            '#prefix' => '<div class="check">',
            '#suffix' => '</div></div>',
            '#type' => 'checkbox',
            '#title' => 'Buscar cerca a mi',
            '#default_value' => isset($_GET['lat']) && is_numeric($_GET['lat']) ? true : false,
            '#attributes' => array(
                'class' => array('check-around-me'),
            ),
        );

        $parametros_get = $_GET;
        $list = '';
        $current_uri = \Drupal::request()->getRequestUri();
        $path_current = explode('?', $current_uri);

        if (isset($name_city)) {
            unset($parametros_get['c']);
            unset($parametros_get['e']);
            $list .= '<li class="item-filter"><a  cdata="c" class="link-filter" href="' . $this->genera_url($path_current[0], array()) . '">' . $name_city . '<img src="/themes/custom/liberty_public/images/icons/close-filtros.svg"></a></li>';
        }
        if (isset($name_speciality)) {
            $parametros_get = $_GET;
            unset($parametros_get['e']);
            $list .= '<li class="item-filter"><a  cdata="e" class="link-filter" href="' . $this->genera_url($path_current[0], $parametros_get) . '">' . $name_speciality . '<img src="/themes/custom/liberty_public/images/icons/close-filtros.svg"></a></li>';
        }
        if (isset($parametros_get['t']) && !empty($_GET['t'])) {
            $parametros_get = $_GET;
            unset($parametros_get['t']);
            $list .= '<li class="item-filter"><a  cdata="t" class="link-filter" href="' . $this->genera_url($path_current[0], $parametros_get) . '">' . $_GET['t'] . '<img src="/themes/custom/liberty_public/images/icons/close-filtros.svg"></a></li>';
        }
        if (isset($_SESSION['is_mobile'])) {
            unset($_SESSION['is_mobile']);
        }

        $form['filters'] = array(
            '#prefix' => '<ul class="special-filters" id="special-filters">',
            '#suffix' => '</ul>',
            '#markup' => $list,
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    private function genera_url($path, $get)
    {
        $parametros = '';
        foreach ($get as $key => $value) {
            if (!empty($parametros)) {
                $parametros .= '&';
            }
            if (!is_array($value)) {
                $parametros .= "$key=$value";
            }
        }
        if (isset($_SESSION['is_mobile']) && $_SESSION['is_mobile'] == 1) {
            return $path . '?' . $parametros . '';
        } else {
            return $path . '?' . $parametros . '#component-371';
        }

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
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $values = $form_state->getValues();
        $plan_type = $form_state->getValue('plan_type');
        $city = $form_state->getValue('h_city');
        $specialty = $form_state->getValue('h_specialty');
        $search_word = $form_state->getValue('search_word');
        $view_mode_results = $form_state->getValue('view_mode_results');
        $lat = $form_state->getValue('lat');
        $long = $form_state->getValue('long');
        $is_mobile = $form_state->getValue('is_mobile');

        if ($is_mobile == 0) {
            $fragment = 'component-371';
        } else {
            $fragment = '';
            $_SESSION['is_mobile'] = 1;
        }

        $options = array(
            'query' => array(
                'pt' => $plan_type,
                'c' => $city,
                'e' => $specialty,
                't' => $search_word,
                'vm' => $view_mode_results,
            ),
            'fragment' => $fragment,
            'absolute' => true,
        );

        if (is_numeric($lat) && is_numeric($long)) {
            $options['query']['lat'] = $lat;
            $options['query']['lng'] = $long;
        }

        // Get current node
        $node = \Drupal::routeMatch()->getParameter('node');
        if ($node instanceof \Drupal\node\NodeInterface) {
            $nid = $node->id();
        }

        // Reload page
        $url = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $nid], $options);
        $form_state->setRedirectUrl($url);

    }
=======
use Drupal\node\NodeInterface;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Search Medical Network.
 */
class SearchMedicalNetwork extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'search_medical_network_form';
  }

  /**
   * RequestStack.
   *
   * @var array
   */
  protected $requestStack;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack')
    );
  }

  /**
   * Construct custom.
   */
  public function __construct(RequestStack $requestStack) {
    $this->requestStack = $requestStack;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attached']['library'][] = 'lib_rm/lib_rm';
    $lib_rm = new LibRmController();

    $opts_plans = $lib_rm->libRmGetOptionsByVocabulary('tipo_de_plan', FALSE);
    $dflt_plan = 0;
    if ($request = $this->requestStack->getCurrentRequest()) {
      $pt = $request->query->get('pt');
    }

    if ($pt !== NULL) {
      $dflt_plan = $pt;
    }

    $bool_dflt_vals = FALSE;
    if ($request = $this->requestStack->getCurrentRequest()) {
      $c = $request->query->get('c');
      $t = $request->query->get('t');

      if ((is_numeric($c) || !empty($t))) {
        $bool_dflt_vals = TRUE;
      }
    }

    $form['ctn'] = [
      '#prefix' => '<div class="wrapper-form-search">',
      '#suffix' => '</div>',
    ];

    $form['ctn']['plan_type'] = [
      '#type' => 'radios',
      '#options' => $opts_plans,
      '#attributes' => [
        'class' => ['plan-types'],
      ],
      '#default_value' => $dflt_plan,
    ];

    $key_gp = 'gp_form';
    $form['ctn'][$key_gp] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => $key_gp,
        'class' => ['content-fields-rm active is-desktop'],
      ],
    ];

    // Default city.
    if ($request = $this->requestStack->getCurrentRequest()) {
      $c = $request->query->get('c');

      if (is_numeric($c)) {
        $tid_city = $c;
        $term = Term::load($tid_city);

        if ($term instanceof Term) {
          $name_city = $term->getName();
          // Haz lo que necesites con $name_city.
        }
      }
    }
    $form['ctn'][$key_gp]['city'] = [
      '#type' => 'textfield',
      '#title' => 'Ciudad',
      '#default_value' => $name_city ?? NULL,
      '#disabled' => $dflt_plan > 0 ? FALSE : TRUE,
      '#attributes' => [
        'class' => ['city-rm'],
        'autocomplete' => 'off',
      ],
      '#name' => 'lib-rm-city',
    ];
    $form['ctn'][$key_gp]['h_city'] = [
      '#type' => 'hidden',
      '#default_value' => $tid_city ?? NULL,
      '#attributes' => [
        'class' => ['h-city-rm'],
      ],
    ];
    $form['ctn'][$key_gp]['is_mobile'] = [
      '#type' => 'hidden',
      '#default_value' => 0,
      '#attributes' => [
        'class' => ['is_mobile'],
        'id' => 'is_mobile',
      ],
    ];

    /*    $form['ctn'][$key_gp]['specialty'] = array(
    '#type' => 'select',
    '#title' => 'Especialidad',
    '#options' => array(
    'none' => 'Seleccionar',
    ),
    '#disabled' => TRUE,
    '#attributes' => array(
    'class' => array('specialty-rm'),
    )
    );
     */
    // Default specialty.
    // Luego, puedes acceder al parámetro GET 'e' de la siguiente manera:
    if ($request = $this->requestStack->getCurrentRequest()) {
      $e = $request->query->get('e');

      if (is_numeric($e)) {
        $tid_speciality = $e;
        $term = Term::load($tid_speciality);

        if ($term instanceof Term) {
          $name_speciality = $term->getName();
        }
      }
    }

    $form['ctn'][$key_gp]['specialty'] = [
      '#type' => 'textfield',
      '#title' => 'Especialidad',
      '#default_value' => $name_speciality ?? NULL,
      '#disabled' => isset($name_speciality) ? FALSE : TRUE,
      '#attributes' => [
        'class' => ['speciality-rm-sr'],
        'autocomplete' => 'off',
      ],
      '#name' => 'lib-rm-specialty',
    ];

    $form['ctn'][$key_gp]['h_specialty'] = [
      '#type' => 'hidden',
      '#default_value' => $tid_speciality ?? NULL,
      '#attributes' => [
        'class' => ['h-specialty-rm'],
      ],
    ];

    if ($request = $this->requestStack->getCurrentRequest()) {
      $t = $request->query->get('t');
    }
    else {
      $t = NULL;
    }

    $form['ctn'][$key_gp]['search_word'] = [
      '#type' => 'textfield',
      '#title' => 'Nombre de la institución o especialista',
      '#size' => 60,
      '#default_value' => !empty($t) ? $t : NULL,
      '#maxlength' => 128,
      '#attributes' => [
        'class' => ['search-word-rm'],
        'autocomplete' => 'off',
      ],
    ];

    $form['ctn']['view_mode_results'] = [
      '#type' => 'hidden',
      '#default_value' => 'list',
      '#attributes' => [
        'class' => ['h-view_mode_results'],
      ],
    ];

    $form['ctn']['lat'] = [
      '#type' => 'hidden',
      '#attributes' => [
        'class' => ['h-lat'],
      ],
    ];
    $form['ctn']['long'] = [
      '#type' => 'hidden',
      '#attributes' => [
        'class' => ['h-long'],
      ],
    ];

    $form['ctn']['search'] = [
      '#prefix' => '<div class="content ctn-footer is-desktop"><div class="form-item">',
      '#suffix' => '</div>',
      '#type' => 'submit',
      '#value' => 'Buscar',
      '#attributes' => $bool_dflt_vals ? ['class' => ['btn button--primary vals-dflt']] : ['class' => ['btn button--primary']],
    ];

    if ($request = $this->requestStack->getCurrentRequest()) {
      $lat = $request->query->get('lat');
    }
    else {
      $lat = NULL;
    }

    $form['ctn']['around_me'] = [
      '#prefix' => '<div class="check">',
      '#suffix' => '</div></div>',
      '#type' => 'checkbox',
      '#title' => 'Buscar cerca a mi',
      '#default_value' => is_numeric($lat) ? TRUE : FALSE,
      '#attributes' => [
        'class' => ['check-around-me'],
      ],
    ];

    if ($request = $this->requestStack->getCurrentRequest()) {
      $parametros_get = $request->query->all();
    }
    else {
      $parametros_get = [];
    }
    $list = '';
    $current_uri = \Drupal::request()->getRequestUri();
    $path_current = explode('?', $current_uri);

    if (isset($name_city)) {
      unset($parametros_get['c']);
      unset($parametros_get['e']);
      $list .= '<li class="item-filter"><a  cdata="c" class="link-filter" href="' . $this->generaUrl($path_current[0], []) . '">' . $name_city . '<img src="/themes/custom/liberty_public/images/icons/close-filtros.svg"></a></li>';
    }
    if (isset($name_speciality)) {
      if ($request = $this->requestStack->getCurrentRequest()) {
        $parametros_get = $request->query->all();
      }
      else {
        $parametros_get = [];
      }
      unset($parametros_get['e']);
      $list .= '<li class="item-filter"><a  cdata="e" class="link-filter" href="' . $this->generaUrl($path_current[0], $parametros_get) . '">' . $name_speciality . '<img src="/themes/custom/liberty_public/images/icons/close-filtros.svg"></a></li>';
    }
    if ($request = $this->requestStack->getCurrentRequest()) {
      $parametros_get = $request->query->all();
    }
    else {
      $parametros_get = [];
    }

    if (isset($parametros_get['t']) && !empty($parametros_get['t'])) {
      $tValue = $parametros_get['t'];
      unset($parametros_get['t']);
      $list .= '<li class="item-filter"><a  cdata="t" class="link-filter" href="' . $this->generaUrl($path_current[0], $parametros_get) . '">' . $tValue . '<img src="/themes/custom/liberty_public/images/icons/close-filtros.svg"></a></li>';
    }
    if (isset($_SESSION['is_mobile'])) {
      unset($_SESSION['is_mobile']);
    }

    $form['filters'] = [
      '#prefix' => '<ul class="special-filters" id="special-filters">',
      '#suffix' => '</ul>',
      '#markup' => $list,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  private function generaUrl($path, $get) {
    $parametros = '';
    foreach ($get as $key => $value) {
      if (!empty($parametros)) {
        $parametros .= '&';
      }
      if (!is_array($value)) {
        $parametros .= "$key=$value";
      }
    }
    if (isset($_SESSION['is_mobile']) && $_SESSION['is_mobile'] == 1) {
      return $path . '?' . $parametros . '';
    }
    else {
      return $path . '?' . $parametros . '#component-371';
    }

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
    $plan_type = $form_state->getValue('plan_type');
    $city = $form_state->getValue('h_city');
    $specialty = $form_state->getValue('h_specialty');
    $search_word = $form_state->getValue('search_word');
    $view_mode_results = $form_state->getValue('view_mode_results');
    $lat = $form_state->getValue('lat');
    $long = $form_state->getValue('long');
    $is_mobile = $form_state->getValue('is_mobile');

    if ($is_mobile == 0) {
      $fragment = 'component-371';
    }
    else {
      $fragment = '';
      $_SESSION['is_mobile'] = 1;
    }

    $options = [
      'query' => [
        'pt' => $plan_type,
        'c' => $city,
        'e' => $specialty,
        't' => $search_word,
        'vm' => $view_mode_results,
      ],
      'fragment' => $fragment,
      'absolute' => TRUE,
    ];

    if (is_numeric($lat) && is_numeric($long)) {
      $options['query']['lat'] = $lat;
      $options['query']['lng'] = $long;
    }

    // Get current node.
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof NodeInterface) {
      $nid = $node->id();
    }

    // Reload page.
    $url = Url::fromRoute('entity.node.canonical', ['node' => $nid], $options);
    $form_state->setRedirectUrl($url);

  }

>>>>>>> main
}
