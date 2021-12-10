<?php
/**
 * Lightning Three Column Unit
 *
 * @package Lightning Three Column Unit
 */

/**
 * Lightning Three Column Unit
 */
class Lightning_G3_Three_Column_Unit_Control {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'lighghtning_columns_setting_choice', array( __CLASS__, 'columns_setting_choice' ) );
		add_filter( 'lightning_get_class_names', array( __CLASS__, 'get_the_class_names' ) );
	}

	/**
	 * Add Column Setting Chioice
	 *
	 * @param array $choice Choice of Setting.
	 */
	public static function columns_setting_choice( $choice ) {
		$choice = array(
			'default'                  => __( 'Use common settings', 'lightning-g3-three-column-unit' ),
			'col-one-no-subsection'    => __( '1 column ( No sub section )', 'lightning-g3-three-column-unit' ),
			'col-one'                  => __( '1 column', 'lightning-g3-three-column-unit' ),
			'col-two'                  => __( '2 column', 'lightning-g3-three-column-unit' ),
			'col-three-content-left'   => __( '3 Column Content Left', 'lightning-g3-three-column-unit' ),
			'col-three-content-center' => __( '3 Column Content Center', 'lightning-g3-three-column-unit' ),
			'col-three-content-right'  => __( '3 Column Content Right', 'lightning-g3-three-column-unit' ),
		);
		return $choice;
	}

	/**
	 * Class Change
	 *
	 * @param array $class_names classnames.
	 */
	public static function get_the_class_names( $class_names ) {

		$options                = get_option( 'lightning_theme_options' );
		$options['sidebar_fix'] = 'no-fix';
		update_option( 'lightning_theme_options', $options );

		$one_column_layout   = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_one_column();
		$two_column_layout   = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_two_column();
		$three_column_layout = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column();

		$three_column_content_left_layout   = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column_content_left();
		$three_column_content_center_layout = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column_content_center();
		$three_column_content_right_layout  = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column_content_right();

		$three_column_set = Lightning_G3_Three_Column_Unit_Condition::lightning_is_set_three_column();

		$class_names['main-section']      = array( 'main-section' );
		$class_names['sub-section']       = array( 'sub-section' );
		$class_names['add-section']       = array( 'add-section' );
		$class_names['sub-section-inner'] = array( 'sub-section-inner' );
		$class_names['add-section-inner'] = array( 'add-section-inner' );

		if ( $one_column_layout ) {
			if ( lightning_is_subsection() ) {
				$class_names['main-section'][] = ' main-section--margin-bottom--on';
			}
		}

		if ( $two_column_layout ) {
			$class_names['main-section'][] = 'main-section--col--two';
			$class_names['sub-section'][]  = 'sub-section--col--two';
		}

		if ( $three_column_content_left_layout || $three_column_content_center_layout || $three_column_content_right_layout ) {
			$class_names['main-section'][] = 'main-section-col-three';
			$class_names['sub-section'][]  = 'sub-section-col-three';
			$class_names['add-section'][]  = 'add-section-col-three';
		}

		if ( function_exists( 'lightning_is_base_active' ) && lightning_is_base_active() ) {
			$class_names['site-body'][]    = 'site-body--base--on';
			$class_names['main-section'][] = 'main-section--base--on';
			$class_names['sub-section'][]  = 'sub-section--base--on';
			$class_names['add-section'][]  = 'add-section--base--on';
		} else {
			unset( $class_names['site-body']['site-body--base--on'] );
			unset( $class_names['main-section']['main-section--base--on'] );
			unset( $class_names['sub-section']['sub-section--base--on'] );
			unset( $class_names['add-section']['add-section--base--on'] );
		}

		return $class_names;
	}


}

new Lightning_G3_Three_Column_Unit_Control();
