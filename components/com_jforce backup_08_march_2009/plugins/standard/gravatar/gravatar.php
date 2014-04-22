<?php
defined('_JEXEC') or die('Restricted access');

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
    
    if($user->person->accessrole == "Client"){
        //echo "<pre>";
          //  print_r($user->person);
          //die();
        // modify dashboard for client type
        //echo "I am client";         
        //$dashboard = array("My Option"=>array("link"=>"Ram"));
        ?>
        <div class='contentheading'><?php echo JText::_('My Places'); ?></div>
            <div class='tabContainer2'>
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
                    <div class='objectTitle textleft'><a href="/index.php?option=com_jforce&c=project&status=Active">My Progress</a></div>
                    <!--
                    <div class='objectTitle textleft'><a href="#">My Profile</a></div>
                    <div class='objectTitle textleft'><a href="#">My Testimonial</a></div>
                    <div class='objectTitle textleft'><a href="#">My Documents</a></div>                    
                    -->
                    <div class='objectTitle textleft'><a href="/index.php?option=com_user&view=login">Logout</a></div>
               </div>
            </div>
        <?php                
    }else if($user->person->accessrole == "Coach"){
        ?>

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
        <?php
    }
    
    $role = $user->person->accessrole;
    if($role == "Client" || $role == "Coach"){
		// echo a separator
		?>
			<div><br /></div>
		<?php    	
    }
    return true;
}


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
