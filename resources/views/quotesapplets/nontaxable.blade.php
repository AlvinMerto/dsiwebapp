                        <div class="table-wrapper applettable">
                            <table id="insertitemtbl" class="table display responsive nowrap">
                                <thead>
                                    <th> &nbsp; </th>
                                    <th> Markup </th>
                                    <th> Cost </th>
                                    <th> Item Code </th>
                                    <th> Description </th>
                                    <th> Sell Price </th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (count($data) > 0) {
                                            foreach($data as $d) {
                                                echo "<tr>";
                                                    echo "<td><input type='checkbox'/></td>";
                                                    echo "<td>".$d[0]."</td>";
                                                    echo "<td>".$d[1]."</td>";
                                                    echo "<td>".$d[2]."</td>";
                                                    echo "<td>".$d[3]."</td>";
                                                    echo "<td>".$d[4]."</td>";
                                                echo "</tr>";
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