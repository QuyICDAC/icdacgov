<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php if ($this->checkSpotlight('footer-1, footer-2')) : ?>
<!-- FOOT NAVIGATION -->
<nav class="t3-footnav">
  <?php 
  	$this->spotlight ('footer-1, footer-2')
  ?>
</nav>
<!-- //FOOT NAVIGATION -->
<?php endif ?>