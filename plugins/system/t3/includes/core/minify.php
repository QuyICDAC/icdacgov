<?php
/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die();

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

//T3::import('minify/csscompressor');
T3::import('core/path');

/**
 * T3Template class provides extended template tools used for T3 framework
 *
 * @package T3
 */
class T3Minify
{
	/**
	 * 
	 * Known Valid CSS Extension Types
	 * @var array
	 */
	protected static $cssexts = array('.css', '.css1', '.css2', '.css3');


	/**
	 * Minify
	 */
	public static function minify( $css ) {
		$css = preg_replace( '#\s+#', ' ', $css );
		$css = preg_replace( '#/\*.*?\*/#s', '', $css );
		$css = str_replace( '; ', ';', $css );
		$css = str_replace( ': ', ':', $css );
		$css = str_replace( ' {', '{', $css );
		$css = str_replace( '{ ', '{', $css );
		$css = str_replace( ', ', ',', $css );
		$css = str_replace( '} ', '}', $css );
		$css = str_replace( ';}', '}', $css );

		return trim( $css );
	}

	/**
	 * 
	 * Check and convert to css real path
	 * @param  string  $url  url to check
	 * @return  mixed  the css file path or false if not exist in server
	 */
	public static function cssPath($url = '') {
		$url = preg_replace('#[?\#]+.*$#', '', $url);
		$base = JURI::base();
		$root = JURI::root(true);
		$ret = false;

		if(substr($url, 0, 2) === '//'){ //check and append if url is omit http
			$url = JURI::getInstance()->getScheme() . ':' . $url; 
		}

		//check for css file extensions
		foreach ( self::$cssexts as $ext ) {
			if (strlen($ext) <= strlen($url) && substr_compare($url, $ext, -strlen($ext), strlen($ext)) === 0) {
				$ret = true;
				break;
			}
		}

		if($ret){
			if (preg_match('/^https?\:/', $url)) { //is full link
				if (strpos($url, $base) === false){
					// external css
					return false;
				}

				$path = JPath::clean(JPATH_ROOT . '/' . substr($url, strlen($base)));
			} else {
				$path = JPath::clean(JPATH_ROOT . '/' . ($root && strpos($url, $root) === 0 ? substr($url, strlen($root)) : $url));
			}

			return is_file($path) ? $path : false;
		}

		return false;
	}


	/**
	 * @param   string  $url  url to refine
	 * @return  string  the refined url
	 */
	public static function fixUrl($url = ''){
		return ($url[0] === '/' || strpos($url, '://') !== false) ? $url : JURI::base(true) . '/' . $url;
	}

	/**
	 * @param   $tpl  template object
	 * @return  bool  optimize success or not
	 */
	public static function optimizecss($tpl)
	{
		$outputpath = JPATH_ROOT . '/' . $tpl->getParam('t3-assets', 't3-assets') . '/css';
		$outputurl = JURI::root(true) . '/' . $tpl->getParam('t3-assets', 't3-assets') . '/css';
		
		if (!JFile::exists($outputpath)){
			JFolder::create($outputpath);
			@chmod($outputpath, 0755);
		}

		if (!is_writeable($outputpath)) {
			return false;
		}

		$doc = JFactory::getDocument();

		//======================= Group css ================= //
		$cssgroups = array();
		$stylesheets = array();
		$ielimit = 4095;
		$selcounts = 0;
		$regex = '/\{.+?\}|,/s'; //selector counter
		$csspath = '';

		foreach ($doc->_styleSheets as $url => $stylesheet) {

			$url = self::fixUrl($url);

			if ($stylesheet['mime'] == 'text/css' && ($csspath = self::cssPath($url))) {
				$stylesheet['path'] = $csspath;
				$stylesheet['data'] = JFile::read($csspath);

				$selcount = preg_match_all($regex, $stylesheet['data'], $matched);
				if(!$selcount) {
					$selcount = 1; //just for sure
				}

				//if we found an @import rule or reach IE limit css selector count, break into the new group
				if (preg_match('#@import\s+.+#', $stylesheet['data']) || $selcounts + $selcount >= $ielimit) {
					if(count($stylesheets)){
						$cssgroup = array();
						$groupname = array();
						foreach ( $stylesheets as $gurl => $gsheet ) {
							$cssgroup[$gurl] = $gsheet;
							$groupname[] = $gurl;
						}

						$cssgroup['groupname'] = implode('', $groupname);
						$cssgroups[] = $cssgroup;
					}

					$stylesheets = array($url => $stylesheet); // empty - begin a new group
					$selcounts = $selcount;
				} else {

					$stylesheets[$url] = $stylesheet;
					$selcounts += $selcount;
				}

			} else {
				// first get all the stylsheets up to this point, and get them into
				// the items array
				if(count($stylesheets)){
					$cssgroup = array();
					$groupname = array();
					foreach ( $stylesheets as $gurl => $gsheet ) {
						$cssgroup[$gurl] = $gsheet;
						$groupname[] = $gurl;
					}

					$cssgroup['groupname'] = implode('', $groupname);
					$cssgroups[] = $cssgroup;
				}

				//mark ignore current stylesheet
				$cssgroup = array($url => $stylesheet, 'ignore' => true);
				$cssgroups[] = $cssgroup;

				$stylesheets = array(); // empty - begin a new group
			}
		}
		
		if(count($stylesheets)){
			$cssgroup = array();
			$groupname = array();
			foreach ( $stylesheets as $gurl => $gsheet ) {
				$cssgroup[$gurl] = $gsheet;
				$groupname[] = $gurl;
			}

			$cssgroup['groupname'] = implode('', $groupname);
			$cssgroups[] = $cssgroup;
		}
		
		//======================= Group css ================= //

		$output = array();
		foreach ($cssgroups as $cssgroup) {
			if(isset($cssgroup['ignore'])){
				
				unset($cssgroup['ignore']);
				foreach ($cssgroup as $furl => $fsheet) {
					$output[$furl] = $fsheet;
				}

			} else {

				$groupname = 'css-' . substr(md5($cssgroup['groupname']), 0, 5) . '.css';
				$groupfile = $outputpath . '/' . $groupname;
				$grouptime = JFile::exists($groupfile) ? @filemtime($groupfile) : -1;
				$rebuild = $grouptime < 0; //filemtime == -1 => rebuild

				unset($cssgroup['groupname']);
				foreach ($cssgroup as $furl => $fsheet) {
					if(!$rebuild && @filemtime($fsheet['path']) > $grouptime){
						$rebuild = true;
					}
				}

				if($rebuild){

					$cssdata = array();
					foreach ($cssgroup as $furl => $fsheet) {
						$cssdata[] = "\n\n/*===============================";
						$cssdata[] = $furl;
						$cssdata[] = "================================================================================*/";
						
						$cssmin = self::minify($fsheet['data']);
						$cssmin = T3Path::updateUrl($cssmin, T3Path::relativePath($outputurl, dirname($furl)));

						$cssdata[] = $cssmin;
					}

					$cssdata = implode("\n", $cssdata);
					JFile::write($groupfile, $cssdata);
					$grouptime = @filemtime($groupfile);
					@chmod($groupfile, 0644);
				}

				$output[$outputurl . '/' . $groupname.'?t='.($grouptime % 1000)] = array(
					'mime' => 'text/css',
					'media' => null,
					'attribs' => array()
					);
			}
		}

		//apply the change make change
		$doc->_styleSheets = $output;
	}
}
?>