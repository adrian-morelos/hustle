<div id="wpoi-sshare-stats-modal">
	
	<div class="hustle-two">
	
		<div class="wpoi-complete-mask"></div>
		
		<div class="wpoi-complete-wrap row">
			
			<div class="col-xs-12">
				
				<section class="box">
					
					<div class="box-title">
						
						<h3><?php _e('Social Sharing Stats', Opt_In::TEXT_DOMAIN); ?></h3>
						
						<a href="#" id="wph-sshare_stats_close" aria-label="Close" class="wph-icon i-close inc-opt-close-emails-list"></a>
						
					</div>
					
					<div class="box-content">
						
						<div class="row">
							
							<div class="col-xs-12">
								
								<table id="wph-sshare--stats_items" class="wph-table wph-table--fixed">
									
									<thead>
										
										<tr>
											
											<th><?php _e('Page or Post', Opt_In::TEXT_DOMAIN); ?></th>
											
											<th class="wph-module--count"><?php _e('Cumulative Shares', Opt_In::TEXT_DOMAIN); ?></th>
											
										</tr>
										
									</thead>
									
									<tbody>
                                        
                                        <?php foreach( $ss_share_stats as $ss ) : ?>
							
                                            <tr>
                                                
                                                <td class="wph-module--name"><a target="_blank" href="<?php echo ( $ss->ID != 0 ) ? esc_url(get_permalink($ss->ID)) : esc_url(get_home_url()) ; ?>"><?php echo ( $ss->ID != 0 ) ? $ss->post_title : bloginfo('title'); ?></a></td>
                                                
                                                <th class="wph-module--count"><?php echo $ss->page_shares; ?></th>
                                                
                                            </tr>
                                            
                                        <?php endforeach; ?>
										
									</tbody>
									
								</table>
								
								<div class="wph-pagination-wrap">
                                    
                                    <?php
                                        $pages = (int) ($total_stats / 5);
                                        if ( ($total_stats % 5) ) {
                                            $pages++;
                                        }
                                        $first_page = 1;
                                        $last_page = $pages;
                                    ?>
                                    
									<ul class="wph-pagination" data-total="<?php echo $pages;?>" data-nonce="<?php echo wp_create_nonce('hustle_ss_stats_paged_data'); ?>">
										
										<li class="wph-link wph-link-prev wph-sshare--prev_page" data-page="1"><span><i class="wph-icon i-arrow"></i></span></li>
										
										<li class="wph-link wph-sshare--current_page" data-page="1" ><span>1</span></li>
                                        
                                        <?php if( $pages > 1 ): ?>
										
										<li class="wph-link wph-sshare--page_number" data-page="2"><a href="#">2</a></li>
                                        
                                        <li class="wph-link wph-link-next wph-sshare--next_page" data-page="2"><a href="#"><i class="wph-icon i-arrow"></i></a></li>
                                        
                                        <?php else: ?>
                                        
                                        <li class="wph-link wph-link-next wph-sshare--next_page" data-page="2"><span><i class="wph-icon i-arrow"></i></span></li>
                                        
                                        <?php endif; ?>
										
										
										
									</ul>
									
								</div>
								
							</div>
							
						</div>
						
					</div>
					
				</section>
				
			</div>
			
		</div>
		
	</div>
    
</div>
<script id="wpoi-sshare-stats-modal-tpl" type="text/template">
    <table id="wph-sshare--stats_items" class="wph-table wph-table--fixed">
                
        <thead>
            
            <tr>
                
                <th><?php _e('Page or Post', Opt_In::TEXT_DOMAIN); ?></th>
                
                <th class="wph-module--count"><?php _e('Cumulative Shares', Opt_In::TEXT_DOMAIN); ?></th>
                
            </tr>
            
        </thead>
        
        <tbody>
        
            <# _.each( ss_share_stats, function(ss, key){ #>
            
                <tr>
                    
            <td class="wph-module--name"><a target="_blank" href="{{ss.page_url}}">{{ss.page_title}}</a></td>
                    
                    <th class="wph-module--count">{{ss.page_shares}}</th>
                    
                </tr>
                
            <# }); #>
                
            
        </tbody>
        
    </table>
</script>