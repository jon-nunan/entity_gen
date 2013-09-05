<?php print '<?php' ?>

/*
 * Implementation of hook_migrate_api().
 */
function migrate_<?php print $machine_name ?>_migrate_api() {
  $api = array(
    'api' => 2,
  );
  return $api;
}
