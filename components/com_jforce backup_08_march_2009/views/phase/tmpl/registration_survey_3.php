<?php

/************************************************************************************
*    @package        Joomla                                                            *
*    @subpackage        jForce, the Joomla! CRM                                            *
*    @author        Dhruba,JTPL
*    @license        GNU/GPL, see jforce.license.php                                    *
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');    
?>

<div class='contentheading'><?php echo JText::_('DiseaseTrack Instructions'); ?></div>
<div class='tabContainer2'>
<div>
Please check off the diseases you are experiencing and we will track them for you.
</div>
    <form action="<?=JRoute::_("index.php?option=com_jforce&view=phase&task=registration_survey_3&layout=registration_survey_4");?>" method="post">


<table>
        <tr>
        <td><strong>Cardiovascular</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='atherosclerotic-heart-disease'><label>Atherosclerotic Heart Disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='cardio-vascular-disease'><label>Cardio Vascular Disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='cardiomegaly'><label>Cardiomegaly</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='heart-bypass'><label>Heart Bypass</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='hypertension'><label>Hypertension</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='pacemaker'><label>Pacemaker</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='pericarditis'><label>Pericarditis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='peripheral-vascular-disease'><label>Peripheral vascular disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='pulmonary-embolus'><label>Pulmonary embolus</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='stents'><label>Stents</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[cardiovascular][]' value='valve-replacement'><label>Valve replacement</label></td>                
    </tr>

    <tr>
        <td><strong>Neurological</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[neurological][]' value='alzheimers'><label>Alzheimers</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[neurological][]' value='epilepsy'><label>Epilepsy</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[neurological][]' value='lou-gehrigs-disease'><label>Lou Gehrigs Disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[neurological][]' value='migraines'><label>Migraines</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[neurological][]' value='multiple-sclerosis'><label>Multiple sclerosis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[neurological][]' value='muscular-dystrophy'><label>Muscular dystrophy</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[neurological][]' value='parkinsons-disease'><label>Parkinsons disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[neurological][]' value='stroke'><label>Stroke</label></td>                
    </tr>

    <tr>
        <td><strong>Pulmonary</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[pulmonary][]' value='asthma'><label>Asthma</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[pulmonary][]' value='chronic-bronchitis'><label>Chronic bronchitis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[pulmonary][]' value='chronic-obstructive-pulmonary-disease'><label>Chronic obstructive pulmonary disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[pulmonary][]' value='chronic-sinusitis'><label>Chronic sinusitis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[pulmonary][]' value='pneumonia'><label>Pneumonia</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[pulmonary][]' value='tuberculosis'><label>Tuberculosis</label></td>                
    </tr>

    <tr>
        <td><strong>Metabolic</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='anemia'><label>Anemia</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='chronic-fatigue-syndrome'><label>Chronic fatigue syndrome</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='elevated-cholesterol'><label>Elevated cholesterol</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='elevated-triglycerides'><label>Elevated triglycerides</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='erectile-dysfunction'><label>Erectile dysfunction</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='fibromyalgia'><label>Fibromyalgia</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='glaucoma'><label>Glaucoma</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='hepatitis'><label>Hepatitis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='hiv/aids'><label>HIV/AIDS</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='insulin-dependent-diabetes'><label>Insulin dependent diabetes</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='leukemia'><label>Leukemia</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='osteoporosis'><label>Osteoporosis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='peridontal-disease'><label>Peridontal disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='polio'><label>Polio</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='restless-leg-syndrome'><label>Restless leg syndrome</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='thyroid-problems'><label>Thyroid problems</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[metabolic][]' value='type-ii-diabetes'><label>Type II diabetes</label></td>                
    </tr>

    <tr>
        <td><strong>Rheumatological</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[rheumatological][]' value='lupus'><label>Lupus</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[rheumatological][]' value='osteoarthritis'><label>Osteoarthritis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[rheumatological][]' value='rheumatoid-arthritis'><label>Rheumatoid arthritis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[rheumatological][]' value='scleroderma'><label>Scleroderma</label></td>                
    </tr>

    <tr>
        <td><strong>Skin</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[skin][]' value='acne'><label>Acne</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[skin][]' value='eczema'><label>Eczema</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[skin][]' value='psoriasis'><label>Psoriasis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[skin][]' value='skin-cancers'><label>Skin cancers</label></td>                
    </tr>

    <tr>
        <td><strong>Orthopedic</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[orthopedic][]' value='back-problems'><label>Back problems</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[orthopedic][]' value='bursitis'><label>Bursitis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[orthopedic][]' value='carpal-tunnel-syndrome'><label>Carpal tunnel syndrome</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[orthopedic][]' value='history-of-fracture'><label>History of fracture</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[orthopedic][]' value='tendonitis'><label>Tendonitis</label></td>                
    </tr>

    <tr>
        <td><strong>Psychiatric</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[psychiatric][]' value='add'><label>ADD</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[psychiatric][]' value='adhd'><label>ADHD</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[psychiatric][]' value='anorexia'><label>Anorexia</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[psychiatric][]' value='anxiety'><label>Anxiety</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[psychiatric][]' value='bipolar-disease'><label>Bipolar disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[psychiatric][]' value='bulimia'><label>Bulimia</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[psychiatric][]' value='depression'><label>Depression</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[psychiatric][]' value='obsessive-compulsive-disorder'><label>Obsessive compulsive disorder</label></td>                
    </tr>

    <tr>
        <td><strong>Gastrointestinal</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='bowel-obstruction'><label>Bowel obstruction</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='crohns-disease'><label>Crohns disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='diverticulitis'><label>Diverticulitis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='fistula'><label>Fistula</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='gastritis'><label>Gastritis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='ileostomy/colostomy'><label>Ileostomy/colostomy</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='irritable-bowel-syndrome'><label>Irritable bowel syndrome</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='peptic-ulcer-disease'><label>Peptic ulcer disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gastrointestinal][]' value='ulcerative-colitis'><label>Ulcerative colitis</label></td>                
    </tr>

    <tr>
        <td><strong>Gyn</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gyn][]' value='endometriosis'><label>Endometriosis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gyn][]' value='fibrocystic-breast-disease'><label>Fibrocystic breast disease</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gyn][]' value='fibroid'><label>Fibroid</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[gyn][]' value='human-papilloma-virus'><label>Human papilloma virus</label></td>                
    </tr>

    <tr>
        <td><strong>Other</strong></td><td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[other][]' value='appendicitis'><label>Appendicitis</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[other][]' value='cancer-any-type'><label>Cancer (any type)</label></td>                
    </tr>

    <tr>
        <td>&nbsp;</td><td><input type='checkbox' name='disease[other][]' value='herpes'><label>Herpes</label></td>                
    </tr>


    
    <tr>
        <td colspan=2>
            <input type="submit" name="submit" value="Next Step">
        </td>
    </tr>
</table>




</form>

</div>


