<script id="wpoi-social-sharing-services-tpl" type="text/template">
    
    <div id="wph-sshare--name" class="row">
			
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            
            <h5><?php _e('Name & Icons', Opt_In::TEXT_DOMAIN); ?></h5>
            
        </div>
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            
            <label class="wph-label--border"><?php _e('Choose a name for this module.', Opt_In::TEXT_DOMAIN); ?></label>
            
            <input type="text" placeholder="<?php _e('Enter social group name...', Opt_In::TEXT_DOMAIN); ?>" data-attribute="optin_name" value="{{optin_name}}" />
            
        </div>
        
    </div><!-- #wph-sshare--name -->
    
    <div id="wph-sshare--behav" class="row">
        
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            
            <label class="wph-label--border"><?php _e('Select the type of social icons & their behaviour', Opt_In::TEXT_DOMAIN); ?></label>
            
            <p><?php _e('Native actions are actions that are native to the service. e.g. share on Facebook, Twitter etc. Linked icon simply provide you with provide you Icons for a variety of services and allows you to set your own links.', Opt_In::TEXT_DOMAIN); ?></p>
            
            <div class="tabs">
                
                <ul class="tabs-header wph-ss-service-type">
                    
                    <li {{_.add_class(service_type === "native", "current" )}}>
                        
                        <label for="wph-sshare-native-share">
                            
                            <?php _e('Native Share', Opt_In::TEXT_DOMAIN); ?>
                            
                            <input type="radio" id="wph-sshare-native-share" name="wph-sshare-icon-behav" data-attribute="service_type" value="native" {{_.checked(service_type, "native")}} />
                            
                        </label>
                        
                    </li>
                    
                    <li {{_.add_class(service_type === "linked", "current" )}}>
                        
                        <label for="wph-sshare-linked-icons">
                            
                            <?php _e('Linked Icons', Opt_In::TEXT_DOMAIN); ?>
                            
                            <input type="radio" id="wph-sshare-linked-icons" name="wph-sshare-icon-behav" data-attribute="service_type" value="linked" {{_.checked(service_type, "linked")}} />
                            
                        </label>
                        
                    </li>
                    
                </ul>
                
            </div>
            
            <# if( service_type === "native" ) {  #>
                
                <div class="wph-sshare-counter">
                    
                    <label class="wph-label--alt">
                        
                        <span><?php _e('Enable Click Counter', Opt_In::TEXT_DOMAIN); ?></span>
                        
                        <small><?php _e('Shows number of times social icon has been clicked. Note, counter not linked to actual service.', Opt_In::TEXT_DOMAIN); ?></small>
                        
                    </label>
                    
                    <span class="toggle">
                        
                        <input id="wph-sshare-enable-counter" class="toggle-checkbox" type="checkbox" value="1" name="click_counter" data-attribute="click_counter" {{_.checked(click_counter, "1")}}>
                        
                        <label class="toggle-label" for="wph-sshare-enable-counter"></label>
                        
                    </span>
                    
                </div>
                
            <# } #>
            
        </div>
        
    </div><!-- #wph-sshare--behav -->
    
    <div id="wph-sshare--social_icons" class="row {{_.class(service_type === 'linked', 'linked-icons-enabled')}}">
        
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            
            <# if( service_type === "native" ) {  #>
                
                <label class="wph-label--border"><?php _e('Pick social icons & set their default counter values', Opt_In::TEXT_DOMAIN); ?></label>
            
            <# } else if( service_type === "linked" ) { #>
                
                <label class="wph-label--border"><?php _e('Pick social icons & set URLs for them', Opt_In::TEXT_DOMAIN); ?></label>
                
            <# } #>
            
            <div class="wph-sshare--pick_social_icons {{_.class(service_type === 'native', 'wph-sshare--native_share')}}{{_.class(service_type === 'linked', 'wph-sshare--linked_icons')}}">
                
                <div class="wph-sshare--social_{{service_type}}">
                    
                    <# if( service_type === "linked" ) {  #><div class="wph-sshare--social_wrap"><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--toggle_wrap"><# } #>
                            
                            <span class="toggle">
                                
                                <input id="wph-sshare-enable-fb" class="toggle-checkbox wph-share-icon-enable" type="checkbox" value="1" name="facebook_enable" {{ ( typeof social_icons.facebook == 'undefined' ) ? '' : _.checked(social_icons.facebook.enabled, 'true') }} >
                                
                                <label class="toggle-label" for="wph-sshare-enable-fb"></label>
                                
                            </span>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--icon_wrap"><# } #>
                            
                            <div class="wph-sshare--icon {{ ( typeof social_icons.facebook == 'undefined' ) ? 'disabled' : '' }}" data-id="facebook">
	                            
	                            <?php $this->render("general/icons/social/wph-facebook"); ?>
	                            
                            </div>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "native" ) {  #>
                            
                            <div class="wph-input--number {{ ( typeof social_icons.facebook == 'undefined' || click_counter == '0' ) ? 'disabled' : '' }}">
                                
                                <input type="number" min="0" max="500" step="1" value="{{ ( typeof social_icons.facebook == 'undefined' ) ? '0' : social_icons.facebook.counter }}" data-attribute="">
                                
                            </div>
                            
                        <# } else if( service_type === "linked" ) {  #>
                            
                            <div class="wph-sshare--input_wrap {{ ( typeof social_icons.facebook == 'undefined' ) ? 'disabled' : '' }}">
                                
                                <input type="url" placeholder="<?php _e('Type URL here...', Opt_In::TEXT_DOMAIN); ?>" value="{{ ( typeof social_icons.facebook == 'undefined' ) ? '' : social_icons.facebook.link }}">
                                
                            </div>
                            
                        <# } #>
                        
                    <# if( service_type === "linked" ) {  #></div><# } #>
                    
                </div><?php // Facebook ?>
                
                <div class="wph-sshare--social_{{service_type}}">
                    
                    <# if( service_type === "linked" ) {  #><div class="wph-sshare--social_wrap"><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--toggle_wrap"><# } #>
                            
                            <span class="toggle">
                                
                                <input id="wph-sshare-enable-tw" class="toggle-checkbox wph-share-icon-enable" type="checkbox" value="1" name="" {{ ( typeof social_icons.twitter == 'undefined' ) ? '' : _.checked(social_icons.twitter.enabled, 'true') }} >
                                
                                <label class="toggle-label" for="wph-sshare-enable-tw"></label>
                                
                            </span>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--icon_wrap"><# } #>
                            
                            <div class="wph-sshare--icon {{ ( typeof social_icons.twitter == 'undefined' ) ? 'disabled' : '' }}" data-id="twitter">
	                            
	                            <?php $this->render("general/icons/social/wph-twitter"); ?>
	                            
                            </div>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "native" ) {  #>
                            
                            <div {{click_counter}} class="wph-input--number {{ ( typeof social_icons.twitter == 'undefined' || click_counter == '0' ) ? 'disabled' : '' }}">
                                
                                <input type="number" min="0" max="500" step="1" value="{{ ( typeof social_icons.twitter == 'undefined' ) ? '0' : social_icons.twitter.counter }}" data-attribute="">
                                
                            </div>
                            
                        <# } else if( service_type === "linked" ) {  #>
                            
                            <div class="wph-sshare--input_wrap {{ ( typeof social_icons.twitter == 'undefined' ) ? 'disabled' : '' }}">
                                
                                <input type="url" placeholder="<?php _e('Type URL here...', Opt_In::TEXT_DOMAIN); ?>" value="{{ ( typeof social_icons.twitter == 'undefined' ) ? '' : social_icons.twitter.link }}">
                                
                            </div>
                            
                        <# } #>
                        
                    <# if( service_type === "linked" ) {  #></div><# } #>
                    
                </div><?php // Twitter ?>
                
                <div class="wph-sshare--social_{{service_type}}">
                    
                    <# if( service_type === "linked" ) {  #><div class="wph-sshare--social_wrap"><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--toggle_wrap"><# } #>
                            
                            <span class="toggle">
                                
                                <input id="wph-sshare-enable-gg" class="toggle-checkbox wph-share-icon-enable" type="checkbox" value="1" name="" {{ ( typeof social_icons.google == 'undefined' ) ? '' : _.checked(social_icons.google.enabled, 'true') }} >
                                
                                <label class="toggle-label" for="wph-sshare-enable-gg"></label>
                                
                            </span>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--icon_wrap"><# } #>
                            
                            <div class="wph-sshare--icon {{ ( typeof social_icons.google == 'undefined' ) ? 'disabled' : '' }}" data-id="google">
	                            
	                            <?php $this->render("general/icons/social/wph-google"); ?>
	                            
                            </div>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "native" ) {  #>
                            
                            <div class="wph-input--number {{ ( typeof social_icons.google == 'undefined' || click_counter == '0' ) ? 'disabled' : '' }}">
                                
                                <input type="number" min="0" max="500" step="1" value="{{ ( typeof social_icons.google == 'undefined' ) ? '0' : social_icons.google.counter }}" data-attribute="">
                                
                            </div>
                            
                        <# } else if( service_type === "linked" ) {  #>
                            
                            <div class="wph-sshare--input_wrap {{ ( typeof social_icons.google == 'undefined' ) ? 'disabled' : '' }}">
                                
                                <input type="url" placeholder="<?php _e('Type URL here...', Opt_In::TEXT_DOMAIN); ?>" value="{{ ( typeof social_icons.google == 'undefined' ) ? '' : social_icons.google.link }}">
                                
                            </div>
                            
                        <# } #>
                        
                    <# if( service_type === "linked" ) {  #></div><# } #>
                    
                </div><?php // Google Plus ?>
                
                <div class="wph-sshare--social_{{service_type}}">
                    
                    <# if( service_type === "linked" ) {  #><div class="wph-sshare--social_wrap"><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--toggle_wrap"><# } #>
                            
                            <span class="toggle">
                                
                                <input id="wph-sshare-enable-pn" class="toggle-checkbox wph-share-icon-enable" type="checkbox" value="1" name="" {{ ( typeof social_icons.pinterest == 'undefined' ) ? '' : _.checked(social_icons.pinterest.enabled, 'true') }} >
                                
                                <label class="toggle-label" for="wph-sshare-enable-pn"></label>
                                
                            </span>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--icon_wrap"><# } #>
                            
                            <div class="wph-sshare--icon {{ ( typeof social_icons.pinterest == 'undefined' ) ? 'disabled' : '' }}" data-id="pinterest">
	                            
	                            <?php $this->render("general/icons/social/wph-pinterest"); ?>
	                            
                            </div>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "native" ) {  #>
                            
                            <div class="wph-input--number {{ ( typeof social_icons.pinterest == 'undefined' || click_counter == '0' ) ? 'disabled' : '' }}">
                                
                                <input type="number" min="0" max="500" step="1" value="{{ ( typeof social_icons.pinterest == 'undefined' ) ? '0' : social_icons.pinterest.counter }}" data-attribute="">
                                
                            </div>
                            
                        <# } else if( service_type === "linked" ) {  #>
                            
                            <div class="wph-sshare--input_wrap {{ ( typeof social_icons.pinterest == 'undefined' ) ? 'disabled' : '' }}">
                                
                                <input type="url" placeholder="<?php _e('Type URL here...', Opt_In::TEXT_DOMAIN); ?>" value="{{ ( typeof social_icons.pinterest == 'undefined' ) ? '' : social_icons.pinterest.link }}">
                                
                            </div>
                            
                        <# } #>
                        
                    <# if( service_type === "linked" ) {  #></div><# } #>
                    
                </div><?php // Pinterest ?>
                
                <div class="wph-sshare--social_{{service_type}}">
                    
                    <# if( service_type === "linked" ) {  #><div class="wph-sshare--social_wrap"><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--toggle_wrap"><# } #>
                            
                            <span class="toggle">
                                
                                <input id="wph-sshare-enable-rd" class="toggle-checkbox wph-share-icon-enable" type="checkbox" value="1" name="" {{ ( typeof social_icons.reddit == 'undefined' ) ? '' : _.checked(social_icons.reddit.enabled, 'true') }} >
                                
                                <label class="toggle-label" for="wph-sshare-enable-rd"></label>
                                
                            </span>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--icon_wrap"><# } #>
                            
                            <div class="wph-sshare--icon {{ ( typeof social_icons.reddit == 'undefined' ) ? 'disabled' : '' }}" data-id="reddit">
	                            
	                            <?php $this->render("general/icons/social/wph-reddit"); ?>
	                            
                            </div>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "native" ) {  #>
                            
                            <div class="wph-input--number {{ ( typeof social_icons.reddit == 'undefined' || click_counter == '0' ) ? 'disabled' : '' }}">
                                
                                <input type="number" min="0" max="500" step="1" value="{{ ( typeof social_icons.reddit == 'undefined' ) ? '0' : social_icons.reddit.counter }}" data-attribute="">
                                
                            </div>
                            
                        <# } else if( service_type === "linked" ) {  #>
                            
                            <div class="wph-sshare--input_wrap {{ ( typeof social_icons.reddit == 'undefined' ) ? 'disabled' : '' }}">
                                
                                <input type="url" placeholder="<?php _e('Type URL here...', Opt_In::TEXT_DOMAIN); ?>" value="{{ ( typeof social_icons.reddit == 'undefined' ) ? '' : social_icons.reddit.link }}">
                                
                            </div>
                            
                        <# } #>
                        
                    <# if( service_type === "linked" ) {  #></div><# } #>
                    
                </div><?php // Reddit ?>
                
                <div class="wph-sshare--social_{{service_type}}">
                    
                    <# if( service_type === "linked" ) {  #><div class="wph-sshare--social_wrap"><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--toggle_wrap"><# } #>
                            
                            <span class="toggle">
                                
                                <input id="wph-sshare-enable-ln" class="toggle-checkbox wph-share-icon-enable" type="checkbox" value="1" name="" {{ ( typeof social_icons.linkedin == 'undefined' ) ? '' : _.checked(social_icons.linkedin.enabled, 'true') }} >
                                
                                <label class="toggle-label" for="wph-sshare-enable-ln"></label>
                                
                            </span>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--icon_wrap"><# } #>
                            
                            <div class="wph-sshare--icon {{ ( typeof social_icons.linkedin == 'undefined' ) ? 'disabled' : '' }}" data-id="linkedin">
	                            
	                            <?php $this->render("general/icons/social/wph-linkedin"); ?>
	                            
                            </div>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "native" ) {  #>
                            
                            <div class="wph-input--number {{ ( typeof social_icons.linkedin == 'undefined' || click_counter == '0' ) ? 'disabled' : '' }}">
                                
                                <input type="number" min="0" max="500" step="1" value="{{ ( typeof social_icons.linkedin == 'undefined' ) ? '0' : social_icons.linkedin.counter }}" data-attribute="">
                                
                            </div>
                            
                        <# } else if( service_type === "linked" ) {  #>
                            
                            <div class="wph-sshare--input_wrap {{ ( typeof social_icons.linkedin == 'undefined' ) ? 'disabled' : '' }}">
                                
                                <input type="url" placeholder="<?php _e('Type URL here...', Opt_In::TEXT_DOMAIN); ?>" value="{{ ( typeof social_icons.linkedin == 'undefined' ) ? '' : social_icons.linkedin.link }}">
                                
                            </div>
                            
                        <# } #>
                        
                    <# if( service_type === "linked" ) {  #></div><# } #>
                    
                </div><?php // Linkedin ?>
                
                <div class="wph-sshare--social_{{service_type}}">
                    
                    <# if( service_type === "linked" ) {  #><div class="wph-sshare--social_wrap"><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--toggle_wrap"><# } #>
                            
                            <span class="toggle">
                                
                                <input id="wph-sshare-enable-kt" class="toggle-checkbox wph-share-icon-enable" type="checkbox" value="1" name="" {{ ( typeof social_icons.vkontakte == 'undefined' ) ? '' : _.checked(social_icons.vkontakte.enabled, 'true') }} >
                                
                                <label class="toggle-label" for="wph-sshare-enable-kt"></label>
                                
                            </span>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "linked" ) {  #><div class="wph-sshare--icon_wrap"><# } #>
                            
                            <div class="wph-sshare--icon {{ ( typeof social_icons.vkontakte == 'undefined' ) ? 'disabled' : '' }}" data-id="vkontakte">
	                            
	                            <?php $this->render("general/icons/social/wph-vkontakte"); ?>
	                            
                            </div>
                            
                        <# if( service_type === "linked" ) {  #></div><# } #>
                        
                        <# if( service_type === "native" ) {  #>
                            
                            <div class="wph-input--number {{ ( typeof social_icons.vkontakte == 'undefined' || click_counter == '0' ) ? 'disabled' : '' }}">
                                
                                <input type="number" min="0" max="500" step="1" value="{{ ( typeof social_icons.vkontakte == 'undefined' ) ? '0' : social_icons.vkontakte.counter }}" data-attribute="">
                                
                            </div>
                            
                        <# } else if( service_type === "linked" ) {  #>
                            
                            <div class="wph-sshare--input_wrap {{ ( typeof social_icons.vkontakte == 'undefined' ) ? 'disabled' : '' }}">
                                
                                <input type="url" placeholder="<?php _e('Type URL here...', Opt_In::TEXT_DOMAIN); ?>" value="{{ ( typeof social_icons.vkontakte == 'undefined' ) ? '' : social_icons.vkontakte.link }}">
                                
                            </div>
                            
                        <# } #>
                        
                    <# if( service_type === "linked" ) {  #></div><# } #>
                    
                </div><?php // VK ?>
                
            </div>
            
        </div>
        
    </div><?php // #wph-sshare--default_icons ?>
    
</script>

<div id="wph-social-sharing--services_tab" class="wph-toggletabs <?php echo ( !isset( $_GET['tab'] ) ) ?  'wph-toggletabs--open' : ''; ?>">
	
	<header class="wph-toggletabs--title can-open">
		
		<h4><?php _e('Name & Services', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<span class="open"><i class="wph-icon i-arrow"></i></span>
		
	</header>
	
	<section class="wph-toggletabs--content">
    
	</section>
	
	<footer class="wph-toggletabs--footer">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button class="wph-button ss-cancel wph-button--filled wph-button--gray" ><?php _e('Cancel', Opt_In::TEXT_DOMAIN); ?></button>
				
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_social_sharing_save'); ?>" class="wph-button ss-save-changes wph-button-save wph-button--filled wph-button--blue" >
					
					<span class="off-action"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
				<button data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_social_sharing_save'); ?>" class="wph-button ss-next-step wph-button--filled wph-button--gray" >
					
					<span class="off-action"><?php _e('Next Step', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
			</div>
			
		</div>
		
	</footer>
	
</div><?php // #wph-social-sharing--services_tab ?>

<?php $this->render("admin/common/media-holder"); ?>

