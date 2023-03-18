<?php

function flow_fields_header(){
    global $wpdb;
    $table_name = esc_sql( $wpdb->prefix . 'flow_boxes' );
    $results = $wpdb->get_results( "SELECT * FROM $table_name" );
    
    $dropdown_output = "";
    if ( $results ) {
        $dropdown_output = "<ul class='flow_dropdown'>";
        foreach ( $results as $box ) {
            $dropdown_output .= "<li><a href='/wp-admin/admin.php?page=flow_field_boxes&action=edit&id=" . esc_attr( $box->id ) . "'>" . esc_html( $box->title ) . "</a></li>";
        }
        $dropdown_output .= "</ul>";
    }

    echo "<div class='flow_header'>";
    echo "<div><a href='/wp-admin/admin.php?page=flow_field_admin'><img src='/wp-content/plugins/flow-fields/includes/assets/flow_logo.jpg' style='max-height:75px'/> </a></div>";
    echo "<div>";
        echo "<ul>";
            echo "<li><a href='/wp-admin/admin.php?page=flow_field_admin'>Home</a></li>";
            echo "<li><a href='/wp-admin/admin.php?page=flow_field_boxes'>Boxes</a></li>";
            echo "<li class='has_flow_dropdown'><a href='/wp-admin/admin.php?page=flow_field_boxes'>Custom Fields</a>".$dropdown_output."</li>";
            echo "<li style='opacity:0.8'>Custom Post Types</li>";
            echo "<li style='opacity:0.8'>Settings</li>";
        echo "</ul>";
    echo "</div>";
    echo "</div>";
}