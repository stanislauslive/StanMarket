<?php
/*
  Copyright (c) 2002 - 2006 SystemsManager.Net

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

/*
  class tableBox {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '0';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . $this->table_border . '" width="' . $this->table_width . '" cellspacing="' . $this->table_cellspacing . '" cellpadding="' . $this->table_cellpadding . '"';
      if ($this->table_parameters != '') $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0; $i<sizeof($contents); $i++) {
        if ($contents[$i]['form']) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if ($this->table_row_parameters != '') $tableBox_string .= ' ' . $this->table_row_parameters;
        if ($contents[$i]['params']) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (is_array($contents[$i][0])) {
          for ($x=0; $x<sizeof($contents[$i]); $x++) {

            if ($contents[$i][$x]['text']) {
              $tableBox_string .= '    <td';
              if ($contents[$i][$x]['align'] != '') $tableBox_string .= ' align="' . $contents[$i][$x]['align'] . '"';
              if ($contents[$i][$x]['params']) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif ($this->table_data_parameters != '') {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if ($contents[$i][$x]['form']) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if ($contents[$i][$x]['form']) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
          } else { 
          $tableBox_string .= '  <td align="left" width="'.SIDE_BOX_LEFT_WIDTH.'" background="'.DIR_WS_INFOBOX . 'box_bg_l.gif"><img src="'.DIR_WS_INFOBOX . 'box_bg_l.gif" width="'.SIDE_BOX_LEFT_WIDTH.'" height="1"></td>  <td'; 
          if ($contents[$i]['align'] != '') $tableBox_string .= ' align="' . $contents[$i]['align'] . '"'; 
          if ($contents[$i]['params']) { 
            $tableBox_string .= ' ' . $contents[$i]['params']; 
          } elseif ($this->table_data_parameters != '') { 
            $tableBox_string .= ' ' . $this->table_data_parameters; 
          } 
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td> <td width="'.SIDE_BOX_RIGHT_WIDTH.'" background="'.DIR_WS_INFOBOX . 'box_bg_r.gif"><img src="'.DIR_WS_INFOBOX . 'box_bg_r.gif" width="'.SIDE_BOX_RIGHT_WIDTH.'" height="1"></td>' . "\n"; 
        }

        $tableBox_string .= '  </tr>' . "\n";
        if ($contents[$i]['form']) $tableBox_string .= '</form>' . "\n";
      }
      $tableBox_string .= '</table>' . "\n";
      if ($direct_output) echo $tableBox_string;
      return $tableBox_string;
    }
  }
*/

  class tableBox {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '0';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . smn_output_string($this->table_border) . '" width="' . smn_output_string($this->table_width) . '" cellspacing="' . smn_output_string($this->table_cellspacing) . '" cellpadding="' . smn_output_string($this->table_cellpadding) . '"';
      if (smn_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && smn_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (smn_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && smn_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && smn_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && smn_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . smn_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && smn_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (smn_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && smn_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && smn_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td';
          if (isset($contents[$i]['align']) && smn_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . smn_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && smn_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (smn_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && smn_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }


/*
  class infoBox extends tableBox {
    function infoBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));
      $this->table_cellpadding = '0';
      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxContents($contents) {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      //$info_box_contents[] = array(array('text' => smn_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0; $i<sizeof($contents); $i++) {
        $info_box_contents[] = array(array('align' => $contents[$i]['align'], 'form' => $contents[$i]['form'], 'params' => 'class="boxText"', 'text' => $contents[$i]['text']));
      }
      //$info_box_contents[] = array(array('text' => smn_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }
  
  class infoBoxHeading extends tableBox {
    function infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';

      if ($left_corner) {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_left.gif');
      } else {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_right_left.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . smn_image(DIR_WS_INFOBOX . 'arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_right.gif');
      } else {
         $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_left_right.gif');

      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="5" class="infoBoxHeading"', 'text' => $left_corner),
                                   array('params' => 'background="'.DIR_WS_INFOBOX . 'background.gif" class="infoBoxHeading" width="100%"', 'text' => $contents[0]['text']),
                                   array('params' => 'height="5" class="infoBoxHeading" nowrap', 'text' => $right_corner));
      $this->tableBox($info_box_contents, true);
    }
  }
  */
  
    class infoBox extends tableBox {
    function infoBox($contents,  $classendbox = '') {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContents($contents, $classendbox));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBox'.$classendbox.'"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxContents($contents, $classendbox = '') {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="infoBoxContents'.$classendbox.'"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => smn_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText'.$classendbox.'"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => smn_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

  class infoBoxHeading extends tableBox {
    function infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false, $class_head = '') {
      $this->table_cellpadding = '0';

      if ($left_corner == true) {
//        $left_corner = smn_image(DIR_WS_IMAGES . 'infobox/corner_left.gif');
        $left_corner = '';
      } else {
//        $left_corner = smn_image(DIR_WS_IMAGES . 'infobox/corner_right_left.gif');
        $left_corner = '';
      }
      if ($right_arrow == true) {
        $right_arrow = '<a href="' . $right_arrow . '">' . smn_image(DIR_WS_IMAGES_COMMON . 'infobox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner == true) {
//        $right_corner = $right_arrow . smn_image(DIR_WS_IMAGES . 'infobox/corner_right.gif');
        $right_corner = $right_arrow;
      } else {
//        $right_corner = $right_arrow . smn_draw_separator('pixel_trans.gif', '11', '14');
        $right_corner = $right_arrow;
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'class="infoBoxHeading'.$class_head.'"',
                                         'text' => $left_corner),
                                   array('params' => 'width="100%" class="infoBoxHeading'.$class_head.'"',
                                         'text' => $contents[0]['text']),
                                   array('params' => 'class="infoBoxHeading'.$class_head.'" nowrap',
                                         'text' => $right_corner));

      $this->tableBox($info_box_contents, true);
    }
  }

  class infoBoxModuleHeading extends tableBox {
    function infoBoxModuleHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';

      if ($left_corner) {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_left_module.gif');
      } else {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_right_left_module.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . smn_image(DIR_WS_INFOBOX . 'arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_right_module.gif');
      } else {
         $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_left_right_module.gif');

      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="5" class="infoBoxHeading"', 'text' => $left_corner),
                                   array('params' => 'class="infoBoxHeading" background="'. DIR_WS_INFOBOX . 'background.gif" width="100%"', 'text' => $contents[0]['text']),
                                   array('params' => 'height="5" class="infoBoxHeading" nowrap', 'text' => $right_corner));
      $this->tableBox($info_box_contents, true);
    }
  }
 class infoBoxFooter extends tableBox {
    function infoBoxFooter($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
     $this->table_cellpadding = '0';

      if ($left_corner) {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_left.gif');
      } else {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_right_left.gif');
      }
       if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . smn_image(DIR_WS_INFOBOX . 'arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_right.gif');
      } else {
        $right_corner = $right_arrow . smn_draw_separator('pixel_trans.gif', '12', '13');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="5" class="infoBoxHeading"', 'text' => $left_corner),
                                   array('params' => 'class="infoBoxHeading" background="'.DIR_WS_INFOBOX . 'backgroundfb.gif" width="100%" height="5"', 'text' => $contents[0]['text']),
                                   array('params' => 'height="5" class="infoBoxHeading" nowrap', 'text' => $right_corner));
      $this->tableBox($info_box_contents, true);
    }
  }

  class infoBoxDefault extends tableBox {
    function infoBoxDefault($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';
      if ($left_corner) {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_left_flip.gif');
      } else {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_left_flip.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . smn_image(DIR_WS_INFOBOX . 'arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_right_flip.gif');
      } else {
        $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_right_flip.gif');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="15" class="infoBoxHeading"', 'text' => $left_corner),
                                   array('params' => 'class="infoBoxHeading" background="'.DIR_WS_INFOBOX . 'backgroundfb.gif" width="100%" height="15"', 'text' => $contents[0]['text']),
 						array('params' => 'height="15" class="infoBoxHeading" nowrap', 'text' => $right_corner));

      $this->tableBox($info_box_contents, true);
    }
  }

  class infoBoxModuleDefault extends tableBox {
    function infoBoxModuleDefault($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';
      if ($left_corner) {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_left_flip_module.gif');
      } else {
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_left_flip_module.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . smn_image(DIR_WS_INFOBOX . 'arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_right_flip_module.gif');
      } else {
        $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_right_flip_module.gif');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="15" class="infoBoxHeading"', 'text' => $left_corner),
                                   array('params' => 'class="infoBoxHeading" background="'.DIR_WS_INFOBOX . 'backgroundfb.gif" width="100%" height="15"', 'text' => $contents[0]['text']),
 						array('params' => 'height="15" class="infoBoxHeading" nowrap', 'text' => $right_corner));

      $this->tableBox($info_box_contents, true);
    }
  }

  class contentBox extends tableBox {
    function contentBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContents($contents));
      $this->table_cellpadding = '0';
      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);
    }

    function contentBoxContents($contents) {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="infoBoxContents"';
      return $this->tableBox($contents);
    }
  }


  class contentBoxHeading extends tableBox {
    function contentBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_width = '100%';
      $this->table_cellpadding = '0';
        $left_corner = smn_image(DIR_WS_INFOBOX . 'corner_left_right.gif');
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . smn_image(DIR_WS_INFOBOX . 'arrow_main.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
              $right_corner = $right_arrow . smn_image(DIR_WS_INFOBOX . 'corner_right_left.gif');


      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="13" class="infoBoxHeading"', 'text' => $left_corner),
                                   array('params' => 'class="infoBoxHeading" background="'.DIR_WS_INFOBOX . 'background.gif" width="100%"', 'text' => $contents[0]['text']),
 						array('params' => 'height="13" class="infoBoxHeading" nowrap', 'text' => $right_corner));

      $this->tableBox($info_box_contents, true);
    }
  }

  class productListingBox extends tableBox {
    function productListingBox($contents) {
      $this->table_parameters = 'class="productListing"';
      $this->tableBox($contents, true);
    }
  }
  
    class storeListingBox extends tableBox {
    function storeListingBox($contents, $newID) {
      $this->table_row_parameters = 'class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . smn_href_link(FILENAME_DEFAULT, 'ID=' . $newID) .'\'"';
      $this->tableBox($contents, true);
    }
  }
  
  class errorBox extends tableBox {
    function errorBox($contents) {
      $this->table_data_parameters = 'class="errorBox"';
      $this->tableBox($contents, true);
    }
  }
  define('SIDE_BOX_LEFT_WIDTH', '8');
  define('SIDE_BOX_RIGHT_WIDTH', '10');
  define('SITE_WIDTH', '100%');
  define('DISPLAY_HEADER_IMAGE', 'false');
  define('BOX_WIDTH', 145); // how wide the boxes should be in pixels (default: 125)
  define('MAX_DISPLAY_FEATURED_PRODUCTS', '3');
  define('MAX_DISPLAY_FEATURED_PRODUCTS_LISTING', '10');
  define('FEATURED_PRODUCTS_DISPLAY', true);
  
 /*Class Added By Cimi*/ 
class tableBlock {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

    function tableBlock($contents) {
      $tableBox_string = '';

      $form_set = false;
      if (isset($contents['form'])) {
        $tableBox_string .= $contents['form'] . "\n";
        $form_set = true;
        array_shift($contents);
      }

      $tableBox_string .= '<table border="' . $this->table_border . '" width="' . $this->table_width . '" cellspacing="' . $this->table_cellspacing . '" cellpadding="' . $this->table_cellpadding . '"';
      if (smn_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $tableBox_string .= '  <tr';
        if (smn_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && smn_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $y=sizeof($contents[$i]); $x<$y; $x++) {
            if (isset($contents[$i][$x]['text']) && smn_not_null(isset($contents[$i][$x]['text']))) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && smn_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . $contents[$i][$x]['align'] . '"';
              if (isset($contents[$i][$x]['params']) && smn_not_null(isset($contents[$i][$x]['params']))) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (smn_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && smn_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && smn_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td';
          if (isset($contents[$i]['align']) && smn_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . $contents[$i]['align'] . '"';
          if (isset($contents[$i]['params']) && smn_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (smn_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($form_set == true) $tableBox_string .= '</form>' . "\n";

      return $tableBox_string;
    }
  }

class box extends tableBlock {
    function box() {
      $this->heading = array();
      $this->contents = array();
    }

    function infoBox($heading, $contents) {
      $this->table_row_parameters = 'class="infoBoxHeading"';
      $this->table_data_parameters = 'class="infoBoxHeading"';
      $this->heading = $this->tableBlock($heading);

      $this->table_row_parameters = '';
      $this->table_data_parameters = 'class="infoBoxContents"';
      $this->contents = $this->tableBlock($contents);

      return $this->heading . $this->contents;
    }

    function menuBox($heading, $contents) {
      $this->table_data_parameters = 'class="menuBoxHeading"';
      if (isset($heading[0]['link'])) {
        $this->table_data_parameters .= ' onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . $heading[0]['link'] . '\'"';
        $heading[0]['text'] = '&nbsp;<a href="' . $heading[0]['link'] . '" class="menuBoxHeadingLink">' . $heading[0]['text'] . '</a>&nbsp;';
      } else {
        $heading[0]['text'] = '&nbsp;' . $heading[0]['text'] . '&nbsp;';
      }
      $this->heading = $this->tableBlock($heading);

      $this->table_data_parameters = 'class="menuBoxContent"';
      $this->contents = $this->tableBlock($contents);

      return $this->heading . $this->contents;
    }
  }
?>