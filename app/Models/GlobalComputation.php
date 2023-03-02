<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Productline;
use App\Models\QuotationCorner;
use App\Models\Quoteitemstbl;
use App\Models\AllowedUser;

use DB;
use Auth;

class GlobalComputation extends Model
{
    use HasFactory;

    public $unitcost;
    public $unitcostmarkup;
    public $totalunitcost;
    
    public $shipcostmarkup;
    public $shipcost;
    public $qty;
    
    public $istaxable;
    public $custint;

    public $profit;
    public $sellprice;
    public $extended;
    public $totalshipcost;
    
    public $withshipping = null;

    public function compute() {
        // compute for profit
        // compute for selling price
        // compute for extended price
        // compute total ship cost

        $this->totalunitcost = $this->unitcost*$this->qty;

        if ($this->unitcostmarkup > 0) {
            // compute the selling price with markup

            $per                 = (100/$this->unitcostmarkup);
            $addon               = $this->unitcost/$per;
            $this->sellprice     = $this->unitcost+$addon;

        } else {
            $this->sellprice     = $this->unitcost;
        }

        if ($this->withshipping != null) {
            // compute the selling price with shipping cost
            if ($this->shipcostmarkup > 0) {
                $shipper              = (100/$this->shipcostmarkup);
                $shipaddon            = $this->shipcost/$shipper;
            } else {
                $shipaddon            = 0;
            }

            $this->totalshipcost  = $this->shipcost+$shipaddon;

            $this->sellprice     = $this->sellprice+$this->totalshipcost;
        }

        if ((int) $this->custint == 2) { // private
            $grt             = ($this->sellprice*.05);
            $this->sellprice = ($this->sellprice+$grt);
        }
        
        $this->sellprice     = ceil($this->sellprice);
        $this->totalshipcost = ceil($this->totalshipcost);
        $this->extended      = ceil($this->sellprice*$this->qty);
        $this->profit        = ceil($this->extended)-$this->totalunitcost;
    }

    public static function getminimummarkup() {
        $markup      = DB::select(DB::raw(
            "SELECT min(minimummarkup) as minimum, thegrpid FROM `productlines` GROUP by thegrpid;"
        ));

        return $markup;
    }

    public static function checkminimummarkup($productlinegprid) {
        $markup      = DB::select(DB::raw(
            "SELECT min(minimummarkup) as minimummarkup, thegrpid FROM `productlines` where thegrpid = '{$productlinegprid}';"
        ));

        if (count($markup) > 0) {
            return $markup[0]->minimummarkup;
        } else {
            return false;
        }
    }

    public static function checkneedsapproval($grpidfk) { 
        // 0 = needs approval
        // 1 = normal status 
        // 3 = disapproved

        $items = Quoteitemstbl::where(["quoteidfk"=>$grpidfk,"status"=>"0"])->get();

        if (count($items) > 0) {
            return true;
        }

        return false;
    }

    public static function checkifhaveaccess($accountid, $table ,$thetableid) {
        $alloweddetails = AllowedUser::where(["table"=>$table,"idfk"=>$thetableid,"alloweduser"=>$accountid])->get("status");

        if (count($alloweddetails) > 0) {
            if ($alloweddetails[0]->status == "1" || $alloweddetails[0]->status == 1) {
                return true;
            }
        }
        
        return false;
    }

    public static function listofusers($table, $thetableid) {
        $haveaccess = DB::select(
            DB::raw("Select allowed_users.auid, users.name, users.email from allowed_users 
                    JOIN users on allowed_users.alloweduser = users.id
                    where allowed_users.table = '{$table}' and allowed_users.idfk = '{$thetableid}'")
        );

        if (count($haveaccess) > 0) {
            return $haveaccess;
        }

        return false;
    }
}
