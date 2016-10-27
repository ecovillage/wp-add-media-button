function evalselection(selected,align) {
	var size = "medium";
	var alt = selected.alt;
     	if (0 === alt.length){
	    alt = selected.name;
	    alt = alt.toUpperCase();
	}

	return('<a href="' + selected.url + '"><img src="' +
	selected.sizes[size].url + '" alt="' + alt + '" width="' +
	selected.sizes[size].width + '" height="' +
	selected.sizes[size].height + '" class="' + align + ' size-' +
	size + ' wp-image-' + selected.id + '" /></a>');
	// console.log(JSON.stringify(selected));
}

jQuery(function($) {
    $(document).ready(function(){
           $('#insert-my-media-left').click(open_media_window_left);
           $('#insert-my-media-right').click(open_media_window_right);
        });

    function open_media_window_left() {
        if (this.window === undefined) {
	   var imagealign = "alignleft"; 	// "alignleft|aligncenter|alignright"
           this.window = wp.media({
                title: 'Bild linksbündig in den Text einfügen',
                library:   wp.media.query({ type: 'image' }),
                multiple: false,
                button: {text: 'Bild links einfügen'}
            });

        var self = this; // Needed to retrieve our variable in the anonymous function below
        this.window.on('select', function() {
                wp.media.editor.insert(evalselection(self.window.state().get('selection').first().toJSON(),imagealign));
            });
        }

        this.window.open();
        return false;
    }

    function open_media_window_right() {
        if (this.window === undefined) {
	   var imagealign = "alignright"; 	// "alignleft|aligncenter|alignright"
           this.window = wp.media({
                title: 'Bild rechtsbündig in den Text einfügen',
                library:   wp.media.query({ type: 'image' }),
                multiple: false,
                button: {text: 'Bild rechts einfügen'}
            });

        var self = this; // Needed to retrieve our variable in the anonymous function below
        this.window.on('select', function() {
                wp.media.editor.insert(evalselection(self.window.state().get('selection').first().toJSON(),imagealign));
            });
        }

        this.window.open();
        return false;
    }
});
