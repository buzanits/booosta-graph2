<?php
namespace booosta\graph2;

use \booosta\Framework as b;
b::init_module('graph2');

class Graph2 extends \booosta\ui\UI
{
  use moduletrait_graph2;

  protected $id;
  protected $title;
  protected $data;
  protected $height, $width;
  protected $options = [], $colors = [], $labels, $tooltip = false;


	public function __construct($name, $data = null, $title = null, $height = 300, $width = 400)
  {
    parent::__construct();

    $this->id = "graph2_$name";
    if($data === null) $data = [];
    $this->data = $data;
    $this->title = $title;
    $this->height = $height;
    $this->width = $width;
  }

  public function after_instanciation()
  {
    parent::after_instanciation();

    if(is_object($this->topobj) && is_a($this->topobj, "\\booosta\\webapp\\Webapp")):
      $this->topobj->moduleinfo['graph2'] = true;
    endif;
  }

	public function set_title($title) { $this->title = $title; }
  public function set_data($data) { $this->data = $data; }
  public function set_height($val) { $this->height = $val; }
  public function set_width($val) { $this->width = $val; }
  public function set_colors($val) { $this->colors = $val; }
  public function set_labels($val) { $this->labels = $val; }
  public function set_mode($val) { $this->mode = $val; }
  public function set_tooltip($val = true) { $this->tooltip = $val; }
  public function set_minval($val = true) { $this->minval = $val; }
  public function set_maxval($val = true) { $this->maxval = $val; }

	public function add_data($data)
  {
    if (is_array($data)) $this->data = array_merge($this->data, $data);
    else $this->data[] = $data;
  }

  public function set_option($name, $value, $value1 = null)
  {
    if ($value1 === null) $this->options[$name] = $value;
    else $this->options[$name][$value] = $value1;
  }

	protected function get_options()
  {
    $options = array_replace_recursive($this->default_options, $this->options);

    #\booosta\debug($options);
    #\booosta\debug($this->get_suboptions($options));

    $result = $this->get_suboptions($options);

    return $result;
  }

  protected function get_suboptions($options)
  {
    if(is_array($options)):
      $result = '';
      foreach ($options as $name => $opt) $result .= " $name: " . $this->get_suboptions($opt) . ", ";
      if (is_array($this->colors)) $result .= 'colors: ["' . implode('", "', $this->colors) . '"], ';

      return " { $result } ";
    endif;

    return "'$options'";
    #return is_numeric($options) ? $options : "'$options'";
  }

  public function get_html_includes($libpath = 'lib/modules/graph2') {}

  public function get_htmlonly()
  {
    return "<div id='$this->id' style='height: {$this->height}px;'></div>";
  }

	protected function random_color()
	{
		$r = random_int(0, 255);
		$g = random_int(0, 255);
		$b = random_int(0, 255);

		return sprintf("#%02x%02x%02x", $r, $g, $b);
	}

  public function get_js() {}   // to override
}