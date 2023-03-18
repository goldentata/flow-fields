<?php


function flow_fields_admin_enqueue_scripts( $hook_suffix ) {
    wp_enqueue_script( 'flow-fields-js', plugins_url( '/assets/flow-fields.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
    wp_enqueue_style( 'flow-fields-css', plugins_url( '/assets/flow-fields.css', __FILE__ ), array(), '1.0.0' );
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'flow_fields_admin_enqueue_scripts' );