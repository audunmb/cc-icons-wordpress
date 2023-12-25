<?php
/*
Plugin Name: Creative Commons Icons shortcodes
Plugin URI: 
Description: Shortcodes to add Creative Commons icons and license links
Version: 0.4
Author: Audun Myhra Bergwitz
Author URI: 
License: GPLv3 or later
Text domain: cc-icons
Domain path: /languages
*/

// Register Style
function creative_commons_style() {

	wp_enqueue_style( 'cc-icons-style', plugin_dir_url( __FILE__ ). 'cc-icons.css' );

}
add_action( 'wp_enqueue_scripts', 'creative_commons_style' );


// Main function code
function cc_shortcodes( $atts, $content= null, $tag) {
	extract( shortcode_atts(  array(

		// extra classes

		'class' => ''

	), $atts ) );



/* #translators: check https://creativecommons.org/licenses/by/4.0/deed , choose your language and att the end of the url here. Usually in the format '.xx' */
$lang_url = __('.en', 'cc-icons');

$link_title = __('Link to Creative Commons license', 'cc-icons');
$aria_label_start = __('Used with Creative Commons license ', 'cc-icons');
$aria_label_end = __('- follow link to read full license ', 'cc-icons');

$by = 'by';
$nd = 'nd';
$nc = 'nc';
$sa = 'sa';

$by_text = __('Attribution' , 'cc-icons');
$nd_text = __('Non-Derivative' , 'cc-icons');
$nc_text = __('Non-Commercial', 'cc-icons');
$sa_text = __('Share-Alike' , 'cc-icons');


$cc_icon = '<svg viewBox="5.5 -3.5 70 70" class="cc-icon"><use fill= "currentColor" href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#cc" xlink:href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#cc" /></svg>';
$by_icon = '<svg viewBox="5.5 -3.5 70 70" class="cc-icon"><use fill= "currentColor" href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#by" xlink:href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#by"/></svg>';
$nd_icon = '<svg viewBox="0 0 70 70" class="cc-icon"><use fill= "currentColor" href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#nd" xlink:href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#nd"/></svg>';
$nc_icon = '<svg viewBox="5.5 -3.5 70 70" class="cc-icon"><use fill= "currentColor" href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#nc" xlink:href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#nc"/></svg>';
$sa_icon = '<svg viewBox="5.5 -3.5 70 70" class="cc-icon"><use fill= "currentColor" href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#sa" xlink:href = "' . plugins_url( 'cc-icons.svg', __FILE__ ) . '#sa"/></svg>';


/*
$cc_icon = 'cc-icons.svg#cc';
$by_icon = 'cc-icons.svg#by';
$nd_icon = 'cc-icons.svg#nd';
$nc_icon = 'cc-icons.svg#nc';
$sa_icon = 'cc-icons.svg#sa';
*/

switch ( $tag ) {

		case 'CC-BY':

			$url_part = $by;
			$aria_part = $by_text;
			$svg_icons = $by_icon;		
			
			break;

		case 'CC-BY-SA':

			$url_part = $by . '-' . $sa ;
			$aria_part = $by_text . '-' . $sa_text ;
			$svg_icons = $by_icon . ' ' . $sa_icon ;	
			break;

		case 'CC-BY-ND':

			$url_part = $by . '-' . $nd ;
			$aria_part = $by_text . '-' . $nd_text ;
			$svg_icons = $by_icon . ' ' . $nd_icon ;	
			break;

		case 'CC-BY-NC':

			$url_part = $by . '-' . $nc ;
			$aria_part = $by_text . '-' . $nc_text ;
			$svg_icons = $by_icon . ' ' . $nc_icon ;	
			break;

		case 'CC-BY-NC-ND':

			$url_part = $by . '-' . $nc . '-' . $nd;
			$aria_part = $by_text . '-' . $nc_text . '-' . $nd_text ;
			$svg_icons = $by_icon . ' ' . $nc_icon . ' ' . $nd_icon;	
			break;

		case 'CC-BY-NC-SA':

			$url_part = $by . '-' . $nc . '-' . $sa;
			$aria_part = $by_text . '-' . $nc_text . '-' . $sa_text ;
			$svg_icons = $by_icon . ' ' . $nc_icon . ' ' . $sa_icon;	
			break;


	}


$cc_link_icons = '<a href="https://creativecommons.org/licenses/' . $url_part . '/4.0/deed' . $lang_url .'" aria-label="' . $aria_label_start . $aria_part . ' 4.0 ' . $aria_label_end . '"  title="' . $link_title . '" class="cc-link-icons">' . $cc_icon . ' ' . $svg_icons . '</a>';



	return $cc_link_icons;

}


add_shortcode( 'CC-BY', 'cc_shortcodes' );
add_shortcode( 'CC-BY-SA', 'cc_shortcodes' );
add_shortcode( 'CC-BY-ND', 'cc_shortcodes' );
add_shortcode( 'CC-BY-NC', 'cc_shortcodes' );
add_shortcode( 'CC-BY-NC-ND', 'cc_shortcodes' );
add_shortcode( 'CC-BY-NC-SA', 'cc_shortcodes' );


/* add localization */
add_action( 'init', 'wpdocs_load_textdomain' );

function wpdocs_load_textdomain() {
	load_plugin_textdomain( 'wpdocs_textdomain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

/*allow for use in captions*/
add_filter("shortcode_atts_caption", function($atts) {
  if (isset($atts['caption'])) {
    $atts['caption'] = do_shortcode($atts['caption']);
  }
  return $atts;
});

function my_caption_shortcode($atts) {
  if (isset($atts['caption'])) {
    // avoid endless loop
    remove_filter( current_filter(), __FUNCTION__);
    // apply shortcodes
    $atts['caption'] = do_shortcode($atts['caption']);
    // restore filter
    add_filter(current_filter(), __FUNCTION__);
  }
  return $atts;
}

add_filter("shortcode_atts_caption", "my_caption_shortcode");


