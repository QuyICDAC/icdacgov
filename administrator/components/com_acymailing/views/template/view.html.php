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


class TemplateViewTemplate extends acymailingView
{

	var $selection =  array('a.tempid','a.name','a.description','a.created','a.published','a.premium','a.ordering','a.thumb');
	var $filters = array();
	var $button = true;

	function display($tpl = null)
	{

		$function = $this->getLayout();
		if(method_exists($this,$function)) $this->$function();

		parent::display($tpl);
	}

	function listing(){
		$app = JFactory::getApplication();
		$pageInfo = new stdClass();
		$pageInfo->filter = new stdClass();
		$pageInfo->filter->order = new stdClass();
		$pageInfo->limit = new stdClass();
		$pageInfo->elements = new stdClass();
		$config = acymailing_config();

		$paramBase = ACYMAILING_COMPONENT.'.'.$this->getName().$this->getLayout();
		$pageInfo->filter->order->value = $app->getUserStateFromRequest( $paramBase.".filter_order", 'filter_order',	'a.ordering','cmd' );
		$pageInfo->filter->order->dir	= $app->getUserStateFromRequest( $paramBase.".filter_order_Dir", 'filter_order_Dir',	'asc',	'word' );
		$pageInfo->search = $app->getUserStateFromRequest( $paramBase.".search", 'search', '', 'string' );
		$pageInfo->search = JString::strtolower( $pageInfo->search );

		$pageInfo->limit->value = $app->getUserStateFromRequest( $paramBase.'.list_limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$pageInfo->limit->start = $app->getUserStateFromRequest( $paramBase.'.limitstart', 'limitstart', 0, 'int' );

		$database	= JFactory::getDBO();

		if(!empty($pageInfo->search)){
			$searchVal = '\'%'.acymailing_getEscaped($pageInfo->search,true).'%\'';
			$this->filters[] = "a.name LIKE $searchVal OR a.description LIKE $searchVal OR a.tempid LIKE $searchVal";
		}

		$query = 'SELECT '.implode(',',$this->selection).' FROM '.acymailing_table('template').' as a';
		if(!empty($this->filters)){$query .= ' WHERE ('.implode(') AND (',$this->filters).')';}
		if(!empty($pageInfo->filter->order->value)){
			$query .= ' ORDER BY '.$pageInfo->filter->order->value.' '.$pageInfo->filter->order->dir;
		}

		$database->setQuery($query,$pageInfo->limit->start,$pageInfo->limit->value);

		try{
			$this->rows = $database->loadObjectList();
		}catch(Exception $e){
			$this->rows = null;
		}

		if($this->rows === null){
			acymailing_display(isset($e) ? print_r($e,true) : substr(strip_tags($database->getErrorMsg()),0,200).'...','error');
			if(file_exists(ACYMAILING_BACK.'install.acymailing.php')){
				include_once(ACYMAILING_BACK.'install.acymailing.php');
				$installClass = new acymailingInstall();
				$installClass->fromVersion = '4.1.0';
				$installClass->update = true;
				$installClass->updateSQL();
			}
		}

		$queryCount = 'SELECT COUNT(a.tempid) FROM '.acymailing_table('template').' as a';
		if(!empty($this->filters)){$queryCount .= ' WHERE ('.implode(') AND (',$this->filters).')';}
		$database->setQuery($queryCount);
		$pageInfo->elements->total = $database->loadResult();


		if(!empty($pageInfo->search) && $this->button){
			$rows = acymailing_search($pageInfo->search,$this->rows);
		}else{
			$rows =& $this->rows;
		}

		$pageInfo->elements->page = count($rows);

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $pageInfo->elements->total, $pageInfo->limit->start, $pageInfo->limit->value );

		if($this->button){
			acymailing_setTitle(JText::_('ACY_TEMPLATES'),'acytemplate','template');


			$bar = JToolBar::getInstance('toolbar');
			$bar->appendButton( 'Acypopup', 'import', JText::_('IMPORT'), "index.php?option=com_acymailing&ctrl=template&task=upload&tmpl=component");
			JToolBarHelper::custom( 'export', 'acyexport', 'acyexport', JText::_('ACY_EXPORT') );
			JToolBarHelper::divider();
			JToolBarHelper::addNew();
			JToolBarHelper::editList();
			if(acymailing_isAllowed($config->get('acl_templates_delete','all'))) JToolBarHelper::deleteList(JText::_('ACY_VALIDDELETEITEMS',true));
			if(acymailing_isAllowed($config->get('acl_templates_copy','all'))){
				JToolBarHelper::spacer();
				JToolBarHelper::custom( 'copy', 'copy.png', 'copy.png', JText::_('ACY_COPY') );
			}
			JToolBarHelper::divider();

			$bar->appendButton( 'Pophelp','template-listing');
			if(acymailing_isAllowed($config->get('acl_cpanel_manage','all'))) $bar->appendButton( 'Link', 'acymailing', JText::_('ACY_CPANEL'), acymailing_completeLink('dashboard') );
		}


		$toggleClass = acymailing_get('helper.toggle');

		$order = new stdClass();
		$order->ordering = false;
		$order->orderUp = 'orderup';
		$order->orderDown = 'orderdown';
		$order->reverse = false;
		if($pageInfo->filter->order->value == 'a.ordering'){
			$order->ordering = true;
			if($pageInfo->filter->order->dir == 'desc'){
				$order->orderUp = 'orderdown';
				$order->orderDown = 'orderup';
				$order->reverse = true;
			}
		}

		$this->assignRef('order',$order);
		$this->assignRef('toggleClass',$toggleClass);
		$this->assignRef('rows',$rows);
		$this->assignRef('pageInfo',$pageInfo);
		$this->assignRef('pagination',$pagination);

	}

	function form(){
		$tempid = acymailing_getCID('tempid');
		$app = JFactory::getApplication();
		$config = acymailing_config();

		if(!empty($tempid)){
			$templateClass = acymailing_get('class.template');
			$template = $templateClass->get($tempid);
			if(!empty($template->body)) $template->body = acymailing_absoluteURL($template->body);
		}else{
			$template = new stdClass();
			$template->body = '';
			$template->tempid = 0;
			$template->published = 1;
		}

		$editor = acymailing_get('helper.editor');
		$editor->setTemplate($template->tempid);
		$editor->name = 'editor_body';
		$editor->content = $template->body;
		$editor->prepareDisplay();

		if(!ACYMAILING_J16){
			$script = 	'function submitbutton(pressbutton){
						if (pressbutton == \'cancel\') {
							submitform( pressbutton );
							return;
						}';
		}else{
			$script = 	'Joomla.submitbutton = function(pressbutton) {
						if (pressbutton == \'cancel\') {
							Joomla.submitform(pressbutton,document.adminForm);
							return;
						}';
		}

		$script .= 'if(window.document.getElementById("name").value.length < 2){alert(\''.JText::_('ENTER_TITLE',true).'\'); return false;}';
		$script .= "if(pressbutton == 'test' && window.document.getElementById('sendtest') && window.document.getElementById('sendtest').style.display == 'none'){ window.document.getElementById('sendtest').style.display = 'block'; return false;}";
		$script .= $editor->jsCode();
		if(!ACYMAILING_J16){ $script .= 'submitform( pressbutton );} ';
		}else{ $script .= 'Joomla.submitform(pressbutton,document.adminForm);}; ';}

		$script .= "function insertTag(tag){ try{jInsertEditorText(tag,'editor_body'); return true;} catch(err){alert('Your editor does not enable AcyMailing to automatically insert the tag, please copy/paste it manually in your Newsletter'); return false;}}";

		$script .= 'function addStyle(){
		var myTable=window.document.getElementById("classtable");
		var newline = document.createElement(\'tr\');
		var column = document.createElement(\'td\');
		var column2 = document.createElement(\'td\');
		var input = document.createElement(\'input\');
		var input2 = document.createElement(\'input\');
		input.type = \'text\';
		input2.type = \'text\';
		input.style.width = \'180px\';
		input2.style.width = \'200px\';
		input.name = \'otherstyles[classname][]\';
		input2.name = \'otherstyles[style][]\';
		input.value = "'.JText::_('CLASS_NAME',true).'";
		input2.value = "'.JText::_('CSS_STYLE',true).'";
		column.appendChild(input);
		column2.appendChild(input2);
		newline.appendChild(column);
		newline.appendChild(column2);
		myTable.appendChild(newline);
		}';

		$script .= 'var currentValueId = \'\';
				function showthediv(valueid,e)
					{
							if(currentValueId != valueid){
					try{
						document.getElementById(\'wysija\').style.left = e.pageX-50+"px";
						document.getElementById(\'wysija\').style.top = e.pageY-40+"px";
					}catch(err){
						document.getElementById(\'wysija\').style.left = e.x-50+"px";
						document.getElementById(\'wysija\').style.top = e.y-40+"px";
					}
					currentValueId = valueid;
							}
							document.getElementById(\'wysija\').style.display = \'block\';
				initDiv();
					}

					function spanChange(span)
					{
							input = currentValueId;
						if (document.getElementById(span).className == span.toLowerCase()+"elementselected")
						{
				document.getElementById(span).className = span.toLowerCase()+"element";
								if(span == "B"){
							document.getElementById("name_"+currentValueId).style.fontWeight = "";
								document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value.replace(/font-weight *: *bold(;)?/i, "");
						}
						if(span == "I"){
							document.getElementById("name_"+currentValueId).style.fontStyle = "";
								document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value.replace(/font-style *: *italic(;)?/i, "");
						}
						if(span == "U"){
							document.getElementById("name_"+currentValueId).style.textDecoration="";
								document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value.replace(/text-decoration *: *underline(;)?/i,"");
						}

						}
						else{
						 document.getElementById(span).className = span.toLowerCase()+"elementselected";
						if(span == "B"){
							document.getElementById("name_"+currentValueId).style.fontWeight = "bold";
								document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value + "font-weight:bold;";
						}
						if(span == "I"){
							document.getElementById("name_"+currentValueId).style.fontStyle = "italic";
								document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value + "font-style:italic;";
						}
						if(span == "U"){
							document.getElementById("name_"+currentValueId).style.textDecoration="underline";
								document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value + "text-decoration:underline;";
						}
						}
					}
			function getValueSelect()
					 {
				selec = currentValueId;
				var myRegex2 = new RegExp(/font-size *:[^;]*;/i);
				var MyValue = document.getElementById("style_select_wysija").value;
				document.getElementById("name_"+currentValueId).style.fontSize = MyValue;
					if(document.getElementById("style_"+currentValueId).value.search(myRegex2) != -1){
						if(MyValue == ""){
							document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value.replace(myRegex2, "");
						}
						else{
							document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value.replace(myRegex2, "font-size:"+MyValue+";");
						}
					}
					else{
						document.getElementById("style_"+currentValueId).value = document.getElementById("style_"+currentValueId).value + "font-size:"+MyValue+";";
					}
				}

				function initDiv(){

					var RegexSize = new RegExp(/font-size *:[^;]*(;)?/gi);
					var RegexColor = new RegExp(/([^a-z-])color *:[^;]*(;)?/gi);


					document.getElementById("colorexamplewysijacolor").style.backgroundColor = "#000000";
					document.getElementById("colordivwysijacolor").style.display = "none";
					spaced = document.getElementById("style_"+currentValueId).value.substr(0,1);
						if(spaced != " "){
							stringToQuery = \' \' + document.getElementById("style_"+currentValueId).value;
						}
						else{
							stringToQuery = document.getElementById("style_"+currentValueId).value;
						}
					NewColor = stringToQuery.match(RegexColor);
					if(NewColor != null){
						NewColor = NewColor[0].match(/:[^;!]*/gi);
						NewColor = NewColor[0].replace(/(:| )/gi,"");
						document.getElementById("colorexamplewysijacolor").style.backgroundColor = NewColor;
					}


								 document.getElementById("U").className = "uelement";
								 document.getElementById("I").className = "ielement";
								 document.getElementById("B").className = "belement";

							if(document.getElementById("style_"+currentValueId).value.search(/font-weight: *bold(;)?/i) != -1){
										document.getElementById("B").className += "selected";
								}
							if(document.getElementById("style_"+currentValueId).value.search(/font-style: *italic(;)?/i) != -1){
										document.getElementById("I").className += "selected";
								}
							if(document.getElementById("style_"+currentValueId).value.search(/text-decoration: *underline(;)?/i) != -1){
										document.getElementById("U").className += "selected";
								}


					NewSize = stringToQuery.match(RegexSize);
					document.getElementById("style_select_wysija").options[0].selected = true;
					if(NewSize != null){
						NewSize = NewSize[0].match(/:[^;]*/gi);
						NewSize = NewSize[0].replace(" ","");
						NewSize = NewSize.substr(1);
						for(var i = 0; i < document.getElementById("style_select_wysija").length; i++)
						{
							if(document.getElementById("style_select_wysija").options[i].value == NewSize){
								document.getElementById("style_select_wysija").options[i].selected = true;
							}
						}
					}
					}';

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration( $script);

		$paramBase = ACYMAILING_COMPONENT.'.'.$this->getName();
		$infos = new stdClass();
		$infos->receiver_type = $app->getUserStateFromRequest( $paramBase.".receiver_type", 'receiver_type', '','string' );
		$infos->test_email = $app->getUserStateFromRequest( $paramBase.".test_email", 'test_email', '','string' );


		acymailing_setTitle(JText::_('ACY_TEMPLATE'),'acytemplate','template&task=edit&tempid='.$tempid);

		$bar = JToolBar::getInstance('toolbar');

		if(acymailing_isAllowed($config->get('acl_tags_view','all'))) $bar->appendButton( 'Acytags');
		JToolBarHelper::divider();
		JToolBarHelper::custom('test', 'acysend', '',JText::_('SEND_TEST'), false);
		JToolBarHelper::spacer();
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
		JToolBarHelper::divider();
		$bar->appendButton( 'Pophelp','template-form');

		$this->assignRef('editor',$editor);
		$receiverClass = acymailing_get('type.testreceiver');
		$this->assignRef('receiverClass',$receiverClass);
		$this->assignRef('template',$template);
		$colorBox = acymailing_get('type.color');
		$this->assignRef('colorBox',$colorBox);
		$this->assignRef('infos',$infos);

		$tabs = acymailing_get('helper.acytabs');
		$tabs->setOptions(array('useCookie' => true));
		$this->assignRef('tabs',$tabs);
	}

	function theme(){
		$this->selection[] = 'a.*';
		$this->filters[] = 'a.published = 1';
		$this->button = false;
		acymailing_display(JText::_('CHANGE_TEMPLATE'),'warning', false);
		$this->listing();

		$js = "function applyTemplate(tempid){
			window.parent.changeTemplate(window.document.getElementById('htmlcontent_'+tempid).innerHTML,window.document.getElementById('textcontent_'+tempid).innerHTML,window.document.getElementById('subject_'+tempid).innerHTML,window.document.getElementById('stylesheet_'+tempid).innerHTML,window.document.getElementById('fromname_'+tempid).innerHTML,window.document.getElementById('fromemail_'+tempid).innerHTML,window.document.getElementById('replyname_'+tempid).innerHTML,window.document.getElementById('replyemail_'+tempid).innerHTML,tempid);
			acymailing_js.closeBox(true); }";
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration( $js );
	}

	function upload(){
	}
}
