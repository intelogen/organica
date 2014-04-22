<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class manageVIEWedit_photo extends JView
{
	function display($tpl = null)
	{
		global $mainframe;	
    	
		//set the toolbar buttons
    	JToolBarHelper::title( JText::_('EDIT PHOTO DETAILS'),'generic.png' );
		JToolBarHelper::custom('apply_edit_photo','apply', '',JText::_('APPLY'), false);
		JToolBarHelper::custom('save_edit_photo','save', '',JText::_('SAVE'), false);
		JToolBarHelper::custom('cancel_edit_photo','cancel', '',JText::_('CANCEL'), false);
		
		//get our data from the edit_photo model
		$gallery =& $this->get('Gallery');
		$photo =& $this->get('Photo');
		
		//make some html form elements
		$lists = array();
		
		$lists['target_blank'] = JHTML::_('select.booleanlist',  'target_blank', 'class="inputbox"', $photo->target_blank);
		
		$lists['access'] = JHTML::_('list.accesslevel',  $photo);
		
		//assign vars and display
		$this->assignRef('gallery',$gallery);
		$this->assignRef('photo',$photo);
		$this->assignRef('lists',$lists);
		parent::display($tpl);
	}
}	
?>