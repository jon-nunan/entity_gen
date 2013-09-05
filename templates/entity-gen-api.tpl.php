<?php print '<?php ' ?>
/**
 * @file
 * Hooks provided by this module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Acts on <?php print $machine_name ?> being loaded from the database.
 *
 * This hook is invoked during $<?php print $machine_name ?> loading, which is handled by
 * entity_load(), via the EntityCRUDController.
 *
 * @param array $entities
 *   An array of $<?php print $machine_name ?> entities being loaded, keyed by id.
 *
 * @see hook_entity_load()
 */
function hook_<?php print $machine_name ?>_load(array $entities) {
  $result = db_query('SELECT pid, foo FROM {mytable} WHERE pid IN(:ids)', array(':ids' => array_keys($entities)));
  foreach ($result as $record) {
    $entities[$record->pid]->foo = $record->foo;
  }
}

/**
 * Responds when a $<?php print $machine_name ?> is inserted.
 *
 * This hook is invoked after the $<?php print $machine_name ?> is inserted into the database.
 *
 * @param ExampleTask $<?php print $machine_name ?>
 *   The $<?php print $machine_name ?> that is being inserted.
 *
 * @see hook_entity_insert()
 */
function hook_<?php print $machine_name ?>_insert(ExampleTask $<?php print $machine_name ?>) {
  db_insert('mytable')
    ->fields(array(
      'id' => entity_id('<?php print $machine_name ?>', $<?php print $machine_name ?>),
      'extra' => print_r($<?php print $machine_name ?>, TRUE),
    ))
    ->execute();
}

/**
 * Acts on a $<?php print $machine_name ?> being inserted or updated.
 *
 * This hook is invoked before the $<?php print $machine_name ?> is saved to the database.
 *
 * @param ExampleTask $<?php print $machine_name ?>
 *   The $<?php print $machine_name ?> that is being inserted or updated.
 *
 * @see hook_entity_presave()
 */
function hook_<?php print $machine_name ?>_presave(ExampleTask $<?php print $machine_name ?>) {
  $<?php print $machine_name ?>->name = 'foo';
}

/**
 * Responds to a $<?php print $machine_name ?> being updated.
 *
 * This hook is invoked after the $<?php print $machine_name ?> has been updated in the database.
 *
 * @param ExampleTask $<?php print $machine_name ?>
 *   The $<?php print $machine_name ?> that is being updated.
 *
 * @see hook_entity_update()
 */
function hook_<?php print $machine_name ?>_update(ExampleTask $<?php print $machine_name ?>) {
  db_update('mytable')
    ->fields(array('extra' => print_r($<?php print $machine_name ?>, TRUE)))
    ->condition('id', entity_id('<?php print $machine_name ?>', $<?php print $machine_name ?>))
    ->execute();
}

/**
 * Responds to $<?php print $machine_name ?> deletion.
 *
 * This hook is invoked after the $<?php print $machine_name ?> has been removed from the database.
 *
 * @param ExampleTask $<?php print $machine_name ?>
 *   The $<?php print $machine_name ?> that is being deleted.
 *
 * @see hook_entity_delete()
 */
function hook_<?php print $machine_name ?>_delete(ExampleTask $<?php print $machine_name ?>) {
  db_delete('mytable')
    ->condition('pid', entity_id('<?php print $machine_name ?>', $<?php print $machine_name ?>))
    ->execute();
}

/**
 * Act on a <?php print $machine_name ?> that is being assembled before rendering.
 *
 * @param $<?php print $machine_name ?>
 *   The <?php print $machine_name ?> entity.
 * @param $view_mode
 *   The view mode the <?php print $machine_name ?> is rendered in.
 * @param $langcode
 *   The language code used for rendering.
 *
 * The module may add elements to $<?php print $machine_name ?>->content prior to rendering. The
 * structure of $<?php print $machine_name ?>->content is a renderable array as expected by
 * drupal_render().
 *
 * @see hook_entity_prepare_view()
 * @see hook_entity_view()
 */
function hook_<?php print $machine_name ?>_view($<?php print $machine_name ?>, $view_mode, $langcode) {
  $<?php print $machine_name ?>->content['my_additional_field'] = array(
    '#markup' => $additional_field,
    '#weight' => 10,
    '#theme' => 'mymodule_my_additional_field',
  );
}

/**
 * Alter the results of entity_view() for <?php print $machine_name ?>s.
 *
 * @param $build
 *   A renderable array representing the <?php print $machine_name ?> content.
 *
 * This hook is called after the content has been assembled in a structured
 * array and may be used for doing processing which requires that the complete
 * <?php print $machine_name ?> content structure has been built.
 *
 * If the module wishes to act on the rendered HTML of the <?php print $machine_name ?> rather than
 * the structured content array, it may use this hook to add a #post_render
 * callback. Alternatively, it could also implement hook_preprocess_<?php print $machine_name ?>().
 * See drupal_render() and theme() documentation respectively for details.
 *
 * @see hook_entity_view_alter()
 */
function hook_<?php print $machine_name ?>_view_alter($build) {
  if ($build['#view_mode'] == 'full' && isset($build['an_additional_field'])) {
    // Change its weight.
    $build['an_additional_field']['#weight'] = -10;

    // Add a #post_render callback to act on the rendered HTML of the entity.
    $build['#post_render'][] = 'my_module_post_render';
  }
}

/**
 * Acts on <?php print $machine_name ?>_type being loaded from the database.
 *
 * This hook is invoked during <?php print $machine_name ?>_type loading, which is handled by
 * entity_load(), via the EntityCRUDController.
 *
 * @param array $entities
 *   An array of <?php print $machine_name ?>_type entities being loaded, keyed by id.
 *
 * @see hook_entity_load()
 */
function hook_<?php print $machine_name ?>_type_load(array $entities) {
  $result = db_query('SELECT pid, foo FROM {mytable} WHERE pid IN(:ids)', array(':ids' => array_keys($entities)));
  foreach ($result as $record) {
    $entities[$record->pid]->foo = $record->foo;
  }
}

/**
 * Responds when a <?php print $machine_name ?>_type is inserted.
 *
 * This hook is invoked after the <?php print $machine_name ?>_type is inserted into the database.
 *
 * @param ExampleTaskType $<?php print $machine_name ?>_type
 *   The <?php print $machine_name ?>_type that is being inserted.
 *
 * @see hook_entity_insert()
 */
function hook_<?php print $machine_name ?>_type_insert(ExampleTaskType $<?php print $machine_name ?>_type) {
  db_insert('mytable')
    ->fields(array(
      'id' => entity_id('<?php print $machine_name ?>_type', $<?php print $machine_name ?>_type),
      'extra' => print_r($<?php print $machine_name ?>_type, TRUE),
    ))
    ->execute();
}

/**
 * Acts on a <?php print $machine_name ?>_type being inserted or updated.
 *
 * This hook is invoked before the <?php print $machine_name ?>_type is saved to the database.
 *
 * @param ExampleTaskType $<?php print $machine_name ?>_type
 *   The <?php print $machine_name ?>_type that is being inserted or updated.
 *
 * @see hook_entity_presave()
 */
function hook_<?php print $machine_name ?>_type_presave(ExampleTaskType $<?php print $machine_name ?>_type) {
  $<?php print $machine_name ?>_type->name = 'foo';
}

/**
 * Responds to a <?php print $machine_name ?>_type being updated.
 *
 * This hook is invoked after the <?php print $machine_name ?>_type has been updated in the database.
 *
 * @param ExampleTaskType $<?php print $machine_name ?>_type
 *   The <?php print $machine_name ?>_type that is being updated.
 *
 * @see hook_entity_update()
 */
function hook_<?php print $machine_name ?>_type_update(ExampleTaskType $<?php print $machine_name ?>_type) {
  db_update('mytable')
    ->fields(array('extra' => print_r($<?php print $machine_name ?>_type, TRUE)))
    ->condition('id', entity_id('<?php print $machine_name ?>_type', $<?php print $machine_name ?>_type))
    ->execute();
}

/**
 * Responds to <?php print $machine_name ?>_type deletion.
 *
 * This hook is invoked after the <?php print $machine_name ?>_type has been removed from the database.
 *
 * @param ExampleTaskType $<?php print $machine_name ?>_type
 *   The <?php print $machine_name ?>_type that is being deleted.
 *
 * @see hook_entity_delete()
 */
function hook_<?php print $machine_name ?>_type_delete(ExampleTaskType $<?php print $machine_name ?>_type) {
  db_delete('mytable')
    ->condition('pid', entity_id('<?php print $machine_name ?>_type', $<?php print $machine_name ?>_type))
    ->execute();
}

/**
 * Define default <?php print $machine_name ?>_type configurations.
 *
 * @return
 *   An array of default <?php print $machine_name ?>_type, keyed by machine names.
 *
 * @see hook_default_<?php print $machine_name ?>_type_alter()
 */
function hook_default_<?php print $machine_name ?>_type() {
  $defaults['main'] = entity_create('<?php print $machine_name ?>_type', array(
    // …
  ));
  return $defaults;
}

/**
 * Alter default <?php print $machine_name ?>_type configurations.
 *
 * @param array $defaults
 *   An array of default <?php print $machine_name ?>_type, keyed by machine names.
 *
 * @see hook_default_<?php print $machine_name ?>_type()
 */
function hook_default_<?php print $machine_name ?>_type_alter(array &$defaults) {
  $defaults['main']->name = 'custom name';
}
