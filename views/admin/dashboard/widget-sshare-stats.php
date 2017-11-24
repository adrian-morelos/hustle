<div id="wpoi-box-dashboard-sshare-stats" class="box">
	
	<div class="box-title">
		
		<h3><?php _e('Social Sharing Stats', Opt_In::TEXT_DOMAIN); ?><span class="wph-tag--premium"><?php _e('New', Opt_In::TEXT_DOMAIN); ?></span></h3>
		
	</div>
	
	<div class="box-content">
		
		<div class="row">
			
			<div class="col-xs-12">
            
                <?php if( count( $ss_share_stats ) > 0 ): ?>
				
                    <table class="wph-table wph-table--fixed">
                        
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
                        
                        <?php if( count( $ss_share_stats ) >= 5 ): ?>

                            <tfoot>

                                <tr>

                                    <td colspan="2"><a id="wph-sshare_stats_view_all" class="wph-button wph-button--gray"><?php _e('View All', Opt_In::TEXT_DOMAIN); ?></a></td>

                                </tr>

                            </tfoot>

                        <?php endif; ?>

                    </table>
                
                <?php else : ?>
                
                    <div class="wph-sshare_no_stats">
	                    
	                    <p class="wph-label--notice"><span><?php _e('Create a new Social Share and enable tracking to see your stats here!', Opt_In::TEXT_DOMAIN); ?></span></p>
	                    
	                </div>
                
                <?php endif; ?>
				
			</div>
			
		</div>
		
	</div>
	
</div>