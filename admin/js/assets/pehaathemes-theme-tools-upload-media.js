( function( $ ) {

	"use strict";
	
	$( document ).ready( function() {
		pehaathemes_widget.thumbnail_display();				
		pehaathemes_widget.media_frame();
	});

	var pehaathemes_widget = {

		thumbnail_display : function() {
			
			$( document ).on( 'click', '.js-pht-remove-thumbnail', function( e ) {

				e.preventDefault();
				$( this ).siblings( ".pht-new-media-image" ).val( '' );
				$( this )
					.siblings( '.js-img-ctnr' ).find( ".pht-img-placeholder" )
					.attr( 'src', '' )
					.attr( 'srcset', '' )
					.parent( '.pht-img__ctnr--set' )
					.removeClass( 'pht-img__ctnr--set' )
					.addClass( 'pht-img__ctnr--empty' );
				
			});
		},

		media_frame : function() {
			
			var pehaathemes_media_frame;

			$( document ).on( 'click', '.js-pht-upload-thumbnail', function( e ){
				
				e.preventDefault();

				var $upload_button = $( this );
				
				if ( pehaathemes_media_frame ) {
					pehaathemes_media_frame.open();
					return;
				}

				pehaathemes_media_frame = wp.media.frames.pehaathemes_media_frame = wp.media( {
					className: 'media-frame pht-media-frame',
					frame: 'select',
					multiple: false,
					library: {
						type: 'image'
					}
				});

				pehaathemes_media_frame.on( 'select', function(){
					
					var media_attachment = pehaathemes_media_frame.state().get('selection').first().toJSON();
					
					$upload_button
						.siblings( ".pht-new-media-image" )
						.val( media_attachment.id );
					
					$upload_button
						.siblings( '.js-img-ctnr' )
						.find( ".pht-img-placeholder" )
						.attr( 'src', media_attachment.url )
						.attr( 'srcset', '' )
						.parent( '.pht-img__ctnr--empty' )
						.removeClass( 'pht-img__ctnr--empty' )
						.addClass( 'pht-img__ctnr--set' );
					
				});

				pehaathemes_media_frame.open();
			});
		}		

	};

})( jQuery );