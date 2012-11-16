Contao Mobile/Desktop Visibility
================================

![screenshot](http://d.pr/i/pDoJ+)

This module extends contao with the feature to decide which content you want to show only on desktop browsers and which
only on mobile browsers.

It adds two options: "mobile invisible" and "desktop invisible" to content-elements, articles and pages.
Note: It does NOT really block pages for the browser groups, but hide invisible pages from all menus.

Changelog
---------
Update from Nov 16th, 2012: Respect Cookie, set by toggle_view url parameter.


Notice
------
This is a early test version and altough no errors occured so far, it should not be used in a production environment.

I applied a few "bad practices" to weasel some additional AJAX functionality into the CMS, as well as monkey-patches
to extend the native palettes.
I feel really sad about this. If you have another solution, then please fork this project and send me a pull request.


Requirements & Installation
---------------------------
This module makes use of the Contao 3 mobile device detection, so you will need Contao 3 or up to use it.
To install it, create the folder `/system/modules/kiss_mobile-visibility` in your contao folder.

After you copied the module files, you have to run the contao install tool, or do a database update from the extension manager
before you access the backend-modules "articles" and/or "site structure".