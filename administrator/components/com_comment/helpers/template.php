<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 15.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');

class ccommentHelperTemplate {

	/**
	 * This function will return the name of the frontend template
	 *
	 * @return string
	 */
	public static function getFrontendTemplate() {
		$db	= JFactory::getDBO();
		$query = $db->getQuery('true');
		$query->select($db->qn('template'))->from($db->qn('#__template_styles'))
			->where($db->qn('client_id') . '=' . $db->q(0))
			->where($db->qn('home') . '=' . $db->q(1));
		$db->setQuery($query, 0, 1);

		$template = $db->loadObject();

		return $template ? $template->template : '';
	}
}