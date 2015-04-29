<?php

/*
 * The social core options for the Shoestrap theme
 */
if ( !function_exists( 'shoestrap_module_social_options' ) ) :
function shoestrap_module_social_options( $sections ) {

  $section = array(
    'title'     => __( 'Social Sharing', 'shoestrap' ),
    'icon'      => 'el-icon-share icon-large',
  );

  $fields[] = array( 
    'id'        => 'social_sharing_help_2',
    'title'     => __( 'Select which Socials Share buttons to show at the bottom of posts and pages.', 'shoestrap' ),
    'type'      => 'info'
  );

  $fields[] = array( 
    'title'     => __( 'Button Text', 'shoestrap' ),
    'desc'      => __( 'Select the text for the social sharing button.', 'shoestrap' ),
    'id'        => 'social_sharing_text',
    'default'   => 'Share',
    'type'      => 'text'
  );


  $fields[] = array( 
    'title'     => __( 'Facebook', 'shoestrap' ),
    'id'        => 'facebook_share',
    'default'   => '',
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Google+', 'shoestrap' ),
    'id'        => 'google_plus_share',
    'default'   => '',
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'LinkedIn', 'shoestrap' ),
    'id'        => 'linkedin_share',
    'default'   => '',
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Pinterest', 'shoestrap' ),
    'id'        => 'pinterest_share',
    'default'   => '',
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Reddit', 'shoestrap' ),
    'id'        => 'reddit_share',
    'default'   => '',
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Tumblr', 'shoestrap' ),
    'id'        => 'tumblr_share',
    'default'   => '',
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Twitter', 'shoestrap' ),
    'id'        => 'twitter_share',
    'default'   => '',
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Email', 'shoestrap' ),
    'id'        => 'email_share',
    'default'   => '',
    'type'      => 'switch'
  );

  $section['fields'] = $fields;
  $section = apply_filters( 'shoestrap_module_social_share_options_modifier', $section );
  $sections[] = $section;

  $section = array( 
    'title'     => __( 'Footer Social Links', 'shoestrap' ),
    'icon'      => 'el-icon-group icon-large',
  );
  $fields = array();
  
  $fields[] = array( 
    'title'       => __( 'Show social icons in footer', 'shoestrap' ),
    'desc'        => __( 'Show social icons in the footer. Default: On.', 'shoestrap' ),
    'id'          => 'footer_social_toggle',
    'default'     => 1,
    'customizer'  => array(),
    'type'        => 'switch',
  );

  $fields[] = array( 
    'title'       => __( 'Footer social links column width', 'shoestrap' ),
    'desc'        => __( 'Set the width of the footer social links area. The footer text width will be adjusted accordingly.', 'shoestrap' ),
    'id'          => 'footer_social_width',
    'required'    => array('footer_social_toggle','=',array('1')),
    'default'     => 8,
    'min'         => 3,
    'step'        => 1,
    'max'         => 10,
    'customizer'  => array(),
    'type'        => 'slider',
  );    

  $fields[] = array( 
    'title'       => __( 'Footer social icons open in new window', 'shoestrap' ),
    'desc'        => __( 'Social icons in footer will open a new window.', 'shoestrap' ),
    'id'          => 'footer_social_new_window_toggle',
    'required'    => array('footer_social_toggle','=',array('1')),
    'default'     => 1,
    'customizer'  => array(),
    'type'        => 'switch',
  );  
  
  $fields[] = array( 
    'id'        => 'social_links_help_1',
    'title'     => __( 'Enter your profile URLs below to show in the footer.', 'shoestrap' ),
    'type'      => 'info'
  );  

  $fields[] = array( 
    'title'     => __( 'Blogger', 'shoestrap' ),
    'id'        => 'blogger_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'DeviantART', 'shoestrap' ),
    'id'        => 'deviantart_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Digg', 'shoestrap' ),
    'id'        => 'digg_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Dribbble', 'shoestrap' ),
    'id'        => 'dribbble_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Facebook', 'shoestrap' ),
    'id'        => 'facebook_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Flickr', 'shoestrap' ),
    'id'        => 'flickr_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'GitHub', 'shoestrap' ),
    'id'        => 'github_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Google+', 'shoestrap' ),
    'id'        => 'google_plus_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Instagram', 'shoestrap' ),
    'id'        => 'instagram_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'LinkedIn', 'shoestrap' ),
    'id'        => 'linkedin_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'MySpace', 'shoestrap' ),
    'id'        => 'myspace_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Pinterest', 'shoestrap' ),
    'id'        => 'pinterest_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Reddit', 'shoestrap' ),
    'id'        => 'reddit_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'RSS', 'shoestrap' ),
    'id'        => 'rss_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Skype', 'shoestrap' ),
    'id'        => 'skype_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'SoundCloud', 'shoestrap' ),
    'id'        => 'soundcloud_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Tumblr', 'shoestrap' ),
    'id'        => 'tumblr_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Twitter', 'shoestrap' ),
    'id'        => 'twitter_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Vimeo', 'shoestrap' ),
    'id'        => 'vimeo_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );


  $fields[] = array( 
    'title'     => 'Vkontakte',
    'id'        => 'vkontakte_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => 'YouTube Link',
    'id'        => 'youtube_link',
    'validate'  => 'url',
    'default'   => '',
    'type'      => 'text'
  );
  
  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_social_links_options_modifier', $section );
  
  $sections[] = $section;
  return $sections;

}
endif;
add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_social_options', 85 ); 

include_once( dirname( __FILE__ ) . '/functions.social.php' );