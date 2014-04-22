
window.addEvent('domready', function() {

    var dis_searchInput = $('regs3_disease');

    var dis_compl = new Autocompleter.Ajax.Json(dis_searchInput, '/index.php?option=com_hreport&c=search&task=suggestion&t=disease&tmpl=component', {
        'postVar': 'search',
        'onRequest': function(el) {
        },
        'onComplete': function(el) {
        }
    });

     $('regs3_dis_add').addEvent('click', function(event){
         if(!dis_searchInput.value) return;
		var item = new Element('li').appendText(dis_searchInput.value);
		item.inject($('regs3_dis_list'));
		var field = new Element('input',
            {
                'type':'hidden',
                'name':'diseases['+regs3_questions[dis_searchInput.value].type+'][]',
                'value':regs3_questions[dis_searchInput.value]['var']
            }
        );
		field.inject($('regs3_searchform'));
                dis_searchInput.value = '';
         equalColHeight();
	});
});
