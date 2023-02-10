<div class='dsibox flex appletnavs pd-b-10'>
<button class="btn btn-default" data-toggle="modal" data-target="#addlink"> <i class="icon ion-plus"></i>&nbsp;Add New </button>
</div>

<div class="table-wrapper applettable pd-t-10">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <th> # </th>
                <th> Document Name </th>
                <th> Document Owner </th>
                <th> Notes </th>
                <th> Link </th>
            </thead>
            <tbody>
                <?php 
                    if (count($data) > 0) {
                        $count = 1;
                        foreach($data as $d) {
                            if ($d->status ==1){
                                echo "<tr>";
                                    echo "<td> {$count} </td>";
                                    echo "<td class='intablink' 
                                            data-toggle='modal' 
                                            data-target='#linkview' 
                                            data-tab='linkview' data-id='{$d->sourceid}'>{$d->documentname}</td>";
                                    echo "<td> {$d->name} </td>";
                                    echo "<td> {$d->notes} </td>";
                                    echo "<td> <a href='{$d->url}' target='_blank'>{$d->filename}</a></td>";
                                echo "</tr>";
                            }
                            $count++;
                        }
                    }
                ?>
                <!-- <tr>
                    <td>1</td>
                    <td class="intablink" data-toggle='modal' data-target='#linkview' data-tab='links' data-id='2'>Product</td>
                    <td> Alvin </td>
                    <td> Lorem ipsum dolor set amit </td>
                    <td> Alvin, Jessica</td>
                </tr> -->
                
            </tbody>
        </table>
    </div>

        <div id="linkview" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Link Information</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='intabviewspan'>  </span>
                </div>
              </div>
            </div>
        </div>

        <div id="addlink" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Link</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <table class='dsismalltable'>
                        <tr>
                            <td> Document Name </td>
                            <td>
                                <input type='text'class='dsitxtbox' id='documentname'/>
                            </td>
                        </tr>
                        <tr>
                            <td> Share With </td>
                            <td> 
                                <input type='text' data-showid='noteshare' class='notesharetxt dsitxtbox ' list='sharewith' data-groupid="<?php echo $groupid; ?>"/>
                                    <datalist id='sharewith'>
                                        <option value='all'> </option>
                                        <?php 
                                            if (count($users) > 0) {
                                                foreach($users as $u) {
                                                    echo "<option value='{$u->id}_{$u->name}'>{$u->name}</option>";
                                                }
                                            }
                                        ?>
                                    </datalist>
                            </td>
                        </tr>
                        <tr>
                            <td> </td> <td> <p id='noteshare' style='margin-top:5px; margin-bottom:0px;'> </p> </td>
                            </tr>
                        <tr>
                            <td> Notes </td>
                            <td>
                                <textarea class='dsitxtbox' id='linknote'></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td> Filename </td>
                            <td>
                                <input type='text' class='dsitxtbox' id='linkfilename'/>
                            </td>
                        </tr>
                        <tr>
                            <td> URL </td>
                            <td>
                                <!-- <input type='file' class='dsitxtbox'/> -->
                                <input type='url' class='dsitxtbox' id='linkurl'/>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class='modal-footer'>
                    <button class='dsibutton' id='savelinkbtn' 
                    data-groupid='<?php echo $groupid; ?>'
                    data-custid='<?php echo $custid; ?>'> Save </button>
                </div>
              </div>
            </div>
        </div>

    <script>
        $('#datatable1').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_',
            }
        });

        // $("#textchangetxt").on("blur", function(e) {
        //     if ($(this).val().length > 0) {
        //         $("<span class='sharewith'>"+$(this).val()+"</span>,")
        //             .on("click", function(){
        //                 $(this).remove();
        //             }).appendTo("#sharei");
        //         $(this).val("");
        //     }
        // });
     </script>