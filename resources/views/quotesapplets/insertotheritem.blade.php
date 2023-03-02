                    <table class='txtrightfirsttd'>
                        <tr>
                            <td> Type of item </td>
                            <td>
                                <select id='thetypeofitem' class='dsitxtbox'>
                                    <option> Select </option>
                                    <option value='Labor'> Labor </option>
                                    <option value='Freight'> Freight </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Markup Threshold </td>
                            <td> 
                                <select id='markuplineselect' class='dsitxtbox'>
                                    <option> Select </option>
                                        <?php 
                                            $custom = [];
                                            if (count($itemtype) > 0) {
                                                echo "<optgroup label='Markup threshold'> ";
                                                foreach($itemtype as $it) {
                                                    if ($it->iscustom == 1) {
                                                        array_push($custom, [$it->productlineid => $it->theproductline."_".$it->thegrpid]);
                                                    } else {
                                                        echo "<option value='{$it->productlineid}_0_{$it->thegrpid}'>{$it->theproductline}</option>";
                                                    }
                                                }
                                                echo "</optgroup>";

                                                if (count($custom) > 0) {
                                                    echo "<optgroup label='Custom Item'>";
                                                        foreach($custom as $key => $cs) {
                                                            foreach($cs as $k => $kk) {
                                                                $text  = explode("_",$kk)[0];
                                                                $grpid = explode("_",$kk)[1];
                                                                echo "<option value='{$k}_1_{$grpid}'>";
                                                                    echo $text;
                                                                echo "</option>";
                                                            }
                                                        }
                                                    echo "</optgroup>";
                                                }
                                            } 
                                        ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Markup </td>
                            <td>
                                <span id='markupselspan'> select from the item type... </span>
                            </td>
                        </tr>

                        <!-- enter labor -->
                            <tr class=''>
                                <td> Cost </td>
                                <td> <input type='text' class='dsitxtbox' id='costtxt'/> </td>
                            </tr>
                            <tr class='forlabor'>
                                <td> Enter Hours </td>
                                <td> <input type='text' class='dsitxtbox' id='qtytxt'/> </td>
                            </tr>
                            <tr class=''>
                                <td> Description </td>
                                <td> 
                                    <textarea class='dsitxtbox' id='itemdesc'></textarea> 
                                </td>
                            </tr>
                        <!-- end labor -->

                    </table>