=== Last.fm For Artists ===
Contributors: j.org, simonwheatley
Tags: lastfm, events, gigs, concerts, music, widget, sidebar, REST, calendar
Requires at least: 2.3
Tested up to: 2.6.1
Stable Tag: 0.5

This plugin adds a widget to show artist event data from Last.FM. Comes with full customization.

== Description ==
This plugin adds a widget to list your upcoming shows from Last.FM on your Wordpress blog (using the new 2.0 REST API), with full customization of the displayed html.

This plugin is still in development, but is stable enough that I use it on my own blog.

Please let me know about bugs and improper translations you may encounter. **I cannot fix bugs I don't know.**

For a changelog see [here](http://www.jek-source.net/#download "Plugin Website")

== Screenshots ==
Please provide screenshots of how YOU use this plugin!

1. v0.5 - nice integration in your theme. [de-DE]

2. v0.5 - widget options [de-DE]

== Installation ==

1. Upload `lastfm-for-artists` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the widget to a sidebar, and configure the options (otherwise it will show my preferred style and my own band :D )

Note:
Until I implement some kind of option-migration, the plugin will **delete ALL options** upon deactivation. This is the way you can reset the options if something crazy is going on. Up to now I recommend upgraders to 

1. copy their options
1. deactivate the plugin (and therefor remove all options off the database)
1. perform the upgrade by replacing the old files by the new files.
1. activate the upgraded version an paste your previously saved options.

I'm sorry for any inconvenience this may cause, but you can always try your luck by performing just step 3. If something goes wrong, perform the long run.

== Frequently Asked Questions ==
As soon as your question arrives I will add it here.
= Some weird error message =
Do your server run php5? We need the "DOM" section of your phpinfo() show "enabled"-values.

= There's an error message like "ERROR: domdocument::domdocument() expects 2 parameter to be long" =
Disable the "domxml" extension of your php installation. "domxml" is a legacy extension introduced for php4 which lacks cool dom-functions. But in php5 they are built in and - guess what - **incompatible** with the old extension. Se we rely on the new bright and shiny built-in functions.


== Other Notes ==
= Planned features =
* new meta-tags (e.g. "duration-days"), any further suggestions?
* maybe migrate to own database-table instead of using the wordpress options-table (which is sooo easy to use btw :) )
* more widget types. which one do **YOU** need?

= Known Issues =
*none so far*

= Notes =
The *format of dates and times* are part of the translation files. Let me know if this should be another user-editable option.

== Documentation ==
The widget should be self-explanatory, you can also visit the [plugin homepage](http://www.jek-source.net) for more information.

= Options =
* **Title**: This will be the title of the widget.
* **Artistname**: This one is needed for the communication with Last.fm, you must use a Last.fm artist name.
* **Hide this widget if there are no shows**: self-explanatory, I guess.
* **Profile link text**: Under the list of shows, there will be a "_blank" link to the Last.fm artist page. This option determines the link text.
* **Maximum number of events**: Useful, if your artist is on a thousand-shows-tour ;).
* **Format Strings**: These are the *most* important options, since they determine how the shows will be displayed. For every show Last.fm has delivered there will occur a replacement with the format-string. Use html code mixed with the listed tags and you're fine. Inside the header the most tags represent information of the first show, for the footer the tags still contain information about the last showed item. I've included my own preferences as defaults, but only your imagination is the limit. What I would really like is somebody reporting a working mashup with google-maps, which should be possible by adding some additional javascript.

= Format String Examples =

*If you have some neat examples and screenshots, don't hesitate to send them to me, and I'll do my best to add them here.*