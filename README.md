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
$line = $this->makeInstance("\\booosta\\graph2\\Line", $name, $data, $title, $height, $width);
$html = $line->get_html();
```
`$name` is a unique name for the graph object. 
`$data` is an array in the form `[[x1,y1], [x2, y2] ... ]` holding the coordinates for the line graph. For
showing several lines, make the array three dimensional: `[[[x1,y1], [x2, y2] ...], [[x1,y1], [x2, y2] ... ]]`
`$title` is the title displayed on the graph
`$height` and `$witdh` are the size of the whole graph in pixels

## Usage in standalone PHP scripts

In your PHP script you use:

```
<?php
require_once __DIR__ . '/vendor/autoload.php';

use \booosta\graph2\Line;

$line = new Line($name, $data, $title, $height, $width);
print $line->loadHTML();
```
The meaning of the parameters match those described above.

## Additional functions for all Graph2 Types

```
$graph->set_title($title);  # set the graph title
$graph->set_data($data);    # set the array with the data (explanation above)
$graph->set_height($val);   # set the height of the graphic
$graph->set_width($val);    # set the width of the graphic
$graph->set_colors($val);   # set the colors; an array with the colors of the data lines (#RRGGBB)
$graph->set_labels($val);   # set the labels for the data; array with one entry per data line
$graph->set_mode($val);     # set the mode of the graph ("date", "datetime", "time" or null for standard data)
$graph->set_tooltip($val);  # set the tooltip of the data lines (explanation beneath)
$graph->set_minval($val);   # set the minimum value on the graph
$graph->set_maxval($val);   # set the maximum value on the graph
$graph->hide_hover($val);   # hide any hover functions (boolean)
$graph->hide_label($val);   # hide any labels on data (boolean)
$graph->set_stepsize($val); # set the size of the steps displayed on the graph
$graph->set_unit($val);     # set the unit, which is used in some graph types

**This README is ongoing work**
