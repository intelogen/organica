
function equalColHeight() {
    var maincol = $('maincol');
    var rightcol = $('rightcol');
    var max_height = $('maincontent-block').getSize().size.y + 30;
    maincol.setStyle('height', max_height);
    rightcol.setStyle('height', max_height);
}

window.addEvent('domready', function() {

    var med_searchInput = $('regs1_medtrack');

    var med_compl = new Autocompleter.Ajax.Json(
        med_searchInput,
        '/index.php?option=com_hreport&c=search&task=suggestion&t=medtrack&tmpl=component',
        {
            'postVar': 'search',
            'onRequest': function(el) {},
            'onComplete': function(el) {}
        }
    );

     $('regs1_med_add').addEvent('click', function(event){
         if(!med_searchInput.value) return;
		var item = new Element('li').appendText(med_searchInput.value);
		item.inject($('regs1_med_list'));
		var field = new Element('input',{'type':'hidden', 'name':'medtrack[]', 'value': regs1_questions[med_searchInput.value]});
		field.inject($('regs1_searchform'));
                med_searchInput.value = '';
        equalColHeight();
	});
});
