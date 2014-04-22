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

<div class='contentheading'><?php echo JText::_('Phase Initial Survey'); ?></div>
<div class='tabContainer2'>
    <table>
    <tr>
        <td colspan=2><h3>Step 1</h3></td>
    </tr>
    <tr>
        <td width=100><b>Weight</b></td>
        <td><input type="text" style="width: 50px;" tabindex="1" id="txtWeight" name="txtWeight"/>
             <strong>lbs</strong>
        </td>
    </tr>
    <tr>
        <td><b><a target="_blank">Body Fat</a></b></td>
        <td><input type="text" style="width: 50px;" tabindex="2" id="txtBodyFat" name="txtBodyFat"/>
             <strong>%</strong></td>
    </tr>
    <tr>
        <td><b><a target="_blank">PH Score</a></b></td>
        <td><input type="text" style="width: 50px;" tabindex="3" id="txtPHScore" name="txtPHScore"/></td>
    </tr>
    
    <tr>
        <td colspan=2><h3>Step 2</h3></td>
    </tr>
    
    <tr>
        <td bgcolor="#000000" colspan="2"><div align="center">
                <h2 class="style5"><span class="style2"> </span><span class="style7">Digestive / 
                        Intestinal Questionnaire Start: <strong><u/></strong></span>
                </h2>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2"><p align="center" class="maximErrorH"> </p>
        </td>
    </tr>
    <tr>
        <td width="77%"><p class="style1">Do you have any digestive diagnosed disease, such as, 
                Crohns, Diverticulitis, IBS, Celiac, Ulcerative Colitis etc?</p>
        </td>
        <td bgcolor="#fff9d2" width="23%"><p class="style1">
                <input type="radio" id="Radio36" name="Diabetes Thyroid Other" value="Yes"/>
                Yes    <input type="radio" checked="checked" id="Radio49" name="Diabetes Thyroid Other" value="No"/>
                No</p>
        </td>
    </tr>
    <tr>
        <td><p class="style1">Are you on any medication for any Gastrointestinal Disorder?</p>

        </td>

        <td bgcolor="#fff9d2"><p class="style1">

                <input type="radio" id="Radio37" name="Endocrine Disorder" value="Yes"/>

                Yes    <input type="radio" checked="checked" id="Radio48" name="Endocrine Disorder" value="No"/>

                No</p>

        </td>

    </tr>

    <tr>

        <td><p class="style1">Are you extremely sensitive to any herbs or vitamins?</p>

        </td>

        <td bgcolor="#fff9d2"><p class="style1">

                <input type="radio" id="Radio38" name="Hypertension_" value="Yes"/>

                Yes    <input type="radio" checked="checked" id="Radio47" name="Hypertension_" value="No"/>

                No</p>

        </td>

    </tr>

    <tr>

        <td><p class="style1">Are you NOT committed to being healthy?</p>

        </td>

        <td bgcolor="#fff9d2"><p class="style1">

                <input type="radio" checked="checked" id="Radio39" name="Lipid_Disorder" value="Yes"/>

                Yes    <input type="radio" id="Radio46" name="Lipid_Disorder" value="No"/>

                No</p>

        </td>

    </tr>

    <tr>

        <td colspan="2"> </td>

    </tr>

    <tr>

        <td colspan="2"><p>If you have any of these disease states, talk to your doctor or 

                practitioner before starting any complimentary health program.</p>

        </td>

    </tr>

    <tr>

        <td colspan="2"><p>Alternatively, educate yourself on the benefits from clinical 

                articles to gain a better understanding of the benefits and sit down with a 

                clinician to help you through the process.</p>

        </td>

    </tr>
    
    </table>
</div>