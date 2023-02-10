<x-app-layout>
    @section("title","List of Quotes")
   <div class="br-mainpanel pd-30">
        <div class='bgwhite'>
            <div class='dsibox pd-t-15 pd-b-15'>
                <div class='col-md-5 flex pd-l-20'>
                    <h5 class='pageh'> All Quotations </h5> 
                </div>
            </div>
                    <div class="table-wrapper applettable pd-20">
                        <table id="datatable1" class="table display responsive nowrap">
                            <thead>
                                <th> # </th>
                                <th> Quote ID </th>
                                <th> Company </th>
                                <th> Price </th>
                                <th> Quoted Date </th>
                                <th> Status </th>
                            </thead>
                            <tbody>
                                <?php 
                                    if (count($allquotes) > 0) {
                                        foreach($allquotes as $aq) {
                                            echo "<tr>";
                                                echo   "<th> 1 </th>";
                                                echo   "<td class='compname'> <a href='".route('quotes')."/{$aq->id}/{$aq->quoteid}' target='_blank'>QT-{$aq->quoteid}</a></td>";
                                                echo   "<td> {$aq->companyname} </td>";
                                                echo   "<td> ". number_format($aq->total,2)."</td>";
                                                echo   "<td> ". date("M. d, Y", strtotime($aq->quotedate)) ."</td>";
                                                echo   "<td>";
                                                    if ($aq->status <= "2") {
                                                        echo "Quotation";
                                                    } else if ($aq->status == "3") {
                                                        echo "Invoice";
                                                    } else if ($aq->status == "4") {
                                                        echo "Sales";
                                                    } else if ($aq->status == "5") {
                                                        echo "Cancelled";
                                                    }
                                                echo "</td>";
                                            echo   "</tr>";
                                        }
                                    }
                                ?>
                                <!-- <tr>
                                    <th> 1 </th>
                                    <td class='compname'> <a href="{{route('quotes')}}/1">QT-98204</a></td>
                                    <td> Trabajob </td>
                                    <td> 12,904,459.00 </td>
                                    <td> January 1, 2023</td>
                                    <td> Order</td>
                                </tr>
                                <tr>
                                    <th> 2 </th>
                                    <td class='compname'> <a href="{{route('quotes')}}/1"> QT-8424</a></td>
                                    <td> ABC Incorporated </td>
                                    <td> 457,925.00 </td>
                                    <td> January 5, 2023</td>
                                    <td> Invoice </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
        </div>
    </div>
</x-app-layout>

