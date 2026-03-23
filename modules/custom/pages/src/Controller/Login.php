<?php

namespace Drupal\pages\Controller;

use Drupal\Core\Controller\ControllerBase;

class Login extends ControllerBase {

  public function page() {
    return [
      '#theme' => 'login_page',
      '#form' => \Drupal::formBuilder()->getForm('Drupal\pages\Form\LoginForm'),
    ];
  }

}
