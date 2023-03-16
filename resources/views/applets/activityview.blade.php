<div class='pd-b-10'>
    <table class='dsianothertable'>
        <tr>
            <td> Activity </td>
            <td> 
                <?php 
                    echo $data[0]->activity;
                ?> 
            </td>
        </tr>
        <tr>
            <td> Contact </td>
            <td> 
                <?php 
                    echo $data[0]->contactname;
                ?> 
            </td>
        </tr>
        <tr>
            <td> Reference </td>
            <td id='taskreferenceactivity'>
                <?php 
                    echo $data[0]->reference;
                ?> 
            </td>
        </tr>
        <tr>
            <td> Date </td>
            <td>
                <?php 
                    echo date("M. d, Y @ h:i A", strtotime($data[0]->taskdatetime));
                ?> 
            </td>
        </tr>
        <tr>
            <td> Note </td>
            <td>
                <?php 
                    echo $data[0]->notes;
                ?> 
            </td>
        </tr>
        <tr>
            <td> Status </td>
            <td style='color:#37a000;'>
                COMPLETED
            </td>
        </tr>
    </table>
</div>

<div class='dsibox row'>
        <div class='col-md-12 retaskdiv pd-b-10 pd-t-10'>
                <input type='text' data-showid='noteshare' placeholder='Share with' class='notesharetxt dsitxtbox ' list='sharewith' data-groupid="<?php echo $data[0]->groupidfk; ?>"/>
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

<div class='pd-b-10 pd-t-10'>
    <p style='margin-bottom: 5px;'> Responses: </p>
    <table class='tblresponses'>
            <tbody>
                <?php 
                    if (count($replies) > 0) {
                        foreach($replies as $rp) {
                            echo "<tr>";
                                echo "<td> <p> ";
                                    echo "<strong class='dsitxt'> {$rp->name} </strong>";
                                    echo " | <small> ".date("M. d, Y @ h:i A", strtotime($rp->created_at) )." </small>";
                                echo "</p> ";
                                echo "<p>{$rp->thereply}</p></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                            echo "<td> No responses </td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
    </table>
</div>

<div class='pd-t-10'>
    <div class='row'>
        <div class='col-md-12'>
            <p style="margin-bottom:5px;font-weight: bold;color: #37a000;"> Your reply: </p>
            <div class='dsitxtbox' id = 'dsieditor'></div> 
        </div>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='flex'>
                <button class='dsibutton' 
                        id = "replybtnactivity"
                        data-groupid= "<?php echo $data[0]->groupidfk; ?>"
                        data-taskid = "<?php echo $data[0]->taskid; ?>"
                        data-custid = "<?php echo $data[0]->custid; ?>"
                        style='margin-top:10px;'> 
                        Reply </button> &nbsp;
                <button class='dsibutton' 
                        id = "retaskbutton"
                        data-custid = "<?php echo $data[0]->custid; ?>" 
                        data-groupidfk = "<?php echo $data[0]->groupidfk; ?>"
                        data-taskid = "<?php echo $data[0]->taskid; ?>"
                        style='margin-top:10px;'> Re-Task </button>
            </div>            
        </div>
    </div>
</div>

<script>
    $('#dsieditor').summernote({
        height: 200,
        width:'100%'
    });
</script>
