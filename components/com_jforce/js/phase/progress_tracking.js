/**
 * Created by: Vyacheslav Radchenko
 * Date: 1/3/12 6:43 PM
 */

window.addEvent('domready', function() {



    var med_searchInput = $('tracking-medtrack');

    var med_compl = new Autocompleter.Ajax.Json(
        med_searchInput,
        '/index.php?option=com_hreport&c=search&task=suggestion&t=medtrack&tmpl=component',
        {
            'postVar': 'search',
            'onRequest': function(el) {},
            'onComplete': function(el) {}
        }
    );

     /*$('tracking-med-add').addEvent('click', function(event){
         if(!med_searchInput.value) return;

		//var item = new Element('li').appendText(med_searchInput.value);
		//item.inject($('regs1_med_list'));
		//var field = new Element('input',{'type':'hidden', 'name':'medtrack[]', 'value': regs1_questions[med_searchInput.value]});
		//field.inject($('regs1_searchform'));
        //        med_searchInput.value = '';

	});*/

});

var hyphenate = function(string) {
        return string.clean().toLowerCase().replace(/[\(\)]/g, '').replace(/\s/g, '-');
    };