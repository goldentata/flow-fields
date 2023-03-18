<?php
// THIS FILE IS INCLUDED IN FLOW-FIELDS.PHP
// IT HAS ALL FUNCTIONS RESPONSIBLE FOR REGISTERING AND OUTPUTTING ADMIN PAGES



function flow_field_boxes_admin_menu() {
    add_menu_page(
        'Flow Fields',
        'Flow',
        'manage_options',
        'flow_field_admin',
        'flow_fields_admin_page'
    );
    add_submenu_page(
        'flow_field_admin',
        'Flow Field Boxes',
        'Flow Boxes',
        'manage_options',
        'flow_field_boxes',
        'flow_field_boxes_admin_page'
    );
    add_submenu_page(
        'flow_field_admin',
        'Flow Custom Post Types',
        'Flow Post Types',
        'manage_options',
        'flow_field_cpt_edit',
        'flow_field_cpt_admin_page'
    );
}
add_action( 'admin_menu', 'flow_field_boxes_admin_menu' );

function flow_fields_admin_page() {
    flow_fields_header();
    echo "MAIN PAGE";
}

function flow_field_cpt_admin_page() {
    flow_fields_header();
    echo "CPTs PAGE";
}

// Main function for boxes subpage
function flow_field_boxes_admin_page() {
    flow_fields_header();
    global $wpdb;
    $table_name = $wpdb->prefix . 'flow_boxes';
    // if you click on Add new box
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'add' ) {
        flow_field_boxes_add_form();
    } 
    // If you click on Box Options button
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'edit' ) {
        flow_field_boxes_edit_page();
        flow_fields_boxes_fields();
    } 
    // If you click on Manage Fields button
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'fields' ) {
    }
    // If you open this page first time, without clicking any buttons
    // list existing boxes 
    if(!isset( $_GET['action'])){
        flow_fields_boxes_list();
   }
}
