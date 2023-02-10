                    <table class='dsismalltable removepmarg'>
                        <tr>
                            <td> Reference: </td>
                            <td> 
                                <?php 
                                    echo $notes[0]->reference;
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td> Author: </td>
                            <td> 
                                <?php 
                                    echo $notes[0]->name;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Date: </td>
                            <td> 
                                <?php 
                                    echo date("M. d, Y", strtotime($notes[0]->created_at));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Note: </td>
                            <td> 
                                <?php 
                                    echo $notes[0]->thenote;
                                ?>    
                            </td>
                        </tr>
                    </table>
<?php 
    if ($notes[0]->inputby == $viewer) { 
?>
    <div class='dsibox pd-t-10 pd-b-10'>
        <button class='btn btn-danger removeitem' data-idfld='noteid' data-tbl="notestbls" data-id=<?php echo $notes[0]->noteid; ?> > Remove </button>
    </div>

<?php } ?>