<div class="table-wrapper applettable pd-t-10 pd-b-10">
                            <table id="insertitemtbl" class="table display responsive nowrap">
                                <thead>
                                    <th> # </th>
                                    <th> Markup </th>
                                    <th> Cost </th>
                                    <th> Item Name </th>
                                    <th> Description </th>
                                    <!-- <th> Sell Price </th> -->
                                </thead>
                                <tbody>
                                    <?php 
                                        if (count($theitems) > 0) {
                                            $count = 1;
                                            foreach($theitems as $d) {
                                                echo "<tr>";
                                                    echo "<td>{$count}</td>";
                                                    echo "<td>{$d->markup}</td>";
                                                    echo "<td>{$d->itemprice}</td>";
                                                    echo "<td class='dsitxt addthisitem' data-itemid='{$d->itemid}'>{$d->itemname}</td>";
                                                    echo "<td>{$d->description}</td>";
                                                echo "</tr>";
                                                $count++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
    
        <script>
            $("#insertitemtbl").DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                }
            });
        </script>