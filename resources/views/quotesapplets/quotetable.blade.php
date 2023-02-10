<?php
    if (count($quotesinformation) > 0) {
        $count  = 1;
        $idname = null;
        foreach($quotesinformation as $q) {
            $idname = "id_".$q->quoteitemid;
            echo "<tr>";
                echo "<td><input type='checkbox' class='qtcheckbox' value='{$q->quoteitemid}'/></td>";
                echo "<td data-id='{$q->quoteitemid}'>{$count}</td>";
                echo "<td class='' id='profit_{$idname}' data-idname='{$idname}' data-fld='profit' data-id='{$q->quoteitemid}' data-cont='{$q->profit}' >".number_format($q->profit,2)."</td>";
                echo "<td class='editdataqt' id='markup_{$idname}'  data-idname='{$idname}' data-fld='markupvalue' data-id='{$q->quoteitemid}' data-cont='{$q->markupvalue}' >{$q->markupvalue}</td>";
                echo "<td class='editdataqt' id='itemcost_{$idname}' data-idname='{$idname}' data-fld='itemcost' data-id='{$q->quoteitemid}' data-cont='{$q->itemcost}' >".number_format($q->itemcost,2)."</td>";
                echo "<td class='editdataqt' id='suppname_{$idname}' data-idname='{$idname}' data-fld='suppname' data-id='{$q->quoteitemid}' data-cont='{$q->suppname}' >{$q->suppname}</td>";
                echo "<td class='editdataqt' id='supppart_{$idname}' data-idname='{$idname}' data-fld='supppart' data-id='{$q->quoteitemid}' data-cont='{$q->supppart}' >{$q->supppart}</td>";
                echo "<td class='editdataqt' id='manuname_{$idname}' data-idname='{$idname}' data-fld='manuname' data-id='{$q->quoteitemid}' data-cont='{$q->manuname}' >{$q->manuname}</td>";
                echo "<td class='editdataqt' id='manupart_{$idname}' data-idname='{$idname}' data-fld='manupart' data-id='{$q->quoteitemid}' data-cont='{$q->manupart}' >{$q->manupart}</td>";
                echo "<td class='editdataqt' id='itemdesc_{$idname}' data-idname='{$idname}' data-fld='itemdesc' data-id='{$q->quoteitemid}' data-cont='{$q->itemdesc}' >{$q->itemdesc}</td>";
                echo "<td class='editdataqt' id='qty_{$idname}' data-idname='{$idname}' data-fld='qty' data-id='{$q->quoteitemid}' data-cont='{$q->qty}' >{$q->qty}</td>";
                echo "<td id='price_{$idname}' data-idname='{$idname}' data-id='{$q->quoteitemid}'>".number_format($q->price,2)."</td>";
                echo "<td id='extended_{$idname}' data-idname='{$idname}' data-id='{$q->quoteitemid}'>".number_format($q->extended,2)."</td>";
                
                echo "<td style='text-align:center;'>";
                    if ($q->taxable == "1") {
                        echo "<input type='checkbox' class='istaxable' data-id='{$q->quoteitemid}' checked>";
                    } else {
                       echo "<input type='checkbox' class='istaxable' data-id='{$q->quoteitemid}'>";
                    }
                echo "</td>";
            echo "</tr>";
            $count++;
        }
    }
?>