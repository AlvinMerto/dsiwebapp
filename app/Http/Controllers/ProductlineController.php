<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productline;

use DB;
use Auth;

class ProductlineController extends Controller
{
    //

    function productline($grpcode = false, $action = false) {
        $data = DB::select(DB::raw(
            "select * from productlines group by thegrpid"
        ));

        if (isset($_POST['newmarkupbtn'])) {
            $thepline = [
                "theproductline" => $_POST['productlinename'],
                "minimummarkup"  => $_POST['markupvalue'],
                "iscustom"       => $_POST['iscustom'],
                "thegrpid"       => $grpcode,
                "status"         => "1",
                "inputby"        => Auth::id()
            ];

            $productline = Productline::create($thepline);
        }

        $markups = null;

        if ($grpcode != false) {
            $markups = Productline::where("thegrpid",$grpcode)->get();
        }

        $newgrpid = md5(md5(md5(date("mdYhisA"))));
        return view("productline", compact("data","markups","grpcode","newgrpid"));
    }
}
