<div class='dsibox pd-b-10'>
   <button class='btn btn-default btn-sm intablink' data-tab='contacts' data-id="<?php echo $contactid; ?>"> back </button>
</div>
<div class='dsibox'>
    <table class='dsismalltable'>
        <tr>
            <th colspan=2>
                Add Additional Information
            </th>
        </tr>
        <tr>
            <td> Reference Name </td>
            <td> 
                <input type='text' class='dsitxtbox' list='refnames' id='referencename' /> 
                <?php
                    if (count($fields)>0) {
                        echo "<datalist id='refnames'>";
                            foreach($fields as $f) {
                                echo "<option>{$f->thefield}</option>";
                            }
                        echo "</datalist>";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td> Value </td>
            <td> <input type='text' class='dsitxtbox' id='referencevalue'/> </td>
        </tr>
        <tr>
            <td> &nbsp; </td>
            <td> <button class='dsibutton' id='saveaddoninfo' data-contid="<?php echo $contactid; ?>"> Save </button> </td>
        </tr>
    </table>
</div>