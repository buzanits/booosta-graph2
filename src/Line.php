<?php
namespace booosta\graph2;

use \booosta\Framework as b;
use booosta\graph2\Graph2;

class Line extends Graph2
{
  protected $mode = 'number';
  protected $minval, $maxval;
  protected $locale = 'en-US';

  protected set_locale($locale) { $this->locale = $locale; }

  protected $default_options =
  [
    'grid' => ['hoverable' => 'true', 'borderColor' => '#f3f3f3'],
    'series' => ['shadowsize' => '0']
  ];

  public function show_legend()
  {
    $this->set_option('legend', 'show', 'true');
  }

  public function show_points()
  {
    $this->set_option('series', 'points', ['show' => 'true']);
    $this->set_option('series', 'lines', ['show' => 'true']);
  }

  public function get_js()
  {
    if (!is_array($this->data)) return '';
    $linearr = [];

    // set options depending on $this->mode
    switch ($this->mode):
      case 'date':
        $this->set_option('xaxis', 'mode', 'time');
        $this->set_option('xaxis', 'timeBase', 'seconds');
        $this->set_option('xaxis', 'timeformat', '%d.%m.');
        $this->set_option('xaxis', 'timezone', 'browser');
        $this->convert_x_timestamp();
        break;
      case 'datetime':
        $this->set_option('xaxis', 'mode', 'time');
        $this->set_option('xaxis', 'timeBase', 'seconds');
        $this->set_option('xaxis', 'timeformat', '%d.%m. %H:%M');
        $this->set_option('xaxis', 'timezone', 'browser');
        $this->convert_x_timestamp();
        break;
      case 'time':
        $this->set_option('xaxis', 'mode', 'time');
        $this->set_option('xaxis', 'timeBase', 'seconds');
        $this->set_option('xaxis', 'timeformat', '%H:%M');
        $this->set_option('xaxis', 'timezone', 'browser');
        $this->convert_x_timestamp();
        break;
    endswitch;

    // if min or max is set, the other must be calculated
    $calc_minval = false;
    $calc_maxval = false;

    if(is_numeric($this->minval) && !is_numeric($this->maxval)) $calc_maxval = true;
    elseif(!is_numeric($this->minval) && is_numeric($this->maxval)) $calc_minval = true;

    foreach ($this->data as $index => $line) :
      if (!is_array($line)) continue;
      $pointarr = [];

      foreach ($line as $point) :
        if (!is_array($point)) continue;

        $pointarr[] = "[{$point[0]},{$point[1]}]";
        if($calc_minval && ($this->minval === null || $this->minval > $point[1])) $this->minval = $point[1];
        if($calc_maxval && ($this->maxval === null || $this->maxval < $point[1])) $this->maxval = $point[1];
      endforeach;

      if ($this->labels[$index]) $label = $this->labels[$index];
      elseif (is_string($index)) $label = $index;
      else $label = '';

      if ($label) $linearr[] = "{ label: '$label', data: [" . implode(',', $pointarr) . '], }';
      else $linearr[] = '[' . implode(',', $pointarr) . ']';
    endforeach;

    if(!is_numeric($this->minval) && !is_numeric($this->maxval)):
      $this->set_option('yaxis', 'autoScale', 'loose');
    else:
      $this->set_option('yaxis', 'autoScale', 'none');
      $this->set_option('yaxis', 'min', $this->minval);
      $this->set_option('yaxis', 'max', $this->maxval);
    endif;

    $lines = implode(',', $linearr);

    // get options
    $options = $this->get_options();

    // show tooltip
    if ($this->tooltip !== false) :
      if ($this->tooltip === true) $tooltext = "{label} of {x} = {y}";
      else $tooltext = $this->tooltip;

      $tooltext = "'$tooltext'";
      $tooltext = str_replace(['{label}', '{x}', '{y}'], ["' + item.series.label + '", "' + x + '", "' + y +
      '"], $tooltext);

      $libpath = 'lib/modules/graph1';
      $tpl = file_get_contents("$libpath/tooltip.tpl");

      $calculations = '';
      if (in_array($this->mode, ['date', 'time', 'datetime'])) $calculations = "x = new Date(x*1000).toLocaleString('$this->locale', {month: '2-digit', day: '2-digit', hour: '2-digit', minute:'2-digit'}) ";
      $toolcode = str_replace(['{id}', '{tooltext}', '{calculations}'], [$this->id, $tooltext, $calculations], $tpl);
    else :
      $toolcode = '';
    endif;

    return $this->get_ready_code("\$.plot('#$this->id', [ $lines ],\n $options); $toolcode");
  }

  protected function convert_x_timestamp()
  {
    foreach ($this->data as $i => $d)
      foreach ($d as $j => $data)
        $this->data[$i][$j][0] = strtotime($data[0]);
  }
}
