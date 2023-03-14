<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@100;300&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
        <link href="{{ asset('lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <title> Quotation for <?php echo $data[0]->companyname; ?> </title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="font-family: 'Alegreya Sans', sans-serif; font-size: 1.1rem; background: #ccc;">
        <div class='custbigdiv pd-l-30 pd-r-30 pd-b-20'>
            <?php if($ispreview == false) { ?>
            <div class='leftfloatdiv'>
                <?php
                    switch($quotestatus) {
                        case "expired":
                            echo "<p class='expiredstatus'> EXPIRED </p>";    
                            break;
                        case "valid":
                            echo "<p class='validstatus'> VALID </p>";
                            break;
                        case "ORDERED":
                            echo "<p class='orderstatus'> ORDERED </p>";
                            break;
                    }
                ?>
                <!-- <p class='expiredstatus'>
                    
                </p> -->
                <div class='navigationdiv pd-l-15 pd-r-15 blacktext'>
                    <a href='https://dimensionsystems.com/' target="_blank"> <i class="fa fa-angle-right" aria-hidden="true"></i> &nbsp; Contact us </a> <br/>
                    <a href='#ouroffer'> <i class="fa fa-angle-right" aria-hidden="true"></i> &nbsp; Our Offer </a> <br/>
                    <a href='#termsandcondition'> <i class="fa fa-angle-right" aria-hidden="true"></i> &nbsp; Terms and Condition </a>
                </div> <?php // echo $quoteid; ?>
                <?php if ($quotestatus == "valid") { ?>
                    <p style='text-align: center; position: absolute;bottom: 0;width: 100%;'> 
                        <a href='#' data-toggle='modal' data-target='#acceptandsigndiv' class='acceptandsignbtn'> Accept and Sign </a> 
                    </p>
                <?php } ?>
            </div>
            <?php } ?>
            <!-- <div class='row' id='ouroffer'>
                <div class='col-md-12 custquoteheader' style="background-image:url('{{url('images/quotation_template_03.png')}}');padding: 79px 0px;background-repeat: no-repeat;">

                </div>
            </div> -->
            <div class='row pd-t-15 pd-b-15'>
                <div class='col-md-7'> 
                    <div class='removepmarg blacktext'>
				        <p> Quotation to: </p>
				        <p class='dsitxt'> <?php echo $data[0]->contactname; ?> </p>
				        <p> <?php echo $data[0]->title; ?> at <?php echo $data[0]->companyname; ?> </p>
				    </div>
                    <div class='mg-t-20 removepmarg blacktext'>
                        <p> Address: <strong> <?php echo $data[0]->address; ?>, <?php echo $data[0]->city; ?>, <?php echo $data[0]->country; ?>, <?php echo $data[0]->state; ?> </strong> </p>
                        <p> Phone: <strong> <?php echo $data[0]->contactnumber; ?> </strong> </p>
                        <p> Email: <strong> <?php echo $data[0]->email; ?>  </strong></p>
                    </div>
                </div>
                
                <div class='col-md-5'> 
                    <div>
                        <p class='quotestatus'> Quotation </p>
                        <div>
                            <div class='flex justit blacktext removepmarg'> 
                                <div class=''> <p> Quote ID: </p>  </div>
                                <div class=''> <p> QT-<?php echo $data[0]->quoteid; ?> </p>  </div>
                            </div>
                        </div>
                        <div>
                            <div class='flex justit blacktext removepmarg'> 
                                <div class=''> <p> Date </p> </div>
                                <div class=''> <p> <?php echo date("M. d, Y", strtotime($data[0]->quotedate)); ?> </p> </div>
                            </div>
                        </div>
                        <div>
                            <div class='flex justit blacktext removepmarg'> 
                                <div class=''> <p> Validity: </p> </div>
                                <div class=''> <p> <?php echo date("M. d, Y", strtotime($data[0]->quotevalidity)); ?> </p> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row mg-t-20'>
                <div class='col-md-12'>
                    <table class='custquotetbl'>
                        <tr>
                            <th> NO. </th>
                            <?php 
                                foreach($flds as $f) {
                                    echo "<th>";
                                        echo $fldname[$f];
                                    echo "</th>";
                                }
                            ?>   
                            <th> QTY </th>                         
                            <th> PRICE </th>                            
                            <th> TOTAL </th>
                        </tr>
                        <?php
                            if (count($data) > 0) {
                                $count        = 1;
                                $countttt     = 0;
                                $subtotalname = null;
                                $subtotalqty  = 0;
                                $subprice     = 0;
                                $subsubprice  = 0;
                                $ext          = 0;

                                foreach($data as $d) {
                                    if ($d->subtotalidfk != null) {
                                        
                                        if (in_array("showbreakdown",$sets)) {
                                            $displaytotal = false;

                                            foreach($subtotaltbl as $st) {
                                                if ($st->subtotalid == $d->subtotalidfk) {
                                                    $subtotalname = $st->subtotalname;
                                                    // $subtotalqty  = $subtotalqty+$d->qty;
                                                    $subtotalqty  = $st->subtotalqty;
                                                    $price        = $d->price*$d->qty;
                                                    $subprice     += $price;
                                                    $subsubprice  = $subsubprice+$subprice;
                                                }

                                                $ext = $subprice*$st->subtotalqty;
                                            }

                                            if (count($subtotaltbl) == $countttt) {
                                                $displaytotal = true;
                                            }
                                            
                                                if ($displaytotal) {
                                                    echo "<tr>";
                                                        echo "<td>";
                                                            echo $count;
                                                        echo "</td>";
                                                        echo "<td colspan='1'>";
                                                            echo $subtotalname."";
                                                        echo "</td>";
                                                        echo "<td colspan=''>";
                                                            echo $subtotalqty;
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo number_format($subprice,2);
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo number_format($ext,2);
                                                        echo "</td>";
                                                    echo "</tr>";

                                                    $subtotalname = null;
                                                    $subtotalqty  = 0;
                                                    $subprice     = 0;
                                                    $ext          = 0;

                                                }
                                            $countttt++;
                                        } else {
                                            echo "<tr>";
                                                echo "<td style='position: relative'>{$count}</td>";

                                                foreach($flds as $fs) {
                                                    $f = $fs;
                                                    echo "<td>";
                                                        if ($fs == "shippingfinalprice") {
                                                            echo number_format($d->$fs,2);
                                                        } else {
                                                            echo $d->$fs;
                                                        }
                                                    echo "</td>";
                                                }

                                                echo "<td>{$d->qty}</td>";
                                                echo "<td>".number_format($d->price,2)."</td>";
                                                echo "<td style='position:relative;'>".number_format($d->price,2);
                                                    if (in_array("withexpiry",$sets)) {
                                                        if ($d->withexpiry != null) {
                                                            $expiry = date("M. d, Y h:i A", strtotime($d->created_at." + ".$d->expnumber." ".$d->expunit));
                                                            echo "<div class='titlediv'>";
                                                                echo '<i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 9px;"></i>';    
                                                                // echo "&nbsp; {$d->expnote}";
                                                                echo "<span> price valid until {$expiry} </span>";
                                                            echo "</div>";
                                                        }
                                                    }
                                                echo "</td>";

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr>";  
                                            echo "<td style='position: relative'>{$count}</td>";
                                                
                                            foreach($flds as $fs) {
                                                $f = $fs;
                                                echo "<td>";
                                                    if ($fs == "shippingfinalprice") {
                                                        echo number_format($d->$fs,2);
                                                    } else {
                                                        echo $d->$fs;
                                                    }
                                                echo "</td>";
                                            }
                                            // echo "<td>{$d->manupart}</td>";
                                            // echo "<td>{$d->itemdesc}</td>";
                                            echo "<td>{$d->qty}</td>";
                                            echo "<td>".number_format($d->price,2)."</td>";
                                            echo "<td style='position:relative;'>".number_format($d->price,2);
                                                if (in_array("withexpiry",$sets)) {
                                                    if ($d->withexpiry != null) {
                                                        $expiry = date("M. d, Y h:i A", strtotime($d->created_at." + ".$d->expnumber." ".$d->expunit));
                                                        echo "<div class='titlediv'>";
                                                            echo '<i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 9px;"></i>';    
                                                            // echo "&nbsp; {$d->expnote}";
                                                            echo "<span> price valid until {$expiry} </span>";
                                                        echo "</div>";
                                                    }
                                                }
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    
                                    $count++;
                                }
                            } else {
                                echo "<tr> <td colpan=10> No data found </td> </tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div class='row '>
                <div class='col-md-7 pd-t-50 blacktext'> 
                    <!-- <p> Thank you very much. </p> -->
                </div>
                <div class='col-md-5'> 
                    <div>
                        <div>
                            <div class='flex justit grayit blacktext removeborder'> 
                                <div class='pd-t-10'> Subtotal: </div>
                                <div class='pd-t-10'> <?php echo number_format($data[0]->subtotal,2); ?>  </div>
                            </div>
                        </div>
                        <div>
                            <div class='flex justit grayit removeborder'> 
                                <div class='pd-t-10'> tax </div>
                                <div class='pd-t-10'> <?php echo number_format($data[0]->tax,2); ?> </div>
                            </div>
                        </div>
                        <div>
                            <div class='flex justit blackit removeborder'> 
                                <div class='pd-t-10'> Total: </div>
                                <div class='pd-t-10'> <?php echo number_format($data[0]->total,2); ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row mg-t-50'>
                <div class='col-md-7'>
                    
                </div>
                <div class='col-md-5'>
                    <center>
                        <div class='removepmarg blacktext'>
                            <p style='font-size:25px; text-transform:capitalize;'> <?php echo $data[0]->name; ?> </p>
                            <hr style='margin:0px;'/>
                            <p> Name and Signature </p>
                            <p> Sales Personnel </p>
                        </div>
                    </center>
                </div>
            </div>
            <!-- <div class='row mg-t-50'>
                <div class='col-md-12' style="background-image:url('{{url('images/bot_06.png')}}'); padding: 79px 0px 0px; background-repeat: no-repeat;">

                </div>
            </div> -->
        </div>
        <div class='custbigdiv' id='termsandcondition'>
            terms and condition
        </div>
        
        <div id="acceptandsigndiv" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Accept and Sign</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                    <form method='post' enctype="multipart/form-data">
                        @csrf
                    <table class='dsismalltable'>
                        <tr>
                            <td> <input type='email' class='dsitxtbox' placeholder='your@email.com' name='approveremail' style="width: 300px;"/> </td>
                        </tr>
                        <tr>
                            <td> <input type="submit" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" value='Sign' name='signbtn'/> </td>
                        </tr>
                    </table>
                    </form>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->

             <script src="{{asset('lib/jquery/jquery.js')}}"></script>
            <script src="{{asset('lib/popper.js/popper.js')}}"></script>
            <script src="{{asset('lib/bootstrap/bootstrap.js')}}"></script>
            <script src="{{asset('lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
            <script src="{{asset('lib/moment/moment.js')}}"></script>
            <script src="{{asset('lib/jquery-ui/jquery-ui.js')}}"></script>
            <script src="{{asset('lib/jquery-switchbutton/jquery.switchButton.js')}}"></script>
            <script src="{{asset('lib/peity/jquery.peity.js')}}"></script>
            <script src="{{asset('lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>
            <script src="{{asset('lib/d3/d3.js')}}"></script>
            
          <script src="{{asset('js/bracket.js')}}"></script>
    </body>
</html>