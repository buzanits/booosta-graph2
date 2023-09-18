<?php
namespace booosta\graph2;

use \booosta\Framework as b;
use booosta\graph2\Graph2;

class Donut extends Graph2
{
	protected $radius = 1, $innerRadius = 0.5, $showlabel = true;

	public function get_js()
  {
    if (!is_array($this->data)) return '';

		$labels = [];
		$datachunk = [];
		$i = 0;

		foreach($this->data as $index => $value):
			$color = $this->colors[$i++] ?? $this->random_color();
			$datachunk[] = "{ label: '$index', data: $value, color: '$color' }";
		endforeach;

		#$js = "\nvar donutChartCanvas = $('#$this->id').get(0).getContext('2d')\nvar donutData = [ ";
		$js = "\nvar donutData_$this->id = [ ";
		$js .= implode(',', $datachunk);
		$js .= "]\n";

		$showlabel = $this->showlabel ? 'true' : 'false';

		$js .= "$.plot('#$this->id', donutData_$this->id, {
      series: {
        pie: {
          show: true, radius: $this->radius, innerRadius: $this->innerRadius,
          label: { show: $showlabel, radius: 2 / 3, formatter: labelFormatter, threshold: 0.1 }
        }
      },
      legend: { show: false }
    })\n";

		$extrajs = "function labelFormatter(label, series) {
    return '<div style=\"font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;\">'
      + label + '<br>' + Math.round(series.percent) + '%</div>'
    };\n";

    if (is_object($this->topobj) && is_a($this->topobj, '\booosta\webapp\webapp')) :
      $this->topobj->add_jquery_ready($js);
			$this->topobj->add_javascript($extrajs);
    else :
      return "\$(document).ready(function(){ $js }); $extrajs";
    endif;
	}
}