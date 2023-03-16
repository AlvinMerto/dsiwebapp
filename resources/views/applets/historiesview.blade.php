<div class='dsibox pd-b-10'>
    
    <table class='dsismalltable'>
        <?php 
            if (count($details) > 0) {
                $arr = (array) $details;
                
                foreach($arr as $key => $value) {
                    $arr1 = (array) $value;

                    foreach($arr1 as $k => $aa) {
                        $arr2 = (array) $aa;
                        
                        foreach($arr2 as $kk => $aaa) {
                            echo "<tr>";
                                echo "<td>";
                                    echo $kk;
                                echo "</td>";                            
                                echo "<td>{$aaa}</td>";
                            echo "</tr>";
                        }
                    }
                }
            }
        ?>
    </table>
</div>
<!-- <div class='pd-t-10'>
    <button class='dsibutton'> Complete </button>
    <button class='dsibutton'> Reply </button>
</div> -->