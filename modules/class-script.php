<?php
/**
 * Lightning Three Column Unit
 *
 * @package Lightning Three Column Unit
 */

namespace Lightning_G3_Three_Column_Unit;
use Lightning_G3_Three_Column_Unit\Admin;
use Lightning_G3_Three_Column_Unit\Condition;

class Script {

    /**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_footer', array( __CLASS__, 'render_script' ) );
	}

	/**
	 * Render Script
	 */
	public static function render_script() {
		$options = get_option( 'lightning_g3_three_column_unit_options' );
		$default = Admin::default_option();
		$options = wp_parse_args( $options, $default );

		$one_column_layout   = Condition::lightning_is_layout_one_column();
		$two_column_layout   = Condition::lightning_is_layout_two_column();
		$three_column_layout = Condition::lightning_is_layout_three_column();

		$three_column_content_left_layout   = Condition::lightning_is_layout_three_column_content_left();
		$three_column_content_center_layout = Condition::lightning_is_layout_three_column_content_center();
		$three_column_content_right_layout  = Condition::lightning_is_layout_three_column_content_right();

		$three_column_set = Condition::lightning_is_set_three_column();

		$lightning_theme_option = get_option( 'lightning_theme_options' );

		$current_skin = get_option( 'lightning_design_skin' );

		$sidebar_position = ! empty( $lightning_theme_option['sidebar_position'] ) && 'left' === $lightning_theme_option['sidebar_position'] ? 'left' : 'right';

		$main_width                = $options['main_width'];
		$side_width                = $options['side_width'];
		$column_margin             = $options['column_margin'];
		$outer_container_margin    = $options['outer_container_margin'];
        $sub_sidebar_position_2col = $options['2col_sub_sidebar_position'];

		$container_2col_width = $main_width + $side_width + $column_margin;
		$container_3col_width = $container_2col_width + $side_width + $column_margin;
		$max_1col_width       = $container_2col_width + $outer_container_margin - 1;
		$min_2col_width       = $container_2col_width + $outer_container_margin;
		$max_2col_width       = $container_3col_width + $outer_container_margin - 1;
		$min_3col_width       = $container_3col_width + $outer_container_margin;

        if ( $three_column_layout && 'under-main-sidebar' ===  $sub_sidebar_position_2col ) {
           
            $script = <<<EOT
            const isThreeColumnLayout = $three_column_layout;
            const min_2col_width = $min_2col_width;
            const max_2col_width = $max_2col_width;
            const min_3col_width = $min_3col_width;         

            const changeLayout = ( windowWidth, sideSection, subSection, addSection ) => {
                if ( sideSection === null || sideSection === undefined ) {
                    if ( windowWidth >= min_2col_width && windowWidth <= max_2col_width ) {
                        const sideSectionHTML = document.createElement("div");
                        sideSectionHTML.classList.add( 'side-section' );
                        sideSectionHTML.innerHTML = subSection.outerHTML + addSection.outerHTML;
                        subSection.before( sideSectionHTML );
                        subSection.remove(); 
                        addSection.remove();
                    }                   
                } else {
                    if ( windowWidth < min_2col_width || windowWidth > max_2col_width ) {
                        sideSection.before( subSection, addSection  );
                        sideSection.remove();
                    }
                }
            }

            const fixLayout = () => {
                const sideSection = document.querySelector( '.side-section' );
                const subSection  = document.querySelector( '.sub-section' );
                const addSection  = document.querySelector( '.add-section' );
                const windowWidth = window.innerWidth;
                changeLayout( windowWidth, sideSection, subSection, addSection );
            }

            window.addEventListener('DOMContentLoaded', () => {
                fixLayout();           
            });

            window.addEventListener('resize', () => {
                fixLayout();
            });
            EOT;

            
            
            wp_add_inline_script( 'lightning-js', $script );
        }

    }
}