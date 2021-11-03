# cool page setup
[![GitHub license](https://img.shields.io/github/license/ketrab2004/cool-page.setup?style=plastic)](https://github.com/ketrab2004/cool-page.setup/blob/master/LICENSE) [![GitHub forks](https://img.shields.io/github/forks/ketrab2004/cool-page.setup?style=plastic)](https://github.com/ketrab2004/cool-page.setup/network) [![GitHub stars](https://img.shields.io/github/stars/ketrab2004/cool-page.setup?style=plastic)](https://github.com/ketrab2004/cool-page.setup/stargazers)

based upon mini-cms

![Image of the homepage](https://user-images.githubusercontent.com/60228292/140168130-aad7cfef-2691-43a9-82e6-9cd6018c42b6.png)

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

### Visual Studio Code setup:
1. Check if the correct files/folders are hidden (for example .vscode and .idea)
2. Check if live sass compiler compiles to the correct directory (```style/css/```) by making a new scss file in ```style/scss/```

### PhpStorm setup:
1. In the project explorer choose the ```Default``` scope
   - Check if the correct files/folders are hidden (for example .idea and .vscode)
2. Turn on the scss file watcher, if it doesn't exist import it from ```.idea/file_watchers/watchers.xml```
   - Check if the file watcher compiles to the correct directory (```style/css```)

## Usage:

### Controllers:
Controllers basically "control" the website.
They call upon services and use them, then hold the resulting data for models to display.

### Models:
Models are basically pages that create controllers and use them to fill themselves with content.

### Services:
Services provide services that controllers (or maybe sometimes models) can use.
<i>Like in Roblox 🙂</i>
