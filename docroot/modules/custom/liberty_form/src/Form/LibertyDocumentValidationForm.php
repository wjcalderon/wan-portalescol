<?php
/**
 * @file
 * Contains Drupal\liberty_form\Form\LibertyDocumentValidationForm.
 */
namespace Drupal\liberty_form\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class LibertyDocumentValidationForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    private $arg;

    public function __construct()
    {
        $path = \Drupal::service('path.current')->getPath();
        $path_args = explode('/', $path);
        $this->arg = $path_args[2];

        // verifica si es vip
        $config = $this->config('liberty_form.vip');
        $variable_vip_name = \Drupal::request()->query->get($config->get('variable_get_name'));
        $variable_get_value = $config->get('variable_get_value');
        if (isset($variable_get_value)) {
            if ($variable_get_value == $variable_vip_name) {
                $response = new AjaxResponse();
                $tempstore = \Drupal::service('tempstore.private')->get('LibertySession');
                $tempstoreTime = \Drupal::service('tempstore.private')->get('LibertySessionTime');
                $tempstore->set('landingaccess', $path_args[2]);
                $tempstoreTime->set('landingaccesstime', '3600');
                $options = ['absolute' => true];
                $url = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $path_args[2]], $options);
                $command = new RedirectCommand($url->toString());
                $response->addCommand($command);
            }
        }
    }

    public function getFormId()
    {
        return 'LibertyDocumentValidationForm';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $path = \Drupal::service('path.current')->getPath();
        $path_args = explode('/', $path);
        $nid = end($path_args);
        $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
        $moderation_state = $node->get('moderation_state')->getValue()[0]['value'];

        if ($moderation_state == "archived") {
            header('Location: /not-access');
            exit;

        }

        $form['#attached']['library'][] = 'liberty_form/liberty-validations';

        $form['message_top'] = [
            '#type' => 'markup',
            '#markup' => '<div class="welcome-text"><h1>Bienvenido</h1><p>Un sitio diseñado especialmente para clientes. Ingresa tu tipo y número de identificación y comienza a disfrutar de todos los beneficios que ofrecemos.</p></div>',
        ];

        $form['#prefix'] = '<div class="login-form-content">';

        $form['#suffix'] = '</div> <div id="liberty-error-message"></div>';

        $form['identification_type'] = [
            '#type' => 'select',
            '#title' => $this->t('Tipo de documento'),
            '#empty_option' => '',
            '#options' => [
                1 => "Cédula de ciudadanía",
                2 => "Cédula de extranjería",
                3 => "Pasaporte",
            ],
            '#required' => true,
            '#label_classes' => [
                'some-label-class',
            ],
            '#attributes' => [
                'id' => ['form-prev'],
            ],
        ];
        $form['identification_number'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Número de identificación'),
            '#required' => true,

        ];

        $form['id_campaign'] = [
            '#type' => 'textfield',
            '#default_value' => $this->arg,
            '#attributes' => [
                'class' => ['hidden'],

            ],
        ];

        $form['my_captcha_element'] = array(
            '#type' => 'captcha',
            '#captcha_type' => 'recaptcha/reCAPTCHA',
        );

        $form['hidden'] = array(
            '#type' => 'hidden',
            '#value' => '1',
        );

        $form['submit'] = [
            '#type' => 'button',
            '#value' => 'Ingresar',
            '#ajax' => array(
                'callback' => '::validateIdCallback',
                'event' => 'click',
                'progress' => array(
                    'type' => 'throbber',
                    'message' => 'Cargando..',
                ),
            ),
            '#attributes' => [
                'class' => ['welcome-box'],
                'disabled' => 'disabled',
            ],
        ];

        $form['#theme'] = 'document_validation_form';
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $type_id = $form_state->getValue('identification_type');
        $id_number = $form_state->getValue('identification_number');

        $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['field_document_type' => $type_id, 'field_id_number' => $id_number]);

        if ($query == []) {
            return \Drupal::messenger()->addError('Los datos ingresados son incorrectos, por favor ingresa los datos nuevamente');
        } else {

            setcookie('landing_access', true, time() + (60 * 60 * 24), '/');
            return \Drupal::messenger()->addMessage('datos validados correctamente');
        }
    }

    public function validateIdCallback(array &$form, FormStateInterface $form_state): AjaxResponse
    {

        $response = new AjaxResponse();
        $campaign_id = $form_state->getValue('id_campaign');
        $identification_number = $form_state->getValue('identification_number');
        if (!$form_state->getErrors()) {

            $nids = array();
            $user_id = $form_state->getValue('identification_number');
            $type_id = $form_state->getValue('identification_type');

            $query = \Drupal::entityQuery('node')
                ->condition('type', 'customer')
                ->condition('field_document_type', $type_id)
                ->condition('field_id_number', $user_id)
                ->condition('field_campaign_id', $campaign_id)
                ->condition('field_status', 1);
            $nids = $query->execute();

            if (empty($nids)) {
                $msg_heading = 'Los datos ingresados son incorrectos';
                $msg_summary = 'Por favor ingresa los datos nuevamente.';
                $msg_type = 'error';

                // Theming mensaje
                $message = [];
                $message['#theme'] = 'liberty_message_block';
                $message['#heading'] = $msg_heading;
                $message['#summary'] = $msg_summary;
                $message['#type'] = $msg_type;

                // Mensaje informativo
                $response->addCommand(new ReplaceCommand('#liberty-error-message', $message));
            }
            // Si existe
            else {
                $session = \Drupal::request()->getSession();
                $node_id = $campaign_id;
                $session->set('node_id', $node_id);

                $options = ['absolute' => true];
                $url = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $campaign_id], $options);
                setcookie('type_id', $type_id, time() + (3 * 60 * 60), '/');
                setcookie('user_id', $user_id, time() + (3 * 60 * 60), '/');
                $command = new RedirectCommand($url->toString());
                $response->addCommand($command);
            }

            return $response;

        }
    }
}
