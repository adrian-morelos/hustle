<?php
/**
 * @var Opt_In_Admin $this
 * @var Object $args
 * @var Opt_In_Model $optin
 */

?>
<?php if( isset( $args->group ) ): $group = $args->group;

    $selected = array();
    $options = array();
    foreach( $group->interests as $interest ){
        $options[] = $interest->label;

        if( isset( $group->selected ) && in_array( $interest->value, (array) $group->selected ) )
            $selected[] = $interest->label;
    }
    ?>
<div id="wpoi-mailchimp-prev-group-args"  >
    <h3>
        <?php _e("Interest group:", Opt_In::TEXT_DOMAIN); ?>
    </h3>
    <p>
        <?php printf(  __("Name: %s", Opt_In::TEXT_DOMAIN ),  $group->title ) ; ?>
    </p>
    <ul>
        <li>
            <?php printf( __("<strong>Type:</strong> %s", Opt_In::TEXT_DOMAIN), ucfirst( $group->type ) ); ?>
        </li>
        <li>
            <?php printf( __("<strong>Options:</strong> %s", Opt_In::TEXT_DOMAIN), implode(", ", $options) ); ?>
        </li>
        <li>
            <?php printf( __("<strong>Selected:</strong> %s", Opt_In::TEXT_DOMAIN), implode(", ", $selected) ); ?>
        </li>
    </ul>


</div>
<?php endif; ?>


