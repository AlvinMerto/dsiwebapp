<?php
    date_default_timezone_set("asia/manila");
    $datetoday  = date("Y-m-d H:i:s A");

    $islast = 0;

    if (count($quotesinformation) > 0) {
        $count  = 1;
        $idname = null;

        $subtotalprice          = 0;
        $subtotalextendedprice  = 0;
        $subtotalqty            = 0;
        $hassubtotal            = false;
        $displaysub             = false;
        $beginsub               = false;
        $displayedbegin         = false;
        $subtotalname           = null;
        $serving                = null;
        
        // has error            
        $haserror               = null;
        // end 

        $theerror               = null;
        foreach($quotesinformation as $q) {
            $theerror        = "";
            $haserror        = false;

            $datecreatd      = $q->created_at;
            $expiry          = "+".$q->expnumber." ".$q->expunit;
            $datetocompare   = date("Y-m-d H:i:s A", strtotime($datecreatd . ' '.$expiry.' '));

            $isexpired       = null;
            $title           = null;

            if($q->withexpiry == "1") {
                if ($datetoday > $datetocompare) {
                    $isexpired = "expireditem";
                    $title     = "EXPIRED";
                    $haserror  = true;

                    $theerror  .= "<p class='errortxt'> <span class='headtxtspan'> Validity: </span> 
                                       <span class='contenttxtspan'> EXPIRED </span> 
                                  </p>";
                }
            }

            $needsapproval = null;

            if ($q->status =="0") {
                $needsapproval = "needsapproval";
                
                if ($title != null) { $title .= " and "; }
                $title         .= "needs approval";

                $haserror   = true;
                $theerror  .= "<p class='errortxt'> <span class='headtxtspan'> Item Status: </span> 
                                   <span class='contenttxtspan'> NEEDS APPROVAL </span> 
                                </p>";
            }

            // allowed edit 
            $allowedclass       = "editdataqt";
            $allowedsubqtyclass = "allowedsubqty";
            if (!$allowed) {
                $allowedclass       = null;
                $allowedsubqtyclass = null;
            }
            // end 

            $hascomment = null;

            if (count($comments) > 0) {
                foreach($comments as $cs) {
                    if ($cs->quoteitemidfk == $q->quoteitemid) {
                        $hascomment = "hascomment";
                    }
                }
            }

            if ($q->subtotalidfk != null) {
                foreach($subtotals as $ss) {
                    if ($q->subtotalidfk == $ss->subtotalid) {
                        if ($serving == null) {
                            $serving         = $q->subtotalidfk;
                            $beginsub        = true;   
                            $hassubtotal     = true;
                        } else {
                            if ($serving == $ss->subtotalid) {
                                $beginsub        = false;
                            } else {

                                if ($subtotalprice !=0) {
                                    echo "<tr>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td colspan='3' style='text-align:right;color: #000;'> <strong> Subtotal end </strong> </td>";
                                        // echo "<td> &nbsp; </td>";
                                        echo "<td colspan='0' class='{$allowedsubqtyclass}' style='color: #000;' data-id='{$serving}'> <strong> {$subtotalname} </strong> </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";  
                                        echo "<td class='{$allowedsubqtyclass} align-center' style='color: #000;' data-id='{$serving}'> <strong> ".$subtotalqty." </strong> </td>";
                                        echo "<td style='color: #000;' class='align-right'> <strong>".number_format($subtotalprice,2)."</strong> </td>";
                                        echo "<td style='color: #000;' class='align-right'> <strong>".number_format($subtotalextendedprice,2)."</strong> </td>";
                                        
                                    echo "</tr>";
                                }

                                $subtotalname           = null;
                                $subtotalqty            = 0;
                                $subtotalprice          = 0;
                                $subtotalextendedprice  = 0;

                                $serving                = $q->subtotalidfk;
                                $beginsub               = true;
                                $hassubtotal            = true;
                            }
                        }

                        $subtotalname           = $ss->subtotalname;
                        $subtotalqty            = $ss->subtotalqty;
                        $totalprice_perline     = $q->price*$q->qty;
                        $subtotalprice          = $subtotalprice+$totalprice_perline;
                        $subtotalextendedprice  = $subtotalprice*$ss->subtotalqty;

                        //if ($q->price == 0 || $q->price )
                    } else {
                        // $beginsub = false;
                    }
                }
            } 
            else {
                if ($hassubtotal == true) {
                    $displaysub     = true;
                    $displayedbegin = false;
                    $beginsub       = false;
                     $hassubtotal    = false;

                    echo "<tr>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td colspan='3' style='text-align:right; color: #000;'> <strong> Subtotal end </strong> </td>";
                        // echo "<td> &nbsp; </td>";
                        echo "<td colspan='0' class='{$allowedsubqtyclass} align-left' style='color: #000;' data-id='{$serving}'> <strong> {$subtotalname} </strong> </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";                  
                        echo "<td style='color: #000;' class='{$allowedsubqtyclass} align-center' data-id='{$serving}'> <strong> ".$subtotalqty." </strong> </td>";
                        echo "<td style='color: #000;' class='align-right'> <strong> ".number_format($subtotalprice,2)."</strong> </td>";
                        echo "<td style='color: #000;' class='align-right'> <strong> ".number_format($subtotalextendedprice,2)."</strong> </td>";
                    echo "</tr>";

                }
            }

            $idname      = "id_".$q->quoteitemid;

            if ($beginsub) {

                    echo "<tr>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td colspan='3' style='text-align:right; color: #000;'>";
                            if ($allowed) {
                                echo "<i data-subtotalid='{$serving}' class='fa fa-times removesubtotal' aria-hidden='true'></i>";
                            }
                        echo "<strong> Subtotal Start </strong> </td>";
                        echo "<td colspan='9' style='text-align:left;'> 
                         </td>";
                    echo "</tr>";

                
            }

            $errorclass = null;
            if ($haserror) {
                $errorclass = "haserror";
            }

            echo "<tr class='' title='{$title}'>"; // {$isexpired} {$needsapproval}
                // echo "<td>".$datetoday." = ".$datetocompare."</td>";
                if ($allowed) {
                    echo "<td class='{$hascomment}'><input type='checkbox' class='qtcheckbox' value='{$q->quoteitemid}'/></td>";
                } else {
                    echo "<td class='{$hascomment}'><input type='checkbox' class='qtcheckbox' value='{$q->quoteitemid}'/></td>";
                    // echo "<td> &nbsp; </td>";
                }
                echo "<td class='align-center'>";
                    if ($haserror) {
                        echo "<i class='fa fa-exclamation-circle {$errorclass}' aria-hidden='true'></i>";
                    }
                echo "</td>";
                echo "<td class='align-center' data-id='{$q->quoteitemid}'>{$count}</td>";
                echo "<td class='align-right' style='padding:5px;' id='profit_{$idname}' data-idname='{$idname}' data-fld='profit' data-id='{$q->quoteitemid}' data-cont='{$q->profit}' >".number_format($q->profit,2)."</td>";
                echo "<td class='{$allowedclass} align-right' id='itemcost_{$idname}' data-idname='{$idname}' data-fld='itemcost' data-id='{$q->quoteitemid}' data-cont='{$q->itemcost}' >".number_format($q->itemcost,2)."</td>";
                echo "<td class='{$allowedclass} align-right' id='markup_{$idname}'  data-idname='{$idname}' data-fld='markupvalue' data-id='{$q->quoteitemid}' data-cont='{$q->markupvalue}' >".number_format($q->markupvalue,1)."</td>";
                echo "<td class='{$allowedclass} align-left' id='suppname_{$idname}' data-idname='{$idname}' data-fld='suppname' data-id='{$q->quoteitemid}' data-cont='{$q->suppname}' >{$q->suppname}</td>";
                echo "<td class='{$allowedclass} align-left' id='supppart_{$idname}' data-idname='{$idname}' data-fld='supppart' data-id='{$q->quoteitemid}' data-cont='{$q->supppart}' >{$q->supppart}</td>";
                echo "<td class='{$allowedclass} align-left' id='manuname_{$idname}' data-idname='{$idname}' data-fld='manuname' data-id='{$q->quoteitemid}' data-cont='{$q->manuname}' >{$q->manuname}</td>";
                echo "<td class='{$allowedclass} align-left' id='manupart_{$idname}' data-idname='{$idname}' data-fld='manupart' data-id='{$q->quoteitemid}' data-cont='{$q->manupart}' >{$q->manupart}</td>";
                echo "<td id='productline_{$idname} align-left' data-idname='{$idname}' data-fld='productline' data-id='{$q->quoteitemid}' data-cont='{$q->productline}' >{$q->productline}</td>";
                echo "<td class='{$allowedclass} align-left' id='itemdesc_{$idname}' data-idname='{$idname}' data-fld='itemdesc' data-id='{$q->quoteitemid}' data-cont='{$q->itemdesc}' style='width:fit-content;'>{$q->itemdesc}</td>";
                echo "<td class='{$allowedclass} align-right' id='shippingcost_{$idname}' data-idname='{$idname}' data-fld='shippingcost' data-id='{$q->quoteitemid}' data-cont='{$q->shippingcost}' >".number_format($q->shippingcost,2)."</td>";
                echo "<td class='{$allowedclass} align-right' id='shippingmarkup_{$idname}' data-idname='{$idname}' data-fld='shippingmarkup' data-id='{$q->quoteitemid}' data-cont='{$q->shippingmarkup}' >".number_format($q->shippingmarkup,1)."</td>";
                echo "<td id='shippingfinalprice_{$idname}' class='align-right' data-idname='{$idname}' data-fld='shippingfinalprice' data-id='{$q->quoteitemid}' data-cont='{$q->shippingfinalprice}' >".number_format($q->shippingfinalprice,2)."</td>";
                echo "<td class='{$allowedclass} align-center' id='qty_{$idname}' data-idname='{$idname}' data-fld='qty' data-id='{$q->quoteitemid}' data-cont='{$q->qty}' >{$q->qty}</td>";
                echo "<td id='price_{$idname}' class='align-right' data-idname='{$idname}' data-id='{$q->quoteitemid}'>".number_format($q->price,2)."</td>";
                echo "<td id='extended_{$idname}' class='align-right' data-idname='{$idname}' data-id='{$q->quoteitemid}'>".number_format($q->extended,2)."</td>";
                
                echo "<td style='text-align:center;'>";
                    if ($allowed) {                       
                            if ($q->taxable == "1") {
                                echo "<input type='checkbox' class='istaxable' data-id='{$q->quoteitemid}' checked>";
                            } else {
                                echo "<input type='checkbox' class='istaxable' data-id='{$q->quoteitemid}'>";
                            }
                        
                    } else {
                        //echo "<td>";
                            if ($q->taxable == "1") {
                                echo "<i class='fa fa-check' aria-hidden='true'></i>";
                            } else {
                                echo "&nbsp;";
                            }
                        //echo "</td>";
                    }
                echo "</td>";

                echo "<td style='width:fit-content;'> {$theerror} </td>";

            echo "</tr>";
            
            if ($haserror) {
                echo "<tr class='haserror_row' style='display:none;'>";
                    echo "<td colspan='20' class='align-left'> {$theerror} </td>";
                echo "</tr>";
            }

            if ($islast == count($quotesinformation)-1) {
                if ($hassubtotal) {
                    echo "<tr>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td colspan='3' style='text-align:right; color: #000;'> <strong> Subtotal end </strong> </td>";
                        // echo "<td> &nbsp; </td>";
                        echo "<td colspan='0' class='{$allowedsubqtyclass}' style='color: #000;' data-id='{$serving}'> <strong> {$subtotalname} </strong> </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";                  
                        echo "<td style='color: #000;' class='{$allowedsubqtyclass}' data-id='{$serving}'> <strong> ".$subtotalqty." </strong> </td>";
                        echo "<td style='color: #000;'> <strong> ".number_format($subtotalprice,2)."</strong> </td>";
                        echo "<td style='color: #000;'> <strong> ".number_format($subtotalextendedprice,2)."</strong> </td>";
                    echo "</tr>";
                }
            }

            if ($displaysub) {
                // reset everything after display
                $subtotalprice          = 0;
                $subtotalextendedprice  = 0;
                $hassubtotal            = false;
                $displaysub             = false;
                $beginsub               = false;
            }

            $count++;
            $islast++;
        }
    }
?>