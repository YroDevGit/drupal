<?php

namespace Drupal\yrocards\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'YroCards' Block.
 *
 * @Block(
 *   id = "yrocards_block",
 *   admin_label = @Translation("YroCards Block"),
 * )
 */
class YroCardsBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return [
      'section_title' => 'Our Services',
      'section_description' => 'Explore our offerings',
      'items' => [
        [
          'title' => 'Card 1',
          'description' => 'Sample description',
          'image_url' => '',
          'button_text' => 'View',
          'button_url' => '#',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {

    // Section title and description
    $form['section_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Section Title'),
      '#default_value' => $this->configuration['section_title'],
    ];

    $form['section_description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Section Description'),
      '#default_value' => $this->configuration['section_description'],
    ];

    // Track number of cards
    $num_items = $form_state->get('num_items');
    if ($num_items === NULL) {
      $num_items = count($this->configuration['items']);
      $form_state->set('num_items', $num_items);
    }

    // Fieldset for cards
    $form['items'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Card Items'),
    ];



    // Build card fields
    for ($i = 0; $i < $num_items; $i++) {
      $item = $this->configuration['items'][$i] ?? [];

      $form['items'][$i]['divider'] = [
        '#markup' => '<hr style="margin:10px 0;">',
      ];

      $form['items'][$i]['title'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Card Title'),
        '#default_value' => $item['title'] ?? '',
      ];

      $form['items'][$i]['description'] = [
        '#type' => 'textarea',
        '#title' => $this->t('Card Description'),
        '#default_value' => $item['description'] ?? '',
      ];

      $form['items'][$i]['image'] = [
        '#type' => 'managed_file',
        '#title' => $this->t('Card Image'),
        '#upload_location' => 'public://yrocards/', // where the uploaded file will be stored
        '#default_value' => isset($item['image_fid']) ? [$item['image_fid']] : NULL,
        '#upload_validators' => [
          'file_validate_extensions' => ['png jpg jpeg gif'],
          //'file_validate_image_resolution' => ['50x50', '2000x2000'], // optional
        ],
      ];

      $form['items'][$i]['button_text'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Button Text'),
        '#default_value' => $item['button_text'] ?? 'View',
      ];

      $form['items'][$i]['button_url'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Button URL'),
        '#default_value' => $item['button_url'] ?? '#',
      ];
      $form['items'][$i]['remove'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove'),
        '#submit' => [[get_class($this), 'removeOne']], // points to static remove handler
        '#limit_validation_errors' => [], // skip validation
        '#card_index' => $i, // keep track of which card
      ];
    }

    // Add Card button — rebuilds form
    $form['add_item'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add Card'),
      '#submit' => [[get_class($this), 'addOne']],
      '#limit_validation_errors' => [], // Skip validation to just add a card
    ];

    //dump($form);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $this->configuration['section_title'] = $form_state->getValue('section_title');
    $this->configuration['section_description'] = $form_state->getValue('section_description');
    $items = $form_state->getValue('items');
    foreach ($items as $delta => &$item) {
      if (!empty($item['image'])) {
        $file = \Drupal\file\Entity\File::load($item['image'][0]);
        if ($file) {
          $file->setPermanent();
          $file->save();
          $item['image_fid'] = $file->id(); // store the file ID instead of URL
          $item['image_url'] = \Drupal::service('file_url_generator')->generateAbsoluteString($file->getFileUri());
        }
      }
    }
    $this->configuration['items'] = $items;
  }

  public static function removeOne(array &$form, FormStateInterface $form_state)
  {
    // Get which card to remove
    $trigger = $form_state->getTriggeringElement();
    $index = $trigger['#card_index'];

    // Get current items
    $items = $form_state->getValue('items') ?? [];

    // Remove the selected card
    if (isset($items[$index])) {
      array_splice($items, $index, 1);
    }

    // Update items in form_state
    $form_state->setValue('items', $items);

    // Update num_items
    $form_state->set('num_items', count($items));

    // Rebuild form to reflect change
    $form_state->setRebuild(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    return [
      '#theme' => 'yrocards',
      '#section_title' => $this->configuration['section_title'],
      '#section_description' => $this->configuration['section_description'],
      '#items' => $this->configuration['items'],
    ];
  }

  /**
   * Submit callback to add a new card.
   */
  public static function addOne(array &$form, FormStateInterface $form_state)
  {
    $num_items = $form_state->get('num_items') ?? 0;
    $num_items++;
    $form_state->set('num_items', $num_items);
    $form_state->setRebuild(TRUE);
  }
}
