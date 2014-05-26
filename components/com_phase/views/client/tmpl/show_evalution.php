<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
if($this->start)
{
foreach ($this->start as $value)
{
    $name = $value->name;
}
}
else
{
        $name = "Start survey";
}
?>




<table border="1" bordercolor="black" width = 100%>
    <tr>
        <td colspan="2">
        <?php
        foreach ($this->phases as $value)
        {
            $phases[]=$value->id;
            $l=$value->leader;
        }
        ?>

        <div class='contentheading'> <?php echo JText::_('Progress Tracking - '.$name); ?> </div>

        <a href="index.php?option=com_phase&controller=client&action=show_evalution&c=<?=$l?>">Start survey</a>
        <?php
        $q = 1;
        for ($i = 0; $i < count($phases); $i++)
        :
            ?>
            <a href="index.php?option=com_phase&controller=client&action=show_evalution&pid=<?=$phases[$i]?>&c=<?=$l?>"><?=$q?></a>
            <?php
            $q++;
        endfor;
        ?>
        </td>
    </tr>
    
    <tr>
        <td align="center" colspan="2"><div class='contentheading'> UQ </td>
    </tr>
    <tr>
        <td colspan="2">
        <?php
        if($this->uq)
        {
            if($this->uq == no)
            {
                echo 'None of';
            }
            else
            {
            foreach ($this->uq as $value)
                {
                echo $value->answer."<br>";
                }    
            }
        }
        else
        {
        echo 'No Information Has Been Provided Yet';    
        }
        ?>
        </td>

    <tr>
        <td colspan="2">
            
            <?php
            if($this->trackingStart){  ?>
            <!-- Body score chart initialization -->
            <script type="text/javascript">
                var bodyscore_chart;
                jQuery(document).ready(function() {
                    bodyscore_chart = new Highcharts.Chart({
                      chart: {
                         renderTo: 'bs_container',
                         defaultSeriesType: 'column'
                      },
                      colors: ['#0096D6'],
                      title: {
                         text: ''
                      },
                      xAxis: {
                         categories: <?php echo $this->trackingStart->cats ?>
                      },
                      yAxis: {
                         min: 0,
                         max: 100,
                         title: {
                            text: 'Percentage'
                         },
                         tickInterval: 10
                      },
                      tooltip: {
                          enabled: false
                      },
                      legend: {
                          enabled: false
                      },
                      credits: {
                          enabled: false
                      },
                      plotOptions: {
                         column: {
                            enableMouseTracking: false
                         }
                      },
                           series: [{
                          data: <?php echo $this->trackingStart->opp_vals ?>
                      }]
                   });
                });
            </script>
            <div id="bs_container" style="width: 100%; height: 300px"></div>
        <?php }  ?>
            
            
            
            
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2"><div class='contentheading'> Body Score </div></td>
    </tr>
    <tr>
        <td colspan="2">
        <?php
        if($this->fat)
            {
                echo "вес".$this->fat[0];
                echo '<br>';
                echo "жир".$this->fat[1];
                echo '<br>';
                echo "PH".$this->fat[2];
                echo '<br>';
            }
        else
            {
                echo 'No Information Has Been Provided Yet';    
            }
        ?>  
        </td>
    </tr>
        <tr>
        <td align="center" colspan="2"> <div class='contentheading'> Photo </div> </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if($this->photo):
                echo "  <div style='font-size:15px;color:#008;'>
                <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->photo[0]."\" width=\"230\" height=\"350\">
                <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->photo[1]."\" width=\"230\" height=\"350\">
                </div>";
            ?>    
            <?php    
            else:
                echo 'No Information Has Been Provided Yet';    
            endif;
            ?>   
        </td>
    </tr>
        <tr>
        <td align="center" colspan="2"><div class='contentheading'> Symptoms: </div></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if($this->symptoms)
            {
                if($this->symptoms == no)
                {
                    echo 'None of';
                }
                else
                {
                foreach ($this->symptoms as $value)
                {
                echo $value->name."<br>";    
                }    
                }

            }
            else
            {
                echo 'No Information Has Been Provided Yet';    
            }
            ?> 
        </td>
    </tr>
        <tr>
        <td align="center" colspan="2"><div class='contentheading'> Medtrack </div></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if($this->medtrack)
            {    
                if($this->medtrack == no)
                {
                    echo 'None of';
                }
                else
                {
                foreach ($this->medtrack as $value)
                {
                echo $value->name."<br>";    
                }    
                }

            }
            else
            {
            echo 'No Information Has Been Provided Yet';    
            }
            ?>    
        </td>
    </tr>
        <tr>
        <td align="center" colspan="2"><div class='contentheading'> Diseases </div></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if($this->diseases)
            {
                if($this->diseases == no)
                {
                    echo 'None of';
                }
                else
                {
                foreach ($this->diseases as $value)
                {
                echo $value->name."<br>";    
                }    
                }

            }
            else
            {
            echo 'No Information Has Been Provided Yet';    
            }
            ?>  
        </td>
    </tr>
</table>

