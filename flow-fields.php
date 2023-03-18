<?php
/*
Plugin Name: Flow Fields
Plugin URI: https://flow.borowicz.me
Description: Manage fields and custom post types
Version: 1.0
Author: Wojciech Borowicz
Author URI: https://borowicz.me
License: GPL2
*/


// Activate
function create_flow_field_tables() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'flow_boxes';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        post_types VARCHAR(255) NOT NULL,
        instruction VARCHAR(255) NOT NULL,
        internal VARCHAR(255) NOT NULL,
        priority VARCHAR(255) NOT NULL,
        position VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $table_name = $wpdb->prefix . 'flow_fields';
    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        box_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL,
        type VARCHAR(255) NOT NULL,
        instruction VARCHAR(255) NOT NULL,
        width VARCHAR(255) NOT NULL,
        position VARCHAR(255) NOT NULL,
        default_value VARCHAR(255) NOT NULL,
        required BOOLEAN NOT NULL,
        placeholder VARCHAR(255) NOT NULL,
        css_id VARCHAR(255) NOT NULL,
        internal VARCHAR(255) NOT NULL,
        parent_field INT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (box_id) REFERENCES {$wpdb->prefix}flow_boxes(id)
    ) $charset_collate;";
    dbDelta( $sql );

}
register_activation_hook( __FILE__, 'create_flow_field_tables' );

function drop_flow_field_tables() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'flow_boxes';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query( $sql );
    $table_name = $wpdb->prefix . 'flow_fields';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query( $sql );
}
register_deactivation_hook( __FILE__, 'drop_flow_field_tables' );



include('includes/flow_general_functions.php');
include('includes/admin_layout.php');
include('includes/flow_fields.php');
include('includes/admin_pages.php');
include('includes/assets.php');



