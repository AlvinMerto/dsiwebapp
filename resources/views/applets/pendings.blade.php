<div class="table-wrapper applettable">
        <!-- <button class='dsibutton intablink dsitext' 
                data-tab='schedule' 
                data-id='<?php //echo $data[0]->id; ?>' 
                data-toggle='modal' 
                data-viewspan = "scheduleactivityspan"
                data-target='#scheduletaskdivbox'> Schedule a task </button> -->

        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <th> # </th>
                <th> Activity </th>
                <th> Date </th>
                <th> Reference </th>
                <th> Note </th>
            </thead>
            <tbody>
                <?php 
                    if (count($data) > 0) {
                        $count = 1;
                        foreach($data as $d) {
                            if ($d->status == 1) {
                                echo "<tr>";
                                    echo "<td>{$count}</td>";
                                    echo "<td class='intablink' 
                                            data-toggle='modal' 
                                            data-target='#modalpopupview' 
                                            data-tab='viewpending' 
                                            data-id='{$d->taskid}'>{$d->activity}</td>";
                                    echo "<td>".date("M. d, Y", strtotime($d->taskdatetime))."</td>";
                                    echo "<td>{$d->reference}</td>";
                                    echo "<td>{$d->notes}</td>";
                                echo "</tr>";
                            }
                            $count++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

        <!-- <div id="pendingview" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Task Information</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='intabviewspan'>  </span>
                </div>
              </div>
            </div>
        </div> -->

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