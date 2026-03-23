<?php

namespace Drupal\main_navigation\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Main_navigation' Block.
 *
 * @Block(
 *   id = "main_navigation_block",
 *   admin_label = @Translation("Main_navigation Block"),
 *   category = @Translation("Customs")
 * )
 */
class Main_navigationBlock extends BlockBase
{
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
      "default" => "Sample description for YroBox component and CTR."
    ];

    $data['button'] = [
      "type" => "submit",
      "label" => "add link",
      "action" => "addOne"
    ];

    $data["menus"] = [
      "type" => "fieldset",
      "label" => "Menu Items",
      "id" => "menus_count",
      "auto" => false,
      "items" => [
        "text" => [
          "type" => "textfield",
          "label" => "Label",
        ],
        "url" => [
          "type" => "textfield",
          "label" => "Link or URL",
        ],
        "btn" => [
          "type" => "submit",
          "label" => "Remove",
          "action" => "removeOne",
          "id" => "rem1",

        ]
      ]
    ];

    return $data;
  }

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

  public function blockForm($form, FormStateInterface $form_state)
  {
    $data = $this->data();
    $form = [];
    $form = $this->filterBlockFormCtr($data, $form_state);
    return $form;
  }

  public static function ajaxCallback(array &$form, FormStateInterface $form_state)
  {
    $complete_form = $form_state->getCompleteForm();

    if (isset($complete_form['menus'])) {
      return $complete_form['menus'];
    }

    if (isset($complete_form['settings']['menus'])) {
      return $complete_form['settings']['menus'];
    }
    return $complete_form;
  }

  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $except = [];
    $data = $this->data();

    foreach ($data as $k => $v) {
      if(isset($v['type'])){
        if($v['type'] == "submit" || $v['type'] == "markup"){continue;};
        if($v['type'] == "fieldset"){
          $newItems = $form_state->getValue($k);
          //dump($newItems);
          foreach($newItems as $ko=>$vo){

            if(is_array($vo)){
              $quib = [];
              foreach($vo as $kl =>$vl){
                if(is_string($vl) || is_numeric($vl)){

                  $quib[$kl] = $vl;
                }
              }
              $this->configuration[$k][] = $quib;


            }
          }



          continue;
        }
      }
      if(in_array($v, $except)) continue;
      $this->configuration[$k] = $form_state->getValue($k);
    }

    //$this->configuration = [];

    dump($this->configuration);

    //dump($this->configuration);

    /*
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
    */
    //dump($this->configuration);
  }

  public static function addOne(array &$form, FormStateInterface $form_state)
  {
    $current = $form_state->get("menus");
    $current[] = [
      "text" => "/",
      "url" => "/"
    ];

    $form_state->setUserInput([]);
    $form_state->set("menus", $current);
    $form_state->setRebuild(TRUE);
  }

  public static function removeOne(array &$form, FormStateInterface $form_state)
{
  $trigger = $form_state->getTriggeringElement();
  $index = $trigger["#index"] ?? 0;

  $items = $form_state->get('menus') ?? [];

  //unset($items[$index]);
  $newItems = array_values($items);

  $form_state->set("menus", $newItems);

  $form_state->setUserInput([]); // Refresh ang UI para ma update pati ang form.

  $form_state->setRebuild(TRUE);
}

public function filterBlockFormCtr($data, FormStateInterface $form_state, string|int $parent = null, $counter = -1)
  {
    $form = [];
    foreach ($data as $k => $v) {
      if(isset($v['type']) && ($v['type'] == "manage_file" || $v['type'] == "file")){

        $conf = $this->configuration[$k];
        $form[$k] = [
          '#type' => 'managed_file',
          '#title' => $this->t($v['label'] ?? $k),
          '#upload_location' => 'public://main_navigation/',
          '#default_value' => $conf['image_fid'] ?? $conf['image_fid'] ?? NULL,
        ];
        if(isset($v['validator'])){
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

        if(isset($v['id'])){
          $form[$k]["#".$v['id']] = $counter;
        }

        if (isset($v['ajax'])) {
          if(is_string($v['ajax']['callback'])){
            $form[$k]["#ajax"]['callback'] =[get_class($this), $v['ajax']['callback']];
            $form[$k]["#ajax"]['wrapper'] = $v['ajax']['wrapper'];
          }else{
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

        $wrap = $k."-"."wrapper";
        if(isset($v['wrapper'])){
          $wrap =  $v['wrapper'];
        }
        $form[$k] = [
          '#type' => 'fieldset',
          '#title' => $this->t($v['label']),
          '#tree' => TRUE,
          '#prefix' => "<div id='$wrap'>",
          '#suffix' => '</div>',
        ];

        $children = $this->filterBlockFormCtr($items, $form_state, $k);

        for ($i = 0; $i < $num_items; $i++) {
          $atinIto = $akinIto[$i] ?? [];

          $form[$k][$i]['divider'] = [
            '#markup' => '<hr style="margin:10px 0;">',
          ];

          foreach ($children as $ikey => $child) {
            if (isset($child['#type']) && $child['#type'] == 'submit') {
              $child['#limit_validation_errors'] = [];
              $child['#attributes']['data-index'] = $i;
              $child["#name"] = $i + 1;
              $child["#index"] = $i + 1;
              if(isset($items[$ikey]['id'])){
                $child['#attributes']["#".$items[$ikey]['id']]= $i;
              }
            } else {
              if(! isset($v['autoload']) || $v['autoload'] == false){
                if(! $atinIto[$ikey]) continue;
              }
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

    $ret = [
      '#theme' => 'main_navigation',
      '#attached' => [
        'library' => [
          'main_navigation/main_navigation-styles',
        ],
      ],
    ];

    foreach ($data as $key => $val) {
      $krg = $this->configuration[$key];
      if (is_array($krg)) {
        foreach ($krg as $k => $v) {
          if(! is_array($v)){
            if(is_string($v) || is_numeric($v)){
              $ret["#" . $key] = $krg; continue;
            }

          }
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
    return $ret;
  }
}
