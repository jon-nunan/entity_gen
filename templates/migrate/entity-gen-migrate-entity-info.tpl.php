core = "7.x"
dependencies[] = "migrate_extras"
dependencies[] = "<?php print $machine_name ?>"
description = "Migrate <?php print $name?> entities"
files[] = migrate_<?php print $machine_name ?>.migrate.inc
name = "Migrate <?php print $name?>"
package = "GTFS Migrate"

