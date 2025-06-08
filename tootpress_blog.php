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
	$toot_html.='<!-- Toot ID '.esc_html($mastodon_id).'-->';

	// Toot Start
	$toot_html.='<div class="tootpress-toot"/>';

	// Toot Elephant
	$toot_html.=tootpress_paint_elephant( $instance, $account, $mastodon_id, $backlink);

	// Toot Date
	$toot_html.=tootpress_paint_date($date);

	// Toot Content
	$content=tootpress_remove_target_blank($content);
	$content=tootpress_toot_content_filter_apply($content);	
	$toot_html.='<div class="toot-content">'.wp_kses_post($content).'</div>';

	// Toot Image
	if($media){
		$toot_html.=tootpress_paint_image($mastodon_id);
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
			$image_html.='toot-image-gallery-'.(int) $amount_of_images.' ';
			$image_html.='toot-image-'.(int) ($i+1);
		} else {
			// Single Images
			$image_html.='toot-image-single ';
		}
		
		$image_html.='">';
		$image_html.=tootpress_paint_image_tag($toot_image[$i]['attachment_file'],$toot_image[$i]['attachment_description'],$amount_of_images,($i+1));
		$image_html.='</div>';

	}

	return $image_html;
}

/**
 * Create the Image Tag
 * 
 * @since 0.5
 * 
 * @param string Image File Name
 * @param string Image Description
 * @param int Amount of Images
 * @param int Image Number
 * @return string Image Tag
 */

function tootpress_paint_image_tag($filename, $description, $amount_of_images, $image_number) {

		$image_tag='<img ';
		$image_tag.='src="';
		$image_tag.=tootpress_get_url_image_directory();
		$image_tag.=$filename;
		$image_tag.='" ';
		$image_tag.='alt="';
		$image_tag.=$description;
		//$image_tag.='" ';
		//$image_tag.='width="';
		//$image_tag.=$toot_image[0]['attachment_width'];
		//$image_tag.='" ';
		//$image_tag.='height="';
		//$image_html.=$toot_image[0]['attachment_height'];
		$image_tag.='" />';

		$image_tag=tootpress_image_filter_apply($image_tag,$amount_of_images,$image_number);

		return $image_tag;

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
	$elephant_img='<img class="tootpress-toot-symbol" src="'.esc_url(plugins_url()).'/tootpress/tootpress_toot.png" alt="Toot Symbol" width="35" height="37"/>';
	$elephant_img=tootpress_mastodon_logo_filter_apply($elephant_img);
	$elephant_html.=$elephant_img;

	if($backlink) {
		$elephant_html.='</a>';
	}

	return $elephant_html;

}

/**
 * Paint the Date 
 * 
 * @since 0.5
 * 
 * @param string Date
 * @return string html
 */

 function tootpress_paint_date($date) {

	// 2023-05-30 22:40:28

	$mysqldate=$date;

	$date=tootpress_date_filter_apply($date);

	if($mysqldate==$date) {

		if(tootpress_is_language_german()) {
			$date=tootpress_convert_mysqldate_to_german_format($date);
		} else {
			$date=tootpress_convert_mysqldate_to_international_format($date);
		}

	}

	$date_html='<div class="toot-date"><p>'.esc_html($date).'</p></div>';
	return $date_html;

}

/**
 * Creates the Preamble 
 * 
 * @since 0.4
 * 
 * @param int TootPress Current Page
 * @return string html
 */

 function tootpress_paint_preamble($tootpress_current_page) {

	$preamble='';

	if($tootpress_current_page==1) {

		$preamble=tootpress_preamble_filter_apply($preamble);

		if($preamble) {
			$preamble='<div class="tootpress-preamble">'.$preamble.'</div>';
		}

	}

	return $preamble;

}

/**
 * Creates the Closing Filter Content 
 * 
 * @since 0.5
 * 
 * @param int TootPress Current Page
 * @return string Content
 */

 function tootpress_paint_closing($tootpress_current_page) {

	$content='';
	$lastpage=tootpress_amount_of_pages();

	if($tootpress_current_page==$lastpage) {

		$content.=tootpress_closing_filter_apply($content);

		if($content) {
			$content='<div class="tootpress-closing">'.$content.'</div>';
		}

	}

	return $content;

}

/**
 * Create the Before Loop Content.
 * 
 * @since 0.5
 * 
 * @param string empty
 * @param int TootPress Current Page
 * @return string Content
 */

function tootpress_paint_beforeloop($tootpress_current_page) {

	$content='';
	$content=tootpress_beforeloop_filter_apply($content, $tootpress_current_page);

	if($content) {
		$content='<div class="tootpress-beforeloop">'.$content.'</div>';
	}

	return $content;

}

/**
 * Create the After Loop Content.
 * 
 * @since 0.5
 * 
 * @param string empty
 * @param int TootPress Current Page
 * @return string Content
 */

function tootpress_paint_afterloop($tootpress_current_page) {

	$content='';
	$content=tootpress_afterloop_filter_apply($content, $tootpress_current_page);

	if($content) {
		$content='<div class="tootpress-afterloop">'.$content.'</div>';
	}

	return $content;

}

/**
 * Create the Between Element.
 * 
 * @since 0.5
 * 
 * @param int Open Loops
 * @return string Between Element
 */

function tootpress_paint_between($open_loops) {

	$content='';

	if ($open_loops>1) {
		$content=tootpress_between_filter_apply($content);
	}

	if($content) {
		$content='<div class="tootpress-between">'.$content.'</div>';
	}

	return $content;

}

?>