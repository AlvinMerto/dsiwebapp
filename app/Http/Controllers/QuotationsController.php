<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Customerstbl;
use App\Models\QuotationCorner;
use App\Models\Quoteitemstbl;
use App\Models\Totalpricetbl;
use App\Models\taxationtbl;
use App\Models\markuptbl;
use App\Models\itemstbl;
use App\Models\contactstbl;

use DB;

class QuotationsController extends Controller
{
    function quotes(Request $req, $id = null, $quoteid = null) {
        if ($id == null) {
            $allquotes = DB::table("quotation_corners")
                            ->select("quotation_corners.quotedate","quotation_corners.quoteid","quotation_corners.status",
                                     "customerstbls.companyname","customerstbls.id",
                                     "totalpricetbls.total")
                            ->join("totalpricetbls", "quotation_corners.quoteid","=","totalpricetbls.quoteidfk")
                            ->join("customerstbls", "quotation_corners.custidfk","=","customerstbls.id")->get();
                            //->join("users","quotation_corners.custidfk","=","users.id")->get();

            return view("listofallquotes",compact("allquotes"));
        } else {
            $data      = customerstbl::where("id",$id)->get();
            $allcust   = customerstbl::all();
            $quotedets = null;

            if($quoteid == "new") {
                // create new quote :: 
                $qcorner = [
                    "custidfk"   => $id,
                    "quotedate"  => date("Y-m-d H:i:s"),
                    "quoteprice" => "0",
                    "inputby"    => Auth::id(),
                    "status"     => "1"
                ];

                $insertedid = QuotationCorner::create($qcorner);
                $quoteid    = $insertedid->quoteid;

                $tx         = taxationtbl::where(["custidfk"=>$id, "status" => "1"])->get("thetax");

                $thetax     = "12";

                if (count($tx) > 0) {
                    $thetax  = $tx[0]->thetax;
                }
                
                // create totalpricetbls 
                    $ddd  = [
                        "custidfk"      => $id,
                        "quoteidfk"     => $quoteid,
                        "taxpercentage" => $thetax,
                        "inputby"       => Auth::id(),
                        "status"        => "0"
                    ];

                    $tptbls     = Totalpricetbl::create($ddd);
                // end 
                
                return redirect("quotes/{$id}/$quoteid");
            } else {
                // retrieve the quotation's information
                // $quotedets = Totalpricetbl::where("quoteidfk",$quoteid)->get();
                $quotedets    = DB::table("totalpricetbls")
                                    ->select("totalpricetbls.*","users.name")
                                    ->join("users","totalpricetbls.inputby","=","users.id")
                                    ->where("totalpricetbls.quoteidfk",$quoteid)->get();
                
                $empdata      = DB::table("intereststbls")
                                    ->select("intereststbls.theinterest","intereststbls.interid")
                                    ->leftJoin("customerstbls","intereststbls.interid","=","customerstbls.interest")
                                    ->where("customerstbls.id",$id)->get();

                $overallqtdets = QuotationCorner::where("quoteid", $quoteid)->get();
                
                if (count($empdata) == 0) {
                    return back()->with('status', "You need to specify the company's interest to proceed.");
                }

                if (count($overallqtdets) > 0) {
                    if ( strtotime(date("Y-m-d")) > strtotime($overallqtdets[0]->quotevalidity) ) {
                        $updateqt      = QuotationCorner::where("quoteid", $quoteid)->update(["status"=>"7"]);
                        $overallqtdets = QuotationCorner::where("quoteid", $quoteid)->get();
                    }
                } 

                $contacts = contactstbl::where("custidfk", $id)->get(["contid","contactname"]);

                $categories   = DB::select(DB::raw("select distinct(category) from itemstbls"));
            }

            $percentage = markuptbl::all();

            return view("quotations", compact('data','allcust', 'quoteid','quotedets','percentage','empdata','categories','contacts','overallqtdets'));
        }
    }

    function taxable(Request $req) {
        // $data = [];
        if ($req->input("cats") == "false" || $req->input("cats") == false) {
            return false;
        } else {
            $theitems = itemstbl::where("category",$req->input("cats"))->get();
        }

        return view("quotesapplets.taxable", compact('theitems'));
    }

    function nontaxable(Request $req) {
        $data = [];
        if ($req->input("cats") == "false" || $req->input("cats") == false) {
            return false;
        } else {
            switch($req->input("cats")) {
                case "antivi":
                    $data = [
                            ["45%","45.00","A-CDR-l2k34","Karspersky","58.00"],
                            ["45%","123.00","A-CD-234lsdf","Nod-32","123.00"],
                        ];
                    break;
                case "mboard":
                        $data = [
                                ["45%","12,252.00","mboard-dg3","Samsung Motherboard","12,880.00"],
                                ["45%","8,900.00","mboard-dh3","Asus Motherboard","8,990.00"],
                            ];
                        break;
                case "ampl":
                        $data = [
                                ["45%","46,700.00","ampl-484hd","Amplifier 1","48,700.00"],
                                ["45%","56,290.00","ampl-934s","Amplifier 2","58,290.00"],
                            ];
                        break;  
            }
        }
        return view("quotesapplets.nontaxable", compact('data'));
    }

    function additem(Request $req) {
        $percentage = markuptbl::all();

        $itemgrpid  = md5(md5(md5(date("mdyhis"))));
        return view("quotesapplets.additem", compact("percentage","itemgrpid"));
    }

    function computetotal(Request $req) {
        $quoteid = $req->input("quoteidfk");

        $data        = Quoteitemstbl::where("quoteidfk",$quoteid)->get();
        
        $quotecorner = QuotationCorner::where("quoteid",$quoteid)->get(["custidfk","status"]);
        $custidfk    = $quotecorner[0]->custidfk;

        // if status = 2; meaning approved:: do not change 
        $quotestatus = $quotecorner[0]->status;

        // $taxation = taxationtbl::where(["custidfk"=>$custidfk,"status"=>1])->get(); 
        $taxation = Totalpricetbl::where("quoteidfk",$quoteid)->get("taxpercentage");

        $markup   = markuptbl::get("thevalue")->toArray();

        $mmm      = [];
        foreach($markup as $mm) {
           array_push($mmm,$mm['thevalue']);
        }

        $thetax   = ($taxation[0]->taxpercentage/100);
        $fulltax  = $taxation[0]->taxpercentage;

        $values = [
            "Profit"     => "0",
            "Price"      => "0",
            "Extended"   => "0",
            "GP"         => "0",
            "Cost"       => "0",
            "Subtotal"   => "0",
            "Tax"        => "0",
            "taxpercent" => $fulltax,
            "Total"      => "0"
        ];

        if (count($data) > 0){
            $found = true;
            foreach($data as $d) {
                $values['Profit']   += $d->profit;
                $values['Price']    += $d->price;
                $values["Extended"] += $d->extended;
                $values['Cost']     += $d->itemcost*$d->qty;

                if ($d->taxable == "1") {
                    $values['Tax']      += ($d->extended*$thetax);
                    // $values['Tax']      += ($d->extended*0.12);
                }

                // if mark up is not within the specified mark up, set the quote's status to 0
                    if ($found == true) {
                        if (in_array($d->markupvalue, $mmm)) {
                        $found = true;
                        } else {
                        $found = false;
                        }
                    }
                // end 
            }

            if ($found == false) {
                $updateqtstatus = QuotationCorner::where(["quoteid"=>$quoteid, "status"=>"1"])->update(["status"=>"0"]);
            } else {
                $updateqtstatus = QuotationCorner::where(["quoteid"=>$quoteid, "status"=>"0"])->update(["status"=>"1"]);
            }
            

            $values['GP']       = (($values['Extended']-$values['Cost'])/$values['Extended'])*100;
            $values['Subtotal'] = $values['Extended'];
            $values['Total']    = $values['Subtotal']+$values['Tax'];
        }

    //    $values['taxpercentage']

        // save
        $details = [
            "custidfk"      => $custidfk,
            "profit"        => $values["Profit"],
            "gp" 	        => $values["GP"],
            "cost" 	        => $values["Cost"],
            "subtotal" 	    => $values['Subtotal'],
            "tax" 	        => $values['Tax'],
            "taxpercentage" => $fulltax,
            "total" 	    => $values['Total'],
            "inputby" 	    => Auth::id(),
            "status"        => '1'
        ];

        $totaltbl = Totalpricetbl::updateOrCreate(
            ["quoteidfk" => $quoteid], $details
        );

        // end saving

        // update quotation corner
        // $quotecorner = [
        //     "taxused"    => $thetax,
        //     "quoteprice" => 
        // ];
        
        // $updatequotecorner = QuotationCorner::where("quoteid",$quoteid)->update();
        // end 

        return view("quotesapplets.computation", compact('data','values'));
    }

    function displayquote(Request $req) {
        $quoteid = $req->input("quoteid");

        $quotesinformation = DB::select(
            DB::raw(
                "select quoteitemstbls.* from quoteitemstbls where quoteidfk = '{$quoteid}'"
            )
        );

        return view("quotesapplets.quotetable", compact("quotesinformation"));
    }

    function displayperitem(Request $req) {
        $uniqueid = $req->input("uniqueid");
        
        // $uniqueid = 19;
        $data = Quoteitemstbl::where("quoteitemid",$uniqueid)->get();
        
        return view("quotesapplets.displayperitem", compact('data'));
    }

    function saveperitem_qt(Request $req) {
        $tbl    = $req->input("table");
        $fld    = $req->input("field"); // -> field which value be changed
        $id     = $req->input("id");
        $idfld  = $req->input("idfld");
        $val    = $req->input("value");

        $details      = Quoteitemstbl::where("quoteitemid", $id)->get();
        $qidfk        = $details[0]->quoteidfk;

        $ciinfo       = DB::table("customerstbls")
                            ->select("customerstbls.interest")
                            ->join("quotation_corners","customerstbls.id","=","quotation_corners.custidfk")
                            ->where("quotation_corners.quoteid",$qidfk)->get();
        
        $custint      = $ciinfo[0]->interest;

        // defaults 
            $markup     = $details[0]->markupvalue;
            $itemcost   = $details[0]->itemcost;
            $qty        = $details[0]->qty;
            $price      = $details[0]->price;
            $extended   = $details[0]->extended;
            $profit     = $details[0]->profit;
        // end 

        if ($fld == "markupvalue") { 
            $markup = $val; 
            // if markup value is not within the specified values, set the quote to for approval
        }

        if ($fld == "itemcost") { 
            $itemcost = $val;

        }

        if ($fld == "qty") { $qty = $val; }
        if ($fld == "price") { $price = $val; }

        // itemcost 
            $totalitemcost = $itemcost*$qty;

        // if private
            if ((int) $custint == 2) { // private
                $grt   = ($itemcost*.05);
                $price = ($itemcost+$grt);
            }
        // end private

        if ($markup > 0) {
        // change price
            $per      = (100/$markup);
            $addon    = ceil($itemcost/$per);
            $price    = $itemcost+$addon;

            // if private 
            if ((int) $custint == 2) { // private
                $grt   = ($price*.05);
                $price = ($price+$grt);
            }
            // end if private

        // change extended price
            $extended = $price*$qty;
            
        // change profit
            $profit   = $extended-$totalitemcost;
        } else {           
            // $price    = $itemcost;
            $extended = $price*$qty;
            // $profit   = "0";
            if ((int) $custint == 2) { // private
                $profit = ($extended-$totalitemcost);
            } else {
                $profit = 0;
            }
        }

        $data = [
            "markupvalue"   => $markup,
            "itemcost"      => ceil($itemcost),
            "qty"           => $qty,
            "price"         => ceil($price),
            "extended"      => ceil($extended),
            "profit"        => ceil($profit)
        ];

        $returndata = [
            "markupvalue"   => $markup,
            "itemcost"      => number_format(ceil($itemcost),2),
            "qty"           => $qty,
            "price"         => number_format(ceil($price),2),
            "extended"      => number_format(ceil($extended),2),
            "profit"        => number_format(ceil($profit),2)
        ];

        $update = Quoteitemstbl::where("quoteitemid",$id)->update($data);

        return response()->json($returndata);
        // return response()->json($custint);
    }

    function taxationtbl(Request $req) {
        $custid = $req->input("id");

        $tax    = taxationtbl::where("custidfk", $custid)->get();

        return view("quotesapplets.taxation", compact('tax','custid'));
    }

    function removeqtitems(Request $req) {
        $ids = $req->input("id");

        foreach($ids as $i) {
            $delete = Quoteitemstbl::where("quoteitemid",$i)->delete();
        }

        return response()->json($delete);
    }

    function checkformarkups(Request $req) {
        $quoteidfk = $req->input("quoteidfk");
        $quotecorner = QuotationCorner::where("quoteid",$quoteidfk)->get("status");

        if (count($quotecorner) == 0) {
            return response()->json("NO DATA FOUND");
        } else {
            $status = $quotecorner[0]->status;

            if ($status == 0 || $status == "0") { // for approval
                return view("quotesapplets.checkformarkups", compact("quoteidfk"));
            } else {
                return response()->json(0);
            }
        }
    }

    function uploaditems(Request $req, $cats = false) {
        $categories   = DB::select(DB::raw("select distinct(category) from itemstbls"));

        $allitems = [];
        if ($cats == false) {
            $allitems     = itemstbl::all();
        } else {
            $allitems     = itemstbl::where("category",$cats)->get();
        }

        return view("uploaditems", compact("categories","allitems","cats"));
    }

    function fileupload(Request $request, $cats = false) {
        $file 	 	 = $request->file("itemuploadfile");
    	// $paytitle    = $request->input("payrolltitle");

    	// $origfn      = $file->getClientOriginalName();
    	// $origext     = $file->getClientOriginalExtension();

    	// if ($origext != "csv") {
    	// 	// return "The file you uploaded is not a valid CSV file";
    	// }

    	// $newname     = md5($origfn.date("mdyhis"));

    	// $destination = storage_path("uploads");
    	// $newpathname = $newname.".".$origext;

    	// $a 			 = $file->move($destination,$newpathname);

    	// // open the file 
    	// $fpath  	 = storage_path("uploads/".$newpathname);
    	//$tfile 		 = fopen($fpath,"r");
        $tfile 		 = fopen($file,"r");

        $count       = 0;

        $headers     = []; // csv headers 
        $dbheaders   = []; // database headers

        while(! feof($tfile)) {
            $csvfile = fgetcsv($tfile);

            if ($csvfile != false) {
                if ($count != 0) {
                    $save = itemstbl::create([
                            "category"      => $cats,    
                            "itemcode"      => $csvfile[0],
                            "description"   => $csvfile[1],
                            "itemname"      => $csvfile[2],
                            "itemprice"     => $csvfile[3],
                            "markup"        => $csvfile[4],
                            "sellprice"     => $csvfile[5],
                            "supplierid"    => $csvfile[6],
                            "suppliername"  => $csvfile[7],
                            "mfgid"         => $csvfile[8],
                            "mfgname"       => $csvfile[9],
                            "istaxable"     => (int) $csvfile[10],
                            "inputby"       => Auth::id(),
                            "status"        => "1"
                        ]);
                }
            }
            $count++;
        }

        return redirect("uploaditems");
    }

    function changevalidity(Request $req) {
        $quoteid   = $req->input("quoteid");
        $theperiod = $req->input("theperiod");

        $data = QuotationCorner::where("quoteid",$quoteid)->get();

        /*
        0   = subject for approval
        1   = quote
        2   = approved
        3   = order
        4   = sales
        5   = invoice
        6   = cancelled
        7   = expired
        */

        if (count($data) > 0) {
            if ( strtotime($data[0]->quotevalidity) < strtotime($theperiod) ) {
                $status = null;

                if ($data[0]->status == 7) {
                    $status = 1;
                } else {
                    $status = $data[0]->status;
                }

                $updated = QuotationCorner::where("quoteid",$quoteid)->update([
                    "status"        => $status,
                    "quotevalidity" => $theperiod
                ]);

                return response()->json($updated);
            } else {
                return response()->json("false");
            }
        }
    }

}
