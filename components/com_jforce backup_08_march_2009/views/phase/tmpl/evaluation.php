<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			results.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<div class='contentheading'><?php echo JText::_('End evaluation for the phase'); ?></div>

<!-- Step 1 -->

<form method="post" action="<?=$this->step_action_link;?>">
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="step_redirection_link" value="<?=$this->step_redirection_link; ?>" >
<input type="hidden" name="phase_id" value="<?=$this->phase_id ?>" >
        
<div class='tabContainer2'>
    <div>
        <h3>Phase 1 End Survey  </h3>
    </div>
    <table>
		<tbody>
            <tr>
                <td><p class="style1">Do you have normal bowel movements of solid consistency?</p>
                </td>
                <td bgcolor="#fff9d2"><p class="style1">
                        <input type="radio" id="Radio36" name="Diabetes Thyroid Other" value="Yes"/>
                        Yes<input type="radio" id="Radio49" name="Diabetes Thyroid Other" value="No"/>
                        No</p>
                </td>
            </tr>
            <tr>
                <td><p class="style1">Are you going to the bathroom at least 1 good complete evacuation 
                        or better 2 to 3 per day?</p>
                </td>
                <td bgcolor="#fff9d2"><p class="style1">
                        <input type="radio" id="Radio37" name="Endocrine Disorder" value="Yes"/>
                        Yes<input type="radio" id="Radio48" name="Endocrine Disorder" value="No"/>
                        No</p>
                </td>
            </tr>
            <tr>
                <td><p class="style1">Is your average pH of 3 to 5 samplings in the normal range 
                        between 6.8 and 7.4?
                    </p>
                </td>
                <td bgcolor="#fff9d2"><p class="style1">
                        <input type="radio" id="Radio38" name="Hypertension_" value="Yes"/>
                        Yes<input type="radio" id="Radio47" name="Hypertension_" value="No"/>
                        No</p>
                </td>
            </tr>
            <tr>
                <td><p class="style1">Are you tired and lethargic?
                    </p>
                </td>
                <td bgcolor="#fff9d2"><p class="style1">
                        <input type="radio" id="Radio39" name="Lipid_Disorder" value="Yes"/>
                        Yes<input type="radio" id="Radio46" name="Lipid_Disorder" value="No"/>
                        No</p>
                </td>
            </tr>
            <tr>
                <td><p class="style1">Are you eating 5 to 7 small meals per day consistently?
                    </p>
                </td>
                <td bgcolor="#fff9d2"><p class="style1">
                        <input type="radio" id="Radio40" name="Cardiovascular_Disease" value="Yes"/>
                        Yes<input type="radio" id="Radio45" name="Cardiovascular_Disease" value="No"/>
                        No</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>	
<div>
    &nbsp;
</div>
<!-- Step 2 -->
<div class="tabContainer2">
    <div>
        <h3>Retake Body Score Survey</h3>
    </div>
    <table>
        
    </table>
</div>
<div>
    &nbsp;
</div>
<!-- Step 3 -->
<div class="tabContainer2">
    <div>
        <h3>
            Retake Intake Survey
        </h3>
    </div>
    <table>
        <tr>
            <td valign="top" align="center" colspan="3"><div align="left">
                    <table width="277" border="0" align="center">
                        <tbody><tr>
                            <td width="72"><b><a target="_blank">Weight</a></b></td>
                            <td width="318"><input type="text" style="width: 50px;" tabindex="1" id="txtWeight" value="100" name="txtWeight"/>
                                <strong>lbs</strong></td>
                        </tr>
                        <tr>
                            <td><b><a target="_blank">Body Fat</a></b></td>
                            <td><input type="text" style="width: 50px;" tabindex="2" id="txtBodyFat" value="10" name="txtBodyFat"/>
                            <strong>%</strong></td>
                        </tr>
                        <tr>
                            <td><b><a target="_blank">PH Score</a></b></td>
                            <td><input type="text" style="width: 50px;" tabindex="3" id="txtPHScore" value="7" name="txtPHScore"/></td>
                        </tr>
                    </tbody></table>
                </div>
            </td>
        </tr>
    </table>
</div>
<div>
    &nbsp;
</div>
<!-- Step 4 -->
<div class="tabContainer2">
    <h3>Phase End Photo</h3>
    <div>
        <?php 
            if ($this->phase_details->endphoto):
                // display link to phase end photo upload form
                echo $this->phase_details->endphoto;
                ?>
                    Visit the photo upload page and upload your picture there
                <?
            else :
                // display phase end photo
                ?>
                    This is your phase end photo
                <?
            endif;                                                                
        ?>
    </div>    
</div>
<div>
    &nbsp;
</div>
<!-- Step 4 -->
<div class="tabContainer2">
    <h3>Update Tracking</h3>
    <div>
        
    </div>    
</div>

<br />
<div class="tabContainer2">
    <input type="submit" value="Mark Step as Completed">
</div>

</form>