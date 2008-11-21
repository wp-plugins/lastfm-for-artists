var lastfm_fa_defaults = {
		events : { 	formatstrings : ['<div class="lfm_countdown">%COUNTDOWN%:</div><ul>', '<li>\n<a target="_blank" class="url summary lastfm-event-%NUMBER%" href="%URL%"><span style="display:none">\n<strong>%TITLE%</strong><br />%DESCRIPTION%</span>\n<strong>%DATE%</strong><br/>\n%LOCATION-SUMMARY%\n</a>\n</li>', '</ul><p class="lastfm-profile">(powered by <a href="%ARTIST-URL%" target="_blank">Last.fm</a> | <a href="http://www.jek-source.net" target="_blank">j:org</a>)</p>']
		         },
		toptracks:{ formatstrings: ['<ul>','<li>\n<a target="_blank" class="url summary lastfm-track-%RANK%"\nhref="%URL%%IF-FULL-STREAMABLE%?autostart%END-IF%"><span style="display:none">\n<strong>Played %PLAYCOUNT% times!</strong><br />\n<img src="%IMAGE-URL%"></span>\n<strong>%RANK%.</strong> %NAME%\n</a>\n</li>','</ul><p class="lastfm-profile">(powered by <a href="%ARTIST-URL%" target="_blank">Last.fm</a> | <a href="http://www.jek-source.net" target="_blank">j:org</a>)</p>']
		         }
};

function lastfm_fa_show_hide_tags(node) {
	var type;
	for(i=0;i<node.length;++i) {
		if (node.options[i].selected == true) {
			type = node.options[i].value;
			break;
		}
	}
	node = node.parentNode.parentNode.parentNode;
	switch (type) {
		case "1":
			jQuery('.lfmfa_event_tags', node).show("slide", "normal");
			jQuery('.lfmfa_toptrack_tags', node).hide("slide", "normal");
			jQuery('.lfmfa-format-string', node).each(function (i) {
				if (this.value == '' || this.value == lastfm_fa_defaults.toptracks.formatstrings[i]) {
					this.value = lastfm_fa_defaults.events.formatstrings[i];
				}
			}); 
			break;
		case "2":
			jQuery('.lfmfa_event_tags', node).hide("slide", "normal");
			jQuery('.lfmfa_toptrack_tags', node).show("slide", "normal");
			jQuery('.lfmfa-format-string', node).each(function (i) {
				if (this.value == '' || this.value == lastfm_fa_defaults.events.formatstrings[i]) {
					this.value = lastfm_fa_defaults.toptracks.formatstrings[i];
				}
			}); 
			break;
	}
}
function lastfm_fa_resize_textareas(node) {
	var parentdiv = node.parentNode.parentNode.parentNode;
	jQuery('.lfmfa-format-string', parentdiv).not(node).animate({height:"12px;"});
	jQuery(node).animate({height:"110px;"});
}
