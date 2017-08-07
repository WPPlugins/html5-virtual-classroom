=== BrainCert - HTML5 Virtual Classroom ===
Contributors: BrainCert
Tags: braincert, virtual classroom, html5, webrtc, whiteboard, screen sharing, video conference, audio conference, chat, annotate, wolfram alpha, latex, conference, meeting, webinar, live class, share screen, video player, line tools, blended learning, video chat
Requires at least: 4.5
Tested up to: 4.6.1
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WebRTC powered HTML5 Virtual Classroom to deliver live classes and webinars.


== Description ==
BrainCert's next-generation [HTML5 Virtual Classroom](https://www.braincert.com/online-virtual-classroom) is designed for seamless synchronous and asynchronous collaboration capabilities between presenter (teacher) and attendees (students). BrainCert offers over 12 low-latency datacenter locations worldwide - the largest secure global infrastructure, enabling you to schedule and launch live virtual classroom sessions no matter where you or your attendees may be! 

To use this application, sign up for your free [BrainCert](https://www.braincert.com) account  and register your [API key](https://www.braincert.com/app/virtualclassroom). 

See [Developer documentation](https://www.braincert.com/developer/virtualclassroom-api) for more info. BrainCert provides a RESTful interface to the resources in the Virtual Classroom e.g. classes, video recordings, shopping cart, etc.


== HTML5 Virtual Classroom features: ==
* WebRTC based Ultra HD audio and video conferencing with great resiliency and multiple full HD participants.
* Available in 50 languages. Use API calls to force an interface language or allow attendees to select a language.
* Cloud-based session recording without the need to install any other software or browser plugins. Download recorded lessons as HD MP4 file, share and play online for attendees.
* Group HTML5-based HD Screen Sharing in tabbed interface. Enhance your computer-based training classes by sharing entire screen or just a single application. No software downloads or installations necessary.
* Multiple interactive whiteboards. The staple of all classroom instruction is the whiteboard that supports drawing tool, LaTEX math equations, draw shapes & symbols, line tools, save snapshots, and share documents in multiple tabs.
* Share documents & presentations. Stream Audio/Video files securely.
* Wolfram|Alpha gives you access to the world's facts and data and calculates answers across a range of topics, including science, engineering, mathematics.
* Equations editor, group chat, and powerful annotation feature to draw over uploaded documents & presentations. 
* Responsive whiteboard fits any screen and browser resolution for seamless same viewing experience by all attendees.


== About BrainCert ==
BrainCert (https://www.braincert.com) is a cloud-based all-in-one educational platform that comes integrated with 4 core platforms in one unified solution - courses platform, online testing platform, award-winning virtual classroom, and content management system. The result - significant cost savings, increasing productivity, and secure, seamless and enhanced user experience across all platforms.


== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Plugin Name screen to configure the plugin
1. If you want to show front end live classes in a page, use short code `[class_list_front]` in your page.

[Download](https://www.braincert.com/braincert-support/downloads/category/wordpress) plugin documentation.


== Frequently Asked Questions ==

= Where is the plugin documentation? = 
[Download](https://www.braincert.com/braincert-support/downloads/category/wordpress) plugin documentation.

= What does the FREE plan comes with? = 
The free plan supports 2 connections (1 instructor + 1 attendee) with a maximum duration of 30 minutes per session. It supports 600 minutes of Free API usage. [Upgrade your API account](https://www.braincert.org/membership/premium) to have more active (concurrent) teachers, attendees per live class, and session duration. All paid API plans comes with premium features such as more attendees in a live class, and session recording as HD MP4 file.

= What about branding and white-label solution? = 
So glad you asked! With Virtual Classroom API, you can upload your own logo, set colors & theme, change API endpoint to your own domain, and even map SSL certificate.
1. [How to map your external domain with API endpoint] (https://www.braincert.com/braincert-support/kb/article/how-to-map-your-external-domain-with-api-endpoint)
1. [Setting up SSL encrypted traffic (HTTPS)](https://www.braincert.com/braincert-support/kb/article/setting-up-ssl-encrypted-traffic-https-using-cloudflare-for-html5-virtual-classroom-20160729170543)

= What about Virtual Classroom specific documentation like troubleshooting guide? = 
1. [Virtual Classroom knowledge base](https://www.braincert.com/braincert-support/kb/live)
1. [Developer guide](https://www.braincert.com/developer/virtualclassroom-api)
1. [WordPress plugin documentation](https://www.braincert.com/braincert-support/downloads/category/wordpress)

= Can I use my own shopping cart to sell live classes? =
Most certainly. You can use the API to schedule and launch classes, and use your own shopping cart system to collect payments.

= What is the difference between "Active" and "Registered" Teachers? =
An "active teacher" is any teacher in your website who can launch classes concurrently. For example, "25 active users" means that only 25 teachers can launch a live virtual classroom session at the same time. So, technically you can launch 25 rooms at the same time each with it's own teacher (presenter) and students (attendees). 

A "Registered Teacher" is any teacher who has an user account in your website. You can have unlimited registered teachers created at your end.

= What about security? =
Data security is of utmost importance to us - all our traffic is done over SSL, the web standard for secure data transmission, and files are stored with top-grade secured infrastructure.

== Screenshots ==
1. HTML5 Virtual Classroom
2. Features Overview
3. Low-latency Datacenter Locations Worldwide
4. API Dashboard


== Upgrade Notice ==

= 1.4 =
Changed plugin as per WordPress policy updates addressing security issues and general guidelines.

== Changelog ==

= 1.4 =
* Changed plugin as per WordPress policy updates addressing security issues and general guidelines.

= 1.3 =
* Optimized code and minor security fixes.

= 1.2 =
* Fixed several minor issues.
* Support for external domain and SSL certificate mapping.
* Improved backend query for timezone conversion and loading time.
* Removed restriction for PM/AM classes that previously was giving error message "Classes cannot continue to next day".
* Added support for both HTML5 Virtual Classroom (https://api.braincert.com/v2) and Flash version (https://api.braincert.com/v1).
* Added support for global datacenter server selection using isRegion API call.
* Added support for auto record sessions using isRecord=2 API call.
* Added support to load only whiteboard or entire app with audio/video, and group chat using isBoard API call.
* Added search filters in component for classes, pricing schemes, discounts, etc.,

= 1.1 =
* Fixed Virtual Classroom launch issues with the latest WordPress releases.

= 1.0 =
* Initial Release.