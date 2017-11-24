<div class="wph-flex wph-flex--center">
	
	<div class="wph-flex--box">
		
		<div class="wph-label--toggle">
			
			<label class="wph-label--alt"><?php _e('Enable Magic Bar', Opt_In::TEXT_DOMAIN); ?></label>
			
			<span class="toggle">
				
				<input id="" class="toggle-checkbox" type="checkbox" data-nonce="" data-id="" checked="checked">
				
				<label class="toggle-label" for=""></label>
				
			</span>
			
		</div>
		
	</div>
	
	<div class="wph-flex--box">
		
		<p class="wph-p--info">All Except 1 category</p>
		
	</div>
	
</div>

<div class="wph-flex wph-flex--column wph-flex--gray">
		
	<div  class="wph-flex--box wph-flex--border wph-ccontent--conditions">
		
		<h4 class="wph-text--reset"><?php _e('Magic Bar Display Conditions', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<p><?php _e('By default, your new Magic Bar will be shown on <strong>every post & page</strong>. Click ( + ) below to set-up more specific conditions. 
You can set up rules for Categories & Tags, or be even more specific & manually choose posts & pages.', Opt_In::TEXT_DOMAIN); ?></p>
		
		<div class="wph-conditions">
			
			<div class="wph-conditions--side">
				
				<label class="wph-label--alt"><?php _e('Available Conditions', Opt_In::TEXT_DOMAIN); ?></label>
				
				<div class="wph-conditions--items">
					
					<div class="wph-conditions--item">Categories</div>
					
					<div class="wph-conditions--item">Tags</div>
					
					<div class="wph-conditions--item">Posts</div>
					
					<div class="wph-conditions--item">Pages</div>
					
					<div class="wph-conditions--item">Visitor logged in</div>
					
					<div class="wph-conditions--item">Magic Bar shown less than</div>
					
					<div class="wph-conditions--item">Mobile Devices</div>
					
					<div class="wph-conditions--item">From specific referrer</div>
					
					<div class="wph-conditions--item">From search engine</div>
					
					<div class="wph-conditions--item">Specific URL</div>
					
				</div>
				
			</div>
			
			<div class="wph-conditions--box">
				
				<label class="wph-label--alt"><?php _e('Conditions in-use', Opt_In::TEXT_DOMAIN); ?></label>
				
				<div class="wph-conditions--items">
					
					<p class="wph-conditions--empty"><?php _e('No Conditions applied. Currently this Magic Bar will be shown everywhere across your site.', Opt_In::TEXT_DOMAIN); ?></p>
					
				</div>
				
			</div>
			
		</div>
		
	</div><!-- Display Conditions -->
	
	<div id="wph-ccontent--triggers" class="wph-flex--box wph-flex--border">
		
		<h4 class="wph-text--reset"><?php _e('Magic Bar Triggers', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<p><?php _e('Magic Bars can be triggered after a certain amount of <strong>Time</strong>, when user <strong>Scrolls</strong> pass an element, on <strong>Click</strong>, if user tries to <strong>Leave</strong> or if we detect <strong>AdBlock</strong>.', Opt_In::TEXT_DOMAIN); ?></p>
		
	</div><!-- Triggers -->
	
	<div id="wph-ccontent--triggers" class="wph-flex--box wph-flex--border">
		
		<h4 class="wph-text--reset"><?php _e('Animation', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<div class="wph-flex">
			
			<div class="wph-flex--box">
				
				<label class="wph-label--alt"><?php _e('Show magic bar animation:', Opt_In::TEXT_DOMAIN); ?></label>
				
				<select id="" name="" data-type="javascript">
					
					<option value="" selected="selected">Fade In & Scale</option>
					<option value="">Animation 2</option>
					<option value="">Animation 3</option>
					<option value="">Animation 4</option>
					<option value="">Animation 5</option>
					
				</select>
				
			</div>
			
			<div class="wph-flex--box">
				
				<label class="wph-label--alt"><?php _e('Hide magic bar animation:', Opt_In::TEXT_DOMAIN); ?></label>
				
				<select id="" name="" data-type="javascript">
					
					<option value="" selected="selected">Fade In & Scale</option>
					<option value="">Animation 2</option>
					<option value="">Animation 3</option>
					<option value="">Animation 4</option>
					<option value="">Animation 5</option>
					
				</select>
				
			</div>
			
		</div>
		
	</div><!-- Animation -->
	
	<div id="wph-ccontent--triggers" class="wph-flex--box">
		
		<h4 class="wph-text--reset"><?php _e('Additional Settings', Opt_In::TEXT_DOMAIN); ?></h4>
		
<!--		<div class="wph-label--checkbox">-->
<!--			-->
<!--			<label class="wph-label--alt">--><?php //_e('Make this Magic Bar a full screen experience', Opt_In::TEXT_DOMAIN); ?><!--</label>-->
<!--			-->
<!--			<input type="checkbox" class="wph-label--alt">-->
<!--			-->
<!--		</div>-->
<!--		-->
		<div class="wph-label--checkbox">
			
			<label class="wph-label--alt"><?php _e('Add \'Never see this message again\' link', Opt_In::TEXT_DOMAIN); ?></label>
			
			<input type="checkbox" class="wph-label--alt">
			
		</div>
		
		<div class="wph-label--checkbox">
			
			<label class="wph-label--alt"><?php _e('Close button acts as \'Never see this message again\'', Opt_In::TEXT_DOMAIN); ?></label>
			
			<input type="checkbox" class="wph-label--alt">
			
		</div>
		
		<div class="wph-label--block">
			
			<label class="wph-label--alt"><?php _e('Expires', Opt_In::TEXT_DOMAIN); ?></label>
			
		</div>
		
		<div class="wph-label--number">
			
			<label class="wph-label--alt"><?php _e('days (upon expiry, user will see the Magic Bar again)', Opt_In::TEXT_DOMAIN); ?></label>
			
			<div class="wph-input--number">
				
				<input type="number" min="0" max="500" step="1" value="0">
				
			</div>
			
		</div>
		
	</div><!-- Additional Settings -->
	
</div>