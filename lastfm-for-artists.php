<?php
/*
Plugin Name: Last.FM for Artists
Version: 0.7.2
Plugin URI: http://www.brain-jek.de/wordpress/lastfm-for-artists/
Description: Loads data of an artist and displays it on your blog. Uses Last.FMs REST 2.0 APIs. Loosely based on Simon Wheatley Last.FM Events plugin.
Author: J.org
Author URI: http://www.brain-jek.de

Copyright 2009 J&ouml;rg Eichhorn.

This script is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This script is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

// Localization stuff
define('LFM_US_DOMAIN','lastfm-for-artists');
// register localization
load_plugin_textdomain(LFM_US_DOMAIN, PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/lang');

// You can edit this, but I don't suggest making it too often
define('LFM_US_CACHE_AGE_EVENTS', 60 * 60); // In seconds, so this is 1 hour (60 minutes). No need to check more frequently than this.
define('LFM_US_CACHE_AGE_TOPTRACKS', 60 * 60 * 24 * 7); // In seconds, so this is 1 week (60 minutes). No need to check more frequently than this.
define('LFM_US_CACHE', 'lfm_fa_cache');
define('LFM_US_OPTIONS', 'lfm_fa_widget');

define('LFM_US_DEFAULT_TITLE', __('Upcoming shows', LFM_US_DOMAIN));
define('LFM_US_DEFAULT_ARTIST', __('7ieben', LFM_US_DOMAIN));

define('LFM_US_DATE_ISO8601', '%Y-%m-%dT%H:%M:%S'); // PHP5 has this set automatically, but we can't rely on PHP5. Sigh.

define('LFM_US_ALERT_STYLE', 'color: #c00; background-color: #ff9; padding: 5px;');
// HTTP client stuff
define('LFM_US_USER_AGENT', 'WordPress/' . $GLOBALS['wp_version']);
define('LFM_US_FETCH_TIME_OUT', 5); // 5 second timeout, Last.FM can be slow
// Use gzip encoding to fetch remote files if supported?
define('LFM_US_USE_GZIP', true);

$lfmfa_default_options = array(
					'type'				=> 1, // 1 means events.
					'title'				=> LFM_US_DEFAULT_TITLE,
					'artistname'		=> LFM_US_DEFAULT_ARTIST,
					'num'				=> '5',
					'examples'			=> array( // examples[<type>]['name][<formatstring>]
							1 => array(
								'Default' => array(
									0	=>
'<style type="text/css">
<!--
a.lfmfa-link {
	position:relative;
}
a .lfmfa_tooltip1 {
	display: none;
	color: #CCC;
	background-color:#000;
	z-index:1;
	width:250px;
	position: absolute;
	top: 45px;
	left: 80px;
	border: 1px solid #AAA;
	-moz-border-radius: 5px;
	text-decoration: none;
	padding: 3px;
	margin: 0px;
}
a:hover .lfmfa_tooltip1 {
	display: block;
	opacity: .9;
	filter: alpha(opacity=90);
}
-->
</style>
<div class="lfm_countdown">%COUNTDOWN%:</div>
<ul>',
									1	=>
'<li>
<a target="_blank" class="url summary lastfm-event-%NUMBER% lfmfa-link" href="%URL%"><span class="lfmfa_tooltip1">
	<strong>%TITLE%</strong><br />%DESCRIPTION%</span>
<strong>%DATE%</strong><br/>
%LOCATION-SUMMARY%
</a>
</li>',
									2	=>
'</ul>
<p class="lastfm-profile">(powered by <a href="%ARTIST-URL%" target="_blank">Last.fm</a> | <a href="http://www.brain-jek.de" target="_blank">j:org</a>)</p>',
									'name' => __('Default', LFM_US_DOMAIN)
								),
								'Default_title' => array(
									0	=>
'<style type="text/css">
<!--
a.lfmfa-link {
	position:relative;
}
a .lfmfa_tooltip2 {
	display: none;
	color: #CCC;
	background-color:#000;
	z-index:1;
	width:250px;
	position: absolute;
	top: 45px;
	left: 80px;
	border: 1px solid #AAA;
	-moz-border-radius: 5px;
	text-decoration: none;
	padding: 3px;
	margin: 0px;
}
a:hover .lfmfa_tooltip2 {
	display: block;
	opacity: .9;
	filter: alpha(opacity=90);
}
-->
</style>
<div class="lfm_countdown">%COUNTDOWN%:</div>
<ul>',
									1	=>
'<li>
<a target="_blank" class="url summary lastfm-event-%NUMBER% lfmfa-link" href="%URL%"><span class="lfmfa_tooltip2">
	<strong>%LOCATION-SUMMARY%</strong><br />%DESCRIPTION%</span>
<strong>%DATE%</strong><br/>
%TITLE%
</a>
</li>',
									2	=>
'</ul>
<p class="lastfm-profile">(powered by <a href="%ARTIST-URL%" target="_blank">Last.fm</a> | <a href="http://www.brain-jek.de" target="_blank">j:org</a>)</p>',
									'name' => __('Default/Title', LFM_US_DOMAIN)
									),
								'Default_artist' => array(
									0	=>
'<style type="text/css">
<!--
a.lfmfa-link {
	position:relative;
}
a .lfmfa_tooltip3 {
	display: none;
	color: #CCC;
	background-color:#000;
	z-index:1;
	width:250px;
	position: absolute;
	top: 45px;
	left: 80px;
	border: 1px solid #AAA;
	-moz-border-radius: 5px;
	text-decoration: none;
	padding: 3px;
	margin: 0px;
}
a:hover .lfmfa_tooltip3 {
	display: block;
	opacity: .9;
	filter: alpha(opacity=90);
}
-->
</style>
<div class="lfm_countdown">%COUNTDOWN%:</div>
<ul>',
									1	=>
'<li>
<a target="_blank" class="url summary lastfm-event-%NUMBER% lfmfa-link" href="%URL%"><span class="lfmfa_tooltip3">
	<strong>%TITLE%</strong><br />%DESCRIPTION%</span>
<strong>%DATE%</strong><br/>
'.__('with', LFM_US_DOMAIN).' %ARTISTS%
</a>
</li>',
									2	=>
'</ul>
<p class="lastfm-profile">(powered by <a href="%ARTIST-URL%" target="_blank">Last.fm</a> | <a href="http://www.brain-jek.de" target="_blank">j:org</a>)</p>',
									'name' => __('Default/Artists', LFM_US_DOMAIN)
									),
								'GoogleMap1' => array(
									0	=>
'<div id="map_canvas" style="width: 100%; height: 200px; overflow:hidden"></div>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=%VARIABLE:GOOGLE-MAPS-API-KEY:%" type="text/javascript"></script>
<script type="text/javascript">
function loadTourMap () {
if (GBrowserIsCompatible()) {
  var map = new GMap2(document.getElementById("map_canvas"));
  map.setCenter(new GLatLng(%LOCATION-LATITUDE%, %LOCATION-LONGITUDE%));
  map.setMapType(G_HYBRID_MAP);
  var bounds = new GLatLngBounds();
  var latLng;',
									1	=>
"  latLng = new GLatLng(%LOCATION-LATITUDE%, %LOCATION-LONGITUDE%);
  bounds.extend(latLng);
  map.addOverlay(new GMarker(latLng, {title:\"%DATE%: %LOCATION-SUMMARY%\"}));",
									2	=>
'  map.setCenter(bounds.getCenter());
  map.setZoom(map.getBoundsZoomLevel(bounds));
  map.addControl(new GSmallZoomControl());
}
};
document.body.onLoad = loadTourMap();
</script>',
									'name' => __('GoogleMap Markers', LFM_US_DOMAIN)
								),
								'GoogleMap2' => array(
									0 =>
'<div id="map_canvas2" style="width: 100%; height: 200px; overflow:hidden"></div>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=%VARIABLE:GOOGLE-MAPS-API-KEY:%" type="text/javascript"></script>
<script type="text/javascript">
function loadTourMap2 () {
if (GBrowserIsCompatible()) {
  var map = new GMap2(document.getElementById("map_canvas2"));
  map.setCenter(new GLatLng(%LOCATION-LATITUDE%, %LOCATION-LONGITUDE%));
  map.setMapType(G_HYBRID_MAP);
  var bounds = new GLatLngBounds();
  var latLng;
  var linePoints = new Array();
  latLng = new GLatLng(%LOCATION-LATITUDE%, %LOCATION-LONGITUDE%);
  map.addOverlay(new GMarker(latLng, {title:"%DATE%: %LOCATION-SUMMARY%"}));',
									1 =>
'  latLng = new GLatLng(%LOCATION-LATITUDE%, %LOCATION-LONGITUDE%);
  bounds.extend(latLng);
  linePoints[linePoints.length] = latLng;',
									2 =>
'  var polyline = new GPolyline(linePoints, "#ff0000", 2);
  map.addOverlay(new GMarker(latLng, {title:"%DATE%: %LOCATION-SUMMARY%"}));
  map.addOverlay(polyline);
  map.setCenter(bounds.getCenter());
  map.setZoom(map.getBoundsZoomLevel(bounds));
  map.addControl(new GSmallZoomControl());
}
};
document.body.onLoad = loadTourMap2();
</script>',
									'name' => __('GoogleMap Tourline', LFM_US_DOMAIN)
								)
							),
							2 => array(
								'Default' => array(
									0 =>
'<style type="text/css">
<!--
a.lfmfa-link {
	position:relative;
}
a .lfmfa_tooltip4 {
	display: none;
	color: #CCC;
	background-color:#000;
	z-index:1;
	width:150px;
	position: absolute;
	top: 45px;
	left: 80px;
	border: 1px solid #AAA;
	-moz-border-radius: 5px;
	text-decoration: none;
	padding: 3px;
	margin: 0px;
}
a .lfmfa_tooltip4 img {
	width: 100%;
}
a:hover .lfmfa_tooltip4 {
	display: block;
	opacity: .9;
	filter: alpha(opacity=90);
}
-->
</style>
<ul>',
									1 =>
'<li>
<a target="_blank" class="url summary lastfm-track-%RANK% lfmfa-link" href="%URL%%IF-FULL-STREAMABLE%?autostart%END-IF%"><span class="lfmfa_tooltip4">
	<strong>Played %PLAYCOUNT% times!</strong><br />
	<img src="%IMAGE-URL%"></span>
<strong>%RANK%.</strong> %NAME%</a>
</li>',
									2 =>
'</ul>
<p class="lastfm-profile">(powered by <a href="%ARTIST-URL%" target="_blank">Last.fm</a> | <a href="http://www.brain-jek.de" target="_blank">j:org</a>)</p>',
									'name' => __('Default', LFM_US_DOMAIN)
								),
								'Default_ol' => array(
									0 =>
'<style type="text/css">
<!--
a.lfmfa-link {
	position:relative;
}
a .lfmfa_tooltip4 {
	display: none;
	color: #CCC;
	background-color:#000;
	z-index:1;
	width:150px;
	position: absolute;
	top: 45px;
	left: 80px;
	border: 1px solid #AAA;
	-moz-border-radius: 5px;
	text-decoration: none;
	padding: 3px;
	margin: 0px;
}
a .lfmfa_tooltip4 img {
	width: 100%;
}
a:hover .lfmfa_tooltip4 {
	display: block;
	opacity: .9;
	filter: alpha(opacity=90);
}
-->
</style>
<ol>',
									1 =>
'<li>
<a target="_blank" class="url summary lastfm-track-%RANK% lfmfa-link" href="%URL%%IF-FULL-STREAMABLE%?autostart%END-IF%"><span class="lfmfa_tooltip4">
	<strong>Played %PLAYCOUNT% times!</strong><br />
	<img src="%IMAGE-URL%"></span>
	%NAME%</a>
</li>',
									2 =>
'</ol>
<p class="lastfm-profile">(powered by <a href="%ARTIST-URL%" target="_blank">Last.fm</a> | <a href="http://www.brain-jek.de" target="_blank">j:org</a>)</p>',
									'name' => __('Default/Ordered', LFM_US_DOMAIN)
								),

							),
					),
					'hide_on_empty'		=>true,
					'test_run' 			=>false
				);


// DEBUGGING via firephp, which I recommend btw.
//require('fb.php');
//ob_start();

// needed for html client class "Snoopy"
require_once(ABSPATH . WPINC . '/class-snoopy.php');

class LastFmForArtists {

	// the constructor, plugin-initializer
	function LastFmForArtists()
	{
		// this adds a little css and javascript to the admin widget page allowing for neat css-tooltips and some more style.
		add_action( 'admin_head', array( &$this, 'lfm4a_admin_head' ) );

		// Run our widget initialization code
		add_action( 'widgets_init', array( &$this, 'lfm4a_init_widgets') );

		// register the cache-deleter
		register_deactivation_hook( __FILE__, array( &$this, 'delete_cache') );

		// copy default example
		$default_options['pre_format_string'] 	= $default_options['examples'][$default_options['type']]['Default'][0];
		$default_options['format_string'] 		= $default_options['examples'][$default_options['type']]['Default'][1];
		$default_options['post_format_string'] 	= $default_options['examples'][$default_options['type']]['Default'][2];
	}

	// helper to clean format string before replacements
	function sanitize_formatstring($formatstring) {
		$result = $formatstring;
		// TODO replace single quotes with double quotes needed?
		//$result = preg_replace("/'/", '"', $result);

		// variable syntax in format strings is %VARIABlE:variable-name:variable-value%
		// delete variables-declaration from format-strings, needed to actually work with an variables value
		$result = preg_replace('/%VARIABLE:([^%:]+):([^%]*)%/', '${2}', $result);
		return $result;
	}

	// simple helper to ease comparison of examples and used format strings
	function equalize_formatString($formatstring) {
		// trim variable declarations
		$result = preg_replace('/%VARIABLE:([^%:]+):([^%]*)%/', '', $formatstring);
		// trim all whitespaces
		$result = preg_replace('/\s/', '', $result);
		return $result;
	}

	// lastfm widget stuff
	function lfm4a_init_widgets()
	{
		$options = get_option( LFM_US_OPTIONS );

        if ( !is_array($options) ) $options = array();

        $widget_ops = array( 'classname' => LFM_US_OPTIONS,  'description' => __('Last.fm Widget for Artists', LFM_US_DOMAIN));
        $control_ops = array( 'width' => 400, 'height' => 350, 'id_base' => 'lfm_fa' );
        $name = 'Last.fm';

        $registered = false;
        foreach ( array_keys( $options ) as $o ) {
            if ( !isset( $options[$o]['title'] ) )
                continue;
            $id = "lfm_fa-$o";
            $registered = true;
		// This registers our widget so it appears with the other available
		// widgets and can be dragged and dropped into any active sidebars.
            wp_register_sidebar_widget( $id, $name, array( &$this, 'lfm4a_widget' ), $widget_ops, array( 'number' => $o ) );
		// This registers our optional widget control form.
            wp_register_widget_control( $id, $name, array( &$this, 'lfm4a_widget_ctrl' ), $control_ops, array( 'number' => $o ) );
        }
        if (!$registered) {
            wp_register_sidebar_widget( 'lfm_fa-1', $name, array( &$this, 'lfm4a_widget' ), $widget_ops, array( 'number' => -1 ) );
            wp_register_widget_control( 'lfm_fa-1', $name, array( &$this, 'lfm4a_widget_ctrl' ), $control_ops, array( 'number' => -1 ) );
        }
		// needed for widget options
		if (is_admin()) {
        	wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'thickbox' );
		}
	}

	// this funtion outputs the widget (or not...)
	function lfm4a_widget( $args, $widget_args = 1 )
	{

		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

		// Multi-Widget-Code
        if (is_numeric($widget_args))
            $widget_args = array('number' => $widget_args);
        $widget_args = wp_parse_args($widget_args, array( 'number' => -1 ));
        extract($widget_args, EXTR_SKIP);
        $options_all = get_option(LFM_US_OPTIONS);
        if (!isset($options_all[$number]))
            return;

        $options = $options_all[$number];

		// check for missing options and use defaults.
		$artistname 		= isset($options['artistname']) 		? $options['artistname'] 		: $default_options['artistname'];
		$type		 		= isset($options['type']) 				? $options['type'] 				: $default_options['type'];
		$title 				= isset($options['title']) 				? $options['title'] 			: $default_options['title'];
		$num 				= isset($options['num'])				? $options['num']				: $default_options['num'];
		$pre_format_string 	= isset($options['pre_format_string'])	? $options['pre_format_string']	: $default_options['pre_format_string'];
		$format_string 		= isset($options['format_string'])		? $options['format_string']		: $default_options['format_string'];
		$post_format_string	= isset($options['post_format_string'])	? $options['post_format_string']: $default_options['post_format_string'];
		$hide_on_empty 		= isset($options['hide_on_empty']) 		? $options['hide_on_empty'] 	: $default_options['hide_on_empty'];
		$test_run 			= isset($options['test_run'])			? $options['test_run'] 			: $default_options['test_run'];

		// Show nothing if in testing mode and user is not logged in.
		if ($test_run) {
			if (!is_user_logged_in()) {
				//cancel if user not logged in!
				return;
			}
		}
		switch ($type) {
			case 1:
				// This will use a cached copy of the events data if it exists and is in date
				$items = & $this->maybe_get_new_events($artistname);
				break;
			case 2:
				// This will use a cached copy of the toptracks data if it exists and is in date
				$items = & $this->maybe_get_new_toptracks($artistname);
				break;
		}

		// If we're not supposed to display anything when we're empty, we abandon ship at this point.
		// but as the modified timestamp is always present, we check for length 2
		if ( count($items) <= 1 && $hide_on_empty ) return;

		// output wordpress stuff
		echo $before_widget . $before_title . htmlspecialchars( $title ) . $after_title;

		if ($items === false) {
			echo '<p style="'.LFM_US_ALERT_STYLE.'">'.__('Could not retrieve data.', LFM_US_DOMAIN).'</p>'.$after_widget;
			return;
		}

		// Show notice, that we are in testing mode.
		if ($test_run) {
			echo "<p>".__('This widget is only seen by logged-in users!', LFM_US_DOMAIN)."</p>";
		}

		switch ($type) {
			case 1:
				$this->write_events($items, $artistname, $num, $this->sanitize_formatstring($pre_format_string), $this->sanitize_formatstring($format_string), $this->sanitize_formatstring($post_format_string));
				break;
			case 2:
				$this->write_toptracks($items, $artistname, $num, $this->sanitize_formatstring($pre_format_string), $this->sanitize_formatstring($format_string), $this->sanitize_formatstring($post_format_string));
				break;
		}
		echo $after_widget;
	}

	// This is the function that outputs the form to let the users edit
	// the widget's the options for the widget.
	function lfm4a_widget_ctrl( $widget_args = 1 )
	{
        global $wp_registered_widgets;
        static $updated = false;
        if (is_numeric($widget_args))
            $widget_args = array('number' => $widget_args);
        $widget_args = wp_parse_args($widget_args, array('number' => -1));
        extract($widget_args, EXTR_SKIP);
        $options_all = get_option(LFM_US_OPTIONS);
        if (!is_array($options_all))
            $options_all = array();
		if (!$updated && !empty($_POST['sidebar'])) {
			$sidebar = (string)$_POST['sidebar'];

			$sidebars_widgets = wp_get_sidebars_widgets();
			if (isset($sidebars_widgets[$sidebar]))
				$this_sidebar =& $sidebars_widgets[$sidebar];
			else
				$this_sidebar = array();
			foreach ($this_sidebar as $_widget_id) {
				if ('lfm4a_widget' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number']))
				{
					$widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
					if (!in_array("lfm_fa-$widget_number", $_POST['widget-id'])) {
						unset($options_all[$widget_number]);
					}
				}
			}
			foreach ((array)$_POST['widget_lfm_fa'] as $widget_number => $posted) {
				if (!isset($posted['title']) && isset($options_all[$widget_number]))
					continue;

				$options = array();

				$options['type'] = $posted['type'];
				$options['title'] = strip_tags(stripslashes($posted['title']));
				$options['artistname'] = strip_tags(stripslashes($posted['artistname']));
				$options['num'] = strip_tags(stripslashes($posted['num']));
				$options['pre_format_string'] =  stripslashes($posted['pre_format_string']);
				$options['format_string'] =  stripslashes($posted['format_string']);
				$options['post_format_string'] =  stripslashes($posted['post_format_string']);
				$options['hide_on_empty'] = (bool) @ $posted['hide_on_empty'];
				$options['test_run'] = (bool) @ $posted['test_run'];

				$options_all[$widget_number] = $options;
			}
			update_option(LFM_US_OPTIONS, $options_all);
			$updated = true;
		}

        if (-1 == $number) {
            $number = '%i%';
            $values = $GLOBALS['lfmfa_default_options'];
        }
        else {
            $values = $options_all[$number];
        }

		// Be sure you format your options to be valid HTML attributes.
		$type = $values['type'];
		$title = htmlspecialchars($values['title'], ENT_QUOTES);
		$artistname = htmlspecialchars($values['artistname'], ENT_QUOTES);
		$num = htmlspecialchars($values['num'], ENT_QUOTES);
		$pre_format_string = htmlspecialchars($values['pre_format_string'], ENT_QUOTES);
		$format_string = htmlspecialchars($values['format_string'], ENT_QUOTES);
		$post_format_string = htmlspecialchars($values['post_format_string'], ENT_QUOTES);
		$hide_on_empty_checked = ($values['hide_on_empty']) ? 'checked="checked"' : '';
		$test_run = ($values['test_run']) ? 'checked="checked"' : '';

		$examples = $GLOBALS['lfmfa_default_options']['examples'];
        include("lastfm-for-artists-form.php");
	}

	// this outputs our stylesheet and javascript for the admin section.
	function lfm4a_admin_head()
	{
		// only print our code if it's required
		if ( strpos($_SERVER['REQUEST_URI'], 'widgets.php') !== false) {
			$url = get_settings( 'siteurl' );
			$url = $url . '/wp-content/plugins/lastfm-for-artists/';
			echo '<link rel="stylesheet" type="text/css" href="' . $url . 'lastfm-for-artists-admin.css" />';
			echo '
<script type="text/javascript">
	var lastfmFaDefaults = '.json_encode($GLOBALS['lfmfa_default_options']['examples']).';
	var lastfmFaExOptionsStrings = {';
			foreach ($GLOBALS['lfmfa_default_options']['examples'] as $type => $examplesPerType) {
				echo '"'.$type.'":"<option selected=\"selected\" value=\"\">'.__('Custom', LFM_US_DOMAIN); // none
				foreach ($examplesPerType as $exName => $exStrings) {
					echo '<option value=\"'.$exName.'\">'.$exStrings['name'];
				}
				echo '",';
			}
			echo '};</script>';
			echo '<script type="text/javascript" src="' . $url . 'lastfm-for-artists-admin.js"></script>';
		}
	}
	// this function will delete the cache
	function delete_cache() {
		delete_option( LFM_US_CACHE );
	}

	// Modelled on the Magpie function of a similar name
	function fetch_remote_file ( $url )
	{
		// Snoopy is an HTTP client in PHP
		$client = new Snoopy();
		$client->agent = LFM_US_USER_AGENT;
		$client->read_timeout = LFM_US_FETCH_TIME_OUT;
		$client->use_gzip = LFM_US_USE_GZIP;
		// SWTODO: Would be good to utilise last-modified when fetching the initial file, allowing them to return 304 Not Modified, to help reduce Last.FM's load.
		if (is_array($headers) ) {
			$client->rawheaders = $headers;
		}

		@$client->fetch($url);
		return $client;
	}

	function fetch_remote_file_contents( $url )
	{
		$response = $this->fetch_remote_file( $url );
		// Check we had a sensible response
		// If we timed out, return false and we can fall back (hopefully) on a cached version
		if ( $response->timed_out ) return false;
		// If its anything other than 200 OK,
		// e.g. 404 Not Found, 500 Internal Server Error, 304 Not Modified, etc,
		// Request for event info failed, we'll fall back on a (hopefully) cached copy
		if ( $response->status != 200 ) return false;
		// It all looks OK
		$contents = $response->results;

		return $contents;
	}

	// Provide an associative array of event info, using the cache if in date or getting
	// new data if the cache is outdated
	function maybe_get_new_events( $artistname )
	{
		// Check if we've got a cached copy
		$cache = get_option( LFM_US_CACHE );
		// No cache? Get new events...
		if ( !isset( $cache ) or !isset( $cache[$artistname] ) or !isset( $cache[$artistname]['events'] ) ) return $this->get_new_events( $artistname );

		// Check if it's out of date
		$now = time();
		$out_of_date = (bool) (( $now - $cache[$artistname]['events']['modified_timestamp'] ) > LFM_US_CACHE_AGE);

		// Out of date? Get new events...
		if ( $out_of_date ) return $this->get_new_events( $artistname );

		return $cache[$artistname]['events'];
	}
	// Get new events data from Last.FM
	function get_new_events( $artistname )
	{

		// Get the file contents in a way which will work, hopefully even for systems with url_file_open off.
		$url = "http://ws.audioscrobbler.com/2.0/?method=artist.getevents&artist=".str_replace(' ', '+', $artistname)."&api_key=c8034aa60717c2dcac9922e90816f28e";
		$xmlstring = $this->fetch_remote_file_contents( $url );

		// Get cache-object
		$cache = get_option(LFM_US_CACHE);

		// Something went wrong with the request
		if ( $xmlstring === false ) {
			// Error occurde, got a cache? Use it...
			if ( ! empty( $cache ) and  !empty( $cache[$artistname]) and  !empty( $cache[$artistname]['events'] ) ) {
				return $cache[$artistname]['events'];
			}
			return false;
		}

		// get new DOM-Model.
		$xml = new DOMDocument('1.0', 'UTF-8');
		$xml->preserveWhiteSpace = FALSE;
		$xml->loadXML($xmlstring);

		// check if there was an error
		$root = $xml->getElementsByTagName( 'lfm' )->item( 0 );
		if ($root->attributes->getNamedItem( "status" )->nodeValue == "failed") {

			// Error occured, got a cache? Use it...
			if ( ! empty( $cache ) and  !empty( $cache[$artistname]) and  !empty( $cache[$artistname]['events'] ) ) {
				return $cache[$artistname]['events'];
			}
			// fake an event containing the error information.
			return array( array('title' 		=> 'Last.fm ERROR: '.$root->firstChild->nodeValue,
								'description' 	=> 'Could not retrieve any event.',
								'startDate' 	=> time(),
								'startTime' 	=> time()
								)
						);
		} else {
			// seems everything is ok, shift the root to get the raw data
			$root = $root->firstChild;
		}

		// Create an object we can cache, including a modified time so we know when it goes out of date
		if ( !isset( $cache ) ) {
			// completely renew the cache object
			$cache = array( $artistname => array( 'events' => array( 'modified_timestamp' => time() ) ) );
		} else if (!isset( $cache[$artistname] ) ) {
			// create a cache for the used artist
			$cache [ $artistname ] = array( 'events' => array( 'modified_timestamp' => time() ) );
		} else {
			// create a cache for this artists events
			$cache [ $artistname ][ 'events' ] = array( 'modified_timestamp' => time() );
		}

		// Create a reference for ease
		$events = & $cache[$artistname]['events'];
		if (! $root->attributes->getNamedItem( "total" )->nodeValue == "0" ) {
			foreach ( $root->childNodes as $key => $eventNode) {
				$events[$key] = $this->parse_event( $eventNode );
			}
			ksort($events);
		}
		// update cache
		update_option(LFM_US_CACHE, $cache);

		// return events
		return $cache[$artistname]['events'];
	}

	// Provide an associative array of track info, using the cache if in date or getting
	// new data if the cache is outdated
	function maybe_get_new_toptracks( $artistname )
	{
		// Check if we've got a cached copy
		$cache = get_option( LFM_US_CACHE );
		// No cache? Get new events...
		if ( !isset( $cache ) or !isset( $cache[$artistname] ) or !isset( $cache[$artistname]['toptracks'] ) ) return $this->get_new_toptracks( $artistname );

		// Check if it's out of date
		$now = time();
		$out_of_date = (bool) (( $now - $cache[$artistname]['toptracks']['modified_timestamp'] ) > LFM_US_CACHE_AGE);

		// Out of date? Get new events...
		if ( $out_of_date ) return $this->get_new_toptracks( $artistname );

		return $cache[$artistname]['toptracks'];
	}
	// Get new top track data from Last.FM
	function get_new_toptracks( $artistname )
	{

		// Get the file contents in a way which will work, hopefully even for systems with url_file_open off.
		$url = "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=".str_replace(' ', '+', $artistname)."&api_key=c8034aa60717c2dcac9922e90816f28e";
		$xmlstring = $this->fetch_remote_file_contents( $url );

		// Get cache-object
		$cache = get_option(LFM_US_CACHE);

		// Something went wrong with the request
		if ( $xmlstring === false ) {
			// Error occurde, got a cache? Use it...
			if ( ! empty( $cache ) and  !empty( $cache[$artistname]) and  !empty( $cache[$artistname]['toptracks'] ) ) {
				return $cache[$artistname]['toptracks'];
			}
			return false;
		}
		// get new DOM-Model.
		$xml = new DOMDocument('1.0', 'UTF-8');
		$xml->preserveWhiteSpace = FALSE;
		$xml->loadXML($xmlstring);

		// check if there was an error
		$root = $xml->getElementsByTagName( 'lfm' )->item( 0 );
		if ($root->attributes->getNamedItem( "status" )->nodeValue == "failed") {

			// Error occured, got a cache? Use it...
			if ( ! empty( $cache ) and  !empty( $cache[$artistname]) and  !empty( $cache[$artistname]['toptracks'] ) ) {
				return $cache[$artistname]['toptracks'];
			}
			// fake an track containing the error information.
			return array( array('name' 		=> 'Last.fm ERROR: '.$root->firstChild->nodeValue ) );
		} else {
			// seems everything is ok, shift the root to get the raw data
			$root = $root->firstChild;
		}

		// Create an object we can cache, including a modified time so we know when it goes out of date
		if ( !isset( $cache ) ) {
			// create a complete and new cache
			$cache = array( $artistname => array( 'toptracks' => array( 'modified_timestamp' => time() ) ) );
		} else if (!isset( $cache[$artistname] ) ){
			// create an artist-specific cache
			$cache [ $artistname ] = array( 'toptracks' => array( 'modified_timestamp' => time() ) );
		} else {
			// create/overwrite cache for this artists tracks
			$cache [ $artistname ][ 'toptracks' ] = array( 'modified_timestamp' => time() );
		}

		// Create a reference for ease
		$tracks = & $cache[$artistname]['toptracks'];

		foreach ( $root->childNodes as $key => $trackNode) {
			$tracks[$key] = $this->parse_toptrack( $trackNode );
		}
		// update cache
		update_option(LFM_US_CACHE, $cache);

		// return events
		return $cache[$artistname]['toptracks'];
	}

	function parse_toptrack($trackNode)
	{
		// A nice clean array of information
		$track= array();
		// get rank attrinute
		$track['rank'] = $trackNode->attributes->getNamedItem( "rank" )->nodeValue;

		// Go through the childnodes and extract the information
		foreach ($trackNode->childNodes as $currentNode) {
			switch ($currentNode->nodeName) {
			// artist is nested and will be ignored
			case 'artist':
				break;
			case 'streamable':
				$track['full_streamable'] = $currentNode->attributes->getNamedItem( "fulltrack" )->nodeValue;
				$track['streamable'] = $currentNode->nodeValue;
				break;

			/* Default will work for:
				name
				playcount
				mbid
				url
				image
			*/
			default:
				$track[$currentNode->nodeName] = $currentNode->nodeValue;
				break;
			}
		}
		return $track;
	}

	function parse_event($eventNode)
	{
		// A nice clean array of information
		$event = array();
		// Go through the childnodes and extract the information
		foreach ($eventNode->childNodes as $currentNode) {
			switch ($currentNode->nodeName) {
			// artists are nested.
			case "artists":
				foreach($currentNode->childNodes as $artist) {
					switch ($artist->nodeName) {
					case "artist":
						$event['artists'][] = $artist->nodeValue;
						break;
					case "headliner":
						$event['headliner'] = $artist->nodeValue;
						break;
					}
				}
				break;
			// venue is deeply nested
			case "venue":
				$event['venue'] = $this->parse_venue($currentNode);
				break;
			case "startDate":
				// remove abbreviated weekday. example: Sat, 06 Sep 2008
				$event["startDate"] = strtotime(substr($currentNode->nodeValue,5));
				break;
			case "startTime":
				$event["startTime"] = strtotime($currentNode->nodeValue);
				break;
			case "endDate":
				// remove abbreviated weekday. example: Sat, 06 Sep 2008
				$event["endDate"] = strtotime(substr($currentNode->nodeValue,5));
				break;

			/* Default will work for:
				id
				title
				description
				attendance
				reviews
				url
				tag
				image (since the largest is the last mentioned, the largest will be stored)
			*/
			default:
				$event[$currentNode->nodeName] = $currentNode->nodeValue;
				break;
			}
		}
		return empty($event) ? NULL : $event;
	}

	function parse_venue($venueNode)
	{
		// A nice clean array of information
		$venue = array();
		// Go through the childnodes and extract the information
		foreach ($venueNode->childNodes as $currentNode) {
			switch ($currentNode->nodeName) {
			// location is nested.
			case "location":
				foreach($currentNode->childNodes as $locationInfo) {
					switch ($locationInfo->nodeName) {
					// geo:point is nested
					case "geo:point":
						if (!$locationInfo->hasChildNodes()) break;
						$latlong = $locationInfo->childNodes->item(0);
						$venue['location']['geo:point'][$latlong->nodeName] = $latlong->nodeValue;
						$latlong = $latlong->nextSibling;
						$venue['location']['geo:point'][$latlong->nodeName] = $latlong->nodeValue;
						break;
					/* default will work for:
						city
						country
						street
						postalcode
					*/
					default:
						$venue['location'][$locationInfo->nodeName] = $locationInfo->nodeValue;
						break;
					}
				}
				break;
			/* Default will work for:
				name
				url
			*/
			default:
				$venue[$currentNode->nodeName] = $currentNode->nodeValue;
				break;
			}
		}
		return $venue;
	}

	function expand_lastfm_event_tags($format_string, $event = array(), $specials = array())
	{
		$event_string = $format_string;

		// do some date formating, if multi day make "01.-03.01.2000" else ("01.01.2000" or "01.01.2000 20:00" when available)
		// TODO: check for multi day whether month is the same
		$start_date = isset($event['startDate']) ? strftime(__('%d.%m.%y', LFM_US_DOMAIN), $event['startDate']) : '';
		$end_date = isset($event['endDate']) ? strftime(__('%d.%m.%y',LFM_US_DOMAIN), $event['endDate']) : $start_date;

		if ($start_date != $end_date) {
			$date_string = strftime(__('%d.',LFM_US_DOMAIN), $event['startDate'])."-".$end_date;
		} else {
			$date_string = $start_date;
			if (isset($event['startTime'])) $date_string = $date_string.' '.strftime(__('%H:%M', LFM_US_DOMAIN), $event['startTime']);
		}
		// Location summary = city, name
		$location = $event['venue']['name'];
		if (isset($event['venue']['location']['city'])) {
			$location = $event['venue']['location']['city'].', '.$location;
		}
	// since v0.3
		$event_string = str_replace( '%URL%', 				$event['url'], 															$event_string );
		$event_string = str_replace( '%TITLE%', 			$event['title'], 														$event_string );
		$event_string = str_replace( '%ARTISTS%', 			( isset( $event['artists']) ? implode(', ',$event['artists'] ) : ''), 	$event_string );
		$event_string = str_replace( '%HEADLINER%', 		$event['headliner'], 													$event_string );
		$event_string = str_replace( '%DATE%', 				$date_string, 															$event_string );
		$event_string = str_replace( '%STARTDATE%', ( isset( $event['startDate']) ? strftime( __( '%d.%m.%y', LFM_US_DOMAIN), $event['startDate'] ) : '' ), $event_string );
		$event_string = str_replace( '%ENDDATE%', ( isset( $event['endDate']) ? strftime( __( '%d.%m.%y', LFM_US_DOMAIN), $event['endDate'] ) : '' ), $event_string );
		$event_string = str_replace( '%STARTTIME%', ( isset( $event['startTime']) ? strftime( __( '%H:%M', LFM_US_DOMAIN), $event['startTime'] ) : '' ), $event_string );
		$event_string = str_replace( '%LOCATION-SUMMARY%', 	$location, 																$event_string );
		$event_string = str_replace( '%DESCRIPTION%', 		strip_tags( $event['description'], '<br>' ), 							$event_string );
		$event_string = str_replace( '%IMAGE-URL%', 		$event['image'], 														$event_string );
		$event_string = str_replace( '%ATTENDANCE%', 		$event['attendance'],													$event_string );
		$event_string = str_replace( '%REVIEWS%', 			$event['reviews'], 														$event_string );
		$event_string = str_replace( '%TAG%', 				$event['tag'], 															$event_string );
		$event_string = str_replace( '%ID%',				$event['id'], 															$event_string );
		$event_string = str_replace( '%LOCATION-NAME%', 	$event['venue']['name'], 												$event_string );
		$event_string = str_replace( '%LOCATION-URL%', 		$event['venue']['url'], 												$event_string );
		$event_string = str_replace( '%LOCATION-CITY%', 	$event['venue']['location']['city'], 									$event_string );
		$event_string = str_replace( '%LOCATION-COUNTRY%', 	$event['venue']['location']['country'], 								$event_string );
		$event_string = str_replace( '%LOCATION-STREET%', 	$event['venue']['location']['street'], 									$event_string );
		$event_string = str_replace( '%LOCATION-POSTALCODE%', $event['venue']['location']['postalcode'],	 						$event_string );
		$event_string = str_replace( '%LOCATION-LATITUDE%', $event['venue']['location']['geo:point']['geo:lat'],					$event_string );
		$event_string = str_replace( '%LOCATION-LONGITUDE%',$event['venue']['location']['geo:point']['geo:long'], 					$event_string );
		$event_string = str_replace( '%LOCATION-TIMEZONE%', $event['venue']['location']['timezone'], 								$event_string );
	// v0.4
		$event_string = str_replace( '%COUNTDOWN%', 		( isset( $event['startDate'] ) ? $this->time_difference($event['startDate']) : '' ), $event_string );
		$event_string = str_replace( '%NUMBER-OF-EVENTS%', ( isset( $specials['NUMBER-OF-EVENTS'] ) ? $specials['NUMBER-OF-EVENTS'] : '' ), $event_string );
		$event_string = str_replace( '%NUMBER%', 			( isset( $specials['NUMBER'] ) ? $specials['NUMBER'] : '' ), 			$event_string );
		$event_string = str_replace( '%ARTIST-URL%', 		( isset( $specials['ARTIST-URL'] ) ? $specials['ARTIST-URL'] : '' ), 	$event_string );

		return $event_string;
	}

	function expand_lastfm_toptrack_tags($format_string, $track = array(), $specials = array(), $recursed = false)
	{
		$track_string = $format_string;

	// since v0.6
		$track_string = str_replace( '%NAME%', 				$track['name'],															$track_string );
		$track_string = str_replace( '%RANK%', 				$track['rank'], 														$track_string );
		$track_string = str_replace( '%PLAYCOUNT%',			$track['playcount'],													$track_string );
		$track_string = str_replace( '%TRACK-MBID%', 		$track['mbid'], 														$track_string );
		$track_string = str_replace( '%URL%', 				$track['url'], 															$track_string );
		// special, because recursion occurs, but restrict single recursion
		if ( !$recursed and preg_match_all( '/%IF-STREAMABLE%(.*)%END-IF%/sU', $track_string, $matches, PREG_SET_ORDER ) >= 1) {
			foreach( $matches as $match ) {
				$sub_string = ($track['streamable'] ? $this->expand_lastfm_toptrack_tags( $match[1], $track, $specials, true ) : '' );
				$track_string = str_replace( $match[0], 	$sub_string, 															$track_string );
			}
		}
		// special, because recursion occurs, but restrict single recursion
		if ( !$recursed and preg_match_all( '/%IF-FULL-STREAMABLE%(.*)%END-IF%/sU', $track_string, $matches, PREG_SET_ORDER ) >= 1) {
			foreach( $matches as $match ) {
				$sub_string = ($track['full_streamable'] ? $this->expand_lastfm_toptrack_tags( $match[1], $track, $specials, true ) : '' );
				$track_string = str_replace( $match[0],		$sub_string, 															$track_string );
			}
		}
		$track_string = str_replace( '%IMAGE-URL%', 		$track['image'],														$track_string );
		$track_string = str_replace( '%ARTIST-URL%', 		$specials['ARTIST-URL'],												$track_string );
		$track_string = str_replace( '%NUMBER-OF-TRACKS%',	$specials['NUMBER-OF-TRACKS'],											$track_string );
		$track_string = str_replace( '%NUMBER%',			$specials['NUMBER'],													$track_string );
		return $track_string;
	}

	// Display Last.fm events.
	function write_events($events, $artistname , $num , $pre_format_string,	$format_string, $post_format_string )
	{
		// Minimum 1
		if ($num <= 0) $num = 1;
		// Max 100 events
		if ($num > 100) $num = 100;

		if ($artistname == '') {
			// MISSING ARTISTNAME !!!
			echo '<p style="'.LFM_US_ALERT_STYLE.'"><strong>'.__( 'You need to set a Last.FM artistname!', LFM_US_DOMAIN ).'</strong>'.__('Edit the widget settings to add it.', LFM_US_DOMAIN).'</p>';
		} else {
			if ( empty($events) ) {
				echo '<p><em>'.__( 'No events coming up.', LFM_US_DOMAIN ).'</em></p>';
			} else {
				// prepare global special tags.
				$specials = array ( 'NUMBER-OF-EVENTS' 	=> sizeof($events),
									'ARTIST-URL' 		=> "http://".__('www.last.fm', LFM_US_DOMAIN)."/music/$artistname/+events/"
								);
				// use first events data to expand header
				echo $this->expand_lastfm_event_tags( $pre_format_string, $events[0], $specials );
				
				foreach ( $events as $counter => $event ) {
					// ignore meta
					if ($counter  === 'modified_timestamp') continue;
					
					// copy over event data to event variable (prevents the loop to override event with meta info)
					$realEvent = $event;

					// prepare event-specials
					$specials['NUMBER'] = $counter;

					// expand and output format-string
					echo $this->expand_lastfm_event_tags( $format_string, $realEvent, $specials );

					// break loop if max events are reached.
					if ( $counter >= $num-1 ) break;
				}
				// specials are already of last event
				echo $this->expand_lastfm_event_tags( $post_format_string, $realEvent, $specials );
			}
		}
	}

	// Display Last.fm top tracks.
	function write_toptracks($toptracks, $artistname , $num , $pre_format_string,	$format_string, $post_format_string )
	{

		if ($num <= 0) $num = 1;
		// Max 50 tracks
		if ($num > 50) $num = 50;

		if ($artistname == '') {
			// MISSING ARTISTNAME !!!
			echo '<p style="'.LFM_US_ALERT_STYLE.'"><strong>'.__( 'You need to set a Last.FM artistname!', LFM_US_DOMAIN ).'</strong>'.__('Edit the widget settings to add it.', LFM_US_DOMAIN).'</p>';
		} else {
			if ( empty($toptracks) ) {
				echo '<p><em>'.__( 'No tracks found.', LFM_US_DOMAIN ).'</em></p>';
			} else {
				// prepare global special tags.
				$specials = array ( 'NUMBER-OF-TRACKS' 	=> sizeof($toptracks),
									'ARTIST-URL' 		=> "http://".__('www.last.fm', LFM_US_DOMAIN)."/music/$artistname/"
								);
				// use first tracks data to expand header
				echo $this->expand_lastfm_toptrack_tags( $pre_format_string, $toptracks[0], $specials );
				
				foreach ( $toptracks as $counter => $toptrack ) {
					// ignore meta
					if ($counter  === 'modified_timestamp') continue;
					
					// copy over track data to track variable (prevents the loop to override track with meta info)
					$realTrack = $toptrack;

					// prepare event-specials
					$specials['NUMBER'] = $counter;

					// expand and output format-string
					echo $this->expand_lastfm_toptrack_tags( $format_string, $realTrack, $specials );

					// break loop if max events are reached.
					if ( $counter >= $num-1 ) break;
				}
				// specials are already of last event
				echo $this->expand_lastfm_toptrack_tags( $post_format_string, $realTrack, $specials );
			}
		}
	}

	// Return the time either until or ago in months, weeks and days
	// Very rough, assumes a day is 24 hours (i.e. ignores daylight saving)
	function time_difference($timestamp)
	{

		$diff = $timestamp - time();
		$time_difference = "";
		$prefix = ( __('usefutureprefix', LFM_US_DOMAIN) == 'usefutureprefix' ? __('In ', LFM_US_DOMAIN) : '' );
		$suffix = ( __('usefutureprefix', LFM_US_DOMAIN) == 'false' ? __(' noch', LFM_US_DOMAIN) : '' );
		$past = false;
		if ( $diff < 0 ) {
			$past = true;
			$prefix = ( __('usepastprefix', LFM_US_DOMAIN) == 'false' ? __('Vor ', LFM_US_DOMAIN) : '' );
			$suffix = ( __('usepastprefix', LFM_US_DOMAIN) == 'usepastprefix' ? __(' ago', LFM_US_DOMAIN) : '' );
			// Got to deal with positive numbers
			$diff = $diff * -1;
		}

		// Define our time periods in seconds
		$minute = 60; // Start off with a minute being 60 seconds
		$hour = 60 * $minute; // Fairly safe
		$day = 24 * $hour; // Inaccurate, as it ignores daylight saving
		$week = 7 * $day; // Fairly safe
		$month = 4 * $week; // Obviously inaccurate

		$diffs = getdate($diff);
		$diffs['mon']--;
		$diffs['mday'];

		$months = $diffs['mon'];
		$weeks = floor($diffs['mday'] / 7);
		$days = $diffs['mday'] - $weeks*7;

		if ($months>0) {
			$time_difference = $months.' ';
			if ( $months == 1 ) {
				$time_difference .= __('month', LFM_US_DOMAIN);
			} else {
				$time_difference .= __('months', LFM_US_DOMAIN);
			}
		}
		if ($weeks>0) {
			$time_difference .= ($time_difference?' '.__('and', LFM_US_DOMAIN).' ':'').$weeks.' ';
			if ( $weeks == 1 ) {
				$time_difference .= __('week', LFM_US_DOMAIN);
			} else {
				$time_difference .= __('weeks', LFM_US_DOMAIN);
			}
		}
		if ($past) {
			$days--;
			if ($months == 0 and $weeks == 0 and $days==0) {
				$time_difference = __('Today', LFM_US_DOMAIN);
				return $time_difference;
			}
		}
		if ($days>0) {
			$time_difference .= ($time_difference?' '.__('and', LFM_US_DOMAIN).' ':'').$days.' ';
			if ( $days == 1 ) {
				$time_difference .= __('day', LFM_US_DOMAIN);
			} else {
				$time_difference .= __('days', LFM_US_DOMAIN);
			}
		}
		// Add proper verbiage
		$time_difference = $prefix . $time_difference . $suffix;
		return $time_difference;
	}
}


// construct an instance of the plugin
$lfm4a = new LastFmForArtists();
?>