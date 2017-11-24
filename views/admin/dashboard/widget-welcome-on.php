<div id="wph-welcome-on" class="box">

	<div class="box-content">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				
				<div class="wph-okay"></div>
				
			</div>
	
			<div class="col-xs-12 col-sm-hidden col-md-4 col-lg-4">
				
				<div class="content-322">
					
					<?php if( $data_exists ): ?>
		
						<h2><?php _e('Welcome Back.', Opt_In::TEXT_DOMAIN); ?></h2>
		
						<h6><?php _e('We have collected some conversion data that is summarized on this page.', Opt_In::TEXT_DOMAIN); ?></h6>
		
					<?php else: ?>
		
						<h2><?php _e('No data yet.', Opt_In::TEXT_DOMAIN); ?></h2>
		
						<h6><?php _e('We haven\'t received any conversion data just yet. Give it a bit more time.', Opt_In::TEXT_DOMAIN); ?></h6>
		
					<?php endif; ?>
					
				</div>
	
			</div>
	
			<div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
				
				<div class="content-374">
					
					<table class="wph-table wph-table--fixed wph-dashboard--stats">
		
						<tbody>
		
							<tr>
		
								<th><?php _e('Active Modules', Opt_In::TEXT_DOMAIN); ?></th>
		
								<td><?php echo $active_modules; ?></td>
		
							</tr>
		
							<tr>
		
								<th><?php _e('Today\'s Conversions', Opt_In::TEXT_DOMAIN); ?></th>
		
								<td><?php echo $conversions; ?></td>
		
							</tr>
		
							<tr>
		
								<th><?php _e('Most Conversions (All Time)', Opt_In::TEXT_DOMAIN); ?></th>
		
								<td><?php echo $most_conversions; ?></td>
		
							</tr>
		
						</tbody>
		
					</table>
					
				</div>
				
			</div>
			
		</div>

	</div>

</div>