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
  "two_sidebars": {
    "default" : [ "span8"         , "span4"             , "span6"               , "span6"       ],
    "wide"    : [],
    "xtablet" : [ "span8"         , "span4"             , "span12"               , "span12 spanfirst"         ],
    "tablet"  : [ "span12"        , "span12 spanfirst"  , "span12"               , "span12"           ]
  },
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
$mastcol  = 'mast-col';
$sidebar1 = 'sidebar-1';
$sidebar2 = 'sidebar-2';

  // Detect layout
if ($this->countModules($mastcol) or $this->countModules("$sidebar1 and $sidebar2")) {
  $layout = "two_sidebars";
} elseif ($this->countModules("$sidebar1 or $sidebar2")) {
  $layout = "one_sidebar";
} else {
  $layout = "no_sidebar";
}
$layout = $layout_config->$layout;
$col = 0;
?>

<div id="t3-mainbody" class="container t3-mainbody feature-page">

  <div class="row-fluid hidden-phone">
    <div class="span8">
      <?php if ($this->countModules('home-feature-1')) : ?>
        <div class="home-feature<?php $this->_c('home-feature-1')?>">
          <jdoc:include type="modules" name="<?php $this->_p('home-feature-1') ?>" style="T3Xhtml" />
        </div>
      <?php endif; ?>
    </div>
    <div class="span4">
      <?php if ($this->countModules('mast-col-1')) : ?>
        <div class="t3-mastcol t3-mastcol-1<?php $this->_c('mast-col-1')?>">
          <jdoc:include type="modules" name="<?php $this->_p('mast-col-1') ?>" style="T3Xhtml" />
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="ja-teline-wrap">
    <div class="row-fluid">
      <div id="t3-content" class="t3-content <?php echo $this->getClass($layout, $col) ?>" <?php echo $this->getData ($layout, $col++) ?>>
        <!-- NEWS PRO MODULES -->
        <?php
        $positions = array ("ja-news-1", "ja-news-2", "ja-news-3");
        foreach($positions as $key=>$p){
          if (!$this->countModules($p)){
            unset($positions[$key]);
          }
        }

        if (count($positions) > 0 ):
          $positions = array_values($positions);

          $active = JRequest::getVar(JText::_('T3_TPL_ACTIVE_TEMPLATE')."-active-position", '', 'COOKIE');
          if (!in_array($active, $positions)){
            $active = $positions[0];
          }
          ?>
          <div class="row-fluid hidden-phone">
            <div class="ja-blocktab">
              <?php if (count($positions) > 1): ?>
                <div class="ja-blocktab-title clearfix">
                  <ul class="t3-hide">
                    <?php foreach ($positions as $position) : ?>
                      <li class="blocktab-<?php echo $position ?> <?php if ($active==$position) echo "active" ?>" onclick="jaswitchtab ('<?php echo $position ?>')"><span><?php echo JText::_($position) ?></span></li>
                    <?php endforeach ?>
                  </ul>
                </div>

                <?php if (!defined('_SWITCH_TAB_')):
                  define ('_SWITCH_TAB_', 1);
                  ?>
                  <script type="text/javascript">
                    function jaswitchtab (tab) {
                      createCookie('<?php echo JText::_('T3_TPL_ACTIVE_TEMPLATE')."-active-position" ?>', tab, 365);
                      window.location.reload();
                    }
                  </script>
                <?php endif; ?>
              <?php endif; ?>
              <div class="ja-blocktab-content clearfix <?php echo $this->_c($active) ?>">
                <jdoc:include type="modules" name="<?php echo $active ?>" style="T3Xhtml" />
              </div>
            </div>
          </div>

        <?php endif;?>
        <!-- //NEWS PRO MODULES -->

        <?php if($this->getParam('responsive', 1) && $this->countModules('ja-news-mobile')) : ?>
          <div class="row-fluid visible-phone hidden-desktop hidden-tablet">
            <div class="ja-news-mobile <?php $this->_c('ja-news-mobile')?>">
              <jdoc:include type="modules" name="<?php $this->_p('ja-news-mobile') ?>" style="T3Xhtml" />
            </div>
          </div>
        <?php endif ?>


        <jdoc:include type="message" />
        <jdoc:include type="component" />

        <div class="feature-module row-fluid">
          <?php if ($this->countModules('home-feature-2')) : ?>
            <div class="home-feature-2 span6<?php $this->_c('home-feature-2')?>">
              <jdoc:include type="modules" name="<?php $this->_p('home-feature-2') ?>" style="T3Xhtml" />
            </div>
          <?php endif ?>
          <?php if ($this->countModules('home-feature-3')) : ?>
            <div class="home-feature-3 span6<?php $this->_c('home-feature-3')?>">
              <jdoc:include type="modules" name="<?php $this->_p('home-feature-3') ?>" style="T3Xhtml" />
            </div>
          <?php endif ?>
        </div>

      </div>
      <!-- //MAIN CONTENT -->

      <?php if ($this->countModules("$sidebar1 or $sidebar2 or $mastcol")) : ?>
      <div class="t3-sidebar <?php echo $this->getClass($layout, $col) ?>" <?php echo $this->getData ($layout, $col++) ?>>
        <?php if ($this->countModules($mastcol)) : ?>
          <!-- MASSCOL 1 -->
          <div class="t3-mastcol t3-mastcol-1<?php $this->_c($mastcol)?>">
            <jdoc:include type="modules" name="<?php $this->_p($mastcol) ?>" style="T3Xhtml" />
          </div>
          <!-- //MASSCOL 1 -->
        <?php endif ?>

        <?php if ($this->countModules("$sidebar1 or $sidebar2")) : ?>
          <div class="row-fluid">
            <?php if ($this->countModules($sidebar1)) : ?>
              <!-- SIDEBAR 1 -->
              <div class="t3-sidebar t3-sidebar-1 <?php echo $this->getClass($layout, $col) ?><?php $this->_c($sidebar1)?>" <?php echo $this->getData ($layout, $col++) ?>>
                <jdoc:include type="modules" name="<?php $this->_p($sidebar1) ?>" style="T3Xhtml" />
              </div>
              <!-- //SIDEBAR 1 -->
            <?php endif ?>

            <?php if ($this->countModules($sidebar2)) : ?>
              <!-- SIDEBAR 2 -->
              <div class="t3-sidebar t3-sidebar-2 <?php echo $this->getClass($layout, $col) ?><?php $this->_c($sidebar2)?>" <?php echo $this->getData ($layout, $col++) ?>>
                <jdoc:include type="modules" name="<?php $this->_p($sidebar2) ?>" style="T3Xhtml" />
              </div>
              <!-- //SIDEBAR 2 -->
            <?php endif ?>
          </div>
        <?php endif ?>

        <!-- MASSCOL 2 -->
        <?php if ($this->countModules('mast-col-2')) : ?>
          <div class="t3-mastcol t3-mastcol-2<?php $this->_c('mast-col-2')?>">
            <jdoc:include type="modules" name="<?php $this->_p('mast-col-2') ?>" style="T3Xhtml" />
          </div>
        <?php endif ?>
        <!-- //MASSCOL 2 -->
      </div>
      <?php endif ?>
    </div>
  </div>
</div>