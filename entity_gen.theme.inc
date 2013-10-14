<?php

/*
 * hook_theme
 */

function entity_gen_theme() {
  $template_path = drupal_get_path('module','entity_gen') . '/templates';
  return array(
    'entity_gen_module_info' => array(
      'variables' => array('name' => NULL, 'description' => NULL,
        'package' => NULL, 'core' => NULL, 'machine_name' => NULL),
      'template' => 'entity-gen-module-info',
      'path' => $template_path,
    ),
    'entity_gen_module_install' => array(
      'variables' => array('machine_name' => NULL, 'schema_definition' => NULL),
      'template' => 'entity-gen-module-install',
      'path' => $template_path,
    ),
    'entity_gen_module_module' => array(
      'variables' => array('config' => NULL),
      'template' => 'entity-gen-module-module',
      'path' => $template_path,
    ),
    'entity_gen_schema_definition' => array(
      'variables' => array('config' => NULL),
      'template' => 'entity-gen-schema-definition',
      'path' => $template_path,
    ),
    'entity_gen_entity_info' => array(
      'variables' => array('config' => NULL),
      'template' => 'entity-gen-entity-info',
      'path' => $template_path,
    ),
    'entity_gen_module_module' => array(
      'variables' => array('config' => NULL, 'hook_entity_info' => NULL, 'hook_menu' => NULL),
      'template' => 'entity-gen-module-module',
      'path' => $template_path,
    ),
    'entity_gen_entity_class' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-entity-class',
      'path' => $template_path,
    ),
    'entity_gen_hook_menu' => array(
      'variables' => array('config' => NULL),
      'template' => 'entity-gen-hook-menu',
      'path' => $template_path,
    ),
    'entity_gen_admin_inc' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-admin-inc',
      'path' => $template_path,
    ),
    'entity_gen_api' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-api',
      'path' => $template_path,
    ),
    'entity_gen_entity_controller_inc' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-entity-controller-inc',
      'path' => $template_path,
    ),
    'entity_gen_entity_module' => array(
      'variables' => array('entity' => NULL, 'module_name' => NULL),
      'template' => 'entity-gen-entity-module',
      'path' => $template_path,
    ),
    'entity_gen_pages_inc' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-pages-inc',
      'path' => $template_path,
    ),
    'entity_gen_info' => array(
      'variables' => array('entity' => NULL, 'module_machine_name' => NULL),
      'template' => 'entity-gen-info',
      'path' => $template_path,
    ),
    'entity_gen_install' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-install',
      'path' => $template_path,
    ),
    'entity_gen_migrate_entity_info' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-migrate-entity-info',
      'path' => $template_path .'/migrate',
    ),
    'entity_gen_migrate_entity_install' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-migrate-entity-install',
      'path' => $template_path .'/migrate',
    ),
    'entity_gen_migrate_entity_migrate_inc' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-migrate-entity-migrate-inc',
      'path' => $template_path .'/migrate',
    ),
    'entity_gen_migrate_entity_module' => array(
      'variables' => array('entity' => NULL),
      'template' => 'entity-gen-migrate-entity-module',
      'path' => $template_path .'/migrate',
    )
  );
}

function template_preprocess_entity_gen_schema_definition(&$variables) {
  $variables['entities'] = $variables['config']['entity'];

}

function template_preprocess_entity_gen_entity_info(&$variables) {
  $i =0;
  foreach($variables['config']['entity'] as $entity){
    $i++;
    // Turn 'machine_name' into 'MachineName' for class
    $class_name = str_replace(" ","",ucwords(str_replace("_", " ",
      $entity['machine_name'])));
      $variables['config']['entity'][$i]['class_name'] = $class_name;

  }
  $variables['entities'] = $variables['config']['entity'];

}



function template_preprocess_entity_gen_module_info(&$variables) {
  //nothing needed at the moment

}


function template_preprocess_entity_gen_module_module(&$variables) {
  $i =0;
  foreach($variables['config']['entity'] as $entity){
    $i++;
    // Turn 'machine_name' into 'MachineName' for class
    $class_name = str_replace(" ","",ucwords(str_replace("_", " ",
      $entity['machine_name'])));
    $variables['config']['entity'][$i]['class_name'] = $class_name;

  }
  $variables['entities'] = $variables['config']['entity'];
}


function template_preprocess_entity_gen_hook_menu(&$variables) {
  $variables['entities'] = $variables['config']['entity'];

}



function template_preprocess_entity_gen_entity_class(&$variables) {
  dpm($variables);
  $variables['machine_name'] = $variables['entity']['machine_name'];
  $variables['name'] = $variables['entity']['name'];
  $variables['class_name'] = str_replace(" ","",ucwords(str_replace("_", " ", $variables['machine_name'])));

}

function template_preprocess_entity_gen_admin_inc(&$variables) {
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];

}

function template_preprocess_entity_gen_api(&$variables) {
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] =$variables['entity']['class_name'];

}

function template_preprocess_entity_gen_entity_controller_inc(&$variables) {
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];

}

function template_preprocess_entity_gen_entity_module(&$variables) {
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];

}


function template_preprocess_entity_gen_pages_inc(&$variables) {
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];
}

function template_preprocess_entity_gen_info(&$variables) {
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['entity_name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];
}

function template_preprocess_entity_gen_install(&$variables) {
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
}

function template_preprocess_entity_gen_migrate_entity_info (&$variables){
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];
}

function template_preprocess_entity_gen_migrate_entity_install(&$variables){
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];
}

function template_preprocess_entity_gen_migrate_entity_migrate_inc(&$variables){
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];
}

function template_preprocess_entity_gen_migrate_entity_module(&$variables){
  $variables['machine_name'] = $variables['entity']['general']['machine_name'];
  $variables['name'] = $variables['entity']['general']['name'];
  $variables['class_name'] = $variables['entity']['class_name'];
}
