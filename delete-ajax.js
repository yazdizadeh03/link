var deleteData = function (id) {
    if (confirm("آیا می خواهید این لینک را حذف کنید؟ ") == true) {
        $.ajax({

            type: "GET",
            url: "../wp-content/plugins/best-link/delete-data.php",
            data: { deleteId: id },
            dataType: "html",
            success: function (data) {
                $('#sampleTable').load('../wp-content/plugins/best-link/show-data.php');
                $('#msg').html(data);



            }

        });
    } else {
    }
   
};