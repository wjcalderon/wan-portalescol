<?php

namespace Drupal\li_news\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * News Config Form.
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

    $form['news_module']['quantity_news'] = [
      '#type' => 'number',
      '#title' => $this->t('Amount of news'),
      '#default_value' => $config->get('news_module')['quantity_news'] ?? 50,
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
