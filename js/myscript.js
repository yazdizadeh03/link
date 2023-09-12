function editLink(link_num) {
    var link_name = $('#my_plugin_link_name_' + link_num).val();
    var link_url = $('#my_plugin_link_url_' + link_num).val();

    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'my_plugin_edit_link',
            link_num: link_num,
            link_name: link_name,
            link_url: link_url
        },
        success: function() {
            alert('Link updated successfully.');
        }
    });
}
