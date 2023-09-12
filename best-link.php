<?php
/**
* 
* Plugin Name: best-link
* Plugin URI:
* Description:Ravand Soft Best link Plugin
* Version: 0.4
* Author: yazdizadeh
*/

register_activation_hook(__FILE__, 'create_table');

function create_table()
{
    // Include WordPress database core
    global $wpdb;
 
    // Define table name with the proper prefix
    $table_name = $wpdb->prefix . 'my_plugin_links';

    // SQL query for creating the table
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id INT(11) NOT NULL AUTO_INCREMENT,
    link_name VARCHAR(255) NOT NULL,
    link_url VARCHAR(255) NOT NULL,
    link_date DATE NOT NULL,
    expiration_date DATE,
    link_type VARCHAR(255),
    Remaining_days INT(11) NULL,
    PRIMARY KEY (id)
    ) $charset_collate;";

    // Load necessary script for dbDelta()
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Create the table
    dbDelta($sql);
    remove_action('activate_' . plugin_basename(__FILE__), 'create_table');

}

function ap_action_init()
{
// Localization
  load_plugin_textdomain( 'danolink', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

add_action('init', 'ap_action_init');
// Enqueue scripts and styles
add_action('admin_enqueue_scripts', 'my_plugin_admin_enqueue_scripts');
function my_plugin_admin_enqueue_scripts($hook_suffix) {
    if ($hook_suffix === 'toplevel_page_my-plugin-settings') {
        wp_enqueue_script('jquery');
        wp_enqueue_script('my-plugin-admin-script', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'));
        wp_localize_script('my-plugin-admin-script', 'my_plugin_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}

// Define menu page
add_action('admin_menu', 'my_plugin_menu');
function my_plugin_menu() {
    add_menu_page('My Plugin Settings', 'Bestlink Settings', 'manage_options', 'my-plugin-settings', 'my_plugin_settings_page');
      add_submenu_page('my-plugin-settings', 'Help', 'Help', 'manage_options', 'my-plugin-help', 'my_plugin_help_page');
}

// Define settings page
add_action('admin_init', 'my_plugin_settings');
function my_plugin_settings() {
    $num_links = get_option('my_plugin_num_links', 2);

    // Add settings fields for each link
    for ($i = 1; $i <= $num_links; $i++) {
        add_settings_field("my_plugin_link_$i", "Link $i", "my_plugin_link_callback", 'my-plugin-settings', 'my_plugin_links_section', array('link_num' => $i));
        register_setting('my_plugin_links_section', "my_plugin_link_$i");
    }

    // Add settings fields for the number of links and the new link
    add_settings_field('my_plugin_num_links', 'Number of Links', 'my_plugin_num_links_callback', 'my-plugin-settings', 'my_plugin_general_section');
    add_settings_field('my_plugin_new_link_name', 'New Link Name', 'my_plugin_new_link_name_callback', 'my-plugin-settings', 'my_plugin_general_section');
    add_settings_field('my_plugin_new_link_url', 'New Link URL', 'my_plugin_new_link_url_callback', 'my-plugin-settings', 'my_plugin_general_section');

    register_setting('my_plugin_links_section', 'my_plugin_num_links');
    register_setting('my_plugin_links_section', 'my_plugin_new_link_name');
    register_setting('my_plugin_links_section', 'my_plugin_new_link_url');
}

// Callback functions for settings fields and sections
function my_plugin_links_section_callback() {}

function my_plugin_link_callback($args) {
    $link_num = $args['link_num'];
    $link_name_value = get_option("my_plugin_link_name_$link_num");
    $link_url_value = get_option("my_plugin_link_url_$link_num");
    echo "<input type='text' name='my_plugin_link_name_$link_num'value='$link_name_value' placeholder='Link Name'>
    <input type='text' name='my_plugin_link_url_$link_num' value='$link_url_value' placeholder='Link URL'>";
}

function my_plugin_general_section_callback() {}

function my_plugin_num_links_callback() {
    $num_links = get_option('my_plugin_num_links', 2);
    echo "<input type='number' name='my_plugin_num_links' value='$num_links'>";
}

function my_plugin_new_link_name_callback() {
    $new_link_name = get_option('my_plugin_new_link_name');
    echo "<input type='text' name='my_plugin_new_link_name' value='$new_link_name' placeholder='Link Name'>";
}

function my_plugin_new_link_url_callback() {
    $new_link_url = get_option('my_plugin_new_link_url');
    echo "<input type='text' name='my_plugin_new_link_url' value='$new_link_url' placeholder='Link URL'>";
}

// Settings page output

include 'data-list.php';
shortcode('shortcode-ajax', 'ajax_list');

// Define settings page content
// Display the settings page
function my_plugin_settings_page() {
echo  do_shortcode( "[shortcode-ajax]" );
  
}
// Help page content
function my_plugin_help_page() {
include 'help.php';
}

// Define shortcode with position parameter
add_shortcode('my_plugin_links', 'my_plugin_links_shortcode');
function my_plugin_links_shortcode($atts) {
    require_once 'jdf.php';
    $position = isset($atts['pos']) ? sanitize_text_field($atts['pos']) : ''; // Get the position attribute value

    global $wpdb;
    $table_name = $wpdb->prefix . 'my_plugin_links';

    // Modify the SQL query based on the position
    $query = "SELECT * FROM $table_name";
    
    if (!empty($position)) {
        $query .= $wpdb->prepare(" WHERE link_type = %s", $position);
    }
     $all_links = $wpdb->get_results($query);
     foreach ($all_links as $link) {
        $expirationDate = $link->expiration_date;
         $remainingDays = get_remaining_day($expirationDate);
           if ($remainingDays < 0) {

                    $data = array(
    'Remaining_days' => 1,
);
$where = array(
    'id' => $link->id,
);

$wpdb->update($table_name, $data, $where);
    }

}
    $query .= " AND Remaining_days = 0";

    $links = $wpdb->get_results($query);

    $html = '<ul class="ads-bestlik">';
    foreach ($links as $link) {
        $expirationDate = $link->expiration_date;
         $remainingDays = get_remaining_day($expirationDate);
           if ($remainingDays < 0) {

                    $data = array(
    'Remaining_days' => 1,
);
$where = array(
    'id' => $link->id,
);

$wpdb->update($table_name, $data, $where);
    }
        $link_name = $link->link_name;
        $link_url = $link->link_url;

        if (!empty($link_name) && !empty($link_url)) {
            $html .= "<li><a href='$link_url'>$link_name</a></li>";
        }
    }
    
    $html .= '</ul>';

    return $html;
}
function get_remaining_day($expirationDate)
{
    $current_gdate = date('Y/m/d');
    $arr_parts = explode('/', $current_gdate);
    $gYear = $arr_parts[0];
    $gMonth = $arr_parts[1];
    $gDay = $arr_parts[2];
    $current_jdate = gregorian_to_jalali($gYear, $gMonth, $gDay, '/');

    $startArry = date_parse($current_jdate);
    $endArry = date_parse($expirationDate);

    // Convert dates to Julian Days
    $start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]);
    $end_date = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]);

    // Return difference
    return round(($end_date - $start_date), 0);
}
