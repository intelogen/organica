<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

    
<?php
if($this->target)
{
    $target = ($this->target);
}
if($this->current)
{
    $current = ($this->current);
}
if($this->bodyHistory)
{
    $bodyHistory = ($this->bodyHistory);
}

echo 'Weight History - values for chart<br>';
foreach ($bodyHistory as $value)
    {
        $value[val] = explode(",", $value[val]);
        $value[weight] = $value[val][0];
        echo "Date - ".$value[date]." Phase - ".$value[pid]." Weight - ".$value[weight]."<br>";
    }

echo '<br><br><br>';
echo 'Fat History - values for chart<br>';    
foreach ($bodyHistory as $value)
    {
        $value[val] = explode(",", $value[val]);
        $value[weight] = $value[val][1];
        echo "Date - ".$value[date]." Phase - ".$value[pid]." Weight - ".$value[weight]."<br>";
    }
echo '<br><br><br>';






?>


<table border="1">
    <tr>
        <td>Height</td>
        <td><?php if(!empty($target[target_height])){echo $target[target_height][0]." ft ".$target[target_height][1]." inc ";} ?></td>
    </tr>
    <tr>
        <td>Weight</td>
        <td><?php if(!empty($current[body])){echo $current[body][0];} ?></td>
    </tr>
    <tr>
        <td>Target Weight</td>
        <td><?php if(!empty($target[target_body])){echo $target[target_body][0];} ?></td>
    </tr>
    <tr>
        <td>Body Fat</td>
        <td><?php if(!empty($current[body])){echo $current[body][1]." % ";} ?></td>
    </tr>
    <tr>
        <td>Target Body Fat</td>
        <td><?php if(!empty($target[target_body])){echo $target[target_body][1]." % ";} ?></td>
    </tr>
    <tr>
        <td>Blood Type</td>
        <td><?php if(!empty($target[blood_type])){echo $target[blood_type];} ?></td>
    </tr>
</table>





