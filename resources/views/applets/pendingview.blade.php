<div class='pd-b-10'>
    <table class='dsianothertable'>
        <tr>
            <td> Activity </td>
            <td> <?php echo $data[0]->activity; ?> </td>
        </tr>
        <tr>
            <td> Contact </td>
            <td> <?php echo $data[0]->contactname; ?> </td>
        </tr>
        <tr>
            <td> Reference </td>
            <td id='taskreference'> <?php echo $data[0]->reference; ?> </td>
        </tr>
        <!-- <tr>
            <td> Assigned to </td>
            <td> Alvin Merto </td>
        </tr> -->
        <tr>
            <td> Date </td>
            <td> <?php echo date("M. d, Y h:i A", strtotime($data[0]->taskdatetime)); ?> </td>
        </tr>
        <tr>
            <td> Note </td>
            <td> <?php echo $data[0]->notes; ?> </td>
        </tr>
        <tr>
            <td> Task status </td>
            <td style='color:red;'> INCOMPLETE </td>
        </tr>
    </table>
</div>
<div class='dsibox'>
    <p style="margin:0px; font-weight:bold;"> Responses </p>
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
            <p style="margin-bottom:5px;"> Reply to this task: </p>
            <div class='dsitxtbox' id = 'dsieditor' placeholder='The Tasks that you did'></div> 
            <div class='flex'>
                <button class='dsibutton' 
                        id = "replybtn" 
                        data-groupid= "<?php echo $data[0]->groupidfk; ?>"
                        data-taskid = "<?php echo $data[0]->taskid; ?>"
                        data-custid = "<?php echo $data[0]->custid; ?>"
                        style='margin-top:10px;'> Reply </button> &nbsp;
                <button class='dsibutton' 
                        id = "completebtn" 
                        data-groupid= "<?php echo $data[0]->groupidfk; ?>"
                        data-taskid = "<?php echo $data[0]->taskid; ?>"
                        data-custid = "<?php echo $data[0]->custid; ?>"
                        style='margin-top:10px;'> Mark as Complete </button>&nbsp;
                <button class='dsibutton' 
                        id = "replycompletebtn" 
                        data-groupid= "<?php echo $data[0]->groupidfk; ?>"
                        data-taskid = "<?php echo $data[0]->taskid; ?>"
                        data-custid = "<?php echo $data[0]->custid; ?>"
                        style='margin-top:10px;'> Reply and Complete </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#dsieditor').summernote({
        height: 150,
        width:'100%'
    })
</script>
