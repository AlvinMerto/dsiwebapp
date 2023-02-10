<div class='dsibox flex appletnavs pd-b-10'>
    <button class='btn btn-default' data-toggle='modal' data-target='#newprofile'> <i class="icon ion-plus"></i>&nbsp;Add New </button>
</div>
<div class='dsibox pd-t-10 pd-b-10'>
    <div class="table-wrapper applettable">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <th> # </th>
                <th> Profile </th>
                <th> Value </th>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td data-toggle='modal' class='intablink' data-target='#viewprofile' data-tab='profiles' data-id='2'>end of Subscription</td>
                    <td>January 1, 2022</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

        <div id="viewprofile" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Profile</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span id='intabviewspan'> </span>
                </div>
              </div>
            </div>
        </div>

        <div id="newprofile" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Profile</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <table class='dsismalltable'>
                            <tr>
                                <td> Profile Tag </td>
                                <td> 
                                    <select class='dsitxtbox'>
                                        <option> Autocad Serial No. </option>
                                        <option> Subscription Date </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> Value </td>
                                <td> <input type='text' class='dsitxtbox'/> </td>
                            </tr>
                            <tr>
                                <td> Share With </td>
                                <td>
                                    <input type='text' class='dsitxtbox' autoComplete="on" list="sharewith" id='textchangetxt'/>
                                        <datalist id='sharewith'>
                                            <option> All </option>
                                            <option> Jessica </option>
                                            <option> Melissa </option>
                                        </datalist>
                                </td>
                            </tr>
                            <tr>
                                <td> </td> <td> <p id='sharei' style='margin-top:5px; margin-bottom:0px;'> </p> </td>
                            </tr>
                            <tr>
                                <td> Note </td>
                                <td> <textarea class='dsitxtbox' class='dsitxtbox'></textarea> </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="dsibutton tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" id='savenewprofile'>Save Profile</button>
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

        $("#textchangetxt").on("blur", function(e) {
            if ($(this).val().length > 0) {
                $("<span class='sharewith'>"+$(this).val()+"</span>,")
                    .on("click", function(){
                        $(this).remove();
                    }).appendTo("#sharei");
                $(this).val("");
            }
        });
</script>