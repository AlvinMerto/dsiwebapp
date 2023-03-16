<div class='dsibox pd-0'>
    <!-- <p> Some items are not within the specified markup value </p>     -->
    <input type='hidden' value='1' id='na'/>
    <button class='dsibutton' data-toggle='modal' data-target='#askforapprovaldiv'> Ask for Approval </button>
</div>

        <div id="askforapprovaldiv" class="modal fade" style='z-index: 10000000000000000;'>
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Ask for Approval<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class='dsibox'>
                        <table class='dsismalltable'>
                            <tr>
                                <td> Subject </td>
                                <td> <input type='text' class='dsitxtbox' id='thesubject'/> </td>
                            </tr>
                            <tr>
                                <td> Message </td>
                                <td> 
                                    <textarea class='dsitxtbox' id='themessage' style="width: 300px;min-height: 130px;"> </textarea>    
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class='pd-t-10 pd-b-10'>
                        <div class='flex'>
                            <button class='dsibutton' id='askforapproval'> Send Email </button>
                            <span id="messagestatus"></span>
                        </div>
                    </div>
                </div>

              </div>
            </div>
        </div>