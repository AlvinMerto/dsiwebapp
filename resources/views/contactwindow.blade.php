<x-app-layout>
@section('title', 'Phonebook')
    <div class="br-mainpanel pd-30">
        <div class='bgwhite'>
            <div class='dsibox pd-20 flex' style='justify-content:space-between;'>
                <h4> Phonebook </h4>
                <button class='dsibutton' id='createnewrecord' data-toggle='modal' data-target='#addnewcontact'> Create new Contact </button>
            </div>
            <div class='pd-20'>
                <table id='datatable1'>
                    <thead>
                        <th> # </th>
                        <th> Position </th>
                        <th> Contact Name </th>
                        <th> Current Company Connected </th>
                        <th> Current Email Address </th>
                        <th> Current Contact Number </th>
                    </thead>
                    <tbody>
                        <?php 
                            if (count($contacts) > 0) {
                                $count=1;
                                foreach($contacts as $c) {
                                    echo "<tr>";
                                        echo "<td>{$count}</td>";
                                        echo "<td>{$c->title}</td>";
                                        echo "<td data-toggle='modal' 
                                                class='intablink' data-target='#viewcontact'
                                                data-tab='contacts' data-id='{$c->contid}' 
                                                data-viewdeck='true'>{$c->contactname}</td>";
                                        echo "<td>{$c->companyname}</td>";
                                        echo "<td>{$c->email}</td>";
                                        echo "<td>{$c->contactnumber}</td>";
                                    echo "</tr>";
                                    $count++;
                                }
                            }
                            // <td data-toggle="modal" class="intablink" data-target="#viewcontact" data-tab="contacts" data-id="5" data-viewdeck="true">DSI contact</td>
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
                                Company
                            </td>
                            <td>
                                <select id='companynametxt'>
                                    <?php 
                                        if(count($customer) > 0) {
                                            foreach($customer as $c) {
                                                echo "<option value='{$c->id}'>";
                                                    echo $c->companyname;
                                                echo "</option>";
                                            }        
                                        } else {
                                            echo "<optgroup label='NO COMPANY'> </optgroup>";
                                        }
                                    ?>
                                </select>
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
                  <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savenewcontact' data-custid="">Save New Contact</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
          <!--end of new record-->
    </div>
</x-app-layout>