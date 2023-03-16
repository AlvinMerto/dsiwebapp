<x-app-layout>
    @section("title","{$title}")
    <div class=''>
        <div class="br-mainpanel pd-30">
            <div class='bgwhite pd-t-10 pd-b-10 mg-b-5'>
                <div class='col-md-12'>
                    <div class='flex' style='justify-content:space-between;'>
                        <div class='flex'>
                            <select id='suppliername' class="btn btn-default dsitxt dsitxtbox">
                                <option value='default'> All </option>
                                <optgroup label='Sort Vendor'>
                                    <?php 
                                        if (count($headers) > 0) {
                                            foreach($headers as $h) {
                                                $selected = null ;

                                                if($fromvendor == $h->suppname) {
                                                    $selected = "selected";
                                                }
                                                echo "<option {$selected}>{$h->suppname}</option>";
                                            }
                                        }
                                    ?>
                                </optgroup>
                            </select> &nbsp;
                            <?php if (isset($weeklyorder)) { ?>
                                <button class='dsibutton'> GENERATE&nbsp;P.O. </button>
                            <?php } ?>
                        </div>
                        <div class='flex'>
                            <?php if (!isset($weeklyorder)) { ?>
                                <button class='dsibutton' data-toggle='modal' data-target='#selectdate'> Select date </button> &nbsp;
                            <?php } ?>
                            <form method='post'>
                                @csrf
                                <input type='hidden' value='<?php echo $orderdate; ?>' id='theorderdate' name='orderdate'/>
                                <input type='hidden' value='<?php echo json_encode($qtidfks); ?>' name='qtidfks'/>
                                <?php if (isset($weeklyorder)) { ?>
                                    <div style="padding-left: 12px;border-left: 1px solid #ccc;margin-left: 12px;">
                                        <p class='mg-b-0'> <strong> Weekly order number:</strong> </p>
                                        <?php echo "<p class='mg-b-0' style='color: #a3a3a3;'>".$weeklyorder."</p>"; ?>
                                    </div>
                                <?php } else {?>
                                    <input type='submit' class='dsibutton' value='Generate Order ID' name='genweeklyid'/>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class='bgwhite pd-t-10 pd-b-10'>
                <div class='col-md-12 theordertable'>
                    <table class="orderstable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Vendor </th>
                                <th> Details </th>
                                <th style='width: 400px;'> Description </th>
                                <th> Qty </th>
                                <th> Unit Cost </th>
                                <!-- <th> Marked-Up Price</th> -->
                                <th> Extended Cost </th>
                                <th> Estimated S/H </th>
                                <th> Total Cost </th>
                            </tr>
                        </thead>
                        <?php
                        if (count($data)>0) { 
                        echo "<tbody>";
                                
                                        $count = 1;
                                        foreach($data as $d) {
                                            $theorderid = null;

                                            if (isset($d->theorderid)) {
                                                $theorderid = $d->theorderid;
                                            }

                                            echo "<tr>";
                                                echo "<td>{$count}</td>";
                                                echo "<td>{$d->suppname}</td>";
                                                echo "<td>view</td>";
                                                echo "<td>{$d->itemdesc}</td>";
                                                echo "<td>{$d->totalqty}</td>";
                                                echo "<td>".number_format($d->totalprice,2)."</td>";
                                               // echo "<td>".number_format($d->price,2)."</td>";
                                                echo "<td>".number_format($d->extendedprice,2)."</td>";
                                                // echo "<td>".var_dump($d->estimatedsh)."</td>";

                                                if ($funcfrom == "processed") {
                                                    $esttxtbox = null;
                                                    if ($d->estimatedsh == null) {
                                                        // echo "<td><input type='text' class='orderdsitxtbox' placeholder='0.00'/></td>";
                                                        $esttxtbox = "placeholder='0.00'";
                                                    } else {
                                                        $esttxtbox = "value='".number_format($d->estimatedsh,2)."'";
                                                    }
                                                    echo "<td>
                                                            <input  type='text' 
                                                                    class='orderdsitxtbox' 
                                                                    data-fld='estimatedsh' 
                                                                    data-idfld='theorderid'
                                                                    data-id='".$theorderid."'
                                                                    data-vendor='".$fromvendor."'
                                                                    data-affectid='total".$theorderid."'
                                                                    data-tbl='the_orders' {$esttxtbox}/>
                                                          </td>";
                                                    
                                                } else if ($funcfrom == "ordertable") {
                                                    echo "<td> 0.00 </td>";
                                                }

                                                if (isset($d->totalcost)) {
                                                    $total = $d->totalcost;
                                                } else {
                                                    $toadd = 0;
                                                    if ($funcfrom == "processed") {
                                                        $toadd = $d->estimatedsh;
                                                    }
                                                    $total  = $d->extendedprice+$toadd;
                                                }

                                                echo "<td id='total{$theorderid}'>".number_format($total,2)."</td>";
                                            echo "</tr>";
                                            $count++;
                                        }
                            if ($funcfrom == "processed") {  
                                $grpidorder = explode("/",$orderdate)[1];

                                echo "  <tr>
                                            <th colspan='6' style='text-align:right;' class='totaltxt dsitxt'> Total </th>
                                            <th class='totaltxt'> <strong>".number_format($totals['totalextendprice'],2)."</strong> </th>
                                            <th class='totaltxt' id='totalestimatedsh'> <strong>".number_format($totals['totalestimatedsh'],2)."</strong> </th>
                                            <th class='totaltxt' id='grandtotalcost'> <strong>".number_format($totals['totaltotalcost'],2)."</strong> </th>
                                        </tr>
                                        <tr>
                                        <th colspan='6' style='text-align:right;' class='totaltxt dsitxt'> Tax(%) </th>
                                            <th> <input type='text' class='grandtaxtxt' 
                                                        data-fld='tax' 
                                                        data-idfld='bulkorderid'
                                                        data-id='".$grpidorder."'
                                                        data-vendor='".$fromvendor."'
                                                        data-affectid='grandextendedcost'
                                                        data-tbl='the_orders'
                                                        value='{$data[0]->tax}'/> </th>
                                            <th> <input type='text' class='grandtaxtxt'
                                                        data-fld='estimatedshtax' 
                                                        data-idfld='bulkorderid'
                                                        data-id='".$grpidorder."'
                                                        data-vendor='".$fromvendor."'
                                                        data-affectid='grandestsh'
                                                        data-tbl='the_orders'
                                                        value='{$data[0]->estimatedshtax}'/> </th>
                                            <th> <input type='text' class='grandtaxtxt' 
                                                        data-fld='totalcosttax' 
                                                        data-idfld='bulkorderid'
                                                        data-id='".$grpidorder."'
                                                        data-vendor='".$fromvendor."'
                                                        data-affectid='gggrandtotalcost'
                                                        data-tbl='the_orders'
                                                        value='{$data[0]->totalcosttax}'/> </th>
                                        </tr>
                                        <tr>
                                     
                                        <th colspan='6' style='text-align:right;' class='totaltxt dsitxt'> Grand Total </th>
                                        <th class='totaltxt' id='grandextendedcost'>".number_format($totals['extcostwithtax'],2)."</th>
                                        <th class='totaltxt' id='grandestsh'>".number_format($totals['estshwithtax'],2)."</th>
                                        <th class='totaltxt' id='gggrandtotalcost'>".number_format($totals['totcostwithtax'],2)."</th>
                                    </tr>
                                        </tbody>";
                            } else if ($funcfrom == "ordertable") {
                                echo "<tr>
                                        <th colspan='6' style='text-align:right;' class='totaltxt dsitxt'> Total </th>
                                        <th class='totaltxt'> <strong>".number_format($totals['totalextendprice'],2)."</strong> </th>
                                        <th class='totaltxt' id='totalestimatedsh'> <strong>".number_format($totals['totalestimatedsh'],2)."</strong> </th>
                                        <th class='totaltxt' id='grandtotalcost'> <strong>".number_format($totals['totaltotalcost'],2)."</strong> </th>
                                      </tr>";
                            }
                        } else {
                            echo "<tbody>";
                                echo "<tr>";
                                    echo "<td colspan=10> no records found </td>";
                                echo "</tr>";
                            echo "</tbody>";
                        }
                        ?>
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