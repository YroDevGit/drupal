<?php

namespace Drupal\yrobox\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'YroBox' Block.
 *
 * @Block(
 *   id = "yrobox_block",
 *   admin_label = @Translation("YroBox Block"),
 * )
 */
class YroBoxBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'title' => 'Sample Title',
      'description' => 'Sample description for YroBox component.',
      'image_url' => '',
      'button_url' => '#',
      'button_text' => 'View',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->configuration['title'],
    ];
    $form['description'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Description'),
      '#default_value' => $this->configuration['description'],
    ];
    $form['image_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Image URL'),
      '#default_value' => $this->configuration['image_url'],
    ];
    $form['button_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Button Text'),
      '#default_value' => $this->configuration['button_text'],
    ];
    $form['button_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Button URL'),
      '#default_value' => $this->configuration['button_url'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['title'] = $form_state->getValue('title');
    $this->configuration['description'] = $form_state->getValue('description');
    $this->configuration['image_url'] = $form_state->getValue('image_url');
    $this->configuration['button_text'] = $form_state->getValue('button_text');
    $this->configuration['button_url'] = $form_state->getValue('button_url');
  }

  /**
   * {@inheritdoc}
   */
  /**
 * {@inheritdoc}
 */
/**
 * {@inheritdoc}
 */
public function build() {
  return [
    '#theme' => 'yrobox',
    '#title' => $this->configuration['title'],
    '#description' => $this->configuration['description'],
    '#image_url' => $this->configuration['image_url'],
    '#button_text' => $this->configuration['button_text'],
    '#button_url' => $this->configuration['button_url'],
    '#attached' => [
      'library' => [
        'yrobox/yrobox-styles',
      ],
    ],
  ];
}

}
