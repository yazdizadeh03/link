<?php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>help</title>
    <style>
       @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700');

$base-spacing-unit: 24px;
$half-spacing-unit: $base-spacing-unit / 2;

$color-alpha: #1772FF;
$color-form-highlight: #EEEEEE;

*, *:before, *:after {
	box-sizing:border-box;
}
a:active, a:hover {
    color: #000;
}
a{
    color:#000;
    text-decoration: unset;
}
body {
	padding:$base-spacing-unit;
	font-family:'Source Sans Pro', sans-serif;
	margin:0;
}

h1,h2,h3,h4,h5,h6 {
	margin:0;
}

.container {
    margin-top: 2%;
	max-width: 98%;
	margin-right:auto;
	margin-left:auto;
	display:flex;
	justify-content:center;
	align-items:flex-start;
	min-height:100vh;
}

.table {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 40px 0 rgba(0,0,0,.15);
    -moz-box-shadow: 0 0 40px 0 rgba(0,0,0,.15);
    -webkit-box-shadow: 0 0 40px 0 rgba(0,0,0,.15);
    -o-box-shadow: 0 0 40px 0 rgba(0,0,0,.15);
    -ms-box-shadow: 0 0 40px 0 rgba(0,0,0,.15);
	width:100%;
	border:1px solid $color-form-highlight;
}

.table-header {
    color: #fff;
        font-weight: bold;
        background: linear-gradient(135deg,#5477f5,#24336a,#5477f5);
	display:flex;
	width:100%;
	padding:($half-spacing-unit * 1.5) 0;
}

.table-row {
	border-bottom: 1px solid #0000000f;
	display:flex;
	width:100%;
	padding:($half-spacing-unit * 1.5) 0;

	&:nth-of-type(odd) {
		background:$color-form-highlight;
	}
}
.table-data{
color: #000;
direction: ltr;
}
.table-data, .header__item {
    padding: 10px;
	flex: 1 1 20%;
	text-align:center;
}

.header__item {
    color:#fff;
    padding: 10px;
	text-transform:uppercase;
}

.filter__link {
    font-size: 18px;
	color:white;
	text-decoration: none;
	position:relative;
	display:inline-block;
	padding-left:$base-spacing-unit;
	padding-right:$base-spacing-unit;

	&::after {
		content:'';
		position:absolute;
		right:-($half-spacing-unit * 1.5);
		color:white;
		font-size:$half-spacing-unit;
		top: 50%;
		transform: translateY(-50%);
	}

	&.desc::after {
		content: '(desc)';
	}

	&.asc::after {
		content: '(asc)';
	}

}
    </style>
    <script>
        function copy_text(element) {
  var textToCopy = element.textContent;


  var tempTextArea = document.createElement("textarea");
  tempTextArea.value = textToCopy;

  document.body.appendChild(tempTextArea);


  tempTextArea.select();
  document.execCommand("copy");

  document.body.removeChild(tempTextArea);


  Toastify({

text: "کد کپی شد.",

duration: 3000

}).showToast();


        }
    </script>
</head>
<body>
    <div style="margin: 30px 0px;">
  	<h1 style="font-size:40px;text-align:center;"><?php esc_html_e('help', 'danolink');?></h1>
 <div class="container">
	<div class="table">
		<div class="table-header">
			<div class="header__item"><?php esc_html_e('Name', 'danolink');?></div>
			<div class="header__item"><?php esc_html_e('Description', 'danolink');?></div>
			<div class="header__item"><?php esc_html_e('Shortcode', 'danolink');?></div>

		</div>
		<div class="table-content">
			<div class="table-row">
				<div class="table-data"><?php esc_html_e('Settings panel', 'danolink');?></div>
				<div class="table-data"><?php esc_html_e('To use the plugin settings panel on another page, copy the short code and place it on that page.', 'danolink');?></div>
				<div class="table-data"><a href='javascript:void(0)' onclick="copy_text(this)">[shortcode-ajax]</a></div>

			</div>
			<div class="table-row">
				<div class="table-data"><?php esc_html_e('Footer Link', 'danolink');?></div>
				<div class="table-data"><?php esc_html_e('To display the footer links, copy the shortcode and put it in that section.', 'danolink');?></div>
				<div class="table-data"><a href='javascript:void(0)' onclick="copy_text(this)">[my_plugin_links pos="footer"]</a></div>

			</div>
			<div class="table-row">
				<div class="table-data"><?php esc_html_e('Sidebar Link', 'danolink');?></div>
				<div class="table-data"><?php esc_html_e('To display the sidebar links,copy rhe shortcode and put it in that section.', 'danolink');?></div>
				<div class="table-data"><a href='javascript:void(0)' onclick="copy_text(this)">[my_plugin_links pos="sidebar"]</a></div>

			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" href="<?php echo trailingslashit(plugin_dir_url(__FILE__)) . 'css/help.css'; ?>">
<link rel="stylesheet" href="<?php echo trailingslashit(plugin_dir_url(__FILE__)) . 'css/css.css'; ?>">
