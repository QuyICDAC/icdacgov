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

class jflanguagesType{
	var $onclick = '';
	var $id = 'jflang';
	var $jid = 'jlang';
	var $found = false;

	function jflanguagesType(){
		$this->values = array();

		if((ACYMAILING_J16 && file_exists(JPATH_SITE.DS.'libraries'.DS.'joomfish'.DS.'manager.php')) || (!ACYMAILING_J16 && file_exists(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'classes'.DS.'JoomfishManager.class.php')))
		{
			include_once( JPATH_SITE.DS.'components'.DS.'com_joomfish'.DS.'helpers'.DS.'defines.php' );
			if(!ACYMAILING_J16)
			{
				include_once(JOOMFISH_ADMINPATH.DS.'classes'.DS.'JoomfishManager.class.php');
			}else{
				include_once(JPATH_SITE.DS.'libraries'.DS.'joomfish'.DS.'manager.php');
			}
			$jfManager = JoomFishManager::getInstance();
			$langActive = $jfManager->getActiveLanguages();
			$this->values[] = JHTML::_('select.option', '',JText::_('DEFAULT_LANGUAGE'));
			foreach($langActive as $oneLanguage){
				$this->values[] = JHTML::_('select.option', $oneLanguage->shortcode.','.$oneLanguage->id,$oneLanguage->name);
			}
			$this->found = true;
		}

		if(empty($this->values) && file_exists(JPATH_SITE.DS.'components'.DS.'com_falang'.DS.'helpers'.DS.'defines.php') && include_once(JPATH_SITE.DS.'components'.DS.'com_falang'.DS.'helpers'.DS.'defines.php')){
			JLoader::register('FalangManager',FALANG_ADMINPATH.'/classes/FalangManager.class.php' );
			$fManager = FalangManager::getInstance();
			$langActive = $fManager->getActiveLanguages();
			$this->values[] = JHTML::_('select.option', '',JText::_('DEFAULT_LANGUAGE'));
			foreach($langActive as $oneLanguage){
				$this->values[] = JHTML::_('select.option', $oneLanguage->lang_code.','.$oneLanguage->lang_id,$oneLanguage->title);
			}
			$this->found = true;
		}
	}

	function display($map,$value = ''){
		if(empty($this->values)) return '';
		return JHTML::_('select.genericlist', $this->values, $map , 'size="1" style="max-width:150px" '.$this->onclick, 'value', 'text', $value,$this->id);
	}

	function displayJLanguages($map,$value = ''){
		if(!ACYMAILING_J16) return;
		$db = JFactory::getDBO();
		$db->setQuery('SELECT title as text,lang_code as value FROM #__languages WHERE published = 1');
		$langSite = $db->loadObjectList();
		if(count($langSite) < 2) return '';

		$default = new stdClass();
		$default->text = ' - - - ';
		$default->value = '';

		array_unshift($langSite,$default);

		return JHTML::_('select.genericlist', $langSite, $map , 'size="1" style="max-width:150px" '.$this->onclick, 'value', 'text', $value,$this->jid);
	}
}
