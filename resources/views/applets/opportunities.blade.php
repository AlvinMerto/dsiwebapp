    <div>
        <button class="btn dsibutton btn-sm" data-toggle='modal' data-target="#viewfilter"> Filter </button>
    </div>
                <div class='pd-t-10 pd-b-10'>
                    <div class="table-wrapper applettable">
                        <table id="datatable1" class="table display responsive nowrap">
                            <thead>
                                <!-- <th> # </th> -->
                                <th> Company </th>
                                <!-- <th> Location </th> -->
                                <th> Requirements </th>
                                <th> Forecast </th>
                                <th> Forecast Amt($) </th>
                                <th> Owner </th>
                                <th> Assigned </th>
                                <th> Date Created </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- <td> 1 </td> -->
                                    <td class='thecompname'>
                                        <p data-toggle='modal' data-target='#viewopportunity'> 
                                            Company name
                                        </p>
                                    </td>
                                    <!-- <td> PI	</td> -->
                                    <td> Hardware </td>
                                    <td> 2,500.00 </td>
                                    <td> 2,500.00 </td>
                                    <td> Melissa Dimla </td>
                                    <td> Melissa Dimla </td>
                                    <td> 08/10/2020 @ 04:38 pm </td>
                                </tr>
                                <tr>
                                    <td> 2 </td>
                                    <td class='thecompname'>
                                        <p data-toggle='modal' data-target='#viewopportunity'> 
                                            Company name 
                                        </p>
                                    </td>
                                    <!-- <td> PI	</td> -->
                                    <td> Hardware </td>
                                    <td> 2,500.00 </td>
                                    <td> 2,500.00 </td>
                                    <td> Melissa Dimla </td>
                                    <td> Melissa Dimla </td>
                                    <td> 08/10/2020 @ 04:38 pm </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
        <div class='dsibox removepmarg pd-t-20 pd-b-20'>
            <div class='row'>
                <div class='col-md-4'>
                    <p> Total Sales won for 2023</p>
                    <p class='dsitxt'> $ 2,000,000.00 </p>
                </div>
                <div class='col-md-4'>
                    <p> TOTAL SALES WON FOR JANUARY 2023: </p>
                    <p class='dsitxt'> $ 2,000,000.00 </p>
                </div>
                <div class='col-md-4'>
                    <p> TOTAL SALES FORECAST (within 30 days):  </p> 
                    <p class='dsitxt'> $ 1,190,906.87 </p>
                </div>
            </div>
        </div>
</div>

        <div id="viewfilter" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Filter Opportunity</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td> Filter by Status </td>
                            <td>
                                <select>
                                    <option> Active (within 30 days forecast) </option>
                                    <option> Future Opportunities (> 30 days forecast) </option>
                                    <option> Won </option>
                                    <option> Cancelled/lost </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Filter by Source </td>
                            <td>
                                <select>
                                    <option> Ads </option>
                                    <option> Customer - Existing </option>
                                    <option> Customer - Visited </option>
                                    <option> Email Blast/Direct </option>
                                    <option> Email Inquiry </option>
                                    <option> Newspaper </option>
                                    <option> Phone Inquiry </option>
                                    <option> Referral </option>
                                    <option> Telemarketing </option>
                                    <option> Walk-in </option>
                                    <option> Website </option>
                                    <option> Work of Mouth </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Forecast Date Range </td>
                            <td>
                                <div class='flex'><input type='date' class='dsitxtbox'/> <input type='date' class='dsitxtbox'/> </div>
                            </td>
                        </tr>
                        <tr>
                            <td> Forecast Closed Range </td>
                            <td>
                                <div class='flex'><input type='date' class='dsitxtbox'/> <input type='date' class='dsitxtbox'/> </div>
                            </td>
                        </tr>
                        <tr>
                            <td> Location </td>
                            <td>
                                <select>
                                    <option> Guam </option>
                                    <option> PH </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Filter by requirements </td>
                            <td>
                                <select>
                                    <option> 3CX </option>
                                    <option> 3CX Licence </option>
                                    <option> 3CX Project </option>
                                    <option> AVG / Avast </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Filter by Owner </td>
                            <td>
                                <select>
                                    <option> Pam </option>
                                    <option> Chu </option>
                                    <option> Mae </option>
                                    <option> Jason </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Filter by Assigned </td>
                            <td>
                                <select>
                                    <option> Pam </option>
                                    <option> Chu </option>
                                    <option> Mae </option>
                                    <option> Jason </option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class='modal-footer'>
                    <button class='dsibutton'> Filter </button>
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