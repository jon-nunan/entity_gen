<?php print '<?php ' ?>
/**
 * @file
 * Examples and test fodder for migration into <?php print $machine_name ?> entities.
 */

/**
 * Migration class to test import of various date fields.
 */
class Migrate<?php print $class_name ?>Migration extends Migration {
  public function __construct() {
    parent::__construct();
    $this->description = t('Migrate <?php print $name ?>s');

    $this->map = new MigrateSQLMap($this->machineName,
      array(
        '<?php print $machine_name ?>_id' => array(
          'type' => 'int',
          'unsigned' => TRUE,
          'not null' => TRUE,
        )
      ),
      MigrateDestinationEntityAPI::getKeySchema('<?php print $machine_name ?>')
    );

    // Our test data is in a CSV file
    $this->source = new MigrateSourceCSV(__DIR__ . '/migrate_<?php print $machine_name ?>s.csv', $this->csvcolumns(), array(),
      $this->fields());
    $this->destination = new MigrateDestinationEntityAPI('stop','migrate_stop');
    $this->addFieldMapping('agency_stop_id', 'stop_id');
    $this->addFieldMapping('stop_lon','long');
    $this->addFieldMapping('stop_lat', 'lat');
    $this->addFieldMapping('stop_description', 'desc');
    $this->addFieldMapping('stop_zone', 'zone');
    $this->addFieldMapping('name', 'name');
    $this->addFieldMapping('uid')
         ->defaultValue(1);

    // Unmapped destination fields
    //$this->addUnmigratedDestinations(array('id'));
  }

  function csvcolumns() {
    $columns[0] = array("<?php print $machine_name ?>_id",'<?php print $machine_name ?> ID');
    $columns[1] = array("name", 'Stop name',);
    $columns[2] = array("desc", 'Stop Description',);
    $columns[3] = array("zone", 'Stop Zone(s)',);
    $columns[4] = array("lat", 'latitude of stop',);
    $columns[5] = array("long", 'longitude of stop');

    return $columns;
  }

  function fields() {
    return array(
      'agency_stop_id' => 'Agency Stop ID',
      'stop_lon' => 'Longitude',
      'stop_lat' => 'Latitude',
      'stop_description' => 'Stop Description',
      'stop_zone' => 'Stop Zone(s)',
      'name' => 'Stop Name',
    );
  }
}
