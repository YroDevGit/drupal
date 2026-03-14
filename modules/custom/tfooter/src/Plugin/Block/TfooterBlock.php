<?php
namespace Drupal\tfooter\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Provides a 'Tfooter' Block.
 *
 * @Block(
 *   id = "tfooter_block",
 *   admin_label = @Translation("Tfooter Block"),
 * )
 */
class TfooterBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function data(array $array = [])
  {
    $data['header'] = [
      "type" => "textfield",
      "label" => "header",
      "default" => "Sample header"
    ];

    $data['btn'] = [
      "type" => "submit",
      "action" =>"func",
      "label" => "Click me"
    ];

    //Add more here...

    return $data;
  }

  function func(){

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
      '#theme' => 'tfooter',
      '#attached' => [
        'library' => [
          'tfooter/tfooter-styles',
        ],
      ],
    ];
    foreach($data as $k=>$v){
      $ret["#".$k] = $this->configuration[$k];
    }
    return $ret;
  }
}
