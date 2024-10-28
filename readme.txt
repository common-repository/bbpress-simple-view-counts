=== bbPress Simple View Counts ===
Contributors: jezza101
Donate link: http://www.blogercise.com
Tags: bbpress, views, reads, forum
Requires at least: 3.0.1
Tested up to: 4.4.1
Stable tag: 0.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a count of post views into bbPress 2 forum listing display and into posts.

== Description ==

This plugin will add a count of page views to your bbPress 2 forum.  The plugin inserts the count into two places, 
once on the forum listing page and once at the top of each post.

You can select whether you want a simple hit count, or a unique count of member views.  Or both.  

* The hit count literally counts every time the page is displayed.
* The member count increases each time a member views the page for the first time.  It is a unique count.  This tracks users using their WordPress user ID so if you mess with the user table the tracking will likely break.

Please post in the plugin's WP forum area or mention @jezza101 in a tweet.  This plugin is maintained, I use it on my own forums,  but unless I have a request or it 
breaks I will not be adding new features as it works how I want it to work.

== Installation ==
Upload and install the plugin as normal.  

The options link is under the main Forum menu.  Use this to select if you want to track hit count, member count or both.

== Frequently Asked Questions ==

= Will this plugin slow down my site? =
It works fine on low volume sites, however it does add additional work on every page load so this will lead to a higher burden on your database.  
This could have an impact on a high volume site, the truth is I don't know what the affect might be.  It works perfectly on my site with no complaints.  
Member view tracking requires more work, so don't turn this on unless you really need it.

= The plugin doesn't work quite how I'd like it, can I make a suggestion? =
Sure, get in touch.  The plugin works as I want it to so it is unlikely I will change it unless it breaks.  But sure, feel free to make a 
request, the member tracking was added by request!

= It's hardcoded in English, can you make it language friendly? =
Yes, this will be added in a future version.  Please do let me know if this is important to you and I will prioritise this.

= Can you add a unique count? =
After careful consideration I have decided not to do this.  Tracking unique views is a whole different ball game and is not easy to do.  Even forum software
such as vBulletin shows a hit count.  I want this plugin to stay simple.  If you need to track unique views you are better off using Googe Analytics or
WordPress Stats.

I may add session tracking, so the count won't go up if you just sit an hit F5. But it will if you come back at a later date.

= Does it work with caching plugins? =
I have no idea, I don't use any.  But let me know.  I suspect the only way to make this work would be to regnerate the page on each load but that would defeat 
the point of the page cache. 

= I don't like where the counts show, can you change it? =
Sure, where would you like it to show?  I might replace the voice count as suggested by a user.  But other opinions welcome!

== Screenshots ==
1. bbPress Simple View counts config page
2. View counts as seen on forum page
3. View and member counts as seen on topic page
4. Most viewed posts widget

== Changelog ==

= 0.3 = 
Added most viewed widget

= 0.2.1 =
Rename class to avoid clash in rare instance 

= 0.2 = 
Added member tracking.  The plugin can now give a unique count of member views.

= 0.1 =
* Initial release

