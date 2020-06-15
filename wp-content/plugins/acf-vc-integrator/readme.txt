=== ACF-VC Integrator ===
Contributors: Frederik Rosendahl-Kaa
Tags: ACF, Advanced Custom Fields, WPBakery Page Builder, WPBakery, Page builder, VC, Visual Composer, Templatera, Grid builder
Requires at least: 4.4.0
Tested up to: 5.2.2
Stable tag: 1.8.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

The ACF-VC Plugin puts a ACF element into your WPBakery Page Builder (Visual Composer), making it easier than ever to use your custom created fields in your own page design.

== Description ==

Advanced Custom Fields right inside your WPBakery Page Builder (Visual Composer)

The ACF-VC Plugin puts a ACF element into your WPBakery Page Builder (Visual Composer), making it easier than ever to use your custom created fields in your own page design.

All Advanced Custom Fields are supported, and easy to target with your own CSS classes for ultimative design possibilities.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/acf-vc-integrator directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. The plugin requires no configuration on itself, but requires Advanced Custom Fields AND Visual Composer plugins to be active.


== Frequently Asked Questions ==

= Supported WPBakery features =

* Templatera
* Grid Builder

= Supported ACF fields =

* Text
* Text Area
* Number
* Range
* Email
* Url
* Password
* Image
* File
* Wysiwyg Editor
* oEmbed
* Gallery
* Select
* Checkbox
* Radio Button
* Button Group
* True / False
* Link
* Post Object
* Page Link
* Relationship
* Taxonomy
* User
* Google Map
* Date Picker
* Date Time Picker
* Time Picker
* Color Picker
* Repeater
* Flexible Content
* Clone

= Google Map API =
To use google map you need a google map api key.
Read more on [https://www.advancedcustomfields.com/resources/google-map#google-map%20api](https://www.advancedcustomfields.com/resources/google-map#google-map%20api)

== Changelog ==

= 1.8.1 =
Release Date: October 7, 2019

* Bug fix: Default fields for google map settings showed incorrect info after saving.

= 1.8.0 =
Release Date: October 5, 2019

* Change: Updated Google map field output to use the Google Maps JavaScript API instead of using Google map embed code for output.
* New stuff: Added option to adjust google map settings.
* New stuff: Added prepend text, link text ( custom link text, Title, filename ), link target for file field.
* New stuff: Added option to select custom label in show label option field.
* Updated languages file

= 1.7.4 =
Release Date: July 31, 2019

* Bug fix: Gallery field output not working in some themes.

= 1.7.3 =
Release Date: June 24, 2019

* Added option to display a header row for repeater fields

= 1.7.2 =
Release Date: April 23, 2019

* Bug fix: $field['type'] could not be found using acf_vc_add_on_fields filter hook

= 1.7.1 =
Release Date: April 17, 2019

* Bug fix: prepend and append not showing up when using grid builder
* Bug fix: CSS editor not working in grid builder
* Bug fix: Removed double div on output when using acf-vc grid builder element
* Added field type class on output div for acf-vc grid builder element


= 1.7.0 =
Release Date: March 17, 2019

* New stuff: Added prepend and append support for Text, Number, Range, Email And Password fields
* Bug fix: The select field with return format set to array now returns the label instead of array.
* Removed some notice and warnings.
* Clean up some of the code

= 1.6.2 =
Release Date: January 24, 2019

* Added supprt for acf link field

= 1.6.1 =
Release Date: December 26, 2018

* Bug fix: Create check for acf_get_options_pages function exists

= 1.6.0 =
Release Date: December 20, 2018

* Added support for ACF Options page
* Updated languages file

= 1.5.0 =
Release Date: November 24, 2018

* Added support for WPBakery Grid Builder
* Added display of field name on ACF-VC element in backend for better view if you use multiple ACF-VC elements
* Removed changelog file from admin page and insert link to WordPress Repository changelog
* Clean up some of the code

= 1.4.2 =
Release Date: November 7, 2018

* Bug fix: Fixed error when default options not exist in database.
* Removed Notice for a Undefined variable.

= 1.4.1 =
Release Date: November 5, 2018

* Bug fix: Remove Undefined variable Notice for align, clone_field_key and post_id_text

= 1.4.0 =
Release Date: November 5, 2018

* Merge ACF-VC Integrator Pro and ACF-VC Integrator into one free Version
* New stuff: Added Support for Range, Button Group, Date Time Picker, Time Picker, Flexible Content, Clone fields

= 1.3.1 =
Release Date: July 26, 2018

* Bug fix: Removed freemius due to conflict with other plugins like bbpress and postman smtp

= 1.3.0 =
Release Date: July 17, 2018

* New stuff: Support for acf gallery usning wp gallery shortcode
* New stuff: Support for filter hook
* New stuff: Add default options for some fields
* Updated: Updated freemius SDK to lastest version
* Bug fix: Remove some warnings and fixed some bugs

= 1.2.4 =
Release Date: March 28, 2018

* Bug fix: Updated Freemius WordPress SDK: https://wordpress.org/support/topic/fopen-error-after-moving-site-or-changing-web-root-path/

= 1.2.3 =
Release Date: March 7, 2018

* Bug fix: Caused HTTP 500 error when WPBakery Page Builder is disabled

= 1.2.2 =
Release Date: March 7, 2018

* Bug fix: Not Working with WPBakery Version 5.4.6: https://wordpress.org/support/topic/not-working-with-wpbakery-version-5-4-6/

= 1.2.1 =
Release Date: December 12, 2017

* Bug fix: Not working with VC 5.4.5: https://wordpress.org/support/topic/not-working-with-vc-5-4-5/

= 1.2 =
Release Date: October 14, 2017

* New stuff: Support for Templatera
* New stuff: Freemius integration
* New stuff: Hide label if there is no data
* New stuff: Added support of Radio button, Multiple select, date picker, text area, number, email, WYSIWYG, oEmbed field
* New stuff: Added support for Repeater within Repeater within Repeater
* New stuff: Changed repeater from using table to use div
* New stuff: Moved acf-vc admin page under the Settings menu: https://wordpress.org/support/topic/it-would-be-good-if-the-admin-menu-item-could-be-moved/
* Updated: Updated some outdated features
* Bug fix: Minor bugs and warnings
* Bug fix: Relationship Post ID as return format: https://wordpress.org/support/topic/not-working-trying-to-get-property-of-non-object/
* Bug fix: foreach warning

= 1.1.1 =
Release Date: November 21, 2016

* Bug fix: has_cap warning: https://wordpress.org/support/topic/has_cap-is-deprecated-since-version-2-0-0/

= 1.1 =
Release Date: November 18, 2016

* New stuff: Support for the repeater field. Supporting ACF-Pro and the standalone repeater plugin
* New stuff: Supports multiple select
* New stuff: New and improved core structure to support reuse of functions for repeaterfields.
* Bug fix: Error when no taxonomy was selected
* Bug fix: ACF Pro check for plugin
* Bug fix: Error message if ACF or ACF-pro is missing
* Bug fix: Logo Icon was gone on the VC element

= 1.0 =
Release Date: February 8, 2016

* First version of the plugin supporting ACF version 4.4.5 and Visual Composer version 4.8.0.1
