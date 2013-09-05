<?php print '<?php ' ?>

function migrate_<?php print $machine_name ?>_install() {
  $type = entity_create('<?php print $machine_name ?>_type', array(
    'type' => 'migrate_<?php print $machine_name ?>',
    'label' => t('<?php print $name ?>s migrated by script'),
    'weight' => 0,
  ));
  $type->save();
}

function migrate_<?php print $machine_name ?>_uninstall() {
//  if ($entities = entity_load_multiple_by_name('<?php print $machine_name ?>_type', array('migrate_<?php print $machine_name ?>'))) {
 //   list($id) = entity_extract_ids('<?php print $machine_name ?>_type', reset($entities));
 //   entity_delete('<?php print $machine_name ?>_type', $id);
 // }
}
