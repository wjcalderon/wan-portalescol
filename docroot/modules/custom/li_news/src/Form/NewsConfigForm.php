<?php

namespace Drupal\li_news\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
<<<<<<< HEAD
use Drupal\node\Entity\Node;

/**
 * Class NewsConfigForm.
=======

/**
 * News Config Form.
>>>>>>> main
 */
class NewsConfigForm extends ConfigFormBase {

  /**
   * Drupal\li_news\Services\NewsInterface definition.
   *
   * @var \Drupal\li_news\Services\NewsInterface
   */
  protected $liNewsDefault;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->liNewsDefault = $container->get('li_news.default');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'li_news.newsconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'news_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('li_news.newsconfig');

<<<<<<< HEAD
    $form['article'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Article configurations'),
      '#tree' => TRUE,
    );

    $form['article']['quantity_images'] = array(
      '#type' => 'number',
      '#title' => $this->t('Images'),
      '#default_value' => isset($config->get('article')['quantity_images']) ?
        $config->get('article')['quantity_images'] : 5,
    );

    $form['article_video'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Article with video configurations'),
      '#tree' => TRUE,
    );

    $form['article_video']['quantity_images'] = array(
      '#type' => 'number',
      '#title' => $this->t('Images'),
      '#default_value' => isset($config->get('article_video')['quantity_images']) ?
        $config->get('article_video')['quantity_images'] : 5,
    );

    $form['article_video']['quantity_videos'] = array(
      '#type' => 'number',
      '#title' => $this->t('Videos'),
      '#default_value' => isset($config->get('article_video')['quantity_videos']) ?
        $config->get('article_video')['quantity_videos'] : 1,
    );

    $form['news_module'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('News module'),
      '#tree' => TRUE,
    );

    // $form['news_module']['principal'] = [
    //   '#type' => 'entity_autocomplete',
    //   '#title' => $this->t('Principal history'),
    //   // '#description' => $this->t('Contenido que se mostrará como el especial resaltado'),
    //   '#default_value' => isset($config->get('news_module')['principal']) ?
    //     Node::load($config->get('news_module')['principal']) : NULL,
    //   '#target_type' => 'node',
    //   '#selection_settings' => array(
    //     'target_bundles' => array('news_article', 'news_article_video', 'news_inphograpfy'),
    //   ),
    // ];
=======
    $form['article'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Article configurations'),
      '#tree' => TRUE,
    ];

    $form['article']['quantity_images'] = [
      '#type' => 'number',
      '#title' => $this->t('Images'),
      '#default_value' => $config->get('article')['quantity_images'] ?? 5,
    ];

    $form['article_video'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Article with video configurations'),
      '#tree' => TRUE,
    ];

    $form['article_video']['quantity_images'] = [
      '#type' => 'number',
      '#title' => $this->t('Images'),
      '#default_value' => $config->get('article_video')['quantity_images'] ?? 5,
    ];

    $form['article_video']['quantity_videos'] = [
      '#type' => 'number',
      '#title' => $this->t('Videos'),
      '#default_value' => $config->get('article_video')['quantity_videos'] ?? 1,
    ];

    $form['news_module'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('News module'),
      '#tree' => TRUE,
    ];
>>>>>>> main

    $form['news_module']['quantity_news'] = [
      '#type' => 'number',
      '#title' => $this->t('Amount of news'),
<<<<<<< HEAD
      '#default_value' => isset($config->get('news_module')['quantity_news']) ?
        $config->get('news_module')['quantity_news'] : 50,
=======
      '#default_value' => $config->get('news_module')['quantity_news'] ?? 50,
>>>>>>> main
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('li_news.newsconfig')
      ->set('article', $form_state->getValue('article'))
      ->set('article_video', $form_state->getValue('article_video'))
      ->set('news_module', $form_state->getValue('news_module'))
      ->save();
  }

}
