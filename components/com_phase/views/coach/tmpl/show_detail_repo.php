<?php
if($this->data)
{
    $data = $this->data;
}

?>
<div class='contentheading'><?='Client Body Stats';?></div>
<table border="1">
    <tr>
        <td>Date</td>
        <td>Weight</td>
        <td>Body Fat</td>
    </tr>
    <?php
    foreach ($data as $value)
    {
    ?>
        <tr>
        <td><?=$value[0]."<br>";?></td>
        <td><?=$value[1]."<br>";?></td>
        <td><?=$value[2]."<br>";?></td>
        </tr>
    <?php    
    }
    ?>
    
</table>