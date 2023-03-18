<?php

function flow_sanitize_fields( $fields ) {
    foreach ( $fields as $key => $value ) {
        if ( is_array( $value ) ) {
            $fields[ $key ] = flow_sanitize_fields( $value );
        } else {
            $fields[ $key ] = sanitize_text_field( $value );
        }
    }
    return $fields;
}

// ACF compatibility
if (!function_exists('get_field')) {
function get_field($field_key, $post_id = false, $format_value = true) {
    global $post;

    // Try to get post ID dynamically
    if (!$post_id && $post) {
        $post_id = $post->ID;
    }

    // Get the field value
    $field_value = get_post_meta($post_id, $field_key, true);

    // Sanitize and escape the field value
    if ($format_value) {
        $field_value = flow_sanitize_fields($field_value);
        $field_value = esc_attr($field_value);
    }

    return $field_value;
}
}



?>