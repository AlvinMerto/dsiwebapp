<x-app-layout>
    <?php $compname = $data[0]->companyname." Quotation"; ?>
    @section("title",$compname)


    <?php if ($overallqtdets[0]->status == 6 || $overallqtdets[0]->status == 7 || $overallqtdets[0]->status == 0) { ?>
    <div class="alert alert-danger" style="z-index: 100000000000000000;position: fixed;bottom: 0;width: 100%;text-align: center;box-shadow: 0px 3px 9px #a2a2a2;margin-bottom: 0px;">
       <?php 
            Switch($overallqtdets[0]->status) {
                case "0": echo "Subject for Approval"; break;
                case "6": echo "Cancelled"; break;
                case "7": echo "Expired"; break;
            }
       ?>
    </div>
    <?php } ?>
    <?php if ($showapprovebtn != null) { ?>
        <div class='showapprovediv'>
            <a class='dsibutton' href='<?php echo $showapprovebtn ?>'> APPROVE </a> &nbsp;
            <button class='dsibutton' data-toggle='modal' data-target='#sendbackwindow' > Send Back </button>
        </div>
    <?php } ?>

    <?php if ( is_array($allowdetails)) { ?>
        <div class='showpermissionwindow pd-t-20'>
            <div class='pd-t-20 pd-b-20 permissionfirstborn'>
                <p> <strong> <?php echo $allowdetails['req']; ?> is asking permission to edit this quotation. </strong> </p>
                    <div>
                        <?php
                            foreach($thecells as $tc) {
                                echo $tc->cellid."<br/>";
                            }
                        ?>
                    </div>
                <a href="<?php echo $allowdetails['approvelink']; ?>" class='dsibutton' target='_blank'> Give Permission </a>
            </div>
        </div>
    <?php } ?>
   <div class="br-mainpanel pd-15">
        <div class=''>
                <div class='row mg-b-10'>
                    <div class='dsibox mg-b-20 pd-r-30 pd-t-15' id='totaldiv' style=''> 
                        <p style='text-align:center;'> Computing... </p>
                    </div>
                    <div class='col-md-12 pd-r-0'>
                        <div class='flex'>
                            <div class='col-md-6 pd-0 flex bgwhite' style="border-radius: 99px 0px 0px 99px;"> 
                                <div class='companyprof'>
                                    <p> <?php echo strtoupper($ints); ?> </p>
                                </div>
                                <div class='pd-t-20 pd-r-15 pd-l-15 mg-r-10' style='border-right:3px solid #f3f4f6;'>
                                    <h3 style="font-size: 21px;"> Quotation </h3>
                                </div>
                                <div class='pd-t-10 mg-r-20'>
                                    <h5 style="font-size: 17px;"> Company </h5>
                                    <p class='mg-0 dsitxt'> <i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 12px;"></i> 
                                        <span> 
                                            <?php 
                                                if ($data != null) {
                                                    if (strlen($data[0]->companyname)==0) {
                                                        echo "N/A";
                                                    } else {
                                                        echo $data[0]->companyname;
                                                    }
                                                }
                                            ?>    
                                        </span> 
                                    </p>
                                </div>
                                <div class='pd-t-10 mg-r-20'>
                                    <h5 style="font-size: 17px;"> Contact  </h5>
                                    <p class='mg-0 dsitxt'> 
                                        <i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 12px;"></i> 
                                        <?php 
                                            if (count($contacts) > 0) {
                                                foreach($contacts as $cn) {
                                                    if ($overallqtdets[0]->quotationsentto == $cn->contid) {
                                                        echo $cn->contactname;
                                                    }
                                                }
                                            }
                                        ?>
                                    </p>
                                </div>
                            <!-- </div>
                            <div class='col-md-6 pd-0 flex bgwhite pd-r-30' style="justify-content: right;"> -->
                                <div class='pd-t-10 mg-r-20'>
                                    <h5 style="font-size: 17px;"> Status </h5>
                                    <p class='mg-0 dsitxt'> <i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 12px;"></i> Quotation </p>
                                </div>
                                <div class='pd-t-10 mg-r-20'>
                                    <h5 style="font-size: 17px;"> Date Created </h5>
                                    <p class='mg-0 dsitxt'> <i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 12px;"></i> June 2, 2023 </p>
                                </div>
                                <div class='pd-t-10'>
                                    <h5 style="font-size: 17px;"> Valid Until </h5>
                                    <p class='mg-0 dsitxt'> <i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 12px;"></i> June 3, 2023 </p>
                                </div>
                            </div>
                            <div class='col-md-6 pd-0 flex bgwhite pd-r-30' style="justify-content: right;"> 
                                <?php if (!$allowed) { ?>
                                    <div class="pd-t-15">
                                        <button class='dsibutton' data-toggle='modal' data-target='#askpermission'> Ask Permission to edit </button>
                                    </div>
                                <?php } ?>

                                <?php if ($showapprovebtn == null) { ?>
                                    <?php if ($allowed) { ?>
                                        <div id ='checkformarkups'  class='pd-t-15'> 
                                            checking...
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-12 pd-l-5' id='motherdiv' style='min-height:700px; '>
                    <div class='pd-t-0 pd-b-0 '>
                        <div class='dsibox flex pd-l-0' style="border-bottom: none; border-right: 1px solid #dfdfdf; border-left: 1px solid #dfdfdf;border-radius: 10px 10px 0px 0px;background: #fff;border-top: 1px solid #dfdfdf;">
                        <input type='hidden' value='<?php echo $quoteid; ?>' id='quoteidfk'/>

                        <?php if (count($empdata) > 0) { ?>
                            <input type='hidden' value='<?php echo $empdata[0]->grttypeid; ?>' id='interid'/>
                            <input type='hidden' value='<?php echo $empdata[0]->grtvalue; ?>' id='intervalue'/>
                        <?php } else { ?>
                            <div class='setdivforinterest'>
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <center> 
                                            <!-- <div style="width: 50%;margin-top: 150px; background: #fff; border-radius: 10px;" class='pd-20'> -->
                                            <div class='col-md-6 mg-t-20 pd-50 bgwhite' style='border-radius: 5px;'>
                                                <h2 style="font-size: 19px;color: #000;text-align: left;"> GRT Computation </h2>
                                                <div class='row pd-20'>
                                                    <div class='col-md-12'>
                                                        <button class='pd-20 setcomputation' data-value = '2' data-text = 'Compute GRT' data-custid='<?php echo $id; ?>' style="font-size: 19px; width:100%;"> Compute for GRT </button>
                                                    </div>
                                                    <div class='col-md-12 mg-t-5'>
                                                        <button class='pd-20 setcomputation' data-value = '1' data-text = 'No GRT' data-custid='<?php echo $id; ?>' style="font-size: 19px; width:100%;"> Do not compute GRT </button>
                                                    </div>
                                                </div>
                                                <!-- <p style='font-size: 16px;'> Set the computation for GRT </p>    
                                                <select class='dsitxtbox pd-20' id='grtselect'>
                                                    <option value='1'> No GRT </option>
                                                    <option value='2'> Compute GRT </option>
                                                </select>
                                                <button class='dsibutton mg-t-10' id='setcomputation' data-custid='<?php //echo $id; ?>'> Set this computation </button> -->
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- <iframe name='iframe_a' id='iframe_a'> </iframe> -->
                        <div class='flex' style="justify-content: space-between;width: 100%; ">
                                <ul class='flex smallnavsbtn'>
                                    <!-- <li style="background: #37a000;color: #fff; border-radius: 10px 0px 0px 0px;" data-toggle='modal' data-target='#companyprofile'> <i class="fa fa-id-card-o" aria-hidden="true"></i> &nbsp; Profile </li> -->
                                    <li> File 
                                        <ul>
                                            <?php if ($allowed) { ?>
                                                <li data-toggle='modal' data-target='#savequote'> <i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; Save </li>
                                            <?php } ?>

                                            <?php if ($overallqtdets[0]->quotationsentto == null) { ?>
                                                <li> <i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Preview: <i style='color:red;'> Please save this quotation first </i> </li>
                                            <?php } else { ?>
                                                <a href='<?php echo url('')."/quotation/".$quoteid."/0/true"; ?>' target='_blank'> <li> <i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Preview</li> </a>
                                            <?php } ?>
                                            
                                            <?php if ($allowed) { ?>
                                                <li data-toggle='modal' data-target='#sendquotation'> 
                                                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i> &nbsp; Send 
                                                </li>
                                            <?php } ?>

                                            <!-- <li data-toggle='modal' data-target='#savetonewcustomer'> <i class="fa fa-terminal" aria-hidden="true"></i> &nbsp;Save to new customer </li> -->
                                            
                                            <?php if ($allowed) { ?>
                                                <li id='resetexp' style='cursor:pointer;' data-toggle='modal' data-target='#resetexpiry'> <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp; Reset Quotation Status</li>
                                                <li> <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download as PDF </li>
                                            <?php } ?>

                                            <?php if ($allowed) { ?>
                                                <li data-toggle='modal' data-target='#viewingoptions' class='viewingoptions'> <i class="fa fa-cog" aria-hidden="true"></i> &nbsp; Viewing Options </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    
                                    <?php if ($allowed) { ?>
                                    <li> Edit 
                                        <ul>
                                            
                                            <li id='removebtn'> <i class="fa fa-close" aria-hidden="true"></i> &nbsp;Remove </li>
                                            <li id='duplicateentry'> <i class="fa fa-clone" aria-hidden="true"></i> &nbsp;Duplicate </li>
                                        </ul>
                                    </li>
                                    <?php } ?>

                                    <li> View 
                                        <ul>
                                            <?php if ($allowed) { ?>
                                                <li id='itemdetails' data-toggle='modal' data-target='#viewitemdetails'> Item details </li>
                                            <?php } ?>
                                            <?php if ($showapprovebtn != null) { ?>
                                                <li data-toggle='modal' data-target='#addcomment' class='callwindowwithid' data-window='loadingcomments' data-insertospan='loadingcommentsspan'> <i class="fa fa-angle-right" aria-hidden="true"></i> Comment </li>
                                            <?php } ?>

                                            <li id='userswithaccess' data-toggle='modal' data-target='#viewerswithaccess'> View Users with access </li>
                                        </ul>
                                    </li>
                                    <?php if ($allowed) { ?>
                                        <li> Insert
                                            <ul>
                                                <li data-toggle='modal' data-target='#insertitem' class='callitemssource' data-window='additem' data-backdrop="static" data-keyboard="false"> <i class="fa fa-angle-right" aria-hidden="true"></i> Add Custom Item </li>
                                                <li data-toggle='modal' data-target='#insertitem' class='callitemssource' data-window='taxable'> <i class="fa fa-angle-right" aria-hidden="true"></i> Insert item from a product line </li> 
                                                <li data-toggle='modal' data-target='#subtotaldiv'> <i class="fa fa-angle-right" aria-hidden="true"></i> Subtotal </li>
                                                <li data-toggle='modal' data-target='#insertotheritem' class='callwindow' data-window='insertotheritems' data-insertospan='insertotheritemspan'> <i class="fa fa-angle-right" aria-hidden="true"></i> Labor </li>
                                                <li data-toggle='modal' data-target='#insertotheritem' class='callwindow' data-window='insertotheritems' data-insertospan='insertotheritemspan'> <i class="fa fa-angle-right" aria-hidden="true"></i> Freight </li>
                                                <!-- <li> <i class="fa fa-angle-right" aria-hidden="true"></i> Line </li>
                                                <li> <i class="fa fa-angle-right" aria-hidden="true"></i> Blank Row </li> -->
                                                <li data-toggle='modal' data-target='#addcomment' class='callwindowwithid' data-window='loadingcomments' data-insertospan='loadingcommentsspan'> <i class="fa fa-angle-right" aria-hidden="true"></i> Comment </li>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                    <?php if ($allowed) { ?>
                                        <li> Convert 
                                            <ul>
                                                <li> <i class="fa fa-angle-right" aria-hidden="true"></i> To order </li>
                                                <li> <i class="fa fa-angle-right" aria-hidden="true"></i> To invoice </li>
                                                <li> <i class="fa fa-angle-right" aria-hidden="true"></i> To sales </li>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>

                               
                                
                        </div>
                            
                    </div>
                </div>
            
                <div class=' pd-l-0'>
                    <!--<h6 class="pageh pd-l-10 pd-t-10 pd-b-10" style="border-right: 1px solid #eaeaea;border-bottom: 1px solid #eaeaea;"> Quotation for <a href='#' data-toggle='modal' data-target='#basicinfodiv' class='thecompname'> <?php // echo $data[0]->companyname; ?> </a>  </h6>--> 
                        <?php if (!$allowed) { $idcontext = null; } else { $idcontext = "contextmenu"; } ?>
                        <div class='dsibox minheightdiv bgdiv' id='<?php echo $idcontext; ?>'>
                            <table class='quotestable' id='quoteshit'>  
                                <!-- table-striped -->
                                <thead>
                                    <tr style="border-right: 1px solid #eaeaea;">
                                        <th> &nbsp; </th>
                                        <th> &nbsp; </th>
                                        <th> # </th>
                                        <th> Profit </th>
                                        <th> Cost </th>
                                        <th> Cost: Markup  </th>
                                        <th> Supplier </th>
                                        <th> Supplier # </th>
                                        <th> Mfg </th>
                                        <th> Mfg # </th>
                                        <th> Product Line </th>
                                        <th style='width:300px;'> Description </th>
                                        <th> Ship: Cost </th>
                                        <th> Ship: Markup </th>
                                        <th> Ship: Price </th>
                                        <th> Qty </th>
                                        <th> Price </th>
                                        <th> Extended </th>
                                        <th> Tax </th>
                                        <th style='width:200px;'> Status </th>
                                    </tr>
                                </thead>
                                <tbody id='tbodyrow'>
                                <tr> <td colspan="20"> loading... </td> </tr>
                                </tbody>
                            </table>
                            <center style="margin-top:10px;" class='pd-t-10 pd-b-10'>
                                <?php if ($allowed) { ?>
                                <button class='btn btn-default callitemssource' 
                                        style="color:#a49f9f;margin-top: 10px;" 
                                        data-toggle='modal' 
                                        data-target='#insertitem' data-window='additem'> <i class="fa fa-plus" aria-hidden="true"></i> add item </button>
                                <?php } else { ?>
                                    <button class='dsibutton' data-toggle='modal' data-target='#askpermission'> Ask Permission to edit </button>
                                <?php } ?>
                            </center>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
    </div>
    <div style='height: 85px; width:100%; background:#000;'></div>
</x-app-layout>

        <div id="addcomment" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Comment</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-t-10 pd-l-20 pd-r-20">
                    <span id='loadingcommentsspan'> loading comments ...</span>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->

        <?php if ($allowed) { ?>
            <div id="editsubsqty" class="modal fade">
                <div class="modal-dialog modal-dialog-vertical-center" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Subtotal Details </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body pd-t-10 pd-l-20 pd-r-20">
                        <span id='loadsubtotalspan'>  </span>
                    </div>
                </div>
                </div><!-- modal-dialog -->
            </div><!-- modal -->
        <?php } ?>

<?php if (!$allowed) { ?>
        <div id="askpermission" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Ask Permission</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                    <p> Check the field(s) that you ask permission to edit </p>
                    <label> <input type='checkbox' value='all' id='selectallflds'/> ALL </label>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label> <input type='checkbox' value='1' class='fieldsselect'/> Cost </label><br/>
                            <label> <input type='checkbox' value='2' class='fieldsselect'/> Cost Markup </label><br/>
                            <label> <input type='checkbox' value='3' class='fieldsselect'/> Supplier </label><br/>
                            <label> <input type='checkbox' value='4' class='fieldsselect'/> Supplier Number </label>
                        </div>
                        <div class='col-md-4'>
                            <label> <input type='checkbox' value='5' class='fieldsselect'/> Mfg </label><br/>
                            <label> <input type='checkbox' value='6' class='fieldsselect'/> Mfg Number </label><br/>
                            <label> <input type='checkbox' value='7' class='fieldsselect'/> Product Line </label><br/>
                            <label> <input type='checkbox' value='8' class='fieldsselect'/> Description </label>
                        </div>
                        <div class='col-md-4'>
                            <label> <input type='checkbox' value='9' class='fieldsselect'/> Ship: Cost </label><br/>
                            <label> <input type='checkbox' value='10' class='fieldsselect'/> Ship: Markup </label><br/>
                            <label> <input type='checkbox' value='11' class='fieldsselect'/> Ship: Price </label> <br/>
                            <label> <input type='checkbox' value='12' class='fieldsselect'/> Qty </label>
                        </div>
                    </div>
                    <div>
                        <p class='mg-b-5'> Reason </p>
                        <textarea id='reasontxt' class='dsitxtbox' style='height:200px;resize:none;'></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                  <span id='sendingemailstatus'>  </span>
                  <button type="button" 
                          class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" 
                          id='askpermissionbtn'
                          data-owner='<?php echo $overallqtdets[0]->inputby; ?>'
                          data-reqs ='<?php echo Auth::id(); ?>'>Ask Permission</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->
<?php } ?>

<?php if ($allowed) { ?>
        <div id="insertotheritem" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"> Insert </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-10">
                    <span id='insertotheritemspan'> </span>
                </div>
                <div class="modal-footer">
                  <span id='sendingemailstatus'>  </span>
                  <button type="button" 
                          class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" 
                          id='savethisotheritem'>Insert item</button>
                </div>
              </div>
            </div>
        </div>
<?php } ?>

    <!-- viewerswithaccess -->
        <div id="viewerswithaccess" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">List of Users with access</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-10">
                    <?php if ($haveaccess != false) { ?>    
                        <ul class='usersaccessul'>
                        <?php
                            foreach($haveaccess as $h) {
                                echo "<li>";
                                    echo "<p class='mg-0'> ".$h->name. "</p>";
                                    if ($isowner) {
                                        echo "<small data-auid='{$h->auid}' class='removespan'> remove </small>";
                                    }
                                echo "</li>";
                            }    
                        ?>
                        </ul>
                    <?php } else { ?>
                        <p> No users have access to this quotation. </p>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                  <!-- <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savenewrecord'>Remove</button> -->
                </div>
              </div>
            </div>
        </div>


        <div id="basicinfodiv" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Profile</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='pd-l-20 pd-b-20 pd-r-20 dsibox'>
                        <table class='dsismalltable'>
                            <tbody>
                                <tr>
                                    <th colspan=2> Basic Information </th>
                                </tr>
                                <tr>
                                    <td>Company:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->companyname)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->companyname;
                                                }
                                            }
                                        ?>    
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact Person:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->contactperson)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->contactperson;
                                                }
                                            }
                                        ?>   
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact Number:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->contactnumber)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->contactnumber;
                                                }
                                            }
                                        ?>   
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email Address:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->email)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->email;
                                                }
                                            }
                                        ?>   
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dept:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->dept)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->dept;
                                                }    
                                            }
                                        ?> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class='flex pd-l-20 pd-t-20 pd-b-20 pd-r-20' style='justify-content:center;text-align:center;'>
                        <a class='dsibutton fullwidth' target='_blank' href="<?php echo route('customer')."/".$data[0]->id; ?>"> Go to Profile </a>
                    </div>
                </div>
              </div>
            </div>
        </div>

        <div id="savetonewcustomer" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" >Save to new Customer</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='pd-b-20 dsibox'>
                        <div class="table-wrapper applettable">
                            <table id="datatable1" class="table display responsive nowrap">
                                <thead>
                                    <th> &nbsp; </th>
                                    <th> Company Name </th>
                                    <th> Contact Name </th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (count($allcust) > 0) {
                                            $count = 1;
                                            foreach($allcust as $ac) {
                                                echo "<tr>";
                                                    echo "<th> <input type='radio' name='custrad'/> </th>";
                                                    echo "<td class='compname'> <a href='".route("customer")."/".$ac->id."' target='_blank'>".$ac->companyname."</td>";
                                                    echo "<td>".$ac->dept."</td>";
                                                echo "</tr>";
                                                $count++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class='pd-l-20 pd-t-10 pd-b-20 pd-r-20'>
                        <button class='dsibutton fullwidth' id='saveasnewtonewcust' data-custidfrom="<?php echo $data[0]->id; ?>"> Save to this Customer </button>
                    </div>
                </div>
              </div>
            </div>
        </div>

        <div id="insertitem" class="modal fade maxwidth" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Insert Item<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-t-0 pd-b-0" style='background:#fff;'>
                    <div class='dsibox pd-b-10' id='categoryselect'>
                        <table class='fullwidth'>
                            <tbody>
                                <tr> 
                                    <td> Category </td>
                                    <td>
                                        <select id='categorylist'>
                                            <optgroup label='Item Categories'>
                                                <?php
                                                    foreach($categories as $ccc) {
                                                        echo "<option>{$ccc->category}</option>";
                                                    }
                                                ?>
                                            </optgroup>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=''>
                        <span id='additemsshow'></span>
                    </div>
                </div>

              </div>
            </div>
        </div>
        
        <div id="markupvaluemodal" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Markup Item<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='dsibox'>
                        <select>
                            <?php 
                                if (count($percentage) > 0) {
                                    foreach($percentage as $p) {
                                        echo "<option value='{$p->thevalue}'> {$p->thevalue}% </option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class='pd-t-10 pd-b-10'>
                        <button class='dsibutton' id='updatemarkup'> Update </button>
                    </div>
                </div>

              </div>
            </div>
        </div>

        <div id="sendbackwindow" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center fullwidth" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Send Back<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='dsibox mg-b-10'>
                        <input type='text' class='dsitxtbox' placeholder='Subject' id='sendbacksubject'/>
                    </div>
                    <div class='dsibox'>
                        <textarea class='dsitxtbox' style='min-height:200px;' placeholder='Your Message' id='sendbackmessage'></textarea>
                    </div>
                    <div class='pd-t-10 pd-b-10'>
                        <button class='dsibutton' id='sendbackbtn' data-owner='<?php echo $quotedets[0]->inputby; ?>'> Send Back </button>
                        <span id='msgstat'> </span>
                    </div>
                </div>

              </div>
            </div>
        </div>
    
    <?php if ($allowed) { ?>
        <div id="viewingoptions" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14" style="width: fit-content;">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Viewing Options</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                        <div class='row'>
                            <div class='col-md-6'>
                                <?php 
                                    if (count($viewopts) > 0) {                    
                                        foreach($viewopts as $vs) {
                                            ${$vs->viewoptionfld}          = $vs->viewoptionfld;
                                            ${$vs->viewoptionfld."_id"}    = $vs->vopid;
                                        }
                                    }
                                ?>
                                <ul class='sendoptions mg-b-0'>
                                    <li> <label> 
                                            <input type='checkbox' class='sendoptionchck' value='suppname' data-datatxt="Supplier Name" data-vtype='fld' <?php if (isset($suppname_id)) { echo "data-tblid='{$suppname_id}'"; } ?> <?php if (isset($suppname)) { echo "checked"; } ?>/> Supplier Name 
                                        </label> 
                                    </li>
                                    <li> <label> <input type='checkbox' class='sendoptionchck' value='supppart' data-datatxt="Supplier Part #"  data-vtype='fld' <?php if (isset($supppart_id)) { echo "data-tblid='{$supppart_id}'"; } ?> <?php if (isset($supppart_id)) { echo "checked"; } ?>/> Supplier Part # </label> </li>
                                    <li> <label> <input type='checkbox' class='sendoptionchck' value='manuname' data-datatxt="Manufacturer Name" data-vtype='fld' <?php if (isset($manuname_id)) { echo "data-tblid='{$manuname_id}'"; } ?> <?php if (isset($manuname_id)) { echo "checked"; } ?>/> Mfg Name </label> </li>
                                    <li> <label> <input type='checkbox' class='sendoptionchck' value='manupart' data-datatxt="Manufacturer Part #" data-vtype='fld' <?php if (isset($manupart_id)) { echo "data-tblid='{$manupart_id}'"; } ?> <?php if (isset($manupart_id)) { echo "checked"; } ?>/> Mfg Part # </label> </li>
                                    <li> <label> <input type='checkbox' class='sendoptionchck' value='withexpiry' data-datatxt="With Expiry" data-vtype='set' <?php if (isset($withexpiry_id)) { echo "data-tblid='{$withexpiry_id}'"; } ?> <?php if (isset($withexpiry_id)) { echo "checked"; } ?>/> Validity </label> </li>
                                </ul>
                            </div>
                            <div class='col-md-6'>
                                <ul class='sendoptions mg-b-0'>
                                    <li> <label> <input type='checkbox' class='sendoptionchck' value='shippingfinalprice' data-datatxt="Shipping Fee" data-vtype='fld' <?php if (isset($shippingfinalprice_id)) { echo "data-tblid='{$shippingfinalprice_id}'"; } ?> <?php if (isset($shippingfinalprice_id)) { echo "checked"; } ?>/> Shipment fee </label> </li>
                                    <li> <label> <input type='checkbox' class='sendoptionchck' value='itemdesc' data-datatxt="Description" data-vtype='fld' <?php if (isset($itemdesc_id)) { echo "data-tblid='{$itemdesc_id}'"; } ?> <?php if (isset($itemdesc_id)) { echo "checked"; } ?>/> Description </label> </li>
                                    <li> <label> <input type='checkbox' class='sendoptionchck' value='showbreakdown' data-datatxt="Show Breakdown" data-vtype='set' <?php if (isset($showbreakdown_id)) { echo "data-tblid='{$showbreakdown_id}'"; } ?> <?php if (isset($showbreakdown_id)) { echo "checked"; } ?>/> Show Subtotal </label> </li>
                                    <li> <label> <input type='checkbox' class='sendoptionchck' value='incorporatetaxornot' data-datatxt="Tax Incorporated" data-vtype='set' <?php if (isset($incorporatetaxornot_id)) { echo "data-tblid='{$incorporatetaxornot_id}'"; } ?> <?php if (isset($incorporatetaxornot_id)) { echo "checked"; } ?>/> Show Tax </label> </li>
                                </ul>
                            </div> 
                            <div class="col-md-12"> 
                                <h5 class='mg-t-20'> Column Order </h5>
                                <table class='columnorder'>
                                    <tbody id='columntds'>
                                        <th> Nothing to show </th>
                                    </tbody>
                                </table>
                            </div>
                            <div class='col-md-12' style="text-align: center;">
                                <span id='savingoptions'>  </span>
                            </div>
                        </div>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->
    <?php } ?>

        <div id="savequote" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Save Quotation<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='dsibox pd-b-20 pd-t-0'>
                        <table>
                            <tr>
                                <td> Document Name </td>
                                <td> <input type='text' class='dsitxtbox' id='documentname' value='<?php if (count($overallqtdets) > 0) { echo $overallqtdets[0]->quotationname; } ?>'/></td>
                            </tr>
                            <tr>
                                <td> Contact Name </td>
                                <td> 
                                    <select id='documentcontact' class='dsitxtbox'>
                                        <?php
                                            if (count($contacts) > 0) {
                                                foreach($contacts as $cn) {
                                                    $sel = null;
                                                    if ($overallqtdets[0]->quotationsentto == $cn->contid) {
                                                        $sel = "selected";
                                                    } else {
                                                        $sel = null;
                                                    }
                                                    echo "<option value='{$cn->contid}' {$sel}>{$cn->contactname}</option>";
                                                }
                                            } else {
                                                echo "<optgroup label='No contact found'> </optgroup>";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class='pd-t-10 pd-b-10'>
                        <button class='dsibutton' id='savequotation'> Save Quotation </button>
                        <button class='dsibutton'> Add New </button>
                    </div>
                </div>

              </div>
            </div>
        </div>

        <div id="sendquotation" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Send Quotation<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='dsibox pd-b-20 pd-t-0'>
                        
                                        <?php
                                            $sel = false;
                                            if (count($contacts) > 0) {
                                                foreach($contacts as $cn) {
                                                    if ($overallqtdets[0]->quotationsentto == $cn->contid) {
                                                        $sel = false;
                                                        echo "<p style='text-align:center;'> You are about to send this quotation to <strong> {$cn->contactname} </strong> </p>";
                                                        echo "<p> Message </p>";
                                                        echo "<textarea id='emailmsgtxt' class='dsitxtbox'> </textarea>";
                                                        break;
                                                    } else {
                                                        $sel = true;
                                                    }
                                                    
                                                }
                                            } else {
                                                echo "<p> Please save to quotation first. </p>";
                                            }
                                        ?>
                                    
                    </div>
                    <div class='pd-t-10 pd-b-10'>
                        <?php if ($sel == false) { ?>
                        <input type='hidden' value='<?php echo $overallqtdets[0]->quotationname; ?>' id='documentsubject'/>
                        <div class='flex'>
                            <button class='dsibutton fullwidth' id='sendquotationbtn' data-toid='<?php echo $overallqtdets[0]->quotationsentto; ?>'> Send Quotation </button>
                            <span id='sendqtspan'> </span>
                        </div>
                        <?php } else { ?>
                            <p> Please save this quotation first. </p>
                        <?php } ?>
                    </div>
                </div>

              </div>
            </div>
        </div>

        <div id="resetexpiry" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Reset Expiration date<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='dsibox pd-b-20 pd-t-20'>
                       <table>
                            <tr>
                                <td> Set new expiry date </td>
                                <td> 
                                    <input type='date' id='expirydate' class='dsitxtbox'/>
                                </td>
                            </tr>
                       </table>
                    </div>
                    <div class='pd-t-10 pd-b-10'>
                        <button class='dsibutton' id='resetexpirybtn'> Reset Expiry </button>
                    </div>
                </div>

              </div>
            </div>
        </div>

        

        <div id="subtotaldiv" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Sub total</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                    <table class='dsitable'>
                        <tr>
                            <td> Description </td>
                            <td> <input type='text' class='dsitxtbox' id='subtotaldesc'/> </td>
                        </tr>
                        <tr>
                            <td> Quantity </td>
                            <td> <input type='number' class='dsitxtbox' id='subtotalqty'/> </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                  <button type="button" 
                          class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" 
                          id='insertsubtotal'>Insert Subtotal</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->
        
        <div id="viewitemdetails" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Item Details</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body removepmarg uniformp" id='showitemdetailshere'>
                    
                </div>
              </div>
            </div>
        </div>

    
                            <div id="companyprofile" class="modal fade">
                                <div class="modal-dialog modal-dialog-vertical-center" role="document">
                                    <div class="modal-content bd-0 tx-14">
                                        <!-- <div class="modal-header pd-y-20 pd-x-25">
                                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"></h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div> -->
                                        <div class="modal-body pd-t-10">
                                            <div class='pd-l-0' id='profilediv'>
                                                <div style="background: #fff;border: 1px solid #dfdede;border-radius: 10px 10px 0px 0px;" class="pd-t-10 pd-r-0 pd-l-10">
                                                    <div class='row dsibox pd-b-10 pd-t-10'>
                                                        <div class='col-md-4'>
                                                            <div class='companyprof'>
                                                                <p> <?php echo strtoupper($ints); ?> </p>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-8 pd-l-0 removepmarg'>
                                                            <strong class='dsitxt'>
                                                                <p>
                                                                <?php 
                                                                    if ($data != null) {
                                                                        if (strlen($data[0]->companyname)==0) {
                                                                            echo "N/A";
                                                                        } else {
                                                                            echo "<span id = 'savetonewclient' > ".$data[0]->companyname ."  </span>";
                                                                        }
                                                                    }
                                                                ?>
                                                                </p>
                                                            </strong>
                                                            <small style="font-size: 13px;"> 
                                                                <?php 
                                                                   
                                                                    if (count($empdata) > 0) {
                                                                        echo $empdata[0]->theinterest;
                                                                    } else {
                                                                        echo "no interest specified";
                                                                    }
                                                                ?>
                                                            </small> <br/> <br/>                                                            
                                                            <a class='fullwidth' style="color: #a4a3a3;font-size: 13px;text-decoration: underline;" target='_blank' href="<?php echo route('customer')."/".$data[0]->id; ?>"> Go to Profile </a>
                                                        </div>
                                                    </div>
                                                   
                                                        <table class='removepmarg dsiflattable mg-t-10'>
                                                            <tr>
                                                                <th colspan='2' style='padding-bottom: 10px;'> Quotation Details </th>
                                                            </tr>
                                                            <tr>
                                                                <td> <p> Status: </p>
                                                                    <strong class='dsitxt'>
                                                                        <?php
                                                                            if (count($overallqtdets) > 0) {
                                                                                if ($overallqtdets[0]->status == 1) {
                                                                                    echo "Quotation";
                                                                                } else if ($overallqtdets[0]->status == 0) {
                                                                                    echo "Subject for Approval";
                                                                                } else if ($overallqtdets[0]->status == 3) {
                                                                                    echo "Ordered";
                                                                                } else if ($overallqtdets[0]->status == 2) {
                                                                                    echo "APPROVED";
                                                                                } else if ($overallqtdets[0]->status == 6) {
                                                                                    echo "Cancelled"; 
                                                                                } else if ($overallqtdets[0]->status == 7) {
                                                                                    echo "expired"; 
                                                                                } else if ($overallqtdets[0]->status == 8) {
                                                                                    echo "Processed: P.O."; 
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </strong> 
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td> <p> Valid until: </p>
                                                                    <?php if ($allowed) { ?>
                                                                        <button class='btn btn-default' 
                                                                                id='changevalidity'
                                                                                data-toggle='modal'
                                                                                data-target='#changevalidityperiod'> 
                                                                            <strong class='dsitxt'> <?php echo date("M. d, Y", strtotime($overallqtdets[0]->quotevalidity)); ?> </strong> 
                                                                        </button>
                                                                    <?php } else { ?>
                                                                        <?php echo "<strong class='dsitxt'>".date("M. d, Y", strtotime($overallqtdets[0]->quotevalidity))."</strong>"; ?>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            
                                                            <!-- <tr>
                                                                <td> 
                                                                    <p> GRT Computation </p>
                                                                    <?php 
                                                                        echo "hello world".count($grt);
                                                                        if (count($grt) > 0) {
                                                                            if ($grt[0]->grttypeid == "2") {
                                                                                echo "<strong class='dsitxt'> This quote computes GRT </strong>";
                                                                            } else {
                                                                                echo "<strong class='dsitxt'> This quote do not compute GRT </strong>";
                                                                            }
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr> -->

                                                            <tr>
                                                                <td> <p> Date: </p>
                                                                    <strong class='dsitxt'> 
                                                                        <?php
                                                                            echo date("M. d, Y", strtotime($quotedets[0]->created_at));
                                                                        ?>
                                                                    </strong> 
                                                                </td>
                                                            </tr>
                                                                        
                                                            <tr>
                                                                <td> <p> Owner: </p>
                                                                    <strong class='dsitxt'>
                                                                        <?php
                                                                            echo $quotedets[0]->name;
                                                                        ?>
                                                                    </strong> 
                                                                </td>
                                                            </tr>
                                                        
                                                        </table>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- modal-dialog -->
                            </div><!-- modal -->
        
        <div id="changevalidityperiod" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document" style="box-shadow: 0px 0px 25px #333;">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"> Change Validity Period</h6>
                  <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button> -->
                </div>
                <div class="modal-body">
                    <div class='dsibox pd-b-20 pd-t-20'>
                       <table>
                            <tr>
                                <td> new validity date </td>
                                <td> 
                                    <input type='date' id='validitydate' class='dsitxtbox'/>
                                </td>
                            </tr>
                       </table>
                    </div>
                    <div class='pd-t-10 pd-b-10'>
                        <button class='dsibutton' id='changevaliditynowbtn'> Reset Expiry </button>
                    </div>
                </div>

              </div>
            </div>
        </div>

        <script>
            $('#datatable1').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                }
            });
        </script>