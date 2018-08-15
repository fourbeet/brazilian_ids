<?php

namespace Drupal\brazilian_ids\Element;

use Drupal\Core\Render\Element\Textfield;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FormElement("brazilian_ids_cpf_cnpj")
 */
class CpfCnpjElement extends Textfield {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $info = parent::getInfo();

    // Limits the maxlength.
    $info['#maxlength'] = 18;
    $info['#size'] = 20;

    // Adds validation callback.
    $info['#element_validate'] = [
      [get_class($this), 'validateElement'],
    ];

    return $info;
  }

  /**
   * {@inheritdoc}
   */
  public static function valueCallback(&$element, $input, FormStateInterface $form_state) {
    $value = parent::valueCallback($element, $input, $form_state);
    return \Drupal::service('brazilian_ids')->clean($value);
  }

  /**
   * Validates the CPF or CNPJ value.
   */
  public static function validateElement(&$element, FormStateInterface $form_state, &$complete_form) {
    $value = $element['#value'];
    $error = [];
    if ($value !== '' && !\Drupal::service('brazilian_ids')->validateCpfCnpj($value, $error)) {
      $form_state->setError($element, $error['message']);
    }
  }

}
