<?php 
namespace App\classes\Dsiclass;

use App\Models\contactfluidtbl;

class Dsiclass {
    public static function savetocontacthistory($details) {
        return contactfluidtbl::create($details);
    }
}

?>