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

<div id="t3-mainbody" class="container t3-mainbody">
  <div class="ja-teline-wrap">
    <div class="row-fluid">
      <!-- MAIN CONTENT -->
      <div id="t3-content" class="t3-content">
        
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
  </div>
  </div>
</div> 