<?php print '<?php ' ?>

/**
 * Implements hook_entity_info().
 */
function <?php print $machine_name ?>_entity_info() {
  $return['<?php print $machine_name ?>'] = array(
      'label' => t('<?php print $name ?>'),
      'entity class' => '<?php print $class_name ?>',
      'controller class' => '<?php print $class_name ?>Controller',
      'base table' => '<?php print $machine_name ?>',
      'revision table' => '<?php print $machine_name ?>_revision',
      'fieldable' => TRUE,
      'entity keys' => array(
        'id' => '<?php print $machine_name?>_id',
        'bundle' => 'type',
        'revision' => 'revision_id'
      ),
      'bundle keys' => array(
        'bundle' => 'type',
      ),
      'bundles' => array(),
      'load hook' => '<?php print $machine_name ?>_load',
      'view modes' => array(
        'full' => array(
          'label' => t('Default'),
          'custom settings' => FALSE,
        ),
      ),
      'label callback' => 'entity_class_label',
      'uri callback' => 'entity_class_uri',
      'module' => '<?php print $machine_name ?>',
      'access callback' => '<?php print $machine_name ?>_access',
  );
  $return['<?php print $machine_name ?>_type'] = array(
    'label' => t('<?php print $name ?> Type'),
    'entity class' => '<?php print $class_name ?>Type',
    'controller class' => '<?php print $class_name ?>TypeController',
    'base table' => '<?php print $machine_name ?>_type',
    'fieldable' => FALSE,
    'bundle of' => '<?php print $machine_name ?>',
    'exportable' => TRUE,
    'entity keys' => array(
      'id' => 'id',
      'name' => 'type',
      'label' => 'label',
    ),
    'module' => '<?php print $machine_name ?>',
    // Enable the entity API's admin UI.
    'admin ui' => array(
      'path' => 'admin/structure/<?php print $machine_name ?>-types',
      'file' => '<?php print $machine_name ?>.admin.inc',
      'controller class' => '<?php print $class_name ?>TypeUIController',
    ),
    'access callback' => '<?php print $machine_name ?>_type_access',
  );

  return $return;
}

/**
 * Implements hook_entity_info_alter().
 */
function <?php print $machine_name ?>_entity_info_alter(&$entity_info) {
  foreach (<?php print $machine_name ?>_types() as $type => $info) {
    $entity_info['<?php print $machine_name ?>']['bundles'][$type] = array(
      'label' => $info->label,
      'admin' => array(
        'path' => 'admin/structure/<?php print $machine_name ?>-types/manage/%<?php print $machine_name ?>_type',
        'real path' => 'admin/structure/<?php print $machine_name ?>-types/manage/' . $type,
        'bundle argument' => 4,
      ),
    );
  }
}

/**
 * Implements hook_menu().
 */
function <?php print $machine_name ?>_menu() {
  $items = array();

  $items['<?php print $machine_name ?>/add'] = array(
    'title' => 'Add <?php print $name ?>',
    'page callback' => '<?php print $machine_name ?>_admin_add_page',
    'access arguments' => array('administer <?php print $machine_name ?> entities'),
    'file' => '<?php print $machine_name ?>.admin.inc',
    'type' => MENU_LOCAL_ACTION,
    'tab_parent' => '<?php print $machine_name ?>',
    'tab_root' => '<?php print $machine_name ?>',
  );

  $<?php print $machine_name ?>_uri = '<?php print $machine_name ?>/%<?php print $machine_name ?>';
  $<?php print $machine_name ?>_uri_argument_position = 1;

  $items[$<?php print $machine_name ?>_uri] = array(
    'title callback' => 'entity_label',
    'title arguments' => array('<?php print $machine_name ?>', $<?php print $machine_name ?>_uri_argument_position),
    'page callback' => '<?php print $machine_name ?>_view',
    'page arguments' => array($<?php print $machine_name ?>_uri_argument_position),
    'access callback' => 'entity_access',
    'access arguments' => array('view', '<?php print $machine_name ?>', $<?php print $machine_name ?>_uri_argument_position),
    'file' => '<?php print $machine_name ?>.pages.inc',
  );

  $items[$<?php print $machine_name ?>_uri . '/view'] = array(
    'title' => 'View',
    'type' => MENU_DEFAULT_LOCAL_TASK,
    'weight' => -10,
  );

  $items[$<?php print $machine_name ?>_uri . '/delete'] = array(
    'title' => 'Delete <?php print $name ?>',
    'title callback' => '<?php print $machine_name ?>_label',
    'title arguments' => array($<?php print $machine_name ?>_uri_argument_position),
    'page callback' => 'drupal_get_form',
    'page arguments' => array('<?php print $machine_name ?>_delete_form', $<?php print $machine_name ?>_uri_argument_position),
    'access callback' => 'entity_access',
    'access arguments' => array('edit', '<?php print $machine_name ?>', $<?php print $machine_name ?>_uri_argument_position),
    'file' => '<?php print $machine_name ?>.admin.inc',
  );

  $items[$<?php print $machine_name ?>_uri . '/edit'] = array(
    'title' => 'Edit',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('<?php print $machine_name ?>_form', $<?php print $machine_name ?>_uri_argument_position),
    'access callback' => 'entity_access',
    'access arguments' => array('edit', '<?php print $machine_name ?>', $<?php print $machine_name ?>_uri_argument_position),
    'file' => '<?php print $machine_name ?>.admin.inc',
    'type' => MENU_LOCAL_TASK,
    'context' => MENU_CONTEXT_PAGE | MENU_CONTEXT_INLINE,
  );

  foreach (<?php print $machine_name ?>_types() as $type => $info) {
    $items['<?php print $machine_name ?>/add/' . $type] = array(
      'title' => 'Add <?php print $name ?>',
      'page callback' => '<?php print $machine_name ?>_add',
      'page arguments' => array(2),
      'access callback' => 'entity_access',
      'access arguments' => array('create', '<?php print $machine_name ?>', $type),
      'file' => '<?php print $machine_name ?>.admin.inc',
    );
  }

  $items['admin/structure/<?php print $machine_name ?>-types/%<?php print $machine_name ?>_type/delete'] = array(
    'title' => 'Delete',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('<?php print $machine_name ?>_type_form_delete_confirm', 4),
    'access arguments' => array('administer <?php print $machine_name ?> types'),
    'weight' => 1,
    'type' => MENU_NORMAL_ITEM,
    'file' => '<?php print $machine_name ?>.admin.inc',
  );

  return $items;
}

/**
 * Implements hook_permission().
 */
function <?php print $machine_name ?>_permission() {
  $permissions = array(
    'administer <?php print $machine_name ?> types' => array(
      'title' => t('Administer <?php print $name ?> types'),
      'description' => t('Allows users to configure <?php print $name ?> types and their fields.'),
      'restrict access' => TRUE,
    ),
    'create <?php print $machine_name ?> entities' => array(
      'title' => t('Create <?php print $name ?>s'),
      'description' => t('Allows users to create <?php print $name ?>s.'),
      'restrict access' => TRUE,
    ),
    'view <?php print $machine_name ?> entities' => array(
      'title' => t('View <?php print $name ?>s'),
      'description' => t('Allows users to view <?php print $name ?>s.'),
      'restrict access' => TRUE,
    ),
    'edit any <?php print $machine_name ?> entities' => array(
      'title' => t('Edit any <?php print $name ?>s'),
      'description' => t('Allows users to edit any <?php print $name ?>s.'),
      'restrict access' => TRUE,
    ),
    'edit own <?php print $machine_name ?> entities' => array(
      'title' => t('Edit own <?php print $name ?>s'),
      'description' => t('Allows users to edit own <?php print $name ?>s.'),
      'restrict access' => TRUE,
    ),
  );

  return $permissions;
}


/**
 * Implements hook_entity_property_info_alter().
 */
function <?php print $machine_name ?>_entity_property_info_alter(&$info) {
  include_once(drupal_get_path('module', '<?php print $module_name?>').'/<?php print $module_name ?>.util.inc');
  $properties = &$info['<?php print $machine_name ?>']['properties'];
  require_once drupal_get_path('module', '<?php print $machine_name ?>') .'/<?php print $machine_name ?>.install';
  $schema = <?php print $machine_name ?>_schema();
  $<?php print $machine_name ?> = $schema['<?php print $machine_name ?>'];
  foreach($<?php print $machine_name ?>['fields'] as $name => $data){
    $properties[$name] = array(
      'label' => t($data['description']),
      'type' => __<?php print $module_name ?>_get_info_type($data['type']),
      'description' => t($data['description']),
      'setter callback' => 'entity_property_verbatim_set',
      'setter permission' => 'administer <?php print $machine_name ?> entities',
      'required' => TRUE,
      'schema field' => $name,
    );
  }
}

/*
* Helper function for hook_entity_property_info
*/
function __get_info_type($type){
  switch($type){
    case 'int':
    case 'serial':
      return 'integer';
      break;
    case 'varchar':
    case 'text':
      return 'text';
  }
}

/*******************************************************************************
 ********************************* <?php print $machine_name ?> API's **********************************
 ******************************************************************************/

/**
 * Access callback for <?php print $machine_name ?>.
 */
function <?php print $machine_name ?>_access($op, $<?php print $machine_name ?>, $account = NULL, $entity_type = NULL) {
  global $user;

  if (!isset($account)) {
    $account = $user;
  }
  switch ($op) {
    case 'create':
      return user_access('administer <?php print $machine_name ?> entities', $account)
          || user_access('create <?php print $machine_name ?> entities', $account);
    case 'view':
      return user_access('administer <?php print $machine_name ?> entities', $account)
          || user_access('view <?php print $machine_name ?> entities', $account);
    case 'edit':
      return user_access('administer <?php print $machine_name ?> entities')
          || user_access('edit any <?php print $machine_name ?> entities')
          || (user_access('edit own <?php print $machine_name ?> entities') && ($<?php print $machine_name ?>->uid == $account->uid));
  }
}

/**
 * Load a <?php print $machine_name ?>.
 */
function <?php print $machine_name ?>_load($entity_id, $reset = FALSE) {
  $<?php print $machine_name ?>s = <?php print $machine_name ?>_load_multiple(array($entity_id), array(), $reset);
  return reset($<?php print $machine_name ?>s);
}

/**
 * Load multiple <?php print $machine_name ?>s based on certain conditions.
 */
function <?php print $machine_name ?>_load_multiple($entity_ids = array(), $conditions = array(), $reset = FALSE) {
  return entity_load('<?php print $machine_name ?>', $entity_ids, $conditions, $reset);
}

/**
 * Save <?php print $machine_name ?>.
 */
function <?php print $machine_name ?>_save($<?php print $machine_name ?>) {
  entity_save('<?php print $machine_name ?>', $<?php print $machine_name ?>);
}

/**
 * Delete single <?php print $machine_name ?>.
 */
function <?php print $machine_name ?>_delete($<?php print $machine_name ?>) {
  entity_delete('<?php print $machine_name ?>', entity_id('<?php print $machine_name ?>' ,$<?php print $machine_name ?>));
}

/**
 * Delete multiple <?php print $machine_name ?>s.
 */
function <?php print $machine_name ?>_delete_multiple($<?php print $machine_name ?>_ids) {
  entity_delete_multiple('<?php print $machine_name ?>', $<?php print $machine_name ?>_ids);
}


/*******************************************************************************
 ****************************** <?php print $machine_name ?> Type API's ********************************
 ******************************************************************************/

/**
 * Access callback for <?php print $machine_name ?> Type.
 */
function <?php print $machine_name ?>_type_access($op, $entity = NULL) {
  return user_access('administer <?php print $machine_name ?> types');
}

/**
 * Load <?php print $machine_name ?> Type.
 */
function <?php print $machine_name ?>_type_load($<?php print $machine_name ?>_type) {
  return <?php print $machine_name ?>_types($<?php print $machine_name ?>_type);
}

/**
 * List of <?php print $machine_name ?> Types.
 */
function <?php print $machine_name ?>_types($type_name = NULL) {
  $types = entity_load_multiple_by_name('<?php print $machine_name ?>_type', isset($type_name) ? array($type_name) : FALSE);
  return isset($type_name) ? reset($types) : $types;
}

/**
 * Save <?php print $machine_name ?> type entity.
 */
function <?php print $machine_name ?>_type_save($<?php print $machine_name ?>_type) {
  entity_save('<?php print $machine_name ?>_type', $<?php print $machine_name ?>_type);
}

/**
 * Delete single case type.
 */
function <?php print $machine_name ?>_type_delete($<?php print $machine_name ?>_type) {
  entity_delete('<?php print $machine_name ?>_type', entity_id('<?php print $machine_name ?>_type' ,$<?php print $machine_name ?>_type));
}

/**
 * Delete multiple case types.
 */
function <?php print $machine_name ?>_type_delete_multiple($<?php print $machine_name ?>_type_ids) {
  entity_delete_multiple('<?php print $machine_name ?>_type', $<?php print $machine_name ?>_type_ids);
}

/**
  * Implements hook_views_api().
  */
function <?php print $machine_name ?>_views_api() {
  return array(
    'api' => 3,
    'path' => drupal_get_path('module', '<?php print $machine_name ?>'),
  );
}

