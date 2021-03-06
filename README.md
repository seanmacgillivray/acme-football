# ACME Sports Football Grid
Authored by Sean MacGillivray

Tested and developed with Drupal 8.9.7

## Installation
1. add the repo to your `composer.json` file, ensuring that the `composer/installers` version constraint does not conflict with your project's version constraint for that package:
    ```
     "repositories": [
    {
                "type": "package",
                "package": {
                    "name": "seanmacgillivray/acme_football",
                    "version": "1.0",
                    "type": "drupal-module",
                    "dist": {
                        "type": "zip",
                        "url": "https://github.com/seanmacgillivray/acme-football/archive/1.0.0.zip"
                    },
                    "require" : {
                        "composer/installers": "^1.0"
                    }
                }
            }
    ],
    ```
2. add the path for drupal custom modules: 
    ```
    "extra": {
               "installer-paths": {
                   "web/core": ["type:drupal-core"],
                   "web/libraries/{$name}": ["type:drupal-library"],
                   "web/modules/contrib/{$name}": ["type:drupal-module"],
                   "web/modules/custom/{$name}": ["type:drupal-custom-module"],
         }
        }
    ```
2. install the module: `composer require seanmacgillvray/acme_football`
3. enable the module: `drush pm-enable acme_football`
4. ensure the API Key and API Endpoint values are correct on the config page (`/acme_football/form/config`); these can be found in the default config (`config/install/acme_football.default.yml`)
3. place the "Acme Football Masonry block" in the block layout and choose whether or not you want to display the filters

## Assumptions
* that a block would be a sensible way of putting the component on a page
* that the team logos would remain relatively static and could be part of the code for v1.0
* that some level of caching would be necessary to reduce load on the API server and shrink overall pageload times
* that jQuery would continue to be packaged with Drupal and hence would be a safe dependency
* that the filters for Division and Conference could be mutually exclusive as opposed to combinative
* that CDNs for third-party assets like fonts and JS libraries were safe to use
* that it would be desirable to have the API Endpoint and URL as admin-definable settings and for these to be exported as part of config
* that the API response comes straight from the server and not from a CDN (no CF headers in response), and that every API request is a DB hit to the API server
* that the module should be installable via Composer

## Solution
* build a controller to get the data and cache it
* build a block and use the controller to populate it and do manipulation like the creation of the filter arrays
* wrap markup with a twig template
* use a Google Webfont via CDN to simplify 
* use Sass + Gulp + Autoprefixer for browser cross-compatibility
* add the module's CSS/JS assets as a library, add Masonry (and ImagesLoaded) as a custom library and dependency of the module's library, such that they are all only loaded when needed
* instantiate UI JS behaviours as Drupal Behaviours and manage them with once() so unnecessary/duplicative JS events/behaviours don't occur
* when one filter is changed, reset the other one
* take advantage of the ready availability of SVG logos for awesome mobile/retina sharpness
* log cache hits/misses in DBlog to monitor cache performance

## Future steps
* I harvested the SVGs pretty hastily and they need some viewbox tweaks to add padding where appropriate; alternately restructure the markup and CSS to accomplish this
* theme-appropriate styling
* add options to specify desktop and mobile grid column width and gutter in admin options form
* add custom entities or config to hold the mappings of teams to their logos
* Create a service to return the data to the controller
* caching could definitely be improved
* rewrite the JS in vanilla JS
