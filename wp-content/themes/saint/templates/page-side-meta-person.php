<?php
/****************************/
/**** Side Meta - Person ****/ 
/****************************/
?>
<ul class='meta-data'> 
	<?php
		$phone_number = ac_get_meta('phone_number');
		if ($phone_number) : ?>
			<li class="phone-number"><i class="entypo smaller icon-phone-1"></i><?php echo $phone_number;?></span></li> <?php
		endif; 

		$email_address = ac_get_meta('email_address');
		if ($email_address) : ?>
			<li class="email-address"><i class="entypo smaller icon-link-1"></i><a href="mailto:<?php echo $email_address;?>"><?php echo $email_address;?></a></li> <?php
		endif; 
		
		$web_address = ac_get_meta('web_address');
		if ($web_address) : ?>
			<li class="web-address"><i class="entypo smaller icon-mail-1"></i><a href="<?php echo esc_url(ac_ensure_http($web_address));?>"><?php echo $web_address;?></a></li> <?php
		endif; 		
		?>

		<?php echo ac_person_get_all_social_icons( $post, 'li' ); ?>

		<?php if ( get_the_terms($post->ID, 'people-category') ) : ?>
		<li><?php echo get_the_term_list($post->ID, 'people-category', '', ', ', ''); ?></li>
		<?php endif; ?>		
</ul>