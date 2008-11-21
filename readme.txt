=== Last.fm For Artists ===
Contributors: j.org
Tags: lastfm, events, gigs, charts, top, concerts, music, widget, sidebar, REST, calendar
Requires at least: 2.3
Tested up to: 2.6.3
Stable Tag: 0.6

This plugin adds a widget to show an artists event and/or charts data from Last.FM. Comes with FULL customization.

== Description ==
This plugin adds a widget to list your upcoming shows or your top tracks from Last.FM on your Wordpress blog (using the new 2.0 REST API), with full customization of the displayed html. Additionally you can directly add and customize as many widgets as you want, there is no extra options page.

This plugin is still in development, but is stable enough that I use it on my own blog.

Please let me know about bugs and improper translations you may encounter. **I cannot fix bugs I don't know.**

For a changelog see [here](http://www.jek-source.net/#download "Plugin Website")

== Screenshots ==
1. Left: A simple <ul> list of the upcoming events. Middle-top: More sophisticated, a GoogleMaps mash-up displaying the tour. Middle-bottom: new in v0.6, display an artists top tracks. Right: The widget options.

== Installation ==

1. Upload `lastfm-for-artists` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the widget to a sidebar, and configure the options (otherwise it will show my preferred style and my own band :D )

Note:
Until I implement some kind of option-migration, the plugin will **delete ALL options** upon deactivation. This is the way you can reset the options if something crazy is going on. Up to now I recommend upgraders to 

1. copy their options and paste 'em in a simple text editor
1. deactivate the plugin (and therefor remove all options off the database)
1. perform the upgrade by replacing the old files by the new files, possibly adding some new files.
1. activate the upgraded version and paste your previously saved options in newly added widgets.
1. explore the new shiny and sparkling features ;)

I'm sorry for any inconvenience this may cause. But before version 1.0 I'd rather develop new features, shouldn't I? 

== Frequently Asked Questions ==
As soon as your question arrives I will add it here.
= Some weird error message =
Do your server run php5? We need the "DOM" section of your phpinfo() show "enabled"-values.

= There's an error message like "ERROR: domdocument::domdocument() expects 2 parameter to be long" =
Disable the `domxml` extension of your php installation. `domxml` is a legacy extension introduced for php4 which lacks cool dom-functions. But in php5 they are built in and - guess what - **incompatible** with the old extension. So we rely on the new bright and shiny built-in functions.


== Other Notes ==

= Known Issues =
*none so far*

= Notes =
The *format of dates and times* are part of the translation files. Let me know if this should be another user-editable option.

== Documentation ==
The widget should be self-explanatory, you can also visit the [plugin homepage](http://www.jek-source.net) for more information.

The most important options are the **Format Strings**. They determine how the items will be displayed. For every item Last.fm has delivered there will occur a replacement with the format-string. Use html code mixed with the listed tags and you're fine. Inside the header the most tags represent information of the first item, for the footer the tags still contain information about the last showed item. I've included my own preferences as defaults, but only your imagination is the limit.

I gathered some self-made examples of format-string combinations on [my homepage](http://jek-source.net/#documentation), feel free to drive by and check out.