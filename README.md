# Line graph for Booosta PHP Framework

This module provides multiple graphs for Booosta PHP Framework

Booosta allows to develop PHP web applications quick. It is mainly designed for small web applications.
It does not provide a strict MVC distinction. Although the MVC concepts influence the framework. Templates,
data objects can be seen as the Vs and Ms of MVC.

Up to version 3 Booosta was available at Sourceforge: https://sourceforge.net/projects/booosta/ From version
4 on it resides on Github and is available from Packagist under booosta/booosta .

## Installation

This module can be used inside the Booosta framework. If you want to do so, install the framework first. See the
[installation instructions](https://github.com/buzanits/booosta-installer) for accomplishing this. If your
Booosta is installed, you can install this module.

You also can use this module in your standalone PHP scripts. In both cases you install it with:

```
composer require booosta/graph2
```

## Usage in the Booosta framework

In your scripts you use the module:

```
# [...]
$map = $this->makeInstance("\\booosta\\graph2\\Line", $data, $title, $height, $width);
$html = $map->get_html();
```

## Usage in standalone PHP scripts

In your PHP script you use:

```
<?php
require_once __DIR__ . '/vendor/autoload.php';

use \booosta\graph2\Line;

$graph = new Line($data, $title, $height, $width);
print $graph->loadHTML();
```

**This README is ongoing work**
