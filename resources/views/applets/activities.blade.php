<div class="table-wrapper applettable">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <th> # </th>
                <th> Activity </th>
                <th> Date and Time</th>
                <th> Reference </th>
                <th> Notes </th>
            </thead>
            <tbody>
                <?php
                    if (count($data) > 0) {
                        foreach($data as $d) {
                            if ($d->status == 2) {
                                echo "<tr>";
                                    echo "<td>1</td>";
                                    echo "<td class='intablink' 
                                            data-toggle='modal' 
                                            data-target='#activityview' 
                                            data-tab='activityview' data-id='{$d->taskid}'>{$d->activity}</td>";
                                    echo "<td>".date("M. d, Y | h:i A", strtotime($d->created_at))."</td>";
                                    echo "<td>{$d->reference}</td>";
                                    echo "<td>{$d->notes}</td>";
                                echo "</tr>";
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

        <div id="activityview" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Activity Information</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='intabviewspan'></span>
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