<?php

include 'database.php';

if (isset($_GET['deleteId'])) {

    $id = $_GET['deleteId'];
    delete_data($conn, $id);

}

// delete data query
function delete_data($conn, $id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_plugin_links';

    $query = "DELETE FROM $table_name WHERE id=$id";
    $exec = mysqli_query($conn, $query);

    if ($exec) {
  $msg =esc_html_e('Link removed successfully','danolink');

} else {
        $msg = "Error: " . $query . "<br>" . mysqli_error($conn);
        echo $msg;
    }
}
?>