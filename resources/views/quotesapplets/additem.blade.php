<div>
    <p id='industrytype'></p>
</div>
<input type='hidden' value='<?php echo $itemgrpid; ?>' id='itemgrpid'/>

<div class='row addpmarg'>
    <div class='col-md-12'>
        <div class='row'>
            <div class='col-md-12 pd-b-10'>
                <div class='flex'> 
                    <div> 
                        <p> Product Line </p>
                        <select id='productlineselect'>
                            <option> Select </option>
                            <?php 
                                $custom = [];
                                if (count($itemtype) > 0) {
                                    echo "<optgroup label='Product Lines'> ";
                                    foreach($itemtype as $it) {
                                        if ($it->iscustom == 1) {
                                            array_push($custom, [$it->productlineid => $it->theproductline."_".$it->thegrpid]);
                                        } else {
                                            echo "<option value='{$it->productlineid}_0_{$it->thegrpid}'>{$it->theproductline}</option>";
                                        }
                                    }
                                    echo "</optgroup>";

                                    if (count($custom) > 0) {
                                        echo "<optgroup label='Custom Item'>";
                                            foreach($custom as $key => $cs) {
                                                foreach($cs as $k => $kk) {
                                                    $text  = explode("_",$kk)[0];
                                                    $grpid = explode("_",$kk)[1];
                                                    echo "<option value='{$k}_1_{$grpid}'>";
                                                        echo $text;
                                                    echo "</option>";
                                                }
                                            }
                                        echo "</optgroup>";
                                    }
                                } 
                            ?>
                        </select>
                    </div>
                    <div class='mg-l-10'> 
                        <p> &nbsp; </p>
                        <input type='text' class='dsitxtbox hidethis' id='customitemtypetxt' placeholder='Custom Item Type'/>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12 pd-b-10'>
                <p> Description </p>
                <textarea class='dsitxtbox' id='itemdesc' style='min-height:60px;'></textarea>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4 pd-b-10'>
                <p> Unit Cost </p>
                <input type='text' class='dsitxtbox' placeholder='0.00' id='costtxt'/>
            </div>
            <!-- <div class='col-md-4'>
                <p> Markup </p>
                <select id='markupselect'>
                    <option> Markup </option>
                </select>
            </div> -->
            <div class='col-md-8 pd-b-10'>
                <p> Markup </p>
                <div class='flex'>
                    <span id='percentageselspan'> select from the item type... </span>
                    <input type='text' class='dsitxtbox' id='custpertxt' placeholder='0%' style='margin:0px;'/>
                </div>
            </div>
            <!-- <div class='col-md-4 pd-b-10'>
                <p> Total </p>
               <input type='text' class='dsitxtbox'/>
            </div> -->
        </div>
        <div class='row'>
            <div class='col-md-12 pd-b-10 pd-t-10'>
                <div class='row'>
                    <div class='col-md-12'>
                        <label class='btn btn-default utilsbtn'> 
                            <input type='checkbox' id='addshippingbtn'/> Add Shipping &nbsp; <i class="fa fa-plus" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
                <div class='row pd-t-10 pd-b-10 hidethis' id='shippingcosttable' style="background: #e9e9ed;margin-top: -1px; position:relative; z-index:1000;">
                    <div class='col-md-4'>
                        <p> Shipping cost </p>
                        <input type='text' class='dsitxtbox' id='shipcost'/>
                    </div>
                    <div class='col-md-8'>
                        <p> Mark up </p>
                        <input type='dsitxtbox' id='shipmarkup' class='dsitxtbox'/>
                        <!-- <select class='dsitxtbox' id='shipmarkup'>
                            <option value='75.0'> 75.0% </option>
                        </select> -->
                    </div>
                    <!-- <div class='col-md-4'>
                        <p> Value </p>
                        <input type='text' class='dsitxtbox' id='shipvalue'/>
                    </div>    -->
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12 pd-b-10 pd-t-10'>
                <div class='row'>
                    <div class='col-md-12'>
                        <label class='btn btn-default utilsbtn'> 
                            <input type='checkbox' id='addexpirybtn'/> Add Expiry &nbsp; <i class="fa fa-plus" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
                <div class='row pd-t-10 pd-b-10 hidethis' id = 'expirytable' style="background: #e9e9ed;margin-top: -1px; position:relative; z-index:1000;">
                    <div class='col-md-4'>
                        <p> Number </p>
                        <input type='text' class='dsitxtbox' id='expirynumber'/>
                    </div>
                    <div class='col-md-8'>
                        <p> Unit </p>
                        <select class='dsitxtbox' id='expiryunit'>
                            <option value='hour'> Hours </option>
                            <option value='day'> Days </option>
                            <option value='week'> Weeks </option>
                            <option value='month'> Months </option>
                            <option value='year'> Years </option>
                        </select>
                    </div>
                    <div class='col-md-12'>
                        <p> Note </p>
                        <textarea class='dsitxtbox' style='min-height:70px;' id='expirynote'></textarea>
                    </div>   
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12 pd-b-10 pd-t-10'>
                <!-- <p> Sell Price </p>
                <input type='text' class='dsitxtbox' placeholder='0.00' id='sellpricetxt' style="font-size: 19px;padding: 10px;"/> -->
                <div class='flex pd-t-0'> 
                    <Label style='margin:0px 10px 0px 0px;'> <input type='checkbox' name='istax' id='istax'/> Taxable </label>
                    <!-- <Label style='margin:0px;'> <input type='checkbox' name='' id=''/> Add GRT </label> -->
                </div>
            </div>
            <!-- <div class='col-md-4 pd-b-10'>
                <p> Qty </p>
                <input type='text' class='dsitxtbox' placeholder='0' id='qtytxt'/>
            </div> -->
        </div>
        <div class='row'>
            <div class="col-md-6">
                
            </div>
            <!-- <div class='col-md-6'>
                <p> Extended Price </p>
                <p style="font-size: 16px;font-weight: bold;" id='extendedprice'> 0.00 </p>
            </div> -->
        </div>
    </div>
    <div class='col-md-12 pd-t-15' style="border-top: 1px solid #e0d7d7;">
        <div class='row' id='criteriadivdisplay'>
            <div class='col-md-12 removepmarg flex' id='tabgroupdiv'>
                <p class='additemtab' data-tabname='supplierdiv' style='margin:0px;'> Supplier </p>
                <p class='additemtab' data-tabname='manufacturerdiv' style='margin:0px;'> Manufacturer </p>
                <p class='additemtab' data-tabname='otherdetails' style='margin:0px;'> <i class="fa fa-plus" aria-hidden="true"></i> </p>    
            </div>
            <div class='col-md-12 ' id='' style=''>
                <div id = 'manufacturerdiv' class='additemtab_div pd-t-10 pd-b-10 pd-r-15 pd-l-15'>
                    <div class='flex' style="justify-content: space-between;">
                        <p> Manufacturer </p>
                    </div>
                    <div class='row'>
                        <div class='col-md-12 mg-b-10'> <input type='text' class='dsitxtbox' placeholder='Part #' id='mfgpart'/> </div>
                        <div class='col-md-12'> <input type='text' class='dsitxtbox' placeholder='Name' id='mfgname'/> </div>
                    </div>
                </div>
                <div id = 'supplierdiv' class='additemtab_div pd-t-10 pd-b-10 pd-r-15 pd-l-15'>
                    <div class='flex' style="justify-content: space-between;">
                        <p> Supplier </p>
                    </div>
                    <div class='row'>
                        <div class='col-md-12 mg-b-10'> <input type='text' class='dsitxtbox' placeholder='Part #' id='supppart'/> </div>
                        <div class='col-md-12'> <input type='text' class='dsitxtbox' placeholder='Name' id='suppname'/> </div>
                    </div>
                </div>
                <div id = 'otherdetails' class='additemtab_div pd-t-10 pd-b-10 pd-r-15 pd-l-15'>
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
    </div>
</div>

<div class='modal-footer flex'>
    <!-- <button class='dsibutton'> Insert Additional Information </button> -->
    <button class='dsibutton' id='insertcustomitem'> Insert Item </button>
</div>