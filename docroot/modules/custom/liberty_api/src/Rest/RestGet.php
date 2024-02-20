<?php

namespace Drupal\liberty_api\Rest;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
<<<<<<< HEAD
use SVG\Utilities\Units\Length;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class RestGet extends ControllerBase {
  protected $entityTypeManager;
  
  /**
   * Construct implementation.
   * @param EntityTypeManagerInterface $entityTypeManager
=======
use Drupal\webform\Entity\Webform;
use Drupal\webform\Entity\WebformSubmission;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Rest get.
 */
class RestGet extends ControllerBase {

  /**
   * Entity Type Manager variable  custom.
   *
   * @var array
   */
  protected $entityTypeManager;

  /**
   * Construct implementation.
>>>>>>> main
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }
<<<<<<< HEAD
  
  /**
   * Create implementation.
   * @param ContainerInterface $container
   * @return \Drupal\liberty_api\Rest\CustomRest
   */
  public static function create(ContainerInterface $container) {
    return new static (
      $container->get('entity_type.manager')
    );
  }
  
  /**
   * Return webform created in a Json.
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function getWebform($id) {
    $response_array = array();
    $submission_data2 = [];
    
    if ($id == "all") {
      $webform = \Drupal\webform\Entity\Webform::load('call_center_');
      if ($webform->hasSubmissions()) {
        $query = \Drupal::entityQuery('webform_submission')
          ->condition('webform_id', 'call_center_');
          $query->accessCheck(FALSE);
        $result = $query->execute();
        $count=1;
        $submission_data = [];
        foreach ($result as $key => $item) {
          $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
=======

  /**
   * Create implementation.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Return webform created in a Json.
   */
  public function getWebform($id) {
    $submission_data2 = [];

    if ($id == "all") {
      $webform = Webform::load('call_center_');
      if ($webform->hasSubmissions()) {
        $query = \Drupal::entityQuery('webform_submission')
          ->condition('webform_id', 'call_center_');
        $query->accessCheck(FALSE);
        $result = $query->execute();
        $count = 1;
        $submission_data = [];
        foreach ($result as $item) {
          $submission = WebformSubmission::load($item);
>>>>>>> main
          $submission_data = $submission->getData();
          $submission_data2[$count] = $submission_data;
          $count++;
        }
        if (count($submission_data2) == 0) {
          $submission_data2 = [
            'message' => $this->t('No webform stored.'),
          ];
        }
      }
<<<<<<< HEAD
    }elseif (isset($id) && $id !== "all" ) {
=======
    }
    elseif (isset($id) && $id !== "all") {
>>>>>>> main
      $node_storage = \Drupal::entityTypeManager()->getStorage('node');
      $node = $node_storage->load($id);
      if ($node) {
        $title = $node->title->value;
<<<<<<< HEAD
        $webform = \Drupal\webform\Entity\Webform::load('call_center_');
        if ($webform->hasSubmissions()) {
          $query = \Drupal::entityQuery('webform_submission')
            ->condition('webform_id', 'call_center_');
            $query->accessCheck(FALSE);
          $result = $query->execute();
          $submission_data = [];
          $count=1;
          foreach ($result as $key => $item) {
            $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
            $submission_data = $submission->getData();
            if ($submission_data['campana'] == $title ) {
=======
        $webform = Webform::load('call_center_');
        if ($webform->hasSubmissions()) {
          $query = \Drupal::entityQuery('webform_submission')
            ->condition('webform_id', 'call_center_');
          $query->accessCheck(FALSE);
          $result = $query->execute();
          $submission_data = [];
          $count = 1;
          foreach ($result as $item) {
            $submission = WebformSubmission::load($item);
            $submission_data = $submission->getData();
            if ($submission_data['campana'] == $title) {
>>>>>>> main
              $submission_data2[$count] = $submission_data;
              $count++;
            }
          }
          if (count($submission_data2) == 0) {
            $submission_data2 = [
              'message' => $this->t('No webform stored.'),
            ];
          }
        }
<<<<<<< HEAD
      }else {
=======
      }
      else {
>>>>>>> main
        $submission_data2 = [
          'message' => $this->t('No webform stored.'),
        ];
      }
<<<<<<< HEAD
    }else {
=======
    }
    else {
>>>>>>> main
      $submission_data2 = [
        'message' => $this->t('No webform stored.'),
      ];
    }
    // Transform array in a Json response.
    $response = new JsonResponse($submission_data2);
<<<<<<< HEAD
    
    return $response;
  }
}
=======

    return $response;
  }

}
>>>>>>> main
