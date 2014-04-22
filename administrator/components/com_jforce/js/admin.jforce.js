function submitbutton(pressbutton) {
		
	var form = document.adminForm;
	switch(pressbutton) {
	
		case 'default':
			form.view.value = form.c.value;
			form.layout.value = 'default';
		break;
		
		case 'new':
			if(form.view.value=='') {
				form.view.value = form.c.value;
			}
			form.boxchecked.value=0;
			form.layout.value = 'form';
		break;
		
		case 'edit':
			if(form.view.value=='') {
				form.view.value = form.c.value;
			}
			form.layout.value = 'form';
		break;
		
		default:
			form.task.value = pressbutton;
		break;
		
	}
	
	submitform(pressbutton);
}

function toggleValueRow() {

	var type = $('fieldtype').value;

	var row = $('valueRow');
	var required = $('requiredRow');

	if (type == 'textbox' || type == 'textarea') {
		row.setStyle('display', 'none');
	} else {
		row.setStyle('display', 'table-row');
	}

	if (type == 'checkbox') {
		required.setStyle('display', 'none');	
	} else {
		required.setStyle('display','table-row');
	}

}

function createValueField(type) {
	if(!type){
		var type = 'values';
	}
	var valueField = new Element('input', {
			'type'		:	'text',
			'name'		:	type+'[]', 
			'size'		:	'35',
			'class'		:	'inputbox separate'
		});
	
	$(type+'Holder').appendChild(valueField);
}

