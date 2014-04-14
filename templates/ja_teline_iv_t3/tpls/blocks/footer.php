<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
// Layout configuration
$layout_configf = json_decode ('{  
	"have_footlogo": {
		"default" : [ "span3"  , "span9" ,  "span9" , "span3"],
		"wide"    : [],
		"xtablet" : [ "span4"         , "span8"],
		"tablet"  : [ "span12"        , "span12 spanfirst" ]
	},
	"no_footlogo": {
		"default" : [ "span12", "span8"         , "span4"],
		"wide"    : ["span12"],
		"xtablet" : ["span12"],
		"tablet"  : [ "span12" ]
	}
}');
// positions configuration
$footlogo  = 'footlogo';
$footer = 'footer';

// Detect layout
if ($this->countModules($footlogo)) {
	$layoutf = "have_footlogo";
} else{
	$layoutf = "no_footlogo";
}
$layoutf = $layout_configf->$layoutf;
$colf = 0;
?>

<!-- FOOTER -->
<footer id="t3-footer" class="wrap container">
	<div class="t3-footer">

		<!-- FOOT NAVIGATION -->
		<?php if ($this->checkSpotlight('footnav', 'footer-1, footer-2')) : ?>
		<?php 
			$this->spotlight ('footnav', 'footer-1, footer-2', array(
				'footer-1' => array(
					'default' => 'span8',
					'tablet' => 'span8',
					'xtablet' => 'span8'
					),
				'footer-2' => array(
					'default' => 'span4',
					'tablet' => 'span4',
					'xtablet' => 'span4'
					),

				)
			); 
		?>
		<?php endif; ?>
		<!-- //FOOT NAVIGATION -->

		<section class="t3-copyright">
			<div class="row-fluid">
				<?php if ($this->countModules("$footlogo")) : ?>
					<div class="<?php echo $this->getClass($layoutf, $colf) ?><?php $this->_c($footlogo)?>" id="ja-footlogo" <?php echo $this->getData ($layoutf, $colf++) ?>>		
						<jdoc:include type="modules" name="<?php $this->_p($footlogo) ?>" style="raw"/>
					</div>
				<?php endif; ?>
				<div class="<?php echo $this->getClass($layoutf, $colf) ?>" <?php echo $this->getData ($layoutf, $colf++) ?>>

					<?php if($this->countModules('footnav or backtotop')) : ?>
						<div class="row-fluid ja-footnav">
							<?php 
							$footnavspan = '';
							$backtotopspan = '';
							if($this->countModules('footnav and backtotop')){
								$footnavspan = 'span10 ';
								$backtotopspan = 'span2 ';
							}else{
								$footnavspan = 'span12 ';
								$backtotopspan = 'span12 ';
							}
							?>

							<?php if($this->countModules('footnav')) : ?>
								<div class="<?php echo $footnavspan;?><?php $this->_c('footnav')?>">
									<jdoc:include type="modules" name="<?php $this->_p('footnav') ?>" style="raw" />
								</div>
							<?php endif; ?>

							<?php if($this->countModules('backtotop')) : ?>
								<div class="<?php echo $backtotopspan;?><?php $this->_c('backtotop')?>">
									<jdoc:include type="modules" name="<?php $this->_p('backtotop') ?>" style="raw" />
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<div class="row-fluid">
						<div class="<?php echo $this->getClass($layoutf, $colf) ?> copyright<?php $this->_c($footer)?>" <?php echo $this->getData ($layoutf, $colf++) ?>>
							<jdoc:include type="modules" name="<?php $this->_p($footer) ?>" />
						</div>
						<?php if($this->getParam('t3-rmvlogo', 1)): ?>
							<div class="<?php echo $this->getClass($layoutf, $colf) ?> poweredby clearfix" <?php echo $this->getData ($layoutf, $colf++) ?>>
								<a class="t3-logo t3-logo-light pull-right" href="http://t3-framework.org" title="Powered By T3 Framework" target="_blank" <?php echo method_exists('T3', 'isHome') && T3::isHome() ? '' : 'rel="nofollow"' ?>>Powered by <strong>T3 Framework</strong></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	</div>
</footer>
<!-- //FOOTER -->