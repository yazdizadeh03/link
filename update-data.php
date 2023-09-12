 <?php

include 'database.php';

if (isset($_GET['editId'])) {
    $id = $_GET['editId'];


    edit_data($conn, $id);
}

if (isset($_POST['updateId'])) {
    $id = $_POST['updateId'];

    update_data($conn, $id);
}
// edit data query

function edit_data($conn, $id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_plugin_links';

    $query = "SELECT * from $table_name WHERE id='$id'";
    $exec = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($exec);
    echo json_encode($row);

}

// update data query
function update_data($conn, $id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_plugin_links';

    $link_name = legal_input($_POST['link_name']);
    $link_url = legal_input($_POST['link_url']);
    $expiration_date = legal_input($_POST['expiration_date']);
    $link_type = legal_input($_POST['link_type']);

    $query = "UPDATE $table_name
              SET link_name='$link_name',
                  link_url='$link_url',
                  expiration_date='$expiration_date',
                  link_type='$link_type'
                 WHERE id='$id'";

    $exec = mysqli_query($conn, $query);

    if ($exec) {

  echo (esc_html_e('Link updated successfully','danolink'));

} else {
        $msg = "Error:" . mysqli_error($conn);
        echo $msg;
    }
}

// convert illegal input to legal input
function legal_input($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}

?>