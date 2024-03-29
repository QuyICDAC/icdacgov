<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	4.5.0
 * @author	acyba.com
 * @copyright	(C) 2009-2013 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
JHTML::_('behavior.modal','a.modal');
if(!include_once(rtrim(JPATH_ADMINISTRATOR,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_acymailing'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'helper.php')){
	echo 'This module can not work without the AcyMailing Component';
}

if(!ACYMAILING_J16){

	class JElementLists extends JElement
	{
		function fetchElement($name, $value, &$node, $control_name)
		{
			$link = 'index.php?option=com_acymailing&amp;tmpl=component&amp;ctrl=chooselist&amp;task='.$name.'&amp;values='.$value.'&amp;control='.$control_name;
			$text = '<input class="inputbox" id="'.$control_name.$name.'" name="'.$control_name.'['.$name.']" type="text" style="width:100px" value="'.$value.'">';
			$text .= '<a class="modal" id="link'.$control_name.$name.'" title="'.JText::_('Select one or several Lists').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}"><button class="btn" onclick="return false">'.JText::_('Select').'</button></a>';

			return $text;
		}
	}
}else{
	class JFormFieldLists extends JFormField
	{
		var $type = 'lists';

		function getInput() {

			$link = 'index.php?option=com_acymailing&amp;tmpl=component&amp;ctrl=chooselist&amp;task='.$this->name.'&amp;values='.$this->value.'&amp;control=';
			$text = '<input class="inputbox" id="'.$this->name.'" name="'.$this->name.'" type="text" style="width:100px" value="'.$this->value.'">';
			$text .= '<a class="modal" id="link'.$this->name.'" title="'.JText::_('Select one or several Lists').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}"><button class="btn" onclick="return false">'.JText::_('Select').'</button></a>';

			return $text;
		}
	}
}
