<x-app-layout>
    @section('title',"All Orders")
    <div class=''>
        <div class="br-mainpanel pd-30">
            <div class='flex' style=''>
                <div>
                    <ul class='flex navigationuls'>
                        <li data-tab='waitingorders' class='selectednavli'> Waiting Orders </li>
                        <li data-tab='procorders'> Processed Orders </li>
                    </ul>
                </div>
                <div class='pd-t-5'>
                <button class='dsibutton' data-toggle='modal' data-target='#selectdate'> Create Weekly Orders by date </button> &nbsp;
                </div>
            </div>
            <div id = 'waitingorders' class='hidwindow bgwhite pd-t-10 pd-b-10 mg-b-5' style='display:block;'>
                <div class="table-wrapper pd-l-15 pd-r-15 dsitablesort">
                    <table id="waitingfororders" class="table display responsive nowrap ">
                        <thead>
                            <th> # </th>
                            <th> Customer Name </th>
                            <th> Quotation Name </th>
                            <th> Order Date </th>
                        </thead>
                        <tbody>
                            <?php
                                if (count($orderswaiting) > 0) {
                                    $count = 1;
                                    foreach($orderswaiting as $ow) {
                                        echo "<tr>";
                                            echo "<td>{$count}</td>";
                                            echo "<td>{$ow->companyname}</td>";
                                            echo "<td>{$ow->quotationname}</td>";
                                            echo "<td>".date("M. d, Y", strtotime($ow->orderdate))."</td>";
                                        echo "</tr>";
                                        $count++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id = 'procorders' class='hidwindow bgwhite pd-t-10 pd-b-10 mg-b-5'>
                <div class="table-wrapper pd-l-15 pd-r-15 dsitablesort">
                    <table id="processedorders" class="table display responsive nowrap ">
                        <thead>
                            <th> # </th>
                            <th> Weekly Order ID </th>
                            <th> Processed Date </th>
                            <th> Total Cost </th>
                        </thead>
                        <tbody>
                            <?php
                                if (count($processedorders) > 0) {
                                    $count = 1;
                                    foreach($processedorders as $pd) {
                                        echo "<tr>";
                                            echo "<td>{$count}</td>";
                                            echo "<td class='compname'><a href='".url('')."/processed/{$pd->bulkorderid}'>{$pd->bulkorderid}</a></td>";
                                            echo "<td>".date("M. d, Y", strtotime($pd->processeddate))."</td>";
                                            echo "<td>".number_format($pd->totalcost,2)."</td>";
                                        echo "</tr>";
                                        $count++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            </div>
        </div>
    </div>
</x-app-layout>

        <div id="selectdate" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document" style="width: 400px;">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Select Date</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                    <div class='dsibox removepmarg mg-b-10'>
                        <p> From </p>
                        <input type='date' class='dsitxtbox' id='fromdatetxt'/>
                    </div>
                    <div class='dsibox removepmarg'>
                        <p> To </p>
                        <input type='date' class='dsitxtbox' id='todatetxt'/>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" 
                    class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" 
                    id='findordersbtn'>Find Orders</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->


<script>
    $('#waitingfororders').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
     });

     $('#processedorders').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
     });
     
</script>