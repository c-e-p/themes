<?php

//require_once('view/theme/redbasic/php/style.php');

echo @file_get_contents('view/theme/porple/css/style.css');

if(! App::$install) {

	// Get the UID of the channel owner
	$uid = get_theme_uid();

	if($uid) {
		load_pconfig($uid,'porple');
	}

	// Load the owners pconfig
	$nav_bg = get_pconfig($uid, 'porple', 'nav_bg');
	$nav_icon_colour = get_pconfig($uid, 'porple', 'nav_icon_colour');
	$nav_active_icon_colour = get_pconfig($uid, 'porple', 'nav_active_icon_colour');
	$banner_colour = get_pconfig($uid,'porple','banner_colour');
	$narrow_navbar = get_pconfig($uid,'porple','narrow_navbar');
	$link_colour = get_pconfig($uid, 'porple', 'link_colour');
	$schema = get_pconfig($uid,'porple','schema');
	$bgcolour = get_pconfig($uid, 'porple', 'background_colour');
	$background_image = get_pconfig($uid, 'porple', 'background_image');
	$item_colour = get_pconfig($uid, 'porple', 'item_colour');
	$comment_item_colour = get_pconfig($uid, 'porple', 'comment_item_colour');
	$font_size = get_pconfig($uid, 'porple', 'font_size');
	$font_colour = get_pconfig($uid, 'porple', 'font_colour');
	$radius = get_pconfig($uid, 'porple', 'radius');
	$shadow = get_pconfig($uid,'porple','photo_shadow');
	$converse_width=get_pconfig($uid,'porple','converse_width');
	$top_photo=get_pconfig($uid,'porple','top_photo');
	$reply_photo=get_pconfig($uid,'porple','reply_photo');

}

// Now load the scheme.  If a value is changed above, we'll keep the settings
// If not, we'll keep those defined by the schema
// Setting $schema to '' wasn't working for some reason, so we'll check it's
// not --- like the mobile theme does instead.

// Allow layouts to over-ride the schema

if($_REQUEST['schema']) {
	$schema = $_REQUEST['schema'];
}

if (($schema) && ($schema != '---')) {

	// Check it exists, because this setting gets distributed to clones
	if(file_exists('view/theme/porple/schema/' . $schema . '.php')) {
		$schemefile = 'view/theme/porple/schema/' . $schema . '.php';
		require_once ($schemefile);
	}

	if(file_exists('view/theme/porple/schema/' . $schema . '.css')) {
		$schemecss = file_get_contents('view/theme/porple/schema/' . $schema . '.css');
	}

}

if (! $nav_bg)
	$nav_bg = '#343a40';
if (! $nav_icon_colour)
	$nav_icon_colour = 'rgba(255, 255, 255, 0.5)';
if (! $nav_active_icon_colour)
	$nav_active_icon_colour = 'rgba(255, 255, 255, 0.75)';
if (! $link_colour)
	$link_colour = '#007bff';
if (! $banner_colour)
	$banner_colour = '#fff';
if (! $bgcolour)
	$bgcolour = 'rgb(254,254,254)';
if (! $background_image)
	$background_image ='';
if (! $item_colour)
	$item_colour = 'rgb(238,238,238)';
if (! $comment_item_colour)
	$comment_item_colour = 'rgb(255,255,255)';
if (! $item_opacity)
	$item_opacity = '1';
if (! $font_size)
	$font_size = '0.875rem';
if (! $font_colour)
	$font_colour = '#4d4d4d';
if (! $radius)
	$radius = '0.25rem';
if (! $shadow)
	$shadow = '0';
if (! $converse_width)
	$converse_width = '790';
if(! $top_photo)
	$top_photo = '2.3rem';
if(! $reply_photo)
	$reply_photo = '2.3rem';

if(file_exists('view/theme/porple/css/style.css')) {

	$x = file_get_contents('view/theme/porple/css/style.css');

	if($schemecss) {
		$x .= $schemecss;
	}

	$aside_width = 288;

	// left aside and right aside are 285px + converse width
	$main_width = (($aside_width * 2) + intval($converse_width));

	// prevent main_width smaller than 768px
	$main_width = (($main_width < 768) ? 768 : $main_width);

	$options = array (
		'$nav_bg' => $nav_bg,
		'$nav_icon_colour' => $nav_icon_colour,
		'$nav_active_icon_colour' => $nav_active_icon_colour,
		'$link_colour' => $link_colour,
		'$banner_colour' => $banner_colour,
		'$bgcolour' => $bgcolour,
		'$background_image' => $background_image,
		'$item_colour' => $item_colour,
		'$comment_item_colour' => $comment_item_colour,
		'$font_size' => $font_size,
		'$font_colour' => $font_colour,
		'$radius' => $radius,
		'$shadow' => $shadow,
		'$converse_width' => $converse_width,
		'$nav_float_min_opacity' => $nav_float_min_opacity,
		'$nav_percent_min_opacity' => $nav_percent_min_opacity,
		'$top_photo' => $top_photo,
		'$reply_photo' => $reply_photo,
		'$pmenu_top' => $pmenu_top,
		'$pmenu_reply' => $pmenu_reply,
		'$main_width' => $main_width,
		'$aside_width' => $aside_width
	);

	echo str_replace(array_keys($options), array_values($options), $x);

}

// Set the schema to the default schema in derived themes. See the documentation for creating derived themes how to override this. 

if(local_channel() && App::$channel && App::$channel['channel_theme'] != 'porple')
	set_pconfig(local_channel(), 'porple', 'schema', '---');

