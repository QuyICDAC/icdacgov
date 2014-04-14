<?php
/**
 * @package Jumpmenu Module for Joomla! 1.7
 * @version $Id: 1.0 
 * @author muratyil
 * @Copyright (C) 2012- muratyil
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldLine extends JFormField {
	protected $type = 'Line';

	protected function getInput() {
		$text  	= (string) $this->element['text'];
		
		return '<div class="jtFormLine'.(($text != '') ? ' hasText hasTip' : '').'" title="'. JText::_($this->element['desc']) .'"><span>' . JText::_($text) . '</span></div>';
	}
}

/* eof */