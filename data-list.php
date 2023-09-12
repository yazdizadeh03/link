<?php
/**
 * Adds a new shortcode.
 *
 * Care should be taken through prefixing or other means to ensure that the
 * shortcode tag being added is unique and will not conflict with other,
 * already-added shortcode tags. In the event of a duplicated tag, the tag
 * loaded last will take precedence.
 *
 * @since 2.5.0
 *
 * @global array $shortcode_tags
 *
 * @param string   $tag      Shortcode tag to be searched in post content.
 * @param callable $callback The callback function to run when the shortcode is found.
 *                           Every shortcode callback is passed three parameters by default,
 *                           including an array of attributes (`$atts`), the shortcode content
 *                           or null if not set (`$content`), and finally the shortcode tag
 *                           itself (`$shortcode_tag`), in that order.
 */

function shortcode($tag, $callback)
{
    global $shortcode_tags;

    if ('' === trim($tag)) {
        _doing_it_wrong(
            __FUNCTION__,
            __('Invalid shortcode name: Empty name given.'),
            '4.4.0'
        );
        return;
    }

    if (0 !== preg_match('@[<>&/\[\]\x00-\x20=]@', $tag)) {
        _doing_it_wrong(
            __FUNCTION__,
            sprintf(
                /* translators: 1: Shortcode name, 2: Space-separated list of reserved characters. */
                __('Invalid shortcode name: %1$s. Do not use spaces or reserved characters: %2$s'),
                $tag,
                '& / < > [ ] ='
            ),
            '4.4.0'
        );
        return;
    }

    $shortcode_tags[$tag] = $callback;
}

function ajax_list()
{

    ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body >



<div id="table-container">
 <h1><?php esc_html_e('Settings','danolink'); ?></h1>
<div>
  <div>
    <div>
        <center>
          
            <h3><?php esc_html_e('Links','danolink'); ?></h3>
        </center>
    </div>
<?php

    include 'show-data.php';
include 'add-form.php';
    ?>

</div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo trailingslashit(plugin_dir_url(__FILE__)) . 'delete-ajax.js'; ?>"></script>
<script type="text/javascript" src="<?php echo trailingslashit(plugin_dir_url(__FILE__)) . 'update-ajax.js'; ?>"></script>
<link rel="stylesheet" href="<?php echo trailingslashit(plugin_dir_url(__FILE__)) . 'css/css.css'; ?>">
</body>
</html>
<?php
}

?>