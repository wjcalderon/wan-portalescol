<?php

namespace Drupal\lib_login_corredores\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Login Custom Authentication.
 */
class CustomLoginForm extends FormBase {

  /**
   * Información relacionada con la coincidencia de rutas en la aplicación.
   *
   * @var RouteMatch
   */
  protected $routeMatch;

  /**
   * La instancia de la sesión actual del usuario en la aplicación.
   *
   * @var Session
   */
  protected $session;

  /**
   * Pila de solicitudes para acceder a solicitudes.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Construct services.
   */
  public function __construct(
    RouteMatchInterface $route_match,
    SessionInterface $session,
    RequestStack $requestStack
  ) {
    $this->routeMatch = $route_match;
    $this->session = $session;
    $this->requestStack = $requestStack;
  }

  /**
   * Create services container instance.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_route_match'),
      $container->get('session'),
      $container->get('request_stack')
    );
  }

  /**
   * Form id .
   */
  public function getFormId() {
    return 'lib_login_corredores_custom_login_form';
  }

  /**
   * Build form custom.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['container'] = [
      '#type' => 'container',
      '#attributes' => ['class' => ['custom-login-form']],
    ];

    $form['container']['numero_documento'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Clave líder'),
    // Expresión regular para permitir solo números enteros.
      '#pattern' => '\d+',
      '#attributes' => ['class' => ['text-document']],
    ];

    $form['container']['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('INGRESAR'),
      '#attributes' => ['class' => ['btn btn-primary']],
    ];

    // Agrega la referencia a la plantilla Twig personalizada.
    $form['#theme'] = 'custom_login_form';
    $form['#form'] = $form;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $this->routeMatch->getParameter('node');
    return [
      '#theme' => 'ceap_block',
      '#details' => (isset($this->configuration['details'])) ? $this->configuration['details'] : 'empty',
    ];
  }

  /**
   * Validation custom form .
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $numero_documento = $form_state->getValue('numero_documento');

    if (!$this->numeroDocumentoExists($numero_documento)) {
      $form_state->setErrorByName('numero_documento', $this->t('El número de documento no se encuentra en la base de datos.'));
    }
  }

  /**
   * Verifica si el número de documento existe en la tabla personalizada.
   *
   * @param string $numero_documento
   *   El número de documento a verificar.
   *
   * @return bool
   *   TRUE si el número de documento existe en la tabla,
   *   FALSE en caso contrario.
   */
  private function numeroDocumentoExists($numero_documento) {
    $database = \Drupal::database();
    $table_name = 'custom_import_table';

    $query = $database->select($table_name, 't')
      ->fields('t', ['numero_documento'])
      ->condition('numero_documento', $numero_documento)
      ->range(0, 1);

    $result = $query->execute();

    return !empty($result->fetchCol());
  }

  /**
   * Action post submit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $numero_documento = $form_state->getValue('numero_documento');
    $database = \Drupal::database();
    $table_name = 'custom_import_table';

    // Verifica si el número de documento existe en la tabla.
    if ($this->numeroDocumentoExists($numero_documento)) {
      // Actualiza el campo_booleano a 1 (o al valor que necesites)
      // cuando el usuario es válido.
      $database->update($table_name)
      // Puedes cambiar 1 al valor deseado.
        ->fields(['campo_booleano' => 1])
        ->condition('numero_documento', $numero_documento)
        ->execute();
    }

    $this->session->set('session_expire', REQUEST_TIME + 2592000);

    $this->requestStack->getCurrentRequest();

    if ($this->session->get('session_expire', 0) < REQUEST_TIME) {
      $form_state->setRedirect('lib_login_corredores.login');
      return;
    }

    $redirectFrom = $this->session->get('redirect_from_blog');
    if (!empty($redirectFrom)) {
      $form_state->setRedirectUrl(Url::fromUserInput($redirectFrom));
      $this->session->remove('redirect_from_blog');
      return;
    }

    $destination = Url::fromUri('internal:/blog');
    $form_state->setRedirectUrl($destination);
  }

}
