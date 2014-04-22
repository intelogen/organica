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
<div class="tabContainer2">
    <p>
        Below are the surveys specific to this phase. This information is needed to specifically evaluate your health and track your progress. Answer the questions to complete survey accordingly.
        <br />
        <ul>
            <li><a href="#step1">Step 1: General Intake survey</a></li>
            <li><a href="#step2">Step 2: Body Score survey</a></li>
            <li><a href="#step3">Step 3: Phase Start survey</a></li>
        </ul>
    </p>
</div>
<br />

<form method="post" action="<?=$this->step_action_link;?>">
<div class='tabContainer2'>
    <a href="#" name="step1"></a>
    <h3>Step 1 (General Intake Survey)</h3>
        <table>    
        <tr>
            <td colspan=2>
                <table>
                    <tr>
                        <td width=100><b>Weight</b></td>
                        <td><input type="text" style="width: 50px;" tabindex="1" id="txtWeight" name="survey_weight"/>
                             <strong>lbs</strong>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Body Fat</b></td>
                        <td><input type="text" style="width: 50px;" tabindex="2" id="txtBodyFat" name="survey_fat"/>
                             <strong>%</strong></td>
                    </tr>
                    <tr>
                        <td><b>PH Score</b></td>
                        <td><input type="text" style="width: 50px;" tabindex="3" id="txtPHScore" name="survey_ph"/></td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </div>
    <br />

    <div class="tabContainer2">
        <a href="#" name="step2"></a>
        <table>    
        <tr>
            <td colspan=2><h3>Step 2 (Body Score Survey)</h3></td>
        </tr>
        <tr>
            <td colspan=2>
                <table>
                                  <tr>
                                      <td align="right" style="width: 48px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblDigestiveLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=digestion&amp;headerid=1490&amp;score=100','results1')"><b>Digestive</b></a></span></td>
                                      <td align="center" style="width: 46px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblDigestive">100%</span></td>
                                      <td>
                                          <!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcDigestive"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcDigestive" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="right" style="width: 48px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblIntestinalLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=intestinal&amp;headerid=1490&amp;score=100','results2')"><b>Intestinal</b></a></span></td>
                                      <td align="center" style="width: 46px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblIntestinal">100%</span></td>
                                      <td><!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcIntestinal"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcIntestinal" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="right" style="width: 48px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblCirculatoryLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=circulatory&amp;headerid=1490&amp;score=100','results3')"><b>Circulatory</b></a></span></td>
                                      <td align="center" style="width: 46px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblCirculatory">100%</span></td>
                                      <td><!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcCirculatory"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcCirculatory" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="right" style="width: 48px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblNervousLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=nervous&amp;headerid=1490&amp;score=100','results4')"><b>Nervous</b></a></span></td>
                                      <td align="center" style="width: 46px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblNervous">100%</span></td>
                                      <td><!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcNervous"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcNervous" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="right" style="width: 48px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblImmuneLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=immune&amp;headerid=1490&amp;score=100','results5')"><b>Immune</b></a></span></td>
                                      <td align="center" style="width: 46px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblImmune">100%</span></td>
                                      <td><!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcImmune"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcImmune" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="right" style="width: 48px; height: 18px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblRespiratoryLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=respiratory&amp;headerid=1490&amp;score=100','results6')"><b>Respiratory</b></a></span></td>
                                      <td align="center" style="width: 46px; height: 18px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblRespiratory">100%</span></td>
                                      <td style="height: 18px;"><!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcRespiratory"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcRespiratory" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="right" style="width: 48px; height: 20px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblUrinaryLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=urinary&amp;headerid=1490&amp;score=100','results7')"><b>Urinary</b></a></span></td>
                                      <td align="center" style="width: 46px; height: 20px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblUrinary">100%</span></td>
                                      <td style="width: 79px; height: 20px;"><!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcUrinary"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcUrinary" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="right" style="width: 48px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblGlandularLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=glandular&amp;headerid=1490&amp;score=100','results8')"><b>Glandular</b></a></span></td>
                                      <td align="center" style="width: 46px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblGlandular">100%</span></td>
                                      <td style="width: 79px;"><!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcGlandular"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcGlandular" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="right" style="width: 48px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblStructuralLink"><a href="javascript:cw('http://maximlrg.com/MaximOnline/client/clBodyScoreDetails.aspx?system=structural&amp;headerid=1490&amp;score=100','results9')"><b>Structural</b></a></span></td>
                                      <td align="center" style="width: 46px;">
                                          <span style="font-weight: bold; font-family: Verdana;" id="lblStructural">100%</span></td>
                                      <td style="width: 79px;"><!-- epicFlashControl V2.2.01 -->
    <script type="text/javascript">AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','80','height','20','src','http://www.maximlrg.com/maximonline/images/flash/meter','name','http://www.maximlrg.com/maximonline/images/flash/meter','quality','High','flashvars','percent=100','wmode','Transparent','menu','True','play','True','loop','True','scale','None' );</script><embed width="80" height="20" type="application/x-shockwave-flash" scale="None" loop="True" play="True" menu="True" wmode="Transparent" flashvars="percent=100" quality="High" name="http://www.maximlrg.com/maximonline/images/flash/meter" src="http://www.maximlrg.com/maximonline/images/flash/meter.swf"/> 
    <noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="80" height="20" id="fcStructural"><param name="movie" value="http://www.maximlrg.com/maximonline/images/flash/meter.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="menu" value="true"><param name="play" value="True"><param name="loop" value="true"><param name="scale" value="none">
    <param name="flashvars" value="percent=100"><embed src="http://www.maximlrg.com/maximonline/images/flash/meter.swf" quality="high" wmode="transparent" play="true" loop="true" width="80" height="20" name="fcStructural" scale="None" flashvars="percent=100" menu="True" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer"></embed></object></noscript>
                                      </td>
                                  </tr>
                </table>                    
            </td>
        </tr>
        
        </table>
        </div>
        <br />
        
        
        <div class="tabContainer2">
        <a href="#" name="step3"></a>
        <table>    
        <tr>
            <td colspan=2><h3>Step 3 (Phase Start Survey)</h3></td>
        </tr> 
        <tr>
            <td colspan="2">
                <strong>Digestive / Intestinal Questionnaire Start:</strong>
            </td>
        </tr>
        <tr>
            <td width="77%"><p class="style1">Do you have any digestive diagnosed disease, such as, 
                    Crohns, Diverticulitis, IBS, Celiac, Ulcerative Colitis etc?</p>
            </td>
            <td bgcolor="#fff9d2" width="23%"><p class="style1">
                    <input type="radio" id="Radio36" name="diabetes-thyroid" value="Y"/>
                    Yes    <input type="radio" checked="checked" id="Radio49" name="diabetes-thyroid" value="N"/>
                    No</p>
            </td>
        </tr>
        <tr>
            <td><p class="style1">Are you on any medication for any Gastrointestinal Disorder?</p>

            </td>

            <td bgcolor="#fff9d2"><p class="style1">

                    <input type="radio" id="Radio37" name="endochrine-disorder" value="Y"/>

                    Yes    <input type="radio" checked="checked" id="Radio48" name="endochrine-disorder" value="N"/>

                    No</p>

            </td>

        </tr>

        <tr>

            <td><p class="style1">Are you extremely sensitive to any herbs or vitamins?</p>

            </td>

            <td bgcolor="#fff9d2"><p class="style1">

                    <input type="radio" id="Radio38" name="hypertension" value="Y"/>

                    Yes    <input type="radio" checked="checked" id="Radio47" name="hypertension" value="N"/>

                    No</p>

            </td>

        </tr>

        <tr>

            <td><p class="style1">Are you NOT committed to being healthy?</p>

            </td>

            <td bgcolor="#fff9d2"><p class="style1">

                    <input type="radio" checked="checked" id="Radio39" name="committed-not-being-healthy" value="Y"/>

                    Yes    <input type="radio" id="Radio46" name="committed-not-being-healthy" value="N"/>

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
        
        <!-- Step 3 ends here ------------------->
        
        </table>
        <table>
            <tr>
                <td>
                    <?php echo JHTML::_( 'form.token' ); ?>
                    <input type="hidden" name="step_redirection_link" value="<?=$this->step_redirection_link; ?>" >
                    <input type="hidden" name="phase_id" value="<?=$this->phase_id ?>" >
                    <input type="submit" value="Mark Step as Completed">
                </td>
            </tr>
        </table>
    </div>
</form>