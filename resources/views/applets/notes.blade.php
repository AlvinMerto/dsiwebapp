<div class='dsibox appletnavs pd-b-10'>

    <div id="dsieditor"></div>
</div>
<div class='pd-t-10 flex'> 
    <button class='dsibutton' id='savenote' data-toggle='modal' data-target='#savenotemenu'> Save </button> &nbsp;
    <button class='btn btn-default tabs' data-tabname='allnotes' 
            data-id = "<?php echo $custid; ?>" data-doctitle='| All Notes'> View all Notes </button>
</div>

<!--create new record-->
        <div id="savenotemenu" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Note Option</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    
                  </button>
                </div>
                <div class="modal-body pd-l-25 pd-r-25">
                    <div class='pd-t-10 pd-b-10'>
                        <table class='tabtable'>
                            <tr>
                                <td> Reference </td>
                                <td> <input type='text' class='dsitxtbox' id='referencebox'/> </td>
                            </tr>
                            <tr>
                                <td> Label </td>
                                <td> 
                                    <input type='text' class='dsitxtbox' id='labelnote'/>
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
                        </table>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button class='dsibutton proceedsavenote' 
                    data-custid="<?php echo $custid; ?>" 
                    data-groupid="<?php echo $groupid; ?>"> Save </button>
                </div>
              </div>
            </div>
        </div>


<script>
    $('#dsieditor').summernote({
    height: 300,
    width:'100%'
    });
</script>