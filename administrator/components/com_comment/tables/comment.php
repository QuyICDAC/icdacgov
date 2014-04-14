<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       27.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');


/**
 * Class CcommentTableComment
 *
 * @since  5.0
 */
class CcommentTableComment extends JTable
{
	/**
	 * The constructor
	 *
	 * @param   JDatabaseDriver  &$db  - JDatabaseDriver object.
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__comment', 'id', $db);
	}

	/**
	 * Stores a row in the database
	 *
	 * @param   bool  $updateNulls  - True to update fields even if they are null.
	 *
	 * @return bool
	 */
	public function store($updateNulls = false)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		if ($this->id)
		{
			$this->modified = $date->toSql();
			$this->modified_by = $user->get('id');
		}
		else
		{
			$this->date = $date->toSql();
			$this->unsubscribe_hash = md5(JSession::getFormToken() . time() . mt_rand(1, 100));
			$this->moderate_hash = md5($this->ip . JVERSION . JSession::getFormToken() . time() . mt_rand(1, 10000));

		}

		return parent::store($updateNulls);
	}
}
