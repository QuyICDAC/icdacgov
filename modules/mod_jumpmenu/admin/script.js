/**
* Admin script file
* @package Jumpmenu Module
* @Copyright (C) 2012 www.joomlatema.net
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version: 1.0 
**/

window.addEvent("domready",function(){
	getUpdates();
	//
	
	//
	$$('.input-pixels').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">px</span>"});
	$$('.input-percents').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">%</span>"});
	$$('.input-minutes').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">minutes</span>"});
	$$('.input-ms').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">ms</span>"});
	
	$$('.text-limit').each(function(el){
		var name = el.get('id') + '_type';
		var parent = el.getParent();
		el.inject(document.id(name),'before');		
        parent.dispose();
	});
	
	$$('.float').each(function(el){
		var destination = el.getParent().getPrevious().getElement('select');
		var parent = el.getParent();
        el.inject(destination, 'after');
		parent.dispose();	
	});
	
	$$('.enabler').each(function(el){
		var destination = el.getParent().getPrevious().getElement('select');
		var parent = el.getParent();
		el.inject(destination, 'after');
		parent.dispose();	
	});
	
	$$('.jt_switch').each(function(el){
		el.setStyle('display','none');
		var style = (el.value == 1) ? 'on' : 'off';
		var switcher = new Element('div',{'class' : 'switcher-'+style});
		switcher.inject(el, 'after');
		switcher.addEvent("click", function(){
			if(el.value == 1){
				switcher.setProperty('class','switcher-off');
				el.value = 0;
			}else{
				switcher.setProperty('class','switcher-on');
				el.value = 1;
			}
		});
	});
	
	var link = new Element('a', { 'class' : 'jtHelpLink', 'href' : 'http://www.joomlatema.net', 'target' : '_blank' })
	link.inject($$('div.panel')[$$('div.panel').length-1].getElement('h3'), 'bottom');
	link.addEvent('click', function(e) { e.stopPropagation(); });
});
// function to generate the updates list
function getUpdates() {
	document.id('jform_params_module_updates-lbl').destroy(); // remove unnecesary label
	var update_url = 'http://www.joomlatema.net/ucretli-temalar/ucretli-eklenti.html';
	var update_div = document.id('jt_jumpmenu_updates');
	update_div.innerHTML = '<div id="jt_jumpmenu_updates"><span id="jt_loader"></span><a target="_blank" href="http://www.joomlatema.net/download/cat_view/3-my-free-extensions-uecretsz-eklentlerm.html">Check For Update</a></div>';
	
	new Asset.javascript(update_url,{
		id: "new_script",
		onload: function(){
			content = '';
			$jt_update.each(function(el){
				content += '<li><span class="jt_update_version"><strong>Version:</strong> ' + el.version + ' </span><span class="jt_update_data"><strong>Date:</strong> ' + el.date + ' </span><span class="jt_update_link"><a href="' + el.link + '" target="_blank">Download</a></span></li>';
			});
			update_div.innerHTML = '<ul class="jt_updates">' + content + '</ul>';
			if(update_div.innerHTML == '<ul class="jt_updates"></ul>') update_div.innerHTML = '<p>There is no available updates for this module</p>';	
		}
	});
}