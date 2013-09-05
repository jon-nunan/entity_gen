<?php print '<?php ' ?>

/**
 * Generates the <?php print $name ?> type editing form.
 */
function <?php print $machine_name ?>_type_form($form, &$form_state, $<?php print $machine_name ?>_type, $op = 'edit') {

  if ($op == 'clone') {
    $<?php print $machine_name ?>_type->label .= ' (cloned)';
    $<?php print $machine_name ?>_type->type = '';
  }

  $form['label'] = array(
    '#title' => t('Label'),
    '#type' => 'textfield',
    '#default_value' => $<?php print $machine_name ?>_type->label,
    '#description' => t('The human-readable name of this <?php print $name ?> type.'),
    '#required' => TRUE,
    '#size' => 30,
  );

  // Machine-readable type name.
  $form['type'] = array(
    '#type' => 'machine_name',
    '#default_value' => isset($<?php print $machine_name ?>_type->type) ? $<?php print $machine_name ?>_type->type : '',
    '#maxlength' => 32,
    '#disabled' => $<?php print $machine_name ?>_type->isLocked() && $op != 'clone',
    '#machine_name' => array(
      'exists' => '<?php print $machine_name ?>_types',
      'source' => array('label'),
    ),
    '#description' => t('A unique machine-readable name for this <?php print $name ?> type. It must only contain lowercase letters, numbers, and underscores.'),
  );

  $form['description'] = array(
    '#type' => 'textarea',
    '#default_value' => isset($<?php print $machine_name ?>_type->description) ? $<?php print $machine_name ?>_type->description : '',
    '#description' => t('Description about the <?php print $name?> type.'),
  );

  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save <?php print $name?> type'),
    '#weight' => 40,
  );

  if (!$<?php print $machine_name ?>_type->isLocked() && $op != 'add' && $op != 'clone') {
    $form['actions']['delete'] = array(
      '#type' => 'submit',
      '#value' => t('Delete <?php print $name?> type'),
      '#weight' => 45,
      '#limit_validation_errors' => array(),
      '#submit' => array('<?php print $machine_name ?>_type_form_submit_delete')
    );
  }
  return $form;
}

/**
 * Submit handler for creating/editing <?php print $machine_name ?>_types.
 */
function <?php print $machine_name ?>_type_form_submit(&$form, &$form_state) {
  $<?php print $machine_name ?>_type = entity_ui_form_submit_build_entity($form, $form_state);
  // Save and go back.
  <?php print $machine_name ?>_type_save($<?php print $machine_name ?>_type);

  // Redirect user back to list of <?php print $name ?> types.
  $form_state['redirect'] = 'admin/structure/<?php print $machine_name ?>-types';
}

function <?php print $machine_name ?>_type_form_submit_delete(&$form, &$form_state) {
  $form_state['redirect'] = 'admin/structure/<?php print $machine_name ?>-types/' . $form_state['<?php print $machine_name ?>_type']->type . '/delete';
}

/**
 * <?php print $name ?> type delete form.
 */
function <?php print $machine_name ?>_type_form_delete_confirm($form, &$form_state, $<?php print $machine_name ?>_type) {
  $form_state['<?php print $machine_name ?>_types'] = $<?php print $machine_name ?>_type;
  // Always provide entity id in the same form key as in the entity edit form.
  $form['<?php print $machine_name ?>_types_id'] = array('#type' => 'value', '#value' => entity_id('<?php print $machine_name ?>_type' ,$<?php print $machine_name ?>_type));
  return confirm_form($form,
    t('Are you sure you want to delete <?php print $name ?> type %title?', array('%title' => entity_label('<?php print $machine_name ?>_types', $<?php print $machine_name ?>_type))),
    '<?php print $machine_name ?>/' . entity_id('<?php print $machine_name ?>_type' ,$<?php print $machine_name ?>_type),
    t('This action cannot be undone.'),
    t('Delete'),
    t('Cancel')
  );
}

/**
 * <?php print $name ?> type delete form submit handler.
 */
function <?php print $machine_name ?>_type_form_delete_confirm_submit($form, &$form_state) {
  $<?php print $machine_name ?>_type = $form_state['<?php print $machine_name ?>_types'];
  <?php print $machine_name ?>_type_delete($<?php print $machine_name ?>_type);

  watchdog('<?php print $machine_name ?>_type', '@type: deleted %title.', array('@type' => $<?php print $machine_name ?>_type->type, '%title' => $<?php print $machine_name ?>_type->label));
  drupal_set_message(t('@type %title has been deleted.', array('@type' => $<?php print $machine_name ?>_type->type, '%title' => $<?php print $machine_name ?>_type->label)));

  $form_state['redirect'] = 'admin/structure/<?php print $machine_name ?>-types';
}

/**
 * Page to select <?php print $name ?> Type to add new <?php print $machine_name ?>.
 */
function <?php print $machine_name ?>_admin_add_page() {
  $items = array();
  foreach (<?php print $machine_name ?>_types() as $<?php print $machine_name ?>_type_key => $<?php print $machine_name ?>_type) {
    $items[] = l(entity_label('<?php print $machine_name ?>_type', $<?php print $machine_name ?>_type), '<?php print $machine_name ?>/add/' . $<?php print $machine_name ?>_type_key);
  }
  return array('list' => array('#theme' => 'item_list', '#items' => $items, '#title' => t('Select type of <?php print $name ?> to create.')));
}

/**
 * Add new <?php print $name ?> page callback.
 */
function <?php print $machine_name ?>_add($type) {
  $<?php print $machine_name ?>_type = <?php print $machine_name ?>_types($type);

  $<?php print $machine_name ?>= entity_create('<?php print $machine_name ?>', array('type' => $type));
  drupal_set_title(t('Create @name', array('@name' => entity_label('<?php print $machine_name ?>_types', $<?php print $machine_name ?>_type))));

  $output = drupal_get_form('<?php print $machine_name ?>_form', $<?php print $machine_name ?>);

  return $output;
}

/**
 * <?php print $name ?> Form.
 */
function <?php print $machine_name ?>_form($form, &$form_state, $<?php print $machine_name ?>) {
  $form_state['<?php print $machine_name ?>'] = $<?php print $machine_name ?>;

$form = array(

<?
//for each config field print out form api field
foreach ($entity['fields'] as $field) {
  if(!is_array($field)){

  }else{
    switch($field['type']){
      case 'blob':
        $type = 'file';
        break;
      case 'datetime':
        $type = 'date';
        break;
      case 'numeric':
      case 'int':
      case 'numeric':
      case 'float':
      case 'varchar':
      case 'char':
        $type = 'textfield';
        break;
      case 'text':
        $type = 'textarea';
        break;
    }



    ?>

  '<?php print $field['machine_name'] ?>' => array(
  '#type' => '<?php print $type ?>',
  '#title' => t('<?php print $field['name']?>'),
  '#required' => <?php print $field['db options']['not null']?>,
  '#default_value' => isset($<?php print $entity['general']['machine_name']?>-><?php print $field['machine_name']?>) ?
  $<?php print $entity['general']['machine_name']?>-><?php print $field['machine_name']?> : '',
  ),
  <?php
  }
} ?>
);

  field_attach_form('<?php print $machine_name ?>', $<?php print $machine_name ?>, $form, $form_state);

  $submit = array();
  if (!empty($form['#submit'])) {
    $submit += $form['#submit'];
  }

  $form['actions'] = array(
    '#weight' => 100,
  );

  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save <?php print $machine_name ?>'),
    '#submit' => $submit + array('<?php print $machine_name ?>_form_submit'),
  );

  // Show Delete button if we edit <?php print $machine_name ?>.
  $<?php print $machine_name ?>_id = entity_id('<?php print $machine_name ?>' ,$<?php print $machine_name ?>);
  if (!empty($<?php print $machine_name ?>_id) && <?php print $machine_name ?>_access('edit', $<?php print $machine_name ?>)) {
    $form['actions']['is_new_revision'] = array(
      '#type' => 'checkbox',
      '#title' => 'create new revision',
    );
    $form['actions']['delete'] = array(
      '#type' => 'submit',
      '#value' => t('Delete'),
      '#submit' => array('<?php print $machine_name ?>_form_submit_delete'),
    );
  }

  $form['#validate'][] = '<?php print $machine_name ?>_form_validate';

  return $form;
}

function <?php print $machine_name ?>_form_validate($form, &$form_state) {

}

/**
 * <?php print $name ?> submit handler.
 */
function <?php print $machine_name ?>_form_submit($form, &$form_state) {
  $<?php print $machine_name ?>= $form_state['<?php print $machine_name ?>'];

  entity_form_submit_build_entity('<?php print $machine_name ?>', $<?php print $machine_name ?>, $form, $form_state);

  if($form_state['values']['is_new_revision'] ==1){
    $<?php print $machine_name ?>->is_new_revision = 1;
  }

  <?php print $machine_name ?>_save($<?php print $machine_name ?>);

  $<?php print $machine_name ?>_uri = entity_uri('<?php print $machine_name ?>', $<?php print $machine_name ?>);

  $form_state['redirect'] = $<?php print $machine_name ?>_uri['path'];

  drupal_set_message(t('<?php print $machine_name ?> %title saved.', array('%title' => entity_label('<?php print $machine_name ?>', $<?php print $machine_name ?>))));
}

function <?php print $machine_name ?>_form_submit_delete($form, &$form_state) {
  $<?php print $machine_name ?>= $form_state['<?php print $machine_name ?>'];
  $<?php print $machine_name ?>_uri = entity_uri('<?php print $machine_name ?>', $<?php print $machine_name ?>);
  $form_state['redirect'] = $<?php print $machine_name ?>_uri['path'] . '/delete';
}

/**
 * Delete confirmation form.
 */
function <?php print $machine_name ?>_delete_form($form, &$form_state, $<?php print $machine_name ?>) {
  $form_state['<?php print $machine_name ?>'] = $<?php print $machine_name ?>;
  // Always provide entity id in the same form key as in the entity edit form.
  $form['<?php print $machine_name ?>_types_id'] = array('#type' => 'value', '#value' => entity_id('<?php print $machine_name ?>' ,$<?php print $machine_name ?>));
  $<?php print $machine_name ?>_uri = entity_uri('<?php print $machine_name ?>', $<?php print $machine_name ?>);
  return confirm_form($form,
    t('Are you sure you want to delete <?php print $name ?> %title?', array('%title' => entity_label('<?php print $machine_name ?>', $<?php print $machine_name ?>))),
    $<?php print $machine_name ?>_uri['path'],
    t('This action cannot be undone.'),
    t('Delete'),
    t('Cancel')
  );
}

/**
 * Delete form submit handler.
 */
function <?php print $machine_name ?>_delete_form_submit($form, &$form_state) {
  $<?php print $machine_name ?>= $form_state['<?php print $machine_name ?>'];
  <?php print $machine_name ?>_delete($<?php print $machine_name ?>);

  drupal_set_message(t('<?php print $machine_name ?> %title deleted.', array('%title' => entity_label('<?php print $machine_name ?>', $<?php print $machine_name ?>))));

  $form_state['redirect'] = '<front>';
}
