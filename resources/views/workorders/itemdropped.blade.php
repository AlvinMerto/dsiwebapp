<div class="table-wrapper applettable pd-t-10 pd-b-10">
                        <table id="itemdropped" class="table display responsive nowrap">
                            <thead>
                                <th> Item </th>
                                <th> Serial Number </th>
                                <th> Notes </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th> test Item </th>
                                    <td class='compname'> <a href='#'>SN-ksjl-ij23</a></td>
                                    <td>This is a first note</td>
                                </tr>
                                <tr>
                                    <th> test Item 2</th>
                                    <td class='compname'> <a href='#'>SN-892kd-9234j</a></td>
                                    <td>This is a second note</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    
<script>
     $('#itemdropped').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
     });
</script>