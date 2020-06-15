;(function($){
	
	var PHP_EDITOR = null;
	
	$( document ).on( 'click', 'button', function(ev){ev.preventDefault();} );

	$( document ).on( 'click', '#save-settings', function(){
		$( '#loading-overlay' ).css( 'display', 'block' );
		var args = $( '#chart-settings' ).serialize();
		var nonce = $( '#settings-nonce' ).val();
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'rrj_save_settings',
				nonce: nonce,
				args: args,
			},
			success: function( resp, status, xhr ){
				if ( 'undefined' != typeof resp.status && true === resp.status ) {
					document.location.reload();
				} else {
					$( '#loading-overlay' ).css( 'display', 'none' );
				}
			},
			error: function( req, status, err ){
				$( '#loading-overlay' ).css( 'display', 'none' );
			},
		});
	} );

	$( document ).on( 'click', '#reset-settings', function(){
		$( '#loading-overlay' ).css( 'display', 'block' );
		var nonce = $( '#settings-nonce' ).val();
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'rrj_reset_settings',
				nonce: nonce,
			},
			success: function( resp, status, xhr ){
				if ( 'undefined' != typeof resp.status && true === resp.status ) {
					document.location.reload();
				} else {
					$( '#loading-overlay' ).css( 'display', 'none' );
				}
			},
			error: function( req, status, err ){
				$( '#loading-overlay' ).css( 'display', 'none' );
			},
		});

	} );

	$( document ).on( 'click', '.nav-tab', function(){
		if ( $( this ).hasClass( 'nav-tab-active' ) ) return;
		var target = $( this ).attr( 'href' );
		$( '.nav-tab' ).removeClass( 'nav-tab-active' );
		$( '.nav-tab-div' ).css( 'display', 'none' );
		$( this ).addClass( 'nav-tab-active' );
		$( target ).css( 'display', 'block' );
	} );

	$( document ).on( 'click', '#new-function', function(){
		var fn = $( '#new-function-name' ).val().trim();
		if ( !fn ) {
			$( '#new-function-name' ).css( 'border-color', '#ff5722' );
		} else {
			$( '#new-function-name' ).val( '' );
			$( '#new-function-name' ).css( 'border-color', '#ddd' );
			$( '#loading-overlay' ).css( 'display', 'block' );
			var nonce = $( '#settings-nonce' ).val();
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'rrj_new_fn',
					nonce: nonce,
					fn: fn,
				},
				success: function( resp, status, xhr ){
					$( '#loading-overlay' ).css( 'display', 'none' );
					if ( 'undefined' != typeof resp.status && true === resp.status && resp.functions ) {
						rrjPhpFunctions = resp.functions;
						$( '#function-selector, #testee-selector' ).append( '<option value="' + fn + '">' + fn + '</option>' ).val( fn );
						$( '#function-selector' ).trigger( 'change' );
					}
				},
				error: function( req, status, err ){
					$( '#loading-overlay' ).css( 'display', 'none' );
				},
			});
		}
	} );

	$( document ).on( 'change', '#function-selector', function(){
		var fn = $( this ).val();
		if ( fn ) {
			$( '#function-editor' ).css( 'display', 'block' );
			$( '#function-editor [name="function-name"]' ).val( 'fn' );
			$( '#function-editor [name="function-storage"]' ).val( rrjPhpFunctions[fn]['storage'] );
			if ( null === PHP_EDITOR ) {
				var input = $( '#function-editor [name="function-code"]' );
				PHP_EDITOR = CodeMirror(function(el){
					input.hide().after( $(el) );
				},{
					mode: 'php',
					startOpen: true,
					lineNumbers: true,
				});
			}
			var doc = PHP_EDITOR.getDoc();
			doc.setValue( rrjPhpFunctions[fn]['code'] );
			PHP_EDITOR.refresh();
			$( '#response-div > div' ).empty();
			$( '#response-div' ).css( 'display', 'none' );
		}
	} );

	$( document ).on( 'click', '#save-function', function(){
		$( '#loading-overlay' ).css( 'display', 'block' );
		var doc = PHP_EDITOR.getDoc();
		var fn = $( '#function-selector' ).val();
		var storage = $( '#storage' ).val();
		var nonce = $( '#settings-nonce' ).val();
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'rrj_save_function',
				nonce: nonce,
				fn: fn,
				storage: storage,
				code: doc.getValue(),
			},
			success: function( resp, status, xhr ){
				$( '#loading-overlay' ).css( 'display', 'none' );
			},
			error: function( req, status, err ){
				$( '#loading-overlay' ).css( 'display', 'none' );
			},
		});
	} );
	
	$( document ).on( 'click', '#delete-function', function(){
		$( '#loading-overlay' ).css( 'display', 'block' );
		var fn = $( '#function-selector' ).val();
		var nonce = $( '#settings-nonce' ).val();
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'rrj_delete_function',
				nonce: nonce,
				fn: fn,
			},
			success: function( resp, status, xhr ){
				document.location.reload();
			},
			error: function( req, status, err ){
				$( '#loading-overlay' ).css( 'display', 'none' );
			},
		});
	} );
	
	$( document ).on( 'click', '#execute-test', function( ev ) {
		ev.preventDefault();
		$( '#loading-overlay' ).css( 'display', 'block' );
		var conds = {};
		$( '.condlabel .conditional' ).each(function(){
			conds[$(this).attr( 'data-fn' )] = $( this ).prop( 'checked' );
		});
		
		var doc = PHP_EDITOR.getDoc();
		var code = doc.getValue();
		$.ajax({
			type: 'post',
			url: ajaxurl,
			data: {
				nonce: $( '#settings-nonce' ).val(),
				action: 'rrj_test_fn',
				code: code,
				conditionals: JSON.stringify( conds, '', false ),
			},
			success: function( resp, status, xhr ){
				$( '#loading-overlay' ).css( 'display', 'none' );
				$( '#response-div' ).css( 'display', 'block' );
				try {
					var respObj = JSON.parse( resp );
				} catch ( E ) {};
				if ( 'undefined' != typeof respObj ) {
					var respTxt = JSON.stringify( respObj, '', 2 );
					$( '#response-div > div' ).html( '<pre>' + respTxt + '</pre>' );
				} else {
					$( '#response-div > div' ).html( '<p>' + rrjAcI18n.unknownResponse.replace( '%s', resp ) + '</p>' );
				}
			},
			error: function( req, status, err ){
				$( '#loading-overlay' ).css( 'display', 'none' );
				$( '#response-div' ).css( 'display', 'block' );
				$( '#response-div > div' ).html( '<code>' + req.status + ': ' + err + '</code>' );
			},
		});
		
	} );
	
	$( document ).on( 'click', '#show-conditionals', function(){
		$( '#conditionals' ).css( 'display', 'block' );
		$( this ).css( 'display', 'none' );
	} );
	
	$(function(){
		$( '.color-input' ).wpColorPicker();
		if ( document.location.hash ) {
			$( '.nav-tab[href="' + document.location.hash + '"]' ).trigger( 'click' );
		} else {
			$( '.nav-tab' ).first().trigger( 'click' );
		}
	})

})(window.jQuery);