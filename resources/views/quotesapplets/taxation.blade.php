<div class='pd-l-20 pd-r-20 pd-b-20'>
    <table class='removepmarg fullwidth dsismalltable'>
        <tr>
            <td>
                <p> Status </p>
            </td>
            <td>
                <h6 class='dsitxt' style='margin:0px;'> 
                    <strong> 
                        <?php
                            if (count($tax) > 0) {
                                echo "IN USED";
                            } else {
                                echo "NO TAX";
                            }
                        ?>
                    </strong> 
                </h6>
            </td>
        </tr>
        <tr>
            <td>
                <p> Percentage </p>
            </td>
            <td>
                    <?php
                        if (count($tax) > 0) { ?>
                             <input type="text" 
                                    class="thetextinput" 
                                    data-fld="thetax" 
                                    data-idfld="taxid"
                                    data-id="<?php echo $tax[0]->taxid; ?>"
                                    data-tbl="taxationtbls"
                                    value="<?php echo $tax[0]->thetax; ?>" 
                                    disabled="disabled"
                                    style=''>
                                <small class="peritemedit"> edit </small>
                    <?php  } else { ?>
                        <button class='dsibutton createtax' data-custidfk = '<?php echo $custid; ?>'> Create Tax </button>        
                    <?php  } ?>
                    
            </td>
        </tr>
    </table>
</div>