<x-app-layout>
@section('title', 'List of Customers')
    <div class="br-mainpanel pd-30">
        <div class='bgwhite'>
            <div class='dsibox pd-20 flex' style='justify-content:space-between;'>
                <h4> All Records </h4>
                <button class='dsibutton' id='createnewrecord' data-toggle='modal' data-target='#addnewrecord'> Create new Record </button>
            </div>
            <!--div class='flex dsibox pd-20' style='justify-content:space-between;'>
                <div>
                    <h4 style='margin:0px;'> All Records </h4>
                </div>
                <div>
                    <button class='btn btn-default'> Delete </button>
                </div>
            </div-->
            <div class='dsibox pd-20'>
            <div class="table-wrapper">
                <table id="datatable1" class="table display responsive nowrap">
                <thead>
                    <tr>
                        <th style='width:10px;'> &nbsp; </th>
                        <th class="wd-15p">Company Name</th>
                        <th class="wd-15p">Contact Number</th>
                        <th class="wd-20p">Email</th>
                        <th class="wd-15p">Quotations</th>
                        <th class="wd-10p">Work Orders</th>
                        <th class="wd-10p">Opportunity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if (count($data) > 0) {
                            $count = 0;
                            foreach($data as $d) {
                                echo "<tr>";
                                    echo "<td style='width:10px;'> <input type='checkbox'/> </td>";
                                    echo "<td class='compname'><a href='".url('/customer')."/".$d->id."'/>".$d->companyname."</a></td>";
                                    echo "<td>".$d->contactnumber."</td>";
                                    echo "<td>".$d->email."</td>";
                                    echo "<td>";
                                        foreach($qtcnt as $key => $qt) {
                                            if ($key == $d->id) {
                                                echo $qt ." Quotations";
                                            }
                                        }
                                    echo " </td>";
                                    echo "<td> 280 Work Orders </td>";
                                    echo "<td> 90 Opportunities </td>";
                                echo "</tr>";
                                $count++;
                            }
                        }
                    ?>
                </tbody>
                </table>
                </div><!-- table-wrapper -->
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

</x-app-layout>