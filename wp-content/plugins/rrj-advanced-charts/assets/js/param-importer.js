;(function($){
	
	/**
	 * PHP's json_decode equivalent
	 */
	function jsonDecode( str ) {
		try {
			var data = JSON.parse( str );
			return data;
		} catch(Ex){
			return null;
		}
	}
	
	// stores instances of importer
	var instances = {};
	
	/**
	 * constructor 
	 */
	var importer = function( id ){
		if ( !$( '#' + id ).length ) return;
		
		this.$el = $( '#' + id );
		this.type = this.$el.find( '.type-holder' ).val();
		this.$fileBtn = this.$el.find( '.file-btn' );
		this.$importBtn = this.$el.find( '.import-btn' );
		this.$importGroup = this.$el.find( '.imported-data-group' );
		this.$fileNotice = this.$el.find( '.file-notice' );
		this.$fileId = this.$el.find( '.file-id' );
		this.$fileDesc = this.$el.find( '.file-desc' );
		this.$input = this.$el.find( '.data-holder' );
		this.$editor = this.$importGroup.find( '.editor' );
		this.$clear = this.$importGroup.find( '.clear-data' );
		
		// add this instance and delete all removed (from the DOM) objects
		instances[id] = this;
		for ( var i in instances ) {
			if ( !$( '#' + i ).length ) { delete( instances[i] ) }
		}
		
		this.init();
		
		return this;
	};
	
	importer.prototype = {
		
		constructor: importer,
		
		init: function(){
			var that = this;
			
			// open the media selection frame
			this.$fileBtn.on( 'click', function(ev){
				ev.preventDefault();
				$.rrjMediaFrame({
					id: that.$fileId,
					notice: that.$fileNotice,
					mime: [
						'text/csv',
						'text/plain',
						'application/vnd.ms-excel',
						'text/x-csv',
						'application/csv',
						'application/x-csv',
						'text/csv',
						'text/comma-separated-values',
						'text/x-comma-separated-values',
						'text/tab-separated-values',
					],
					size: false,
					name: that.$fileDesc,
				})
			});
			
			this.$fileId.on( 'change', function(){
				that.$el.find( '.file-name' ).text( that.$fileDesc.val() );
				that.$importBtn.prop( 'disabled', !( that.$fileId.val() ) );
			} );
			
			// launch parsing of CSV (ajax) on click
			this.$importBtn.on( 'click', function(ev){
				ev.preventDefault();
				var id = that.$fileId.val();
				if ( !id ) {
					return;
				}
				var orientation = that.$el.find( '.set-orientation' ).val();
				var header = that.$el.find( '.set-header' ).val();
				that.parseCsv( id, orientation, header );
			});
			
			this.$editor.find( '.sets-wrap' ).sortable({
				handle: '.vc-c-icon-dragndrop',
				items: '> .imported-data-field',
				stop: function( ev, ui ){
					that.afterSorting.call( that, ev, ui );
				},
				placeholder: 'sortable-import-placeholder',
				forcePlaceholderSize: true,
			});
			
			// initial value
			if ( this.$input.val() ) {
				var data = this.$input.val();
				data = jsonDecode( atob( data ) );
				if ( data ) {
					this.processResponseData( data, true );
				}
			}
			
			// clear up every imported data
			this.$clear.find( 'button' ).on( 'click', function(ev) {
				ev.preventDefault();
				that.$editor.find( '.sets-wrap' ).empty();
				that.$editor.find( '.labels-wrap' ).empty();
				that.$importGroup.css( 'display', 'none' );
				that.inputsToData();
			} );
			
		},
		
		// after sorting a dataset list
		afterSorting: function( ev, ui ) {
			this.inputsToData();
		},
		
		// parse CSV ( AJAX )
		parseCsv: function( id, orientation, header ){
			$( '#rrj-load-overlay' ).css( 'display', 'block' );
			var that = this;
			var type = this.type;
			var nonce = this.$el.find( '.rrj-importer-nonce' ).val();
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					nonce: nonce,
					type: type,
					id: id,
					orientation: orientation,
					header: header,
					action: 'rrj_csv_importer',
				},
				success: function( resp, status, xhr ){
					$( '#rrj-load-overlay' ).css( 'display', 'none' );
					if ( 'undefined' != typeof resp.status && resp.status && 'undefined' != typeof resp.data ) {
						that.processResponseData( resp.data, true );
					}
				},
				error: function( req, status, err ){
					$( '#rrj-load-overlay' ).css( 'display', 'none' );
					console.log( req )
				},
			});
		},
		
		// take all action following data change (AJAX, sorting, editing etc)
		processResponseData: function( data, create ) {
			if ( 'undefined' == typeof create ) {
				create = false;
			}
			this.$importGroup.css( 'display', 'block' );
			var value = {
				sets: data.sets,
				labels: data.labels,
			};
			this.$el.find( '.import-desc' ).text( data.desc );
			if ( data.sets.length ) {
				if ( this.getManualDatasetLength() != data.sets.length ) {
					this.$el.find( '.import-warning' ).css( 'display', 'block' );
				} else {
					this.$el.find( '.import-warning' ).css( 'display', 'none' );
				}
				if ( true === create ) {
					this.createDataEditor( data );
				}
				this.$clear.css( 'display', 'block' );
			} else {
				this.$el.find( '.import-warning' ).css( 'display', 'none' );
				this.$clear.css( 'display', 'none' );
			}
		},
		
		// update the input field according to the fields in the editor zone
		inputsToData: function(){
			if ( this.$editor.find( '.sets-wrap' ).find( '.imported-data-field' ).length ) {
				var sets = [];
				this.$editor.find( '.sets-wrap' ).find( '.imported-data-field' ).each(function(){
					sets.push( $( this ).find( 'input' ).val() );
				});
				var labels = this.$editor.find( '.labels-wrap' ).find( 'input' ).val();
				var data = {labels:labels,sets:sets};
				this.$input.val( btoa( JSON.stringify( data ) ) );
				this.processResponseData( data )
			} else {
				this.$input.val( '' );
			}
		},
		
		// create all editor inputs according to data value
		createDataEditor: function( data ){
			var markup = this.$el.find( '.text-input-template' ).html().trim();
			var $labels = $( markup.replace( '%type%', 'label' ) );
			$labels.find( 'input' ).val( data.labels );
			$labels.find( '.vc-composer-icon' ).remove();
			this.$editor.find( '.labels-wrap' ).empty().append( $labels );
			this.$editor.find( '.sets-wrap' ).empty()
			for ( var i in data.sets ) {
				var $set = $( markup.replace( '%type%', 'set' ) );
				$set.find( 'input' ).val( data.sets[i] );
				this.$editor.find( '.sets-wrap' ).append( $set );
			}
			this.$editor.find( '.sets-wrap' ).sortable( 'refresh' );
			this.inputsToData();
		},
		
		// get data set count from the General tab
		getManualDatasetLength: function () {
			var $li = this.$el.parents( '.vc_edit-form-tab' ).siblings( '#vc_edit-form-tab-0' ).find(
				'.vc_wrapper-param-type-param_group' ).find( 'ul.vc_param_group-list li' ).not( '.vc_empty-container' );
			return $li.length;
		},
		
	};
	
	// remove imported set
	$( document ).on( 'click', '.imported-data-field .vc-c-icon-delete_empty', function() {
		var id = $( this ).parents( '.rrj-csv-importer-wrap' ).attr( 'id' );
		$( this ).parents( '.imported-data-field' ).remove();
		instances[id].inputsToData();
		instances[id].$editor.find( '.sets-wrap' ).sortable( 'refresh' );
	} );
	
	// duplicate imported set
	$( document ).on( 'click', '.imported-data-field .vc-c-icon-content_copy', function() {
		var id = $( this ).parents( '.rrj-csv-importer-wrap' ).attr( 'id' );
		$( this ).parents( '.imported-data-field' ).after( $( this ).parents( '.imported-data-field' ).clone() );
		instances[id].inputsToData();
		instances[id].$editor.find( '.sets-wrap' ).sortable( 'refresh' );
	} );
	
	// update data on input change on the editor
	$( document ).on( 'change', '.imported-data-field input', function() {
		var id = $( this ).parents( '.rrj-csv-importer-wrap' ).attr( 'id' );
		instances[id].inputsToData();
	} )
	
	window.rrjDataImporter = importer;
	
})(window.jQuery);