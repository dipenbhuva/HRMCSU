<?php

require get_stylesheet_directory() . '/inc/customizer.php';

add_action( 'wp_enqueue_scripts', 'professional_education_consultancy_chld_thm_parent_css' );
function professional_education_consultancy_chld_thm_parent_css() {

    wp_enqueue_style( 
    	'professional_education_consultancy_chld_css', 
    	trailingslashit( get_template_directory_uri() ) . 'style.css', 
    	array( 
    		'bootstrap',
    		'font-awesome-5',
    		'bizberg-main',
    		'bizberg-component',
    		'bizberg-style2',
    		'bizberg-responsive' 
    	) 
    );
    
}

/**
* Changed the blog layout to 3 columns
*/
add_filter( 'bizberg_sidebar_settings', 'professional_education_consultancy_sidebar_settings' );
function professional_education_consultancy_sidebar_settings(){
	return '4';
}

/**
* Change the theme color
*/
add_filter( 'bizberg_theme_color', 'professional_education_consultancy_change_theme_color' );
function professional_education_consultancy_change_theme_color(){
    return '#ff5202';
}

/**
* Change the header menu color hover
*/
add_filter( 'bizberg_header_menu_color_hover', 'professional_education_consultancy_header_menu_color_hover' );
function professional_education_consultancy_header_menu_color_hover(){
    return '#ff5202';
}

/**
* Change the button color of header
*/
add_filter( 'bizberg_header_button_color', 'professional_education_consultancy_header_button_color' );
function professional_education_consultancy_header_button_color(){
    return '#ff5202';
}

/**
* Change the button hover color of header
*/
add_filter( 'bizberg_header_button_color_hover', 'professional_education_consultancy_header_button_color_hover' );
function professional_education_consultancy_header_button_color_hover(){
    return '#ff5202';
}