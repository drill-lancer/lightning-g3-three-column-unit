<?php
/**
 * Conditions of Lightning Three Column Unit
 *
 * @package Lightning Three Column Unit
 */

/**
 * Conditions of Lightning Three Column Unit
 */
class Lightning_G3_Three_Column_Unit_Condition {

	/**
	 * Lightning Layout Target Array
	 */
	public static function lightning_layout_target_array() {
		$array = array(
			'error404'       => array(
				'function' => 'is_404',
			),
			'search'         => array(
				'function' => 'is_search',
			),
			'archive-author' => array(
				'function' => 'is_author',
			),
		);
		return $array;
	}

	/**
	 * Lightning Layout Single
	 *
	 *  @since Lightning 14.3.3
	 *  @return false / col-two / col-one / col-one-no-subsection
	 */
	public static function lightning_layout_by_single() {
		$layout = false;
		if ( is_singular() ) {
			global $post;
			if ( is_page() || is_front_page() ) {
				$template           = get_post_meta( $post->ID, '_wp_page_template', true );
				$template_onecolumn = array(
					'page-onecolumn.php',
					'page-lp.php',
				);
				if ( in_array( $template, $template_onecolumn, true ) ) {
					$layout = 'col-one';
				}
			}
			if ( isset( $post->_lightning_design_setting['layout'] ) ) {
				if ( 'col-one-no-subsection' === $post->_lightning_design_setting['layout'] ) {
					$layout = 'col-one-no-subsection';
				} elseif ( 'col-one' === $post->_lightning_design_setting['layout'] ) {
					$layout = 'col-one';
				} elseif ( 'col-two' === $post->_lightning_design_setting['layout'] ) {
					$layout = 'col-two';
				} elseif ( 'col-three-content-left' === $post->_lightning_design_setting['layout'] ) {
					$layout = 'col-three-content-left';
				} elseif ( 'col-three-content-center' === $post->_lightning_design_setting['layout'] ) {
					$layout = 'col-three-content-center';
				} elseif ( 'col-three-content-right' === $post->_lightning_design_setting['layout'] ) {
					$layout = 'col-three-content-right';
				}
			}
		}
		return $layout;
	}

	/**
	 * Lightning Is Layout One Column
	 *
	 * @since Lightning 9.0.0
	 * @return boolean
	 */
	public static function lightning_is_layout_one_column() {
		$onecolumn = false;
		$options   = get_option( 'lightning_theme_options' );
		global $wp_query;

		$additional_post_types = get_post_types(
			array(
				'public'   => true,
				'_builtin' => false,
			),
			'names'
		);

		$array = self::lightning_layout_target_array();

		foreach ( $array as $key => $value ) {
			if ( call_user_func( $value['function'] ) ) {
				if ( isset( $options['layout'][ $key ] ) ) {
					if ( 'col-one' === $options['layout'][ $key ] || 'col-one-no-subsection' === $options['layout'][ $key ] ) {
						$onecolumn = true;
					}
				}
			}
		}

		if ( is_front_page() && ! is_home() ) {
			// show_on_front 'page' case.
			if ( isset( $options['layout']['front-page'] ) ) {
				if ( 'col-one' === $options['layout']['front-page'] || 'col-one-no-subsection' === $options['layout']['front-page'] ) {
					$onecolumn = true;
				}
			} elseif ( 'col-one' === lightning_layout_by_single() || 'col-one-no-subsection' === lightning_layout_by_single() ) {
				$onecolumn = true;
			}
		} elseif ( is_front_page() && is_home() ) {
			// show_on_front 'posts' case.
			if ( isset( $options['layout']['front-page'] ) ) {
				if ( 'col-one' === $options['layout']['front-page'] || 'col-one-no-subsection' === $options['layout']['front-page'] ) {
					$onecolumn = true;
				} elseif ( isset( $options['layout']['archive-post'] ) ) {
					if ( 'col-one' === $options['layout']['archive-post'] || 'col-one-no-subsection' === $options['layout']['archive-post'] ) {
						$onecolumn = true;
					}
				}
			}
		} elseif ( ! is_front_page() && is_home() ) {
			if ( isset( $options['layout']['archive-post'] ) ) {
				if ( 'col-one' === $options['layout']['archive-post'] || 'col-one-no-subsection' === $options['layout']['archive-post'] ) {
					$onecolumn = true;
				}
			}
		} elseif ( is_archive() && ! is_search() && ! is_author() ) {
			$current_post_type_info = VK_Helpers::get_post_type_info();
			$archive_post_types     = array( 'post' ) + $additional_post_types;
			foreach ( $archive_post_types as $archive_post_type ) {
				if ( isset( $options['layout'][ 'archive-' . $archive_post_type ] ) && $current_post_type_info['slug'] === $archive_post_type ) {
					if ( 'col-one' === $options['layout'][ 'archive-' . $archive_post_type ] || 'col-one-no-subsection' === $options['layout'][ 'archive-' . $archive_post_type ] ) {
						$onecolumn = true;
					}
				}
			}
		} elseif ( 'col-one' === lightning_layout_by_single() || 'col-one-no-subsection' === lightning_layout_by_single() ) {
			$onecolumn = true;
		}
		return apply_filters( 'lightning_g3_is_layout_one_column', $onecolumn );
	}

	/**
	 * Lightning is 2 Column
	 */
	public static function lightning_is_layout_two_column() {
		$one_column          = self::lightning_is_layout_one_column();
		$three_column_left   = self::lightning_is_layout_three_column_content_left();
		$three_column_center = self::lightning_is_layout_three_column_content_center();
		$three_column_right  = self::lightning_is_layout_three_column_content_right();
		return ! $one_column && ! $three_column_left && ! $three_column_center && ! $three_column_right;
	}

	/**
	 * Lightning is 3 Column Content Left
	 */
	public static function lightning_is_layout_three_column_content_left() {
		$three_column_left = false;
		$options           = get_option( 'lightning_theme_options' );
		global $wp_query;

		$additional_post_types = get_post_types(
			array(
				'public'   => true,
				'_builtin' => false,
			),
			'names'
		);

		$array = self::lightning_layout_target_array();

		foreach ( $array as $key => $value ) {
			if ( call_user_func( $value['function'] ) ) {
				if ( isset( $options['layout'][ $key ] ) ) {
					if ( 'col-three-content-left' === $options['layout'][ $key ] ) {
						$three_column_left = true;
					}
				}
			}
		}

		if ( is_front_page() && ! is_home() ) {
			if ( isset( $options['layout']['front-page'] ) ) {
				if ( 'col-three-content-left' === $options['layout']['front-page'] ) {
					$three_column_left = true;
				}
			} elseif ( 'col-three-content-left' === lightning_layout_by_single() ) {
				$three_column_left = true;
			}
		} elseif ( is_front_page() && is_home() ) {
			if ( isset( $options['layout']['front-page'] ) ) {
				if ( 'col-three-content-left' === $options['layout']['front-page'] ) {
					$three_column_left = true;
				} elseif ( isset( $options['layout']['archive-post'] ) ) {
					if ( 'col-three-content-left' === $options['layout']['archive-post'] ) {
						$three_column_left = true;
					}
				}
			}
		} elseif ( ! is_front_page() && is_home() ) {
			if ( isset( $options['layout']['archive-post'] ) ) {
				if ( 'col-three-content-left' === $options['layout']['archive-post'] ) {
					$three_column_left = true;
				}
			}
		} elseif ( is_archive() && ! is_search() && ! is_author() ) {
			$current_post_type_info = lightning_get_post_type();
			$archive_post_types     = array( 'post' ) + $additional_post_types;
			foreach ( $archive_post_types as $archive_post_type ) {
				if ( isset( $options['layout'][ 'archive-' . $archive_post_type ] ) && $current_post_type_info['slug'] === $archive_post_type ) {
					if ( 'col-three-content-left' === $options['layout'][ 'archive-' . $archive_post_type ] ) {
						$three_column_left = true;
					}
				}
			}
		} elseif ( 'col-three-content-left' === lightning_layout_by_single() ) {
			$three_column_left = true;
		}
		return apply_filters( 'lightning_g3_is_layout_three_column_content_left', $three_column_left );
	}

	/**
	 * Lightning is 3 Column Content center
	 */
	public static function lightning_is_layout_three_column_content_center() {
		$three_column_center = false;
		$options           = get_option( 'lightning_theme_options' );
		global $wp_query;

		$additional_post_types = get_post_types(
			array(
				'public'   => true,
				'_builtin' => false,
			),
			'names'
		);

		$array = self::lightning_layout_target_array();

		foreach ( $array as $key => $value ) {
			if ( call_user_func( $value['function'] ) ) {
				if ( isset( $options['layout'][ $key ] ) ) {
					if ( 'col-three-content-center' === $options['layout'][ $key ] ) {
						$three_column_center = true;
					}
				}
			}
		}

		if ( is_front_page() && ! is_home() ) {
			if ( isset( $options['layout']['front-page'] ) ) {
				if ( 'col-three-content-center' === $options['layout']['front-page'] ) {
					$three_column_center = true;
				}
			} elseif ( 'col-three-content-center' === lightning_layout_by_single() ) {
				$three_column_center = true;
			}
		} elseif ( is_front_page() && is_home() ) {
			if ( isset( $options['layout']['front-page'] ) ) {
				if ( 'col-three-content-center' === $options['layout']['front-page'] ) {
					$three_column_center = true;
				} elseif ( isset( $options['layout']['archive-post'] ) ) {
					if ( 'col-three-content-center' === $options['layout']['archive-post'] ) {
						$three_column_center = true;
					}
				}
			}
		} elseif ( ! is_front_page() && is_home() ) {
			if ( isset( $options['layout']['archive-post'] ) ) {
				if ( 'col-three-content-center' === $options['layout']['archive-post'] ) {
					$three_column_center = true;
				}
			}
		} elseif ( is_archive() && ! is_search() && ! is_author() ) {
			$current_post_type_info = lightning_get_post_type();
			$archive_post_types     = array( 'post' ) + $additional_post_types;
			foreach ( $archive_post_types as $archive_post_type ) {
				if ( isset( $options['layout'][ 'archive-' . $archive_post_type ] ) && $current_post_type_info['slug'] === $archive_post_type ) {
					if ( 'col-three-content-center' === $options['layout'][ 'archive-' . $archive_post_type ] ) {
						$three_column_center = true;
					}
				}
			}
		} elseif ( 'col-three-content-center' === lightning_layout_by_single() ) {
			$three_column_center = true;
		}
		return apply_filters( 'lightning_g3_is_layout_three_column_content_center', $three_column_center );
	}

	/**
	 * Lightning is 3 Column Content Right
	 */
	public static function lightning_is_layout_three_column_content_right() {
		$three_column_right = false;
		$options           = get_option( 'lightning_theme_options' );
		global $wp_query;

		$additional_post_types = get_post_types(
			array(
				'public'   => true,
				'_builtin' => false,
			),
			'names'
		);

		$array = self::lightning_layout_target_array();

		foreach ( $array as $key => $value ) {
			if ( call_user_func( $value['function'] ) ) {
				if ( isset( $options['layout'][ $key ] ) ) {
					if ( 'col-three-content-right' === $options['layout'][ $key ] ) {
						$three_column_right = true;
					}
				}
			}
		}

		if ( is_front_page() && ! is_home() ) {
			if ( isset( $options['layout']['front-page'] ) ) {
				if ( 'col-three-content-right' === $options['layout']['front-page'] ) {
					$three_column_right = true;
				}
			} elseif ( 'col-three-content-right' === lightning_layout_by_single() ) {
				$three_column_right = true;
			}
		} elseif ( is_front_page() && is_home() ) {
			if ( isset( $options['layout']['front-page'] ) ) {
				if ( 'col-three-content-right' === $options['layout']['front-page'] ) {
					$three_column_right = true;
				} elseif ( isset( $options['layout']['archive-post'] ) ) {
					if ( 'col-three-content-right' === $options['layout']['archive-post'] ) {
						$three_column_right = true;
					}
				}
			}
		} elseif ( ! is_front_page() && is_home() ) {
			if ( isset( $options['layout']['archive-post'] ) ) {
				if ( 'col-three-content-right' === $options['layout']['archive-post'] ) {
					$three_column_right = true;
				}
			}
		} elseif ( is_archive() && ! is_search() && ! is_author() ) {
			$current_post_type_info = lightning_get_post_type();
			$archive_post_types     = array( 'post' ) + $additional_post_types;
			foreach ( $archive_post_types as $archive_post_type ) {
				if ( isset( $options['layout'][ 'archive-' . $archive_post_type ] ) && $current_post_type_info['slug'] === $archive_post_type ) {
					if ( 'col-three-content-right' === $options['layout'][ 'archive-' . $archive_post_type ] ) {
						$three_column_right = true;
					}
				}
			}
		} elseif ( 'col-three-content-right' === lightning_layout_by_single() ) {
			$three_column_right = true;
		}
		return apply_filters( 'lightning_g3_is_layout_three_column_content_right', $three_column_right );
	}

	/**
	 * Lightning is 3 Column
	 */
	public static function lightning_is_layout_three_column() {
		$three_column_content_left   = self::lightning_is_layout_three_column_content_left();
		$three_column_content_center = self::lightning_is_layout_three_column_content_center();
		$three_column_content_right  = self::lightning_is_layout_three_column_content_right();
		return $three_column_content_left || $three_column_content_center || $three_column_content_right;
	}

	/**
	 * Lightning is 3 Column
	 */
	public static function lightning_is_set_three_column() {
		$three_column_set = false;

		$options = get_option( 'lightning_theme_options' );

		$three_column_content_left_posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'meta_key'       => '_lightning_design_setting',
				'meta_value'     => 'col-three-content-left',
				'meta_compare'   => 'LIKE',
			)
		);

		$three_column_content_center_posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_key'       => '_lightning_design_setting',
				'meta_value'     => 'col-three-content-center',
				'meta_compare'   => 'LIKE',
			)
		);

		$three_column_content_right_posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_key'       => '_lightning_design_setting',
				'meta_value'     => 'col-three-content-right',
				'meta_compare'   => 'LIKE',
			)
		);

		if ( ! empty( $three_column_content_left_posts ) ) {
			$three_column_set = true;
		} elseif ( ! empty( $three_column_content_center_posts ) ) {
			$three_column_set = true;
		} elseif ( ! empty( $three_column_content_right_posts ) ) {
			$three_column_set = true;
		}
		if ( ! empty( $options['layout'] ) ) {
			if ( in_array( 'col-three-content-left', $options['layout'], true ) ) {
				$three_column_set = true;
			} elseif ( in_array( 'col-three-content-center', $options['layout'], true ) ) {
				$three_column_set = true;
			} elseif ( in_array( 'col-three-content-right', $options['layout'], true ) ) {
				$three_column_set = true;
			}
		} else {
			$three_column_set = false;
		}
		return $three_column_set;

	}
}

new Lightning_G3_Three_Column_Unit_Condition();
