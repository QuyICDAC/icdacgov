<?php
/**
 * @package Jumpmenu Module for Joomla! 1.7
 * @version $Id: 1.0 
 * @author muratyil
 * @Copyright (C) 2012- muratyil
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );
$destination	= $params->get( 'destination');
$heading= $params->get( 'heading', "" );
$headpos = $params->get( 'headpos', "" );
$textalign	= $params->get( 'textalign', "" );
$textdir	= $params->get( 'textdirection', "" );
$url[]	= "!";
$urltext[]= $params->get( 'urltext0', "" );
for ($jtn=1; $jtn<=40; $jtn++)
	{
	$urltext[]= $params->get( 'urltext'.$jtn , "" );
	$url[]	= $params->get( 'url'.$jtn , "" );
	}
?>

<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script><div style="width:auto;">
<table cellpadding="0" cellspacing="0" style="width:100%; text-align: <?php echo $textalign; ?>; textdirection: <?php echo $textdir; ?>;">
	<tr>
		<td><?php echo $heading; ?></td>
		<?php if ($headpos==1)	{echo "</tr><tr>";} ?>
		<td>
		<form name="jumpmenu">
  <select name="jumpmenu" onChange="<?php echo $destination; ?>">
    	<?php 
				for ($i=0; $i<=40; $i++)
					{if ($urltext[$i] != null) { echo "<option value='$url[$i]'>$urltext[$i]</option>"; }}
				?>
</select></form>
</td>
	</tr>
</table>
</div>