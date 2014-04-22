window.addEvent('domready', function() {

    var dis_searchInput = $('hreport_disease');

    var dis_compl = new Autocompleter.Ajax.Json(dis_searchInput, '/index.php?option=com_hreport&c=search&task=suggestion&t=disease&tmpl=component', {
        'postVar': 'search',
        'onRequest': function(el) {
        },
        'onComplete': function(el) {
        }
    });

    var sym_searchInput = $('hreport_symptom');

    var sym_compl = new Autocompleter.Ajax.Json(sym_searchInput, '/index.php?option=com_hreport&c=search&task=suggestion&t=symptom&tmpl=component', {
        'postVar': 'search',
        'onRequest': function(el) {
        },
        'onComplete': function(el) {
        }
    });

    var med_searchInput = $('hreport_medtrack');

    var med_compl = new Autocompleter.Ajax.Json(med_searchInput, '/index.php?option=com_hreport&c=search&task=suggestion&t=medtrack&tmpl=component', {
        'postVar': 'search',
        'onRequest': function(el) {
        },
        'onComplete': function(el) {
        }
    });

	$('dis_add').addEvent('click', function(event){
		var item = new Element('li').appendText(dis_searchInput.value);
		item.inject($('dis_list'));
		var field = new Element('input',{'type':'hidden', 'name':'dis[]', 'value':dis_searchInput.value});
		field.inject($('searchform'));
                dis_searchInput.value = '';
	});
	
	$('sym_add').addEvent('click', function(event){
		var item = new Element('li').appendText(sym_searchInput.value);
		item.inject($('sym_list'));
		var field = new Element('input',{'type':'hidden', 'name':'sym[]', 'value':sym_searchInput.value});
		field.inject($('searchform'));
                sym_searchInput.value = '';
	});

        $('med_add').addEvent('click', function(event){
		var item = new Element('li').appendText(med_searchInput.value);
		item.inject($('med_list'));
		var field = new Element('input',{'type':'hidden', 'name':'med[]', 'value':med_searchInput.value});
		field.inject($('searchform'));
                med_searchInput.value = '';
	});
	
});