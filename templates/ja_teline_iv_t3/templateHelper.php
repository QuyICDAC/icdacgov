<?php
/**
 * ------------------------------------------------------------------------
 * JA Fixel Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.image.image');

class TelineIVHelper {
    /**
     * Get last updated date
     *
     * @param string $fieldname   Fieldname
     *
     * @return string
     */
    public static function getLastUpdate($fieldname = null)
    {
        if (! $fieldname) $fieldname = 'created';
        $db = JFactory::getDBO();
        $query = "SELECT `$fieldname` FROM #__content ORDER BY `$fieldname` DESC LIMIT 1";
        $db->setQuery($query);
        $data = $db->loadObject();
        if ($data != null && $data->$fieldname) {
            $date = JFactory::getDate($data->$fieldname);
            //get timezone configured in Global setting
            $app =  JFactory::getApplication();
            // Get timezone offset
            $tz = $app->getCfg('offset');
            // Set timezone offset for date
            $date->setTimezone(new DateTimeZone($tz));
            //return by the format defined in language
            return $date->format(JText::_('T3_DATE_FORMAT_LASTUPDATE'), true);
        }
        return;
    }
}