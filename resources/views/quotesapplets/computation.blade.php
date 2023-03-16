<table class='computationtable'>
    <tbody>
        <tr> 
            <th> Profit </th>
            <th> GP% </th>
            <th> Cost </th>
            <th> Subtotal </th>
            <th> Tax </th>
            <th> Tax Used </th>
            <th> Total </th>
        </tr>
        <tr> 
            <td> <?php echo number_format($values['Profit'],2); ?> </td>
            <td> <?php echo number_format($values['GP'],2)."%"; ?> </td>
            <td> <?php echo number_format($values['Cost'],2); ?> </td>
            <td> <?php echo number_format($values['Subtotal'],2); ?> </td>
            <td> <?php echo number_format($values['Tax'],2); ?> </td>
            <td> <?php echo $values['taxpercent']."%"; ?> </td>
            <td> <?php echo number_format($values['Total'],2); ?> </td>
        </tr>
    </tbody>
</table>
