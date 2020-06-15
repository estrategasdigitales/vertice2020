(function($){
	
	var slider = function( ID ){
		if ( 'undefined' == typeof ID ) return;
		this.$el = $( '#' + ID );
		if ( !this.$el.length ) return;
		this.$holder = this.$el.find( '.rrj-uislider-holder' );
		this.$input = this.$el.find( 'input[type="hidden"]' );
		this.$display = this.$el.find( '.rrj-uislider-display span' );
		this.init();
		this.$el.data( 'uislider', this );
		return this;
	}
	
	slider.prototype = {
		constructor: slider,
		
		init: function(){
			var that = this;
			this.$holder.slider({
				min: parseInt( this.$input.attr( 'data-min' ), 10 ),
				max: parseInt( this.$input.attr( 'data-max' ), 10 ),
				step: parseInt( this.$input.attr( 'data-step' ), 10 ),
				value: parseInt( this.$input.val(), 10 ),
				slide: function( ev, ui ){
					that.slide( ev, ui );
				},
			});
		},
		
		slide: function( ev, ui ){
			this.$input.val( ui.value );
			this.$display.text( ui.value );
		},
	}
	
	window.rrjUiSlider = slider;
	
})(window.jQuery)