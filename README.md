# ACME Sports Football Grid
Authored by Sean MacGillivray

Tested and developed with Drupal 8.9.7

## Installation
1. add the repo to your `composer.json` file:
```
 "repositories": [
{
         "type": "package",
         "package": {
           "name": "seanmacgillivray/acme-football",
           "version": "1.0",
           "type": "drupal-module",
           "dist": {
             "type": "zip",
             "url": "https://github.com/seanmacgillivray/acme-football/archive/master.zip"
           },
           "require" : {
             "composer/installers": "v1.0.6"
           }
         }
       },
],
```

2. install the module: `composer require seanmacgillvray/acme_football`
4. ensure the API Key and API Endpoint values are correct on the config page (`/acme_football/form/config`); these can be found in the default config (`config/install/acme_football.default.yml`)
3. place the "Acme Football Masonry block" in the block layout and choose whether or not you want to display the filters

## Assumptions
* that a block would be a sensible way of putting the component on a page
* that the team logos would remain relatively static and could be part of the code
* that some level of caching would be necessary
* that jQuery would continue to be packaged with Drupal and hence would be a safe dependency
* that the filters for Division and Conference could be mutually exclusive as opposed to combinative
* that CDNs for third-party assets like fonts and JS libraries were safe to use
* that it would be desirable to have the API Endpoint and URL as admin-definable settings and for these to be exported as part of config

## Solution
* build a controller to get the data and cache it
* build a block and use the controller to populate it
* use Sass + Gulp + Autoprefixer for browser cross-compatibility
* add the module's CSS/JS assets as a library, add Masonry (and ImagesLoaded) as a custom library and dependency of the module library
* instantiate UI JS behaviours as Drupal Behaviours
* when one filter is changed, reset the other one
* take advantage of the ready availability of SVG logos for awesome mobile/retina sharpness
* cache hits/misses are logged in DBlog

## Future steps
* I harvested the SVGs pretty hastily and they need some viewbox tweaks to add padding where appropriate; alternately restructure the markup and CSS to accomplish this
* Create a service to return the data to the controller
* theme-appropriate styling
* add options to specify desktop and mobile grid column width and gutter in admin options form
* add custom entities or config to hold the mappings of teams to their logos
* caching could definitely be improved
