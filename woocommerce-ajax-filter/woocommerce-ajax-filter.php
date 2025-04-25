<?php
/*
Plugin Name: WooCommerce AJAX Filter
Description: Plugin for filtering and sorting WooCommerce products using AJAX
Version: 1.0
Author: alex & Copilot
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access protection
}

// Connect styles and scripts
function waf_enqueue_scripts() {
    wp_enqueue_style( 'waf-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
    wp_enqueue_script( 'waf-script', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array( 'jquery' ), false, true );

    wp_localize_script( 'waf-script', 'waf_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'waf_enqueue_scripts' );

// include form
function waf_display_filter_form() {
    include plugin_dir_path( __FILE__ ) . 'includes/filter-form.php';
}
add_action( 'woocommerce_before_shop_loop', 'waf_display_filter_form' );

/**
 * Handling AJAX requests
 */
function waf_filter_products() {
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $sort = isset($_POST['sort']) ? $_POST['sort'] : '';

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
    );

    if ( !empty($category) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category,
            ),
        );
    }

    if ( $sort == 'popular' ) {
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'total_sales';
    } elseif ( $sort == 'new' ) {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }

    $query = new WP_Query( $args );



    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            wc_get_template_part( 'content', 'product' );
        }
    } else {
        echo '<p>No products found.</p>';
    }
 
    wp_die();
}
add_action( 'wp_ajax_waf_filter_products', 'waf_filter_products' );
add_action( 'wp_ajax_nopriv_waf_filter_products', 'waf_filter_products' );

