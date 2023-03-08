<?php

namespace Drupal\migratewebform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MigrateForm.
 */
class MigrateForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'migrate_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['message_top'] = [
            '#type' => 'markup',
            '#markup' => '<div class="welcome-text"><h2>Bienvenidos</h2><p>Haz click en iniciar migracion para comenzar a pasar los datos de un webform a otro. Recuerde que al pasar los datos se elimina del webform antiguo para evitar duplicidad</p></div>',
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Iniciar migración '),
        ];

        $form['#attributes']['class'][] = 'elements-center';
        $form['#attached']['library'][] = 'migratewebform/libraries';

        return $form;
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

        \Drupal::service('migratedata')->doSomething();
        $message = "Importación finalizada";
        \Drupal::messenger()->addMessage($message, 'status');
    }

}
