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

class QueueController extends acymailingController{

	var $aclCat = 'queue';

	function remove(){
		if(!$this->isAllowed($this->aclCat,'delete')) return;
		JRequest::checkToken() or die( 'Invalid Token' );

		$mailid = JRequest::getVar('filter_mail',0,'post','int');

		$queueClass = acymailing_get('class.queue');
		$search = JRequest::getString('search');
		$filters = array();
		if(!empty($search)){
			$db = JFactory::getDBO();
			$searchVal = '\'%'.acymailing_getEscaped($search,true).'%\'';
			$searchFields = array('b.name','b.email','c.subject','a.mailid','a.subid');
			$filters[] = implode(" LIKE $searchVal OR ",$searchFields)." LIKE $searchVal";
		}
		if(!empty($mailid)){
			$filters[] = 'a.mailid = '.intval($mailid);
		}

		$total = $queueClass->delete($filters);
		$app = JFactory::getApplication();
		$app->enqueueMessage(JText::sprintf( 'SUCC_DELETE_ELEMENTS',$total ), 'message');
		JRequest::setVar('filter_mail',0,'post');
		JRequest::setVar('search','','post');

		return $this->listing();
	}

	function process(){
		if(!$this->isAllowed($this->aclCat,'process')) return;
		JRequest::setVar( 'layout', 'process'  );
		return parent::display();
	}

	function preview(){
		JRequest::setVar( 'layout', 'preview'  );
		return parent::display();
	}

}
