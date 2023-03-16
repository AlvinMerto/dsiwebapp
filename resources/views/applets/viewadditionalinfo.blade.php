<style>
    .modal-dialog {
        width:100%;
    }
</style>
<div class='dsibox pd-b-10'>
   <button class='btn btn-default btn-sm intablink' data-tab='contacts' data-id="<?php echo $contactid; ?>"> back </button>
</div>
<div class='dsibox'>
    <table class='dsismalltable'>
        <?php
            if (count($data) > 0) {
                foreach($data as $d) {
                    echo "<tr>";
                        echo "<td>{$d->thefield}</td>";
                        echo "<td>
                                <input type='text' 
                                            disabled    ='disabled'
                                            class       ='thetextinput'
                                            data-fld    = 'thevalue'
                                            data-idfld  = 'cffid'
                                            data-id     = '".$d->cffid."'
                                            data-tbl    = 'contactfluidtbls'
                                            data-othid  = '".$contactid."'
                                            data-othfld = '".$d->thefield."'
                                            value       ='".$d->thevalue."'/>
                                        <small class='peritemedit'> edit </small>
                                        &nbsp;
                                        <i class='fa fa-trash removeitem'
                                            data-id='".$d->cffid."'
                                            data-tbl='contactfluidtbls'
                                            data-idfld = 'cffid'
                                         aria-hidden='true'></i>
                            </td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>
</div>