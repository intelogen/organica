
window.addEvent('domready', function() {

    var sym_searchInput = $('regs2_symptom');

    var sym_compl = new Autocompleter.Ajax.Json(sym_searchInput, '/index.php?option=com_hreport&c=search&task=suggestion&t=symptom&tmpl=component', {
        'postVar': 'search',
        'onRequest': function(el) {
        },
        'onComplete': function(el) {
        }
    });

     $('regs2_sym_add').addEvent('click', function(event){
         if(!sym_searchInput.value) return;
		var item = new Element('li').appendText(sym_searchInput.value);
		item.inject($('regs2_sym_list'));
		var field = new Element('input',{'type':'hidden', 'name':'symptoms[]', 'value': regs2_questions[sym_searchInput.value]});
		field.inject($('regs2_searchform'));
                sym_searchInput.value = '';
         equalColHeight();
	});
});
