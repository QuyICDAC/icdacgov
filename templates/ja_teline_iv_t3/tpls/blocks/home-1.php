<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<!-- SPOTLIGHT 1 -->
<div class="container home-1">

  <div class="row-fluid clearfix">
  
	<?php if ($this->countModules('home1-1')) : ?>
	  <div class="box-content <?php $this->_c('home1-1')?>">
		<div class="box-module">
		<jdoc:include type="modules" name="<?php $this->_p('home1-1') ?>" style="T3Xhtml" />
		</div>
	  </div>
	<?php endif ?>
	 <?php if ($this->countModules('home1-2')) : ?>
	  <div class="box-content <?php $this->_c('home1-2')?>">
		<div class="box-module">
		<jdoc:include type="modules" name="<?php $this->_p('home1-2') ?>" style="T3Xhtml" />
		</div>
	  </div>
	<?php endif ?>
	 <?php if ($this->countModules('home1-3')) : ?>
	  <div class="box-content <?php $this->_c('home1-3')?>">
		<div class="box-module">
		<jdoc:include type="modules" name="<?php $this->_p('home1-3') ?>" style="T3Xhtml" />
		</div>
	  </div>
	<?php endif ?>
	 <?php if ($this->countModules('home1-4')) : ?>
	  <div class="box-content <?php $this->_c('home1-4')?>">
		<div class="box-module">
		<jdoc:include type="modules" name="<?php $this->_p('home1-4') ?>" style="T3Xhtml" />
		</div>
	  </div>
	<?php endif ?>
	 <?php if ($this->countModules('home1-5')) : ?>
	  <div class="box-content <?php $this->_c('home1-5')?>">
		<div class="box-module">
		<jdoc:include type="modules" name="<?php $this->_p('home1-5') ?>" style="T3Xhtml" />
		</div>
	  </div>
	<?php endif ?>
  </div>

</div>
<!-- //SPOTLIGHT 1 -->