<x-app-layout>
@section("title","Product Lines")
<div class="br-mainpanel pd-30">
    <div class='bgwhite'>
        <div class='row'>
            <div class='col-md-4'>
                <div class='pd-20' style='background:#fff;'>
                    <div class='dsibox pd-b-20'> 
                        <p> Product Lines </p> 
                        <select class='pd-20' id='productlinechange'>
                            <option <?php if ($grpcode == false) { echo "selected"; } ?>> Select </option>
                            <?php
                                if (count($data) > 0) {
                                    foreach($data as $d) {
                                        $selected = null;

                                        if ($grpcode != false) {
                                            if ($markups[0]->thegrpid == $d->thegrpid) {
                                                $selected = "selected";
                                            }
                                        }

                                        echo "<option value='{$d->thegrpid}' {$selected}>";
                                            echo $d->theproductline;
                                        echo "</option>";
                                    }
                                }
                            ?>
                        </select>
                        <?php if ( $grpcode != false ) { ?>
                            <a href="{{ route('productline') }}" style='float: right; padding-top: 16px; color: #898686;'> Reset </a>
                            <button class='btn btn-danger btn-sm mg-t-10' id='deleteproductline' data-grpid='<?php echo $grpcode; ?>'> Delete Product Line </button>
                        <?php } ?>
                    </div>
                    <?php if ($grpcode == false) { ?>
                        <div class='dsibox mg-t-20 pd-b-20'>
                                <p class='mg-b-5'> Add New Product Line</p>
                                <input type='hidden' value='<?php echo $newgrpid; ?>' id='newgrpid'/>
                                <input type='text' class='dsitxtbox' style='padding:15px 10px;' id='productlinename' placeholder='Product line'/>
                                <br/>
                                <input type='text' class='dsitxtbox mg-t-5' id='initialmarkup' style='padding-left:10px;' placeholder='Mark up'/>
                                <label class='mg-t-10'> 
                                    <input type='checkbox' name='isdefault' id='iscustomval'/> ask for custom name?
                                </label>
                                <label class='mg-t-10'> 
                                    <input type='checkbox' name='isproductline' id='isproductline'/> Check to include as new productline. Uncheck if markup threshold.
                                </label>
                                <br/>
                                <input type='button' value='Add' class='dsibutton mg-t-10' id='addnewproductline'/>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class='col-md-8'>
                <?php if ( $grpcode != false ) { ?>
                    <!-- start of adding new mark up -->
                        <div class='pd-t-20 pd-r-20 dsibox'>
                            <div class='flex spacebetween'> 
                                <div>
                                    <p> <?php echo $markups[0]->theproductline; ?> </p>
                                <!-- </div>
                                <div> -->
                                    <label> 
                                        <?php if ($markups[0]->iscustom == 1) { ?>
                                            <?php $checked = "checked"; ?>
                                        <?php } else if ($markups[0]->iscustom == 0) {
                                            $checked = null;
                                            } ?>
                                        <input type='checkbox' data-grpid='<?php echo $markups[0]->thegrpid; ?>' id='askcustomnameid' <?php echo $checked; ?>/> Ask for custom name?
                                    </label>
                                        <br/>
                                    <label>
                                    <?php if ($markups[0]->status == 1) { ?>
                                            <?php $checked = "checked"; ?>
                                        <?php } else if ($markups[0]->iscustom == 0) {
                                            $checked = null;
                                            } ?>
                                        <input type='checkbox' data-grpid='<?php echo $markups[0]->thegrpid; ?>' id='asproductline' <?php echo $checked; ?>/> Check to add as productline. Uncheck to set as markup.
                                    </label>

                                </div>
                            </div>
                        </div>
                        
                        <div class='pd-20 dsibox'>
                            <form method='post' enctype="multipart/form-data"> 
                                @csrf
                                <div class='flex'>        
                                    <p class='mg-b-0 mg-t-5'> Add&nbsp;New&nbsp;mark&nbsp;up </p> &nbsp;
                                    <input type='hidden' value='<?php echo $markups[0]->theproductline; ?>' name='productlinename'/>
                                    <input type='hidden' value='<?php echo $markups[0]->iscustom; ?>' name='iscustom'/>
                                    <input type='text' class='pd-0 dsitxtbox' name='markupvalue'/> &nbsp;
                                    <input type='submit' value='Add New' class='dsibutton' name='newmarkupbtn'/>
                                </div>
                            </form>
                        </div>
                        
                        <div class='pd-t-20'>
                            <p> Mark Ups </p>
                            <ul class='markuplist'>
                                <?php
                                    if (count($markups) > 0) {
                                        foreach($markups as $m) {
                                            echo "<li> {$m->minimummarkup}% &nbsp; 
                                                    <small id='deletebtn' 
                                                           data-id='{$m->productlineid}'
                                                           style='color:red; cursor:pointer;'> Delete </small> </li>";
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                    <!-- end -->
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</x-app-layout>