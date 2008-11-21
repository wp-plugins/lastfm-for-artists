<div class="tipped">
<!-- event tags -->
	<div class="lfmfa_event_tags"<?php echo ( $type == 1 ? '' : ' style="display:none;"');?>>
	<p><a>%URL%<span><? _e( 'The Last.fm webpage of the event. Equals to &quot;http://www.last.fm/event/%ID%&quot;', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%TITLE%<span><? _e( 'The title of the event, may be equal to the headliner.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%DESCRIPTION%<span><? _e( 'A description, may be empty and may contain some html (currently only &lt;br&gt; is allowed).', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%ARTISTS%<span><? _e( 'A comma-separated list of the artists playing at the event.', LFM_US_DOMAIN); ?></span></a> (*)</p>
	<p><a>%HEADLINER%<span><? _e( 'The artist marked to be the headliner of the event. Also mentioned in %ARTISTS%.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%DATE%<span><? _e( 'A convenient date, i.e. if a one-day event &quot;%STARTDATE% %STARTTIME%&quot;, else &quot;%STARTDATE%-%ENDDATE%&quot;.', LFM_US_DOMAIN); ?></span></a> (*)</p>
	<p><a>%STARTDATE%<span><? _e( 'The date the event will begin.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%STARTTIME%<span><? _e( 'The time the event will begin, may be empty.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%ENDDATE%<span><? _e( 'The date the event will end.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%ATTENDANCE%<span><? _e( 'The number of Last.fm users who said to attend the event.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%REVIEWS%<span><? _e( 'The number of reviews for this event, most likely to be 0 because only future events are listed.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-SUMMARY%<span><? _e( 'A convenient location summary, equals to &quot;%LOCATION-CITY%, %LOCATION-NAME%&quot;.', LFM_US_DOMAIN); ?></span></a> (*)</p>
	<p><a>%LOCATION-NAME%<span><? _e( 'The name of the venue.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-URL%<span><? _e( 'The Last.fm webpage of the venue.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-CITY%<span><? _e( 'The city the venue is located in.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-COUNTRY%<span><? _e( 'The country the city is located in. ;)', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-STREET%<span><? _e( 'The adress of the venue. May be empty.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-POSTALCODE%<span><? _e( 'The adress of the venue. May be empty.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-LATITUDE%<span><? _e( 'The latitude of the location.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-LONGITUDE%<span><? _e( 'The longitude of the location.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%LOCATION-TIMEZONE%<span><? _e( 'The timezone the location is located in.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%IMAGE-URL%<span><? _e( 'The URL of the Last.fm image for the event, most likely the headliner.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%TAG%<span><? _e( 'The Last.fm tag for the event, equals to &quot;lastfm:event=%ID%&quot;.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%ID%<span><? _e( 'The Last.fm id of the event.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%COUNTDOWN%<span><? _e( 'A countdown in months/weeks/days to this event.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%NUMBER-OF-EVENTS%<span><? _e( 'The number of events delivered by Last.fm.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%NUMBER%<span><? _e( 'The number of the current event, starts at 0.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%ARTIST-URL%<span><? _e( 'The URL of the last.fm artists event page.', LFM_US_DOMAIN); ?></span></a></p>
	</div>
	<div class="lfmfa_toptrack_tags"<?php echo ( $type == 2 ? '' : ' style="display:none;"');?>>
<!-- toptrack tags -->
	<p><a>%NAME%<span><? _e( 'The name of the track.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%RANK%<span><? _e( 'The rank of the current track, most likely %NUMBER%+1.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%PLAYCOUNT%<span><? _e( 'How often this track has been played by last.fm users.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%URL%<span><? _e( 'A URL of the last.fm page for this song. Concatenate &quot;?autostart&quot; to let the music play!', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%IF-STREAMABLE% ... %END-IF%<span><? _e( 'This is kind of special: replace &quot;...&quot; with any valid sub-formatstring and it only gets evaluated, if this track is marked &quot;streamable&quot; by Last.fm.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%IF-FULL-STREAMABLE% ... %END-IF%<span><? _e( 'Same as above, but stronger: evaluation will only occur, if this track may be streamed full length.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%TRACK-MBID%<span><? _e( 'The Musicbrainz Track ID, may be empty.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%IMAGE-URL%<span><? _e( 'The URL of an image for the track, most likely the corresponding album art.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%ARTIST-URL%<span><? _e( 'The URL of the last.fm artist page.', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%NUMBER-OF-TRACKS%<span><? _e( 'The number of top-tracks delivered by Last.fm. (max. 50)', LFM_US_DOMAIN); ?></span></a></p>
	<p><a>%NUMBER%<span><? _e( 'The number of the current track, starts at 0.', LFM_US_DOMAIN); ?></span></a></p>
<!-- end tags -->
	</div>
	 (*) <? _e('means the string is being pre-processed by the plugin.', LFM_US_DOMAIN); ?>
</div>
<!-- actual form -->
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_title"><? _e('Title:', LFM_US_DOMAIN);?>
	    <input style="width: 200px;" id="lfmfa_<?php echo $number; ?>_title" name="widget_lfm_fa[<?php echo $number; ?>][title]" type="text" value="<?php echo $title; ?>" />
    </label></p>
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_artistname"><? _e('Artistname:', LFM_US_DOMAIN ); ?>
    	<input style="width: 200px;" id="lfmfa_<?php echo $number; ?>_artistname" name="widget_lfm_fa[<?php echo $number; ?>][artistname]" type="text" value="<?php echo $artistname; ?>" />
    </label></p>
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_artistname"><? _e('type of widget:', LFM_US_DOMAIN ); ?>
		<select onchange="lastfm_fa_show_hide_tags(this);" name="widget_lfm_fa[<?php echo $number; ?>][type]" size="1">
			<option  value="1"<?php echo ( $type == 1 ? ' selected="true"' : '');?>><?php _e( 'upcoming shows', LFM_US_DOMAIN); ?>
			<option  value="2"<?php echo ( $type == 2 ? ' selected="true"' : '');?>><?php _e( 'top tracks', LFM_US_DOMAIN); ?>
        </select>
    </label></p>
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_hide_on_empty"><? _e('Hide this widget if there are no items:', LFM_US_DOMAIN ); ?>
	    <input id="lfmfa_<?php echo $number; ?>_hide_on_empty" name="widget_lfm_fa[<?php echo $number; ?>][hide_on_empty]" type="checkbox" <?php echo $hide_on_empty_checked; ?> />
    </label></p>
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_test_run"><? _e('Enable testing mode (only logged-in users will see the widget):', LFM_US_DOMAIN ); ?>
    	<input id="lfmfa_<?php echo $number; ?>_test_run" name="widget_lfm_fa[<?php echo $number; ?>][test_run]" type="checkbox" <?php echo $test_run; ?> />
    </label></p>
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_num"><? _e('Maximum number of items:', LFM_US_DOMAIN ); ?>
	    <input style="width: 25px;" id="lfmfa_<?php echo $number; ?>a_num" name="widget_lfm_fa[<?php echo $number; ?>][num]" type="text" value="<?php echo $num; ?>" />
    </label></p>
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_pre_format_string"><? _e('The Format String serving as header of your list, available data is of the first item:', LFM_US_DOMAIN ); ?>
    	<textarea wrap="off" onFocus="lastfm_fa_resize_textareas(this);" style="width: 60%;" id="lfmfa_<?php echo $number; ?>_pre_format_string" name="widget_lfm_fa[<?php echo $number; ?>][pre_format_string]" cols="20" rows="7" class="widefat lfmfa-format-string"><?php echo $pre_format_string;?></textarea>
    </label></p>
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_format_string"><? _e('The Format String for one item:', LFM_US_DOMAIN ); ?>
	    <textarea wrap="off" onFocus="lastfm_fa_resize_textareas(this);" style="width: 60%;" id="lfmfa_<?php echo $number; ?>_format_string" name="widget_lfm_fa[<?php echo $number; ?>][format_string]" cols="20" rows="7" class="widefat lfmfa-format-string"><?php echo $format_string; ?></textarea>
    </label></p>
	<p style="text-align:right;"><label for="lfm4a_<?php echo $number; ?>_post_format_string"><? _e('The Format String serving as footer of your list, available data is of the last shown item:', LFM_US_DOMAIN ); ?>
    	<textarea wrap="off" onFocus="lastfm_fa_resize_textareas(this);" style="width: 60%;" id="lfmfa_<?php echo $number; ?>_post_format_string" name="widget_lfm_fa[<?php echo $number; ?>][post_format_string]" cols="20" rows="7" class="widefat lfmfa-format-string"><?php echo $post_format_string; ?></textarea>
   	<input type="hidden" name="widget_lfm_fa[<?php echo $number; ?>][submit]" value="1" />

    </label></p>
	<div style="clear:both;"></div>