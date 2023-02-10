<div class='dsibox' style='margin-bottom: 12px;'>
    <div class='flex'>
        <ul class="flex smallnavsbtn">
            <li> New work Order </li>
            <li> TBS </li>
            <li> unassigned </li> 
            <li> my work orders 
                <ul>
                    <li> open </li>
                    <li> pending close-out </li>
                    <li> invoiced </li>
                    <li> closed </li>
                </ul>
            </li>
            <li> All open work orders 
                <ul>
                    <li> open </li>
                    <li> pending close-out </li>
                    <li> rejected </li>
                    <li> for approval </li>
                    <li> for invoicing </li>
                </ul>
            </li>
            <li> invoiced/closed
                <ul>
                    <li> invoiced </li>
                    <li> closed </li>
                </ul>
            </li>
            <li> Void </li>
            <li> Report </li>
        </ul>
    </div>
</div>
                        <div class="table-wrapper applettable">
                            <table id="datatable1" class="table display responsive nowrap">
                                <thead>
                                    <th> # </th>
                                    <th> Service Type </th>
                                    <th> Work Requested </th>
                                    <th> Scheduled Date/Time </th>
                                    <th> Status </th>
                                    <th> Date Created </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> 1 </td>
                                        <td> In-house </td>
                                        <td class='wodets' data-toggle='modal' data-target='#viewwo'> Apply fix to exchange 2016 Y2K22 bug. Affecting incoming and outgoing emails. </td>
                                        <td> January 1, 2023 @ 11:00 AM </td>
                                        <td> Invoiced </td>
                                        <td> January 1, 2023 by Alvin </td>
                                    </tr>
                                    <tr>
                                        <td> 2 </td>
                                        <td> Service Contract </td>
                                        <td class='wodets'> Install Office 365 on Darren PC. Check Label printer at parts.	 </td>
                                        <td> January 5, 2023 @ 11:00 AM </td>
                                        <td> Invoiced </td>
                                        <td> January 1, 2023 by Jay </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
            
        <div id="viewwo" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center maxwidth" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Work Order Detail</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-t-0">
                    <div class="flex navsdiv greenboxbot">
                        <p class='showwobtn' data-id='1' data-pagereq='invoice'> Invoice</p>
                        <p class='showwobtn' data-id='1' data-pagereq='workreqs'> Work Requested</p>
                        <p class='showwobtn' data-id='1' data-pagereq='items'> Items Dropped Off</p>
                        <p class='showwobtn' data-id='1' data-pagereq='workcomplete'>Work Completed</p>
                        <p>Parts and Materials</p>
                        <p>Comments</p>
                        <p>Attachments</p>
                    </div>
                    <div>
                        <span id='showwohere'></span>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button class='dsibutton'> Complete </button>
                </div>
              </div>
            </div>
        </div>
    
        <script>
            $("#datatable1").DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                }
            });
        </script>