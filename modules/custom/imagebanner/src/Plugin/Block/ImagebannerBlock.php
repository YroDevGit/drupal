<?php

namespace Drupal\imagebanner\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Imagebanner' Block.
 *
 * @Block(
 *   id = "imagebanner_block",
 *   admin_label = @Translation("Imagebanner Block"),
 *   category = @Translation("Customs")
 * )
 */
class ImagebannerBlock extends BlockBase
{
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

    $data["promotion"] = [
      "type" => "textfield",
      "label" => "Promotion text"
    ];

    $data['img'] = [
      "type" => "file",
      "label" => "Banner Image",
      "validator" => [
        'file_validate_extensions' => ['png jpg jpeg gif'],
        //'file_validate_image_resolution' => ['50x50', '2000x2000'],
      ]
    ];

    $data['buttontext'] = [
      "type" => "textfield",
      "label" => "Button text",
    ];

    $data['buttonurl'] = [
      "type" => "textfield",
      "label" => "Button url"
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
        $ret[$k] = $val;
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

  public static function ajaxCallback(array &$form, FormStateInterface $form_state)
  {
    $itemKey = "menus";
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
    $itemKey = "menus"; //fieldset item key
    $current = $form_state->get($itemKey);
    $current[] = [
      "text" => "/", //update this field.
      "url" => "/"
    ];
    $form_state->setUserInput([]); //disable or comment this if using ajax
    $form_state->set($itemKey, $current);
    $form_state->setRebuild(TRUE);
  }

  public static function removeOne(array &$form, FormStateInterface $form_state)
  {
    $itemKey = "menus"; //fieldset item key
    $trigger = $form_state->getTriggeringElement();
    $index = $trigger["#index"] ?? 0;

    $items = $form_state->get($itemKey) ?? [];

    unset($items[$index]);
    $newItems = array_values($items);

    $form_state->set($itemKey, $newItems);

    $form_state->setUserInput([]); // Refresh ang UI para ma update pati ang form.

    $form_state->setRebuild(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $except = ["img"];

    $data = $this->data();
    foreach ($data as $k => $v) {
      if(in_array($k, $except)) continue;
      $this->configuration[$k] = $form_state->getValue($k);
    }

    $item = $form_state->getValue("img");


    if(! empty($item)){
      $file = \Drupal\File\Entity\File::load($item[0]);
      //dump($file);
      if ($file) {
        $file->setPermanent();
        $file->save();
        $item['image_fid'] = $file->id(); // store the file ID instead of URL
        $item['image_url'] = \Drupal::service('file_url_generator')->generateAbsoluteString($file->getFileUri());
      }
    }

    $this->configuration["img"] = $item;

    /*
    $items = $form_state->getValue('items');
    foreach ($items as $delta => &$item) {
      if (!empty($item['image'])) {
        $file = \Drupalile\Entity\File::load($item['image'][0]);
        if ($file) {
          $file->setPermanent();
          $file->save();
          $item['image_fid'] = $file->id(); // store the file ID instead of URL
          $item['image_url'] = \Drupal::service('file_url_generator')->generateAbsoluteString(());
        }
      }
    }
    $this->configuration['items'] = $items;
    */
  }

  /**
   * {@inheritdoc}
   */

  public function filterBlockFormCtr($data, FormStateInterface $form_state, string|int $parent = null, $counter = -1)
  {
    $form = [];
    foreach ($data as $k => $v) {
      if (isset($v['type']) && ($v['type'] == "manage_file" || $v['type'] == "file")) {
        $conf = $this->configuration[$k];
        $form[$k] = [
          '#type' => 'managed_file',
          '#title' => $this->t($v['label'] ?? $k),
          '#upload_location' => 'public://main_navigation/',
          '#default_value' => $conf ?? [],
        ];
        if (isset($v['validator'])) {
          $form[$k]["#upload_validators"] = $v['validator'];
          //'file_validate_extensions' => ['png jpg jpeg gif'],
          //'file_validate_image_resolution' => ['50x50', '2000x2000'], // optional
        }
        continue;
      }
      if (isset($v['type']) && $v['type'] == "submit") {
        $form[$k] = [
          '#type' => 'submit',
          '#value' => $this->t($v['label'] ?? "Submit"),
        ];

        if (isset($v['id'])) {
          $form[$k]["#" . $v['id']] = $counter;
        }

        if (isset($v['ajax'])) {
          if (is_string($v['ajax']['callback'])) {
            $form[$k]["#ajax"]['callback'] = [get_class($this), $v['ajax']['callback']];
            $form[$k]["#ajax"]['wrapper'] = $v['ajax']['wrapper'];
          } else {
            $form[$k]["#ajax"] = $v['ajax'];
          }
        }

        if (isset($v['action']) || isset($v['callback'])) {
          $form[$k]['#submit'] = [
            [get_class($this), $v['action'] ?? $v['callback']]
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

        $wrap = $k . "-" . "wrapper";
        if (isset($v['wrapper'])) {
          $wrap =  $v['wrapper'];
        }
        $form[$k] = [
          '#type' => 'fieldset',
          '#title' => $this->t($v['label'] ?? ucfirst($k)),
          '#tree' => TRUE,
          '#prefix' => "<div id='$wrap'>",
          '#suffix' => '</div>',
        ];

        $children = $this->filterBlockFormCtr($items, $form_state, $k);

        for ($i = 0; $i < $num_items; $i++) {
          $atinIto = $akinIto[$i] ?? [];

          foreach ($children as $ikey => $child) {
            if (! isset($v['autoload']) || $v['autoload'] == false) {
              if (! isset($atinIto[$ikey]) || ! $atinIto[$ikey]) continue;
            }
            $form[$k][$i]['divider'] = [
              '#markup' => '<hr style="margin:10px 0;">',
            ];
            if (isset($child['#type']) && $child['#type'] == 'submit') {
              $child['#limit_validation_errors'] = [];
              $child['#attributes']['data-index'] = $i;
              $child["#name"] = $i + 1;
              $child["#index"] = $i + 1;
              if (isset($items[$ikey]['id'])) {
                $child['#attributes']["#" . $items[$ikey]['id']] = $i;
              }
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

  public function build()
  {
    $data = $this->data();
    $ret =  [
      '#theme' => 'imagebanner',
      '#attached' => [
        'library' => [
          'imagebanner/imagebanner-styles',
        ],
      ],
    ];
    foreach ($data as $key => $val) {
      $krg = $this->configuration[$key];
      if (is_array($krg)) {
        foreach ($krg as $k => $v) {
          if(! is_array($v)) {$ret["#" . $key] = $krg; continue;}
          $num = false;
          foreach ($v as $kk => $vv) {
            if ($vv) $num = true;
          }
          if ($num == true) $ret["#" . $key][] = $krg[$k];
        }
      } else {
        $ret["#" . $key] = $krg;
      }
    }
    //dump($ret);
    return $ret;
  }
}
