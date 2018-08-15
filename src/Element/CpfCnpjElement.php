<?php

namespace Drupal\brazilian_ids\Element;

use Drupal\Core\Form\FormStateInterface;

/**
 * @FormElement("brazilian_ids_cpf_cnpj")
 */
class CpfCnpjElement extends CpfCnpjBase {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $info = parent::getInfo();
    $info['#maxlength'] = 18;
    return $info;
  }

}
