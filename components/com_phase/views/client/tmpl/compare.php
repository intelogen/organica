<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
$uid = $this->uid;
$pid = $this->pid;
$phases = $this->phases;

if(JRequest::getVar('c') && JRequest::getVar('c') != "")
        {
            $uid = JRequest::getVar('c');
        }
?>


<?php
if($this->evalution_1)
{
    $evalution = $this->evalution_1; 


}

if($this->evalution_1)
{
    $evalution_2 = $this->evalution_2; 


}
if($this->list)
{
    $list = $this->list; 
}

?>


<table>
    <tr><td colspan="2"><div class='contentheading'>Compare Phases</div></td></tr>
    <tr><td colspan="2"><div class='contentheading'>Body Tracking</div></td></tr>
    <tr>
        <td>
                        <div class='tabContainer2' style="background-color:#E1FFE3">
               <table width="50%">
                <tr>
                    <td><?="Weight"?></td>
                    <td><?php if(isset($evalution[body][0])){ echo $evalution[body][0];} ?><?="lbs"?></td>
                </tr>
                <tr>
                    <td><?="Body Fat"?></td>
                    <td><?php if(isset($evalution[body][1])){ echo $evalution[body][1];} ?><?="%"?></td>
                </tr>
                <tr>
                    <td><?="PH"?></td>
                    <td><?php if(isset($evalution[body][2])){ echo $evalution[body][2];} ?><?="%"?></td>
                </tr>

            </table> 
            </div>
        </td>
        <td>
            <div class='tabContainer2' style="background-color:#E1FFE3">
               <table width="50%">
                <tr>
                    <td><?="Weight"?></td>
                    <td><?php if(isset($evalution_2[body][0])){ echo $evalution_2[body][0];} ?><?="lbs"?></td>
                </tr>
                <tr>
                    <td><?="Body Fat"?></td>
                    <td><?php if(isset($evalution_2[body][1])){ echo $evalution_2[body][1];} ?><?="%"?></td>
                </tr>
                <tr>
                    <td><?="PH"?></td>
                    <td><?php if(isset($evalution_2[body][2])){ echo $evalution_2[body][2];} ?><?="%"?></td>
                </tr>

            </table> 


            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Current Photo</div></td>
    </tr>
    <tr>
        <td>
                        <div class='tabContainer2' style="background-color:#E1FFE3"> 
                    <?php
                    if($evalution[photo][0])
                    {
                        ?>

                        <?php
                        echo "<img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[photo][0]."\" width=\"200\" height=\"350\">";
                    }
                    else
                    {
                        echo "  <div style='font-size:15px;color:#008;'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                    }
                    ?>

                    <?php
                    if($evalution[photo][1])
                    {
                        ?>

                        <?php
                        echo "<img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[photo][1]."\" width=\"200\" height=\"350\">";
                    }
                    else
                    {
                        echo "  <div style='font-size:15px;color:#008;'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                    }
                    ?>

            </div>
        </td>
        <td>
                        <div class='tabContainer2' style="background-color:#E1FFE3"> 
                
                    <?php
                    if($evalution_2[photo][0])
                    {
                        ?>

                        <?php
                        echo "<img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution_2[photo][0]."\" width=\"200\" height=\"350\">";
                    }
                    else
                    {
                        echo "  <div style='font-size:15px;color:#008;'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                    }
                    ?>

                
                
                    <?php
                    if($evalution_2[photo][1])
                    {
                        ?>

                        <?php
                        echo "<img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution_2[photo][1]."\" width=\"200\" height=\"350\">";
                    }
                    else
                    {
                        echo "  <div style='font-size:15px;color:#008;'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                    }
                    ?>

            
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Symptoms Tracking</div></td>
    </tr>
    <tr>
        <td>
 
<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution[symptoms]))
{
    for ($i = 0; $i < count($evalution[symptoms][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[symptomList] as $value)
            {
                if($value[id] == $evalution[symptoms][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution[symptoms][status][$i];?>
        </td>
        <td>
            <?=$evalution[symptoms][note][$i];?>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any symptoms</td></tr>
<?php
}
?>
</table>
        </td>
        <td>

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution_2[symptoms]))
{
    for ($i = 0; $i < count($evalution_2[symptoms][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[symptomList] as $value)
            {
                if($value[id] == $evalution_2[symptoms][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution_2[symptoms][status][$i];?>
        </td>
        <td>
            <?=$evalution_2[symptoms][note][$i];?>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any symptoms</td></tr>
<?php
}
?>
</table>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Medical preparations Tracking</div></td>
    </tr>
    <tr>
        <td>

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution[drug]))
{
    for ($i = 0; $i < count($evalution[drug][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[medtrackList] as $value)
            {
                if($value[id] == $evalution[drug][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution[drug][status][$i];?>
        </td>
        <td>
            <?=$evalution[drug][note][$i];?>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any drug</td></tr>
<?php
}
?>
</table>
        </td>
        <td>
            
<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution_2[drug]))
{
    for ($i = 0; $i < count($evalution_2[drug][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[medtrackList] as $value)
            {
                if($value[id] == $evalution_2[drug][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>            
        </td>
        <td>
            <?=$evalution_2[drug][status][$i];?>
        </td>
        <td>
            <?=$evalution_2[drug][note][$i];?>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any drug</td></tr>
<?php
}
?>
</table>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Diseases Tracking</div></td>
    </tr>
    <tr>
        <td>

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution[diseases]))
{
    for ($i = 0; $i < count($evalution[diseases][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[diseasesList] as $value)
            {
                if($value[id] == $evalution[drug][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution[diseases][status][$i];?>
        </td>
        <td>
            <?=$evalution[diseases][note][$i];?>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any drug</td></tr>
<?php
}
?>
</table>

        </td>
        <td>

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution_2[diseases]))
{
    for ($i = 0; $i < count($evalution_2[diseases][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[diseasesList] as $value)
            {
                if($value[id] == $evalution_2[drug][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution_2[diseases][status][$i];?>
        </td>
        <td>
            <?=$evalution_2[diseases][note][$i];?>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any drug</td></tr>
<?php
}
?>
</table>
        </td>
    </tr>
</table>
