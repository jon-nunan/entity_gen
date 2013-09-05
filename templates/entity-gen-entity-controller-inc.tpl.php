<?php print '<?php ' ?>

class <?php print $class_name ?>Controller extends EntityAPIController {

  public function create(array $values = array()) {
    global $user;
    $values += array(
      'title' => '',
      'description' => '',
      'created' => REQUEST_TIME,
      'updated' => REQUEST_TIME,
      'uid' => $user->uid,
    );
    return parent::create($values);
  }

  public function buildContent($entity, $view_mode = 'full', $langcode = NULL, $content = array()) {
    $wrapper = entity_metadata_wrapper('<?php print $machine_name?>', $entity);
    $content['author'] = array('#markup' => t('Created by: !author', array('!author' => $wrapper->uid->name->value(array('sanitize' => TRUE)))));

    // Make Description and Status themed like default fields.
    $content['description'] = array(
      '#theme' => 'field',
      '#weight' => 0,
      '#title' =>t('Description'),
      '#access' => TRUE,
      '#label_display' => 'above',
      '#view_mode' => 'full',
      '#language' => LANGUAGE_NONE,
      '#field_name' => 'field_fake_description',
      '#field_type' => 'text',
      '#entity_type' => '<?php print $machine_name?>',
      '#bundle' => $entity->type,
      '#items' => array(array('value' => $entity->name)),
      '#formatter' => 'text_default',
      0 => array('#markup' => check_plain($entity->name))
    );

    return parent::buildContent($entity, $view_mode, $langcode, $content);
  }
}

 class <?php print $class_name ?>TypeController extends EntityAPIControllerExportable {
   public function create(array $values = array()) {
    $values += array(
      'label' => '',
      'description' => '',
    );
    return parent::create($values);
  }

  /**
   * Save Task Type.
   */
  public function save($entity, DatabaseTransaction $transaction = NULL) {
    parent::save($entity, $transaction);
    // Rebuild menu registry. We do not call menu_rebuild directly, but set
    // variable that indicates rebuild in the end.
    // @see http://drupal.org/node/1399618
    variable_set('menu_rebuild_needed', TRUE);
  }
}

/**
 * UI controller for Task Type.
 */
class <?php print $class_name ?>TypeUIController extends EntityDefaultUIController {
  /**
   * Overrides hook_menu() defaults.
   */
  public function hook_menu() {
    $items = parent::hook_menu();
    $items[$this->path]['description'] = 'Manage <?php print $name ?> types.';
    return $items;
  }
}

/**
 * Task class.
 */
class <?php print $class_name?> extends Entity {
  protected function defaultLabel() {
    return $this->name;
  }

  protected function defaultUri() {
    return array('path' => '<?php print $machine_name?>/' . $this->identifier());
  }
}

/**
 * Task Type class.
 */
class <?php print $class_name ?>Type extends Entity {
  public $type;
  public $label;
  public $weight = 0;

  public function __construct($values = array()) {
    parent::__construct($values, '<?php print $machine_name?>_type');
  }

  function isLocked() {
    return isset($this->status) && empty($this->is_new) && (($this->status & ENTITY_IN_CODE) || ($this->status & ENTITY_FIXED));
  }
}
