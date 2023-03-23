# TootPress WordPress Plugin

TootPress copies your toots from Mastodon to WordPress continuously.

## Description

TootPress brings your data back and copies your toots from Mastodon to WordPress continuously. The toots will be saved in the WordPress database and can be displayed on the blog chronologically (but do not have to). Indeed, Mastodon is also blogging, micro-blogging so to speak.  

## Functions

* Copy your toots back
* Copy your tooted images back
* Display your toots on the blog
* Retrieve your complete timeline
* Languague: English, German (only FrontEnd)

## Installation

1. Download the plugin from the GitHub Repository (see latest Release)
2. Rename the downloaded folder to "tootpress"
2. Upload the folder to the WordPress Plugin Directory
3. Activate the plugin in WordPress
4. Follow the configuration manual

## Configuration

1. Create an Application on your Mastodon Instance to get API Access (under Settings/Development)
2. Restrict the Authorization of the created Application to Read (all data)
3. Maintain Mastodon Instance and Access Token in the TootPress Settings
4. Retrieve your Account ID (in WordPress under Tools/Toots)
5. Maintain the Account ID in the TootPress Settings
6. Create a new WordPress Page and add the Page to your Menu
7. Maintain the Page ID in the TootPress Settings (you find the Page ID in URL of the Browser when editing the Page in WordPress)
8. Run Mastodon API Request once (in WordPress under Tools/Toots)
9. Activate Steady Fetch
10. That's it!

## Instructions for Use

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

## CSS classes

TootPress comes with basic CSS Styles. For best fit it is required to add additional styles in your theme. All TootPress UI elements can be addressed with individual CSS selectors. Please use the browser development tools to find the right classes. 

## Data & Files

TootPress creates 2 folders within wp-content/uploads.

* tootpress-mastodonapidata = Archive of the received Mastodon API data
* tootpress-images = Toot Image Folder 

## Supported Toot Objects

Following toot objects are supported.

* Text
* Images
* URLs
* Hashtags
* Mentions

## Not supported Toot Objects

Following toot objects are not supported.

* Galleries
* Audio
* Video
* Poll
* Emojis
* Teaser

## Excluded Toot Types

Following toot types are excluded from the data transfer.

* Boosts
* Replys
* Private Toots

## TootPress API

WordPress Action: tootpress_toots_update (fired on toot update)

## TootPress Cron Jobs @ WordPress

* Steady Fetch (every 15 minutes, customizable)
* Load Complete Timeline (every 5 minutes)

## WordPress Framework

Following components of WordPress are used in TootPress.

* HTTP API
* WP-Cron
* Settings API
* Options API
* Rewrite API
* Date Functions
* MySQL Functions
* URL Functions
* File Functions
* Content Functions

## Frequently Asked Questions

### Why are boosts, replys and private toots not supported?

Boosts are not your toots. Replys are communication, but not micro-posts. Private Toots should stay private.

### How does TootPress handle the canonical URL?

TootPress does not modify the existing canonical url handling in WordPress. If you want to create a unique canonical url for each TootPress subpage, you must control that with a SEO plugin. This becomes relevant when your toots must be distributed over several pages and the plugin starts the paging process.

### What have to be considered with the usage of caching plugins?

The length of the cron period in combination with the configuration of caching determines how early a toot will be displayed within the blog. If a toot should be displayed as early as possible, the caching must be deactivated for the page containing the toots. Another possibility is removing the affected page from the cache, if new toots have been loaded. For this, a WordPress Action is fired by the plugin.

### Does TootPress support WordPress Multisite?

No. TootPress does not support the WordPress Multisite Feature. The plugin is working on the master-site, but is not working on all other child sites within the wordpress network.

## Live Demo

[Here!](https://www.unmus.de/troets/)

## Maturity Grade

* Low maturity level
* Early stage of development
* Future updates may require a complete reload of the toots. 
* To avoid data inconsistancy and process errors 

## Branches

This repository follows the git-flow workflow to a large extent.

* master branch is the latest release
* develop branch is the current state of development
* feature branches contain dedicated features in development
* bugfix branches contain dedicated bugfixes in development

Hotfix and release branches will not be applied.

## Built With

* [Visual Studio Code](https://code.visualstudio.com)
* [Postman](https://postman.com)
* [JSON Viewer](https://jsonviewer.app)

## License

This project is licensed under the GPL3 License.

## Changelog

### 0.1 "Ms. Marvel"

* March 2023
* Initial Release