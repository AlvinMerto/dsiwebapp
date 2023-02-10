<table class='totaltable'>
    <?php  ?>
    <tbody>
        <tr>
            <td style='padding-bottom: 10px;'> <strong> Breakdown</strong> </td>
            <td> &nbsp;</td>
        </tr>
        <tr> 
            <td> Profit </td>
            <td> <?php echo number_format($values['Profit'],2); ?> </td>
        </tr>
        <tr> 
            <td> GP%  </td>
            <td> <?php echo number_format($values['GP'],2)."%"; ?> </td>
        </tr>
        <tr> 
            <td> Cost </td>
            <td> <?php echo number_format($values['Cost'],2); ?> </td>
        </tr>
        <tr> 
            <td> Subtotal </td>
            <td> <?php echo number_format($values['Subtotal'],2); ?> </td>
        </tr>
        <tr> 
            <td> Tax </td>
            <td> <?php echo number_format($values['Tax'],2); ?> </td>
        </tr>
        <tr> 
            <td> Tax Used </td>
            <td> <?php echo $values['taxpercent']."%"; ?> </td>
        </tr>
        <tr class='totaldiv'> 
            <td> Total </td>
            <td> <?php echo number_format($values['Total'],2); ?> </td>
        </tr>
    </tbody>
</table>
