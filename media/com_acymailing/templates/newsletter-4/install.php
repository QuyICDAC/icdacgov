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
$name = 'Notification template';
$thumb = 'media/com_acymailing/templates/newsletter-4/newsletter-4.png';
$body = JFile::read(dirname(__FILE__).DS.'index.html');

$styles['tag_h1'] = 'color:#393939 !important; font-size:14px; font-weight:bold; margin:10px 0px;';
$styles['tag_h2'] = 'color: #309fb3 !important; font-size: 14px; font-weight: normal; text-align:left; margin:0px; padding:0px;';
$styles['tag_h3'] = 'color: #393939 !important; font-size: 18px; font-weight: bold; text-align:left; margin:0px; padding-bottom:5px; border-bottom:1px solid #bdbdbd;';
$styles['tag_h4'] = 'color: #309fb3 !important; font-size: 14px; font-weight: bold; text-align:left; margin:0px; padding: 5px 0px 0px 0px;';
$styles['tag_a'] = 'color:#309FB3; text-decoration:none; font-style:italic; cursor:pointer;';
$styles['acymailing_readmore'] = 'font-size: 12px; color: #fff; background-color:#309fb3; font-weight:bold; padding:3px 5px;';
$styles['acymailing_online'] = 'color:#a3a3a3; text-decoration:none; font-size:11px;';
$styles['acymailing_unsub'] = 'color:#a3a3a3; text-decoration:none; font-size:11px;';
$styles['color_bg'] = '#ffffff';
$styles['acymailing_content'] = 'text-align:justify;';

$stylesheet = 'div,table,p{font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:justify; color:#8c8c8c; margin:0px}
div.info{text-align:center;padding:10px;font-size:11px;color:#a3a3a3;}

@media (max-width:450px){
	table[class=w600], td[class=w600],  table[class=w520], td[class=w520], table[class=w480], td[class=w480], img[class=w600]{ width:100% !important; }
	td[class=w40] { width: 20px !important;}
	td[class=w20] { width: 10px !important;}
	.pict img {max-width:240px; height:auto !important;}
}

@media (min-width:450px) and (max-width:600px){
	table[class=w600], td[class=w600],  table[class=w520], td[class=w520], table[class=w480], td[class=w480], img[class=w600]{ width:100% !important; }
	td[class=w40] { width: 20px !important;}
	td[class=w20] { width: 10px !important;}
	.pict img {max-width:390px;  height:auto !important;}
}
@media (min-width:600px){
	body {width:600px !important; margin:auto !important;}
	.pict img {max-width:480px !important;  height:auto !important;}
}
';


