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
		add_filter( 'lightning_get_the_class_names', array( __CLASS__, 'get_the_class_names' ) );
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
	 * @param array  $class_names classnames.
	 * @param string $position position.
	 */
	public static function get_the_class_names( $class_names, $position = '' ) {

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

		if ( $one_column_layout ) {
			$class_names['mainSection'] = 'col mainSection mainSection-col-one';
			$class_names['sideSection'] = 'col subSection sideSection sideSection-col-one';
			if ( lightning_is_subsection_display() ) {
				$class_names['mainSection'] .= ' mainSection-marginBottom-on';
			}
		} else {
			if ( lightning_is_siteContent_padding_off() ) {
				$class_names['mainSection'] .= ' mainSection-marginVertical-off';
			}
		}

		if ( $two_column_layout ) {
			if ( ! empty( $options['sidebar_position'] ) && 'left' === $options['sidebar_position'] ) {
				$class_names['mainSection'] = 'col mainSection mainSection-col-two baseSection';
				$class_names['sideSection'] = 'col subSection sideSection sideSection-col-two baseSection';
			} else {
				$class_names['mainSection'] = 'col mainSection mainSection-col-two baseSection';
				$class_names['sideSection'] = 'col subSection sideSection sideSection-col-two baseSection';
			}
		}

		if ( $three_column_content_left_layout ) {
			$class_names['mainSection'] = 'col mainSection  mainSection-col-three baseSection';
			if ( ! empty( $options['sidebar_position'] ) && 'left' === $options['sidebar_position'] ) {
				$class_names['sideSection'] = 'col subSection sideSection sideSection-col-three baseSection';
				$class_names['addSection']  = 'col subSection addSection addSection-col-three baseSection';
			} else {
				$class_names['sideSection'] = 'col subSection sideSection sideSection-col-three baseSection';
				$class_names['addSection']  = 'col subSection addSection addSection-col-three baseSection';
			}
		}

		if ( $three_column_content_center_layout ) {
			$class_names['mainSection'] = 'col mainSection mainSection-col-three baseSection';
			if ( ! empty( $options['sidebar_position'] ) && 'left' === $options['sidebar_position'] ) {
				$class_names['sideSection'] = 'col subSection sideSection sideSection-col-three baseSection';
				$class_names['addSection']  = 'col subSection addSection addSection-col-three baseSection';
			} else {
				$class_names['sideSection'] = 'col subSection sideSection sideSection-col-three baseSection';
				$class_names['addSection']  = 'col subSection addSection addSection-col-three baseSection';
			}
		}

		if ( $three_column_content_right_layout ) {
			$class_names['mainSection'] = 'col mainSection mainSection-col-three baseSection';
			if ( ! empty( $options['sidebar_position'] ) && 'left' === $options['sidebar_position'] ) {
				$class_names['sideSection'] = 'col subSection sideSection sideSection-col-three baseSection';
				$class_names['addSection']  = 'col subSection addSection addSection-col-three baseSection';
			} else {
				$class_names['sideSection'] = 'col subSection sideSection sideSection-col-three baseSection';
				$class_names['addSection']  = 'col subSection addSection addSection-col-three baseSection';
			}
		}

		if ( function_exists( 'lightning_is_base_active' ) && lightning_is_base_active() ) {
			$class_names['siteContent'] = $class_names['siteContent'] . ' siteContent-base-on';
			$class_names['mainSection'] = $class_names['mainSection'] . ' mainSection-base-on';
			$class_names['sideSection'] = $class_names['sideSection'] . ' sideSection-base-on';
			$class_names['addSection']  = $class_names['addSection'] . ' addSection-base-on';
		} else {
			$class_names['siteContent'] = str_replace( ' siteContent-base-on', '', $class_names['siteContent'] );
			$class_names['mainSection'] = str_replace( ' mainSection-base-on', '', $class_names['mainSection'] );
			$class_names['sideSection'] = str_replace( ' sideSection-base-on', '', $class_names['sideSection'] );
			$class_names['addSection']  = str_replace( ' addSection-base-on', '', $class_names['addSection'] );
		}

		return $class_names;
	}


}

new Lightning_G3_Three_Column_Unit_Control();
