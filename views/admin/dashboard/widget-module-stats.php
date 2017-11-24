<div id="wph-module-stats" class="box">
	
	<div class="box-content">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-6">
				
				<table class="wph-table wph-table--fixed" cellpadding="0" cellspacing="0">
					
					<thead>
						
						<tr>
							
							<th colspan="2" class="wph-table--name"><?php _e('Module Name', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th><?php _e('Rate', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th><?php _e('7 Days', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th><?php _e('30 Days', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th><?php _e('All Time', Opt_In::TEXT_DOMAIN); ?></th>
							
						</tr>
						
					</thead>
					
					<tbody>
						
						<?php foreach ( $conversion_data as $module_name => $data ):  ?>
							
							<tr>
	
								<td class="wph-table--name" colspan="2"><i style="background-color: <?php echo $data['color']; ?>;"></i> <!--<span class="wpoi-tooltip tooltip-left" tooltip="<?php echo $data['module_type']; ?>">--><i class="wph-icon i-<?php echo $data['module_type']; ?>"></i><!--</span>--> <?php echo $module_name; ?></td>
	
								<td data-title="<?php _e('Rate', Opt_In::TEXT_DOMAIN); ?>"><?php echo $data['rate']; ?>%</td>
	
								<td data-title="<?php _e('7 Days', Opt_In::TEXT_DOMAIN); ?>"><?php echo $data['week']; ?></td>
	
								<td class="c-current" data-title="<?php _e('30 Days', Opt_In::TEXT_DOMAIN); ?>"><?php echo $data['month']; ?></td>
	
								<td data-title="<?php _e('All Time', Opt_In::TEXT_DOMAIN); ?>"><?php echo $data['all']; ?></td>
	
							</tr>
							
						<?php endforeach; ?>
						
					</tbody>
					
				</table>
				
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-6">
				
				<div class="wph-module--graph">
					
					<canvas id="conversions_chart"></canvas>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</div>