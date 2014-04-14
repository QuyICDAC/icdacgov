<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$hasright = $this->countModules('languageswitcherload or secnav-1 or secnav-2 or secnav-3 or secnav-4');
?>

<!-- MAIN NAVIGATION -->
<nav id="t3-mainnav" class="wrap t3-mainnav container navbar navbar-collapse-fixed-top">
	<div class="navbar-inner">

		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<i class="icon-reorder"></i>
		</button>

		<div class="row-fluid">
			<div class="nav-collapse collapse<?php echo $this->getParam('navigation_collapse_showsub', 1) ? ' always-show' : '' ?>">
				<div class="<?php echo $hasright ? 'span9' : 'span12'?>">
					<?php if ($this->getParam('navigation_type') == 'megamenu') : ?>
						<?php $this->megamenu($this->getParam('mm_type', 'mainmenu')) ?>
					<?php else : ?>
						<jdoc:include type="modules" name="<?php $this->_p('mainnav') ?>" style="raw" />
					<?php endif ?>
				</div>
			</div>

			<?php if($hasright) : ?>
				<div class="span3 secnav">
					<ul class="nav">
						<!-- Language Switcher -->  
						<?php if ($this->countModules('languageswitcherload')) : ?>
							<li id="languageswitcher-block" class="dropdown languageswitcher-block <?php $this->_c('languageswitcherload') ?>">
								<jdoc:include type="modules" name="<?php $this->_p('languageswitcherload') ?>" style="raw" />
							</li>
						<?php endif ?>
						<!-- // Language Switcher -->

						<!-- LOGIN -->
						<?php if($this->countModules('secnav-1')): ?>
							<?php $user = JFactory::getUser(); ?>
							<li class="dropdown nav-user<?php echo ((!$user->get('guest')) ? ' logged' : ''); ?>">
								<a data-toggle="dropdown" href="#" class=" dropdown-toggle">
									<i class="icon-user"></i>
									<?php echo ((!$user->get('guest')) ? '' : JText::_('')); ?>
								</a>
								<div class="nav-child dropdown-menu">
									<div class="dropdown-menu-inner">
										<jdoc:include type="modules" name="<?php $this->_p('secnav-1') ?>" style="T3Xhtml" />
									</div>
								</div>
							</li>
						<?php endif; ?>
						<!-- //LOGIN -->

						<!-- USER, FOLLOW US -->
						<?php if($this->countModules('secnav-2')): ?>
							<li class="dropdown nav-video">
								<a data-toggle="dropdown" href="#" class=" dropdown-toggle">
									<i class="icon-quote-left"></i>
								</a>
								<div class="nav-child dropdown-menu">
									<div class="dropdown-menu-inner">
										<jdoc:include type="modules" name="<?php $this->_p('secnav-2') ?>" style="T3Xhtml" />
									</div>
								</div>
							</li>
						<?php endif; ?>
						<!-- //USER, FOLLOW US -->


						<!-- ACYMAILING -->
						<?php if ($this->countModules('secnav-3')) : ?>
							<li class="dropdown nav-acymailling">
								<a data-toggle="dropdown" href="#" class="dropdown-toggle">
									<i class="icon-rss"></i>
								</a>
								<div class="nav-child dropdown-menu">
									<div class="dropdown-menu-inner">
										<jdoc:include type="modules" name="<?php $this->_p('secnav-3') ?>" style="T3Xhtml" />
									</div>
								</div>
							</li>
						<?php endif ?>
						<!-- //ACYMAILING -->

						<!-- TWITTER -->
						<?php if ($this->countModules('secnav-4')) : ?>
							<li class="dropdown nav-twitter">
								<a data-toggle="dropdown" href="#" class=" dropdown-toggle">
									<i class="icon-twitter"></i>
								</a>
								<div class="nav-child dropdown-menu">
									<div class="dropdown-menu-inner">
										<jdoc:include type="modules" name="<?php $this->_p('secnav-4') ?>" style="T3Xhtml" />
									</div>
								</div>
							</li>
						<?php endif ?>
						<!-- //TWITTER -->
					</ul>
				</div>
			<?php endif ?>
		</div>
	</div>
</nav>
<!-- //MAIN NAVIGATION -->