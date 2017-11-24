<?php if( $admin ) : ?>
<div class="wph-social-sharing">
	
	<div class="wph-sshare--container wph-sshare--<?php echo $type; ?> wph-sshare--design_{{icon_style}} wph-sshare--color_{{ ( customize_colors == 1 ) ? 'custom' : 'default' }}">
		
	</div>
	
</div>
<?php else : ?>

<script id="hustle-social-tpl" type="text/template">
    <div class="wph-social-sharing wph-social-sharing-{{id}}">
	
        <div class="wph-sshare--container wph-sshare--{{display_type}} wph-sshare--design_{{icon_style}} wph-sshare--color_{{ ( customize_colors == 1 ) ? 'custom' : 'default' }}">
            
        </div>
        
    </div>
</script>

<?php // ICON TEMPLATES for 2,3,4 icon_styles ?>
<script id="wpoi-sshare-facebook-svg-front" type="text/template">
    <?php $this->render('general/icons/social/wph-facebook'); ?>
</script>
<script id="wpoi-sshare-twitter-svg-front" type="text/template">
    <?php $this->render('general/icons/social/wph-twitter'); ?>
</script>
<script id="wpoi-sshare-google-svg-front" type="text/template">
    <?php $this->render('general/icons/social/wph-google'); ?>
</script>
<script id="wpoi-sshare-pinterest-svg-front" type="text/template">
    <?php $this->render('general/icons/social/wph-pinterest'); ?>
</script>
<script id="wpoi-sshare-reddit-svg-front" type="text/template">
    <?php $this->render('general/icons/social/wph-reddit'); ?>
</script>
<script id="wpoi-sshare-linkedin-svg-front" type="text/template">
    <?php $this->render('general/icons/social/wph-linkedin'); ?>
</script>
<script id="wpoi-sshare-vkontakte-svg-front" type="text/template">
    <?php $this->render('general/icons/social/wph-vkontakte'); ?>
</script>

<?php // ICON TEMPLATES for 1 icon_styles ?>
<script id="wpoi-sshare-facebook-one-svg-front" type="text/template">
    <?php $this->render('general/icons/social-path/wph-facebook'); ?>
</script>
<script id="wpoi-sshare-twitter-one-svg-front" type="text/template">
    <?php $this->render('general/icons/social-path/wph-twitter'); ?>
</script>
<script id="wpoi-sshare-google-one-svg-front" type="text/template">
    <?php $this->render('general/icons/social-path/wph-google'); ?>
</script>
<script id="wpoi-sshare-pinterest-one-svg-front" type="text/template">
    <?php $this->render('general/icons/social-path/wph-pinterest'); ?>
</script>
<script id="wpoi-sshare-reddit-one-svg-front" type="text/template">
    <?php $this->render('general/icons/social-path/wph-reddit'); ?>
</script>
<script id="wpoi-sshare-linkedin-one-svg-front" type="text/template">
    <?php $this->render('general/icons/social-path/wph-linkedin'); ?>
</script>
<script id="wpoi-sshare-vkontakte-one-svg-front" type="text/template">
    <?php $this->render('general/icons/social-path/wph-vkontakte'); ?>
</script>

<?php endif; ?>