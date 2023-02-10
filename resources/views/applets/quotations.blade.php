<div class='dsibox pd-t-10 pd-b-10'>
    <div class="table-wrapper applettable">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <th> DOC # </th>
                <th> status </th>
                <th> Description </th>
                <th> Sales + tax </th>
                <th> Profit </th>
                <th> GP% </th>
                <th> Contact </th>
                <th> Created by </th>
                <th> Quoted </th>
            </thead>
            <tbody>
                <?php 
                 $grandtotal  = 0;
                 $docscount   = 0;
                 $grandprofit = 0;
                 $grandgp     = 0;
                    if (count($data) > 0) {
                        foreach($data as $d) {

                            $total = 0;
                            $qtstatus = null;
                            if ($d->status <= 2) {
                                $qtstatus = "Quote";
                            } else if ($d->status == 3) {
                                $qtstatus = "Order";
                            } else if ($d->status == 4) {
                                $qtstatus = "Sales";
                            } else if ($d->status == 5) {
                                $qtstatus = "Invoice";
                            }

                            $total = $d->subtotal+$d->tax;

                            
                            echo "<tr>";
                                echo "<td class='compname'><a href='".url("quotes")."/{$d->custidfk}/{$d->quoteid}' target='_blank'>QT-{$d->quoteid}</a></td>";
                                echo "<td>{$qtstatus}</td>";
                                echo "<td>{$d->quotationname}</td>";
                                echo "<td>".number_format($total,2)."</td>";
                                echo "<td>".number_format($d->profit,2)."</td>";
                                echo "<td>".number_format($d->gp,2)."%</td>";
                                echo "<td>{$d->contactname}</td>";
                                echo "<td>{$d->name}</td>";
                                echo "<td>".date("M. d, Y", strtotime($d->created_at))."</td>";
                            echo "</tr>";

                            $grandtotal  = ($grandtotal+$total);
                            $grandprofit = ($grandprofit+$d->profit);
                            $grandgp     = ($grandgp+$d->gp);
                            $docscount++;
                        }
                    }
                ?>
            </tbody>
        </table>
        <div style="border-top: 1px solid #ccc;margin-top: 10px;" class="pd-t-10 removepmarg">
            <div class='row'>
                <div class='col-md-3'>
                    <p> Docs </p>
                    <p class='dsitxt'> <?php echo $docscount; ?> </p>
                </div>
                <div class='col-md-3'>
                    <p> Total </p>
                    <p class='dsitxt'> <?php echo number_format($grandtotal,2); ?> </p>
                </div>
                <div class='col-md-3'>
                    <p> Profit </p>
                    <p class='dsitxt'> <?php echo number_format($grandprofit,2); ?> </p>
                </div>
                <div class='col-md-3'>
                    <p> GP% </p>
                    <p class='dsitxt'> 
                        <?php 
                            if ($docscount == 0) {
                                echo "0%";
                            } else {
                                echo number_format($grandgp/$docscount,2)."%"; 
                            }
                        ?> 
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- <div id="viewquotemenue" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"> Menu</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <a class='btn btn-default' target='_blank' href="<?php //echo route('quotes')."/11"; ?>"> <i class="icon ion-arrow-expand"></i> View </a>
                    <a class='btn btn-default' href='#'> <i class="icon ion-loop"></i> Use </a>
                    <a class='btn btn-default' href='#'> <i class="fa fa-download"></i> Download </a>
                    <a class='btn btn-default' href='#'> <i class="fa fa-tags"></i> to Order </a>
                    <button class='dsibutton'> <i class="fa fa-send"></i> Send </button>
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