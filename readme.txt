=== TootPress ===
Contributors: unmus
Tags: mastodon, toots, microblogging, blog, fediverse
Requires at least: 6.1
Tested up to: 6.8
Stable tag: 0.5
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

TootPress copies your toots from Mastodon to WordPress.

== Description ==

TootPress copies your toots from Mastodon to WordPress continuously. The toots can be displayed chronologically in the blog, making your timeline accessible to other people outside of Mastodon. In addition, you regain ownership of your own data back. 

= Features =

* Copy your toots back
* Copy your tooted images back
* Display your toots on the blog
* Retrieve your complete timeline
* Languague: English, German (only FrontEnd)

= Live Demo =

[Here!](https://www.unmus.de/troets/)

== Setup Manual ==

1. Install the Plugin in WordPress
2. Create an Application on your Mastodon Instance to get API Access (under Settings/Development)
3. Restrict the Authorization of the created Application to Read (all data)
4. Maintain Mastodon Instance and Access Token in the TootPress Settings
5. Retrieve your Account ID (in WordPress under Tools/Toots)
6. Maintain the Account ID in the TootPress Settings
7. Create a new WordPress Page and add the Page to your Menu
8. Maintain the Page ID in the TootPress Settings (you find the Page ID in URL of the Browser when editing the Page in WordPress)
9. Run Mastodon API Request once (in WordPress under Tools/Toots)
10. Activate Steady Fetch
11. That's it!

== Instructions for Use ==

* You find TootPress in WordPress in the area of Settings and Tools
* Steady Fetch activates the automatic and regular load of new toots
* First API Request will copy your last 40 toots
* New toots will be loaded every 15 minutes (customizable)
* You can load your complete timeline into WordPress with the eponymous function
* Loading your complete timeline can take several hours depending of the amount of toots
* 480 toots are loaded per hour as maximum
* You can run a Mastodon API Request everytime at your own with the eponymous function
* There is no prescribed order for the execution of Steady Fetch, Complete Timeline or manual requests
* If problems occur, TootPress provides a Healthy Check

== Further Information ==

= Supported Toot Objects =

Following toot objects are supported.

* Text
* Images
* Galleries
* URLs
* Hashtags
* Mentions

= Not supported Toot Objects =

Following toot objects are not supported.

* Audio
* Video
* Poll
* Teaser
* Quotes

= Excluded Toot Types =

Following toot types are excluded from the data transfer.

* Boosts
* Replys
* Private Toots

= Architecture =

Data storage and process logic is separated from the WordPress Framework. The toots are not saved in the table wp_posts. And TootPress is not registering a custom post type for the toots as well.

= CSS classes =

TootPress comes with basic CSS Styles. For best fit it is required to add additional styles in your theme. All TootPress UI elements can be addressed with individual CSS selectors. Please use the browser development tools to find the right classes. 

= Data & Files =

TootPress creates 2 folders within the WordPress Uploads Directory.

* tootpress-mastodonapidata = Archive of the received Mastodon API data
* tootpress-images = Toot Image Folder 

= wpCrons =

* Steady Fetch (every 15 minutes, customizable)
* Load Complete Timeline (every 5 minutes)

= TootPress API =

**Action: tootpress_toots_update**  
It will be fired after toot update to execute custom post-processing.  
You can use the following code.

`function tootpress_toots_update_postprocessing() {`
``
`    // Add your code to be executed here`
``
`}`
`add_action('tootpress_toots_update', 'tootpress_toots_update_postprocessing');`

**Filter: tootpress_preamble_filter**  
It outputs html content before the toot loop.  
You can use the following code.

`function tootpress_preamble_add( $preamble ) {`
``
`    // Add your filter code here`
`    // Example: $preamble='<p>Hello World.</p>';`
``
`    return $preamble;`
``
`}`
`add_filter( 'tootpress_preamble_filter', 'tootpress_preamble_add', 10, 1 );`

**Filter: tootpress_closing_filter**  
It outputs html content after the last toot loop.  
You can use the following code.

`function tootpress_closing_add( $content ) {`
``
`    // Add your filter code here`
`    // Example: $content='<p>Hello World.</p>';`
``
`    return $content;`
``
`}`
`add_filter( 'tootpress_closing_filter', 'tootpress_closing_add', 10, 1 );`

**Filter: tootpress_menu_forward_label**  
This filter overwrites the forward label in the bottom navigation.   
You can use the following code.

`function tootpress_menu_forward_label_change( $label ) {`
``
`    // Add your filter code here`
`    // Example: $label='Newer Posts';`
``
`    return $label;`
``
`}`
`add_filter( 'tootpress_menu_forward_label', 'tootpress_menu_forward_label_change', 10, 1 );`

**Filter: tootpress_menu_backward_label**  
This filter overwrites the backward label in the bottom navigation.   
You can use the following code.

`function tootpress_menu_backward_label_change( $label ) {`
``
`    // Add your filter code here`
`    // Example: $label='Older Posts';`
``
`    return $label;`
``
`}`
`add_filter( 'tootpress_menu_backward_label', 'tootpress_menu_backward_label_change', 10, 1 );`

**Filter: tootpress_beforeloop_filter**  
This filter outputs content before the toot loop (on all tootpress pages).  
You can use the following code.

`function tootpress_beforeloop_filter_add( $content, $page_number ) {`
``
`    // Add your filter code here`
`    // Example: $content='<p>Page '.$page_number.'</p>';`
``
`    return $label;`
``
`}`
`add_filter( 'tootpress_beforeloop_filter', 'tootpress_beforeloop_filter_add', 10, 2 );`

**Filter: tootpress_afterloop_filter**
This filter outputs content after the toot loop (on all tootpress pages).
You can use the following code.

`function tootpress_afterloop_add( $content, $current_page_number, $last_page_number ) {`
``
`    // Add your filter code here`
`    // Example: $content='<p>Page '.$current_page_number.' of '.$last_page_number.'</p>';`
``
`    return $content;`
``
`}`
`add_filter( 'tootpress_afterloop_filter', 'tootpress_afterloop_add', 10, 3 );`

**Filter: tootpress_mastodon_logo_filter**
This filter overwrites the Mastodon Logo with Custom Logo.
You can use the following code.

`function tootpress_mastodon_logo_change ( $img ) {`
``
`    // Standard Value`
`    // <img class="toot-symbol" src="FILE-URL" alt="Toot Symbol" width="35" height="37"/>`
``
`    // Add your filter code here`
`    // Example: $img='<img class="toot-symbol" src="FILE-URL" alt="Custom Toot Symbol" width="32" height="32"/>';`
``
`    return $img;`
``
`}`
`add_filter( 'tootpress_mastodon_logo_filter', 'tootpress_mastodon_logo_change', 10, 1 );`

**Filter: tootpress_between_filter**
This filter adds custom HTML between the toots.
You can use the following code.

`function tootpress_create_element_between ( $content ) {`
``
`    // Add your filter code here`
`    // $content='<hr/>';`
``
`    return $content;`
``
`}`
`add_filter( 'tootpress_between_filter', 'tootpress_create_element_between', 10, 1 );`

**Filter: tootpress_toot_content_filter**
This filter can be used to manipulate the toot content.
You can use the following code.

`function tootpress_manipulate_content ( $content ) {`
``
`    // Add your filter code here`
`    // $content=str_replace('href=','target="_blank" href=',$content); `
``
`    return $content;`
``
`}`
`add_filter( 'tootpress_toot_content_filter', 'tootpress_manipulate_content', 10, 1 );`

**Filter: tootpress_date_filter**
This filter overwrites the date output with custom format.
You can use the following code.

`function tootpress_date_custom_format ( $date, $year, $month, $day, $hour, $minute, $second ) {`
``
`    // $date = 2023-05-30 22:40:28`
`    // $year = 2023`
`    // $month = 05`
`    // $day = 30`
`    // $hour = 22`
`    // $minute = 40`
`    // $second = 28`
``
`    // Add your filter code here`
`    // $date=$day.'.'.$month.'.'.$year.' '.$hour.':'.$minute.':'.$second;`
``
`    return $date;`
``
`}`
`add_filter( 'tootpress_date_filter', 'tootpress_date_custom_format', 10, 7 );`

**Filter: tootpress_image_filter**
This filter can be used to manipulate image tags.
You can use the following code.

`function tootpress_image_manipulate ($img_tag,$filename,$description,$width,$height,$image_directory_path,$amount_of_images,$image_number) {`
``
`    // Amount of Images`
`    // ----------------`
`    // 1 = Single Image`
`    // >1 = Gallery + Size of Gallery`
``
`    // Image Number`
`    // ------------`
`    // This number indicates position within the gallery`
``
`    // Add your filter code here`
`    // $img_tag=str_replace('alt=','class="tootpress-image" alt=',$img_tag);`
``  
`    return $img_tag;`
``
`}`
`add_filter( 'tootpress_image_filter', 'tootpress_image_manipulate', 1, 8 );`

= Related Links =

* [Source Code @ GitHub](https://github.com/circuscode/tootpress)
* [Official Plugin Page](https://www.unmus.de/tootpress/) (German)

== Screenshots ==

1. Toots in the Blog
2. Plugin Options
3. Plugin Features

== Frequently Asked Questions ==

= Why are boosts, replys and private toots not supported? =

Boosts are not your toots. Replys are communication, but not micro-posts. Private Toots should stay private.

= How does TootPress handle the canonical URL? =

TootPress does not modify the existing canonical url handling in WordPress. If you want to create a unique canonical url for each TootPress subpage, you must control that with a SEO plugin. This becomes relevant when your toots must be distributed over several pages and the plugin starts the paging process.

= What have to be considered with the usage of caching plugins? =

The length of the cron period in combination with the configuration of caching determines how early a toot will be displayed within the blog. If a toot should be displayed as early as possible, the caching must be deactivated for the page containing the toots. Another possibility is removing the affected page from the cache, if new toots have been loaded. For this, a WordPress Action is fired by the plugin, which then must be processed by your caching plugin.

= How are backlinks to Mastodon displayed? =

Backlinks to Mastodon can be activated in the plugin settings. In this case, the Mastodon Logo, which is shown for each toot, will be extended with an link to the original toot on the corresponding Mastodon instance. Recommendation is not activating the backlinks as this could cause an negative impact on SEO rating.

= Does TootPress support WordPress Multisite? =

No. TootPress does not support the WordPress Multisite Feature. The plugin is working on the master-site, but is not working on all other child sites within the wordpress network.

= Are the toots included in the WordPress Search? =

Unfortunately not.

= Is there any possiblity to modify the outputs on the user interface? =

Almost every content element, which is created by TootPress in the FrontEnd, can be modified. For example, you can replace the Mastodon Logo with another image. Enabeling this, the plugin is providing a bunch of filters. Please read the documentation of the filter above.

= Does TootPress recognize, if a published Toot was edited on Mastodon? =

The plugin does not sync the Toots between Mastodon and WordPress. TootPress is copying the toots just once after they are published on Mastodon. So if a published toot is edited on Mastodon later, TootPress does not recognized this change anymore, if the toot was already copied to WordPress. Reflecting the edit in WordPress there is only the possibility to make the same edit again directly in the WordPress database. The toots are stored in the table tootpress_toots.

= Can toots be loaded from several Mastodon instances? =

No. The plugin does currently not support several Mastodon instances. The architecture is designed to load toots from one single instance. Independent from this, if your toot history is spread over several instances and the timelines does not overlap, you can try to load the timelines one after another. This is not officially supported or tested, but based on user feedback this seems to work surprisingly.

== Changelog ==

= 0.5 "Echo" =

* July 2025
* Feature: Closing Filter
* Feature: Move Forward Label Filter
* Feature: Move Backward Label Filter
* Feature: Before Loop Filter
* Feature: After Loop Filter
* Feature: Mastodon Logo Filter
* Feature: Between Filter
* Feature: Toot Content Filter
* Feature: Date Filter
* Feature: Image Filter
* Changed: DOM Structure
* Renamed: CSS Classes
* Security: Better Output Escaping

= 0.4 "Cassie Lang" =

* June 2024
* Feature: Preamble Filter

= 0.3 "Deadpool" =

* April 2024
* Feature: Support of Gallery Toots
* Feature: Amount of Toots will be shown in WordPress Dashboard
* Feature: Option to activate Backlinks to Mastodon
* Changed: Label of User Interface Section in Plugin Options
* Bugfix: Plugin CSS will now really be activated
* Bugfix: Rewrite Rules will be updated after changed settings 
* Bugfix: Internal Plugin Version will be set corretly
* Bugfix: CSS Option will be set correctly with Restore of default Settings

= 0.2.1 =

* April 2023
* Bugfix: Label for Option Nav Standard will displayed again

= 0.2 "Kate Bishop" =
* April 2023 
* New: Available in WordPress Plugin Directory
* Added: Escaping Echos
* Changed: CSS Enqueuing
* Changed: Retrive Image Files via HTTP API

= 0.1 "Ms. Marvel" =
* March 2023 
* Initial Release

== Upgrade Notice ==

= 0.5 =
This version brings a bunch of filters enabling customization.

= 0.4 =
This version includes a preamble filter.

= 0.3 =
This version brings gallery support and contains major bugfixes.

= 0.2.1 =
This version includes bugfixing only.