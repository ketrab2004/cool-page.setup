# cool page setup
based on mini-cms

## Setup:

1. Replace cool-page-setup in different files, depending on how your host does stuff
    * .htaccess
        - RewriteBase
        - RewriteRule
    * ./php/classes/services/PageService.php
        - protected const baseUrl

2. Replace database connection info
    * in ./php/classes/services/DatabaseService.php

3. Make a website 😁

## Usage:

### Controllers:
Controllers basically "control" the website.
They call upon services and use them, then hold the resulting data for models to display.

### Models:
Models are basically pages that create controllers and use them to fill themselves with content.

### Services:
Services provide services that controllers (or maybe sometimes models) can use.
<i>Like in Roblox 🙂</i>
