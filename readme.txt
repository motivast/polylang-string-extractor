=== Polylang String Extractor ===
Contributors: kierzniak
Tags: polylang, polylang-strings
Requires at least: 3.8
Requires PHP: 5.6
Tested up to: 4.9.4
Stable tag: 0.1.0
License: GPL-2.0-or-later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Polylang String Extractor is a plugin provided for extract translatable strings from WordPress native translation functions like `__()` or `_e()` to Polylang "Strings translations" table.

== Why? ==
Polylang is great plugin for translate WordPress. It provide ease way to translate pages, posts, custom post types and strings. Strings however must be translated with `pll__` or `pll_e` functions and registered with `pll_register_string` to display in "Strings translations" table. It can be very time consuming to adjust your theme or plugin to be compatible with Polylang string translations functionality.

This plugin will scan themes and plugins and search for native WordPress translations functions like `__()` or `_e()`, extract strings from them and add to "Strings translations" table in Polylang.

== Installation ==

1. Visit Plugins > Add New
2. Search for “Polylang String Extractor”
3. Install and activate “Polylang String Extractor"

or

1. Download plugin from wordpres.org repository or [release section](https://github.com/motivast/polylang-string-extractor/releases/latest).
2. Upload the polylang-string-extractor directory to your /wp-content/plugins/ directory
3. Activate the plugin through the"‘Plugins" menu in WordPress

== Frequently Asked Questions ==

== Changelog ==

= 0.1.0 =
* Polylang String Extractor
