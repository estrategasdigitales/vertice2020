;(function($){
    "use strict";
    var rrjMediaFrame = function( options ) {
        
        this.defaultOptions = {
            url: null,
            alt: null,
            mime: ['image/jpeg', 'image/png', 'image/gif'],
            notice: null,
			size: 'thumbnail',
			id: null,
            multiple: false,
			onSelect: false,
			name: null,
        };
        this.options = $.extend( {}, this.defaultOptions, options );
        
        // create an instance of wp.media for our usage
        this.wpMediaFrame = wp.media.frames.frame = wp.media( {
            title: this.options.multiple? rrjMediaFrameLocale.selectMedias : rrjMediaFrameLocale.selectMedia,
            button: {
                text: rrjMediaFrameLocale.button,
            },
            multiple: this.options.multiple,
        } );
        
        var that = this;
		
        // on media selected (actually when the bottom right button is pressed)
        this.wpMediaFrame.on( 'select' , function(){
			if ( that.options.multiple || 'function' == typeof that.options.onSelect ) {
				if ( 'function' == typeof that.options.onSelect ) {
					that.options.onSelect( that.wpMediaFrame.state().get( 'selection' ).toJSON() );
				}
			} else {
				var attachment = that.wpMediaFrame.state().get( 'selection' ).first().toJSON();
				var isValidMedia = ( -1 != that.options.mime.indexOf( attachment.mime ) );
				if ( isValidMedia ) {
					if ( that.options.url ) {
						if ( that.options.size && 'undefined' != typeof attachment['sizes'][that.options.size] ) {
							that.options.url.val( attachment['sizes'][that.options.size]['url'] );
						} else {
							that.options.url.val( attachment.url );
						}
						that.options.url.trigger( 'change' );
					}
					if ( that.options.alt ) {
						that.options.alt.val( attachment.alt );
						that.options.alt.trigger( 'change' );
					}
					
					if ( that.options.name ) {
						that.options.name.val( attachment.name );
						that.options.name.trigger( 'change' );
					}
					if ( that.options.notice ) {
						that.options.notice.empty();
					}
					if ( that.options.id ) {
						that.options.id.val( attachment.id );
						that.options.id.trigger( 'change' );
					}
				} else {
					// mime type not allowed
					if ( that.options.notice ) {
						that.options.notice.text( rrjMediaFrameLocale.invalidFileType );
					}
				}
			}
        });
        
        this.wpMediaFrame.open();
        
        return this;
    };
    
    // extend jQuery with this object
    $.rrjMediaFrame = function( options ){
        var data = $( '#wpwrap' ).data( 'rrjMediaFrame' );
        if ( undefined === data ) {
            $( '#wpwrap' ).data( 'rrjMediaFrame', new rrjMediaFrame( options ) );
        } else {
            data.options = $.extend( {}, data.defaultOptions, options );
            data.wpMediaFrame.open();
        }
    };
    
})(window.jQuery);
