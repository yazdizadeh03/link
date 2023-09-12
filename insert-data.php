 <?php

include 'database.php';
include 'jdf.php';
$db = $conn; // database connection

//legal input values
$link_name = legal_input($_POST['my_plugin_new_link_name']);
$link_url = legal_input($_POST['my_plugin_new_link_url']);
$link_expiration_date = legal_input($_POST['my_plugin_link_expiration_date']);
$link_type = legal_input($_POST['my_plugin_link_type']);
if (!empty($link_name) && !empty($link_url) && !empty($link_expiration_date) && !empty($link_type)) {
    //  Sql Query to insert user data into database table
    insert_data($link_name, $link_url, $link_expiration_date, $link_type, $db); // pass $db as a parameter
} else {
    echo "All fields are required";
}

// convert illegal input value to legal value format
function legal_input($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}

// function to insert user data into database table
function insert_data($link_name, $link_url, $link_expiration_date, $link_type, $db)
{
     global $wpdb;
    $table_name = $wpdb->prefix . 'my_plugin_links';

    $query = "SELECT link_url FROM $table_name WHERE link_url = '$link_url'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
 
          echo (esc_html_e('This link has already been added','danolink'));
} else {
        // تبدیل تاریخ جاری به شمسی
        $current_gdate = date('Y/m/d');

        $arr_parts = explode('/', $current_gdate);

        $gYear = $arr_parts[0];
        $gMonth = $arr_parts[1];
        $gDay = $arr_parts[2];

        $current_jdate = gregorian_to_jalali($gYear, $gMonth, $gDay, '/');

        $query = "INSERT INTO $table_name(link_name, link_url, link_date,expiration_date,link_type) VALUES('$link_name','$link_url','$current_jdate','$link_expiration_date','$link_type')";
        $execute = mysqli_query($db, $query);
        if ($execute == true) {
              echo (esc_html_e('Link successfully added.','danolink'));

} else {
            echo "Error:" . mysqli_error($db);
        }
    }

}

?>