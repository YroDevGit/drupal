<?php

namespace Drupal\carousel\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Carousel' Block.
 *
 * @Block(
 *   id = "carousel_block",
 *   admin_label = @Translation("Carousel Block"),
 *   category = @Translation("Customs")
 * )
 */
class CarouselBlock extends BlockBase
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

    $data['people'] = [
      "type" => "fieldset",
      "label" => "people",
      "items" => [
        "name" => [
          "type" => "textfield",
          "label" => "Name"
        ],
        "details" => [
          "type" => "textfield",
          "label" => "Details"
        ],
        "url" => [
          "type" => "textfield",
          "label" => "URL",
        ],
        "img" => [
          "type" => "file",
          "label" => "image",
          "validator" => [
            'file_validate_extensions' => ['png jpg jpeg gif']
          ]
          ],
        "rem" => [
          "type" => "submit",
          "label" => "Remove",
          "action" => "removeOne"
        ]
      ]
    ];

    $data['btn'] = [
      "type" => "submit",
      "label" => "Add people",
      "action" => "addOne"
    ];

    //Add more here...

    return $data;
  }

  public static function addOne(array &$form, FormStateInterface $form_state)
  {
    $itemKey = "people"; //fieldset item key

    $current = $form_state->get($itemKey);

    $current[] = [
      "name" => "/", //update this field.
      "details" => "/",
      "url" => "/",
      "img" => "/",
      "rem" => "/"
    ];

    $form_state->set($itemKey, $current);
    $newInput = $form_state->getUserInput(); // Save ang form input value antis mg reload para nd madula ang mga value
    $form_state->setUserInput($newInput); // Refresh ang UI para ma update pati ang form.

    $form_state->setRebuild(TRUE);
  }

  public static function removeOne(array &$form, FormStateInterface $form_state)
  {
    $itemKey = "people"; //fieldset item key

    $trigger = $form_state->getTriggeringElement();
    $index = $trigger["#index"] ?? 0;
    $items = $form_state->get($itemKey) ?? [];
    unset($items[$index]);
    $newItems = array_values($items);

    $form_state->set($itemKey, $newItems);
    $newInput = $form_state->getUserInput();// Save ang form input value antis mg reload para nd madula ang mga value
    unset($newInput['settings'][$itemKey][$index]); // kakson ang UI sa item nga gn removed
    $newData = array_values($newInput['settings'][$itemKey] ?? []);
    $newInput['settings'][$itemKey] = $newData;
    $form_state->setUserInput($newInput); // Refresh ang UI para ma update pati ang form.
    $form_state->setRebuild(TRUE);
  }

  public static function ajaxCallback(array $form, FormStateInterface $form_state)
  {
    $itemKey = "people";
    $complete_form = $form_state->getCompleteForm();

    if (isset($complete_form[$itemKey])) {
      return $complete_form[$itemKey];
    }

    if (isset($complete_form['settings'][$itemKey])) {
      return $complete_form['settings'][$itemKey];
    }
    return $complete_form;
  }


  //Below are the core methods, do not modify.

  /**
   * {@inheritdoc}
   * This is a core function, modifying it can cause errors
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $except = []; //keys that has custom process below

    $data = $this->data();
    $this->blockSubmiteFilterCTR($data, $except, $form, $form_state);


    $parentKey = "people"; //parent key
    $childKey = "img"; //child key

    $items = $form_state->getValue($parentKey); //parent key
    foreach ($items as $delta => &$item) {
      if (!empty($item[$childKey])) {
        $file = \Drupal\File\Entity\File::load($item[$childKey][0]);
        if ($file) {
          $file->setPermanent();
          $file->save();
          $item[$childKey] = [
            'image_fid' => $file->id(),
            'image_url' => \Drupal::service('file_url_generator')->generateAbsoluteString($file->getFileUri())
          ];
        }
      }
    }
    $this->configuration[$parentKey] = $items;

  }

  /**
   * {@inheritdoc}
   * This is a core function, modifying it can cause errors
   */
  public function defaultConfiguration()
  {
    $data = $this->data();
    $ret = [];

    foreach ($data as $k => $v) {
      $val = $v["default"] ?? $v["items"] ?? "";
      if (! $val) continue;

      if (is_array($val)) {
        if (! isset($v['autoload']) || $v['autoload'] == false) {
          continue;
        }
        $arr = [];
        foreach ($val as $key => $value) {
          if (isset($value['type'])) {
            if ($value['type'] == "submit") {
              continue;
            }
            if ($value['type'] == "file" || $value['type'] == "manage_file") {
              $arr[$key] = $value['default'] ?? [];
              continue;
            }
          }
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
   * This is a core function, modifying it can cause errors
   */
  public function blockSubmiteFilterCTR($data, $except, $form, $form_state)
  {
    foreach ($data as $k => $v) {
      if (in_array($v, $except)) continue;
      if (isset($v['type'])) {
        if ($v['type'] == "submit") continue;
        if ($v['type'] == "markup" || $v['type'] == "html") continue;
        if ($v['type'] == "fieldset") {
          $items = $v['items'];
          if (! empty($items)) {
            foreach ($items as $ko => $lo) {
              $this->blockSubmiteFilterCTR($lo, [], $form, $form_state);
            }
          }
        }
        $val = $form_state->getValue($k);
        $this->configuration[$k] = $val;
      }
    }
  }

  /**
   * {@inheritdoc}
   * This is a core function, modifying it can cause errors
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $data = $this->data();
    $form = [];
    $form = $this->filterBlockFormCtr($data, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   * This is a core function, modifying it can cause errors
   */
  public function filterBlockFormCtr($data, FormStateInterface $form_state, string|int $parent = null, $counter = -1)
  {
    $form = [];
    foreach ($data as $k => $v) {
      $conf = [];
      if ($parent) {
        //$conf = $this->configuration[$parent] ?? null;
      } else {
        $conf = $this->configuration[$k] ?? null;
      }

      if (isset($v['type']) && ($v['type'] == "manage_file" || $v['type'] == "file")) {
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
              $child["#index"] = $i;
              if (isset($items[$ikey]['id'])) {
                $child['#attributes']["#" . $items[$ikey]['id']] = $i;
              }
            } else if (isset($child['#type']) && ($child['#type'] == 'file' || $child['#type'] == 'managed_file')) {
              if (isset($atinIto[$ikey]) && ! is_array($atinIto[$ikey])) {
                $atinIto[$ikey] = [];
              }
              $child['#default_value'] =  $atinIto[$ikey] ?? [];
            } else {
              $child['#default_value'] = $atinIto[$ikey] ?? "";
            }
            //dump($child);
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

  public function getEmployeesWithPicture() {
    //$result = $connection->query("SELECT * FROM users_field_data");
    //$users = $result->fetchAll();
    // 1. Query users with role 'emp'
    $uids = \Drupal::entityQuery('user')
      ->condition('roles', 'emp')
      ->accessCheck(false)
      ->execute();

    $users = User::loadMultiple($uids);

    $employees = [];

    foreach ($users as $user) {
      $firstname = $user->get('field_firstname')->value ?? '';
      $lastname  = $user->get('field_lastname')->value ?? '';
      $email     = $user->getEmail() ?? $user->get("name")->value;
      $roles     = $user->getRoles();
      $uid       = $user->id();

      $picture_url = null;
      if (!$user->get('user_picture')->isEmpty()) {
        $file = $user->get('user_picture')->entity; // File entity
        $picture_url = \Drupal::service('file_url_generator')
          ->generateString($file->getFileUri());
      }
      $employees[] = [
        'uid'       => $uid,
        'firstname' => $firstname,
        'lastname'  => $lastname,
        'email'     => $email,
        'roles'     => $roles,
        'img'   => $picture_url,

      ];
    }

    return $employees;
  }

  /**
   * {@inheritdoc}
   * This is a core function, modifying it can cause errors
   */
  public function build()
  {
    $data = $this->data();
    $ret =  [
      '#theme' => 'carousel',
      '#attached' => [
        'library' => [
          'carousel/carousel-styles',
        ],
      ],
    ];
    foreach ($data as $key => $val) {
      $krg = $this->configuration[$key] ?? null;
      if (is_array($krg)) {
        foreach ($krg as $k => $v) {
          if (! is_array($v)) {
            $ret["#" . $key] = $krg;
            continue;
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
    unset($ret['#people']);

    $ret['#people'] = $this->getEmployeesWithPicture();
    return $ret;
  }
}
