=== TootPress ===
Contributors: unmus
Tags: mastodon, toots, microblogging, blog, fediverse
Requires at least: 6.1
Tested up to: 6.2
Stable tag: 0.2
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

TootPress copies your toots from Mastodon to WordPress.

== Description ==

TootPress brings your data back and copies your toots from Mastodon to WordPress continuously. The toots will be saved in the WordPress database and can be displayed on the blog chronologically (but do not have to). Indeed, Mastodon is also blogging, micro-blogging so to speak.  

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
* URLs
* Hashtags
* Mentions

= Not supported Toot Objects =

Following toot objects are not supported.

* Galleries
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

= CSS classes =

TootPress comes with basic CSS Styles. For best fit it is required to add additional styles in your theme. All TootPress UI elements can be addressed with individual CSS selectors. Please use the browser development tools to find the right classes. 

= Data & Files =

TootPress creates 2 folders within the WordPress Uploads Directory.

* tootpress-mastodonapidata = Archive of the received Mastodon API data
* tootpress-images = Toot Image Folder 

= Cron Jobs =

* Steady Fetch (every 15 minutes, customizable)
* Load Complete Timeline (every 5 minutes)

= TootPress API =

WordPress Action: tootpress_toots_update (fired on toot update)

= Related Links =

* [Source Code @ GitHub](https://github.com/circuscode/tootpress)

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

= Does TootPress support WordPress Multisite? =

No. TootPress does not support the WordPress Multisite Feature. The plugin is working on the master-site, but is not working on all other child sites within the wordpress network.

== Changelog ==

= 0.2 "Kate Bishop" =
* April 2023 
* New: Available in WordPress Plugin Directory
* Added: Escaping Echos
* Changed: CSS Enqueuing
* Changed: Retrive Image Files via HTTP API

= 0.1 "Ms. Marvel" =
* March 2023 
* Initial Release