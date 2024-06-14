=== TootPress ===
Contributors: unmus
Tags: mastodon, toots, microblogging, blog, fediverse
Requires at least: 6.1
Tested up to: 6.5
Stable tag: 0.4
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
* Emojis
* Teaser

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

**Filter: tootpress_preamble_add**  
It outputs html content before the toot loop.  
You can use the following code.

`function tootpress_preamble_add( $preamble ) {`
``
`    // Add your filter code here`
`	 // Example: $preamble='<p>Hello World.</p>';`
``
`    return $preamble;`
``
`}`
`add_filter( 'tootpress_preamble_filter', 'tootpress_preamble_add', 10, 1 );`

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

== Changelog ==

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

= 0.4 =
This version includes a preamble filter.

= 0.3 =
This version brings gallery support and contains major bugfixes.

= 0.2.1 =
This version includes bugfixing only.