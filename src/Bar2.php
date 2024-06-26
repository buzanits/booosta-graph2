<?php
namespace booosta\graph2;

use \booosta\Framework as b;
use booosta\graph2\Graph2;

class Bar2 extends Graph2
{
  protected $y_labels;

  public function y_labels($val) { $this->y_labels = $val; }

  public function get_htmlonly()
  {
    return "<canvas id='barChart_$this->id' style='min-height: {$this->height}px; height: {$this->height}px; max-height: {$this->height}px; max-width: 100%;'></canvas>";
  }

  public function get_js()
  {
  #b::debug($this->data);
  if (!is_array($this->data)) return '';

  $dataset = [];

  // always work with two dimensional arrays
  if(!is_array(array_values($this->data)[0])) $this->data = [$this->title => $this->data];

  foreach($this->data as $datasetname => $datasets):
    $i = 1;
    $point = [];
    $tick = [];

    foreach($datasets as $label => $datapoint):
      $point[] = $datapoint;
      $tick[] = "'$label'";
      $i++;
    endforeach;

    $points = '[' . implode(',', $point) . ']';
    $ticks = '[' . implode(',', $tick) . ']';

    if(sizeof($this->colors)) $colors = "['" . implode("','", $this->colors) . "']";
    else $colors = "'#ff0000'";

    $dataset[] = "{
      label               : '$datasetname',
      backgroundColor     : $colors,
      borderColor         : $colors,
      pointRadius         : false,
      pointColor          : $colors,
      pointStrokeColor    : $colors,
      pointHighlightFill  : '#fff',
      pointHighlightStroke: $colors,
      data                : $points
      }";
  endforeach;

  $js = "var areaChartData_$this->id = {
    labels  : $ticks,
    datasets: [\n";

    $js .= implode(',', $dataset);

    $js .= "] }
    var barChartCanvas_$this->id = $('#barChart_$this->id').get(0).getContext('2d')
    var barChartData_$this->id = $.extend(true, {}, areaChartData_$this->id)\n";

    for($i = 0; $i < sizeof($this->data); $i++) $js .= "barChartData_$this->id.datasets[$i] = areaChartData_$this->id.datasets[$i]\n";

    $callback = '';
    $callbackcode = '';
    $use_callback = false;

    if($this->y_labels):
      $use_callback = true;

      $callbackcode .= 'const map = new Map(); ';
      foreach($this->y_labels as $val => $text) $callbackcode .= "map.set($val, '$text'); ";
      $callbackcode .= "return map.get(value); } ";
    endif;

    if($this->unit):
      $use_callback = true;
      $callbackcode .= "return value + ' {$this->unit}'; ";
    endif;

    if($use_callback) $callback = "callback: function(value, index, ticks) { $callbackcode } ";

    $hide_hover = $this->hide_hover ? 'events: [], ' : '';
    $hide_label = $this->hide_label ? 'legend: { display: false }, ' : '';

    $tickoptions = '';
    if($this->maxval) $tickoptions = "suggestedMax: $this->maxval,";

    $js .= "
    var barChartOptions_$this->id = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false, $hide_hover $hide_label
      scales: { yAxes: [{ ticks: { min: 0, stepSize: $this->stepsize, $tickoptions $callback } } ] }
    }

    new Chart(barChartCanvas_$this->id, {
      type: 'bar',
      data: barChartData_$this->id,
      options: barChartOptions_$this->id
    })\n";

    if (is_object($this->topobj) && is_a($this->topobj, '\booosta\webapp\webapp')) :
      $this->topobj->add_jquery_ready($js);
    else:
      return "\$(document).ready(function(){ $js });";
    endif;
    }
}