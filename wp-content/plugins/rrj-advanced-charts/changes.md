#CHANGE LOG#

## 1.5.3.1 ##

* hotfix for a bug in custom PHP data after update to 1.5.3

## 1.5.3 ##

* bugfix for PHP < 5.6

## 1.5.2 ##

* added global options for legends font size and color
* added option that removes borders on segments for the Pie and the Polar Area charts

## 1.5.1 ##

* removed forgotten debugging code

## 1.5 ##

* updated ChartJs to v 2.7.2
* Added custom PHP data functions

## 1.4.2 ##

* bugfix with bar charts: bars always stacked for multiple data sets

## 1.4.1 ##

* added a post meta that overrides chart initialization on individual post/page (post type showing UI)

## 1.4 ##

* Added chart initialization setting  (blog wide setting)
* added hidden by default for line, bar, bubble and radar chart.
* added bar group for bar chart
* added background option for pie and polar area chart

## 1.3.2 ##

* bugfix with pie & polar area tooltips

## 1.3.1 ##

* bugfix for PHP < 5.4

## 1.3 ##

* changed plugin name and description to avoid confusion with the new Visual Composer of WPBackery (https://visualcomposer.io/)
* added prefix and suffix to axes of all charts
* added thousand separator, axes color and font family in blog wide setting
* added tooltips format for polar area, radar and pie chart
* added chart blog wide config
* added stack mode for bar chart
* updated ChartJS to v 2.7.1

## 1.2.1 ##

* updated ChartJs to v 2.7.0
* Group chart elements into their own tab (admin UI)

## 1.2 ##

* added CSV import - all chart types but pie and polar area
* added JS data param for all chart types
* added rotation parameter for pie chart
* added custom aspect ratio for all chart types
* display a preloader image for all non-initialized charts - reduce/avoid jumps in document's height while scrolling the page down and several charts are appearing
* added a default value for manually added set for line and bar charts

## 1.1.3 ##

* bugfix: load scripts only in VC screens (conflict with Revolution Slider)

## 1.1.2 ##

* bugfix: in color manipulation class (PHP) for some rgba operations
* updated ChartJS to v 2.6.0
* updated docs

## 1.1.1 ##

* Updated to ChartJs v 2.5.0

## 1.1 ##
* added: custom javascript options field for all chart types
* switched to HTML documentation to allows live previews

## 1.0.1 ##
* added: option to hide Y axis (and X axis when appropriated) ticks (labels)
* added: option to force Y axis to starts from zero for polar area and radar chart
* bugfix: Y axis font color not changing for radial linear axis (radar and polar area)

## 1.0 ##

* initial release