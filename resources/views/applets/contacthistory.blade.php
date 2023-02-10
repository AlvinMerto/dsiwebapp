<style>
    .modal-dialog {
        max-width:100%;
    }
</style>
<div class='dsibox pd-b-10'>
   <button class='btn btn-default btn-sm intablink' data-tab='contacts' data-id="<?php echo $contactid; ?>"> back </button>
</div>

<div class="table-wrapper applettable pd-t-10">
        <table id="contacthistory" class="table display responsive nowrap">
            <thead>
                <th> # </th>
                <th> Updated at </th>
                <th> Updated Field </th>
                <th> previous Value </th>
            </thead>
            <tbody>
                <?php 
                    if (count($data) > 0) {
                        $count = 1;
                        foreach($data as $d) {
                            echo "<tr>";
                                echo "<td>{$count}</td>";
                                echo "<td>".date("M. d, Y", strtotime($d->created_at))."</td>";
                                echo "<td>{$d->thefield}</td>";

                                if ($d->thefield == "Company Name") {
                                    echo "<td class='dsitxt'><a href='".route("customer")."/".$d->thevalue."' target='_blank'>{$d->thevaluename}</a></td>";    
                                } else {
                                    echo "<td>{$d->thevalue}</td>";
                                }
                                
                            echo "</tr>";
                            $count++;
                        }
                    }
                ?>
                <!-- <tr>
                    <td>1</td>  
                    <td>January 2, 2023</td>
                    <td>Email Address</td>
                    <td>jay@gmail.com</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>January 1, 2023</td>
                    <td>Contact Number</td>
                    <td>01010101010</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>November 1, 2022</td>
                    <td>Address</td>
                    <td>381 - O Cebu City, Philippines</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>November 23, 2022</td>
                    <td>Company Connected</td>
                    <td>DSI Technology</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>October 1, 2022</td>
                    <td>Company Connected</td>
                    <td>Google Philippines</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>October 2, 2022</td>
                    <td>Contact Number</td>
                    <td>8888888888</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>November 1, 2022</td>
                    <td>Address</td>
                    <td>48 - B Cagayan De Oro City</td>
                </tr> -->
            </tbody>
        </table>
    </div>

    <script>
        $('#contacthistory').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
     });
    </script>