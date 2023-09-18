<?php
namespace booosta\graph2;

use \booosta\Framework as b;
use booosta\graph2\Graph2;

class Bar extends Graph2
{
	public function get_js()
  {
    if (!is_array($this->data)) return '';

		$point = [];
		$tick = [];
		$i = 1;

		foreach($this->data as $label => $data):
			$point[] = "[$i,$data]";
			$tick[] = "[$i,'$label']";
			$i++;
		endforeach;

		if(sizeof($this->colors)) $colors = implode("','", $this->colors);
		else $colors = '#ff000';

		$js = "var bar_data_{$this->id} = { data : [";
		$js .= implode(',', $point);
		$js .= "],
		bars: { show: true }
	}
	$.plot('#$this->id', [bar_data_{$this->id}], {
		grid  : { borderWidth: 1, borderColor: '#f3f3f3', tickColor  : '#f3f3f3' },
		series: {
			 bars: {
				show: true, barWidth: 0.5, align: 'center'
			},
		},
		colors: ['$colors'],
		xaxis : { ticks: [";

		$js .= implode(',', $tick);
		$js .= "] } })\n";

    if (is_object($this->topobj) && is_a($this->topobj, '\booosta\webapp\webapp')) :
      $this->topobj->add_jquery_ready($js);
    else :
      return "\$(document).ready(function(){ $js });";
    endif;
	}
}