<?php
define( 'WP_DIR', $_SERVER["DOCUMENT_ROOT"] );
require( WP_DIR . "/wp-config.php" );
require( HELPER__PLUGIN_DIR . "core/functions.php" );

if (empty($_POST["ID"]) && empty($_POST["slug"])) { echo "Parameters not defined"; exit; }

if (!empty($_POST["ID"]) && !empty($_POST["slug"]))
    $post = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d and post_name = %s", $_POST["ID"], $_POST["slug"]), ARRAY_A );
else if (!empty($_POST["ID"]))
    $post = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d", $_POST["ID"]), ARRAY_A );
else
    $post = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = %s", $_POST["slug"]), ARRAY_A );
if (empty($post["ID"])) { echo "<div class=\"empty\">Post not found</div>"; exit; }


// Taxonomy
$sql = "
    SELECT t.term_ID, t.name, t.slug, tt.taxonomy
    FROM $wpdb->terms t
        INNER JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id
        INNER JOIN $wpdb->term_relationships tr ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN $wpdb->posts p ON p.ID = tr.object_id
    WHERE p.ID = %d";
$data = $wpdb->get_results( $wpdb->prepare($sql, $post["ID"]), ARRAY_A );

echo "<h2>Taxonomy</h2>";
if (!empty($data)) {
    show_table($data, array("style"=>"width:500px"));
} else
    echo "<div class=\"empty\">No data</div>";

// Post meta
$data = $wpdb->get_results( "SELECT meta_id, meta_key, meta_value FROM $wpdb->postmeta WHERE meta_key not like '\_%' and post_id = ".$wpdb->prepare("%d", $post["ID"]), ARRAY_A );

echo "<h2>Post meta</h2>";
if (!empty($data)) {
    show_table($data, array("style"=>"width:500px"));
} else
    echo "<div class=\"empty\">No data</div>";

