<?php

namespace Drupal\brazilian_ids\Element;

use Drupal\Core\Render\Element\Textfield;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FormElement("brazilian_ids_cpf")
 */
class CpfElement extends Textfield {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $info = parent::getInfo();

    // Limits the maxlength.
    $info['#maxlength'] = 14;
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
   * Validates the CPF value.
   */
  public static function validateElement(&$element, FormStateInterface $form_state, &$complete_form) {
    $value = $element['#value'];
    $error = [];
    if ($value !== '' && !\Drupal::service('brazilian_ids')->validateCpf($value, $error)) {
      $form_state->setError($element, $error['message']);
    }
  }

}
