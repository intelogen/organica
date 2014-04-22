<?php
if($user->person->accessrole == "Client") 
        {
        //echo "<pre>";
          //  print_r($user->person);
          //die();
        // modify dashboard for client type
        //echo "I am client";         
        //$dashboard = array("My Option"=>array("link"=>"Ram"));
        ?>
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
        <?php                
    }
    else if($user->person->accessrole == "Coach") 
        {
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
    
    else if($user->person->accessrole == "Administrator") 
        {?>
      
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
    
    <?php
    }
    
  ?>  
    
    
    
    
    
    
<?php    
    
    switch ($user->person->accessrole == "Client")
    {
     case "Client":   
        ?>
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
<?php                break;
case "Coach":
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
<?php            break;
case "Administrator":
        ?>
      
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
<?php
        
        
    }
    ?>