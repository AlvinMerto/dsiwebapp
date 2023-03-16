<div class='dsibox flex appletnavs pd-b-10'>
    <button class='btn btn-default' data-toggle='modal' data-target='#addnewcontact'> <i class="icon ion-person-add"></i>&nbsp;Add New </button>
</div>
<div class='dsibox pd-t-10 pd-b-10'>
    <div class="table-wrapper applettable">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <th> # </th>
                <th> Contact Name </th>
                <th> Title </th>
                <th> Phone </th>
                <th> Email </th>
            </thead>
            <tbody>
                <?php
                    $count = 1;
                    if (count($data) > 0) {
                        foreach($data as $d) {
                            echo "<tr>";
                                echo "<td>".$count."</td>";
                                echo "<td data-toggle='modal' class='intablink' data-target='#viewcontact' data-tab='contacts' data-id='".$d->contid."' data-viewdeck='true'>".$d->contactname."</td>";
                                echo "<td>".$d->title."</td>";
                                echo "<td>".$d->contactnumber."</td>";
                                echo "<td>".$d->email."</td>";
                            echo "</tr>";
                            $count++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

    <!--view record-->
        <div id="viewcontact" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Contact Information</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-l-25 pd-r-25 pd-b-25 pd-t-10">
                    <span id='intabviewspan'> </span>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
          <!--end of view record-->

<!--create new record-->
        <div id="addnewcontact" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Contact</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-l-10 pd-r-10 pd-b-10 pd-t-10">
                    <table class='dsismalltable'>
                        <!-- <tr>
                            <th colspan=2> 
                                <button class='btn btn-default btn-sm'> Add Additional Information </button> 
                                <hr class='mg-t-10 mg-b-10'/>
                            </th>
                        </tr> -->
                        <tr>
                            <td>
                                Contact Name
                            </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='contactname'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Title
                            </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='contacttitle'/>
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
                        <tr>
                            <td>
                                Address
                            </td>
                            <td>
                                <textarea class='dsitxtbox' id='addresstxt'></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                City
                            </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='citytxt'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                State/Country
                            </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='statecountry'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Zip
                            </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='ziptxt'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Notes
                            </td>
                            <td>
                                <textarea class='dsitxtbox' id='thenotes'></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savenewcontact' data-custid="<?php echo $custid; ?>">Save New Contact</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
          <!--end of new record-->

          <!--send email-->
        <div id="sendemailtoperson" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Send a Message</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='dsibox'>
                        <table class='dsitable'>
                            <tr>
                                <td class='pd-10'> To: </td>
                                <td> <strong> alvin@gmail.com </strong> </td>
                            </tr>
                            <tr>
                                <td colspan=2> 
                                    <div id='emailbody'></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savenewrecord'>Send</button>
                </div>
              </div>
            </div>
        </div>
<script>
    
    $('#emailbody').summernote({
        height: 300,
        width:'100%'
    });

    $('#datatable1').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
     });
</script>