<?php
defined('_JEXEC') or die('Restricted access');
?>






<?php
$test = $test;
$mainframe->registerEvent('onLoadPerson', 'jfGravatar');
#$mainframe->registerEvent('onLoadComment','jfGravatar');
$mainframe->registerEvent('onLoadDashboard', 'jtplLoadMaximDashboard');

function jfGravatar($person) {
	
	$params = JForcePluginHelper::loadParams('gravatar');
	
	$defaultPersonThumb = '<img src="'.JURI::root().'components/com_jforce/images/people_icons/default.png" />';
	$defaultPersonLarge = '<img src="'.JURI::root().'"components/com_jforce/images/people_icons/default_large.png" />';
	
	$defaultPersonThumbPath = JURI::root().'components/com_jforce/images/people_icons/default.png';
	$defaultPersonLargePath = JURI::root().'components/com_jforce/images/people_icons/default_large.png';
	
	$rating = $params->get('rating', 'g');
		
	if ($person->email):
		
		$imageHash = md5($person->email);
		
		if($person->image == $defaultPersonThumb):
			$default = $params->get('default', $defaultPersonThumbPath);
			$size = $params->get('thumb_size', '50');	
		elseif($person->image == $defaultPersonLarge):
			$default = $params->get('default', $defaultPersonLargePath);
			$size = $params->get('large_size', '150');
		endif;
		
		$person->image = '<img src="http://www.gravatar.com/avatar/'.$imageHash.'?d='.$default.'&s='.$size.'&r='.$rating.'" />';
		
	endif;

	return true;
}


# JForce Hack Added by Dhruba(CD, JTPL)

/** whatever done here has to be separated into a separate JForcePlugin Directory and files **/




function jtplLoadMaximDashboard($user, $dashboard){
    
    ?>
    <div class='contentheading'><?php echo JText::_('Welcome'); ?></div>
        <div class="tabContainer2" style="text-align:justify;background-color:#EFFFAB">
            <img src="/images/icons/information.png" style="float:left;padding:5px;margin:5px;">
            
            <!-- Dear <?=$user->person->accessrole;?> , -->
            Dear <?=$user->name; ?>, 
            <br />
            Welcome to your administration control panel. 
            <br />        <br />        
            <?php
                switch($user->person->accessrole){
                    case "Client":
                        ?>Being a Client of <u>Maxim Health System</u>, You will be allocated with a series of phases and assigned a coach to track your progress.
                        Your Coach will be responsible for monitoring symptoms and changes in you, and will be a guide to make sure that you are following Maxim Health System to plan your body.  
                        <?
                    break;
                    case "Coach":
                        ?>                        
                            Being a Coach for <u>Maxim Health System</u>, You will be responsible for monitoring the clients allocated to you, 
                            and will help clients in tracking their progress according to the Maxim Health System Plan. 
                            <br />
                            Furhter, you will be responsible for signing off the phases and assigning new phases according to the client progress. 
                          
                            Also, you will be providing guidances, will be communicating with the clients and will also be recommending products to the clients as per their phase tracking. 
                        <?
                    break;
                    case "Administrator":
                        ?>
                            Being the ADMINISTRATOR of Maxim Health System, you will be responsible for allocating Coach to Clients and vice versa. 
                        <?
                    break;
                }
            ?>
    </div>
    <div><br /></div>
    




    
    
    
    
    <?php
                        
    //старое меню
    /*
    echo ' 
    

<?php if ($user->person->accessrole == "Client"): ?>
<div class='contentheading'><?php echo JText::_('My Places'); ?></div>
            <div class='tabContainer2'  style="background-color:#FFFFE2">
                <div>
                    <style>
                        .textleft{
                            text-align:left;
                            border-bottom:none;
                        }
                    </style>                    
                    <div class='objectTitle textleft'><a href="<?=JRoute::_("index.php?option=com_jforce&c=message&view=message");?>"><?= JText::_('My Messages');?></a></div>
                    <!--
                    <div class='objectTitle textleft'><a href="#">My Exercises</a></div>
                    <div class='objectTitle textleft'><a href="#">My Nutrition</a></div>
                    -->
                    <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>"><?= JText::_('My Coach');?></a></div>
                    <!--<div class='objectTitle textleft'><a href="/index.php?option=com_jforce&c=project&status=Active">My Progress</a></div>-->
                    <div class='objectTitle textleft'><a href="/index.php?option=com_jforce&view=phase&layout=evaluation">My Progress</a></div>
                    <!--
                    <div class='objectTitle textleft'><a href="#">My Profile</a></div>
                    <div class='objectTitle textleft'><a href="#">My Testimonial</a></div>
                    <div class='objectTitle textleft'><a href="#">My Documents</a></div>                    
                    -->
                    <div class='objectTitle textleft'><a href="/index.php?option=com_user&view=login">Logout</a></div>
               </div>
            </div>
<?php endif; ?>
    
    
<?php if ($user->person->accessrole == "Coach"): ?>
<!-- Following are the requirements for a coach dashboard
        Notifications
        Clients
        Your Bio
        Reports
        Presentation and Links
        Store
        -->

        <div class='contentheading'><?php echo JText::_('My Places'); ?></div>
            <div class='tabContainer2'>
                <div>
                    <style>
                        .textleft{
                            text-align:left;
                            border-bottom:none;
                        }
                    </style>
                    <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>">My Profile</a></div>
                    <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>"><?= JText::_('My Clients');?></a></div>
                    <div class='objectTitle textleft'><a href="<?=JRoute::_("index.php?option=com_jforce&c=message&view=message");?>"><?= JText::_('My Messages');?></a></div>
                    <!--
                    <div class='objectTitle textleft'><a href="#">My Exercises</a></div>
                    <div class='objectTitle textleft'><a href="#">My Nutrition</a></div>
                    <div class='objectTitle textleft'><a href="#">My Coach</a></div>
                    <div class='objectTitle textleft'><a href="#">My Progress</a></div>                    
                    <div class='objectTitle textleft'><a href="#">My Testimonial</a></div>
                    <div class='objectTitle textleft'><a href="#">My Documents</a></div>
                    -->
                    <div class='objectTitle textleft'><a href="<?=JRoute::_('index.php?option=com_user&view=login');?>">Logout</a></div>
               </div>
            </div>
<?php endif; ?>
    
<?php if ($user->person->accessrole == "Administrator"): ?>    
<div class='contentheading'><?php echo JText::_('My Places'); ?></div>
    <div class="tabContainer2" style="background-color:#E8FFEF">
        <style>
            .textleft{
                text-align:left;
                border-bottom:none;
            }
        </style>
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=newcoach">New Coach</a></div>
        <!-- <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&ayout=allcoach">All Coaches</a></div> -->
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=assigncoach">Assign Client To Coach</a></div>
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=admin_email">Change Admin Email</a></div>


    </div>
<?php endif; ?> 




    ';
    */
    //конец
    ?>
    
    
    
  
    
    

    
<?php
/*
$user =& JFactory::getUser();
$userId = $user->id;

//isAdmin
$admin = null;

$query = "SELECT usertype FROM #__users WHERE id = $userId";
$result =  $this->_getList($query);
        
foreach ($result as $result) { $result = $result->usertype;}

if($result == 'Super Administrator')
{
$admin = 1;
}
else
{
$admin = 0;
}

//isAdmin

if($admin == 0)
{
    
//isCoach
$coach = null;

$query = "SELECT id FROM #__jf_companies WHERE owner = $userId";
$result =  $this->_getList($query);
if($result)
{
$coach = 1;
}
else
{
$coach = 0;
}

//isCoach



//isClient
$client = null;

$query = "SELECT id FROM #__jf_companies WHERE owner = $userId";
$result =  $this->_getList($query);
if($result)
{
$client = 0;
}
else
{
$client = 1;
}

//isClient

}

    if($admin == 1){$role = 'admin';}
    if($coach == 1){$role = 'coach';}
    if($client == 1){$role = 'client';}
 */


//echo '<pre>';
//var_dump($user);
?>
    
    
    
    
    
    
    
    

    
    
    
<?php if ($user->person->accessrole == "Client"): ?>
<div class='contentheading'><?php echo JText::_('My Places'); ?></div>
            <div class='tabContainer2'  style="background-color:#FFFFE2">
                <div>
                    <style>
                        .textleft{
                            text-align:left;
                            border-bottom:none;
                        }
                    </style>                    
                    <div class='objectTitle textleft'><a href="<?=JRoute::_("index.php?option=com_jforce&c=message&view=message");?>"><?= JText::_('My Messages');?></a></div>
                    <!--
                    <div class='objectTitle textleft'><a href="#">My Exercises</a></div>
                    <div class='objectTitle textleft'><a href="#">My Nutrition</a></div>
                    -->
                    <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>"><?= JText::_('My Coach');?></a></div>
                    <!--<div class='objectTitle textleft'><a href="/index.php?option=com_jforce&c=project&status=Active">My Progress</a></div>-->
                    <div class='objectTitle textleft'><a href="/index.php?option=com_jforce&view=phase&layout=evaluation">My Progress</a></div>
                    <!--
                    <div class='objectTitle textleft'><a href="#">My Profile</a></div>
                    <div class='objectTitle textleft'><a href="#">My Testimonial</a></div>
                    <div class='objectTitle textleft'><a href="#">My Documents</a></div>                    
                    -->
                    <div class='objectTitle textleft'><a href="/index.php?option=com_user&view=login">Logout</a></div>
               </div>
            </div>
<?php endif; ?>
    
    
<?php if ($user->person->accessrole == "Coach"): ?>
<!-- Following are the requirements for a coach dashboard
        Notifications
        Clients
        Your Bio
        Reports
        Presentation and Links
        Store
        -->

        <div class='contentheading'><?php echo JText::_('My Places'); ?></div>
            <div class='tabContainer2'>
                <div>
                    <style>
                        .textleft{
                            text-align:left;
                            border-bottom:none;
                        }
                    </style>
                    <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>">My Profile</a></div>
                    <div class='objectTitle textleft'><a href="<?=$user->person->companyLink;?>"><?= JText::_('My Clients');?></a></div>
                    <div class='objectTitle textleft'><a href="<?=JRoute::_("index.php?option=com_jforce&c=message&view=message");?>"><?= JText::_('My Messages');?></a></div>
                    <!--
                    <div class='objectTitle textleft'><a href="#">My Exercises</a></div>
                    <div class='objectTitle textleft'><a href="#">My Nutrition</a></div>
                    <div class='objectTitle textleft'><a href="#">My Coach</a></div>
                    <div class='objectTitle textleft'><a href="#">My Progress</a></div>                    
                    <div class='objectTitle textleft'><a href="#">My Testimonial</a></div>
                    <div class='objectTitle textleft'><a href="#">My Documents</a></div>
                    -->
                    <div class='objectTitle textleft'><a href="<?=JRoute::_('index.php?option=com_user&view=login');?>">Logout</a></div>
               </div>
            </div>
<?php endif; ?>
    
<?php if ($user->person->accessrole == "Administrator"): ?>    
<div class='contentheading'><?php echo JText::_('My Places'); ?></div>
    <div class="tabContainer2" style="background-color:#E8FFEF">
        <style>
            .textleft{
                text-align:left;
                border-bottom:none;
            }
        </style>
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=newcoach">New Coach</a></div>
        <!-- <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&ayout=allcoach">All Coaches</a></div> -->
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=assigncoach">Assign Client To Coach</a></div>
        <div class="objectTitle textleft"><a href="/index.php?option=com_jforce&view=phase&layout=admin_email">Change Admin Email</a></div>


    </div>
<?php endif; ?> 
    
    
     
<?php
}
?>
    
    
    
    
    
    
    
    
    
    

    
    
    <?php
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //$role = $user->person->accessrole;
   // if($role == "Client" || $role == "Coach"){
		// echo a separator
		?>
			<div><br /></div>
		<?php    	
    //}
    return true;
}

?>
                        
                        
                        
                        
               
<?php

//$mainframe->registerEvent('onLoadCompany', "modifyCompanyToCoach");

function modifyCompanyToCoach($company){
    //echo "<pre>";
    if($company->people){
        //$company->owner=62;
        $i=0;
        $ownerfound = 0;
        foreach($company->people as $p){            
            //echo $p->firstname;
            if($p->uid == $company->owner){
                unset($company->people[$i]);
                $ownerfound = 1;
            }            
            $i++;
        }
    }
    //echo "<pre>";
//    print_r($company);
    //die();
    
    // When a company loads check if one person has been assigned to more than one companies
}

# Hack Ends
