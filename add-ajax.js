$(document).on('submit', '#userForm', function (e) {
    e.preventDefault();


    $.ajax({
        method: "POST",
        url: "../wp-content/plugins/best-link/insert-data.php",
        data: $(this).serialize(),
        success: function (data) {
            $('#sampleTable').load('../wp-content/plugins/best-link/show-data.php');
            $('#msg').html(data);
            alert(data);
            $('#userForm').find('input').val('')
          

        }
    });
});