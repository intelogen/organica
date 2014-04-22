<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			startup.helper.php											*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForceStartupHelper {
	
	function showHelp() {
		
		global $mainframe;
		$user =& JFactory::getUser();
	
		$view = JRequest::getVar('view','');
		
		$text = NULL;
		$function = 'load'.ucwords($view).'Text';
		if (method_exists('JForceStartupHelper',$function)):
			$text = JForceStartupHelper::$function();
		endif;
		
		$html = '<div class="startupContainer">'.$text.'</div>';
		
		return $html;
	}	
	
	function loadProjectText() {
		$text = "<div class='startupText'>
					<h3>About Projects</h3>
						<p><strong>This area allows you to view all open projects for which you have permissions.</strong><br />The first step will be to create a project and then assign the necessary people to that project. Only those people that you authorize to view this project will be able to view them on this page.</p>
						<p><strong>Start adding items to the newly created project.</strong><br />Milestones are considered the main portions of a project.  You can assign many other itmes to milestones.  Milestones allow for definite deadlines for overall project completion.</p>
						<p><strong>Progress Bar</strong><br />This will allow you to quickly see where a project is in development.  Progress is measured by completed milestones and tasks (on checklists) compared to the overall project milestones and tasks.</p>
						<p><strong>Recent Activities</strong><br />The recent activities area shows all recent activity on a project.</p>
						<p><a href='".JRoute::_('index.php?option=com_jforce&view=project&layout=form')."' class='goArrow'>Create a project now</a></p>
						</div>";
		
	return $text;
	}

	function loadMilestoneText() {
		$pid = JRequest::getVar('pid');
		$link = JRoute::_('index.php?option=com_jforce&view=milestone&layout=form&pid='.$pid);
		$text = '<div class="startupText">
					<h3>About Milestones</h3>
				<p><strong>Milestones Mark Key Dates for a Project</strong><br />
			
			Milestones function as key checkpoints in a project. They allow you to see who is responsible for what items, and when they need to be completed. Click on a specific milestones to see all related discussions, checklists, tasks and files.</p>
			
			<p><strong>Keep Track of Important Dates with Your Calendar</strong><br />
			Stay up to speed on milestones and tasks through your iCalendar. Go to the Overview page for a particular project and click on iCalendar feed.  You can add it to your iCalendar compatible program by downloading the file, or you can use the url to set it up as a dynamic web calendar.</p>
			
			<p><strong>Email Notifications</strong><br />
			You can subscribe to a milestone to receive email notifications when it is completed, rescheduled or reopened. Users involved with the project can manage subscriptions to milestones and send reminders to the user(s) responsible for completing them.</p>
						<p><a href="'.$link.'" class="goArrow">Create a milestone now</a></p>
			
			</div>';
	return $text;
	}
	
	function loadChecklistText() {
		$pid = JRequest::getVar('pid');
		$link = JRoute::_('index.php?option=com_jforce&view=checklist&layout=form&pid='.$pid);
		$text = '<div class="startupText">
					<h3>About Checklists</h3>
						<p><strong>Tasks</strong><br />
Checklists consists of a list of tasks that must be completed before a checklist can be completed. An unlimited number of tasks can be created within a checklist. Users can set subscribers for checklist and assignees for tasks, along with priority levels and due dates for specific tasks.</p>

						<p><strong>Email Notifications</strong><br />
							You can subscribe to checklists to receive email notifications for new, completed or rescheduled tasks.</p>
						<p><a href="'.$link.'" class="goArrow">Create a checklist now</a></p>
					</div>';	
	return $text;
	}

	function loadDiscussionText() {
		$pid = JRequest::getVar('pid');
		$link = JRoute::_('index.php?option=com_jforce&view=discussion&layout=form&pid='.$pid);
		$text = '<div class="startupText">
					<h3>About Discussions</h3>
						<p><strong>A Central Hub for Communication</strong><br />
Discussions encourage users to centralize communication throughout the project process. You can create any number of discussion topics and set the visibility levels to just your company (private) or anyone involved with the project (public).</p>

						<p><strong>Link to Categories and Milestones</strong><br />
Discussions can be added to specific categories or associated with milestones. On the main discussions page, you can filter discussions by a specific milestone or category.</p>

						<p><strong>Attach Files</strong><br />
An unlimited number of files can be attached to each discussion. Image files will show a small thumbnail of the particular image, and all other files types (.pdf, .doc) will use system images.</p>

<p><strong>Email Notifications</strong><br />
Users can subscribe to discussions to receive notifications when a new message is posted. Subscribers can unsubscribe directly on the discussion page without having to edit the discussion.</p>
						<p><a href="'.$link.'" class="goArrow">Create a discussion now</a></p>
					</div>';
	return $text;	
	}

	function loadDocumentText() {
		$pid = JRequest::getVar('pid');
		$link = JRoute::_('index.php?option=com_jforce&view=file&layout=upload&pid='.$pid);
		$text = '<div class="startupText">
					<h3>About Files</h3>
					<p><strong>Have a Discussion, Upload Files</strong><br />
You can upload files, compare versions and discuss them in the files section. File versions are automatically tracked, and unlimited comments can be posted. Files that are attached to items in other sections of the project are also listed here.</p>

					<p><strong>Link to Categories and Milestones</strong><br />
Files can be added to specific categories or associated with milestones. On the main files page, you can filter files by a specific milestone or category.</p>

					<p><strong>Email Notifications</strong><br />
Users can subscribe to files to receive notifications when a new revision is uploaded or a new comment is posted. Users can manage subscriptions for files and send reminders to any or all of the users subscribed to a file.</p>
						<p><a href="'.$link.'" class="goArrow">Add a document now</a></p>

				</div>';
	return $text;	
	}
	
	function loadTicketText() {
		$pid = JRequest::getVar('pid');
		$link = $pid ? JRoute::_('index.php?option=com_jforce&view=ticket&layout=form&pid='.$pid) : JRoute::_('index.php?option=com_jforce&view=ticket&layout=form');
		$text = '<div class="startupText">
					<h3>About Tickets</h3>
						<p><strong>Custom Fields</strong><br />
An unlimited number of custom fields can be added to tickets in the custom field configuration settings (backend). They can be set to required or not-required, and are useful for gathering additional information a user might not think to provide.</p>

						<p><strong>Link to Categories and Milestones</strong><br />
Tickets can be added to specific categories or associated with milestones. On the main tickets page, you can filter tickets by ‘active’ and ‘resolved’. Once a ticket is completed it is moved to Resolved.</p>

						<p><strong>Have a Discussion, Upload Files</strong><br />
Ticket can have an unlimited number of comments and file attachments. Image files will show a small thumbnail of the particular image, and all other files types (.pdf, .doc) will use system images.</p>
<p><strong>Email Notifications</strong><br />
Users can subscribe to tickets to receive notifications when a new comment is posted, or when a ticket is completed or reopened. Users can manage subscriptions for tickets and send reminders to any or all of the users subscribed to a ticket.</p>
						<p><a href="'.$link.'" class="goArrow">Create a ticket now</a></p>

					</div>';
	return $text;	
	}

	function loadQuoteText() {
		$pid = JRequest::getVar('pid');
		$text = '';
		
	return $text;
	}

	function loadInvoiceText() {
		$pid = JRequest::getVar('pid');
		$text = '';
		
	return $text;
	}	
	
	function loadTimetrackerText() {
		$pid = JRequest::getVar('pid');
		$link = JRoute::_('index.php?option=com_jforce&view=timetracker&layout=form&pid='.$pid);
		$text = '<div class="startupText">
					<h3>About Time Tracking</h3>
						<p><strong>Track Time Spent</strong>
Time can be tracked directly on the time page for every project. It is tracked in hours and a specific date for the time record must be specified.</p>

						<p><strong>Billing for Time</strong><br />
A time record can be marked as billable or not billable. Billable hours can be marked as billed or not billed. Reports can be pulled on time records for both billed and not-billed time.</p>

						<p><strong>Export Data</strong><br />
Time records for every project can be exported in CSV format and used within a spreadsheet application such as Excel. This feature will be available in jForce 2.0 (stable version).</p>  
						<p><a href="'.$link.'" class="goArrow">Enter time now</a></p>

					</div>';
	return $text;
	}
	
	function loadPersonText() {
		$text = '';	
	return $text;
	}
	
	function loadCompanyText() {
		$text = '';
	return $text;
	}
	
	function loadPotentialText() {
		$text = '';
	return $text;
	}
	
	function loadLeadText() {
		$text = '';
	return $text;
	}
	
}