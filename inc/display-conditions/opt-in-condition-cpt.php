<?php

class Opt_In_Condition_Cpt extends Opt_In_Condition_Abstract implements Opt_In_Condition_Interface
{
    function is_allowed(Hustle_Model $optin){
        global $post;
		
		if ( !isset( $this->args->selected_cpts ) || empty( $this->args->selected_cpts ) ) {
			if ( !isset($this->args->filter_type) || $this->args->filter_type == "except" ) {
				return true;
			} else {
				return false;
			}
		} elseif ( in_array("all", $this->args->selected_cpts) ) {
			if ( !isset($this->args->filter_type) || $this->args->filter_type == "except" ) {
				return false;
			} else {
				return true;
			}
		}

        switch( $this->args->filter_type ){
            case  "only":
                if( !isset( $post ) || !( $post instanceof WP_Post ) || $post->post_type !== $this->args->post_type ) return false;

				return in_array( $post->ID, (array) $this->args->selected_cpts );

                break;
            case "except":
                if( !isset( $post ) || !( $post instanceof WP_Post ) || $post->post_type !== $this->args->post_type ) return true;

                return !in_array( $post->ID, (array) $this->args->selected_cpts );

                break;

            default:
                return true;
                break;
        }
    }


    function label(){
		$post_type_label = ( isset( $this->args->post_type_label ) )
			? strtolower( $this->args->post_type_label )
			: "";
		if ( isset( $this->args->selected_cpts ) && !empty( $this->args->selected_cpts ) ) {
			$total = count($this->args->selected_cpts);
			switch( $this->args->filter_type ){
				case  "only":
					return ( in_array("all", $this->args->selected_cpts) ) 
						? __("All ", Opt_In::TEXT_DOMAIN) . $post_type_label
						: sprintf( __("%d %s", Opt_In::TEXT_DOMAIN), $total, $post_type_label );
					break;
				case "except":
					return ( in_array("all", $this->args->selected_cpts) )
						? __("No ", Opt_In::TEXT_DOMAIN) . $post_type_label
						: sprintf( __("All %s except %d", Opt_In::TEXT_DOMAIN), $total, $post_type_label );
					break;

				default:
					return null;
					break;
			}
		} else {
			return ( !isset($this->args->filter_type) || $this->args->filter_type == "except" ) 
				? __("All ", Opt_In::TEXT_DOMAIN) . $post_type_label
				: __("No ", Opt_In::TEXT_DOMAIN) . $post_type_label;
		}
    }
}