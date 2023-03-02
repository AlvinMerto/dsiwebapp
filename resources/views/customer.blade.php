<x-app-layout>
<?php $compname = $data[0]->companyname; ?>
@section("title",$compname)

@if (session('status'))
    <div class="alert alert-success" style="z-index: 100000000000000000;position: fixed;top: 0;width: 100%;text-align: center;box-shadow: 0px 3px 9px #a2a2a2;">
       {{session('status')}}
    </div>
@endif
<!-- <div style=''>
    <div style=''>
        inner contents
    </div>
</div> -->
<div class="br-mainpanel pd-30">
    <div class='bgwhite'>
        <div class='row dsibox pd-0'>
            <div class='col-md-12'>
                <div class='flex pd-t-10 pd-b-10 pd-r-15 pd-l-15' style='justify-content: space-between;'>
                    <h5 style='margin: 10px 0px 0px 0px;'> Customer's Information </h5>
                    <div>
                        <button class='dsibutton intablink dsitext' 
                                data-toggle='modal' 
                                data-target='#taxationdivbox'
                                data-tab='taxationtbl'
                                data-viewspan = "taxationviewspan"
                                data-id='<?php echo $data[0]->id; ?>'> Taxation </button>
                        <button class='dsibutton intablink dsitext' 
                                data-toggle='modal' 
                                data-target='#forecastdivbox'
                                data-tab='forecastedsale'
                                data-viewspan = "forecastspan"
                                data-id='<?php echo $data[0]->id; ?>'> Forecast Sale </button>
                        <button class='dsibutton intablink dsitext' 
                                data-tab='completedactivity'
                                data-toggle='modal' 
                                data-viewspan = "completeactivityspan"
                                data-id = '<?php echo $data[0]->id; ?>'
                                data-target='#completeactivitydivbox'> Completed Activity </button>
                        <button class='dsibutton intablink dsitext' 
                                data-tab='schedule' 
                                data-id='<?php echo $data[0]->id; ?>' 
                                data-toggle='modal' 
                                data-viewspan = "scheduleactivityspan"
                                data-target='#scheduletaskdivbox'> Schedule a task </button>
                    </div>
                </div>
            </div>
        </div>
        <div class='dsibox'>
            <div class='row'>
                <div class='col-md-3 bd-r'>
                    <div class='pd-t-20 pd-l-20 pd-r-20 flex' style=''>
                        <button class='dsibutton mg-r-10 ' id='createnewrecord' data-toggle='modal' data-target='#addnewrecord'> Create new Record </button>
                        <button class='dsibutton' id='findarecord'> Find a Record </button>
                    </div>
                    <div class='dsibox pd-10 pd-l-20 pd-t-20 pd-b-20'>
                        <a href="{{route('quotes')}}<?php echo "/".$id."/new"; ?>" class='dsibutton linkbtnview'> Create Quotation for this Customer </a>
                    </div>
                    <div class='pd-10 pd-l-20 dsibox'>
                        <table class='dsismalltable'>
                            <tbody>
                                <tr>
                                    <th colspan=2> Basic Information <small class='editsmall' data-toggle='modal' data-target='#editbasicinfo'> <i class="icon ion-edit"></i> edit </small></th>
                                </tr>
                                <tr>
                                    <td>Company:</td>
                                    <td>
                                        <input type='hidden' value='<?php echo $data[0]->companyname; ?>' id='doctitle'/>
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
                                    <td>Website:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->website)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo "<a target='_blank' href='{$data[0]->website}'>".$data[0]->website."</a>";
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
                                <tr>
                                    <td>Source:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                // $data[0]->srcidfk
                                                if ($source != null) {
                                                    $cap = null;
                                                    foreach($source as $s) {
                                                        if ($s->id == $data[0]->srcidfk) {
                                                            $cap = $s->source;
                                                            break;
                                                        }
                                                    }

                                                    if ($cap != null) {
                                                        echo $cap;
                                                    } else {
                                                        echo "N/A";
                                                    }
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class='pd-10 pd-l-20 dsibox'>
                        <table class='dsismalltable'>
                            <tbody>
                                <tr>
                                    <th colspan=2> Location <small class='editsmall' data-toggle='modal' data-target='#editaddress'> <i class="icon ion-edit"></i> Edit </small></th>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->address)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->address;
                                                }
                                            }
                                        ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->city)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->city;
                                                }
                                            }
                                        ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Zip:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->zip)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->zip;
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->country)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->country;
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>State:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->state)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->state;
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class='pd-10 pd-l-20 dsibox'>
                        <table class='dsismalltable'>
                            <tbody>
                                <tr>
                                    <th colspan=2> Business <small class='editsmall' data-toggle='modal' data-target='#businessedit'> <i class="icon ion-edit"></i> edit </small> </th>
                                </tr>
                                <tr>
                                    <td>Industry:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->industry)==0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->industry;
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Interest:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->theinterest) == 0) {
                                                    echo "N/A";
                                                } else {
                                                    echo $data[0]->theinterest;
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>SIC Code:</td>
                                    <td>
                                        <?php 
                                            if ($data != null) {
                                                if (strlen($data[0]->siccode)==0) {
                                                    echo "N/A";
                                                }else {
                                                    echo $data[0]->siccode;
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sales Person:</td>
                                    <td>
                                        <?php 
                                            echo $salesperson;
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='col-md-9'>
                    <div class='flex navsdiv greenboxbot'>
                        <p> <i class="fa fa-chevron-right" aria-hidden="true"></i> </p>
                        <p class='tabs' data-tabname='summary' data-doctitle = '| <?php echo $compname; ?> - Summary' data-id='<?php echo $data[0]->id; ?>'> Summary </p>
                        <p class='tabs' data-tabname='contacts' data-doctitle = '| <?php echo $compname; ?> - Contacts' data-id='<?php echo $data[0]->id; ?>'> Contacts <span class='notificationspan'> [12] </span> </p>
                        <p class='tabs' data-tabname='profiles' data-doctitle = '| <?php echo $compname; ?> - Profiles' data-id='<?php echo $data[0]->id; ?>'> Deals <span class='notificationspan'> [12] </span></p>
                        <p class='tabs' data-tabname='notes' data-doctitle = '| <?php echo $compname; ?> - Notes' data-id='<?php echo $data[0]->id; ?>'> Notes <span class='notificationspan'> [12] </span></p>
                        <!-- <p class='tabs' data-tabname='referrals' data-doctitle = '| Referrals'> Referrals </p> -->
                        <p class='tabs' data-tabname='pendings' data-doctitle = '| <?php echo $compname; ?> - Tasks' data-id='<?php echo $data[0]->id; ?>'> Tasks <span class='notificationspan'> [12] </span></p>
                        <p class='tabs' data-tabname='activities' data-doctitle = '| <?php echo $compname; ?> - Activities' data-id='<?php echo $data[0]->id; ?>'> Activities <span class='notificationspan'> [12] </span></p>
                        <p class='tabs' data-tabname='links' data-doctitle = '| <?php echo $compname; ?> - Sources' data-id='<?php echo $data[0]->id; ?>'> Sources <span class='notificationspan'> [12] </span></p>
                        <p class='tabs' data-tabname='quotations' data-doctitle = '| <?php echo $compname; ?> - Quotations' data-id='<?php echo $data[0]->id; ?>'> Quotes <span class='notificationspan'> [12] </span></p>
                        <p class='tabs' data-tabname='workorders' data-doctitle = '| <?php echo $compname; ?> - Work Orders' data-id='<?php echo $data[0]->id; ?>'> Work&nbsp;Orders <span class='notificationspan'> [12] </span></p>
                        <p class='tabs' data-tabname='opportunities' data-doctitle = '| <?php echo $compname; ?> - Opportunities' data-id='<?php echo $data[0]->id; ?>'> Opportunities <span class='notificationspan'> [12] </span></p>
                        <p class='tabs' data-tabname='histories' data-doctitle = '| <?php echo $compname; ?> - History' data-id='<?php echo $data[0]->id; ?>'> History </p>
                        <!-- <p class='tabs' data-tabname='tracking' data-doctitle = '| Tracking'> Tracking </p> -->
                    </div>
                    <div>
                        <div class='pd-t-10 pd-b-10 pd-r-10'>
                            <span id='showwindowhere'></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!--create new record-->
          <div id="addnewrecord" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Create new Record</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                    <table class='dsismalltable'>
                        <tr>
                            <td>
                                Company's Name
                            </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='companyname'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Person
                            </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='contactperson'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Number
                            </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='contactnumber'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email Address
                            </td>
                            <td>
                                <input type='email' class='dsitxtbox' id='emailaddress'/>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savenewrecord'>Save New Record</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
          <!--end of new record-->
        
          <!-- edit basic information -->
          <div id="editbasicinfo" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Basic Information</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                   <table class='dsismalltable'>
                     <tr>
                        <td>Company</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->companyname; ?>' id='compname'/></td>
                     </tr>
                     <tr>
                        <td>Contact Person</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->contactperson; ?>' id='contper'/></td>
                     </tr>
                     <tr>
                        <td>Contact Number</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->contactnumber; ?>' id='contnum'/></td>
                     </tr>
                     <tr>
                        <td>Email Address</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->email; ?>' id='emailadd'/></td>
                     </tr>
                     <tr>
                        <td>Website</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->website; ?>' id='websitetxt'/></td>
                     </tr>
                     <tr>
                        <td>Dept.</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->dept; ?>' id='depttxt'/></td>
                     </tr>
                     <tr>
                        <td>Source</td>
                        <td>
                            <select class="dsitxtbox" style='width:100%;' id='srctxt'>
                                <?php 
                                    if (count($source) > 0) {
                                        foreach($source as $s) {
                                            $sel = null;
                                            if ($data[0]->srcidfk == $s->id) {
                                                $sel = "selected";
                                            }
                                            echo "<option value='".$s->id."' {$sel}>";
                                                echo $s->source;
                                            echo "</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                     </tr>
                   </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savebasicinfo' data-custid = '<?php echo $data[0]->id; ?>'>Save changes</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end editing basic information -->

          <!-- edit address -->
          <div id="editaddress" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Location</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                   <table class='dsismalltable'>
                     <tr>
                        <td>Address:</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->address; ?>' id='address'/></td>
                     </tr>
                     <tr>
                        <td>City:</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->city; ?>' id='city'/></td>
                     </tr>
                     <tr>
                        <td>Zip:</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->zip; ?>' id='zip'/></td>
                     </tr>
                     <tr>
                        <td>Country:</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->country; ?>' id='country'/></td>
                     </tr>
                     <tr>
                        <td>State:</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->state; ?>' id='state'/></td>
                     </tr>
                   </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='saveaddress' data-custid = '<?php echo $data[0]->id; ?>'>Save changes</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end edit address -->

          <!-- business type -->
          <div id="businessedit" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Business</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                   <table class='dsismalltable'>
                     <tr>
                        <td>Industry:</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->industry; ?>' id='industry'/></td>
                     </tr>
                     <tr>
                        <td>Interest:</td>
                        <td>
                            <select class='dsitxtbox' id='interest'>
                                <?php
                                    if (count($interest) > 0) {
                                        foreach($interest as $i) {
                                            $selected = null;
                                            if ($data[0]->interid == $i->interid) {
                                                $selected = "selected";
                                            } else {
                                                $selected = null;
                                            }
                                            echo "<option value='{$i->interid}' {$selected}>{$i->theinterest}</option>";
                                        }
                                    } else {
                                        echo "<optgroup label='No Data found'> </optgroup>";
                                    }
                                ?>
                            </select>
                            <!-- <input type='text' class='dsitxtbox' value='<?php //echo $data[0]->interest; ?>' id='interest'/> -->
                        </td>
                     </tr>
                     <tr>
                        <td>SIC Code:</td>
                        <td><input type='text' class='dsitxtbox' value='<?php echo $data[0]->siccode; ?>' id='siccode'/></td>
                     </tr>
                     <!--tr>
                        <td>Sales Person:</td>
                        <td><input type='text' class='dsitxtbox' value='' id='country'/></td>
                     </tr-->
                   </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savebusiness' data-custid = '<?php echo $data[0]->id; ?>'>Save changes</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- business type -->

        <div id="modalpopupview" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center fullwidth" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id='modalname'></span></h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='intabviewspan'> -- </span>
                </div>
              </div>
            </div>
        </div>

        <div id="taxationdivbox" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center fullwidth" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Taxation</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='taxationviewspan'> -- </span>
                </div>
              </div>
            </div>
        </div>

        <div id="forecastdivbox" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center fullwidth" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Forecast Sale</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='forecastspan'> -- </span>
                </div>
              </div>
            </div>
        </div>

        <div id="completeactivitydivbox" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center fullwidth" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Complete Activity</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='completeactivityspan'> -- </span>
                </div>
              </div>
            </div>
        </div>
        
        <div id="scheduletaskdivbox" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center fullwidth" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Schedule Activity</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='scheduleactivityspan'> -- </span>
                </div>
              </div>
            </div>
        </div>
        

        <!-- <div id="completemenu" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center fullwidth" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Complete</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class=''>
                        <table class='fullwidth removepmarg tbltoptd'> 
                            <tr>
                                <td colspan=2>
                                    <p> Activity </p>
                                    <select>
                                        <optgroup label='Tasks'>
                                            <option> Call </option>
                                            <option> Meeting </option>
                                            <option> Follow-up </option>
                                            <option> Appointment </option>
                                            <option> Custom Task </option>
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Contact </p>
                                            <select>
                                                <option> Alvin </option>
                                                <option> Jay </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Reference </p>
                                            <input type='text' class='dsitxtbox'/>
                                        </div>
                                    </div>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Share with </p>
                                            <input type="text" class="dsitxtbox" autocomplete="on" list="sharewith" id="textchangetxt">
                                            <p id="sharei" style="margin-top:5px; margin-bottom:0px;"> </p>
                                            <datalist id="sharewith">
                                                <option> All </option>
                                                <option> Jessica </option>
                                                <option> Melissa </option>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Date </p>
                                            <input type='date' class='dsitxtbox'/>
                                        </div>
                                    </div>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Time </p>
                                            <input type='time' class='dsitxtbox'/>
                                        </div>
                                    </div>
                                </td>
                                <td rowspan=10 style='height:100%;'>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Notes </p>
                                            <textarea class='dsitxtbox' style='min-height:290px;'></textarea>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button class='dsibutton'> Complete now </button>
                </div>
              </div>
            </div>
        </div>
        
        <div id="forecastsale" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Forecast Sale</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <table class='dsismalltable'>
                        <tr>
                            <td> Contact </td>
                            <td> 
                                <select>
                                    <option> Jay </option>
                                    <option> Alvin </option>
                                </select>        
                            </td>
                        </tr>
                        <tr>
                            <td> Opportunity/Project </td>
                            <td> 
                               <div class='flex'>
                                    <input type='text' class='dsitxtbox'/>
                                    <button class='btn btn-default'> New </button>    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> Product </td>
                            <td> 
                               <select>
                                    <option> Product 1 </option>
                                    <option> Product 2 </option>
                               </select>
                            </td>
                        </tr>
                        <tr>
                            <td> User </td>
                            <td> 
                               <select>
                                    <option> Jessica </option>
                                    <option> Mae </option>
                               </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Units </td>
                            <td> 
                               <input type='text' class='dsitxtbox' placeholder='0'/>
                            </td>
                        </tr>
                        <tr>
                            <td> Price </td>
                            <td> 
                               <input type='text' class='dsitxtbox' placeholder='0.00'/>
                            </td>
                        </tr>
                        <tr>
                            <td> Amount </td>
                            <td> 
                               <input type='text' class='dsitxtbox' placeholder='0.00'/>
                            </td>
                        </tr>
                        <tr>
                            <td> Probability </td>
                            <td> 
                               <input type='text' class='dsitxtbox' placeholder='%'/>
                            </td>
                        </tr>
                        <tr>
                            <td> Sale Date </td>
                            <td> 
                               <input type='date' class='dsitxtbox'/>
                            </td>
                        </tr>  
                        <tr>
                            <td> Notes </td>
                            <td> 
                               <textarea class='dsitxtbox'></textarea>
                            </td>
                        </tr>  
                    </table>
                </div>
                <div class='modal-footer'>
                    <button class='dsibutton'> Schedule </button>
                </div>
              </div>
            </div>
        </div> -->
        
</x-app-layout>

