<?php

/** 
 * @file
 * Contains \Drupal\variable_get_set\Form\VariableForm
 */
namespace Drupal\variable_get_set\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class VariableForm extends FormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
      return 'variable_form';
    }

     /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = \Drupal::service('config.factory')->getEditable('variable_get_set.api');
        $variable_get_set_cilent_name =  $config->get('cilent_name');
        $variable_get_set_cilent_secret =  $config->get('cilent_secret');

        $form['cilent_key'] = array(
            '#type' => 'textfield',
            '#title' => t('Account Name:'),
            '#required' => TRUE,
            '#default_value' => $variable_get_set_cilent_name
        );
        $form['cilent_secret'] = array(
            '#type' => 'textfield',
            '#title' => t('Account Secret'),
            '#required' => TRUE,
            '#default_value' => $variable_get_set_cilent_secret
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#button_type' => 'primary',
        );
        return $form;
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
        $cilent_key = $form_state->getValue('cilent_key');
        $cilent_secret = $form_state->getValue('cilent_secret');

        $config = \Drupal::service('config.factory')->getEditable('variable_get_set.api');
        $config->set('cilent_name', $cilent_key);
        $config->set('cilent_secret', $cilent_secret);
        $config->save();

        if($config->save()){
            drupal_set_message("updated");
        }       
    }

}