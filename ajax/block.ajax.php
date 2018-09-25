<?php
define( 'WP_DIR', $_SERVER["DOCUMENT_ROOT"] );
require( WP_DIR . "/wp-config.php" );

/*
$_POST["type"] = "admin";
$_POST["id"] = "v_server";
*/

$fname = HELPER__PLUGIN_DIR . "data/" . $_POST["type"] . "/" . $_POST["id"] . ".dat";

if (file_exists($fname)) {
    echo file_get_contents ($fname);
} else
    echo "<div class=\"empty\">No data</div>";