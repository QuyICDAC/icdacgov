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

class JFormFieldUpdate extends JFormField {
	protected $type = 'Update';

	protected function getInput() {
		return '<div id="jt_jumpmenu_updates"></div>';
	}
}

/* eof */