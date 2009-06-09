function lastfm_fa_show_hide_tags(node) {
	type = jQuery('option:selected', node).val();
	node = node.parentNode.parentNode.parentNode;
	switch (type) {
		case "1":
			jQuery('.lfmfa_event_tags', node).show();
			jQuery('.lfmfa_toptrack_tags', node).hide();
			jQuery('.example-selector', node).html(lastfmFaExOptionsStrings["1"]);
			break;
		case "2":
			jQuery('.lfmfa_event_tags', node).hide();
			jQuery('.lfmfa_toptrack_tags', node).show();
			jQuery('.example-selector', node).html(lastfmFaExOptionsStrings["2"]);
			break;
	}
	jQuery('.lfmfa-format-string', node).each(function (i) {
		// null the format strings on type-change
		 this.value = '';
	});
}
function lastfm_fa_resize_textareas(node) {
	var parentdiv = node.parentNode.parentNode.parentNode;
	jQuery('.lfmfa-format-string.open', parentdiv).not(node).animate({height:"40px;"}).removeClass('open');
	jQuery(node).not('.open').animate({height:"150px;"}).addClass('open');
}
function lastfm_fa_chooseExample(node) {
	container = node.parentNode.parentNode.parentNode;
	type = jQuery('.type-selector option:selected', container).val();
	example = jQuery('option:selected', node).val();
	jQuery('.lfmfa-format-string', container).each(function (i) {
			newValue = (example ? lastfmFaDefaults[type][example][i.toString()] : '');
			// TODO introduce multiple variables
			match = newValue.match(/%VARIABLE:([^%:]+):[^%]*%/);
			if (match) {
				userValue = prompt("Enter a value for " + RegExp.$1 + '!', '');
				if (userValue != null) {
					newValue = newValue.replace(/%VARIABLE:([^%:]+):[^%]*%/, '%VARIABLE:' + RegExp.$1 + ':' + userValue + '%');
				}
			}
			this.value = newValue;
	});
}