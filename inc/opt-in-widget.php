<?php

/**
 * Class Opt_In_Widget
 */
class Opt_In_Widget extends WP_Widget {

    /**
     * @var string Widget Id
     */
    const Widget_Id = "inc_opt_widget";


    /**
     * Registers the widget
     */
    function __construct() {
        parent::__construct(
            self::Widget_Id,
            __( 'Hustle', Opt_In::TEXT_DOMAIN ),
            array( 'description' => __( 'A widget to add Opt-ins', Opt_In::TEXT_DOMAIN ), )
        );
    }



    /**
     *
     * Front-end display of widget.
     *
     * @param array $args
     * @param array $instance Previously saved values from database.
     * @return string
     */
    public function widget( $args, $instance ) {

        if( empty( $instance['optin_id'] ) ){

            echo $args['before_widget'];

            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
            }
            _e("Select Opt-in", Opt_In::TEXT_DOMAIN);

            echo $args['after_widget'];

            return;
        }



        $optin = Opt_In_Model::instance()->get( $instance['optin_id'] );

        if( !$optin->settings->widget->show_in_front() ){
            echo $args['before_widget'];
            echo $args['after_widget'];
            return;
        }

        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        
        $widget_css_class = Opt_In_Front::Widget_CSS_CLass;
        if ( $optin->optin_provider == 'social_sharing' ) {
            $widget_css_class = Hustle_Social_Sharing_Front::Widget_CSS_CLass;
        } elseif ( $optin->optin_provider == 'custom_content' ) {
            $widget_css_class = Hustle_Custom_Content_Front::Widget_CSS_CLass;
        }
        
        ?>
        
        <div class="<?php echo $widget_css_class; ?> inc_optin_<?php echo esc_attr( $instance['optin_id'] ); ?>" data-id="<?php echo esc_attr( $instance['optin_id'] ); ?>"></div>
        <?php

        echo $args['after_widget'];
    }


    /**
     *
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     * @param array $instance Previously saved values from database.
     *
     * @return void
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
        if( empty( $instance['optin_id'] ) ) $instance['optin_id'] = -1;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', Opt_In::TEXT_DOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'optin_id' ); ?>"><?php _e( 'Select Opt-in:', Opt_In::TEXT_DOMAIN ); ?></label>
            <select name="<?php echo $this->get_field_name( 'optin_id' ); ?>" id="inc_opt_optin_id">
                <option value=""><?php _e("Select Opt-in", Opt_In::TEXT_DOMAIN); ?></option>
                <?php foreach( Opt_In_Collection::instance()->get_all_id_names() as $opt ) :
                    $optin = Opt_In_Model::instance()->get( $opt->optin_id );
                        if( $optin->settings->widget->show_in_front() ):
                    ?>
                    <option <?php selected( $instance['optin_id'],  $opt->optin_id); ?> value="<?php echo esc_attr( $opt->optin_id ) ?>"><?php echo esc_attr( $opt->optin_name ); ?></option>

                <?php
                        endif;
                        endforeach; ?>
            </select>
        </p>
        <?php
    }


    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] =  ! empty( $new_instance['title'] )  ? strip_tags( $new_instance['title'] ) : '';
        $instance['optin_id'] =  ! empty( $new_instance['optin_id'] )  ? strip_tags( $new_instance['optin_id'] ) : '';

        return $instance;
    }

}