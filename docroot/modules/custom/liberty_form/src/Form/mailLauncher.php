<?php
/**
 * @file
 * Contains Drupal\liberty_form\Form\mailLauncher.
 */
namespace Drupal\liberty_form\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class mailLauncher extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'mailLauncher';
    }
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        //Busqueda en la base de datos de campañas para impresión en el select

        $form['country'] = [
            '#title' => $this->t('País'),
            '#type' => 'select',
            '#options' => [
                '+57' => 'Colombia',
                '+56' => 'Chile',
                '+593' => 'Ecuador',
            ],
            '#empty_option' => $this->t('- Selecciona el país -'),
            '#ajax' => [
                'callback' => '::updateRamos',
                'wrapper' => 'ramos-wrapper',
            ],
            '#required' => true,
        ];

        $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => 'sponsors']);
        foreach ($query as $spons => $item) {
            $sid = $item->tid->value;
            $data = $item->name->value;
            $sponsors[$sid] = $data;
        }

        $form['sponsors'] = [
            '#title' => $this->t('Sponsors'),
            '#type' => 'select',
            '#options' => $sponsors,
            '#empty_option' => $this->t('- Selecciona sponsor -'),
            '#ajax' => [
                'callback' => '::updateRamos',
                'wrapper' => 'ramos-wrapper',
            ],
            '#required' => true,
        ];

        $form['ramos_wrapper'] = [
            '#type' => 'container',
            '#attributes' => ['id' => 'ramos-wrapper'],
        ];

        $sponsor_id = $form_state->getValue('sponsors');
        if (!empty($sponsor_id)) {
            $form['ramos_wrapper']['ramos'] = [
                '#type' => 'select',
                '#title' => $this->t('Ramos'),
                '#options' => $this->getBranches($sponsor_id),
                '#empty_option' => $this->t('- Selecciona ramo -'),
                '#required' => true,
                '#ajax' => [
                    'callback' => '::updateCampaigns',
                    'wrapper' => 'campaings-wrapper',
                ],
            ];
        }

        $form['campaings_wrapper'] = [
            '#type' => 'container',
            '#attributes' => ['id' => 'campaings-wrapper'],
        ];
        $branch_id = $form_state->getValue('ramos');
        if (!empty($sponsor_id) && !empty($branch_id)) {
            $form['campaings_wrapper']['campaing'] = [
                '#type' => 'select',
                '#title' => $this->t('Campaña'),
                '#options' => $this->getCampaigns($sponsor_id, $branch_id),
                '#empty_option' => $this->t('- Selecciona campaña -'),
                '#required' => true,
            ];
        }

        $form['aviso'] = [
            '#type' => 'markup',
            '#markup' => "<h5>Este proceso puede tomar mucho tiempo, por favor no cierre esta página ni abandone el proceso ...</h5>",
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Enviar correos',
        ];
        return $form;
    }

    /**
     * Ajax callback for the ramos dropdown.
     */
    public function updateRamos(array $form, FormStateInterface $form_state)
    {
        return $form['ramos_wrapper'];
    }

    /**
     * Ajax callback for the campaigns dropdown.
     */
    public function updateCampaigns(array $form, FormStateInterface $form_state)
    {
        return $form['campaings_wrapper'];
    }

    public function getBranches($id_sponsor)
    {

        $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'campaign', 'field_sponsor' => $id_sponsor]);
        foreach ($query as $campaings => $campaign) {
            $tid = $campaign->field_campaing_tax;
            $bid = $tid[0]->target_id;
            $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['tid' => $bid]);
            foreach ($query as $taxonomy => $i) {
                $data = $i->name->value;
            }
            $branch[$bid] = $data;
        }

        return $branch;
    }

    public function getCampaigns($id_sponsor, $id_ramo)
    {

        $query = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'campaign', 'field_sponsor' => $id_sponsor, 'field_campaing_tax' => $id_ramo]);
        foreach ($query as $campaings => $campaign) {
            $nid = $campaign->nid->value;
            $data = $campaign->title->value;
            $camp[$nid] = $data;
        }

        return $camp;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $campaings = $form_state->getValue('campaing');

        $launcher = \Drupal::service('sftp_mk')->doSomething($campaings);

        if ($launcher) {
            if ($launcher['type'] == "error") {
                \Drupal::messenger()->addError(t($launcher['message']));
            } else {
                \Drupal::messenger()->addStatus(t($launcher['message']));
            }
        }

    }

}
