<div id="wph-modules--overview" class="box">

	<div class="box-title">

		<h3><?php _e('Modules Overview', Opt_In::TEXT_DOMAIN); ?></h3>

	</div>

	<div class="box-content">
		
		<div class="row">
			
			<div class="col-xs-12">
				
				<div class="tabs">
					
					<ul class="tabs-header">
						
						<li class="current">
							
							<label>
								
								<?php _e('Opt-ins', Opt_In::TEXT_DOMAIN); ?> (<?php echo $total_optins; ?>)
								
								<input type="radio" id="" name="" data-attribute="" value="optins" checked="checked">
								
							</label>
							
						</li>
						
						<li>
							
							<label>
								
								<?php _e('Custom Content', Opt_In::TEXT_DOMAIN); ?> (<?php echo $total_custom_contents; ?>)
								
								<input type="radio" id="" name="" data-attribute="" value="custom_contents">
								
							</label>
							
						</li>
						
					</ul>
					
				</div>
				
			</div>
			
		</div>
		
		<div class="row">
			
			<div id="wph-optins-overview" class="wph-modules-overview col-xs-12 current">
				
				<?php if( count($optins) > 0 ) : ?>
				
				<table class="wph-table">
					
					<thead>
						
						<tr>
							
							<th colspan="2"><?php _e('Active', Opt_In::TEXT_DOMAIN); ?></th>
							
						</tr>
						
					</thead>
					
					<tbody>
						
						<?php foreach( $optins as $optin ) : ?>
							
							<tr>
								
								<td class="wph-module--name"><?php echo $optin->optin_name; ?></td>
								
								<td class="wph-module--edit"><a href="<?php echo $optin->decorated->get_edit_url(''); ?>" class="wph-button wph-button--small wph-button--gray"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a></td>
								
							</tr>
							
						<?php endforeach; ?>
						
					</tbody>
					
				</table>
				
				<?php endif; ?>
				
				<?php if( count($inactive) > 0 ) : ?>
				
				<table class="wph-table">
					
					<thead>
						
						<tr>
							
							<th colspan="2"><?php _e('Inactive', Opt_In::TEXT_DOMAIN); ?></th>
							
						</tr>
						
					</thead>
					
					<tbody>
						<?php foreach( $inactive as $optin ) : ?>
							
							<tr>
								
								<td class="wph-module--name"><?php echo $optin->optin_name; ?></td>
								
								<td class="wph-module--edit"><a href="<?php echo $optin->decorated->get_edit_url(''); ?>" class="wph-button wph-button--small wph-button--gray"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a></td>
								
							</tr>
							
						<?php endforeach; ?>
						
					</tbody>
					
				</table>
				
				<?php endif; ?>
				
			</div>
			
			<div id="wph-custom_contents-overview" class="wph-modules-overview col-xs-12">
				
				<?php if( count($custom_contents) > 0 ) : ?>
				
				<table class="wph-table">
					
					<thead>
						
						<tr>
							
							<th colspan="2"><?php _e('Active', Opt_In::TEXT_DOMAIN); ?></th>
							
						</tr>
						
					</thead>
					
					<tbody>
						
						<?php foreach( $custom_contents as $cc ) : ?>
							
							<tr>
								
								<td class="wph-module--name"><?php echo $cc->optin_name; ?></td>
								
								<td class="wph-module--edit"><a href="<?php echo $cc->decorated->get_edit_url(''); ?>" class="wph-button wph-button--small wph-button--gray"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a></td>
								
							</tr>
							
						<?php endforeach; ?>
						
					</tbody>
					
				</table>
				
				<?php endif; ?>
				
				<?php if( count($inactive_cc) > 0 ) : ?>
				
				<table class="wph-table">
					
					<thead>
						
						<tr>
							
							<th colspan="2"><?php _e('Inactive', Opt_In::TEXT_DOMAIN); ?></th>
							
						</tr>
						
					</thead>
					
					<tbody>
						<?php foreach( $inactive_cc as $cc ) : ?>
							
							<tr>
								
								<td class="wph-module--name"><?php echo $cc->optin_name; ?></td>
								
								<td class="wph-module--edit"><a href="<?php echo $cc->decorated->get_edit_url(''); ?>" class="wph-button wph-button--small wph-button--gray"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a></td>
								
							</tr>
							
						<?php endforeach; ?>
						
					</tbody>
					
				</table>
				
				<?php endif; ?>
				
			</div>
			
		</div>
		
	</div>
	
</div>