<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately.
*/

  include(DIR_WS_CLASSES . 'phplot.php');

  $stats = array(array('0', '0', '0'));
  $banner_stats_query = smn_db_query("select year(banners_history_date) as year, sum(banners_shown) as value, sum(banners_clicked) as dvalue from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $banner_id . "' group by year");
  while ($banner_stats = smn_db_fetch_array($banner_stats_query)) {
    $stats[] = array($banner_stats['year'], (($banner_stats['value']) ? $banner_stats['value'] : '0'), (($banner_stats['dvalue']) ? $banner_stats['dvalue'] : '0'));
  }

  $graph = new PHPlot(600, 350, 'images/graphs/banner_yearly-' . $banner_id . '.' . $banner_extension);

  $graph->SetFileFormat($banner_extension);
  $graph->SetIsInline(1);
  $graph->SetPrintImage(0);

  $graph->SetSkipBottomTick(1);
  $graph->SetDrawYGrid(1);
  $graph->SetPrecisionY(0);
  $graph->SetPlotType('lines');

  $graph->SetPlotBorderType('left');
  $graph->SetTitleFontSize('4');
  $graph->SetTitle(sprintf(TEXT_BANNERS_YEARLY_STATISTICS, $banner['banners_title']));

  $graph->SetBackgroundColor('white');

  $graph->SetVertTickPosition('plotleft');
  $graph->SetDataValues($stats);
  $graph->SetDataColors(array('blue','red'),array('blue', 'red'));

  $graph->DrawGraph();

  $graph->PrintImage();
?>
