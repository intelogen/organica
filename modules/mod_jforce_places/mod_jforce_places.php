<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

$user =& JFactory::getUser();

if(!$user->guest && (JRequest::getVar('option') == 'com_jforce' && JRequest::getVar('view') != 'dashboard')) {
    jforce_tasks_display($user);
}

function jforce_tasks_display(&$user) {
    // this part below is taken from components/com_jforce/plugins/standard/gravatar/gravatar.php
    // line 44: function jtplLoadMaximDashboard($user, $dashboard)
    // cleaned up a bit
    ?>
    <h3 style="visibility: visible; "><span>My</span> Places</h3>
    <style>
        .textleft{
            text-align:left;
            border-bottom:none;
        }
    </style>
    <?php
    if($user->person->accessrole == "Client") { ?>
        <div class='objectTitle textleft'><a href="<?=JRoute::_("index.php?option=com_jforce&c=message&view=message");?>"><?= JText::_('My Messages');?></a></div>
        <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>"><?= JText::_('My Coach');?></a></div>
        <div class='objectTitle textleft'><a href="/index.php?option=com_jforce&view=phase&layout=evaluation">My Progress</a></div>
        <div class='objectTitle textleft'><a href="/index.php?option=com_user&view=login">Logout</a></div>
        <?php
    } else if($user->person->accessrole == "Coach") {
        ?>
        <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>">My Profile</a></div>
        <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>"><?= JText::_('My Clients');?></a></div>
        <div class='objectTitle textleft'><a href="<?=JRoute::_("index.php?option=com_jforce&c=message&view=message");?>"><?= JText::_('My Messages');?></a></div>
        <div class='objectTitle textleft'><a href="<?=JRoute::_('index.php?option=com_user&view=login');?>">Logout</a></div>
        <?php
    } else if($user->person->accessrole == "Administrator") { ?>
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=newcoach">New Coach</a></div>
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=assigncoach">Assign Client To Coach</a></div>
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=admin_email">Change Admin Email</a></div>
    <?php
    }
}