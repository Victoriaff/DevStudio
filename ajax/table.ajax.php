<?php
define( 'WP_DIR', $_SERVER["DOCUMENT_ROOT"] );
require( WP_DIR . "/wp-config.php" );
require( HELPER__PLUGIN_DIR . "core/functions.php" );

if (isset($_POST["table"]) && !empty($_POST["table"]) && preg_match("/^[0-9A-Z_\$]+$/i", $_POST["table"]))
{
    $data = $wpdb->get_results( "SELECT * FROM ".$_POST["table"], ARRAY_A );

    if (is_array($data) && !empty($data))
        show_table($data);
    else
        echo "<div class=\"empty\">No data</div>";
}
