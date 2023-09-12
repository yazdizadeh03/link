<!DOCTYPE html>
<html>
<head>
  <style>
.btn-add {
  background-color: #4CAF50;
    color: white;
    cursor: pointer;
    display: block;
    margin-top: 20px;
    padding: 8px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
  <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
<script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!--====form section start====-->
<div class="my-plugin-form-container" style=" margin-top: 50px;">
  <h2><?php _e('add link','danolink'); ?></h2>
    <p id="msg"></p>
    <form id="userForm" method="POST" style="display: flex;flex-direction: column;justify-content: space-between;align-items: flex-start;">
            <input type="hidden" name="action" value="my_plugin_add_link">

            <label for="my_plugin_new_link_name"><?php _e('Link Name','danolink'); ?>:</label>
            <input type="text" name="my_plugin_new_link_name" id="my_plugin_new_link_name" required>

            <label for="my_plugin_new_link_url"><?php _e('Link URL','danolink'); ?>:</label>
            <input type="url" name="my_plugin_new_link_url" id="my_plugin_new_link_url" required>

            <label for="my_plugin_link_expiration_date"><?php _e('Expiration Date','danolink'); ?>:</label>
             <input type="text" data-jdp data-jdp-min-date="today" placeholder="Date" name="my_plugin_link_expiration_date" id="my_plugin_link_expiration_date" />

            <label for="my_plugin_link_type"><?php _e('Link Type','danolink'); ?>:</label>
            <select name="my_plugin_link_type" id="my_plugin_link_type" style="width: 300px;max-width: 300px;">
                <option value="footer">footer</option>
                <option value="sidebar">sidebar</option>
            </select>

            <button type="submit" class="btn-add" value="Add Link"><?php _e('add link','danolink'); ?></button>

    </form>
        </div>
</div>
<!--====form section start====-->
<script type="text/javascript">
jalaliDatepicker.startWatch({
  minDate: "attr",
  maxDate: "attr"
});

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo trailingslashit(plugin_dir_url(__FILE__)) . 'add-ajax.js';
?>"></script>
</body>
</html>
