<?php

if (!function_exists('FoundationPress_scripts')) :
  function FoundationPress_scripts() {

    // deregister the jquery version bundled with wordpress
    wp_deregister_script( 'jquery' );

    // register scripts
    wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr/modernizr.min.js', array(), '1.0.0', false );
    wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery/dist/jquery.min.js', array(), '1.0.0', false );
    wp_register_script( 'foundation', get_template_directory_uri() . '/js/app.js', array('jquery'), '1.0.0', true );

	
    // enqueue scripts
    wp_enqueue_script('modernizr');
    wp_enqueue_script('jquery');
    wp_enqueue_script('foundation');

  }

  add_action( 'wp_enqueue_scripts', 'FoundationPress_scripts' );

endif;

function kitchensink_scripts() {
  if ( is_page_template('kitchen-sink.php') ) {

    wp_enqueue_script( 'kitchen-sink', get_template_directory_uri() . '/js/kitchen-sink.js', array('jquery'), '1.0.0', true );

  }
}

add_action( 'wp_enqueue_scripts', 'kitchensink_scripts' );

	function renew_scripts()	{
		wp_register_script( 'image_scroll', get_template_directory_uri() . '/js/jquery.imageScroll.js', array('jquery'), '1.0.0', true );
		wp_register_script( 'renew_custom', get_template_directory_uri() . '/js/renew_custom.js', array('jquery'), '1.0.0', true );
		wp_register_script( 'skroller', get_template_directory_uri() . '/js/skroller.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script('image_scroll');
		wp_enqueue_script('skroller');
		wp_enqueue_script('renew_custom');
	}
	add_action( 'wp_enqueue_scripts', 'renew_scripts' ); 

function renew_adding_fonts() {
    wp_register_style( 'fonts_style', get_template_directory_uri(). '/css/fonts/stylesheet.css', 'all' );
    wp_enqueue_style( 'fonts_style' );

}

add_action( 'wp_enqueue_scripts', 'renew_adding_fonts' );


?>