# Data charts for Booosta PHP Framework

This module provides multiple charts for Booosta PHP Framework

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
```

`set_data($data)` takes an array with the data to display. It can be two dimensional to display one data line
or three dimensional to display several data lines. The data structure is described above.

`set_tooltip($val)` takes a string or a boolean. With a string the tooltip will be this string with the
placeholders `{label}` for the datas label, `{x}` for the value of the x axis and corresponding `{y}`.
If the parameter is a boolean `true`, the tooltip shows `"{label} of {x} = {y}"`. If it is false, no
tooltip is shown.

```
$graph->add_data($data);    # adds an additional data line which must be a two dimensional array (see above)
$graph->set_option($name, $value, $value1);   # set an option; options depend on the type of graph you draw
```

## Type "Line"

_Line_ shows a line chart. It is possible to draw several lines in one chart. Line is instantiated as described
above.

### Additional functions for Type Line

```
$graph->show_legend();     # show a legend beside the chart
$graph->show_points();     # show a visible point at each data point
```

## Type "Bar"

_Bar_ shows a bar chart.

`$data` is in a different format:
```
$data = ['First' => 4, 'Second' => 1, 'Third' => 3];
```
This shows a chart with three bars with each bar named after the index on the x axis.


### Instantiation in Booosta framework

```
$bar = $this->makeInstance("\\booosta\\graph2\\Bar", $name, $data, $title, $height, $width);
$html = $bar->get_html();
```

### Instantiation as standalone class

```
<?php
require_once __DIR__ . '/vendor/autoload.php';

use \booosta\graph2\Bar;

$bar = new Bar($name, $data, $title, $height, $width);
print $bar->loadHTML();
```

## Type "Bar2"

_Bar2_ shows an enhanced bar chart. The data is formatted like in the _Bar_ type.


### Instantiation in Booosta framework

```
$bar = $this->makeInstance("\\booosta\\graph2\\Bar2", $name, $data, $title, $height, $width);
$html = $bar->get_html();
```

### Instantiation as standalone class

```
<?php
require_once __DIR__ . '/vendor/autoload.php';

use \booosta\graph2\Bar2;

$bar = new Bar2($name, $data, $title, $height, $width);
print $bar->loadHTML();
```

### Additional functions

```
$bar->y_labels($val);   # An array that holds the values of the y axis. Indexed with the value. Example: [0 => 'zero', 1 => 'one', 2 => 'two']
```

## Type "Donut"

_Donut_ shows a donut style chart.

### Instantiation in Booosta framework

```
$donut = $this->makeInstance("\\booosta\\graph2\\Donut", $name, $data, $title, $height, $width);
$html = $donut->get_html();
```

### Instantiation as standalone class

```
<?php
require_once __DIR__ . '/vendor/autoload.php';

use \booosta\graph2\Donut;

$donut = new Donut($name, $data, $title, $height, $width);
print $donut->loadHTML();
```
