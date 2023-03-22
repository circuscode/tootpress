# TootPress WordPress Plugin

TootPress copies your toots from Mastodon to WordPress continuously.

## Description

The plugin copies your toots from Mastodon continuously and saves them into the WordPress database. The toots can be displayed on the blog chronologically (but do not have to). Indeed, Mastodon is also blogging, micro-blogging so to speak.  

## Functions

* Copy your toots back
* Copy your tooted images back
* Display your toots on the blog
* Retrieve your complete timeline
* Languague: English, German (only FrontEnd)

## Installation

1. Download the plugin from the GitHub Repository (see Releases)
2. Rename the folder to "tootpress"
2. Upload the plugin to the WordPress Plugin Directory
3. Activate the plugin in WordPress
4. Follow the configuration manual

## Configuration

1. Create an Application on your Mastodon Instance for API Access (Account Settings/Applications)
2. Restrict the Authorization of the Application to Read (all data)
3. Maintain Mastodon Instance and Access Token in the TootPress Settings
4. Retrieve your Account ID (WordPress Tools/Toots)
5. Maintain the Account ID in the TootPress Settings
6. Create a new WordPress Page and add the Page to your Main Menu
7. Maintain the Page ID in the TootPress Settings (see URL editing the Page)
8. Run Mastodon API Request once (WordPress Tools/Toots)
9. Activate Steady Fetch
10. That's it!

## CSS classes

TootPress comes with basic CSS Styles. For best fit it is required to add additional styles in your theme. All TootPress UI elements can be addressed with individual CSS selectors. Please use browser debugger to find the right classes. 

## TootPress API

WordPress Action: tootpress_toots_update (fired on toot update)

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

## Not supported Toot Types

Following toot types are not supported.

* Boosts
* Replys
* Private Toots

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
* WordPress Functions
* File Functions

## Frequently Asked Questions

### Which Toots are displayed in the blog?

Only your own toots will be displayed. Boosts (these are not your toots), Replys (these are communication, no micro-posts) and private Toots are excluded.

### Can the toots be loaded automaticly?

Yes. Activate Steady Fetch for this.

### How many toots will be loaded with an API Request?

40 toots at maximum.

### How often will the toots be loaded?

As Standard your toots will be fetched from Mastodon every 15 minutes. But you can define the period in minutes different in the plugin settings.

### Can I load my complete Mastodon timeline?

Yes. You can load your complete Mastodon timeline with this plugin. Just run the corresponding function. The Load will take some time. Every 5 minutes 40 toots will be loaded until the timeline is complete.

### What do I have to do first, activate steady fetch or load the complete timeline first?

All the same. It works both.

### How does TootPress handle the canonical URL?

TootPress does not modify the existing canonical url handling in WordPress. If you want to change the canonical url, you must control that with a SEO plugin. This is relevant for the paged TootPress subpages.

### What have to be considered with the usage of caching plugins?

The length of the cron period in combination with the configuration of caching determines how early a toot will be displayed within the blog. If a toot should be displayed as early as possible, the caching must be deactivated for the page including the toots. Another possibility is removing the affected page from the cache, if new toots have been loaded. For this, a WordPress Action is fired by the plugin (see above).

### Why require some updates a reset of the plugin and reload of the data?

The plugin does still not have a high maturity grade. It is in a early stage of development. To avoid data inconsistency and process errors some updates require a reload of the data.

### Does TootPress support WordPress Multisite?

No. TootPress does not support the WordPress Multisite Feature. The plugin is working on the master-site, but is not working on all other child sites within the wordpress network.

### Can TootPress load toots from several Mastodon instances?

No.

## Live Demo

[Here!](https://www.unmus.de/troets/)

## Branches

This repository follows the git-flow workflow to a large extent.

* master branch is the latest release
* develop branch is the current state of development
* feature branches contain dedicated features in development
* bugfix branches contain dedicated bugfixes in development

Hotfix and release branches will not be applied.

## Built With

* [Visual Studio Code](https://code.visualstudio.com)
* [JSON Viewer](https://jsonviewer.app)

## License

This project is licensed under the GPL3 License.

## Changelog

### 0.1 "Ms. Marvel"

* March 2023
* Initial Release