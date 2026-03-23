<?php
namespace Drupal\test\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Provides a 'Test' Block.
 *
 * @Block(
 *   id = "test_block",
 *   admin_label = @Translation("Test Block"),
 * )
 */
class TestBlock extends BlockBase {
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
      $val = $v["default"] ?? $v["items"] ?? "";
      if (! $val) continue;

      if (is_array($val)) {
        $arr = [];
        foreach ($val as $key => $value) {
          $arr[$key] = $value['default'] ?? "";
        }
        $ret[$k][] = $arr;
      } else {
        $ret[templates] = $val;
      }
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
    $form = $this->filterBlockFormCtr($data, $form_state);
    return $form;
  }

  public function filterBlockFormCtr($data, FormStateInterface $form_state, string|int $parent = null, &$counter = -1)
  {
    $form = [];
    foreach ($data as $k => $v) {
      $counter++;
      if (isset($v['type']) && $v['type'] == "submit") {
        $form[$k] = [
          '#type' => 'submit',
          '#value' => $this->t($v['label'] ?? "Submit"),
          "#id" => $v['id'] ?? $k,
        ];

        if (isset($v['ajax'])) {
          $form[$k]["#ajax"] = $v['ajax'];
        }

        if (isset($v['action'])) {
          $form[$k]['#submit'] = [
            [get_class($this), $v['action']]
          ];
        }
        continue;
      }

      if (isset($v['type']) && $v['type'] == "fieldset") {

        $items = $v['items'] ?? [];

        $triggerBtn = true;
        $akinIto = $form_state->get($k);

        $form_state->set($k, $form_state->get($k) ?? $this->configuration[$k] ?? []);

        if ($akinIto === NULL) {
          $triggerBtn = false;
          $akinIto = $form_state->get($k);
        }

        unset($akinIto[0]);
        $akinIto = array_values($akinIto);

        $num_items = 0;
        if ($form_state->get($k)) {
          $num_items = count($akinIto);
        } else {
          $num_items = count($akinIto);
        }

        $form[$k] = [
          '#type' => 'fieldset',
          '#title' => $this->t($v['label']),
          '#tree' => TRUE,
          '#prefix' => '<div id="menus-wrapper">',
          '#suffix' => '</div>',
        ];

        $children = $this->filterBlockFormCtr($items, $form_state, $k, $counter);

        for ($i = 0; $i < $num_items; $i++) {
          $atinIto = $akinIto[$i] ?? [];

          $form[$k][$i]['divider'] = [
            '#markup' => '<hr style="margin:10px 0;">',
          ];

          foreach ($children as $ikey => $child) {
            if (isset($child['#type']) && $child['#type'] == 'submit') {

              $child['#limit_validation_errors'] = [];
              $child['#attributes']['data-index'] = $i;
            } else {
              $child['#default_value'] = $atinIto[$ikey] ?? "";
            }
            $form[$k][$i][$ikey] = $child;
          }
        }
        continue;
      }

      $form[$k] = [
        '#type' => $v['type'] ?? "textfield",
        '#title' => $this->t($v['label'] ?? ucfirst($k)),
        '#default_value' => $this->configuration[$k] ?? "",
      ];
    }
    return $form;
  }

  public static function ajaxCallback(array &$form, FormStateInterface $form_state)
  {
    $itemKey = "items"; //Change this to the key/name of you fieldset.

    $complete_form = $form_state->getCompleteForm();

    if (isset($complete_form[$itemKey])) {
      return $complete_form[$itemKey];
    }

    if (isset($complete_form['settings'][$itemKey])) {
      return $complete_form['settings'][$itemKey];
    }
    return $complete_form;
  }

  public static function addOne(array &$form, FormStateInterface $form_state)
  {
    $itemKey = "items"; //Change this to the key/name of you fieldset.

    $current = $form_state->get($itemKey);
    $current[] = [
      "text" => "/", // Change the value based on your fieldset
      "url" => "/"
    ];

    $form_state->set($itemKey, $current);
    $form_state->setRebuild(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $data = $this->data();

    foreach ($data as $k => $v) {
      $this->configuration[$k] = $form_state->getValue($k);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $data = $this->data();
    $ret =  [
      '#theme' => 'test',
      '#attached' => [
        'library' => [
          'test/test-styles',
        ],
      ],
    ];
    foreach($data as $k=>$v){
      $ret["#".$k] = $this->configuration[$k];
    }
    return $ret;
  }
}