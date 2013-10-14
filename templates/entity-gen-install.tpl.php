<?php
require_once 'template.php';
print '<?php ' ?>

/**
 * Implements hook_schema().
 */
function <?php print $entity['general']['machine_name'] ?>_schema() {
  $schema = array();
  $schema['<?php print $entity['general']['machine_name'] ?>'] = array(
    'description' => '<?php print $entity['general']['description'] ?>',
    'fields' => array(
<?php
  unset($entity['fields']['add']);
  if($entity['general']['auto_id'] == TRUE){ ?>

  '<?php print $entity['general']['machine_name'] ?>_id' => array(
    'type' => 'serial',
    'description' => 'ID field for <?php print $entity['general']['machine_name'] ?>',
    'unsigned' => TRUE,
    'not null' => TRUE,
  ),
  <?php  }
  if($entity['general']['revisions'] == TRUE) {     ?>
  'revision_id' => array(
    'type' => 'int',
    'unsigned' => TRUE,
    'not null' => FALSE,
    'default' => NULL,
    'description' => 'The ID of the entity\'s default revision.',
  ),
  <?php }

  foreach ($entity['fields'] as $field) { ?>
      '<?php print $field['machine_name'] ?>' => array(
        'type' => '<?php print $field['type'] ?>',
<?php print_if_set($field, 'description', 8); ?>
<?php print_if_set($field, 'unsigned', 8); ?>
<?php print_if_set($field, 'size', 8);?>
<?php print_if_set($field, 'length', 8);?>
<?php print_if_set($field, 'precision', 8);?>
<?php print_if_set($field, 'scale', 8);?>
<?php print_if_set($field, 'default', 8);?>
<?php print_if_set($field, 'not null', 8);?>
      ),
<?php } ?>
<?php
  if($entity['general']['workflow'] == TRUE){ ?>
  // Auto workflow fields
  'created' => array(
    'description' => 'Time entity was created',
    'type' => 'int',
    'not null' => TRUE,
  ),
  'updated' => array(
    'description' => 'Time entity was updated',
    'type' => 'int',
    'not null' => TRUE,
  ),
  'uid' => array(
    'description' => 'User ID',
    'type' => 'int',
    'not null' => TRUE,
  ),
  'status' => array(
    'description' => 'Status of entity',
    'type' => 'int',
    'not null' => TRUE,
    'default' => 0,
  ),
  'type' => array(
    'description' => 'Bundle type',
    'type' => 'int',
    'not null' => TRUE,
    'default' => 0,
  ),
  // end workflow fields
  <?php   } ?>
  ),
  'indexes' => array(
<?php foreach ($entity['fields'] as $field) {
    if($field['db options']['index'] == 1){
      print '\''.$entity['general']['machine_name'] .'_'.$field['machine_name'] .'\' =>
      array(\''.$field['machine_name'].'\'),';
    }
  } ?>

    /*
     *  Only basic indexes are created by generator, add others manually. e.g.
     */
    // 'node_status_type'    => array('status', 'type', 'nid'),
    // 'node_title_type'     => array('title', array('type', 4)),
  ),
  'unique keys' => array(
<?php foreach ($entity['fields'] as $field) {
    if($field['db options']['unique'] == 1){
      print '\''.$field['machine_name'] .'\' => array
      (\''.$field['machine_name'].'\'),';
    }
  } ?>

  ),
  /*
   *  Foreign keys aren't implemented in Drupal 7 core yet
   *  uncomment and set up manually if needed by other modules...
   */
  /*
  'foreign keys' => array(
    'node_revision' => array(
      'table' => 'node_revision',
      'columns' => array('vid' => 'vid'),
    ),
    'node_author' => array(
      'table' => 'users',
      'columns' => array('uid' => 'uid'),
    ),
  ),
  */
<?php
  if($entity['general']['auto_id']){
    $primary_key[] = "'".$entity['general']['machine_name']."_id'";
  }else{
    foreach ($entity['fields'] as $field) {
      if($field['db options']['primary'] == 1){
        $primary_key[] = "'".$field['machine_name']."'";
      }
    }
  }

 ?>


  'primary key' => array(<?php if (isset($primary_key)) { print implode(',',$primary_key); } ?>),
);
<?php
  if($entity['general']['revisions'] == TRUE) {
    ?>
  $schema['<?php print $entity['general']['machine_name'] ?>_revision'] = $schema['<?php print $entity['general']['machine_name'] ?>'];
  // change id field from serial to int as its now the FK
  $schema['<?php print $entity['general']['machine_name'] ?>_revision']['fields']['<?php print $entity['general']['machine_name']?>_id'] = array(
    'type' => 'int',
    'unsigned' => TRUE,
    'not null' => FALSE,
    'default' => NULL,
    'description' => 'The ID of the attached entity.',
  );
  // change revision ID to primary Key
  $schema['<?php print $entity['general']['machine_name'] ?>_revision']['fields']['revision_id'] = array(
    'type' => 'serial',
    'not null' => TRUE,
    'description' => 'Primary Key: Unique revision ID.',
  );
  //Clear unique keys as revision table will have similar entries
  $schema['<?php print $entity['general']['machine_name'] ?>_revision']['unique keys'] = array();

  $schema['<?php print $entity['general']['machine_name'] ?>_revision']['primary key'] = array('revision_id');


  <?php
  } // if revisions

?>

  $schema['<?php print $entity['general']['machine_name'] ?>_type'] = array(
    'description' => 'Stores information about all defined <?php print $name ?> types.',
    'fields' => array(
      'id' => array(
        'type' => 'serial',
        'not null' => TRUE,
        'description' => 'Primary Key: Unique <?php print $name ?> type ID.',
      ),
      'type' => array(
        'description' => 'The machine-readable name of this type.',
        'type' => 'varchar',
        'length' => 32,
        'not null' => TRUE,
      ),
      'label' => array(
        'description' => 'The human-readable name of this type.',
        'type' => 'varchar',
        'length' => 255,
        'not null' => TRUE,
        'default' => '',
      ),
      'description' => array(
        'description' => 'A brief description of this type.',
        'type' => 'text',
        'not null' => TRUE,
        'size' => 'medium',
        'translatable' => TRUE,
      ),
    ) + entity_exportable_schema_fields(),
    'primary key' => array('id'),
    'unique keys' => array(
      'type' => array('type'),
    ),
  );

  return $schema;
}
