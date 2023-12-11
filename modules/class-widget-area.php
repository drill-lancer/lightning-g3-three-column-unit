<?php
/**
 * Lightning Three Column Unit Widget Area
 *
 * @package Lightning Three Column Unit
 */

namespace Lightning_G3_Three_Column_Unit;
use Lightning_G3_Three_Column_Unit\Condition;

/**
 * Lightning Three Column Unit Widget Area
 */
class Widget_Area {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( __CLASS__, 'register_widget_area' ) );
		add_action( 'lightning_sub_section_prepend', array( __CLASS__, 'add_sub_section_prepend' ) );
		add_action( 'lightning_sub_section_append', array( __CLASS__, 'add_sub_section_append' ) );
		add_action( 'lightning_sub_section_after', array( __CLASS__, 'add_sidebar' ) );
	}

	/**
	 * Register Sidebar
	 */
	public static function register_widget_area() {

		register_sidebar(
			array(
				'name'          => __( 'Additional Sidebar Common Upper', 'lightning-g3-three-column-unit' ),
				'id'            => 'lightning-addtional-sidebar-common-upper',
				'description'   => __( 'This widget area appears on Three Column Layout only.', 'lightning-g3-three-column-unit' ),
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title sub-section-title">',
				'after_title'   => '</h4>',
			),
		);

		register_sidebar(
			array(
				'name'          => __( 'Additional Sidebar for Top Page', 'lightning-g3-three-column-unit' ),
				'id'            => 'lightning-addtional-sidebar-top-page',
				'description'   => __( 'This widget area appears on the Front Page and Three Column Layout only.', 'lightning-g3-three-column-unit' ),
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title sub-section-title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Additional Sidebar for Search Result', 'lightning-g3-three-column-unit' ),
				'id'            => 'lightning-addtional-sidebar-search-result',
				'description'   => __( 'This widget area appears on the Search Result and Three Column Layout only.', 'lightning-g3-three-column-unit' ),
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title sub-section-title">',
				'after_title'   => '</h4>',
			)
		);

		$post_types = get_post_types( array( 'public' => true ) );

		foreach ( $post_types as $post_type ) {
			$post_type_object = get_post_type_object( $post_type );
			// Set post type name
			$post_type_name = esc_html( $post_type_object->labels->name );
			$sidebar_description = '';
			if ( 'post' === $post_type ) {

				$sidebar_description = __( 'This widget area appears on the Post and Three Column Layout only.', 'lightning-g3-three-column-unit' );

			} elseif ( 'page' === $post_type ) {

				$sidebar_description = __( 'This widget area appears on the Page and Three Column Layout only.', 'lightning-g3-three-column-unit' );

			} elseif ( 'attachment' === $post_type ) {

				$sidebar_description = __( 'This widget area appears on the Media and Three Column Layout only.', 'lightning-g3-three-column-unit' );

			} else {

				$sidebar_description = sprintf( __( 'This widget area appears on the %s and Three Column Layout only.', 'lightning-g3-three-column-unit' ), $post_type_name );

			}

			// Set post type widget area
			register_sidebar(
				array(
					'name'          => sprintf( __( 'Additional Sidebar for %s', 'lightning-g3-three-column-unit' ), $post_type_name ),
					'id'            => 'lightning-addtional-sidebar-' . $post_type,
					'description'   => $sidebar_description,
					'before_widget' => '<aside class="widget %2$s" id="%1$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title sub-section-title">',
					'after_title'   => '</h4>',
				)
			);
		}

		register_sidebar(
			array(
				'name'          => __( 'Additional Sidebar Common Bottom', 'lightning-g3-three-column-unit' ),
				'id'            => 'lightning-addtional-sidebar-common-bottom',
				'description'   => __( 'This widget area appears on Three Column Layout only.', 'lightning-g3-three-column-unit' ),
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title sub-section-title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Additional Sidebar ( Deprecated )', 'lightning-g3-three-column-unit' ),
				'id'            => 'lightning-addtional-sidebar',
				'description'   => __( 'This widget area appears no page.', 'lightning-g3-three-column-unit' ),
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title sub-section-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	/**
	 * Sub Section Prepend
	 */
	public static function add_sub_section_prepend() {
		?>
		<div class="<?php lightning_the_class_name( 'sub-section-inner' ); ?>">
		<?php
	}

	/**
	 * Sub Section Append
	 */
	public static function add_sub_section_append() {
		?>
		</div>
		<?php
	}

	/**
	 * Add Sidebar
	 */
	public static function add_sidebar() {
		if ( Condition::lightning_is_layout_three_column() ) {
			$post_type = get_post_type();
			?>
			<div class="<?php lightning_the_class_name( 'add-section' ); ?>">
				<div class="<?php lightning_the_class_name( 'add-section-inner' ); ?>">
					<?php
					// サイドバー上部
					if ( is_active_sidebar( 'lightning-addtional-sidebar-common-upper' ) ) {
						dynamic_sidebar( 'lightning-addtional-sidebar-common-upper' );
					}

					// サイドバー中部
					if ( ( is_front_page() || is_home() ) && is_active_sidebar( 'lightning-addtional-sidebar-top-page' ) ) {
						dynamic_sidebar( 'lightning-addtional-sidebar-top-page' );
					} elseif ( is_search() && is_active_sidebar( 'lightning-addtional-sidebar-search-result' ) ) {
						dynamic_sidebar( 'lightning-addtional-sidebar-search-result' );
					} elseif ( ( $post_type === get_post_type() || $post_type === get_query_var( 'post_type' ) ) && is_active_sidebar( 'lightning-addtional-sidebar-' . $post_type ) ) {
						dynamic_sidebar( 'lightning-addtional-sidebar-' . $post_type );
					}
					
					// サイドバー下部
					if ( is_active_sidebar( 'lightning-addtional-sidebar-common-bottom' ) ) {
						dynamic_sidebar( 'lightning-addtional-sidebar-common-bottom');
					}
					?>
				</div>
			</div>
			<?php
		}
	}

}
