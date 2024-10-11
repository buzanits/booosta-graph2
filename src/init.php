<?php
namespace booosta\graph2;

\booosta\Framework::add_module_trait('webapp', 'graph2\webapp');

trait webapp
{
  protected function preparse_graph2()
  {
    #$libpath = 'vendor/npm-asset/flot';
    $libpath = 'vendor/almasaeed2010/adminlte/plugins/flot';
    $chartlibpath = 'vendor/almasaeed2010/adminlte/plugins/chart.js';

    if($this->moduleinfo['graph2']):
      $this->add_includes("<script type='text/javascript' src='{$this->base_dir}{$libpath}/jquery.flot.js'></script>
            <script type='text/javascript' src='{$this->base_dir}{$libpath}/plugins/jquery.flot.time.js'></script>
            <script type='text/javascript' src='{$this->base_dir}{$libpath}/plugins/jquery.flot.resize.js'></script>
            <script type='text/javascript' src='{$this->base_dir}{$libpath}/plugins/jquery.flot.pie.js'></script>
            <script type='text/javascript' src='{$this->base_dir}{$chartlibpath}/Chart.min.js'></script>
            <link rel='stylesheet' type='text/css' href='{$this->base_dir}vendor/booosta/graph2/src/jquery.flot.css' media='screen' />");
    endif;
  }
}
