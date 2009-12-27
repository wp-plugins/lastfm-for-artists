=== Last.fm For Artists ===
Contributors: j.org
Donate link: http://www.brain-jek.de/
Tags: lastfm, events, gigs, charts, top, concerts, music, widget, sidebar, REST, calendar
Requires at least: 2.5
Tested up to: 2.9
Stable Tag: 0.7.2

This plugin adds a fully customizable sidebar-widget to list an artists upcoming shows or top tracks from Last.FM (using the new 2.0 REST API).

== Description ==
This plugin adds a sidebar-widget to list an artists upcoming shows or top tracks from Last.FM (using the new 2.0 REST API).

**This plugin requires PHP 5.**

Current features:

* event listing
* top track listing
* multi-widgets (add arbitrarily many widget instances to your sidebar)
* comes with many pre-defined widget layouts
* complete customization of widget layout possible via format strings and tags
* I18n available: English, German, Russian. Add your own!

Please let me know about bugs and improper translations you may encounter.

* [documentation](http://www.brain-jek.de/wordpress/lastfm-for-artists/ "Plugin Website")

== Screenshots ==
1. Left: A simple unordered list of the upcoming events. Middle-top: More sophisticated, a GoogleMaps mash-up displaying the tour. Middle-bottom: display an artists top tracks. Right: The widget options.

== Changelog ==

= 0.7.2 =

* [CHECK] Compatibility with wordpress 2.9
* [FIX] css tweak in built-in layouts
* [FIX] some configurations generated invalid markup.

= 0.7.1 =

* [FIX] Variable substitution for GoogleMaps generated invalid markup
* [ADD] Russian translation by "Fat Cow" (www.fatcow.com)

= 0.7 =

* [FIX] uninstall method changed
* [FIX] another try to avoid doubled entries
* [FIX] hide-if-empty was broken
* [ADD] now the plugin carries some cool ready-to-use layout variants (fully customizable, of course)
* [CHANGE] the built-in layouts now feature robust, CSS-driven tooltips
* [ADD] there is a new special tag for variables %VARIABLE:<name-of-variable>:<value-of-variable>% which is only useful in built-in configurations and needed for things like API keys

= 0.6.2 =

* [FIX] Thickbox script now only in admin panel, hence avoiding the 404 when auto-loading loadingAnimation.gif in posts with permalinks enabled.

= 0.6.1 =

* [FIX] CSS Compatibility with 2.7
* [FIX] Plugin subtitle in widget view localized
* [ADD] Un-Installation procedure
* [ADD] Introducing advanced customization ;)

= 0.6 =
* [ADD] New widget type: top tracks
** lists your top 50 (or less)
** comes with own set of 11 tags, including a special, if-then tag
** I included a working example, which illustrates the power. See the examples on the documentation page for a short explanation.
* [ADD] more clarity in widget options

= 0.5 =

* [ADD] Multi-Widget support added. Thanks to Millan and Firephp

= 0.4 =
* [FIX] Widget-Options bug when adding the widget to the sidebar.
* [FIX] Date-Tag bug
* [ADD] Some new Meta-Tags: %NUMBER-OF-EVENTS%, %NUMBER%, %ARTIST-URL%
* [ADD] Additional options for header and footer, allowing complete customization.

= 0.3 =

* Completed tag support: Every delivered field may now be used.
* Language support enabled, German and English included. You are welcome to submit your language, since the necessary files to translate are in the "lang" folder.

= 0.2 =

* Extended tag support: Almost every field of the XML answer may now be used
* Language support prepared.
* more style in widget options

= 0.1 =
* Initial Version based on Simon Wheatley Last.FM Events plug-in.

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