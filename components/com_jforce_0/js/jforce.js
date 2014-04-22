function submitbutton(pressbutton) {
	var form = document.adminForm;
	form.task.value=pressbutton;
	
	var pass = true;
	
	if (pressbutton == 'save') {
		pass = validateForm();
	}
	
	if (pass) {
		form.submit();
	} else {
		return false;	
	}
}

function addAttachment() {
	
	var filebox = new Element('input', {
		'class'	:	'inputbox',
		'type'	:	'file',
		'name'	:	'file[]'
	});
	
	var brk = new Element('br');
	
	$('attachments').appendChild(filebox);
}

function validateForm() {
	var pass = true;
	$$('input.required, select.required').each(function(el) {
		value = el.getProperty('value');
		if (!value) {
			pass = false;
			if (!el.hasClass('hilite')) {
				el.addClass('hilite');
				var name = el.getProperty('name');
				var id = el.getProperty('id');
				if (document.getElement('label[for='+id+']')) {
					document.getElement('label[for='+id+']').addClass('labelHilite');
				} else if (document.getElement('label[for='+name+']')) {
					document.getElement('label[for='+name+']').addClass('labelHilite');
				}
			}
		} else {
			if (el.hasClass('hilite')) {
				el.removeClass('hilite');	
				var name = el.getProperty('name');
				var id = el.getProperty('id');
				if (document.getElement('label[for='+id+']')) {
					document.getElement('label[for='+id+']').removeClass('labelHilite');
				} else if (document.getElement('label[for='+name+']')) {
					document.getElement('label[for='+name+']').removeClass('labelHilite');
				}
			}
		}
	});

	if (!pass) {
		alert("Please fill out all fields.");	
	}

	return pass;

}

function saveServicesForm(pressbutton) {
	
	if (pressbutton == 'save') {
		updateTotals();	
	}
	
	submitbutton(pressbutton);
}

function initializeTinyMCE() {
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,	
		});	
}

function refreshModals() {
	SqueezeBox.initialize({});
		$$('a.modal').each(function(el) {
			el.addEvent('click', function(e) {
				new Event(e).stop();
				SqueezeBox.fromElement(el);
			});
		});
	
}

function subscribeMe(id,type, pid) {
	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=subscribeMe';
	var postData = 'id='+id;
	postData += '&type='+type;
	postData += '&pid='+pid;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			$('subscribeLink').setHTML(response);
		}
	}).request(postData);
	
}

function remindPeople(id,type) {
	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=remindPeople';
	var postData = 'id='+id;
	postData += '&type='+type;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
		// Response Option Here
		}
	}).request(postData);
	
}

function subscribeMeTask(id,type, pid) {
	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=subscribeMe';
	var postData = 'id='+id;
	postData += '&type='+type;
	postData += '&pid='+pid;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			$(id).setHTML(response);
		}
	}).request(postData);
	
}

function toggleMilestone(id) {
	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=toggleMilestone';
	var postData = 'id='+id;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			var response = ajaxDecode(response);
			$('milestoneStatus').setHTML(response[0]);
			$('toggleLink').setHTML(response[1]);
		}
	}).request(postData);
}

function toggleBillable(id) {
	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=toggleBillable';
	var postData = 'id='+id;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			$(id).setProperty('src', response);
		}
	}).request(postData);
}

function togglePotentialType() {
	var leadvisibility = $('lead0').getProperty('checked');	

	if(leadvisibility == false) {
		$('leadfield').setStyle('display','block');
		$('companyfield').setStyle('display','none');
	} else {
		$('leadfield').setStyle('display','none');
		$('companyfield').setStyle('display','block');
	}
}
	
function toggleJUserBlock() {
	
	if ($('uidList').getProperty('value') == '') {
		$('JUserBlock').setStyle('display', 'block');	
	} else {
		$('JUserBlock').setStyle('display', 'none');
	}
	
}
	
function updateIcon(model) {
	var id = window.parent.$('id').value;
	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=getProfileIcon';
	var postData = 'id='+id;
	postData += '&model='+model;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			var previewLogo = window.parent.$('previewLogo');
			previewLogo.setHTML(response);
		}
	}).request(postData);
}

function removeIcon(model) {
	var id = window.parent.$('id').value;
	
	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=removeProfileIcon';
	var postData = 'id='+id;
	postData += '&model='+model;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			if(model == 'person') {
				var path = 	'jf_projects/people_icons/default_large.png';
			} else {
				var path = 	'jf_projects/company_icons/default_large.png';
			}
			var img = window.parent.$('previewLogo').getElement('img');
			img.setProperty('src', path);
		}
	}).request(postData);
}

function selectOptions() {
	var allOptions = $$('#unsubSelect option');
	
	var selectedOptions = $$('#subSelect div');
	
	for (var i=0; i<allOptions.length; i++) {
		var option = allOptions[i];
		if (option.selected == true) {	
			moveOption(option);
		}
	}
	
}

function in_ElementArray(needle, haystack) {
	var pass = false;
	
	for (var i=0; i<haystack.length; i++) {
		if(haystack[i].id == needle) {
			pass = true;	
		}
	}
	
	return pass;

}

function in_array(needle, haystack) {
	var pass = false;
	
	for (var i=0; i<haystack.length; i++) {
		if(haystack[i] == needle) {
			pass = true;	
		}
	}
	
	return pass;

}

function closeModal() {
	window.parent.$('sbox-window').close();	
}

function loadSelectedUsers() {
	if ($('type')) {
		if ($('type').value == 'assignment') {
			var div = '#hiddenAssignments';
			var parent = 'asgmntVisible_';
		} else {
			var div = '#hiddenSubscriptions';
			var parent = 'subVisible_';
		}
	} else {
		var div = '#hiddenSubscriptions';
		var parent = 'subVisible_';
	}
	
	var current = new Array();
	
	window.parent.$$(div+' input').each(function(el) {
		var value = el.value;
		var text = window.parent.$(parent+value).innerHTML;
		createSelectedOption(value, text);
	});
	
}

function moveOption(option) {
	var selectedOptions = $$('#subSelect div');
	var divid = 'selectedUser_'+option.value;
	if(in_ElementArray(divid, selectedOptions)) {
		highlightDiv(divid);	
	} else {
		var value = option.value;
		var text  = option.innerHTML;
		createSelectedOption(value, text);
	}
	
}

function createSelectedOption(value, text) {
	var holder = $('subSelect');
	var newSelectDiv = new Element('div', {
		'class'	:	'selectedUser',
		'id'	:	'selectedUser_'+value
	});
	
	var newSelectSpan = new Element('span', {
		'id'	:	'selectedUserName_'+value
	});
	
	var newSelectRemove = new Element('a', {
		'id'		:	'remove_'+value,
		'class'		:	'removeLink',
		'href'		:	'#',
		'events'	:	{
			'click'		:	function() {
				removeOption('selectedUser_'+value);	
			}
		}
	});
	newSelectRemove.setHTML('<img src="components/com_jforce/images/removeLite.png" border="0" class="removeLite" />');
	var hiddenField = new Element('input', {
		'type'		:	'hidden',
		'name'		:	'selectedUsers[]',
		'value'		:	value
	});
	
	var newSelectText = document.createTextNode(text);

	newSelectDiv.appendChild(newSelectRemove);
	newSelectSpan.appendChild(newSelectText);
	newSelectDiv.appendChild(newSelectSpan);
	newSelectDiv.appendChild(hiddenField);
	
	holder.appendChild(newSelectDiv);
	
	highlightDiv(newSelectDiv);
}

function removeOption(id) {
	var div = $(id);
	$('subSelect').removeChild(div);
}

function highlightDiv(div) {
	
	var fx = new Fx.Style(div, 'background-color', {duration:500});
	fx.start('#ffffff','#fffdd0').chain(function() {
		this.start('#fefdd5', '#ffffff')
	});	
	
}
	
function arrayDiff(array1, array2) {
	var diff = new Array();
	array1.each(function(a) {
		if (!in_array(a, array2)) {
			diff.push(a);
		}
	
	});
	return diff;
}

function saveSubscriptions() {
	if ($('type')) {
		if ($('type').value == 'assignment') {
			var div = '#hiddenAssignments';	
			var type = 'assignment';
		} else {
			var div = '#hiddenSubscriptions';
			var type = 'subscription';
		}
	} else {
		var div = '#hiddenSubscriptions';
		var type = 'subscription';
	}
	
	var selected = new Array();
	var current = new Array();
	
	window.parent.$$(div+' input').each(function(el) {
		current.push(el.value);									 
	});

	$$('input[type=hidden]').each(function(el) {
		if (el.id != 'type') {
			selected.push(el.value);								   
		}
	});

	var toDelete = arrayDiff(current, selected);
	var toAdd = arrayDiff(selected, current);
	
	if (type == 'assignment') {
		storeAssignments(toDelete, toAdd);
	} else {
		storeSubscriptions(toDelete, toAdd);
	}
}

function storeAssignments(toDelete, toAdd) {
	
	toDelete.each(function(id) {
		var hiddenField = window.parent.$('asgmntHidden_'+id);
		var listField = window.parent.$('asgmntVisible_'+id);
		window.parent.$('currentAssignments').removeChild(listField);
		window.parent.$('hiddenAssignments').removeChild(hiddenField);
	});
	
	toAdd.each(function(id) {
		var username = $('selectedUserName_'+id).innerHTML;
		var listField = new Element('div', {
			'class'	:	'assignedList',
			'id'	:	'asgmntVisible_'+id
		});
		listField.setHTML(username);
		var hiddenField = new Element('input', {
			'type'	:	'hidden',
			'id'	:	'asgmntHidden_'+id,
			'name'	:	'hiddenAssignment[]',
			'value'	:	id
		});
		
		window.parent.$('currentAssignments').appendChild(listField);
		window.parent.$('hiddenAssignments').appendChild(hiddenField);
	});
	
	if(window.parent.$$('#currentAssignments div').length) {
		window.parent.$('noAssignments').setStyle('display', 'none');
	} else {
		window.parent.$('noAssignments').setStyle('display', 'block');
	}
	
}

function storeSubscriptions(toDelete, toAdd) {
	
	toDelete.each(function(id) {
		var hiddenField = window.parent.$('subHidden_'+id);
		var listField = window.parent.$('subVisible_'+id);
		window.parent.$('currentSubscriptions').removeChild(listField);
		window.parent.$('hiddenSubscriptions').removeChild(hiddenField);
	});
	
	toAdd.each(function(id) {
		var username = $('selectedUserName_'+id).innerHTML;
		var listField = new Element('div', {
			'class'	:	'subscribedList',
			'id'	:	'subVisible_'+id
		});
		listField.setHTML(username);
		var hiddenField = new Element('input', {
			'type'	:	'hidden',
			'id'	:	'subHidden_'+id,
			'name'	:	'hiddenSubscription[]',
			'value'	:	id
		});
		
		window.parent.$('currentSubscriptions').appendChild(listField);
		window.parent.$('hiddenSubscriptions').appendChild(hiddenField);
	});


	if(window.parent.$$('#currentSubscriptions div').length) {
		window.parent.$('noSubscriptions').setStyle('display', 'none');
	} else {
		window.parent.$('noSubscriptions').setStyle('display', 'block');
	}
}
				
function deleteItem(item){ 
	var fadebox = $("service_"+item); 
	if (fadebox) {
		var fx = fadebox.effects({duration: 300});
		fx.start ({
			opacity: 1
		}).chain(function() {
			fx.start.delay(0, fx, {
				opacity: 0
			});
		}).chain(function() {
			fx.start ({
				opacity: 0,
				width: 0,
				height: 0
			});
		}).chain(function() {
			fadebox.remove();	
		});
	}	
		
}

function updateId(id, count) {
	var idArray = id.split('_');
	idArray[1] = count;
	newId = idArray.join('_');
	return newId;
}

function addService() {
	var count = $$('div.serviceTotals').length - 1;
	var k = 1 - count%2;
	
	var last = count - 1;
	
	var serviceRow = $('service_'+last).clone();
	serviceRow.setProperty('id', 'service_'+count);
	
	var toChange = new Array(
		'totalHidden_'+last,
		'subtotalHidden_'+last,
		'descriptionHidden_'+last,
		'descriptionEdit_'+last,
		'descriptionEditLink_'+last,
		'description_'+last,
		'priceField_'+last,
		'serviceSelect_'+last,
		'removeLink_'+last,
		'subtotal_'+last,
		'total_'+last
	);
	
	var output = '';
	serviceRow.getElements('*').each(function(el) {
		var oldId = el.getProperty('id');
		
		if (in_array(oldId, toChange)) {
			var newId = updateId(oldId, count);
			el.setProperty('id', newId);
		}
	});	
	
	var servicesArea = $('servicesArea');
	servicesArea.appendChild(serviceRow);
		
	$$('#service_'+count+' input').each(function(el) {
		if (el.getProperty('name') == 'services[quantity][]') {
			el.setProperty('value', '1');
		} else {
			el.removeProperty('value');											 
		}
	});
	
	$$('#service_'+count+' select').each(function(el) {
		el.removeProperty('value');	
		el.addEvent('change', function() {
			updateTotals();							   
		});
	});
	
	$('removeLink_'+count).removeEvents('click');
	
	$('removeLink_'+count).addEvent('click', function() {
		var removeId = this.id.substr(11);											  
		deleteItem(removeId);
	});
	
	$('serviceSelect_'+count).addEvent('change', function() {
		getServiceInfo(this.value, this.id);													  
	});
	
	$('descriptionEditLink_'+count).removeEvents('click');
	$('descriptionEditLink_'+count).setProperty('href', 'index.php?option=com_jforce&view=modal&layout=editdescription&tmpl=component&i='+count);										   
	
	$('description_'+count).setHTML(null);
	$('subtotal_'+count).setHTML('0');
	$('total_'+count).setHTML('0');
	
	initializeTinyMCE();
	refreshModals();
	
	$$('#servicesArea input').addEvent('blur', function() {
		updateTotals();												 
	});
	
}

function confirmDelete() {
	if(confirm('Are you sure you want to delete this item?')) {
		return true;
	} else {
		return false;
	}
}

function updateTotals() {
	
	var serviceCount = $$('div.serviceTotals').length - 1;

	var totalDiscount	= 0;
	var totalTax		= 0;
	var totalSubtotal	= 0;
	var grandTotal		= 0;
	

	for (var i=0; i<serviceCount; i++) {
		var service = $('service_'+i);
		
		var inputs = service.getElements('input');
		var selects = service.getElements('select');
		
		var priceField = inputs[0];
		var subtotalField = inputs[5];
		var discountField = inputs[1];
		var quantityField = inputs[2];
		var totalHiddenField = inputs[4];
		
		var taxField = selects[1];
		var discountType = selects[0];
		var discountAmount	= 0;
		
		var subtotal = priceField.value * quantityField.value;
		
		subtotalField.setProperty('value', subtotal);
		$('subtotal_'+i).setHTML(subtotal.toFixed(2));
	
	
		if (discountField.value != '') {
			if (discountType.value == 'amount') {
					discountAmount = parseFloat(discountField.value);
				} else if (discountType.value == 'percent') {
					var rate = parseFloat(discountField.value);
					discountAmount = subtotal*(rate/100);
				}
		}

		var taxRate = (taxField.value/100)+1;
		
		var total = (subtotal - discountAmount)*taxRate;
		totalHiddenField.setProperty('value', total);
		$('total_'+i).setHTML(total.toFixed(2));
		
		var taxAmount = total - (subtotal-discountAmount);
	
		totalDiscount 	+= discountAmount;
		totalTax		+= taxAmount;
		totalSubtotal	+= subtotal;
		grandTotal		+= total;
	}
	
	$('subtotal').setHTML(totalSubtotal.toFixed(2));
	$('discount').setHTML(totalDiscount.toFixed(2));
	$('tax').setHTML(totalTax.toFixed(2));
	$('total').setHTML(grandTotal.toFixed(2));
	
	$('subtotalHidden').setProperty('value', totalSubtotal.toFixed(2));
	$('discountHidden').setProperty('value', totalDiscount.toFixed(2));
	$('taxHidden').setProperty('value', totalTax.toFixed(2));
	$('totalHidden').setProperty('value', grandTotal.toFixed(2));
	

}

function getServiceInfo(service, id) {
	
	var i = id.substr(14);
	
	if (service != '' && service != '0') {
		var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=getServiceInfo';
		var postData = 'id='+service;
		new Ajax(url, {
			method: 'post',
			onSuccess: function(response) {
				response = ajaxDecode(response);
				$('priceField_'+i).setProperty('value', response[0]);
				$('descriptionHidden_'+i).setProperty('value', response[1]);
				$('description_'+i).setHTML(response[1]);
				updateTotals();
			}
		}).request(postData);
	} else {
		$('priceField_'+i).setProperty('value', 0);
		$('descriptionHidden_'+i).removeProperty('value');
		$('description_'+i).setHTML(null);
	}
	
	
	updateTotals();
	
}

function editDescription(i) {
	var text = window.parent.$('descriptionHidden_'+i).value;
	
	$('descriptionText').setProperty('value', text);
	
}

function saveDescription() {
	var i = $('i').value;
	var descriptionDiv = window.parent.$('description_'+i);
	var text = tinyMCE.getContent('mce_editor_0');
	
	window.parent.$('descriptionHidden_'+i).setProperty('value', text);
	descriptionDiv.setHTML(text);
	closeModal();
	
}

function toggleDescription(id) {
	var i = id.substr(20);
	
	var descriptionDiv = $('description_'+i);
	var descriptionText = $('descriptionEdit_'+i);
	var editLink = $(id);
	var textArea = $('descriptionHidden_'+i);
	
	var editorId = parseInt(i+1);
	
	if (descriptionText.getStyle('display') == 'block') {
		var text = tinyMCE.getContent('mce_editor_'+editorId);
		descriptionDiv.setHTML(text);
		descriptionText.setStyle('display', 'none')
		descriptionDiv.setStyle('display', 'block');
		editLink.setHTML('Edit');
		
		
		
	} else {
		descriptionText.setStyle('display', 'block')
		descriptionDiv.setStyle('display', 'none');
		editLink.setHTML('Save');
	}
	
	
}

function initProjectRoles() {

	$('accessrole').addEvent('change', function() {
		toggleCustomProjectRoles();								 
	});
}

function initAutoAddToggle() {
	
	$('auto_add0').addEvent('change', function() {
		autoAddToggle();								 
	});
	$('auto_add1').addEvent('change', function() {
		autoAddToggle();								 
	});
}

function autoAddToggle() {
	if($('accessrole').getProperty('value') != '') {
		$('projectPermissions').setStyle('display','none');
		$('customProjectRoles').setStyle('display', 'none');			
	} else {
		$('projectPermissions').setStyle('display','block');	
		toggleCustomProjectRoles();
	}
}
function toggleCustomProjectRoles() {
	var projectrole = $('accessrole').value;
	
	if (projectrole != '') {
		$('customProjectRoles').setStyle('display', 'none');	
	} else {
		$('customProjectRoles').setStyle('display', 'block');
	}
	
}

function toggleTask(id) {

	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=toggleTask';

	var postData = 'id='+id;
	
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			response = ajaxDecode(response);
			if (response[0] == '1') {
				completeTask(id);	
			} else {
				reopenTask(id);
			}
			
			if (response[1] == '1') {
				$('checklistCompleted').setHTML('Yes');
			} else {
				$('checklistCompleted').setHTML('No');
			}
		}
	}).request(postData);

}

function prefillCompanyFields(id) {

	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=prefillCompany';

	var postData = 'id='+id;

	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			var company = ajaxDecode(response);
			var companyName = company[0];
			var companyAddress = company[1];
			var companyPhone = company[2];
			var companyFax = company[3];
			var companyHomepage = company[4];

			$('name').value = companyName;
			$('address').value = companyAddress;
			$('phone').value = companyPhone;
			$('fax').value = companyFax;
			$('homepage').value = companyHomepage;

			if(companyName) {
				$$('input[type=text]').setProperty('readonly','readonly'); 
			} else {
				$$('input[type=text]').removeProperty('readonly'); 
			}
		}
	}).request(postData);
}

function prefillProjectFields(pid) {

	var url = 'index.php?format=raw&option=com_jforce&c=ajax&task=prefillProject';

	var postData = 'pid='+pid;

	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			var project = ajaxDecode(response);
			var projectName = project[0];
			var projectDescription = project[1];

			$('name').value = projectName;
			tinyMCE.setContent(projectDescription);		
			
			if(projectName) {
				$$('input[type=text]').setProperty('readonly','readonly'); 
			} else {
				$$('input[type=text]').removeProperty('readonly'); 
			}
		}
	}).request(postData);
}

function completeTask(id) {
	var toCopy = $('task_'+id);
	var toMove = toCopy.clone();
	
	$('completedTasks').appendChild(toMove);
	$('currentTasks').removeChild(toCopy);
	
	$$('#task_'+id+' input.taskbox').addEvent('click', function(e) {
		toggleTask(this.value);											 
	});
	
}

function reopenTask(id) {
	var toCopy = $('task_'+id);
	var toMove = toCopy.clone();
	
	$('currentTasks').appendChild(toMove);
	$('completedTasks').removeChild(toCopy);
	
	$$('#task_'+id+' input.taskbox').addEvent('click', function(e) {
		toggleTask(this.value);											 
	});
}

function createTask(response) {
	var responseArray = ajaxDecode(response);
	
	var id = responseArray[0];
	var summary = responseArray[1];
	var duedate = responseArray[2];
	var date = responseArray[3];
	var buttons = responseArray[4];
	
	
	var holder = new Element('div', {
			'id'		:	"task_"+id, 
			'class'		:	"row0"
		});
	
	var taskButtons = new Element('div', {
			'class'		:	"itemButtons"
		});
	taskButtons.setHTML(buttons);
	
	var checkBoxHolder = new Element('div', {
			'class'		:	"listCheckbox", 
		});
	
	var checkBox = new Element('input', {
			'class'		:	"taskbox", 
			'type'		:	"checkbox",
			'name'		:	'task_'+id,
			'value'		:	id,
			'events'	: {
				'click'		: function() {
					toggleTask(id);	
				}
			}
		});
	
	var title = new Element('div', {
			'class'		:	"listTitle"
		});
	title.setHTML(summary);
	var toolTip = new Element('div', {
			'class'		:	"hasTip", 
			'title'		:	duedate
		});
	toolTip.setHTML(date);
	
	checkBoxHolder.appendChild(checkBox);
	holder.appendChild(taskButtons);
	holder.appendChild(checkBoxHolder);
	holder.appendChild(title);
	holder.appendChild(toolTip);
	
	$('currentTasks').appendChild(holder);

}

function ajaxDecode(response) {
	var delimiter = '|%|';
	var unencode = response.split(delimiter);
	
	return unencode;
}
 /* TEMPORARY COPY PROJECT VERFIFICATION */
 function copyObject(id, type) {
	if(confirm("Are you sure you want to copy this "+type+"?")) {
		
		if(type=='project') {
			window.location = 'index.php?option=com_jforce&task=copyProject&pid='+id;	
		} else {
			var c = getRequest('c');
			var pid = getRequest('pid');
			if(c=='') c = 'project';
			
			window.location = 'index.php?option=com_jforce&c='+c+'&view='+type+'&task=copyObject&pid='+pid+'&id='+id;
		}
	}
 }
 
 
 /* GET REQUEST VARIABLE */
 function getRequest( name ) {
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	
	if( results == null )
		return "";
	else
		return results[1];
}

function quoteAccept(form, accept) {
	form.accept.value = accept;
	form.submit();
}