<div class='dsibox pd-b-10'>
   <button class='btn btn-default btn-sm intablink' data-tab='contacthistory' data-id="<?php echo $data[0]->contid; ?>"> Contact history </button>
   <button class='btn btn-default btn-sm intablink' data-tab='viewadditionalinfo' data-id="<?php echo $data[0]->contid; ?>"> View Additional Information </button> 
</div>
            <div class='dsibox pd-t-10 pd-b-10'>
                <table class='dsismalltable removepmarg'>
                        <tr>
                            <td>
                                Contact Name
                            </td>
                            <td><input type      ='text' 
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "contactname",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      ='<?php echo $data[0]->contactname; ?>'/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Title
                            </td>
                            <td>
                                <input type      ='text' 
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "title",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      ='<?php echo $data[0]->title; ?>'/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Current Company
                            </td>
                            <td>
                                <a class='dsitxt' target='_blank' href="{{route('customer')}}/<?php echo $data[0]->custidfk; ?>"> <?php echo $data[0]->companyname; ?> </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Number
                            </td>
                            <td>
                                <input type      ='text' 
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "contactnumber",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      ='<?php echo $data[0]->contactnumber; ?>'/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email Address
                            </td>
                            <td>
                                <input type      ='text' 
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "email",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      ='<?php echo $data[0]->email; ?>'/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Address
                            </td>
                            <td>
                                <input type      ='text' 
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "address",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      ='<?php echo $data[0]->address; ?>'/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                City
                            </td>
                            <td>
                                <input type      ='text' 
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "city",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      ='<?php echo $data[0]->city; ?>'/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                State/Country
                            </td>
                            <td>
                               <input type      ='text' 
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "state_country",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      ='<?php echo $data[0]->state_country; ?>'/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Zip
                            </td>
                            <td>
                                <input type      ='text' 
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "zip",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      ='<?php echo $data[0]->zip; ?>'/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Notes
                            </td>
                            <td>
                                <input type='text'
                                      disabled   ='disabled'
                                      class      ='thetextinput'
                                      data-fld   = "notes",
                                      data-idfld = "contid",
                                      data-id    = "<?php echo $data[0]->contid; ?>"
                                      data-tbl   = "contactstbls"
                                      value      = "<?php echo $data[0]->notes; ?>"/>
                                <small class='peritemedit'> edit </small>
                            </td>
                        </tr>
                        <?php if ($data[0]->status == 0) { ?>
                            <tr>
                                <td> Contact Status </td>
                                <td style='color:red;'> DELETED </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="pd-t-10">
                  <!-- <button class='dsibutton' data-toggle='modal' data-target='#sendemailtoperson'> <i class="fa fa-send"></i>&nbsp;Message </button> -->
                  <a class='dsibutton' href='mailto:<?php echo $data[0]->email; ?>'><i class="fa fa-send"></i>&nbsp; Message</a>
                  <button class='dsibutton intablink' data-tab='transfertonew' data-id='<?php echo $data[0]->contid; ?>' style='color: #fff;font-weight: normal;'> <i class="icon ion-document-text"></i>&nbsp; Transfer </button>
                  <button class='dsibutton intablink' data-tab='additionalinfo' data-id="<?php echo $data[0]->contid; ?>" style='color: #fff;font-weight: normal;'> <i class="fa fa-address-card-o" aria-hidden="true"></i> Add Information </button> 
                  <!-- <button class='dsibutton'> <i class="icon ion-document-text"></i>&nbsp;Edit </button> &nbsp; -->
                  <?php if ($data[0]->status == 0) { ?>
                    <button class='dsibutton recovercont' data-contid=<?php echo $data[0]->contid; ?>> <i class="fa fa-check"></i>&nbsp;Recover </button>
                  <?php } else { ?>
                    <button class='btn btn-danger removecont' data-contid=<?php echo $data[0]->contid; ?>> <i class="fa fa-close"></i>&nbsp;Remove </button>
                  <?php } ?>
                  <!--button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savenewrecord'>Save New Contact</button-->
                </div>