<?php
/**
 * The footer template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
					<?php do_action( 'avada_after_main_content' ); ?>

				</div>  <!-- fusion-row -->
			</main>  <!-- #main -->
			<?php do_action( 'avada_after_main_container' ); ?>

			<?php global $social_icons; ?>

			<?php if ( false !== strpos( Avada()->settings->get( 'footer_special_effects' ), 'footer_sticky' ) ) : ?>
				</div>
			<?php endif; ?>

			<?php
			/**
			 * Get the correct page ID.
			 */
			$c_page_id = Avada()->fusion_library->get_page_id();
			?>

			<?php
			/**
			 * Only include the footer.
			 */
			?>
			<?php if ( ! is_page_template( 'blank.php' ) ) : ?>
				<?php $footer_parallax_class = ( 'footer_parallax_effect' == Avada()->settings->get( 'footer_special_effects' ) ) ? ' fusion-footer-parallax' : ''; ?>

				<div class="fusion-footer<?php echo esc_attr( $footer_parallax_class ); ?>">

					<?php
					/**
					 * Check if the footer widget area should be displayed.
					 */
					$display_footer = get_post_meta( $c_page_id, 'pyre_display_footer', true );
					?>
					<?php if ( ( Avada()->settings->get( 'footer_widgets' ) && 'no' !== $display_footer ) || ( ! Avada()->settings->get( 'footer_widgets' ) && 'yes' === $display_footer ) ) : ?>
						<?php $footer_widget_area_center_class = ( Avada()->settings->get( 'footer_widgets_center_content' ) ) ? ' fusion-footer-widget-area-center' : ''; ?>

						<footer role="contentinfo" class="fusion-footer-widget-area fusion-widget-area<?php echo esc_attr( $footer_widget_area_center_class ); ?>">
							<div class="fusion-row">
								<div class="fusion-columns fusion-columns-<?php echo esc_attr( Avada()->settings->get( 'footer_widgets_columns' ) ); ?> fusion-widget-area">
									<?php
									/**
									 * Check the column width based on the amount of columns chosen in Theme Options.
									 */
									$footer_widget_columns = Avada()->settings->get( 'footer_widgets_columns' );
									$footer_widget_columns = ( ! $footer_widget_columns ) ? 1 : $footer_widget_columns;
									$column_width = ( '5' == Avada()->settings->get( 'footer_widgets_columns' ) ) ? 2 : 12 / $footer_widget_columns;
									?>

									<?php
									/**
									 * Render as many widget columns as have been chosen in Theme Options.
									 */
									?>
									<?php for ( $i = 1; $i < 7; $i++ ) : ?>
										<?php if ( $i <= Avada()->settings->get( 'footer_widgets_columns' ) ) : ?>
											<div class="fusion-column<?php echo ( Avada()->settings->get( 'footer_widgets_columns' ) == $i ) ? ' fusion-column-last' : ''; ?> col-lg-<?php echo esc_attr( $column_width ); ?> col-md-<?php echo esc_attr( $column_width ); ?> col-sm-<?php echo esc_attr( $column_width ); ?>">
												<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 'avada-footer-widget-' . $i ) ) : ?>
													<?php
													/**
													 * All is good, dynamic_sidebar() already called the rendering.
													 */
													?>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									<?php endfor; ?>

									<div class="fusion-clearfix"></div>
								</div> <!-- fusion-columns -->
							</div> <!-- fusion-row -->
						</footer> <!-- fusion-footer-widget-area -->
					<?php endif; // End footer wigets check. ?>

					<?php
					/**
					 * Check if the footer copyright area should be displayed.
					 */
					$display_copyright = get_post_meta( $c_page_id, 'pyre_display_copyright', true );
					?>
					<?php if ( ( Avada()->settings->get( 'footer_copyright' ) && 'no' !== $display_copyright ) || ( ! Avada()->settings->get( 'footer_copyright' ) && 'yes' === $display_copyright ) ) : ?>
						<?php $footer_copyright_center_class = ( Avada()->settings->get( 'footer_copyright_center_content' ) ) ? ' fusion-footer-copyright-center' : ''; ?>

						<footer id="footer" class="fusion-footer-copyright-area<?php echo esc_attr( $footer_copyright_center_class ); ?>">
							<div class="fusion-row">
								<div class="fusion-copyright-content">

									<?php
									/**
									 * Footer Content (Copyright area) avada_footer_copyright_content hook.
									 *
									 * @hooked avada_render_footer_social_icons - 15 (outputs the HTML for the footer social icons)..
									 * @hooked avada_render_footer_copyright_notice - 10 (outputs the HTML for the Theme Options footer copyright text)
									 
									 */
									do_action( 'avada_footer_copyright_content' );
									?>

								</div> <!-- fusion-fusion-copyright-content -->
							</div> <!-- fusion-row -->
						</footer> <!-- #footer -->
					<?php endif; // End footer copyright area check. ?>
					<?php
					// Displays WPML language switcher inside footer if parallax effect is used.
					if ( defined( 'ICL_SITEPRESS_VERSION' ) && 'footer_parallax_effect' === Avada()->settings->get( 'footer_special_effects' ) ) {
						global $wpml_language_switcher;
						$slot = $wpml_language_switcher->get_slot( 'statics', 'footer' );
						if ( $slot->is_enabled() ) {
							echo $wpml_language_switcher->render( $slot ); // WPCS: XSS ok.
						}
					}
					?>
				</div> <!-- fusion-footer -->
			<?php endif; // End is not blank page check. ?>
		</div> <!-- wrapper -->

		<?php
		/**
		 * Check if boxed side header layout is used; if so close the #boxed-wrapper container.
		 */
		$page_bg_layout = ( $c_page_id ) ? get_post_meta( $c_page_id, 'pyre_page_bg_layout', true ) : 'default';
		?>
		<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && 'default' === $page_bg_layout ) || 'boxed' === $page_bg_layout ) && 'Top' !== Avada()->settings->get( 'header_position' ) ) : ?>
			</div> <!-- #boxed-wrapper -->
		<?php endif; ?>
		<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && 'default' === $page_bg_layout ) || 'boxed' === $page_bg_layout ) && 'framed' === Avada()->settings->get( 'scroll_offset' ) && 0 !== intval( Avada()->settings->get( 'margin_offset', 'top' ) ) ) : ?>
			<div class="fusion-top-frame"></div>
			<div class="fusion-bottom-frame"></div>
			<?php if ( 'None' !== Avada()->settings->get( 'boxed_modal_shadow' ) ) : ?>
				<div class="fusion-boxed-shadow"></div>
			<?php endif; ?>
		<?php endif; ?>
		<a class="fusion-one-page-text-link fusion-page-load-link"></a>

		<?php wp_footer(); ?>

		<?php
		/**
		 * Echo the scripts added to the "before </body>" field in Theme Options.
		 * The 'space_body' setting is not sanitized.
		 * In order to be able to take advantage of this,
		 * a user would have to gain access to the database
		 * in which case this is the least on your worries.
		 */
		echo Avada()->settings->get( 'space_body' ); // WPCS: XSS ok.
		?>
		
		<!--OWL-->
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/owl.carousel.min.css">
		<script type="text/javascript">
			var $ = jQuery.noConflict();
		</script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/owl.carousel.js"></script>
			<script type="text/javascript">
				$(document).ready(function() {
				  var owl = $('.owl-carousel');
				  owl.owlCarousel({
					margin: 20,
					nav: true,
					loop: false,
					responsive: { 
					  0: {
						items: 1
					  },
					  600: {
						items: 2
					  },
					  1000: {
						items: 2
					  }
					}
				  })
				});
			
		
  </script>


<script type="text/javascript">
	$(document).ready(function () {
  
     $("#owl-demo2").owlCarousel({
        pagination : false,
        loop: false,
     });
   	function initialize() {
   		var mapId = $(".tab-maps").attr('id');
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
       center: new google.maps.LatLng(0, 0),
    	zoom: Math.ceil(Math.log2($(window).width())) - 8,
    };
    var map = new google.maps.Map(document.getElementById(mapId),
            myOptions);
}
//google.maps.event.addDomListener(window, "load", initialize);

});

  </script>




       

 <!-- custom scrollbar-->

	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery.mCustomScrollbar.css">
	<script>window.jQuery || document.write('<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery-1.11.0.min.js"><\/script>')</script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
	 
	 <script type="text/javascript">
		(function($){
			$(window).on("load",function(){
					$("#team-content").mCustomScrollbar({
					axis:"x",
					theme:"light-3",
					advanced:{autoExpandHorizontalScroll:true}
				});
			});
			
			
			})(jQuery);		
	</script>
	<!-- select 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>	
<script type="text/javascript" src="< ?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap-select.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="< ?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap-select.css"> 
   
	<script type="text/javascript">
		jQuery(document).ready(function(){
			 jQuery('.selectpicker').selectpicker({
              style: 'btn-info',
              size: 10
             });
             
        jQuery('.form_date').datetimepicker({
         language:  'Eng',
         weekStart: 1,
         todayBtn:  1,
         autoclose: 1,
         todayHighlight: 1,
         startView: 2,
         minView: 2,
         forceParse: 0
         });
				
		
		});
	</script>
	
	classie -->
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/classie.js"></script>
	
	<script type="text/javascript">
			(function() {
				if (!String.prototype.trim) {
					(function() {
						 
						var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
						String.prototype.trim = function() {
							return this.replace(rtrim, '');
						};
					})();
				}

				[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
					// in case the input is already filled..
					if( inputEl.value.trim() !== '' ) {
						classie.add( inputEl.parentNode, 'input--filled' );
					}

					// events:
					inputEl.addEventListener( 'focus', onInputFocus );
					inputEl.addEventListener( 'blur', onInputBlur );
				} );

				function onInputFocus( ev ) {
					classie.add( ev.target.parentNode, 'input--filled' );
				}

				function onInputBlur( ev ) {
					if( ev.target.value.trim() === '' ) {
						classie.remove( ev.target.parentNode, 'input--filled' );
					}
				}
				
			
				
			})();
		</script>
	
	
	<!--classie Ends-->
	
	<!--datetimepicker-->
	<!-- datetimepicker stylesheet -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap-datetimepicker.min.css">
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap-datetimepicker.fr.js"></script>

<script type="text/javascript">
	/* Added google map refresh functions */
	$(document).ready(function(){
		
		function sonu(){
			console.log('running...');
		}
		
		function fusionTabOceanService(){
			var g_Id = $("#OceanServiceMapId").find(".shortcode-map").attr("id");
			//$("#OceanServiceMapId").find(".shortcode-map").html('');
			var g_pre = "fusion_run_map_";
			//google.maps.event.trigger(document.getElementById(g_Id), 'resize');
			window[g_pre+g_Id]();
			
		}
		google.maps.event.addDomListener(document.getElementById("fusion-tab-oceanservice"), "click", fusionTabOceanService);
		//console.log(window);
		
	});
	

</script>


 
	
	</body>
</html>
