( function( $ ) {

	"use strict";
	
	$( document ).ready( function() {
		pehaathemes_widget.thumbnail_display();				
		pehaathemes_widget.media_frame();
	});

	var pehaathemes_widget = {

		thumbnail_display : function() {
			
			var $input_id, $input_src, $remove_button;
			$( document ).on( 'click', '.js-pht-remove-thumbnail', function( e ) {
				e.preventDefault();
				$remove_button = $( this );
				$input_id = $remove_button.siblings( ".pht-new-media-image" );
				$input_src = $remove_button.siblings( ".pht-megamenu-img-placeholder" );
				$input_id.val( '' );
				$input_src.attr( 'src', '' ).css( 'display', 'none' );
				$remove_button.css( 'display', 'none' );
			});
		},

		media_frame : function() {
			
			var pehaathemes_media_frame, $input_id, $input_src, $upload_button, $remove_button;

			$( document ).on( 'click', '.js-pht-upload-thumbnail', function( e ){
				e.preventDefault();
				$upload_button = $( this );
				$input_id = $upload_button.siblings( ".pht-new-media-image" );
				$input_src = $upload_button.siblings( ".pht-megamenu-img-placeholder" );
				$remove_button = $upload_button.siblings( ".js-pht-remove-thumbnail" );
				
				if ( pehaathemes_media_frame ) {
					pehaathemes_media_frame.open();
					return;
				}

				pehaathemes_media_frame = wp.media.frames.pehaathemes_media_frame = wp.media({
					className: 'media-frame pht-media-frame',
					frame: 'select',
					multiple: false,
					library: {
						type: 'image'
					}
				});

				pehaathemes_media_frame.on( 'select', function(){
					var media_attachment = pehaathemes_media_frame.state().get('selection').first().toJSON();
					$input_id.val( media_attachment.id );
					
					$input_src.attr( 'src', media_attachment.url ).css( 'display', 'block' );
					$remove_button.css( "display", "block" );
				});

				pehaathemes_media_frame.open();
			});
		}		

	};

})( jQuery );