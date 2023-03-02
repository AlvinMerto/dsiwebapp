<?php
    $subdesc = null;
    $subqty  = null;

    if (count($data) > 0) {
        $subdesc = $data[0]->subtotalname;
        $subqty = $data[0]->subtotalqty;
    }
?>

<p class='mg-0'> Subtotal Description </p>
<textarea class='dsitxtbox mg-5' id='subtotdesc'><?php echo $subdesc; ?></textarea>

<p class='mg-0'> Subtotal Quantity </p>
<input type='number' class='dsitxtbox mg-5' id='subtotqty' value='<?php echo $subqty; ?>'/>

<button class='dsibutton mg-5' id='updatesubtotal' data-id='<?php echo $data[0]->subtotalid; ?>'> Update Subtotal </button>