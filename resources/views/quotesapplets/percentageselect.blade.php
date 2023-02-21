<select class='dsitxtbox' id='percentageselect'>
    <?php 
        if (count($markups) > 0) {
            foreach($markups as $p) {
                echo "<option value='{$p->minimummarkup}'> {$p->minimummarkup}% </option>";
            }
        }
    ?>
    <optgroup label='Request'>
        <option value='customper'> Custom Percentage </option>
    </optgroup>
</select>