<script id="hustle-modal-tpl" type="text/template">
	
	<div id="wph-modal-{{type}}--{{id}}" class="wph-modal {{custom_size_class}} wph-modal-container <# if ( customize_css ) { #>wph-customize-css<# } #> wph-slide--{{position}} wph-modal--{{style}} wph-modal--{{type}} wph-modal--{{id}} {{animation_in}} {{fullscreen}}" {{custom_size_attr}}>
		
		<# if ( ( style === "simple" || style === "minimal" ) && ( type === "popup" || type === "slide_in" ) ){ #>
			
			<div class="wph-modal--close"><a class="wph-icon i-close" href=""></a></div>
			
		<# } #>
		
		<div class='wph-modal--content<# if(image && style === "simple" ){ #> wph-modal--image_{{image_position}}<# } #><# if( !optin_title && !subtitle && style !== "simple" ){ #> wph-modal--noheader<# } #><# if( (!cta_label || !cta_url) && style === "minimal" ) { #> wph-modal--nofooter<# } #>'>
			
			<# if ( image && style === "simple" ){ #>
				
				<figure class='wph-modal--image<# if( ( !cta_label || !cta_url ) && !optin_message && !optin_title && !subtitle && style === "simple" ) { #>_full<# } #>{{_.class( _.isTrue( hide_image_on_mobile ), " mobile-hidden" )}}'>
					
					<img src="{{image}}">
				
				</figure>
				
			<# } #>
			
			<# if ( style === "simple" ){ #>
				
				<div class='wph-modal--wrap{{_.class( !optin_title && !subtitle && !optin_message && ( !cta_label || !cta_url ) && !_.isTrue( types[type].add_never_see_link ) && style === "simple", " hidden" )}}'>
				
			<# } #>
				
				<# if ( optin_title || subtitle || ( style === "cabriolet" && ( type === "popup" || type === "slide_in" ) && ( !optin_title && !subtitle ) ) || ( style === "cabriolet" && ( optin_title || subtitle ) ) ){ #>
					
					<header<# if ( ( !cta_label || !cta_url ) && !_.isTrue( types[type].add_never_see_link ) && !optin_message && style === "simple"){ #> class="wph-modal--nocontent"<# } #><# if ( ( !optin_title && !subtitle ) && style === "cabriolet" ){ #> class="wph-modal--nocontent"<# } #>>
						
						<# if ( optin_title ){ #>
							
							<h2 class="wph-modal--title">{{optin_title}}</h2>
							
						<# } #>
						
						<# if ( subtitle ){ #>
							
							<h4 class="wph-modal--subtitle">{{subtitle}}</h4>
							
						<# } #>
						
						<# if ( style === "cabriolet" && ( type === "popup" || type === "slide_in" ) ){ #>
							
							<div class="wph-modal--close"><a class="wph-icon i-close" href=""></a></div>
							
						<# } #>
						
					</header>
					
				<# } #>
				
				<# if ( ( ( image || optin_message || ( cta_label && cta_url ) || _.isTrue( types[type].add_never_see_link ) ) && style === "cabriolet" ) || ( ( image || optin_message ) && style === "minimal" ) || ( ( optin_message || ( cta_label && cta_url ) || _.isTrue( types[type].add_never_see_link ) ) && style === "simple" ) ){ #>
					
					<section<# if(image && style !== "simple" ) { #> class="wph-modal--image_{{image_position}}"<# } #>>
						
						<# if ( image && style !== "simple" ){ #>
							
							<figure class='wph-modal--image<# if ( (!optin_message && style === "minimal") ) { #>_full<# } #><# if( (!cta_label || !cta_url) && !optin_message && style === "cabriolet" ) { #>_full<# } #>{{_.class( _.isTrue( hide_image_on_mobile ), " mobile-hidden" )}}'>
								
								<img src="{{image}}">
								
							</figure>
							
						<# } #>
						
						<div class='wph-modal--message<# if ( ( !optin_message && style === "minimal" ) || ( !optin_message && ( !cta_label || !cta_url ) && !_.isTrue( types[type].add_never_see_link ) && style !== "minimal" ) ){ #> hidden<# } #>'>
							
							<# if ( optin_provider === "custom_content" ){ #>
							
								{{{content}}}
							
							<# } else { #>
							
								{{{optin_message}}}
								
							<# } #>
							
							<# if ( ( ( cta_label && cta_url ) || _.isTrue( types[type].add_never_see_link ) ) && style !== "minimal" ){ #>
								
								<div class="wph-modal--clear">
									
									<# if ( cta_label && cta_url ){ #>
										
										<a href="{{cta_url}}" target="{{cta_target}}" class="wph-modal--cta">{{cta_label}}</a>
									
									<# } #>
									
									<# if ( _.isTrue( types[type].add_never_see_link ) ){ #>
										
										<a href="#0" class="wph-modal-never-see-again" ><?php _e("Never see this message again", Opt_In::TEXT_DOMAIN); ?></a>
									
									<# } #>
									
								</div>
								
							<# } #>
							
						</div>
						
					</section>
					
				<# } #>
				
			<# if ( style === "simple" ){ #>
				
				</div>
				
			<# } #>
			
			<# if ( ( (cta_label && cta_url) || _.isTrue( types[type].add_never_see_link ) ) && style === "minimal" ) { #>
			
				<footer<# if (_.isTrue( types[type].add_never_see_link) && (!cta_label || !cta_url)){ #> class="wph-modal--has_nsam"<# } #><# if ((cta_label && cta_url) && (_.isFalse( types[type].add_never_see_link))){ #> class="wph-modal--has_cta"<# } #><# if ((cta_label && cta_url) && _.isTrue( types[type].add_never_see_link )){ #> class="wph-modal--has_both"<# } #>>
					
					<# if ( _.isTrue( types[type].add_never_see_link ) ){ #>
						
						<a href="#0" class="wph-modal-never-see-again" ><?php _e("Never see this message again", Opt_In::TEXT_DOMAIN); ?></a>
						
					<# } #>
					
					<# if ( cta_label && cta_url ){ #>
						
						<a href="{{cta_url}}" target="{{cta_target}}" class="wph-modal--cta">{{cta_label}}</a>
						
					<# } #>
					
				</footer><?php //FOR MINIMAL STYLE ONLY || available only if user added some data to call-to-action button section  ?>
			
			<# } #>
			
		</div>
		
	</div>
	
</script>