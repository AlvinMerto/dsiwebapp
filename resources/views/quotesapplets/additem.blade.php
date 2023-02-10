<div>
    <p id='industrytype'></p>
</div>
<input type='hidden' value='<?php echo $itemgrpid; ?>' id='itemgrpid'/>
<div class='dsibox pd-b-10 row removepmarg'>
    <div class='col-md-5 pd-l-30'>
        <div class=''>
            <p> Description </p>
            <textarea class='dsitxtbox' id='itemdesc' style='min-height:190px;'></textarea>
        </div>
    </div>
    <div class='col-md-7 pd-r-30'>
        <div class='row'>
            <div class='col-md-5'>
                <div class='pd-b-10'>
                    <p> Cost </p>
                    <input type='text' class='dsitxtbox' placeholder='0.00' id='costtxt'/>
                </div>
            </div>
            <div class='col-md-7'>
                <p> Markup </p>
                <select id='markupselect'>
                    <option> Markup </option>
                </select>
            </div>
        </div>
        <div class='row pd-b-10'>
            <div class='col-md-5'>
                <p> Value </p>
                <select class='dsitxtbox' id='percentageselect'>
                    <?php 
                     if (count($percentage) > 0) {
                        foreach($percentage as $p) {
                            echo "<option value='{$p->thevalue}'> {$p->thevalue}% </option>";
                        }
                     }
                    ?>
                        <optgroup label='Request'>
                            <option value='customper'> Custom Percentage </option>
                        </optgroup>
                </select>
            </div>
            <div class='col-md-7'>
               <p> &nbsp; </p>
               <input type='text' class='dsitxtbox' id='custpertxt' placeholder='0%' style='margin:0px;'/>
            </div>
        </div> 
            
        
        <div class='row'>
            <div class='col-md-4'>
                <p> Sell Price </p>
                <input type='text' class='dsitxtbox' placeholder='0.00' id='sellpricetxt'/>
            </div>
            <div class='col-md-4'>
                <p> Qty </p>
                <input type='text' class='dsitxtbox' placeholder='0' id='qtytxt'/>
            </div>
            <div class='col-md-4'>
                <p> Extended Price </p>
                <p style="font-size: 16px;font-weight: bold;" id='extendedprice'> 0.00 </p>
            </div>
        </div>
        <div class='row'>
            <div class="pd-b-0 pd-t-0 pd-r-15 pd-l-15">
                <Label style='margin:0px;'> <input type='checkbox' name='istax' id='istax'/> Taxable </label>
            </div>
        </div>
    </div>

</div>

<div class='row removepmarg pd-t-10'>
    <div class='col-md-12' id='criteriadivdisplay'>
        <div class='flex dsibox' id='tabgroupdiv'>
            <p class='additemtab' data-tabname='supplierdiv'> Supplier </p>
            <p class='additemtab' data-tabname='manufacturerdiv'> Manufacturer </p>
            <p class='additemtab' data-tabname='otherdetails'> <i class="fa fa-plus" aria-hidden="true"></i> </p>    
        </div>
        <div id = 'manufacturerdiv' class='additemtab_div pd-t-10 pd-b-10 pd-b-10 pd-r-15 pd-l-15'>
            <div class='flex' style="justify-content: space-between;">
                <p> Manufacturer </p>
            </div>
            <div class='row'>
                <div class='col-md-6'> <input type='text' class='dsitxtbox' placeholder='Part #' id='mfgpart'/> </div>
                <div class='col-md-6'> <input type='text' class='dsitxtbox' placeholder='Name' id='mfgname'/> </div>
            </div>
        </div>
        <div id = 'supplierdiv' class='additemtab_div pd-t-10 pd-b-10 pd-b-10 pd-r-15 pd-l-15'>
            <div class='flex' style="justify-content: space-between;">
                <p> Supplier </p>
            </div>
            <div class='row'>
                <div class='col-md-6'> <input type='text' class='dsitxtbox' placeholder='Part #' id='supppart'/> </div>
                <div class='col-md-6'> <input type='text' class='dsitxtbox' placeholder='Name' id='suppname'/> </div>
            </div>
        </div>
        <div id = 'otherdetails' class='additemtab_div pd-t-10 pd-b-10 pd-b-10 pd-r-15 pd-l-15'>
            <div class='flex' style="justify-content: space-between;">
                <p> Other Information </p>
            </div>
            <div class='row'>
                <div class='col-md-12 mg-b-5'> <input type='text' class='dsitxtbox' placeholder='Criteria' id='info_criteriaid'/> </div>
                <div class='col-md-12 mg-b-5'> <input type='text' class='dsitxtbox' placeholder='Reference' id='info_referenceid'/> </div>
                <div class='col-md-12 mg-b-5'> <input type='text' class='dsitxtbox' placeholder='Value' id='info_thevalue'/> </div>
                <div class='col-md-12 mg-b-5 flex' style='justify-content:space-between;'> 
                    <button class='btn btn-default' id='savenewreference'> Save Reference </button> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class='modal-footer flex'>
    <!-- <button class='dsibutton'> Insert Additional Information </button> -->
    <button class='dsibutton' id='insertcustomitem'> Insert Item </button>
</div>