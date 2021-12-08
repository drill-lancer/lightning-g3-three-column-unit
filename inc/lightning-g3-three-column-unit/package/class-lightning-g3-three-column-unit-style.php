<?php
/**
 * Lightning Three Column Unit
 *
 * @package Lightning Three Column Unit
 */

/**
 * Lightning Three Column Unit
 */
class Lightning_G3_Three_Column_Unit_Style {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_head', array( __CLASS__, 'render_style' ), 5 );
	}

	/**
	 * Render Style
	 */
	public static function render_style() {
		$options = get_option( 'lightning_g3_three_column_unit_options' );
		$default = Lightning_G3_Three_Column_Unit_Admin::default_option();
		$options = wp_parse_args( $options, $default );

		$one_column_layout   = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_one_column();
		$two_column_layout   = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_two_column();
		$three_column_layout = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column();

		$three_column_content_left_layout   = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column_content_left();
		$three_column_content_center_layout = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column_content_center();
		$three_column_content_right_layout  = Lightning_G3_Three_Column_Unit_Condition::lightning_is_layout_three_column_content_right();

		$three_column_set = Lightning_G3_Three_Column_Unit_Condition::lightning_is_set_three_column();

		$lightning_theme_option = get_option( 'lightning_theme_options' );

		$current_skin = get_option( 'lightning_design_skin' );

		$sidebar_position = ! empty( $lightning_theme_option['sidebar_position'] ) && 'left' === $lightning_theme_option['sidebar_position'] ? 'left' : 'right';

		$main_width             = $options['main_width'];
		$side_width             = $options['side_width'];
		$column_margin          = $options['column_margin'];
		$outer_container_margin = $options['outer_container_margin'];

		$container_2col_width = $main_width + $side_width + $column_margin;
		$container_3col_width = $container_2col_width + $side_width + $column_margin;
		$max_1col_width       = $container_2col_width + $outer_container_margin - 1;
		$min_2col_width       = $container_2col_width + $outer_container_margin;
		$max_2col_width       = $container_3col_width + $outer_container_margin - 1;
		$min_3col_width       = $container_3col_width + $outer_container_margin;

		$container_class = '';
		$dynamic_css     = '';

		$container_class .= '
		.container,
		.global-nav--layout--penetration .global-nav-list,
		.header_scrolled .global-nav.global-nav--scrolled--nav-container .global-nav-list
		';

		$dynamic_css .= '
		@media (min-width: 992px) {
			.header_scrolled .global-nav.global-nav--scrolled--nav-center .global-nav-list>li {
				width: 100%;
			}
		}
		.site-body-container.container {
			display: flex;
			justify-content: space-between;
			flex-wrap: wrap;
			margin-left: auto;
			margin-right: auto;
			padding-left: 0;
			padding-right: 0;
		}
		.sub-section,
		.main-section,
		.add-section {
			flex-basis: auto;
			float:none;
			margin-left: 0;
			margin-right: 0;
		}
		';

		if ( function_exists( 'lightning_is_base_active' ) && false !== lightning_is_base_active() ) {
			$dynamic_css .= '
			@media (min-width: 1200px) {
				.add-section-base-on {
					padding: 2.4rem 2rem;
				}
			}

			@media (min-width: 992px) {
				.add-section-base-on {
					padding: 2.4rem 1.7rem;
				}
			}

			@media (min-width: 768px) {
				.add-section-base-on {
					padding: 2rem;
				}
			}

			@media (min-width: 576px) {
				.add-section-base-on {
					padding: 1.7rem;
				}
			}

			.add-section-base-on {
				background-color: #fff;
				padding: 1.4rem;
			}
			';
		}

		if ( class_exists( 'Lightning_Header_Top' ) ) {
			$dynamic_css .= '
			.site-header .header-top .container {
				padding-left: 0;
				padding-right: 0;
			}
			';
			if ( 'display' === $options['narrow_window_description'] ) {
				$dynamic_css .= '
				@media ( max-width: ' . $max_1col_width . 'px ) {
					.header-top {
						display: block;
					}
					.header-top .header-top_description {
						text-align: center;
					}
					.header-top nav {
						display: none;
					}
					.header-top .header-top_contactBtn {
						display: none;
					}
				}
				';
			} else {
				$dynamic_css .= '
				@media ( max-width: ' . $max_1col_width . 'px ) {
					.header-top {
						display: none;
					}
				}
				';
			}
		}

		$dynamic_css .= '
		@media  ( max-width: ' . $max_1col_width . 'px ) {
			body.device-pc .vk-mobile-nav-menu-btn {
				display: block;
			}
			.site-header-logo {
				font-size: 1.6rem;
				float: inherit;
				text-align: center;
				display: block;
				margin: 0 auto;
				padding: 0 45px;
			}
			.site-header-logo.navbar-brand {
				float: none;
				height: auto;
			}
			.navbar-header {
				float: none;
			}
			.site-head-container.container .navbar-header {
				padding: 0;
			}
			.global-nav {
				display: none;
			}
		}
		';

		if ( $one_column_layout ) {
			// 1 Column Layout.
			if ( $three_column_set ) {
				$dynamic_css .= '
				@media ( max-width: ' . $max_1col_width . 'px ) {
					' . $container_class . ' {
						width: calc( 100% - ' . $outer_container_margin . 'px );
						max-width: calc( 100% - ' . $outer_container_margin . 'px );
					}
				}
				@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
					' . $container_class . ' {
						width: calc( ' . $container_2col_width . 'px - ' . $outer_container_margin . 'px );
						max-width: calc( ' . $container_2col_width . 'px - ' . $outer_container_margin . 'px );
					}
				}
				@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
					' . $container_class . ' {
						width: calc( ' . $container_3col_width . 'px - ' . $outer_container_margin . 'px );
						max-width: calc( ' . $container_3col_width . 'px - ' . $outer_container_margin . 'px );
					}
				}
				.main-section,
				.sub-section {
					width: 100%;
					max-width: 100%;
				}
				';
			} else {
				$dynamic_css .= '
				@media ( max-width: ' . $max_1col_width . 'px ) {
					' . $container_class . ' {
						width: calc( 100% - ' . $outer_container_margin . 'px );
						max-width: calc( 100% - ' . $outer_container_margin . 'px );
					}
				}
				@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: 9999px ) {
					' . $container_class . ' {
						width: calc( ' . $container_2col_width . 'px - ' . $outer_container_margin . 'px );
						max-width: calc( ' . $container_2col_width . 'px - ' . $outer_container_margin . 'px );
					}
				}
				';
			}
		} elseif ( $two_column_layout ) {
			// 2 Column Layout.
			$main_width_wide = $main_width * ( $container_3col_width - $column_margin ) / ( $container_2col_width - $column_margin );
			$side_width_wide = $side_width * ( $container_3col_width - $column_margin ) / ( $container_2col_width - $column_margin );

			// 1 Column.
			if ( 'wrap-down' === $options['main_sidebar_control'] ) {
				$dynamic_css .= '
				@media ( max-width: ' . $max_1col_width . 'px ) {
					' . $container_class . ' {
						width: calc( 100% - ' . $outer_container_margin . 'px );
						max-width: calc( 100% - ' . $outer_container_margin . 'px );
					}
					.main-section,
					.sub-section {
						width: 100%;
						max-width: 100%;
					}
				}
				';
			} else {
				$dynamic_css .= '
				@media ( max-width: ' . $max_1col_width . 'px ) {
					' . $container_class . ' {
						width: calc( 100% - ' . $outer_container_margin . 'px );
						max-width: calc( 100% - ' . $outer_container_margin . 'px );
					}
					.main-section,
					.sub-section {
						width: 100%;
						max-width: 100%;
					}
					.sub-section {
						display: none;
					}
				}
				';
			}

			// 2 Column.
			if ( 'left' === $sidebar_position ) {
				if ( $three_column_set ) {
					$dynamic_css .= '
					@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
						' . $container_class . ' {
							width: ' . $container_2col_width . 'px;
							max-width: ' . $container_2col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-left: ' . $column_margin . 'px;
							order: 1;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 0;
						}
					}
					@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_3col_width . 'px;
							max-width: ' . $container_3col_width . 'px;
						}
						.main-section {
							width: ' . $main_width_wide . 'px;
							max-width: ' . $main_width_wide . 'px;
							margin-left: ' . $column_margin . 'px;
							order: 1;
						}
						.sub-section {
							width: ' . $side_width_wide . 'px;
							max-width: ' . $side_width_wide . 'px;
							order: 0;
						}
					}
					';
				} else {
					$dynamic_css .= '
					@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_2col_width . 'px;
							max-width: ' . $container_2col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-left: ' . $column_margin . 'px;
							order: 1;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 0;
						}
					}
					';
				}
			} else {
				if ( $three_column_set ) {
					$dynamic_css .= '
					@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
						' . $container_class . ' {
							width: ' . $container_2col_width . 'px;
							max-width: ' . $container_2col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 0;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 1;
						}
					}
					@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_3col_width . 'px;
							max-width: ' . $container_3col_width . 'px;
						}
						.main-section {
							width: ' . $main_width_wide . 'px;
							max-width: ' . $main_width_wide . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 0;
						}
						.sub-section {
							width: ' . $side_width_wide . 'px;
							max-width: ' . $side_width_wide . 'px;
							order: 1;
						}
					}
					';
				} else {
					$dynamic_css .= '
					@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_2col_width . 'px;
							max-width: ' . $container_2col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 0;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 1;
						}
					}
					';
				}
			}
		} elseif ( $three_column_layout ) {
			// 3 column Layout.
			$max_width = 'enable' === $options['three-to-one-via-two'] ? $max_1col_width : $max_2col_width;

			// 1 Column.
			if ( 'wrap-down' === $options['main_sidebar_control'] && 'wrap-down' === $options['sub_sidebar_control'] ) {
				$dynamic_css .= '
				@media ( max-width: ' . $max_width . 'px ) {
					' . $container_class . ' {
						width: calc( 100% - ' . $outer_container_margin . 'px );
						max-width: calc( 100% - ' . $outer_container_margin . 'px );
					}
					.main-section,
					.sub-section,
					.add-section {
						width: 100%;
						max-width: 100%;
					}
				}
				';
			} elseif ( 'wrap-down' === $options['main_sidebar_control'] && 'hide' === $options['sub_sidebar_control'] ) {
				$dynamic_css .= '
				@media ( max-width: ' . $max_width . 'px ) {
					' . $container_class . ' {
						width: calc( 100% - ' . $outer_container_margin . 'px );
						max-width: calc( 100% - ' . $outer_container_margin . 'px );
					}
					.main-section,
					.sub-section,
					.add-section {
						width: 100%;
						max-width: 100%;
					}
					.add-section {
						display: none;
					}
				}
				';
			} elseif ( 'hide' === $options['main_sidebar_control'] && 'wrap-down' === $options['sub_sidebar_control'] ) {
				$dynamic_css .= '
				@media ( max-width: ' . $max_width . 'px ) {
					' . $container_class . ' {
						width: calc( 100% - ' . $outer_container_margin . 'px );
						max-width: calc( 100% - ' . $outer_container_margin . 'px );
					}
					.main-section,
					.sub-section,
					.add-section {
						width: 100%;
						max-width: 100%;
					}
					.sub-section {
						display: none;
					}
				}
				';
			} else {
				$dynamic_css .= '
				@media ( max-width: ' . $max_width . 'px ) {
					' . $container_class . ' {
						width: calc( 100% - ' . $outer_container_margin . 'px );
						max-width: calc( 100% - ' . $outer_container_margin . 'px );
					}
					.main-section,
					.sub-section,
					.add-section {
						width: 100%;
						max-width: 100%;
					}
					.sub-section,
					.add-section{
						display: none;
					}
				}
				';
			}

			// 2 Column.
			if ( 'enable' === $options['three-to-one-via-two'] ) {
				if ( $three_column_content_left_layout ) {
					// 3 Column Content Left.
					if ( 'wrap-down' === $options['sub_sidebar_control'] ) {
						$dynamic_css .= '
						@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
							' . $container_class . ' {
								width: ' . $container_2col_width . 'px;
								max-width: ' . $container_2col_width . 'px;
							}
							.main-section {
								width: ' . $main_width . 'px;
								max-width: ' . $main_width . 'px;
								margin-right: ' . $column_margin . 'px;
								order: 0;
							}
							.sub-section {
								width: ' . $side_width . 'px;
								max-width: ' . $side_width . 'px;
								order: 1;
							}
							.add-section {
								width: 100%;
								max-width: 100%;
								margin-top: 2em;
								order: 2;
							}
						}
						';
					} else {
						$dynamic_css .= '
						@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
							' . $container_class . ' {
								width: ' . $container_2col_width . 'px;
								max-width: ' . $container_2col_width . 'px;
							}
							.main-section {
								width: ' . $main_width . 'px;
								max-width: ' . $main_width . 'px;
								margin-right: ' . $column_margin . 'px;
								order: 0;
							}
							.sub-section {
								width: ' . $side_width . 'px;
								max-width: ' . $side_width . 'px;
								order: 1;
							}
							.add-section {
								display: none;
							}
						}
						';
					}
				} elseif ( $three_column_content_center_layout ) {
					// 3 Column Content Center.
					if ( 'left' === $sidebar_position ) {
						// Sidebar Left.
						if ( 'wrap-down' === $options['sub_sidebar_control'] ) {
							$dynamic_css .= '
							@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
								' . $container_class . ' {
									width: ' . $container_2col_width . 'px;
									max-width: ' . $container_2col_width . 'px;
								}
								.main-section {
									width: ' . $main_width . 'px;
									max-width: ' . $main_width . 'px;
									margin-left: ' . $column_margin . 'px;
									order: 1;
								}
								.sub-section {
									width: ' . $side_width . 'px;
									max-width: ' . $side_width . 'px;
									order: 0;
								}
								.add-section {
									width: 100%;
									max-width: 100%;
									margin-top: 2em;
									order: 2;
								}
							}
							';
						} else {
							$dynamic_css .= '
							@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
								' . $container_class . ' {
									width: ' . $container_2col_width . 'px;
									max-width: ' . $container_2col_width . 'px;
								}
								.main-section {
									width: ' . $main_width . 'px;
									max-width: ' . $main_width . 'px;
									margin-left: ' . $column_margin . 'px;
									order: 1;
								}
								.sub-section {
									width: ' . $side_width . 'px;
									max-width: ' . $side_width . 'px;
									order: 0;
								}
								.add-section {
									display: none;
								}
							}
							';
						}
					} else {
						// Sidebar Right.
						if ( 'wrap-down' === $options['sub_sidebar_control'] ) {
							$dynamic_css .= '
							@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
								' . $container_class . ' {
									width: ' . $container_2col_width . 'px;
									max-width: ' . $container_2col_width . 'px;
								}
								.main-section {
									width: ' . $main_width . 'px;
									max-width: ' . $main_width . 'px;
									margin-right: ' . $column_margin . 'px;
									order: 0;
								}
								.sub-section {
									width: ' . $side_width . 'px;
									max-width: ' . $side_width . 'px;
									order: 1;
								}
								.add-section {
									width: 100%;
									max-width: 100%;
									margin-top: 2em;
									order: 2;
								}
							}
							';
						} else {
							$dynamic_css .= '
							@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
								' . $container_class . ' {
									width: ' . $container_2col_width . 'px;
									max-width: ' . $container_2col_width . 'px;
								}
								.main-section {
									width: ' . $main_width . 'px;
									max-width: ' . $main_width . 'px;
									margin-right: ' . $column_margin . 'px;
									order: 0;
								}
								.sub-section {
									width: ' . $side_width . 'px;
									max-width: ' . $side_width . 'px;
									order: 1;
								}
								.add-section {
									display: none;
								}
							}
							';
						}
					}
				} elseif ( $three_column_content_right_layout ) {
					// 3 Column Content Right.
					if ( 'wrap-down' === $options['sub_sidebar_control'] ) {
						$dynamic_css .= '
						@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
							' . $container_class . ' {
								width: ' . $container_2col_width . 'px;
								max-width: ' . $container_2col_width . 'px;
							}
							.main-section {
								width: ' . $main_width . 'px;
								max-width: ' . $main_width . 'px;
								margin-left: ' . $column_margin . 'px;
								order: 1;
							}
							.sub-section {
								width: ' . $side_width . 'px;
								max-width: ' . $side_width . 'px;
								order: 0;
							}
							.add-section {
								width: 100%;
								max-width: 100%;
								margin-top: 2em;
								order: 2;
							}
						}
						';
					} else {
						$dynamic_css .= '
						@media ( min-width: ' . $min_2col_width . 'px ) and ( max-width: ' . $max_2col_width . 'px ) {
							' . $container_class . ' {
								width: ' . $container_2col_width . 'px;
								max-width: ' . $container_2col_width . 'px;
							}
							.main-section {
								width: ' . $main_width . 'px;
								max-width: ' . $main_width . 'px;
								margin-left: ' . $column_margin . 'px;
								order: 1;
							}
							.sub-section {
								width: ' . $side_width . 'px;
								max-width: ' . $side_width . 'px;
								order: 0;
							}
							.add-section {
								display: none;
							}
						}
						';
					}
				}
			}

			// 3 Column.
			if ( $three_column_content_left_layout ) {
				if ( 'left' === $sidebar_position ) {
					$dynamic_css .= '
					@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_3col_width . 'px;
							max-width: ' . $container_3col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 0;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 1;
						}
						.add-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 2;
							display: block;
						}
					}
					';
				} else {
					$dynamic_css .= '
					@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_3col_width . 'px;
							max-width: ' . $container_3col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 0;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 2;
						}
						.add-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 1;
							display: block;
						}
					}
					';
				}
			} elseif ( $three_column_content_center_layout ) {
				if ( 'left' === $sidebar_position ) {
					$dynamic_css .= '
					@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_3col_width . 'px;
							max-width: ' . $container_3col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-left: ' . $column_margin . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 1;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 0;
						}
						.add-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 2;
							display: block;
						}
					}
					';
				} else {
					$dynamic_css .= '
					@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_3col_width . 'px;
							max-width: ' . $container_3col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-left: ' . $column_margin . 'px;
							margin-right: ' . $column_margin . 'px;
							order: 1;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 2;
						}
						.add-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 0;
							display: block;
						}
					}
					';
				}
			} elseif ( $three_column_content_right_layout ) {
				if ( 'left' === $sidebar_position ) {
					$dynamic_css .= '
					@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_3col_width . 'px;
							max-width: ' . $container_3col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-left: ' . $column_margin . 'px;
							order: 2;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 0;
						}
						.add-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							margin-left: ' . $column_margin . 'px;
							order: 1;
							display: block;
						}
					}
					';
				} else {
					$dynamic_css .= '
					@media ( min-width: ' . $min_3col_width . 'px ) and ( max-width: 9999px ) {
						' . $container_class . ' {
							width: ' . $container_3col_width . 'px;
							max-width: ' . $container_3col_width . 'px;
						}
						.main-section {
							width: ' . $main_width . 'px;
							max-width: ' . $main_width . 'px;
							margin-left: ' . $column_margin . 'px;
							order: 2;
						}
						.sub-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							margin-left: ' . $column_margin . 'px;
							order: 1;
						}
						.add-section {
							width: ' . $side_width . 'px;
							max-width: ' . $side_width . 'px;
							order: 0;
							display: block;
						}
					}
					';
				}
			}
		}
		$dynamic_css = str_replace( PHP_EOL, '', $dynamic_css );
		// delete tab.
		$dynamic_css = preg_replace( '/[\n\r\t]/', '', $dynamic_css );
		// multi space convert to single space.
		$dynamic_css = preg_replace( '/\s(?=\s)/', '', $dynamic_css );
		$dynamic_css = '/* Lightning G3 Three Colomn Unit */' . $dynamic_css;
		wp_add_inline_style( 'lightning-design-style', $dynamic_css );

	}

}
new Lightning_G3_Three_Column_Unit_Style();
