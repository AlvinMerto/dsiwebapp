<div class='dsibox pd-b-10'>
   <button class='btn btn-default btn-sm intablink' data-tab='contacts' data-id="<?php echo $contid; ?>"> back </button>
</div>
<div class='dsibox'>
    <div class="table-wrapper applettable">
        <table id="tbl1" class="table display responsive nowrap">
            <thead>
                <th> &nbsp; </th>
                <th> Company Name </th>
                <th> Contact Person </th>
            </thead>
            <tbody>
                <?php
                    if (count($data) > 0) {
                        foreach($data as $d) {
                            echo "<tr >";
                                echo "<th> <input type='radio' name='transferto' value='{$d->id}'/> </th>";
                                echo "<td class='dsitxt'> {$d->companyname} </td>";
                                echo "<td> {$d->contactperson} </td>";
                            echo "</tr>";
                        }
                    }
                ?>
                <!-- <tr>
                    <th> <input type='radio' name='transferto'/> </th>
                    <td class='compname'> <a href=''>ABC Company</a></td>
                    <td>Test Reference 1</td>
                </tr>
                <tr>
                    <th> <input type='radio' name='transferto'/> </th>
                    <td class='compname'> <a href=''> XYZ Incorporated </a></td>
                    <td>Testing Reference 2</td>
                </tr> -->
            </tbody>
        </table>
    </div>
</div>
<div class='dsibox pd-t-10 pd-b-10'>
    <button class='dsibutton transfertocompbtn' data-contid = "<?Php echo $contid; ?>"> Transfer to here </button>
</div>

<script>
    $('#tbl1').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
    });
</script>
