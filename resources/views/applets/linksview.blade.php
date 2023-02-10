<div class='dsibox pd-10'>
<table class='dsismalltable'>    
    <tbody>
        <tr>
            <td> Document Name </td>
            <td> <?php echo $alllinks[0]->documentname; ?> </td>
        </tr>
        <tr>
            <td> Document Owner </td>
            <td> <?php echo $alllinks[0]->name; ?> </td>
        </tr>
        <tr>
            <td> Notes </td>
            <td> <?php echo $alllinks[0]->notes; ?> </td>
        </tr>
        <tr>
            <td> Filename </td>
            <td> <a href='<?php echo $alllinks[0]->url; ?>' target='_blank'><?php echo $alllinks[0]->name; ?> </a> </td>
        </tr>
    </tbody>
</table>
</div>

<?php if ($alllinks[0]->inputby == $viewer) { ?>
<div class='dsibox pd-t-10 pd-b-10'>
    <button class='btn btn-danger removeitem' 
            data-tbl='linkstbls'
            data-id='<?php echo $alllinks[0]->sourceid; ?>'
            data-idfld ='sourceid'> Delete </button>
</div>
<?php } ?>