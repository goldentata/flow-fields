<?php
// THIS FILE IS INCLUDED IN FLOW-FIELDS.PHP
// IT HAS FUNCTIONS WHICH OPERATE BOXES & FIELDS.

/***********************  FUNCTION TO LIST ALL BOXES (called in admin_pages.php) ******************************/
function flow_fields_boxes_list(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'flow_boxes';
    if(isset( $_GET['notify'])){
        echo '<div class="notice notice-success"><p>Entry '.$_GET['notify'].' successfully.</p></div>';
    }
        $results = $wpdb->get_results( "SELECT * FROM $table_name" );
        ?>
        <div class="flow_wrap wrap">
        <h1 class="wp-heading-inline">All Boxes</h1>
            <a href="?page=flow_field_boxes&action=add" class="page-title-action">Add New Box</a>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Post Types</th>
                        <th>Instruction</th>
                        <th>Internal</th>
                        <th>Priority</th>
                        <th>Position</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $results as $result ) { ?>
                        <tr>
                            <td><?php echo $result->title; ?></td>
                            <td><?php echo implode(', ', json_decode($result->post_types)); ?></td>
                            <td><?php echo $result->instruction; ?></td>
                            <td><?php echo $result->internal; ?></td>
                            <td><?php echo $result->priority; ?></td>
                            <td><?php echo $result->position; ?></td>
                            <td><a href="?page=flow_field_boxes&action=edit&id=<?= $result->id ?>" class="page-title-action">Fields & Options</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php
}
/***********************  FUNCTION TO LIST ALL BOXES (called in admin_pages.php) ******************************/


/***********************  FUNCTION TO OUTPUT AND PROCESS NEW BOX FORM (called in admin_pages.php (condition if $_GET['action']=="add")) ******************************/
function flow_field_boxes_add_form() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'flow_boxes';
    $post_types = get_post_types( array( 'public' => true ), 'names' );
    if ( isset( $_POST['submit'] ) ) {
        $title = sanitize_text_field( $_POST['title'] );
        $post_types = json_encode( $_POST['post_types'] );
        $instruction = sanitize_text_field( $_POST['instruction'] );
        $internal = sanitize_text_field( $_POST['internal'] );
        $priority = sanitize_text_field( $_POST['priority'] );
        $position = sanitize_text_field( $_POST['position'] );
        $wpdb->insert(
            $table_name,
            array(
                'title' => $title,
                'post_types' => $post_types,
                'instruction' => $instruction,
                'internal' => $internal,
                'priority' => $priority,
                'position' => $position
            )
        );
        echo '<div class="notice notice-success"><p>Entry added successfully.</p></div>';
        wp_redirect( admin_url( 'admin.php?page=flow_field_boxes&notify=added' ) );
        exit;
    }
    ?>
    <div class="flow_wrap wrap">
        <div class="wrap_actions">
         <a href="/wp-admin/admin.php?page=flow_field_boxes" class="button button-secondary">Back to all boxes</a>
        </div>
        <div class="flow_card">
        <h2>Add New Box</h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="title">Title</label></th>
                    <td><input type="text" name="title" id="title" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="post_types[]">Post Types</label></th>
                    <td>
                        <select name="post_types[]" id="post_types" class="regular-text" multiple required>
                            <?php foreach ( $post_types as $post_type ) { ?>
                                <option value="<?php echo esc_attr( $post_type ); ?>"><?php echo esc_html( $post_type ); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="instruction">Instruction</label></th>
                    <td><input type="text" name="instruction" id="instruction" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="internal">Internal</label></th>
                    <td><input type="text" name="internal" id="internal" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="priority">Priority</label></th>
                    <td>
                        <select name="priority" id="priority" class="regular-text" required>
                            <option value="high">High</option>
                            <option value="low">Low</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="position">Position</label></th>
                    <td>
                        <select name="position" id="position" class="regular-text" required>
                            <option value="normal">Normal</option>
                            <option value="side">Side</option>
                        </select>
                    </td>
                </tr>
            </table>
          
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Add New Box"></p>
        </form>
    </div>
    </div>
    <?php
}
/***********************  FUNCTION TO OUTPUT AND PROCESS NEW BOX FORM (called in admin_pages.php (condition if $_GET['action']=="add")) ******************************/



/***********************  FUNCTION TO OUTPUT AND PROCESS EDIT BOX FORM (called in admin_pages.php (condition if $_GET['action']=="edit")) ******************************/
function flow_field_boxes_edit_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'flow_boxes';
    $post_types = get_post_types(array('public' => true), 'names');
    
    if (isset($_POST['box_submit'])) {
        $id = (int) $_POST['id'];
        $title = sanitize_text_field($_POST['title']);
        $post_types = json_encode($_POST['post_types']);
        $instruction = sanitize_text_field($_POST['instruction']);
        $internal = sanitize_text_field($_POST['internal']);
        $priority = sanitize_text_field($_POST['priority']);
        $position = sanitize_text_field($_POST['position']);
    
        $wpdb->update(
            $table_name,
            array(
                'title' => $title,
                'post_types' => $post_types,
                'instruction' => $instruction,
                'internal' => $internal,
                'priority' => $priority,
                'position' => $position
            ),
            array('id' => $id)
        );
    }
    
    $id = (int) $_GET['id'];
    $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
    ?>
    <div class="flow_wrap wrap">
    <div class="wrap_actions">
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=flow_field_boxes' ) ); ?>" class="button button-secondary">Back to all boxes</a>
    </div>
    <div class="flow_card">
        <h2>Edit <span class='flow_title'><?php echo esc_html( $result->title ); ?></span> box options </h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="title">Title</label></th>
                    <td><input type="text" name="title" id="title" class="regular-text" value="<?php echo esc_attr( $result->title ); ?>" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="post_types[]">Post Types</label></th>
                    <td>
                        <select name="post_types[]" id="post_types" class="regular-text" multiple required>
                            <?php foreach ( $post_types as $post_type ) { ?>
                                <option value="<?php echo esc_attr( $post_type ); ?>" <?php selected( in_array( $post_type, json_decode( $result->post_types ) ), true ); ?>><?php echo esc_html( $post_type ); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="instruction">Instruction</label></th>
                    <td><input type="text" name="instruction" id="instruction" class="regular-text" value="<?php echo esc_attr( $result->instruction ); ?>" ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="internal">Internal</label></th>
                    <td><input type="text" name="internal" id="internal" class="regular-text" value="<?php echo esc_attr( $result->internal ); ?>" ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="priority">Priority</label></th>
                    <td>
                        <select name="priority" id="priority" class="regular-text" required>
                            <option value="high" <?php selected( $result->priority, 'high' ); ?>>High</option>
                            <option value="low" <?php selected( $result->priority, 'low' ); ?>>Low</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="position">Position</label></th>
                    <td>
                        <select name="position" id="position" class="regular-text" required>
                            <option value="normal" <?php selected( $result->position, 'normal' ); ?>>Normal</option>
                            <option value="side" <?php selected( $result->position, 'side' ); ?>>Side</option>
                        </select>
                    </td>
                </tr>
            </table>
            <input name="id" type="hidden" value="<?php echo esc_attr( $id ); ?>"/>
            <p class="submit"><input type="submit" name="box_submit" id="submit" class="button button-primary" value="Update Box"></p>
        </form>
    </div>

<?php
}
/***********************  FUNCTION TO OUTPUT AND PROCESS EDIT BOX FORM (called in admin_pages.php (condition if $_GET['action']=="edit")) ******************************/


/***********************  ADD META BOXES ON EDIT PAGES OF SET POST TYPES ******************************/
// it loops through all saved boxes, checks current post type, adds a meta box to the current edit page if it matches settings
function flow_field_boxes_add_meta_box() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'flow_boxes';
    $current_post_type = get_post_type();
    $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE JSON_CONTAINS(post_types, '\"" . $current_post_type . "\"', '$')" );
    foreach ( $results as $result ) {
        $title = esc_attr( $result->title );
        $priority = esc_attr( $result->priority );
        $position = esc_attr( $result->position );

        add_meta_box(
            sanitize_title( $title ),
            $title,
            'flow_field_boxes_meta_box_callback',
            $current_post_type,
            $position,
            $priority,
            array( 'result' => $result )
        );

    }
}
add_action( 'add_meta_boxes', 'flow_field_boxes_add_meta_box', 20 );

/***********************  ADD META BOXES ON EDIT PAGES OF SET POST TYPES ******************************/



/***********************  DISPLAY CONTENTS OF META BOXES ON SET POST TYPES ******************************/
// get $result variable passed in flow_field_boxes_add_meta_box()
// it includes meta box details, so we can display fields created for a given meta box.
function flow_field_boxes_meta_box_callback($post, $metabox)
{

    $result = $metabox['args']['result'];
    if ($result->instruction != "") {
        echo "<p>" . esc_html($result->instruction) . "</p>";
    }
    global $wpdb;
    $table_name = $wpdb->prefix . 'flow_fields';
    // Get all fields
    $fields = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE box_id = %d", $result->id));
    
    
    foreach ($fields as $field) {
        if ($field->parent_field !== null && $field->parent_field !== '' && $field->parent_field !== '0') {
            foreach ($fields as $parent) {
                if ($parent->id === $field->parent_field) {
                    if (!isset($parent->children)) {
                        $parent->children = [];
                    }
                    $parent->children[] = $field;
                    continue 2;
                }
            }
            // If parent field doesn't exist, create a new object with just id and children properties
            $fields[] = (object) [
                'id' => $field->parent_field,
                'children' => [$field]
            ];
        }
    }

    // Filter out child fields and fields with parent field of null or empty string
    $fields = array_filter($fields, function ($field) {
        return $field->parent_field === null || $field->parent_field === '0';
    });
    
    wp_nonce_field('flow_field_boxes_meta_box', 'flow_field_boxes_fields_nonce');
?>

<?php foreach ($fields as $field) { ?>
    <?php flow_fields_output_admin_input($field); ?>
<?php } ?>

<script>
    jQuery(document).ready(function ($) {
        <?php foreach ($fields as $field) {
            if ($field->type === 'file' || $field->type === "image") { ?>
                var fileUrl = $('#<?php echo esc_attr($field->slug); ?>').val();
                if (fileUrl) {
                    var fileName = fileUrl.split('/').pop();
                    $('#<?php echo esc_attr($field->slug); ?>_filename').text(fileName);
                }

                $('#<?php echo esc_attr($field->slug); ?>_button').on('click', function () {
                    var custom_uploader = wp.media({
                        title: '<?php echo esc_attr__('Select File', 'textdomain'); ?>',
                        button: {
                            text: '<?php echo esc_attr__('Use this file', 'textdomain'); ?>'
                        },
                        multiple: false
                    }).on('select', function () {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        $('#<?php echo esc_attr($field->slug); ?>').val(attachment.url);
                        $('#<?php echo esc_attr($field->slug); ?>_filename').text(attachment.filename);
                    }).open();
                });
        <?php }
        } ?>
    });
</script>
    <?php
}


/***********************  DISPLAY CONTENTS OF META BOXES ON SET POST TYPES ******************************/


function flow_fields_output_admin_input($field, $repeater_parent = false){
    $post = get_post(get_the_ID()); 
    if($repeater_parent){
        $name = $repeater_parent['slug'] . '['.$repeater_parent['loop_number'].']'. '['.$field->slug.']';
        $value = get_field($repeater_parent['slug'], get_the_ID());
        if($value!=null){
            $value = $value[$repeater_parent['loop_number']][$field->slug];
        }
    } else {
        $name = $field->slug;
        $value = get_field($field->slug, get_the_ID());
    }

    switch ($field->type) { 
        case "file": ?>
            <div class="field-single">
                <?php if(!$repeater_parent){ ?>
                    <label class='flow_label' for="<?php echo esc_attr($field->slug); ?>"><?php echo esc_html($field->title); ?></label>
                <?php } ?>
                <input type="hidden" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($field->slug); ?>" value="<?php echo esc_attr($value); ?>">
                <input type="button" class="button" id="<?php echo esc_attr($field->slug); ?>_button" value="<?php esc_attr_e('Select File', 'textdomain'); ?>">
                <span id="<?php echo esc_attr($field->slug); ?>_filename"></span>
            </div>
        <?php break; 
        case "image": ?>
            <div class="field-single">
                <?php if(!$repeater_parent){ ?>
                    <label class='flow_label' for="<?php echo esc_attr($field->slug); ?>"><?php echo esc_html($field->title); ?></label>
                <?php } ?>
                <input type="hidden" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($field->slug); ?>" value="<?php echo esc_attr($value); ?>">
                <input type="button" class="button" id="<?php echo esc_attr($field->slug); ?>_button" value="<?php esc_attr_e('Select Image', 'textdomain'); ?>">
                <span id="<?php echo esc_attr($field->slug); ?>_filename"></span>
            </div>
        <?php break; ?>
        <?php  case "textarea": ?>
            <div class="field-single">
                <?php if(!$repeater_parent){ ?>
                    <label class='flow_label' for="<?php echo esc_attr($field->slug); ?>"><?php echo esc_html($field->title); ?></label>
                <?php } ?>
                <textarea name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($field->slug); ?>" class="regular-text" ><?php echo esc_html($value); ?></textarea>
            </div>
        <?php break; ?>
        <?php  case "repeater": ?>
            <div class='field-group'>
                <label class='flow_label mt-3' for="<?php echo esc_attr($field->slug); ?>"><?php echo esc_html($field->title); ?></label>
                <table class="">
                    <?php
                    echo "<thead>";
                    echo "<th></th>";
                    foreach($field->children as $child_field){
                        echo "<th>".esc_html($child_field->title)."</th>";
                    }
                    echo "<th></th>";
                    echo "</thead>";
                    $repeater_parent['slug'] = $field->slug;
                    if(is_array($value)){
                        $number_of_rows = count($value);
                   
                    } else { 
                        $number_of_rows = 1; 
                    }
                    
                    for($i = 0; $i < $number_of_rows; $i++) {
                        $repeater_parent['loop_number'] = $i;
                        echo "<tr>";
                        echo "<td class='flow_repeater_actions'>";
                        echo '<span class="dashicons dashicons-menu-alt2"></span>';
                        echo "</td>";
                        
                        foreach($field->children as $child_field) {
                            echo "<td>";
                            flow_fields_output_admin_input($child_field, $repeater_parent);
                            echo "</td>";
                        }
                        
                        echo "<td class='flow_repeater_actions'>";
                        echo '<span class="flow_remove_row dashicons dashicons-no-alt"></span>';
                        echo "</td>";
                        echo "</tr>";
                    }
                
                ?>
                </table>
                <div class='flow_below_repeater_buttons'>
                    <button type='button' class="new_repeater_row button button-primary button-large" >Add Row</button>
                </div>
                </div>
            <?php break;
                 default: ?>
                 <div class="field-single">   
                    <?php if(!$repeater_parent){ ?>
                    <label class='flow_label' for="<?php echo esc_attr($field->slug); ?>"><?php echo esc_html($field->title); ?></label>
                    <?php } ?>
                    <input type="<?php echo esc_attr($field->type); ?>" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($field->slug); ?>" class="regular-text" value="<?php echo esc_attr( $value ); ?>">
                </div>
            <?php break;
        } 
}


/***********************  UPDATE DYNAMIC FIELDS ON POST SAVE HOOK ******************************/
// Get boxes for current post type
// Get fields for all boxes for this post type
// loop through fields and update its values
function flow_field_boxes_save_meta_box( $post_id ) {


    // Check if our nonce is set.
    if ( ! isset( $_POST['flow_field_boxes_fields_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['flow_field_boxes_fields_nonce'], 'flow_field_boxes_meta_box' ) ) {
        return;
    }

    // Check if this is an autosave.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }



    global $wpdb;

    // Get the current post type.
    $post_type = get_post_type( $post_id );

    // Get the boxes that have this post type in their post_types column.
    $boxes_table_name = $wpdb->prefix . 'flow_boxes';
    $fields_table_name = $wpdb->prefix . 'flow_fields';
    $boxes = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $boxes_table_name WHERE JSON_CONTAINS(post_types, '\"%s\"', '$')",
            $post_type
        )
    );    
    // Loop through each box and update its fields.
    foreach ( $boxes as $box ) {
        // Update post meta for each flow field box field.
        $meta_fields = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $fields_table_name WHERE box_id = %d", $box->id ) );
        foreach ( $meta_fields as $field ) {
            if ( isset( $_POST[ $field->slug ] ) ) { 
                $value = flow_sanitize_fields( $_POST[ $field->slug ] );
                update_post_meta( $post_id, $field->slug, $value );
            } else {
                delete_post_meta( $post_id, $field->slug );
            }
        }
    }
}
add_action( 'save_post', 'flow_field_boxes_save_meta_box' );
/***********************  UPDATE DYNAMIC FIELDS ON POST SAVE HOOK ******************************/


/***********************  MANAGE FIELDS FOR A BOX. CALLED IN ADMIN_PAGES.PHP ******************************/
// Output when you click "Manage fields" on a box
// Processes form which manages fields for a box
function flow_fields_boxes_fields() {
    global $wpdb;
    $boxes_table_name = $wpdb->prefix . 'flow_boxes';
    $fields_table_name = $wpdb->prefix . 'flow_fields';
    
    // get box ID from URL parameter
    $box_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
    if ( isset( $_POST['fields_submit'] ) ) {



$existing_fields = array();
$results = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM $fields_table_name WHERE box_id = %d", $box_id ) );
foreach ( $results as $result ) {
    $existing_fields[] = $result->id;
}

        // Loop through the $_POST data to separate the fields by ID or new_ prefix
foreach ($_POST['field'] as $field_id => $field_array) {
    // Check if the field is a new field or an existing field
    if (strpos($field_id, 'new_') !== false) {
      // Insert a new row for the new field
      $wpdb->insert(
        $fields_table_name,
        array(
            'box_id' => $box_id,
            'title' => sanitize_text_field($field_array['title']),
            'slug' => sanitize_text_field($field_array['slug']),
            'type' => sanitize_text_field($field_array['type']),
            'width' => 100,
            'position' => 0,
            'default_value' => '',
            'required' => 0,
            'placeholder' => '',
            'css_id' => '',
            'internal' => '',
            'instruction' => '',
        )
    );
    $new_id = $wpdb->insert_id;
    
      if(isset($field_array['grouped_fields']) && !empty($field_array['grouped_fields'])){
        foreach($field_array['grouped_fields'] as $child_field_id => $child_field){

            $wpdb->insert(
                $fields_table_name,
                array(
                  'box_id' => $box_id,
                  'title' => sanitize_text_field($child_field['title']),
                  'slug' => sanitize_text_field($child_field['slug']),
                  'type' => sanitize_text_field($child_field['type']),
                  'width' => 100,
                  'position' => 0,
                  'default_value' => '',
                  'required' => 0,
                  'placeholder' => '',
                  'css_id' => '',
                  'internal' => '',
                  'instruction' => '',
                  'parent_field' => $new_id
                )
              );

        }
      }
    } else {
      // Update the existing row with the new field values
      $wpdb->update(
        $fields_table_name,
        array(
            'title' => sanitize_text_field($field_array['title']),
            'slug' => sanitize_text_field($field_array['slug']),
            'type' => sanitize_text_field($field_array['type'])
        ),
        array('id' => $field_id),
        array('%s', '%s', '%s'),
        array('%d')
      );

      if(isset($field_array['grouped_fields']) && !empty($field_array['grouped_fields'])){
        foreach($field_array['grouped_fields'] as $child_field_id => $child_field){
            if (strpos($child_field_id, 'new_') !== false) {
            $wpdb->insert(
                $fields_table_name,
                array(
                  'box_id' => $box_id,
                  'title' => sanitize_text_field($child_field['title']),
                  'slug' => sanitize_text_field($child_field['slug']),
                  'type' => sanitize_text_field($child_field['type']),
                  'width' => 100,
                  'position' => 0,
                  'default_value' => '',
                  'required' => 0,
                  'placeholder' => '',
                  'css_id' => '',
                  'internal' => '',
                  'instruction' => '',
                  'parent_field' => $field_id
                )
              );
            } else{
                $wpdb->update(
                    $fields_table_name,
                    array(
                        'title' => sanitize_text_field($child_field['title']),
                        'slug' => sanitize_text_field($child_field['slug']),
                        'type' => sanitize_text_field($child_field['type'])
                    ),
                    array('id' => $child_field_id),
                    array('%s', '%s', '%s'),
                    array('%d')
                  );
            }

        }
      }


      $key = array_search( $field_id, $existing_fields ); 
      unset( $existing_fields[ $key ] );
    }
  }

  if ( ! empty( $existing_fields ) ) {
    $existing_fields = array_map( 'intval', $existing_fields );
    $wpdb->query( "DELETE FROM $fields_table_name WHERE id IN (" . implode( ',', $existing_fields ) . ")" );
}


        }
        
    
    
    // get box title for display
    $box_title = $wpdb->get_var( $wpdb->prepare( "SELECT title FROM $boxes_table_name WHERE id = %d", $box_id ) );

    // if box ID is not valid, display error message
    if ( $box_id <= 0 ) {
        echo '<div class="notice notice-error"><p>Invalid box ID.</p></div>';
        return;
    }
    
    // output page title and box title

    echo '<div class="flow_card">';
    echo '<h2>Fields for <span class="flow_title">' . esc_html( $box_title ) . '</span> box </h2>';
    
    // get all fields for the box
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $fields_table_name WHERE box_id = %d ORDER BY position ASC", $box_id ) );
    

    

        // define the HTML template for each field
        $field_template = '
        <div class="flow_field_row" data-id="%s" data-parent="%s">
            <div class="flow_row_actions">
                <span class="dashicons dashicons-edit show_details"></span>
                <span class="dashicons dashicons-admin-page duplicate_field"></span>
                <span class="dashicons dashicons-no-alt remove_field"></span>
            </div>
            <div class="flow_field_accordion_button" data-field="%s">%s</div>
            <div class="flow_field_details" data-field="%s" style="display:none">
                <div class="flow_single_field">
                    <label>Field Name</label>
                    <input type="text" name="field[%s][title]" class="regular-text flow_field_label" required value="%s">
                </div>
                <div class="flow_single_field">
                    <label>Field Slug</label>
                    <input type="text" name="field[%s][slug]" class="regular-text flow_field_slug" required value="%s">
                </div>
                <div class="flow_single_field">
                    <label>Type</label>
                    <select name="field[%s][type]" class="flow_field_type">
                        <option value="text"%s>Text</option>
                        <option value="number"%s>Number</option>
                        <option value="date"%s>Date</option>
                        <option value="file"%s>File</option>
                        <option value="textarea"%s>Textarea</option>
                        <option value="image"%s>Image</option>
                        <option value="repeater"%s>Repeater</option>
                        <option value="relationship" disabled>Relationship</option>
                    </select>
                </div>
                <div class="flow_single_field repeater_options" style="display:none;">
                    <h6 style="margin-top:0;">Repeater Fields</h6>
                    <button type="button" class="add_new_repeater_field">Add sub field +</button>
                </div>
            </div>
        </div>';
        echo "<div id='field_template' style='display:none;'>".$field_template."</div>";

    echo '<form method="post" action="admin.php?page=flow_field_boxes&action=edit&id='. esc_attr( $box_id ) .'">';

        foreach ( $results as $result ) {
            // use sprintf() to fill in the template with the field data
            $field_html = sprintf(
                $field_template,
                esc_attr( $result->id ),
                esc_attr( $result->parent_field ),
                esc_attr( $result->id ),
                $result->title,
                esc_attr( $result->id ),
                esc_attr( $result->id ),
                esc_attr( $result->title ),
                esc_attr( $result->id ),
                esc_attr( $result->slug ),
                esc_attr( $result->id ), 
                $result->type == "text" ? ' selected' : '',
                $result->type == "number" ? ' selected' : '',
                $result->type == "date" ? ' selected' : '',
                $result->type == "file" ? ' selected' : '',
                $result->type == "textarea" ? ' selected' : '',
                $result->type == "image" ? ' selected' : '',
                $result->type == "repeater" ? ' selected' : '',
                esc_attr( $result->id ),
                esc_attr( $result->id ),
            );
            
            // output the HTML for each field
            echo  $field_html;
            
        }

        echo '<button type="button" class="add_new_field">New field +</button>';
        echo '<p class="submit"><button type="submit" name="fields_submit" id="submit" class="button button-primary" value="Save">Save Fields</button></p>';
    echo '</form>';
    
    echo '</div>';
    echo '</div>';
    
}
/***********************  MANAGE FIELDS FOR A BOX. CALLED IN ADMIN_PAGES.PHP ******************************/