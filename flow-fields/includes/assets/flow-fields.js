jQuery(document).ready(function( $ ) {

    
    $(document).on('click', '.new_repeater_row', function() {
        // Clone the last row of the table
        var lastRow = $(this).closest('.field-group').find('table tbody tr:last-child');
        var newRow = lastRow.clone();

        // Increment the index in the input names
        var newIndex = lastRow.index() + 1;
        newRow.find('input').each(function() {
            var name = $(this).attr('name').replace(/\[\d\]/g, '[' + newIndex + ']');
            $(this).attr('name', name).val('');
        });

        // Add the new row to the table
        newRow.appendTo($(this).closest('.field-group').find('table tbody'));

        // Disable the "Remove Row" button for the first row
        $(this).closest('.field-group').find('table tbody tr:first-child .flow_remove_row').prop('disabled', true);
    });

    $(document).on('click', '.flow_remove_row', function() {
    var row = $(this).closest('tr');
    var index = row.index();



    var field_group = $(this).closest('.field-group');

        row.remove();
    // Update the indexes of all remaining rows
    $(field_group).find('table tr').each(function(i) {
        var newIndex = i;
        newIndex--;
        $(this).find('input, select').each(function() {
            var name = $(this).attr('name').replace(/\[\d+\]/g, '[' + newIndex + ']');

            $(this).attr('name', name);
            });
        });
    });


        $('.flow_field_row[data-parent]:not(#field_template .flow_field_row)').each(function() {
          var current_row = $(this);
          if($(current_row).find('.flow_field_type').val()=="repeater"){
            $(current_row).find('.repeater_options').show();
          }
          var parentId = $(this).data('parent');
          var $parent = $('.flow_field_row[data-id="' + parentId + '"]');
          var $repeaterOptions = $parent.find('.repeater_options .add_new_repeater_field');
          $(this).insertBefore($repeaterOptions);
          if($parent.length>0){
            $(this).find('.repeater_options').remove();
          }
        });
        
    $(document).on('change', '.flow_field_type', function() {
        var repeater_options = $(this).closest('.flow_field_details').find('.repeater_options');
        if($(this).val()=="repeater"){
            $(repeater_options).show();
        } else {
            $(repeater_options).hide();

        }
    });
      

	$(document).on('click', '.flow_field_accordion_button, .flow_field_row .show_details', function(e){
        if($(e.target).hasClass('show_details')){
            $(this).closest('.flow_field_row').toggleClass('open');
            $(this).closest('.flow_field_row').find('.flow_field_details').toggle();
        } else{
            $(this).parent().toggleClass('open');
            $(this).next().toggle();
        }
    });
    $(document).on('click', '.add_new_repeater_field', function() {
        var count = $('.flow_field_row').length;
        count++;
        var parent_id = $(this).closest('.flow_field_row').find('.flow_field_label').attr('name').match(/\[(new_\d+|\d+)\]/)[1];
    
        var html = $('#field_template').html().replace('%s', 'new_'+count);
        var $new_field = $(html).insertBefore($(this));
    
        $new_field.find('.repeater_options').remove();
        $new_field.find('input[name="field[%s][title]"]').attr('name', `field[${parent_id}][grouped_fields][new_${count}][title]`).val('Unnamed');
        $new_field.find('input[name="field[%s][slug]"]').attr('name', `field[${parent_id}][grouped_fields][new_${count}][slug]`).val('');
        $new_field.find('select[name="field[%s][type]"]').attr('name', `field[${parent_id}][grouped_fields][new_${count}][type]`).val('text');
    });
    
    $(document).on('click', '.add_new_field', function() { // Bind a click event to the button
        var count = $('.flow_field_row').length;
        count++;
        
        var html = $('#field_template').html().replace('%s', 'new_'+count);
        $('.add_new_field').before(html);
        
        var new_field = $('.flow_field_row:last');
        $(new_field).find('input, select').val('');
        $(new_field).find('.flow_field_accordion_button').text('New field');
        
        $(new_field).find('input[name*="%s"], select[name*="%s"]').each(function() {
          var name = $(this).attr('name').replace('%s', 'new_'+count);
          $(this).attr('name', name);
        });
    });
    

    $(document).on('click', 'button[name="fields_submit"]', function(e) {

        var slugs = {};
        var valid = true;
    
        $('.flow_field_slug').each(function() {
            var slug = $(this).val();
            if (slug == '') {
                slug = Math.random().toString(36).substring(2, 15);
                $(this).val(slug);
            }
            if (slugs[slug] !== undefined) {
                var i = 1;
                while (slugs[slug + i] !== undefined) {
                    i++;
                }
                slug = slug + i;
                $(this).val(slug);
            }
            slugs[slug] = true;
            if (!slug) {
                valid = false;
            }
        });
    
        $('.flow_field_label').each(function() {
            var title = $(this).val();
            if (!title) {
                $(this).val('Unnamed');
            }
        });
    
        $('.flow_field_type').each(function() {
            var type = $(this).val();
            if (!type) {
                $(this).val('text');
            }
            if(type!='repeater'){
                $(this).closest('.flow_field_details').find('.repeater_options').remove();
            }
        });
    });
    

    // Duplicate field
    $(document).on('click', '.duplicate_field', function(e) {
        var fieldRow = $(this).closest(".flow_field_row");
        var clonedRow = fieldRow.clone();

        // Update the count and IDs
        var count = $('.flow_field_row').length;
        count++;
        clonedRow.find(".flow_field_accordion_button, .flow_field_details").attr("data-field", "new_" + count);
        clonedRow.find("input, select").each(function () {
            var name = $(this).attr("name");
            if (name) {
                name = name.replace(/\[\w+\]/, "[new_" + count + "]");
                $(this).attr("name", name);
            }
        });

        // Update the field name and slug
        var titleInput = clonedRow.find(".flow_field_label");
        var slugInput = clonedRow.find(".flow_field_slug");
        titleInput.val(titleInput.val() + " (copy)");
        slugInput.val(slugInput.val() + "-" + count);

        clonedRow.insertAfter(fieldRow);
    });

    // Remove field
    $(document).on('click', '.remove_field', function() {
        var fieldRow = $(this).closest(".flow_field_row");
        fieldRow.remove();
    });


    $(document).on('change', '.flow_field_label', function() { // Bind a click event to the button
        var inputValue = $(this).val();
        $(this).closest('.flow_field_row').find('.flow_field_accordion_button').text(inputValue);
   
        if($(this).closest('.flow_field_row').find('.flow_field_slug').val()==""){
            var slug = inputValue.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            $(this).closest('.flow_field_row').find('.flow_field_slug').val(slug);
        }
        
   
      });
      
});