<?php
namespace Drupal\lib_rm\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\lib_rm\Controller\LibRmController;
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
}
