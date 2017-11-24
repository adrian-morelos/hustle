<?php


class Hustle_Dashboard_Data
{
    var $optins = array();
    var $custom_contents = array();
    var $social_sharing = array();
    var $data_exists = false;

    var $active_modules = 0;
    var $active_optin_modules = array();
    var $inactive_optin_modules = array();
    var $active_cc_modules = array();
    var $inactive_cc_modules = array();
    var $all_modules = 0;

    var $conversions_today = 0;
    var $most_converted_optin = '-';

    var $has_optins = false;
    var $has_custom_content = false;
    var $has_social_sharing = false;
    var $has_social_rewards = true; // set to true just to avoid showing it in the dashboard as this is not a feature for 2.0

    var $optins_conversions = array();

    var $color = 0;
    var $types = array();
    var  $colors = array(
		'#FF0000',
		'#FFFF00',
		'#00EAFF',
		'#AA00FF',
		'#FF7F00',
		'#BFFF00',
		'#0095FF',
		'#FF00AA',
		'#FFD400',
		'#6AFF00',
		'#0040FF',
		'#EDB9B9',
		'#B9D7ED',
		'#E7E9B9',
		'#DCB9ED',
		'#B8EDE0',
		'#8F2323',
		'#2362BF',
		'#8F6A23',
		'#6B238F',
		'#4F8F23',
		'#000000',
    );

    var  $conversion_data;
    var $ss_share_stats_data = array();
    var $ss_total_share_stats = 0;

    function __construct()
    {
        $this->_prepare_data();
        $this->has_optins = $this->optins !== array();
    }

    private function _prepare_data(){
        $opt_col_instance = Opt_In_Collection::instance();
        $cc_col_instance = Hustle_Custom_Content_Collection::instance();
        $ss_col_instance = Hustle_Social_Sharing_Collection::instance();

        $this->optins = $opt_col_instance->get_all_optins( null, array() );
        $this->all_modules = count( $this->optins );

        $this->custom_contents = $cc_col_instance->get_all( null );
        $this->all_modules += count( $this->custom_contents );
        
        $this->social_sharing = $ss_col_instance->get_all( null );
        if ( count($this->social_sharing) > 0 ) {
            $this->has_social_sharing = true;
            $this->ss_share_stats_data = $ss_col_instance->get_share_stats(0,5);
            $this->ss_total_share_stats = $ss_col_instance->get_total_share_stats();
        }

        $this->types = $types = array(
            'after_content' => __('AFTER CONTENT', Opt_In::TEXT_DOMAIN),
            'popup' => __('Pop-up', Opt_In::TEXT_DOMAIN),
            'slide_in' => __('Slide-in', Opt_In::TEXT_DOMAIN),
            'shortcode' => __('Shortcode', Opt_In::TEXT_DOMAIN),
            'widget' => __('Widget', Opt_In::TEXT_DOMAIN)
        );

		$active_optins = array();
		$end_day = strtotime( 'now' );
		$first_day = strtotime( "-1 month" );
		$last_week = $end_day - WEEK_IN_SECONDS;
		$first_month = date( 'Ymd', $first_day );
		$last_month = date( 'Ymd', $end_day );
		$most_conversions = array();
        $merged_optins = array_merge( $this->optins, $this->custom_contents );

        foreach ( $merged_optins as $key => $optin ) {

            if( $optin->active ){
                $this->active_modules++;
				if ( $optin->get_module_type() === "custom_content" ) {
					array_push($this->active_cc_modules, $optin);
				} else {
                    array_push($this->active_optin_modules, $optin);
                }
            } else {
				if ( $optin->get_module_type() === "custom_content" ) {
					array_push($this->inactive_cc_modules, $optin);
				} else {
					array_push($this->inactive_optin_modules, $optin);
				}
                continue;
            }

			$daily_chart = array();
			$has_today = false;
			$has_firstday = false;
            foreach ( $types as $type_key => $type ) {
                if( !$optin->has_type( $type_key ) ) continue; // make sure this module has the type
                
                if ( $optin->get_module_type() === 'custom_content' ) {
                    $type_stats = $optin->get_stats($type_key);
                } elseif( $optin->get_module_type() === 'optin' ) {
                    $type_stats = $optin->{$type_key};
                } else {
                    $type_stats = $optin->get_statistics($type_key);
                }

                if ( !$this->data_exists && intval( $type_stats->views_count ) > 0 ) {
                    $this->data_exists = true;
                }

                $conversion_array = $type_stats->conversion_data;

                if( !isset( $this->optins_conversions[ $optin->optin_name ] ) ) {
					$active_optins[ $optin->optin_name ] = $optin;

                    $this->optins_conversions[ $optin->optin_name ] = array(
                        'week' => 0,
                        'month' => 0,
                        'all' => 0,
                        'total_views' => 0,
                        'rate' => 0.0,
                        'chart_data' => array(),
                        'color' => '',
                        "module_type" => $optin->module_type
                    );

                }

                foreach ( $conversion_array as $item ) {

                    $conversion_data = json_decode( $item->meta_value );
					$datetime = $conversion_data->date;
					$month = date( 'Ymd', $datetime );
					$day = date( 'Ymd', $datetime );

					if ( $month >= $first_month && $month <= $last_month ) {
						$this->optins_conversions[ $optin->optin_name ]['month']++;

						if ( $datetime >= $last_week ) {
							$this->optins_conversions[ $optin->optin_name ]['week']++;
						}

						$daily = date( 'Ymd', $datetime );
						$offset = array( 'x' => $datetime * 1000, 'y' => 1 );

						if ( isset( $daily_chart[ $daily ] ) ) {
							$daily_chart[ $daily ]['y']++;
						} else {
							$daily_chart[ $daily ] = $offset;
						}

						if ( date( 'Ymd', $first_day ) == $day ) {
							$has_firstday = true;
						}

						if ( $day == date( 'Ymd', $end_day ) ) {
							$has_today = true;
							$this->conversions_today++;
						}
					}

					if ( ! isset( $most_conversions[ $optin->optin_name ] ) ) {
						$most_conversions[ $optin->optin_name ] = 0;
					}
					$most_conversions[ $optin->optin_name ]++;

                    $this->optins_conversions[ $optin->optin_name ]['all']++;

                }

                $this->optins_conversions[ $optin->optin_name ]['total_views'] += $type_stats->views_count;

            }

			$daily_chart = array_filter( array_values( $daily_chart ) );
			// Set the beginning date if no beginning date found
			if ( ! $has_firstday ) {
				array_unshift( $daily_chart, array( 'x' => $first_day * 1000, 'y' => 0 ) );
			}

			$this->optins_conversions[ $optin->optin_name ]['chart_data'] = $daily_chart;

            $this->optins_conversions[ $optin->optin_name ]['rate'] = $this->optins_conversions[ $optin->optin_name ]['total_views'] ? round( ( $this->optins_conversions[ $optin->optin_name ]['all'] / $this->optins_conversions[ $optin->optin_name ]['total_views'] ) * 100, 2 ) : 0;
        }

		if ( ! empty( $most_conversions ) ) {
			$values = array_values( $most_conversions );
			$max = max( $values );
			$this->most_converted_optin = array_search( $max, $most_conversions );
		}
		// Sort conversions per month
		uasort( $this->optins_conversions, array( __CLASS__, 'uasort' ) );
		$data = array_reverse( $this->optins_conversions, true );

		$best_optins = array();
		$amount = 1;
		$this->color = (int) get_option( 'hustle_color_index', 0 );

		foreach ( $data as $optin_name => $conversions ) {
			if ( $amount > 5 ) continue;

			if( $this->color >= count( $this->colors ) ) $this->color = 0;

			$optin = $active_optins[ $optin_name ];
			$color = $optin->get_meta( 'graph_color' );

			if ( empty( $color ) ) {
				$color = $this->colors[ $this->color ];
				$optin->update_meta( 'graph_color', $color );
				$this->color++;
			}

			$conversions['color'] = $color;
			$best_optins[ $optin_name ] = $conversions;
			$amount++;
		}
		// Update color index
		update_option( 'hustle_color_index', $this->color );
		$this->conversion_data = $best_optins;
    }

	public static function uasort( $a, $b ) {
		if ( $a['month'] == $b['month'] ) {
			return 0;
		} elseif ( $a['month'] > $b['month'] ) {
			return 1;
		} else {
			return -1;
		}
	}
}