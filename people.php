<?php
/*
Plugin Name: People
Description: Gets and displays CREOL .
Version: 0.0.1
Author: UCF Web Communications
License: GPL3
GitHub Plugin URI: https://github.com/UCF/CREOL-People
*/

if ( ! defined( 'WPINC' ) ) {
    die;
}

require_once 'includes/people-layout.php';

add_shortcode( 'people', 'people_display');