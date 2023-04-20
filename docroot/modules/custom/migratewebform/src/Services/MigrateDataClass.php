<?php

namespace Drupal\migratewebform\Services;

use Drupal\Core\Controller\ControllerBase;
use Drupal\webform\Entity\Webform;
use Drupal\webform\Entity\WebformSubmission;

/**
 * Class MigrateDataClass.
 */
class MigrateDataClass extends ControllerBase
{

    /**
     * Constructs a new MigrateDataClass object.
     */
    public function __construct()
    {

    }

    /**
     * Does something.
     *
     * @return string
     *   Some value.
     */
    public function doSomething()
    {
        $query = \Drupal::entityQuery('webform_submission')
            ->condition('webform_id', 'preguntas_frecuentes');
        $query->accessCheck(false);
        $result = $query->execute();
        foreach ($result as $key => $item) {
            $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
            $submission_data = $submission->getData();

            try {
                // Example IDs
                $webform_id = 'pqr_webform';
                $webform = Webform::load($webform_id);
                // Create webform submission.
                $values = [
                    'webform_id' => $webform->id(),
                    'data' => [
                        '00ng000000fwyn9' => $submission_data['reconsideracion'],
                        '00n4a00000fkikp' => $submission_data['numero_caso'],
                        '00n4a00000fkiko' => $submission_data['nombres_y_apellidos_razon_social_'],
                        '00ng000000fwyow' => $submission_data['tipo_de_identificacion'],
                        '00ng000000fwyoi' => $submission_data['numero_de_identificacion'],
                        '00ng000000fwynb' => $submission_data['celular_contacto'],
                        '00ng000000fwynf' => $submission_data['ciudad'],
                        '00ng000000fwynx' => $submission_data['direccion_si'],
                        '00ng000000fwyou' => $submission_data['telefono_fijo_contacto'],
                        'description' => $submission_data['descripcion'],
                        '00n4a00000fkil2' => $submission_data['producto'],
                        '00ng000000998ur' => $submission_data['placa'],
                        '00ng000000fwynl' => $submission_data['medio_envio'],
                        'adjuntar_archivos' => $submission_data['adjuntar_archivos'],
                    ],
                ];

                /** @var \Drupal\webform\WebformSubmissionInterface $webform_submission */
                $webform_submission = WebformSubmission::create($values);
                $webform_submission->save();

                if (!empty($submission)) {
                    //Delete the Submission
                    $submission->delete();
                }
            } catch (\Throwable $th) {
                echo ($th);
            }

        }

        $query = \Drupal::entityQuery('webform_submission')
            ->condition('webform_id', 'pqr');
        $query->accessCheck(false);
        $result = $query->execute();

        foreach ($result as $key => $item) {
            $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
            $submission_data = $submission->getData();

            try {
                // Example IDs
                $webform_id = 'pqr_webform';
                $webform = Webform::load($webform_id);
                // Create webform submission.
                $values = [
                    'webform_id' => $webform->id(),
                    'data' => [
                        '00ng000000fwyn9' => $submission_data['reconsideracion'],
                        '00n4a00000fkikp' => $submission_data['numero_caso'],
                        '00n4a00000fkiko' => $submission_data['nombres_y_apellidos_razon_social_'],
                        '00ng000000fwyow' => $submission_data['tipo_de_identificacion'],
                        '00ng000000fwyoi' => $submission_data['numero_de_identificacion'],
                        '00ng000000fwynb' => $submission_data['celular_contacto'],
                        '00ng000000fwynf' => $submission_data['ciudad'],
                        '00ng000000fwynx' => $submission_data['direccion_si'],
                        '00ng000000fwyou' => $submission_data['telefono_fijo_contacto'],
                        'description' => $submission_data['descripcion'],
                        '00n4a00000fkil2' => $submission_data['producto'],
                        '00ng000000998ur' => $submission_data['placa'],
                        '00ng000000fwynl' => $submission_data['medio_envio'],
                    ],
                ];

                /** @var \Drupal\webform\WebformSubmissionInterface $webform_submission */
                $webform_submission = WebformSubmission::create($values);
                $webform_submission->save();

                if (!empty($submission)) {
                    //Delete the Submission
                    $submission->delete();
                }
            } catch (\Throwable $th) {
                echo ($th);
            }

        }

    }

}
