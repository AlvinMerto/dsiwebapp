                    <div class='dsibox'>
                        <table class='fullwidth removepmarg tbltoptd'> 
                            <tr>
                                <td colspan=2>
                                    <p> Activity </p>
                                    <select id='activity'>
                                        <optgroup label='Tasks'>
                                            <option> To do </option>
                                            <option> Call </option>
                                            <option> Meeting </option>
                                            <option> Follow-up </option>
                                            <option> Appointment </option>
                                            <option> Custom Task </option>
                                        </optgroup>
                                        <!-- <optgroup label='Apportunity'>
                                            <option> Scheduled Forecast </option>
                                        </optgroup> -->
                                    </select>
                                    <input type='text' id='customactivity' class='dsitxtbox' style='display:none;'/>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan=10 style='height:100%;' class='pd-r-15'>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Notes </p>
                                            <textarea class='dsitxtbox' style='min-height:290px;' id='thenotes'></textarea>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Contact </p>
                                            <select id='contactname'>
                                                <?php
                                                    if (count($customercontacts)>0) {
                                                        foreach($customercontacts as $cc) {
                                                            echo "<option value='{$cc->contid}'>{$cc->contactname}</option>";
                                                        }
                                                    } else {
                                                        echo "<optgroup label='No contacts'></optgroup>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Reference </p>
                                            <input type='text' class='dsitxtbox' id='reference'/>
                                        </div>
                                    </div>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Share With </p>
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
                                            <p id='noteshare' style='margin-top:5px; margin-bottom:0px;'> </p>
                                        </div>
                                    </div>
                                    <div class='row pd-t-5 pd-b-5'>
                                        <div class='col-md-12'>
                                            <p> Date </p>
                                            <input type='datetime-local' class='dsitxtbox' id='datetimetxt'/>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class='dsibox pd-t-10 pd-b-10'>
                        <button class='dsibutton' 
                                id = "completedactivitybtn" 
                                data-groupid='<?php echo $groupid; ?>' 
                                data-custid='<?php echo $custid; ?>'> Add Completed Activity </button>         
                    </div>