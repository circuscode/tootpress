<?php

/**
 * Menu
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Create TootPress Menu
 * 
 * @since 0.1
 * 
 * @param int Current Page
 * @return html Menu HTML
 */

function tootpress_create_menu($current_page) {

	$menu_html='';
	$amount_of_pages=tootpress_amount_of_pages();

	// No Bottom Navigation required
	if($amount_of_pages==1) {
		$menu_html='<!-- No Bottom Navigation required -->';
		return $menu_html;
	}

	$menu_html.='<div class="tootpress_nav">';

	// Type of Menu
	$tootpress_menu_type=get_option('tootpress_navigation');
	if ($tootpress_menu_type=='standard') {
		$menu_html.=tootpress_generate_nav_standard($current_page);
	} elseif ($tootpress_menu_type=='numbers') {
		$menu_html.=tootpress_generate_nav_numbers($current_page);
	}

	$menu_html.='</div>';

	return $menu_html;

}

/**
 * Generate TootPress Standard Navigation
 * 
 * @since 0.1
 * 
 * @param int Current Page
 * @return html Menu HTML
 */

function tootpress_generate_nav_standard($current_page) {

	$menu_html='';
	$is_perma_enabled=tootpress_is_pretty_permalink_enabled();
	$amount_of_pages=tootpress_amount_of_pages();

	// Newer Toots Link
	if($current_page>1) {

		$menu_html.='<a href="';
		$menu_html.=tootpress_blog_url();
		if($current_page==2) {
			// Special Case: Page 2
			$menu_html.='"';
		} else {
			// Page 3 to n
			if($is_perma_enabled) {
				// Perma
				$menu_html.=($current_page-1);
				$menu_html.='/"';
			} else {
				// Simple
				$menu_html.='&tootpress=';
				$menu_html.=($current_page-1);
				$menu_html.='"';
			}
		}
		$menu_html.='class="tootpress_nav_standard_newer_toots"';
		$menu_html.='>';
		$menu_html.=tootpress_label_newer_toots();
		$menu_html.='</a>';
		
	}

	// Older Toots Link
	if($current_page<$amount_of_pages) {

		$menu_html.='<a href="';
		$menu_html.=tootpress_blog_url();
		if($is_perma_enabled) {
			// Perma
			$menu_html.=($current_page+1);
			$menu_html.='/" ';
		} else {
			// Simple
			$menu_html.='&tootpress=';
			$menu_html.=($current_page+1);
			$menu_html.='" ';
		}
		$menu_html.='class="tootpress_nav_standard_older_toots"';
		$menu_html.='>';
		$menu_html.=tootpress_label_older_toots();
		$menu_html.='</a>';
		
	}

	return $menu_html;

}

/**
 * Generate TootPress Number Navigation
 * 
 * @since 0.1
 * 
 * @param int Current Page
 * @return html Menu HTML
 */

 function tootpress_generate_nav_numbers($current_page) {

	$menu_html='';
	$is_perma_enabled=tootpress_is_pretty_permalink_enabled();
	$amount_of_pages=tootpress_amount_of_pages();

	for($i=0; $i<$amount_of_pages; $i++) {

		$current_number=$i+1;

		if(tootpress_nav_numbers_condition_number($current_number, $current_page, $amount_of_pages)) {
			$menu_html.='<a href="';
			$menu_html.=tootpress_blog_url();
			if($i==0) {
				$menu_html.='" '; // Special Case Number 1 (Perma & Simple)
			}else{
				if($is_perma_enabled){
					// Perma
					$menu_html.=($current_number);
					$menu_html.='/" ';
				} else {
					// Simple
					$menu_html.='&tootpress=';
					$menu_html.=($current_number).'" ';
				}
			}
			$menu_html.='class="tootpress_nav_number ';
			if($current_page==($current_number)) {$menu_html.=' active'; }
			$menu_html.='">';
			$menu_html.=$current_number;
			$menu_html.='</a>';
		}
		
		// Display Dots 		
		if(tootpress_nav_numbers_condition_dots($current_number, $current_page, $amount_of_pages)) {
			$menu_html.='<span class="tootpress_nav_dots">...</span>';
		}
		
	}

	return $menu_html;

}

/**
 * Rules to Display Numbers
 * 
 * @since 0.1
 * 
 * @return bool
 */

function tootpress_nav_numbers_condition_number($current_number, $current_page, $amount_of_pages) {

	// 1
	if($current_number==1) {
		return true;
	}
	// Highest Number
	// Always display the last number: $current_number==($amount_of_pages)
	if ($current_number==($amount_of_pages)) {
		return true;
	}
	// First 5 Numbers
	// Display the first 5 Pages: $current_number <= 5
	// Stop process with page 5: $current_page < 5
	elseif ($current_number <= 5 && $current_page < 5 ) {
		return true;
	}
	// Last 5 Numbers
	// Display 5 Pages before Last Page: $current_number > ($amount_of_pages-5)
	// Start with the fifth last page: $current_page > ($amount_of_pages-4)
	elseif ($current_number > ($amount_of_pages-5) AND $current_page > ($amount_of_pages-4)) {
		return true;
	}
	// 5 Inner Numbers
	// Start = 2 Pages before Current Page: $current_number>($current_page-3)
	// End = 2 Pages after Current Page: $current_number<($current_page+3)
	elseif ($current_number>($current_page-3) && $current_number<($current_page+3)) {
		return true;
	}

	return false;

}

/**
 * Rules to Display Dots
 * 
 * @since 0.1
 * 
 * @return bool
 */

function tootpress_nav_numbers_condition_dots($current_number, $current_page, $amount_of_pages) {

	// Forward Dots
	// Display starting with Page 5: current page>5
	// Display at iteration 1: current number==1
	if($current_page>4 && $current_number==1) {
		return true;
	}
	
	// Backward Dots
	// Activate with more than 6 pages: $amount_of_pages>6
	// Deactivate at fourth last iteration: $current_page<($amount_of_pages-3)
	// Display at second last iteration: current_number==($amount_of_pages-1)
	if ($amount_of_pages>6 
		&& $current_page<($amount_of_pages-3)
		&& $current_number==($amount_of_pages-1)) {
			return true;
	}

	return false;

}

/**
 * Calculates the amount of pages
 * 
 * @since 0.1
 * 
 * @return int Amount of Pages
 */

function tootpress_amount_of_pages() {
	$amount_of_toots=tootpress_get_amount_of_toots();
	$amount_of_toots_on_page=get_option('tootpress_amount_toots_page');
	$amount_of_pages=$amount_of_toots/$amount_of_toots_on_page;
	$amount_of_pages=ceil($amount_of_pages);
	return $amount_of_pages;
}

/**
 * Creates Older Toots Label
 * 
 * @since 0.1
 * 
 * @return string Label
 */

 function tootpress_label_older_toots() {

	if(tootpress_is_language_german()) {
		return 'Ältere Toots';
	} else {
		return 'Older Toots';
	}

}

/**
 * Creates Newer Toots Label
 * 
 * @since 0.1
 * 
 * @return string Label
 */

 function tootpress_label_newer_toots() {

	if(tootpress_is_language_german()) {
		return 'Neuere Toots';
	} else {
		return 'Newer Toots';
	}

}

?>