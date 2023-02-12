<x-app-layout>
    <?php $compname = $data[0]->companyname." Quotation"; ?>
    @section("title",$compname)
   <div class="br-mainpanel pd-30">
        <div class=''>
            <div class='row'>
                <div class='col-md-2 pd-r-0'>
                    <div class='pd-l-0'>
                        <div style="min-height: 800px; background: #fff;border: 1px solid #dfdede;border-radius: 10px 10px 0px 0px;" class="pd-t-10 pd-r-0 pd-l-10">
                            <div class='row dsibox pd-b-10 pd-t-10'>
                                <div class='col-md-4'>
                                    <div class='companyprof'>
                                        <img src="http://localhost:8000/images/DSC_5694.jpg">
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
                                                    echo "<span id = 'savetonewclient' data-toggle='modal' data-target='#savetonewcustomer'> ".$data[0]->companyname ." <i class='icon ion-edit' style='font-size:10px;'></i>  </span>";
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
                            <div id ='checkformarkups' style='text-align:center;'> 
                                checking...
                            </div>
                            <div class='dsibox mg-b-20 pd-r-10 pd-t-5' id='totaldiv' style='text-align:center;'> Computing.. </div>
                            <table class='removepmarg dsibox dsiflattable'>
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
                                                        echo "Sales";
                                                    } else if ($overallqtdets[0]->status == 2) {
                                                        echo "APPROVED";
                                                    } else if ($overallqtdets[0]->status == 6) {
                                                        echo "Cancelled"; 
                                                    } else if ($overallqtdets[0]->status == 7) {
                                                        echo "expired"; 
                                                    }
                                                }
                                                // echo " <small id='resetexp' style='cursor:pointer;' data-toggle='modal' data-target='#resetexpiry'> Reset </small>";
                                            ?>
                                        </strong> 
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td> <p> Tax %: </p>
                                        <input type="text" 
                                            class="thetextinput" 
                                            data-fld="taxpercentage" 
                                            data-idfld="tptblid"
                                            data-id="<?php //echo $quotedets[0]->tptblid; ?>" 
                                            data-tbl="totalpricetbls"
                                            data-callcompute = "true"
                                            value="<?php //echo $quotedets[0]->taxpercentage; ?>" 
                                            disabled="disabled"
                                            style=''>
                                        <small class="peritemedit"> edit </small>
                                        </strong> 
                                    </td>
                                </tr> -->
                                <tr>
                                    <td> <p> Valid until: </p>
                                        <button class='btn btn-default' 
                                                id='changevalidity'
                                                data-toggle='modal'
                                                data-target='#changevalidityperiod'> 
                                            <strong class='dsitxt'> <?php echo date("M. d, Y", strtotime($overallqtdets[0]->quotevalidity)); ?> </strong> 
                                        </button>
                                        <!-- <strong class='dsitxt'> 
                                            <input type="date" 
                                                class="thetextinput" 
                                                data-fld="quotevalidity" 
                                                data-idfld="quoteid"
                                                data-id="<?php // echo $overallqtdets[0]->quoteid; ?>" 
                                                data-tbl="quotation_corners"
                                                disabled="disabled"
                                                style=''>
                                            <small class="peritemedit"> edit </small>
                                        </strong>  -->
                                    </td>
                                </tr>
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
                                    <td> <p> Quoted by: </p>
                                        <strong class='dsitxt'>
                                            <?php
                                                echo $quotedets[0]->name;
                                            ?>
                                        </strong> 
                                    </td>
                                </tr>
                            
                            </table>
                            <br/>
                            <!-- <table class='dsismalltable dsibox'>
                                <tbody>
                                    <tr>
                                        <th colspan=2> Basic Information </th>
                                    </tr>
                                    <tr>
                                        <td>Company:</td>
                                        <td>
                                            <?php 
                                                // if ($data != null) {
                                                //     if (strlen($data[0]->companyname)==0) {
                                                //         echo "N/A";
                                                //     } else {
                                                //         echo "<span id = 'savetonewclient' data-toggle='modal' data-target='#savetonewcustomer'> <i class='icon ion-edit' style='font-size:10px;'></i>".$data[0]->companyname ." </span>";
                                                //     }
                                                // }
                                            ?>    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Contact Person:</td>
                                        <td>
                                            <?php 
                                                // if ($data != null) {
                                                //     if (strlen($data[0]->contactperson)==0) {
                                                //         echo "N/A";
                                                //     } else {
                                                //         echo $data[0]->contactperson;
                                                //     }
                                                // }
                                            ?>   
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Contact Number:</td>
                                        <td>
                                            <?php 
                                                // if ($data != null) {
                                                //     if (strlen($data[0]->contactnumber)==0) {
                                                //         echo "N/A";
                                                //     } else {
                                                //         echo $data[0]->contactnumber;
                                                //     }
                                                // }
                                            ?>   
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email Address:</td>
                                        <td>
                                            <?php 
                                                // if ($data != null) {
                                                //     if (strlen($data[0]->email)==0) {
                                                //         echo "N/A";
                                                //     } else {
                                                //         echo $data[0]->email;
                                                //     }
                                                // }
                                            ?>   
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dept:</td>
                                        <td>
                                            <?php 
                                                // if ($data != null) {
                                                //     if (strlen($data[0]->dept)==0) {
                                                //         echo "N/A";
                                                //     } else {
                                                //         echo $data[0]->dept;
                                                //     }    
                                                // }
                                            ?> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table> -->
                            
                        <!-- <div class='flex pd-l-20 pd-t-20 pd-b-20 pd-r-20' style='justify-content:center;text-align:center;'>
                           
                        </div> -->
                    </div>
                    </div>
                </div>
                <div class='col-md-10 pd-l-5' id='motherdiv'>
                    <div class='pd-t-0 pd-b-0 '>
                        <div class='dsibox flex pd-l-0' style="border-bottom: none; border-right: 1px solid #dfdfdf; border-left: 1px solid #dfdfdf;border-radius: 10px 10px 0px 0px;background: #fff;border-top: 1px solid #dfdfdf;">
                        <input type='hidden' value='<?php echo $quoteid; ?>' id='quoteidfk'/>
                        <input type='hidden' value='<?php echo $empdata[0]->interid; ?>' id='interid'/>
                        <input type='hidden' value='<?php echo $empdata[0]->theinterest; ?>' id='intervalue'/>
                        <div class='flex'>
                                <ul class='flex smallnavsbtn'>
                                    <li> File 
                                        <ul>
                                            <li data-toggle='modal' data-target='#savequote'> <i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; Save </li>
                                            <li data-toggle='modal' data-target='#sendquotation'> <i class="fa fa-paper-plane-o" aria-hidden="true"></i> &nbsp; Send </li>
                                            <li data-toggle='modal' data-target='#savetonewcustomer'> <i class="fa fa-terminal" aria-hidden="true"></i> &nbsp;Save to new customer </li>
                                            <li id='resetexp' style='cursor:pointer;' data-toggle='modal' data-target='#resetexpiry'> <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp; Reset Quotation Status</li>
                                            <li> <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download as PDF </li>
                                        </ul>
                                    </li>
                                    <li> Edit 
                                        <ul>
                                            <li id='removebtn'> <i class="fa fa-close" aria-hidden="true"></i> &nbsp;Remove </li>
                                            <li> <i class="fa fa-clone" aria-hidden="true"></i> &nbsp;Duplicate </li>
                                        </ul>
                                    </li>
                                    <li> Insert
                                        <ul>
                                            <li data-toggle='modal' data-target='#insertitem' class='callitemssource' data-window='additem'> <i class="fa fa-angle-right" aria-hidden="true"></i> Add Custom Item </li>
                                            <li data-toggle='modal' data-target='#insertitem' class='callitemssource' data-window='taxable'> <i class="fa fa-angle-right" aria-hidden="true"></i> Insert Item from source </li> 
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> Subtotal </li>
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> Labor </li>
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> Freight </li>
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> Line </li>
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> Blank Row </li>
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> Comment </li>
                                        </ul>
                                    </li>
                                    <li> Convert 
                                        <ul>
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> To order </li>
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> To invoice </li>
                                            <li> <i class="fa fa-angle-right" aria-hidden="true"></i> To sales </li>
                                        </ul>
                                    </li>
                                </ul>
                        </div>
                            
                    </div>
                </div>
            
                <div class=' pd-l-0'>
                    <!--<h6 class="pageh pd-l-10 pd-t-10 pd-b-10" style="border-right: 1px solid #eaeaea;border-bottom: 1px solid #eaeaea;"> Quotation for <a href='#' data-toggle='modal' data-target='#basicinfodiv' class='thecompname'> <?php // echo $data[0]->companyname; ?> </a>  </h6>--> 
                        <div class='dsibox minheightdiv bgdiv' id='contextmenu'>
                            <table class='quotestable table-striped'>
                                <thead>
                                    <tr style="border-right: 1px solid #eaeaea;">
                                        <th> &nbsp; </th>
                                        <th> # </th>
                                        <th> Profit </th>
                                        <th> Markup </th>
                                        <th> Cost </th>
                                        <th> Supplier </th>
                                        <th> Supplier # </th>
                                        <th> Mfg </th>
                                        <th> Mfg # </th>
                                        <th style="width:250px"> Description </th>
                                        <th> Qty </th>
                                        <th> Price </th>
                                        <th> Extended </th>
                                        <th> Tax </th>
                                    </tr>
                                </thead>
                                <tbody id='tbodyrow'>
                                <tr> <td colspan="20"> loading... </td> </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
    </div>
</x-app-layout>

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

        <div id="insertitem" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Insert Item<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
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
                    <div class='dsibox pd-b-20 pd-t-20'>
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
                    <div class='dsibox pd-b-20 pd-t-20'>
                      
                                        <?php
                                            $sel = false;
                                            if (count($contacts) > 0) {
                                                foreach($contacts as $cn) {
                                                    if ($overallqtdets[0]->quotationsentto == $cn->contid) {
                                                        $sel = false;
                                                        echo "<p> You are about to send this quotation to <strong> {$cn->contactname} </strong> </p>";
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
                            <button class='dsibutton' id='sendquotationbtn' data-toid='<?php echo $overallqtdets[0]->quotationsentto; ?>'> Send Quotation </button>
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

        <div id="changevalidityperiod" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"> Change Validity Period</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
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