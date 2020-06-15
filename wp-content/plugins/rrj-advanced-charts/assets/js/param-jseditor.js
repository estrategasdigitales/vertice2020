(function($){
	
	var jsEditor = function( ID ) {
		this.$input = $( '#' + ID );
		this.value = this.$input.val();
		var decoded = false;
		
		if ( 'function' !== typeof atob ) {
			// no native support for base64 ( IE < 10 ) - Abort
			this.$input.hide();
			this.$input.after( $( '<span style="color:red;">No base64 support</span>' ) );
			return;
		}
		
		try {
			decoded = atob( this.value );
		} catch ( Ex ){};
		
		if ( false === decoded ) {
			this.value = '';
		} else {
			this.value = decoded;
		}
		this.refreshed = false;
		this.editor = null;
		this.$container = this.$input.parents( '.vc_edit-form-tab' );
		
		var that = this;
		
		this.$input.parents( '.vc_ui-panel-window-inner' ).find( '.vc_ui-tabs-line-trigger' ).click( function(){
			that.tabClick( this );
		} );
	}
	
	jsEditor.prototype = {
		
		constructor: jsEditor,
		
		tabClick: function( el ){
			if ( $( el ).attr( 'data-vc-ui-element-target' ) == '#' + this.$container.attr( 'id' ) ) {
				if ( true !== this.refreshed ) {
					var that = this;
					this.refreshed = true;
					setTimeout( function(){ that.init() }, 300 );
				}
				if ( this.editor ) {
					var that = this;
					setTimeout(function(){
						var doc = that.editor.getDoc();
						doc.setValue( atob( that.$input.val() ) );
						that.editor.refresh();
					}, 300);
				}
			}
		},
		
		init: function(){
			
			var that = this;
			this.editor = CodeMirror(function( el ){
				that.$input.hide();
				that.$input.after( $( el ) );
			}, {
				mode: 'javascript',
				identUnit: 2,
			});
			
			this.editor.on( 'changes', function( e, c ){ that.change( e, c ) } );
			var doc = this.editor.getDoc();
			doc.setValue( atob( this.$input.val() ) );
			this.editor.refresh();
			
		},
		
		change: function( editor, changes ) {
			var value = editor.getValue();
			this.$input.val( btoa( value ) );
		},
		
	}
	
	window.rrjJsEditor = jsEditor;
	
})(window.jQuery)