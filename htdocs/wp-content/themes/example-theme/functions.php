<?php
/**
 * Example theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */

/**
 * Enqueues editor-style.css in the editors.
 *
 * @return void
 */
function example_theme_editor_style() {
	add_editor_style( get_parent_theme_file_uri( 'build/css/editor.css' ) );
}
add_action( 'after_setup_theme', 'example_theme_editor_style' );

/**
 * Enqueues styles and scripts on the front-end.
 *
 * @return void
 */
function example_theme_enqueue_styles() {
	// Get dependencies and version from asset file.
	// @link: https://www.npmjs.com/package/@wordpress/dependency-extraction-webpack-plugin
	$styles_asset_path = get_parent_theme_file_path( 'build/css/theme.asset.php' );
	$styles_asset      = file_exists( $styles_asset_path ) ?
		require $styles_asset_path :
		[ 'dependencies' => [], 'version' => get_theme_file_path( 'build/css/theme.css' ) ];

	wp_enqueue_style(
		'example-theme-style',
		get_parent_theme_file_uri( 'build/css/theme.css' ),
		array_merge( $styles_asset['dependencies'], [] ),
		$styles_asset['version'],
	);

	// Get dependencies and version from asset file.
	// @link: https://www.npmjs.com/package/@wordpress/dependency-extraction-webpack-plugin
	$script_asset_path = get_parent_theme_file_path( 'build/js/theme.asset.php' );
	$script_asset      = file_exists( $script_asset_path ) ?
		require $script_asset_path :
		[ 'dependencies' => [], 'version' => get_theme_file_path( 'build/js/theme.js' ) ];

	wp_enqueue_script(
		'theme-scripts',
		get_parent_theme_file_uri( 'build/js/theme.js' ),
		array_merge( $script_asset['dependencies'], [] ),
		$script_asset['version'],
		true
	);
}
add_action( 'wp_enqueue_scripts', 'example_theme_enqueue_styles' );
