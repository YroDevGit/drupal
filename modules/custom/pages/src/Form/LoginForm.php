<?php

namespace Drupal\pages\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class LoginForm extends FormBase {

  public function getFormId() {
    return 'pages_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => 'Username',
      '#required' => TRUE,
    ];

    $form['pass'] = [
      '#type' => 'password',
      '#title' => 'Password',
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Login',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $username = $form_state->getValue('name');
    $password = $form_state->getValue('pass');

    $uid = \Drupal::service('user.auth')->authenticate($username, $password);

    if ($uid) {
      $user = User::load($uid);
      user_login_finalize($user);

      $this->messenger()->addMessage('Login successful!');
      $form_state->setRedirect('<front>');
    } else {
      $this->messenger()->addError('Invalid username or password');
    }
  }

}
