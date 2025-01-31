<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

/**
 * Enqueues editor-style.css in the editors.
 *
 * @since Twenty Twenty-Five 1.0
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
 * @since Twenty Twenty-Five 1.0
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

// Registers custom block styles.
if ( ! function_exists( 'example_theme_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function example_theme_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'example_theme_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'example_theme_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function example_theme_pattern_categories() {

		register_block_pattern_category(
			'example_theme_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'example_theme_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'example_theme_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'example_theme_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function example_theme_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'example_theme_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'example_theme_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'example_theme_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function example_theme_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;
