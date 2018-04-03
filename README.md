# Polylang String Extractor :earth_africa:

[![plugin](https://img.shields.io/wordpress/plugin/v/polylang-string-extractor.svg)](https://wordpress.org/plugins/polylang-string-extractor/) [![downloads](https://img.shields.io/wordpress/plugin/dt/polylang-string-extractor.svg)](https://wordpress.org/plugins/polylang-string-extractor/advanced/) [![rating](https://img.shields.io/wordpress/plugin/r/polylang-string-extractor.svg)](https://wordpress.org/support/plugin/polylang-string-extractor/reviews/) ![php support](https://img.shields.io/badge/php%20support-5.6%2C%207.0%2C%207.1%2C%207.2-8892BF.svg)

[![travis](https://img.shields.io/travis/motivast/polylang-string-extractor.svg)](https://travis-ci.org/motivast/polylang-string-extractor/) ![coverage](https://img.shields.io/codeclimate/coverage/motivast/polylang-string-extractor.svg) ![maintainability](https://img.shields.io/codeclimate/maintainability/motivast/polylang-string-extractor.svg)

Polylang String Extractor is a plugin provided for extract translatable strings from WordPress native translation functions like `__()` or `_e()` to Polylang "Strings translations" table.

## Why? :point_up:
Polylang is great plugin to translate WordPress. It provide ease way to translate pages, posts, custom post types and strings. Strings however must be translated with `pll__` or `pll_e` functions and registered with `pll_register_string` to display in "Strings translations" table. It can be very time consuming to adjust your theme or plugin to be compatible with Polylang string translations functionality.

This plugin will scan themes and plugins and search for native WordPress translations functions like `__()` or `_e()`, extract strings from them and add to "Strings translations" table in Polylang.

## Installation :package:
1. Visit Plugins > Add New
2. Search for “Polylang String Extractor”
3. Install and activate “Polylang String Extractor"

or

1. Download plugin from wordpres.org repository or [release section](https://github.com/motivast/polylang-string-extractor/releases/latest).
2. Upload the polylang-string-extractor directory to your /wp-content/plugins/ directory
3. Activate the plugin through the"‘Plugins" menu in WordPress

## Usage :fire:
After plugin activation Polylang String Extractor will automaticly scan your theme and plugins loooking for WordPress translation functions. If you add plugin or change theme you can reactivate plugin to scan files again.

Supported functions:
* `__()`
* `_e()`
* `_x()`
* `_ex()`
* `esc_attr__()`
* `esc_html__()`
* `esc_attr_e()`
* `esc_html_e()`
* `esc_attr_x()`
* `esc_html_x()`
* `_n()`
* `_nx()`
* `_n_noop()`
* `_nx_noop()`

Polylang String Extractor has support for functions which translate plurals like `_n()` but Polylang itself do not has such a functionality. Translating this kind of strings may cause unexpected results.

## Contribute :hand:
Please make sure to read the [Contribution guide](https://github.com/motivast/polylang-string-extractor/blob/master/CONTRIBUTING.md) before making a pull request.

Thank you to all the people who already contributed to Polylang String Extractor!

## License :book:
The project is licensed under the [GNU GPLv2 (or later)](https://github.com/motivast/polylang-string-extractor/blob/master/LICENSE).

Copyright (c) 2018-present, Motivast
