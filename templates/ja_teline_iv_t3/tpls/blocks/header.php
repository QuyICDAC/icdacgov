<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

//register the helper class
JLoader::register('TelineIVHelper', T3_TEMPLATE_PATH . '/templateHelper.php');

$sitename = $this->params->get('sitename') ? $this->params->get('sitename') : JFactory::getConfig()->get('sitename');
$slogan = $this->params->get('slogan');
$logotype = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', '') : '';
?>

<!-- HEADER -->
<div class="container topbar">
  <div class="row">
    <div class="span4 ja-time clearfix">
      <div class="ja-day clearfix">
        <?php 
          echo "<span class=\"month\">".date ('m')."</span>";
          echo "<span class=\"date\">".date ('d')."</span>";
          echo "<span class=\"year\">".date ('Y')."</span>";
          echo "<span class=\"day\">".JText::_(strtoupper(date ('D')))."</span>";
         ?>
     </div>
      <div class="ja-updatetime">
        <span><?php echo JText::_('T3_TPL_LAST_UPDATE')?></span><em><?php echo TelineIVHelper::getLastUpdate(); ?></em>
      </div>
    </div>

    <div class="span5 ja-headline">
      <?php if ($this->countModules('headline')) : ?>
          <div class="headline<?php $this->_c('headline')?>">     
            <jdoc:include type="modules" name="<?php $this->_p('headline') ?>" style="raw" />
          </div>
      <?php endif ?>
    </div>
    <div class="span3 ja-search">
       <?php if ($this->countModules('head-search')) : ?>
        <div class="head-search<?php $this->_c('head-search')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
        </div>
        <?php endif ?>
    </div>
  </div>
</div>
<header id="t3-header" class="container t3-header">
  
  <div class="row">

    <!-- LOGO -->
   
	<div class="span6 logo logo-<?php echo $logotype ?>">
		<div class="brand">
			<a <?php echo ($logotype == 'image' && $logoimage) ? '' : 'class="bg-image"' ?> href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
				<?php if($logotype == 'image' && $logoimage): ?>
					<img class="logoimg" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
				<?php endif ?>
				<span><?php echo $sitename ?></span>
			</a>
			<small class="site-slogan hidden-phone"><?php echo $slogan ?></small>
		</div>
	</div>
    <!-- //LOGO -->

    <div class="span6<?php $this->_c('head-advertisement')?>">  
      <?php if ($this->countModules('head-advertisement')) : ?>
      <div class="head-advertisement">
          <jdoc:include type="modules" name="<?php $this->_p('head-advertisement') ?>" style="raw" />
      </div>
      <?php endif ?>
    </div>

  </div>
</header>
<!-- //HEADER -->
