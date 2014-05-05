<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Include Options
/*-------------------------------------------------------*/
	$option_name = themeblvd_get_option_name();
	$options = get_option( $option_name );
?>
/* =Primary Design and Structure
----------------------------------------------- */

body {
	background: <?php echo $options['bg_color']; ?> url('<?php echo $options['bg_image']; ?>') <?php echo $options['background_repeat']; ?> <?php echo $options['background_align']; ?>;
}
#container {
	background: <?php echo $options['content_color']; ?>;
<?php if ($options['content_outline'] == 'Yes') { ?>
		-webkit-box-shadow: 1px 1px 5px #333;
		   -moz-box-shadow: 1px 1px 5px #333;
				box-shadow: 1px 1px 5px #333;
	<?php } ?>
}

/* =Global Elements and Typography
-------------------------------------------------------------- */

body {
	color: <?php echo $options['text_color']; ?>;
}
a {
	color: <?php echo $options['link_color' ]; ?>;
	text-decoration: none;
}
a:hover,
.tb-text-logo:hover,
.entry-title a:hover {
	color: <?php echo $options['hover_color' ]; ?>;
	text-decoration: none;
}
<?php
if ($options['rebel_style'] == 'stretch') {
?>
#top {
	background: <?php echo $options['bg_color']; ?> url('<?php echo $options['bg_image']; ?>') <?php echo $options['background_repeat']; ?> <?php echo $options['background_align']; ?>;
}
<?php
	}
?>
/* Primary Navigation */
#access {
	background-color: <?php echo $options['nav_high_color']; ?>;
	background-image: -moz-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-image: -ms-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(<?php echo $options['nav_low_color']; ?>), to(<?php echo $options['nav_high_color']; ?>));
	background-image: -webkit-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-image: -o-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-image: linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-repeat: repeat-x;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $options['nav_low_color']; ?>', endColorstr='<?php echo $options['nav_high_color']; ?>', GradientType=0);
	border: 1px solid <?php echo $options['content_color']; ?>;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}

/* Level 1-3 */
#primary-menu li a {
	color: <?php echo $options['nav_link_color' ]; ?>;
	font-weight: bold;
}
#primary-menu li a .sf-sub-indicator {
	color: <?php echo $options['nav_link_color' ]; ?>; /* Because we're using fontawesome for the icons, we can change the color here. */
}

/* Level 1 only */
#primary-menu > li {
	border-right: solid 1px <?php echo $options['content_color']; ?>;
}
#primary-menu > li > a {
	line-height: 40px; /* Shapes the HEIGHT of the 1st level anchors */
	padding: 0 20px;
}

#primary-menu > li.current_page_item > a {
	/* Style current active menu item on 1st level */
	background: <?php echo $options['nav_low_color']; ?>;
}
#primary-menu > li.current-menu-ancestor > a {
	/* Style current parent menu item present on 1st level */
}
#primary-menu > li > a.sf-with-ul {
	/* If a top-level menu item has a dropdown, reduce its right padding. */
	padding-right: 12px;
}
#primary-menu > [class^="menu-icon-"] > a {
	/* If a top-level menu item has a an icon, reduce its left 
	padding. You can add icons to main menu by adding class "menu-icon-{whatever}" */
	padding-left: 12px;
}
#primary-menu > li > a:hover {
	background: <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>;
}

/* Level 2 and 3 */
#primary-menu ul {
	background: <?php echo $options['nav_low_color']; ?>;
	border: 1px solid <?php echo $options['content_color']; ?>;
	width: 200px; /* Width of dropdown menus */
}
#primary-menu li li a {
	padding: 7px 10px;
}
#primary-menu li li a:hover {
	background: <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>;
}
#primary-menu li li.nav-header {
	color: #888888; /* Slightly lighter color than links */
	font-size: .9em; /* Font size is 90% of everything else to componsate for being bold and uppercase */
	font-weight: bold;
	padding: 7px 10px;
	text-transform: uppercase;
}
#primary-menu li li.divider {
	background-color: #dddddd; /* Color of deviders */
	border-bottom: none; /* Override Bootstrap's default 1px white bottom border */
}

/* Level 2 only */
#primary-menu > li > ul {
	border-top: none;
	margin-left: -1px; /* Shifts dropdowns to the left 1px so they line up with left borders. */
	margin-top: 41px; /* Matches line-height of first level's anchors plus 1px for menu wrapper's bottom border, which positions the dropdown at the base of the anchors. */
}

/* Level 3 only */
#primary-menu ul ul {
	left: 200px; /* Matches width of dropdown menus */
}

/* Make sure graphic nav shows when expanding window back from tablet size */
@media (min-width: 801px) {
	# {
		height: auto !important;
		overflow: visible !important;
	}
}

.tabwhite {
	color: #333;
}

.modal {
	background: <?php echo $options['content_color']; ?>
}

/* Modules
----------------------------------------------- */
.qrcode{
	text-align: right;
}

.editentry {
	text-align: center;
}

<?php if ($options['emgf_disable'] == 'Yes') { ?>
/* IE Check
----------------------------------------------- */
.browser-feedback{	
	font-family: 'Noto Sans', sans-serif;
	position: fixed;	
	font-size: 16px;
	font-weight: bold;
	background: <?php echo $options['bg_color']; ?>;
	z-index: 1000000;
	left: 0;
	right: 0;
}

div.fullScreen{
	top: 0;
	bottom 0;
	height: 100%;
	padding: 100px 0;
}

div.header{
	padding: 10px 0;
	top: 0;
}

div.footer{
	bottom: 0;
	padding: 10px 0;
}

.browser-feedback h3,
.browser-feedback p,
.browser-feedback .message{
	width: 960px;
	margin: 0 auto;
}	

.browser-feedback h3{
	font-size: 25px;
	color: #fff;
	letter-spacing: -1px;
}	

.browser-feedback p,
.browser-feedback .message,
.browser-feedback a{
	font-size: 14px;
	color: #fff;
	line-height: 2.5;
}

.buttons{
	padding-top: 20px;
	text-align: center;
}

.buttons a{
	color: #fff;
	font-size: 16px;
	padding: 10px 15px;
	*padding: 0 15px;
	text-decoration: underline;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#005700',GradientType=0 );
	filter:alpha(opacity=75);
	opacity: 0.75;
	zoom: 1;
	margin-right: 20px;
}

.buttons a:hover{
	color: #f0f0f0;
	text-decoration: none;
}	

.buttons a.upgrade{
	background: #fff;
	color: #333;
	text-decoration: none;
	text-transform: uppercase;
	border-bottom: 3px solid #333;
}

.buttons a.upgrade:hover{
	background: #333;
	color: #fff;
}

<?php } ?>
/* Widget Header Right
----------------------------------------------- */

@media (min-width: 767px) {
	.header_logo {
		float: left;
		text-align: left;
	}
	.header_right {
		float: right;
		text-align: right;
		clear: left;
	}
}

@media (max-width: 767px) {

	.header_logo_text { position: relative; }

	#branding .header_logo { width: 100%; }

	.widget-area-collapsible .search_in_header.widget {
	float: none;
	text-align: center;
	padding-top: 10px; }

	.header_right {
		float: none;
		text-align: center;
		width: 100%; 
		position: absolute;
		left: 0;
		right: 0;
		margin-left: auto;
		margin-right: auto;
	}

}

<?php if ($options['emgf_includegf'] == 'No') { ?>
/* Gravity Specific
----------------------------------------------- */

.gform_wrapper ul {
  .list-unstyled();
}
.gform_wrapper li {
  .form-group();
}
.gform_wrapper form {
  margin-bottom: 0;
}
.gform_wrapper .gfield_label {
}
.gform_wrapper .gfield_required {
  padding-left: 1px;
  color: @state-danger-text;
}
.ginput_container input,
.ginput_container select,
.ginput_container textarea {
  .form-control();
}
.ginput_container textarea {
  height: auto;
}
.gform_button .gform_next_button .gform_previous_button {
  .btn();
  .btn-primary();
}
.gform_wrapper .gfield_error {
  .gfield_label {
    color: @state-danger-text;
  }
  input,
  select,
  textarea {
    border-color: @alert-danger-border;
    background-color: @alert-danger-bg;
    color: @alert-danger-text;
    .form-control-focus(@alert-danger-text);
  }
}
.validation_error {
  .alert();
  .alert-danger();
}
#gforms_confirmation_message {
  .alert();
}

<?php } ?>
/* Additional Specific
----------------------------------------------- */
.custom_button {
	color: <?php echo $options['nav_link_color']; ?>;
	background-color: <?php echo $options['nav_low_color']; ?>;
	background-image: -webkit-gradient(linear, left top, left bottom, from(<?php echo $options['nav_low_color']; ?>), to(<?php echo $options['nav_high_color']; ?>));
	background-image: -webkit-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-image: -moz-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-image: -o-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-image: -ms-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	background-image: linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
	filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='<?php echo $options['nav_low_color']; ?>', EndColorStr='<?php echo $options['nav_high_color']; ?>');
	border-color: <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>;
}
.custom_button:hover {
	color:<?php echo colourBrightness($options['nav_link_color'], 1.5); ?>;
	background-color: <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>;
	background-image: -webkit-gradient(linear, left top, left bottom, from(<?php echo colourBrightness($options['nav_low_color'], -1.5); ?>), to(<?php echo colourBrightness($options['nav_high_color'], -1.5); ?>));
	background-image: -webkit-linear-gradient(top, <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>, <?php echo colourBrightness($options['nav_high_color'], -1.5); ?>);
	background-image: -moz-linear-gradient(top, <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>, <?php echo colourBrightness($options['nav_high_color'], -1.5); ?>);
	background-image: -o-linear-gradient(top, <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>, <?php echo colourBrightness($options['nav_high_color'], -1.5); ?>);
	background-image: -ms-linear-gradient(top, <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>, <?php echo colourBrightness($options['nav_high_color'], -1.5); ?>);
	background-image: linear-gradient(top, <?php echo colourBrightness($options['nav_low_color'], -1.5); ?>, <?php echo colourBrightness($options['nav_high_color'], -1.5); ?>);
	filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='<?php echo colourBrightness($options['nav_low_color'], -1.5); ?>', EndColorStr='<?php echo colourBrightness($options['nav_high_color'], -1.5); ?>');
}

.nomargin_black {
	background-color: #313131;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#313131), to(#000000));
	background-image: -webkit-linear-gradient(top, #313131, #000000);
	background-image: -moz-linear-gradient(top, #313131, #000000);
	background-image: -o-linear-gradient(top, #313131, #000000);
	background-image: -ms-linear-gradient(top, #313131, #000000);
	background-image: linear-gradient(top, #313131, #000000);
	filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#313131', EndColorStr='#000000');
	border-color: #000000;
	padding: 0px 0px 0px;
	margin: 0px;
	height: 100%;
}
.nomargin_black:hover {
	background-color: #0b0b0b;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#0b0b0b), to(#000000));
	background-image: -webkit-linear-gradient(top, #0b0b0b, #000000);
	background-image: -moz-linear-gradient(top, #0b0b0b, #000000);
	background-image: -o-linear-gradient(top, #0b0b0b, #000000);
	background-image: -ms-linear-gradient(top, #0b0b0b, #000000);
	background-image: linear-gradient(top, #0b0b0b, #000000);
	filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#0b0b0b', EndColorStr='#000000');
	padding: 0px;
	margin: 0px;
	height: 100%;
	border-radius: 0px;
}

.nomargin_black .btn-large {
	padding: 0px;
	margin: 0px;
}

.nomargin_black:hover .btn-large {
	padding: 0px;
	margin: 0px;
}

.nomargin_black .btn {
	padding: 0px;
	margin: 0px;
}

.nomargin_black:hover .btn {
	padding: 0px;
	margin: 0px;
}

.logindir {
	text-align: center;
}

.entry-title {
	display: none;
}

.members-login-form {
	color: #333;
	width: 500px;
}

.logindir-inside{
	padding: 10px;
	margin: 10px;
}

div.btn-group-login:hover ul.dropdown-menu{
    display: block;    
}

div.btn-group-login ul.dropdown-menu{
    margin-top: 0px;    
}

input[type=text], input[type=password], input[type=website], input[type=url], input[type=number], input[type=date], input[type=email] {
    height: 28px !important;
}


.frm-table{
	border:0px solid black;
}

.frm-table td, .frm-table th{
	border:0px solid black;
}

.frm_uninstall .button-secondary{display:none;}