<?php

/**
 * Blog
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Creates the Toot Markup
 * 
 * @since 0.1
 * 
 * @param int Mastodon ID
 * @param date Toot Date
 * @param string Toot Content
 * @param int Media Flag
 * @param string Mastodon Instance
 * @param string Mastodon Account
 * @param int Backlink Flag
 * @return string html
 */

function tootpress_paint_toot( $mastodon_id, $date, $content, $media , $instance, $account, $backlink)
{

	$toot_html='';

	// Toot ID as HTML Comment
	$toot_html.='<!-- Toot ID '.$mastodon_id.'-->';

	// Toot Start
	$toot_html.='<div class="tootpress-toot"/>';

	// Toot Elephant
	$toot_html.=tootpress_paint_elephant( $instance, $account, $mastodon_id,$backlink);

	// Toot Date
	if(tootpress_is_language_german()) {
		$date=tootpress_convert_mysqldate_to_german_format($date);
	} else {
		$date=tootpress_convert_mysqldate_to_international_format($date);
	}

	$toot_html.='<div class="toot-date"><p>'.esc_html($date).'</p></div>';

	// Toot Content
	$content=tootpress_remove_target_blank($content);
	$toot_html.='<div class="toot-content">'.wp_kses($content, tootpress_escaping_allowed_html() ).'</div>';

	// Toot Image
	if($media){
		$toot_html.=wp_kses(tootpress_paint_image($mastodon_id), tootpress_escaping_allowed_html() );
	}

	// Toot End
	$toot_html.='</div>';

	return $toot_html;
}

/**
 * Creates the Image Markup
 * 
 * @since 0.1
 * 
 * @param int Toot ID
 * @return string html
 */

function tootpress_paint_image($tootid){

	// Get Images from Database
	$toot_image=array();
	$toot_image=tootpress_get_media_from_database($tootid);
	$image_html='';

	// Amount of Images
	$amount_of_images=sizeof($toot_image);

	for($i=0;$i<$amount_of_images;$i++) {

		// Image Content
		$image_html.='<div class="toot-image ';

		// Classes
		if($amount_of_images>1) {
			// Galleries
			$image_html.='toot-image-gallery ';
			$image_html.='toot-image-gallery-'.$amount_of_images.' ';
			$image_html.='toot-image-'.($i+1);
		} else {
			// Single Images
			$image_html.='toot-image-single ';
		}
		
		$image_html.='">';
		$image_html.='<img ';
		$image_html.='src="';
		$image_html.=tootpress_get_url_image_directory();
		$image_html.=$toot_image[$i]['attachment_file'];
		$image_html.='" ';
		$image_html.='alt="';
		$image_html.=$toot_image[$i]['attachment_description'];
		//$image_html.='" ';
		//$image_html.='width="';
		//$image_html.=$toot_image[0]['attachment_width'];
		//$image_html.='" ';
		//$image_html.='height="';
		//$image_html.=$toot_image[0]['attachment_height'];
		$image_html.='" />';
		$image_html.='</div>';

	}

	return $image_html;
}

/**
 * Creates the Elephant
 * 
 * @since 0.3
 * 
 * @param string Mastodon Instance
 * @param string Mastodon Account
 * @param int Mastodon Toot ID
 * @param int Backlink Option
 * @return string html
 */

function tootpress_paint_elephant( $instance, $account, $mastodon_id, $backlink) {

	$elephant_html='';
	$url='https://'.$instance.'/@'.$account.'/'.$mastodon_id;

	if($backlink) {
		$elephant_html.='<a href="';
		$elephant_html.=esc_url($url);
		$elephant_html.='" class="toot-backlink"/>';
	}

	// The Elephant
	$elephant_html.='<img class="tootpress-toot-symbol" src="'.esc_url(plugins_url()).'/tootpress/tootpress_toot.png" alt="Toot Symbol" width="35" height="37"/>';

	if($backlink) {
		$elephant_html.='</a>';
	}

	return $elephant_html;

}

?>