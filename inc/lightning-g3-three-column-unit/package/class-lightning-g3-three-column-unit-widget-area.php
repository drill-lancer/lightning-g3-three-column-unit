<?php
/**
 * Lightning Three Column Unit Widget Area
 *
 * @package Lightning Three Column Unit
 */

/**
 * Lightning Three Column Unit Widget Area
 */
class Lightning_G3_Three_Column_Unit_Widget_Area {

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
				'name'          => __( 'Additional Sidebar', 'lightning-g3-three-column-unit' ),
				'id'            => 'lightning-addtional-sidebar',
				'description'   => __( 'Display only Three Column Layout', 'lightning-g3-three-column-unit' ),
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
		if ( Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column() ) {
			?>
			<div class="<?php lightning_the_class_name( 'add-section' ); ?>">
				<div class="<?php lightning_the_class_name( 'add-section-inner' ); ?>">
					<?php
					if ( is_active_sidebar( 'lightning-addtional-sidebar' ) ) {
						dynamic_sidebar( 'lightning-addtional-sidebar' );
					}
					?>
				</div>
			</div>
			<?php
		}
	}

}

new Lightning_G3_Three_Column_Unit_Widget_Area();
