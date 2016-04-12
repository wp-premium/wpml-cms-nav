# 1.4.17

##Fixes
* [wpmlcmsnav-28] $post->ancestors is a @property-read array should not be set
* [wpmlcmsnav-29] Fixed bug happening when the "auto-save" action was running, and causing some CMS-NAV loss data during post editing
* [wpmlcmsnav-30] Fixed issue with pages' order not being respected

# 1.4.16

##Cleanup
* [wpmlcore-2541] Removal of "icon-32" usage

# 1.4.15

##Fixes
* Removed dead code for handling auto loaded classes: is not used yet
* [wpmlcmsnav-25] Removed `ENGINE=MyISAM` from table creation script

# 1.4.14

##Fixes
* Added backward compatibility for `__DIR__` magic constant not being supported before PHP 5.3.

## Fix
* [wpmlga-96] WordPress 4.4 compatibility: pulled all html headings by one (e.g. h2 -> h1, he -> h2, etc.)

# 1.4.12

## Fix
* Breadcrumb menu for archive pages and CPT single pages

# 1.4.11

## New
* Updated dependency check module

# 1.4.10

## New
* Updated dependency check module

# 1.4.9

## New
* Updated dependency check module

# 1.4.6

## Improvements
* Compatibility with WPML Core

# 1.4.5

## Improvements
* Compatibility with WPML Core

# 1.4.4

## Improvements
* New way to define plugin url is now tolerant for different server settings

## Fix
* Fixed possible SQL injections
* Fixed corrupted WPML settings when new page is added
* Minor syntax fixes

# 1.4.3

## Fix
* mysql_* functions doesn't show deprecated notice when PHP >= 5.5
* Several fixes to achieve compatibility with WordPress 3.9
* Updated links to wpml.org
* Handled case where ICL_PLUGIN_PATH constant is not defined (i.e. when plugin is activated before WPML core)
* Removed unneeded closing php tag followed by line breaks
* Fixed Korean locale in .mo file name


# 1.4.2

## Fix
* Handled dependency from SitePress::get_setting()
* Updated translations

# 1.4.1

## Performances
* Reduced the number of calls to *$sitepress->get_current_language()*, *$this->get_active_languages()* and *$this->get_default_language()*, to avoid running the same queries more times than needed

## Feature
* Added WPML capabilities (see online documentation)

## Fix
* Using CMS Nav in a non content page (e.g. a static page that only calls wp_head()), won't cause any warning because the $post object is null
* When HTTP_USER_AGENT is not set it won't cause any error