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
        
        foreach($quotesinformation as $q) {
            $datecreatd      = $q->created_at;
            $expiry          = "+".$q->expnumber." ".$q->expunit;
            $datetocompare   = date("Y-m-d H:i:s A", strtotime($datecreatd . ' '.$expiry.' '));

            $isexpired       = null;
            $title           = null;

            if($q->withexpiry == "1") {
                if ($datetoday > $datetocompare) {
                    $isexpired = "expireditem";
                    $title     = "EXPIRED";
                }
            }

            $needsapproval = null;

            if ($q->status =="0") {
                $needsapproval = "needsapproval";
                
                if ($title != null) { $title .= " and "; }
                $title         .= "needs approval";
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
                                        echo "<td colspan='2' style='text-align:right;color: #000;'> <strong> Subtotal end </strong> </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td colspan='0' class='{$allowedsubqtyclass}' style='color: #000;' data-id='{$serving}'> <strong> {$subtotalname} </strong> </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";
                                        echo "<td> &nbsp; </td>";  
                                        echo "<td class='{$allowedsubqtyclass}' style='color: #000;' data-id='{$serving}'> <strong> ".$subtotalqty." </strong> </td>";
                                        echo "<td style='color: #000;'> <strong>".number_format($subtotalprice,2)."</strong> </td>";
                                        echo "<td style='color: #000;'> <strong>".number_format($subtotalextendedprice,2)."</strong> </td>";
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
                    // $hassubtotal    = false;

                    echo "<tr>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td> &nbsp; </td>";
                        echo "<td colspan='2' style='text-align:right; color: #000;'> <strong> Subtotal end </strong> </td>";
                        echo "<td> &nbsp; </td>";
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
                        echo "<td colspan='2' 
                                style='text-align:right; color: #000;'> 
                                <i data-subtotalid='{$serving}' class='fa fa-times removesubtotal' aria-hidden='true'></i> <strong> Subtotal Start </strong> </td>";
                        echo "<td colspan='9' style='text-align:left;'> 
                         </td>";
                    echo "</tr>";

                
            }

            echo "<tr class='{$isexpired} {$needsapproval}' title='{$title}'>";
                // echo "<td>".$datetoday." = ".$datetocompare."</td>";
                if ($allowed) {
                    echo "<td class='{$hascomment}'><input type='checkbox' class='qtcheckbox' value='{$q->quoteitemid}'/></td>";
                } else {
                    echo "<td> &nbsp; </td>";
                }
                echo "<td data-id='{$q->quoteitemid}'>{$count}</td>";
                echo "<td class='' id='profit_{$idname}' data-idname='{$idname}' data-fld='profit' data-id='{$q->quoteitemid}' data-cont='{$q->profit}' >".number_format($q->profit,2)."</td>";
                echo "<td class='{$allowedclass}' id='itemcost_{$idname}' data-idname='{$idname}' data-fld='itemcost' data-id='{$q->quoteitemid}' data-cont='{$q->itemcost}' >".number_format($q->itemcost,2)."</td>";
                echo "<td class='{$allowedclass}' id='markup_{$idname}'  data-idname='{$idname}' data-fld='markupvalue' data-id='{$q->quoteitemid}' data-cont='{$q->markupvalue}' >".number_format($q->markupvalue,1)."</td>";
                echo "<td class='{$allowedclass}' id='suppname_{$idname}' data-idname='{$idname}' data-fld='suppname' data-id='{$q->quoteitemid}' data-cont='{$q->suppname}' >{$q->suppname}</td>";
                echo "<td class='{$allowedclass}' id='supppart_{$idname}' data-idname='{$idname}' data-fld='supppart' data-id='{$q->quoteitemid}' data-cont='{$q->supppart}' >{$q->supppart}</td>";
                echo "<td class='{$allowedclass}' id='manuname_{$idname}' data-idname='{$idname}' data-fld='manuname' data-id='{$q->quoteitemid}' data-cont='{$q->manuname}' >{$q->manuname}</td>";
                echo "<td class='{$allowedclass}' id='manupart_{$idname}' data-idname='{$idname}' data-fld='manupart' data-id='{$q->quoteitemid}' data-cont='{$q->manupart}' >{$q->manupart}</td>";
                echo "<td id='productline_{$idname}' data-idname='{$idname}' data-fld='productline' data-id='{$q->quoteitemid}' data-cont='{$q->productline}' >{$q->productline}</td>";
                echo "<td class='{$allowedclass}' id='itemdesc_{$idname}' data-idname='{$idname}' data-fld='itemdesc' data-id='{$q->quoteitemid}' data-cont='{$q->itemdesc}' >{$q->itemdesc}</td>";
                echo "<td class='{$allowedclass}' id='shippingcost_{$idname}' data-idname='{$idname}' data-fld='shippingcost' data-id='{$q->quoteitemid}' data-cont='{$q->shippingcost}' >".number_format($q->shippingcost,2)."</td>";
                echo "<td class='{$allowedclass}' id='shippingmarkup_{$idname}' data-idname='{$idname}' data-fld='shippingmarkup' data-id='{$q->quoteitemid}' data-cont='{$q->shippingmarkup}' >".number_format($q->shippingmarkup,1)."</td>";
                echo "<td id='shippingfinalprice_{$idname}' data-idname='{$idname}' data-fld='shippingfinalprice' data-id='{$q->quoteitemid}' data-cont='{$q->shippingfinalprice}' >".number_format($q->shippingfinalprice,2)."</td>";
                echo "<td class='{$allowedclass}' id='qty_{$idname}' data-idname='{$idname}' data-fld='qty' data-id='{$q->quoteitemid}' data-cont='{$q->qty}' >{$q->qty}</td>";
                echo "<td id='price_{$idname}' data-idname='{$idname}' data-id='{$q->quoteitemid}'>".number_format($q->price,2)."</td>";
                echo "<td id='extended_{$idname}' data-idname='{$idname}' data-id='{$q->quoteitemid}'>".number_format($q->extended,2)."</td>";
                
                if ($allowed) {
                    echo "<td style='text-align:center;'>";
                        if ($q->taxable == "1") {
                            echo "<input type='checkbox' class='istaxable' data-id='{$q->quoteitemid}' checked>";
                        } else {
                        echo "<input type='checkbox' class='istaxable' data-id='{$q->quoteitemid}'>";
                        }
                    echo "</td>";
                } else {
                    echo "<td>";
                        if ($q->taxable == "1") {
                            echo "<i class='fa fa-check' aria-hidden='true'></i>";
                        } else {
                            echo "&nbsp;";
                        }
                    echo "</td>";
                }
            echo "</tr>";
            
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
                        echo "<td colspan='2' style='text-align:right; color: #000;'> <strong> Subtotal end </strong> </td>";
                        echo "<td> &nbsp; </td>";
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