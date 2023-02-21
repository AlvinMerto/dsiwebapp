<div class='row'>
                        <div class='col-md-12 '>
                            <div class='dsibox pd-t-0 pd-b-15'>
                                <p> <strong> <?php echo $data[0]->itemdesc; ?> </strong> </p>
                                <small style='font-size: 13px;'> <?php echo $data[0]->productline; ?> </small>
                                <p> <strong> <?php echo number_format($data[0]->itemcost,2); ?> </strong> <small style='font-size: 13px;'> x<?php echo $data[0]->qty; ?> </small> </p>
                            </div>
                        </div>
                        <!-- <div class='col-md-12 '>
                            <div class='dsibox pd-t-15 pd-b-15'>
                                <div class='flex spacebetween'>
                                    <p> Selling Price </p>
                                    <p> <strong> <?php //echo number_format($data[0]->price,2); ?> </strong> </p>
                                </div>
                                <div class='flex spacebetween'>
                                    <p> Shipping </p>
                                    <p> <strong> <?php //echo number_format($data[0]->shippingcost,2); ?> </strong> </p>
                                </div>
                            </div>
                        </div> -->
                        <div class='col-md-12 '>
                            <div class='dsibox pd-t-15 pd-b-15'>
                                <div class='flex spacebetween'>
                                    <p> Status </p>
                                    <!-- $datecreatd      = $q->updated_at;
                                    $expiry          = "+".$q->expnumber." ".$q->expunit;
                                    $datetocompare   = date("Y-m-d H:i:s A", strtotime($datecreatd . ' '.$expiry.' ')); -->
                                    <?php
                                        $hidethiscol = "hidethis";
                                        if ($data[0]->withexpiry == "1" || $data[0]->withexpiry == 1) {
                                            $removeexpbtn = null;
                                            $hidethiscol  = null;
                                            
                                            date_default_timezone_set("asia/manila");

                                            $compare   = date("Y-m-d H:i:s A", strtotime($data[0]->created_at.' +'.$data[0]->expnumber.' '.$data[0]->expunit));
                                            $datetoday = date("Y-m-d H:i:s A");
                                            
                                            if ($compare < $datetoday) {
                                                echo "<p style='color:red;'> <strong> Expired </strong>  </p>";
                                            } else {
                                                echo "<p> expires in: <strong>".date("M. d, Y h:i A", strtotime($data[0]->created_at.' +'.$data[0]->expnumber.' '.$data[0]->expunit))."</strong></p>";
                                            }
                                        } else {
                                            $hidethiscol  = "hidethis";
                                            $removeexpbtn = "hidethis";
                                            echo "<button class='btn btn-default' id='setexpirybtn'> <i class='fa fa-clock-o' aria-hidden='true'></i> Set Expiry </button>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-12 '>
                            <div class='dsibox pd-t-15 pd-b-15'>
                                <div class='flex spacebetween'>
                                    <p> Date Created</p>
                                    <p> <strong> <?php echo date("M. d, Y h:i A", strtotime($data[0]->created_at)); ?> </strong> </p>
                                </div>
                            </div>
                        </div>
                                    
                            <div class='col-md-12 expdivbox <?php echo $hidethiscol; ?>'>
                                <div class='dsibox pd-t-15 pd-b-15'>
                                    <div class='flex spacebetween'>
                                        <div class='pd-t-5'>
                                            <p> Expire after </p>
                                        </div>
                                        <div>
                                            <div class='flex spacebetween'>
                                                <input type='text' 
                                                        id ='numbertxtbox'
                                                        class='dsitxtbox expirytxtbox mg-r-5' 
                                                        style='text-align: center;'
                                                        value='<?php echo $data[0]->expnumber; ?>'
                                                        data-fld='expnumber' 
                                                        data-idfld='quoteitemid'
                                                        data-id='<?php echo $data[0]->quoteitemid; ?>'
                                                        data-tbl='quoteitemstbls' disabled='disabled'/>

                                                <select class='mg-r-5 dsitxtbox' id='freqselect' 
                                                        style='text-align: center;'
                                                        data-fld='expunit'
                                                        data-idfld='quoteitemid'
                                                        data-id='<?php echo $data[0]->quoteitemid; ?>'
                                                        data-tbl='quoteitemstbls' disabled='disabled'>
                                                    <option value='def'> Select </option>
                                                    <option value='hour'  <?php if ($data[0]->expunit == "hour") { echo "selected"; } ?>> Hours </option>
                                                    <option value='day'   <?php if ($data[0]->expunit == "day") { echo "selected"; } ?>> Days </option>
                                                    <option value='week'  <?php if ($data[0]->expunit == "week") { echo "selected"; } ?>> Weeks </option>
                                                    <option value='month' <?php if ($data[0]->expunit == "month") { echo "selected"; } ?>> Months </option>
                                                    <option value='year'  <?php if ($data[0]->expunit == "year") { echo "selected"; } ?>> Years </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-md-12 expdivbox <?php echo $hidethiscol; ?>'>
                                <div class='dsibox pd-t-15 pd-b-15' style='overflow:hidden;'>
                                    <div class='flex spacebetween'>
                                        <textarea class='dsitxtbox maxwidth expirytxtbox'
                                                data-fld='expnote' 
                                                data-idfld='quoteitemid'
                                                data-id='<?php echo $data[0]->quoteitemid; ?>'
                                                data-tbl='quoteitemstbls' disabled='disabled'><?php echo $data[0]->expnote; ?></textarea>
                                    </div>

                                    
                                        <p class='<?php echo $removeexpbtn; ?>' style="color: #fff;margin-top: 11px; cursor:pointer;text-align: center;background: red;border-radius: 99px;font-size: 13px;padding: 10px;" 
                                            id='removeexpiry'
                                            data-fld='withexpiry' 
                                            data-idfld='quoteitemid'
                                            data-id='<?php echo $data[0]->quoteitemid; ?>'
                                            data-tbl='quoteitemstbls'> Remove Expiry </p>
                                    
                                </div>
                            </div>

                            
                        

                        <div class='col-md-12'> 
                            <div class='flex dsibox pd-t-15 pd-b-15 spacebetween'>
                                <p class='pd-t-10 pd-b-10'> Other Information </p> 
                                <button class='btn btn-default btn-sm' id='addadditionalinfo'> <i class="fa fa-info-circle" aria-hidden="true"></i> Add other information </button>
                            </div>
                        </div>
                        <div class='col-md-12 hidethis' id='newinformationdiv'>
                            <div class='dsibox pd-t-10 pd-b-10'>
                                <input type='text' placeholder = 'Category' class='dsitxtbox mg-b-5' id='categorytxt'/>
                                <input type='text' placeholder = 'Reference' class='dsitxtbox mg-b-5' id='referencetxt'/>
                                <input type='text' placeholder = 'Value' class='dsitxtbox mg-b-5' id='valuetxt'/>
                                <button class='dsibutton' id='savethisnewinfo' data-itemgrpid='<?php echo $itemgrpid; ?>'> Save new information </button>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='flex dsibox pd-t-15 pd-b-15 spacebetween openwindow'>
                                <p> <strong> Supplier </strong> </p>
                                <p class='pd-l-20 pd-r-20'> <i class="fa fa-angle-down" aria-hidden="true"></i> </p>
                            </div>
                            <div class='referencevalues hidethis'>
                                <table class='dsitable'>
                                    <tr>
                                        <td> Supplier's Name: </td>
                                        <td> <strong> <?php echo $data[0]->suppname; ?> </strong> </td>
                                    </tr>
                                    <tr>
                                        <td> Supplier's Part # </td>
                                        <td> <strong> <?php echo $data[0]->supppart; ?> </strong> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='flex dsibox pd-t-15 pd-b-15 spacebetween openwindow'>
                                <p> <strong> Manufacturer </strong> </p>
                                <p class='pd-l-20 pd-r-20'> <i class="fa fa-angle-down" aria-hidden="true"></i> </p>
                            </div>
                            <div class='referencevalues hidethis'>
                                <table class='dsitable'>
                                    <tr>
                                        <td> Manufacturers Name: </td>
                                        <td> <strong> <?php echo $data[0]->manuname; ?> </strong> </td>
                                    </tr>
                                    <tr>
                                        <td> Manufacturer Part # </td>
                                        <td> <strong> <?php echo $data[0]->manupart; ?> </strong> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <?php
                            if (count($otherinfo) > 0) {
                                foreach($otherinfo as $oi) {
                                    echo "<div class='col-md-12 '>";
                                        echo "<div class=''>";
                                            echo "<div class='flex dsibox pd-t-15 pd-b-15 spacebetween openwindow'> ";
                                                echo "<p> <strong> {$oi->criteria} </strong> </p>";
                                                echo "<p class='pd-l-20 pd-r-20'> <i class='fa fa-angle-down' aria-hidden='true'></i> </p>";
                                            echo "</div>";
                                            echo "<div class='referencevalues hidethis'>";
                                                echo "<table class='dsitable'>";
                                                    echo "<tr>";
                                                        echo "<td> Reference </td>";
                                                        echo "<td> <strong> {$oi->reference} </strong> </td>";
                                                    echo "</tr>";
                                                    echo "<tr>";
                                                        echo "<td> Value </td>";
                                                        echo "<td> <strong> {$oi->thevalue} </strong> </td>";
                                                    echo "</tr>";
                                                echo "</table>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            }
                        ?>
                        <!-- <div class='col-md-12 dsibox pd-t-15 pd-b-15'>
                            <div class='flex spacebetween'>
                                <p> Local Store </p>
                                <p class='pd-l-20 pd-r-20'> <i class="fa fa-angle-down" aria-hidden="true"></i> </p>
                            </div>
                        </div> -->
                    </div> 