<?php

/*
Plugin Name: Disable Comments Back40
Description: Disables comments on your WordPress site to prevent spam.
Author: Tyler Gilbert and Brady Christopher
Author URI: https://back40design.com/
Version: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: disable-comments-b40

Disable Comments Back40 is free software you can redistribute
it and/or modify it under the terms of the GNU General Public License
as published by the Free Software Foundation, either version 2 of the
License, or any later version.
Disable Comments Back40 is distributed in the hope that it
will be useful, but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See
the GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Disable Comments Back40. If not, see
https://www.gnu.org/licenses/gpl-2.0.html.
*/

add_action( 'admin_init', function () {
    global $pagenow;

    if ( 'edit-comments.php' === $pagenow ) {
        wp_redirect( admin_url() );
        exit;
    }

    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

    foreach ( get_post_types() as $post_type ) {
        if ( post_type_supports( $post_type, 'comments' ) ) {
            remove_post_type_support( $post_type, 'comments' );
            remove_post_type_support( $post_type, 'trackbacks' );
        }
    }
} );

add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

add_filter( 'comments_array', '__return_empty_array', 10, 2 );

add_action( 'admin_menu', function () {
    remove_menu_page( 'edit-comments.php' );
} );

add_action( 'wp_before_admin_bar_render', function() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
} );