<?php
namespace Drupal\headline\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Provides a 'Headline' Block.
 *
 * @Block(
 *   id = "headline_block",
 *   admin_label = @Translation("Headline Block"),
 * )
 */
class HeadlineBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function data(array $array = [])
  {
    $data["title"] = [
      "type" => "textfield",
      "label" => "Title",
      "default" => "Sample title"
    ];

    $data["description"] = [
      "type" => "textarea",
      "label" => "Description",
      "default" => "Sample description for YroBox component."
    ];

    $data["button_text"] = [
      "type" => "textfield",
      "label" => "Button Text",
      "default" => "Sample description for YroBox component."
    ];

    $data["button_link"] = [
      "type" => "textfield",
      "label" => "Button Link",
      "default" => "Sample description for YroBox component."
    ];

    //Add more here...

    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    $data = $this->data();
    $ret = [];
    foreach ($data as $k => $v) {
      $ret[$k] = $v["default"] ?? "";
    }

    return $ret;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $data = $this->data();
    $form = [];
    foreach ($data as $k => $v) {
      if(isset($v['type']) && $v['type'] == "submit"){
        $form[$k] = [
          '#type' => $v['type'] ?? "submit",
          '#value' => $this->t($v['label'] ?? $v['text'] ?? "Submit"),
        ];
        if(isset($v['limit_validation_errors'])){
          $form[$k]['#limit_validation_errors'] = $v['limit_validation_errors'];
        }
        if(isset($v['action']) || isset($v['submit']) || isset($v['click'])){
          $form[$k]['#submit'] = [[get_class($this), $v['action'] ?? $v['submit'] ?? $v['click']]];
        }
        continue;
      }
      if(isset($v['type']) && $v['type'] == "html"){
        $form[$k] = [
          '#markup' => $v['markup'] ?? $v['tag'] ?? "<hr>",
        ];
        continue;
      }
      $form[$k] = [
        '#type' => $v['type'] ?? "textfield",
        '#title' => $this->t($v['label'] ?? ucfirst($k)),
        '#default_value' => $this->configuration[$k],
      ];
    }
    //add something here...

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $data = $this->data();
    foreach ($data as $k=>$v){
      $this->configuration[$k] = $form_state->getValue($k);
    }
    //Add something here...

  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $data = $this->data();
    $ret =  [
      '#theme' => 'headline',
      '#attached' => [
        'library' => [
          'headline/headline-styles',
        ],
      ],
    ];
    foreach($data as $k=>$v){
      $ret["#".$k] = $this->configuration[$k];
    }
    return $ret;
  }
}
