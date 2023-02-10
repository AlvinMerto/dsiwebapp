<div class='dsibox flex appletnavs pd-b-10'>
    <button class='btn btn-default' data-toggle='modal' data-target='#addnewreferral'> <i class="icon ion-plus"></i>&nbsp;Add New </button>
    <button class='btn btn-default' data-toggle='modal' data-target='#newprofile'> <i class="icon ion-close"></i>&nbsp;Delete </button>
</div>
<div class='dsibox pd-t-10 pd-b-10'>
    <div class="table-wrapper applettable">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <th> &nbsp; </th>
                <th> Referral </th>
                <th> Reference </th>
            </thead>
            <tbody>
                <tr>
                    <th> <input type='checkbox'/> </th>
                    <td class='compname'> <a href=''>ABC Company</a></td>
                    <td>Test Reference 1</td>
                </tr>
                <tr>
                    <th> <input type='checkbox'/> </th>
                    <td class='compname'> <a href=''> XYZ Incorporated </a></td>
                    <td>Testing Reference 2</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

        <div id="addnewreferral" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Referrals</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="table-wrapper applettable dsibox pd-b-10">
                        <table id="datatable2" class="table display responsive nowrap">
                            <thead>
                                <th> # </th>
                                <th> Referral </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> 1 </td>
                                    <td class='intablink' data-tab='referrals' data-id='1'> ABC Company</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="dsibox pd-t-10 pd-b-10">
                        <span id='intabviewspan'> </span>
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
     $('#datatable2').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
     });
</script>