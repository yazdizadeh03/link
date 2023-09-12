(function ($) {
    $(document).ready(function() {
        $('#my-plugin-add-link-form').on('submit', function(event) {
            event.preventDefault();
            
            // Get the form data
            var formData = $(this).serialize();
            
            // Send an AJAX request to add the link
            $.ajax({
                url: my_plugin_ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'my_plugin_add_link_ajax',
                    my_plugin_new_link_name: $('#my_plugin_new_link_name').val(),
                    my_plugin_new_link_url: $('#my_plugin_new_link_url').val(),
                    security: my_plugin_ajax_object.security
                },
                beforeSend: function() {
                    // Show the loading message
                    $('#my-plugin-add-link-form button[type="submit"]').text('Adding...').attr('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        // Clear the form fields and update the links table
                        $('#my_plugin_new_link_name').val('');
                        $('#my_plugin_new_link_url').val('');
                        $('#my-plugin-links-table tbody').html(response.data.html);
                        // Get the current date
                        var currentDate = new Date();
                        var formattedDate = currentDate.toDateString();
                        
                        // Show the success notification with the date
                        var successMessage = 'Link added successfully on ' + formattedDate + '!';
                        $('#my-plugin-add-link-form button[type="submit"]').text('Add Link').attr('disabled', false);
                        $('<div class="notice notice-success is-dismissible"><p>' + successMessage + '</p></div>').insertBefore('#my-plugin-add-link-form');
                        alert(successMessage);
                    } else {
                        // Show the error notification
                        $('#my-plugin-add-link-form button[type="submit"]').text('Add Link').attr('disabled', false);
                        $('<div class="notice notice-error is-dismissible"><p>' + response.data.message + '</p></div>').insertBefore('#my-plugin-add-link-form');
                        alert('Error adding link: ' + response.data.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
})(jQuery);
