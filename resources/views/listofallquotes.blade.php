<x-app-layout>
    @section("title","List of Quotes")
   <div class="br-mainpanel pd-30">
        <div class='bgwhite'>
            <div class='dsibox pd-t-15 pd-b-15'>
                <div class='col-md-12 flex pd-l-20' style='justify-content:space-between;'>
                    <h5 class='pageh'> All Quotations </h5> 
                    <button class='dsibutton' data-toggle="modal" data-target='#newquotationdiv'> Create new Quotation </button>
                </div>
            </div>
                    <div class="table-wrapper applettable pd-20">
                        <table id="datatable1" class="table display responsive nowrap">
                            <thead>
                                <th> # </th>
                                <th> Quote ID </th>
                                <th> Company </th>
                                <th> Quotation Name </th>
                                <th> Price </th>
                                <th> Quoted Date </th>
                                <th> Status </th>
                            </thead>
                            <tbody>
                                <?php 
                                    if (count($allquotes) > 0) {
                                        $count = 0;
                                        foreach($allquotes as $aq) {
                                            echo "<tr>";
                                                echo   "<th>".++$count."</th>";
                                                echo   "<td class='compname'> <a href='".route('quotes')."/{$aq->id}/{$aq->quoteid}'>QT-{$aq->quoteid}</a></td>";
                                                echo   "<td> {$aq->companyname} </td>";
                                                echo   "<td> {$aq->quotationname} </td>";
                                                echo   "<td> ". number_format($aq->total,2)."</td>";
                                                echo   "<td> ". date("M. d, Y", strtotime($aq->quotedate)) ."</td>";
                                                echo   "<td>";
                                                    if ($aq->status == "0") {
                                                        echo "Subject for approval";
                                                    } else if ($aq->status == "1") {
                                                        echo "Quotation";
                                                    } else if ($aq->status == "2") {
                                                        echo "Quotation";
                                                    } else if ($aq->status == "3") {
                                                        echo "Order";
                                                    } else if ($aq->status == "4") {
                                                        echo "Sales";
                                                    } else if ($aq->status == "5") {
                                                        echo "Invoice";
                                                    } else if ($aq->status == "6") {
                                                        echo "Cancelled";
                                                    } else if ($aq->status == "7") {
                                                        echo "Expired";
                                                    } else if ($aq->status == "8") {
                                                        echo "Processed: P.O";
                                                    }
                                                echo "</td>";
                                            echo   "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
        </div>
    </div>
</x-app-layout>

        <div id="newquotationdiv" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Select Customer</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                    <div class="table-wrapper applettable">
                        <table id="datatable2" class="table display responsive nowrap">
                            <thead>
                                <th> # </th>
                                <th> Company Name </th>
                                <!-- <th> Status </th> -->
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    foreach($allcust as $a) {
                                        echo "<tr>";
                                            echo "<td>".$count++."</td>";
                                            // echo "<td class='compname'><a href='".url('')."/reroute/{$a->id}/new/quotes'>{$a->companyname}</a></td>";
                                            echo "<td class='compname'>";
                                                echo "<a href='".url('')."/quotes/{$a->id}/new'>{$a->companyname}</a>";
                                                // if ($a->interest == null) {
                                                //     echo "<a href='".url('')."/customer/{$a->id}'> {$a->companyname} </a>";
                                                // } else {
                                                //     echo "<a href='".url('')."/quotes/{$a->id}/new'>{$a->companyname}</a>";
                                                // }
                                            echo "</td>";
                                            // echo "<td>";
                                            //     if ($a->interest == null) {
                                            //         echo "Set the industry first";
                                            //     } else {
                                            //         echo null;
                                            //     }
                                            // echo "</td>";
                                            // echo "<td class='compname dsitxt' id='createnewquote' data-href='".url('')."/quotes/{$a->id}/new'>{$a->companyname}</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->

        <script>
            $('#datatable2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                }
            });
        </script>
        