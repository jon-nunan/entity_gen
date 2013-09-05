name = <?php print $entity_name ?>

description = <?php print $entity_name ?> for the <?php print $module_name ?> module
package = <?php print $module_name ?>

version = VERSION
core = 7.x

dependencies[] = entity
dependencies[] = views

files[] = <?php print $class_name?>.controller.inc
