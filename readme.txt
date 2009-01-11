=== Last.fm For Artists ===
Contributors: j.org
Tags: lastfm, events, gigs, charts, top, concerts, music, widget, sidebar, REST, calendar
Requires at least: 2.3
Tested up to: 2.7
Stable Tag: 0.6.1

This plugin adds a widget to show an artists event and/or charts data from Last.FM. Comes with FULL customization.

== Description ==
This plugin adds a widget to list an artists upcoming shows or your top tracks from Last.FM on your Wordpress blog (using the new 2.0 REST API).

Current features:
* event listing
* top track listing
* multiple widgets the way they meant to be (add arbitrarily many widget instances to your sidebar)
* complete customization of the list view possible via format strings and tags
* I18n available: English, German. Add your own!

Please let me know about bugs and improper translations you may encounter.

For a changelog see [here](http://www.brain-jek.de/wordpress/lastfm-for-artists/ "Plugin Website")

== Screenshots ==
1. Left: A simple <ul> list of the upcoming events. Middle-top: More sophisticated, a GoogleMaps mash-up displaying the tour. Middle-bottom: new in v0.6, display an artists top tracks. Right: The widget options.

== Installation ==

1. Upload `lastfm-for-artists` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the widget to a sidebar, and configure the options (otherwise it will show my preferred style and my own band :D )


== Frequently Asked Questions ==

As soon as your question arrives I will add it here.

= Some weird error message =
Do your server run php5? We need the "DOM" section of your phpinfo() show "enabled"-values.

= There's an error message like "ERROR: domdocument::domdocument() expects 2 parameter to be long" =
Disable the `domxml` extension of your php installation. `domxml` is a legacy extension introduced for php4 which lacks cool dom-functions. But in php5 they are built in and - guess what - **incompatible** with the old extension. So we rely on the new bright and shiny built-in functions.


== Other Notes ==

The *format of dates and times* are part of the translation files. Let me know if this should be another user-editable option.