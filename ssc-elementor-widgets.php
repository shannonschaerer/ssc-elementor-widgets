<?php
/**
 * Plugin Name: SSC Elementor Widgets
 * Description: Library of custom made components
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Shannon Schärer
 * Author URI:  https://shannonschaerer.com/
 * Text Domain: ssc-elementor-edigets
 *
 * Elementor tested up to: 3.7.0
 * Elementor Pro tested up to: 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function registerSscDescriptionListWidget( $widgets_manager ) {
    require_once(__DIR__ . '/widgets/ssc-description-list-widget.php');
    $widgets_manager->register( new \ElementorSscDescriptionListWidget() );
}

add_action( 'elementor/widgets/register', 'registerSscDescriptionListWidget');

function registerSscPageHeadingWidget( $widgets_manager ) {
    require_once(__DIR__ . '/widgets/ssc-page-heading-widget.php');
    $widgets_manager->register( new \ElementorSscPageHeadingWidget() );
}

add_action( 'elementor/widgets/register', 'registerSscPageHeadingWidget');


function registerSscTimelineWidget( $widgets_manager ) {
    require_once(__DIR__ . '/widgets/ssc-timeline-widget.php');
    $widgets_manager->register( new \ElementorSscTimelineWidget() );
}

add_action( 'elementor/widgets/register', 'registerSscTimelineWidget');

function register_widget_styles() {
    wp_register_style( 'widget-styles', plugins_url( 'assets/css/styles.css', __FILE__ ) );
    wp_register_style( 'tailwind', plugins_url( 'assets/css/output.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'register_widget_styles' );

function registerSscLatestIssueGridWidget( $widgets_manager ) {
    require_once(__DIR__ . '/widgets/ssc-latest-issue-grid-widget.php');
    $widgets_manager->register( new \ElementorSscLatestIssueGridWidget() );
}

add_action( 'elementor/widgets/register', 'registerSscLatestIssueGridWidget');
