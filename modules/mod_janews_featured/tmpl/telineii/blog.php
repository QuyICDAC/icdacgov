<?php
/**
 * ------------------------------------------------------------------------
 * JA News Featured Module for J25 & J32
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

defined('_JEXEC') or die('Restricted access');
/* This template for headline (frontpage): first news with big image and next news with smaller images*/
$showhlreadmore 		= 	intval (trim( $helper->get( 'showhlreadmore', 0 ) ));
$bigitems 				= intval (trim( $helper->get( 'bigitems', 1) ));
$bigmaxchar 			= $helper->get ( 'bigmaxchars', 200 );
$bigshowimage 			= $helper->get ( 'bigshowimage', 1 );
$smallmaxchar 			= $helper->get ( 'smallmaxchars', 100 );
$smallshowimage 		= $helper->get ( 'smallshowimage', 1 );
$i = 0;
?>
<?php if(count($rows) > 0) : ?>
<div id="jazin-hlwrap-<?php echo $module->id?>" class="<?php echo $theme?>">
<div id="ja-zinfp-<?php echo $module->id?>" class="clearfix">

	<div class="ja-zinfp-featured column clearfix">
		
		<?php foreach ($rows as $news) :
		$pos = ($i==0 || $i==$bigitems)?'first':(($i==count($rows)-1 || $i==$bigitems-1)?'last':'');
		if($i<$bigitems) : //First new?>

			<div class="ja-zincontent inner clearfix <?php echo $pos;?>">
				<?php if($bigshowimage) echo $news->bigimage?>
				<h4 class="ja-zintitle">
					<a href="<?php echo $news->link;?>" title="<?php echo strip_tags($news->title); ?>">
						<?php echo $news->title;?>
					</a>
				</h4>
				<?php echo $bigmaxchar > strlen($news->bigintrotext)?$news->introtext:$news->bigintrotext?>
				<?php if ($showhlreadmore) {?>
				<a href="<?php echo $news->link?>" class="readon" title="<?php echo JText::_('JAFP_READ_MORE');?>"><span><?php echo JText::_('JAFP_READ_MORE');?></span></a>
				<?php } ?>
			</div>

		<?php if($i==$bigitems-1):?>
	</div>

	<div class="ja-zinfp-normal column clearfix">
	<?php endif;?>
	<?php else: ?>
		<div class="ja-zincontent inner clearfix <?php echo $pos;?>">

			<?php if($smallshowimage)	echo $news->smallimage?>

			<h4 class="jazin-title">
				<a href="<?php echo $news->link;?>" title="<?php echo strip_tags($news->title); ?>">
					<?php echo $news->title;?>
				</a>
			</h4>

			<?php echo $smallmaxchar > strlen($news->smallintrotext)?$news->introtext:$news->smallintrotext?>
		</div>
	<?php
	endif;
	++$i;
	endforeach;
	
	?>
	</div>

</div>
</div>
<?php endif; ?>