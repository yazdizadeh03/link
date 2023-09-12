var editData = function (id) {

    $.ajax({
        type: "GET",
        url: "../wp-content/plugins/best-link/update-data.php",
        data: { editId: id },
        dataType: "html",
        success: function (data) {

            var LinkData = JSON.parse(data);
            $("input[name='id']").val(LinkData.id);
            $("input[name='link_name']").val(LinkData.link_name);
            $("input[name='link_url']").val(LinkData.link_url);
            $("input[name='link_date']").val(LinkData.link_date);
            $("input[name='expiration_date']").val(LinkData.expiration_date);
            $("select[name='link_type']").val(LinkData.link_type);

        }

    });
};



$(document).on('submit', '#updateForm', function (e) {
    e.preventDefault();
    var id = $("input[name='id']").val();
    var link_name = $("input[name='link_name']").val();
    var link_url = $("input[name='link_url']").val();
    var link_date = $("input[name='link_date']").val();
    var expiration_date = $("input[name='expiration_date']").val();
    var link_type = $("select[name='link_type']").val();

    $.ajax({
        method: "POST",
        url: "../wp-content/plugins/best-link/update-data.php",
        data: {
            updateId: id,
            link_name: link_name,
            link_url: link_url,
            link_date: link_date,
            expiration_date: expiration_date,
            link_type: link_type

        },
        success: function (data) {

            $('#sampleTable').load('../wp-content/plugins/best-link/show-data.php');
            $('#msg').html(data);
            alert(data);
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('overflow', 'auto');
            $('body').css('padding-right', '0px');
            $('#myModal').modal('hide');





        }
    });
});

