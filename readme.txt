=== Last.fm For Artists ===
Contributors: j.org
Donate link: http://www.brain-jek.de/
Tags: lastfm, events, gigs, charts, top, concerts, music, widget, sidebar, REST, calendar
Requires at least: 2.5
Tested up to: 2.7.1
Stable Tag: 0.7.1

This plugin adds a fully customizable sidebar-widget to list an artists upcoming shows or top tracks from Last.FM (using the new 2.0 REST API).

== Description ==
This plugin adds a sidebar-widget to list an artists upcoming shows or top tracks from Last.FM (using the new 2.0 REST API).

**This plugin requires PHP 5.**

Current features:

* event listing
* top track listing
* multiple widgets the way they meant to be (add arbitrarily many widget instances to your sidebar)
* comes with many pre-defined widget layouts
* complete customization of widget layout possible via format strings and tags
* I18n available: English, German, Russian. Add your own!

Please let me know about bugs and improper translations you may encounter.

* [release notes](http://www.brain-jek.de/2009/release-lastfm-for-artists-07/ "0.7 release notes")
* [changelog and documentation](http://www.brain-jek.de/wordpress/lastfm-for-artists/ "Plugin Website")

== Screenshots ==
1. Left: A simple unordered list of the upcoming events. Middle-top: More sophisticated, a GoogleMaps mash-up displaying the tour. Middle-bottom: display an artists top tracks. Right: The widget options.

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

= Can I use this plugin without a widget? =
Unfortunately this is not possible. As all options are set on a per-widget basis, there is no way to display a list without a widget.

= Can you translate the plugin to language [insert-your-language] =
No... but: **You can!** Just have a look at the translation files and/or contact me for further instructions.

== Other Notes ==

The *format of dates and times* are part of the translation files. Let me know if this should be another user-editable option.