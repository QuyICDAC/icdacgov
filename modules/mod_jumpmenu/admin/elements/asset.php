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

class JFormFieldAsset extends JFormField {
        protected $type = 'Asset';

        protected function getInput() {
                $doc = JFactory::getDocument();
                $doc->addScript(JURI::root().$this->element['path'].'script.js');
                $doc->addStyleSheet(JURI::root().$this->element['path'].'style.css');        
                return null;
        }
}

/* eof */