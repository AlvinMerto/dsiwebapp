<div>
    <table class='dsismalltable thleft'>
        <tr>
            <th> Item Code </th>
            <td>
            <input type="text" 
                   class="thetextinput" 
                   data-fld="itemcode" 
                   data-idfld="itemid"
                   data-id="<?php echo $details[0]->itemid; ?>" 
                   data-tbl="itemstbls"
                   value="<?php echo $details[0]->itemcode; ?>" 
                   disabled="disabled"
                   style=''>
                <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Description </th>
            <td>
            <input type="text" 
                   class="thetextinput" 
                   data-fld="description" 
                   data-idfld="itemid"
                   data-id="<?php echo $details[0]->itemid; ?>" 
                   data-tbl="itemstbls"
                   value="<?php echo $details[0]->description; ?>" 
                   disabled="disabled"
                   style=''>
                <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Item Name </th>
            <td>
            <input type="text" 
                   class="thetextinput" 
                   data-fld="itemname" 
                   data-idfld="itemid"
                   data-id="<?php echo $details[0]->itemid; ?>" 
                   data-tbl="itemstbls"
                   value="<?php echo $details[0]->itemname; ?>" 
                   disabled="disabled"
                   style=''>
                <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Item price </th>
            <td>
            <input type="text" 
                   class="thetextinput" 
                   data-fld="itemprice" 
                   data-idfld="itemid"
                   data-id="<?php echo $details[0]->itemid; ?>" 
                   data-tbl="itemstbls"
                   value="<?php echo $details[0]->itemprice; ?>" 
                   disabled="disabled"
                   style=''>
                <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Mark up </th>
            <td>
                <input type="text" 
                    class="thetextinput" 
                    data-fld="markup" 
                    data-idfld="itemid"
                    data-id="<?php echo $details[0]->itemid; ?>" 
                    data-tbl="itemstbls"
                    value="<?php echo $details[0]->markup; ?>" 
                    disabled="disabled"
                    style=''>
                    <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Sell Price </th>
            <td>
                <input type="text" 
                    class="thetextinput" 
                    data-fld="sellprice" 
                    data-idfld="itemid"
                    data-id="<?php echo $details[0]->itemid; ?>" 
                    data-tbl="itemstbls"
                    value="<?php echo $details[0]->sellprice; ?>" 
                    disabled="disabled"
                    style=''>
                    <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Supplier ID </th>
            <td>
                <input type="text" 
                    class="thetextinput" 
                    data-fld="supplierid" 
                    data-idfld="itemid"
                    data-id="<?php echo $details[0]->itemid; ?>" 
                    data-tbl="itemstbls"
                    value="<?php echo $details[0]->supplierid; ?>" 
                    disabled="disabled"
                    style=''>
                    <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Supplier Name </th>
            <td>
                <input type="text" 
                    class="thetextinput" 
                    data-fld="suppliername" 
                    data-idfld="itemid"
                    data-id="<?php echo $details[0]->itemid; ?>" 
                    data-tbl="itemstbls"
                    value="<?php echo $details[0]->suppliername; ?>" 
                    disabled="disabled"
                    style=''>
                    <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Manufacturer ID </th>
            <td>
                <input type="text" 
                    class="thetextinput" 
                    data-fld="mfgid" 
                    data-idfld="itemid"
                    data-id="<?php echo $details[0]->itemid; ?>" 
                    data-tbl="itemstbls"
                    value="<?php echo $details[0]->mfgid; ?>" 
                    disabled="disabled"
                    style=''>
                    <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> Manufacturer Name </th>
            <td>
                <input type="text" 
                    class="thetextinput" 
                    data-fld="mfgname" 
                    data-idfld="itemid"
                    data-id="<?php echo $details[0]->itemid; ?>" 
                    data-tbl="itemstbls"
                    value="<?php echo $details[0]->mfgname; ?>" 
                    disabled="disabled"
                    style=''>
                    <small class="peritemedit"> edit </small>
            </td>
        </tr>
        <tr>
            <th> is Taxable </th>
            <td>
                <?php if ($details[0]->istaxable == "1") { ?>
                    <input type='checkbox' 
                        class='checkboxchange'
                        data-fld="istaxable" 
                        data-idfld="itemid"
                        data-id="<?php echo $details[0]->itemid; ?>" 
                        data-tbl="itemstbls" checked/>
                <?php } else { ?>
                    <input type='checkbox' 
                       class='checkboxchange'
                       data-fld="istaxable" 
                       data-idfld="itemid"
                       data-id="<?php echo $details[0]->itemid; ?>" 
                       data-tbl="itemstbls"/>
                <?php } ?>
            </td>
        </tr>
    </table>
</div>