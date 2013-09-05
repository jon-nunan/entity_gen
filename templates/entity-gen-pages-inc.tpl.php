<?php print '<?php ' ?>

/**
 * Task view callback.
 */
function <?php print $machine_name ?>_view($<?php print $machine_name ?>) {
  drupal_set_title(entity_label('<?php print $machine_name ?>', $<?php print $machine_name ?>));
  return entity_view('<?php print $machine_name ?>', array(entity_id('<?php print $machine_name ?>',
$<?php print $machine_name ?>) => $<?php print $machine_name ?>), 'full');
}
