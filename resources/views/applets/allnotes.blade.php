    <div class="table-wrapper applettable dsibox pd-b-10">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <th> # </th>
                <th> Reference </th>
                <th> Label </th>
                <th> Date of Input </th>
                <th> Inputted By </th>
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
                                            data-target='#viewnote' 
                                            data-tab='viewnote' 
                                            data-id='{$d->noteid}'>{$d->reference}</td>";
                                    echo "<td> {$d->label} </td>";
                                    echo "<td>".date("M. d, Y", strtotime($d->created_at))."</td>";
                                    echo "<td>".$d->name."</td>";
                                echo "</tr>";
                            }
                            $count++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class='pd-t-10'>
        <button class='dsibutton tabs' data-tabname='notes' data-id='<?php echo $custid; ?>'> Add New Note </button>
    </div>

        <!--create new record-->
        <div id="viewnote" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Note</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-l-25 pd-r-25 pd-b-25">
                    <span id='intabviewspan'> </span>
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