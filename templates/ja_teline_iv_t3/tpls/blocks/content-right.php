<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Mainbody 3 columns, content in left, mast-col on top of 2 sidebars: content - sidebar1 - sidebar2
 */
defined('_JEXEC') or die;
?>
<?php
  // Layout configuration
  $layout_config = json_decode ('{  
    "one_sidebar": {
      "default" : [ "span10"         , "span2"             , "span12"             ],
      "wide"    : [],
      "xtablet" : [ "span8"         , "span4"             , "span12"             ],
      "tablet"  : [ "span12"        , "span12 spanfirst"  , "span12"            ]
    },
    "no_sidebar": {
      "default" : [ "span12" ]
    }
  }');
  // positions configuration
  $sidebar1 = 'sidebar-1';

  // Detect layout
  if ($this->countModules("$sidebar1")) {
    $layout = "one_sidebar";
  } else {
    $layout = "no_sidebar";
  }
  $layout = $layout_config->$layout;
  $col = 0;
?>

<div id="t3-mainbody" class="container t3-mainbody">
  <div class="ja-teline-wrap">
    <div class="row-fluid">
      <!-- MAIN CONTENT -->
      <div id="t3-content" class="t3-content <?php echo $this->getClass($layout, $col) ?>" <?php echo $this->getData ($layout, $col++) ?>>
        
        <jdoc:include type="message" />

        <?php $this->loadBlock ('navhelper') ?>

        <jdoc:include type="component" />
      
        <?php if ($this->countModules('home-feature-2')) : ?>
            <div class="row-fluid">
                <div class="home-feature-2<?php $this->_c('home-feature-2')?>">
                  <jdoc:include type="modules" name="<?php $this->_p('home-feature-2') ?>" style="raw" />
                </div>
            </div>
        <?php endif ?>
      </div>
	  <!-- //MAIN CONTENT -->
    
    <?php if ($this->countModules("$sidebar1 ")) : ?>
        <div class="t3-sidebar <?php echo $this->getClass($layout, $col) ?>" <?php echo $this->getData ($layout, $col++) ?>>

          <?php if ($this->countModules("$sidebar1")) : ?>
              <div class="row-fluid">
                  <?php if ($this->countModules($sidebar1)) : ?>
                    <!-- SIDEBAR 1 -->
                    <div class="t3-sidebar t3-sidebar-1 <?php echo $this->getClass($layout, $col) ?><?php $this->_c($sidebar1)?>" <?php echo $this->getData ($layout, $col++) ?>>
                      <jdoc:include type="modules" name="<?php $this->_p($sidebar1) ?>" style="T3Xhtml" />
                    </div>
                    <!-- //SIDEBAR 1 -->
                    <?php endif ?>
              </div>
          <?php endif ?>
        </div>
    <?php endif ?>
  </div>
  </div>
</div> 