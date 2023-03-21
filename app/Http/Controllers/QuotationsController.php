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
use App\Models\Productline;
use App\Models\itemreferencetbl;
use App\Models\emaillinkstbl;
use App\Models\AllowedUser;
use App\Models\CommentsTbl;
use App\Models\Subtotaltbl;
use App\Models\viewquoteopts;
use App\Models\grttable;

use App\Models\GlobalComputation;

use DB;

class QuotationsController extends Controller
{
    function quotes(Request $req, $id = null, $quoteid = null, $approvalcode = null, $reqsid = null, $aprvcode = null) {
        date_default_timezone_set("asia/manila");

        if ($id == null) {
            $datetoday = date("Y-m-d");

            $update    = DB::select(DB::raw("update quotation_corners set status = '7' where status in ('0','1','2') and quotevalidity < {$datetoday}"));

            $allquotes = DB::table("quotation_corners")
                            ->select("quotation_corners.quotedate","quotation_corners.quotationname",
                                     "quotation_corners.quoteid","quotation_corners.status",
                                     "customerstbls.companyname","customerstbls.id",
                                     "totalpricetbls.total")
                            ->join("totalpricetbls", "quotation_corners.quoteid","=","totalpricetbls.quoteidfk")
                            ->join("customerstbls", "quotation_corners.custidfk","=","customerstbls.id")
                            ->orderByRaw("quotation_corners.quoteid DESC")->get();
                            //->join("users","quotation_corners.custidfk","=","users.id")->get();

            $allcust   = Customerstbl::all();
            return view("listofallquotes",compact("allquotes","allcust"));
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

                // save to grt table

                // end 
                
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
                
                $savetoviewopts = viewquoteopts::insert([
                    [
                        "viewoptionfld" => "withexpiry",
                        "viewoptiontxt" => "expiry",
                        "quoteidfk"     => $quoteid,
                        "optiontype"    => "set",
                        "inputby"       => Auth::id(),
                        "status"        => "1"
                    ],
                    [
                        "viewoptionfld" => "itemdesc",
                        "viewoptiontxt" => "Description",
                        "quoteidfk"     => $quoteid,
                        "optiontype"    => "fld",
                        "inputby"       => Auth::id(),
                        "status"        => "1"
                    ],
                    [
                        "viewoptionfld" => "showbreakdown",
                        "viewoptiontxt" => "breakdown",
                        "quoteidfk"     => $quoteid,
                        "optiontype"    => "set",
                        "inputby"       => Auth::id(),
                        "status"        => "1"
                    ],
                    [
                        "viewoptionfld" => "incorporatetaxornot",
                        "viewoptiontxt" => "tax",
                        "quoteidfk"     => $quoteid,
                        "optiontype"    => "set",
                        "inputby"       => Auth::id(),
                        "status"        => "1"
                    ],
                    [
                        "viewoptionfld" => "shippingfinalprice",
                        "viewoptiontxt" => "Shipping Fee",
                        "quoteidfk"     => $quoteid,
                        "optiontype"    => "fld",
                        "inputby"       => Auth::id(),
                        "status"        => "1"
                    ],
                ]);

               // return redirect()->route('quotes', ['id' => $id,'quoteid'=>$quoteid]);
               return redirect("quotes/{$id}/$quoteid");
            } else {
                // retrieve the quotation's information
                // $quotedets = Totalpricetbl::where("quoteidfk",$quoteid)->get();

                $quotedets    = DB::table("totalpricetbls")
                                    ->select("totalpricetbls.*","users.name")
                                    ->join("users","totalpricetbls.inputby","=","users.id")
                                    ->where("totalpricetbls.quoteidfk",$quoteid)->get();
            //    var_dump($quotedets); return;
                $emps         = DB::table("intereststbls")
                                    ->select("intereststbls.theinterest","intereststbls.interid")
                                    ->leftJoin("customerstbls","intereststbls.interid","=","customerstbls.interest")
                                    ->where("customerstbls.id",$id)->get();

                $empdata       = grttable::where(["quoteidfk"=>$quoteid,"custid"=>$id])->get();

                $viewopts      = viewquoteopts::where("quoteidfk",$quoteid)->get();

                $overallqtdets = QuotationCorner::where("quoteid", $quoteid)->get();
                
                // if (count($empdata) == 0) {
                //     return back()->with('status', "You need to specify the company's GRT type to proceed.");
                // }

                if (count($overallqtdets) > 0) {
                    if ( strtotime(date("Y-m-d")) > strtotime($overallqtdets[0]->quotevalidity) ) {
                        $updateqt      = QuotationCorner::where("quoteid", $quoteid)->update(["status"=>"7"]);
                        $overallqtdets = QuotationCorner::where("quoteid", $quoteid)->get();
                    }
                }

                // get the list of users with access 
                    $haveaccess = GlobalComputation::listofusers("quotation_corners", $quoteid);
                // end list of users with access

                // check owner 
                    $owner   = $overallqtdets[0]->inputby;
                    $viewer  = Auth::id();

                    $allowed = false;
                    $isowner = false;

                    if ($owner == $viewer) {
                        $allowed = true;
                        $isowner = true;
                    } else {
                        $allowed = GlobalComputation::checkifhaveaccess($viewer, "quotation_corners" ,$quoteid);
                    }
                // end check

                // approve btn
                    $showapprovebtn = null;

                    // asking for approval
                    //$showallowbtn  = false;
                    $allowdetails  = null;
                    if ($approvalcode != null) {
                        if ($approvalcode == "askingpermission") {
                            if ($reqsid == null) {
                                die("Requestor ID is not set"); return;
                            } else {
                                $requestdetails = DB::select(
                                    DB::raw("select allowed_users.alloweduser, users.name from allowed_users
                                            join users on allowed_users.alloweduser = users.id 
                                            where allowed_users.alloweduser = '{$reqsid}' 
                                            and allowed_users.idfk = '{$quoteid}'")
                                );
                                                               
                                if (count($requestdetails) == 0) {
                                    die("No request found"); return;
                                }

                                // http://localhost:8000/approve/55/a545f2d7d55a670c3d9ecaba0d628a03
                                $allowdetails = [
                                    "req"           => $requestdetails[0]->name,
                                    "approvelink"   => url('')."/approve/55/{$aprvcode}"
                                ];

                                // $showallowbtn = true;
                            }
                        } else {
                            $loggedinemail = Auth::user()['email'];

                            $checklink = emaillinkstbl::where(["thecode"=>$approvalcode,"approver"=>$loggedinemail,"idfk"=>$quoteid])->get();

                            if (count($checklink) > 0) {
                                $showcomment    = true;
                                $showapprovebtn = url('')."/approve/{$quoteid}/{$approvalcode}";
                            } else {
                                die("There is something wrong with the link you browsed"); 
                            }
                        }
                    }
                // end approve

                $contacts     = contactstbl::where("custidfk", $id)->get(["contid","contactname"]);

                $categories   = DB::select(DB::raw("select distinct(category) from itemstbls"));
                
            }

            $percentage  = markuptbl::all();
        
            $grt         = grttable::where("quoteidfk",$quoteid)->get();
            // $data 
            $initials = explode(" ", $data[0]->companyname);

            $ints     = null;
            if (count($initials) == 1) {
                $ints = $data[0]->companyname[0].$data[0]->companyname[1];
            } else if (count($initials) >= 2) {
                $ints = $initials[0][0].$initials[1][0];
            }

            return view("quotations", compact('data','allcust','ints','quoteid','id','quotedets','percentage','emps','empdata','categories','contacts','overallqtdets','showapprovebtn','allowed','allowdetails','haveaccess','isowner','viewopts','grt'));
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
        $percentage   = markuptbl::all();
        $itemtype     = DB::select(DB::raw("select * from productlines where status = '1' group by thegrpid"));
        
        $itemgrpid  = md5(md5(md5(date("mdyhis"))));
        return view("quotesapplets.additem", compact("percentage","itemtype","itemgrpid"));
    }

    function loadmarkups(Request $req) {
        $groupid = $req->input("groupid");

        $markups = Productline::where("thegrpid",$groupid)->get("minimummarkup");

        return view("quotesapplets.percentageselect", compact("markups"));
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

        // $markup   = markuptbl::get("thevalue")->min("thevalue");
        // $markup      = GlobalComputation::getminimummarkup();

        // echo "hello".$markup; return;
        // $mmm      = [];
        // foreach($markup as $mm) {
        //    array_push($mmm,$mm['thevalue']);
        // }

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
                // get from the subtotal table
                    $subtot_qty   = Subtotaltbl::where("subtotalid", $d->subtotalidfk)->get("subtotalqty");
                    $subtotqty    = 1;

                    if (count($subtot_qty) >= 1) {
                        $subtotqty    = $subtot_qty[0]->subtotalqty;
                    }
                // end 
              
                $values['Profit']   += $d->profit;
                $values['Price']    += $d->price;
                $values["Extended"] += $d->extended*$subtotqty;
                $values['Cost']     += $d->itemcost*$d->qty;
                
               // $values["Extended"] = $values["Extended"] * $subtotqty;

                if ($d->taxable == "1") {
                    $values['Tax']      += ($d->extended*$thetax);
                    // $values['Tax']      += ($d->extended*0.12);
                }

                // foreach($markup as $mk) {
                //     if ($d->productlineid == $mk->thegrpid) {
                //         //if ($found == true) {
                //             if ($d->markupvalue < $mk->minimum) {
                //                 $found = false;
                //                 $updateitemstatus
                //             } else {
                //                 $found = true;
                //             }
                //         //}
                //     }
                // }

            }

            // if ($found == false) {
            //     $updateqtstatus = QuotationCorner::where(["quoteid"=>$quoteid, "status"=>"1"])->update(["status"=>"0"]);
            // } else {
            //     $updateqtstatus = QuotationCorner::where(["quoteid"=>$quoteid, "status"=>"0"])->update(["status"=>"1"]);
            // }
            

            $values['GP']       = (($values['Extended']-$values['Cost'])/$values['Extended'])*100;
            $values['Subtotal'] = $values['Extended'];
            $values['Total']    = $values['Subtotal']+$values['Tax'];
        } else {
            $updateqtstatus = QuotationCorner::where(["quoteid"=>$quoteid, "status"=>"0"])->update(["status"=>"1"]);
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
            // "inputby" 	    => Auth::id(),
            "status"        => '1'
        ];

        $totaltbl = Totalpricetbl::updateOrCreate(
            ["quoteidfk" => $quoteid], $details
        );

        return view("quotesapplets.computation", compact('data','values'));
    }

    function displayquote(Request $req) {
        $quoteid = $req->input("quoteid");

        $quotesinformation = DB::select(
            DB::raw(
                "select quoteitemstbls.* from quoteitemstbls where quoteidfk = '{$quoteid}'"
            )
        );

        $owner = QuotationCorner::where("quoteid",$quoteid)->get("inputby");

        $viewer = Auth::id();

        $allowed = false;
        if ($owner[0]->inputby == $viewer) {
            $allowed = true;
        } else {
            $allowed = GlobalComputation::checkifhaveaccess($viewer, "quotation_corners" ,$quoteid);
        }

        $comments     = CommentsTbl::where("quoteidfk",$quoteid)->get();

        $subtotals    = Subtotaltbl::where("quoteidfk",$quoteid)->get();

        // $checklink    = emaillinkstbl::where(["thecode"=>$approvalcode,"approver"=>$loggedinemail,"idfk"=>$quoteid])->get();

        // if (count($checklink) > 0) {
        //     $approverlink = true;
        // }

        return view("quotesapplets.quotetable", compact("quotesinformation","allowed","comments","subtotals"));
    }

    function displayperitem(Request $req) {
        $uniqueid = $req->input("uniqueid");
        $custid   = $req->input("info");

        $data = Quoteitemstbl::where("quoteitemid",$uniqueid)->get();
        
        // compute here
            $compute = new GlobalComputation();
            $compute->unitcost          = $data[0]->itemcost;
            $compute->unitcostmarkup    = $data[0]->markupvalue;
            $compute->qty               = $data[0]->qty;

            if ($data[0]->withshipping != null) {
                $compute->withshipping      = true;
                $compute->shipcostmarkup    = $data[0]->shippingmarkup;
                $compute->shipcost          = $data[0]->shippingcost;
            }

            $compute->custint               = $custid;
        // end compute

        // start compute
            $compute->compute();
        // end 

        // product line id 
            $minimummarkup = GlobalComputation::checkminimummarkup($data[0]->productlineid);
            
            $status = null;

            if ($compute->unitcostmarkup < $minimummarkup) {
                $status = "0";
            } else {
                $status = "1";
            }
        // end 

        // get the values 
            $update    = Quoteitemstbl::where("quoteitemid",$uniqueid)
                                    ->update([
                                        "profit"                => $compute->profit,
                                        "price"                 => $compute->sellprice,
                                        "extended"              => $compute->extended,
                                        "shippingfinalprice"    => $compute->totalshipcost,
                                        "status"                => $status
                                    ]);
        // end 
        
        $datetoday = date("Y-m-d h:i:s A");

        $data = Quoteitemstbl::where("quoteitemid",$uniqueid)->get();
        return view("quotesapplets.displayperitem", compact('data',"datetoday"));
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
        
        // $custint      = $ciinfo[0]->interest;

        $grt          = grttable::where("quoteidfk",$qidfk)->get();
        $custint      = $grt[0]->grttypeid; 

        // set defaults
        $compute                    = new GlobalComputation();
        $compute->unitcost          = $details[0]->itemcost;
        $compute->unitcostmarkup    = $details[0]->markupvalue;
        $compute->qty               = $details[0]->qty;

        $compute->sellprice         = $details[0]->price;
        $compute->extended          = $details[0]->extended;
        $compute->profit            = $details[0]->profit;
        // end 

        if ($details[0]->withshipping != null) {
            $compute->withshipping      = true;
            $compute->shipcostmarkup    = $details[0]->shippingmarkup;
            $compute->shipcost          = $details[0]->shippingcost;
        }

        // $compute->custint           = $ciinfo[0]->interest;
        $compute->custint              = $custint;
      
        // item
        if ($fld == "markupvalue") { $compute->unitcostmarkup = $val; }
        if ($fld == "itemcost")    { $compute->unitcost       = $val; }
        if ($fld == "qty")         { $compute->qty            = $val; }

        // shipping
        if ($fld == "shippingcost")   { 
            $compute->withshipping      = true;
            $compute->shipcost          = $val;

            if ($compute->shipcost <= 0) {
                $compute->withshipping      = null;
            }
        }

        if ($fld == "shippingmarkup") { 
            $compute->withshipping      = true;
            $compute->shipcostmarkup    = $val; 
        }

        $minimummarkup = GlobalComputation::checkminimummarkup($details[0]->productlineid);

        $status = null;
        if ($compute->unitcostmarkup < $minimummarkup) {
            $status = "0";
        } else {
            $status = "1";
        }

        // start compute 
            $compute->compute();
        // end 

        $returndata = [
            "profit"                => $compute->profit,
            "itemcost"              => $compute->unitcost,
            "markupvalue"           => $compute->unitcostmarkup,
            "price"                 => $compute->sellprice,
            "extended"              => $compute->extended,
            "shippingfinalprice"    => $compute->totalshipcost,
            "withshipping"          => $compute->withshipping,
            "shippingcost"          => $compute->shipcost,
            "shippingmarkup"        => $compute->shipcostmarkup,
            "status"                => $status,
            "qty"                   => $compute->qty
        ];

        $update    = Quoteitemstbl::where("quoteitemid",$id)->update($returndata);

        $returndata1 = [
            "profit"                => number_format($compute->profit,2),
            "itemcost"              => number_format($compute->unitcost,2),
            "markupvalue"           => number_format($compute->unitcostmarkup,1),
            "price"                 => number_format($compute->sellprice,2),
            "extended"              => number_format($compute->extended,2),
            "shippingfinalprice"    => number_format($compute->totalshipcost,2),
            "withshipping"          => $compute->withshipping,
            "shippingcost"          => number_format($compute->shipcost,2),
            "shippingmarkup"        => $compute->shipcostmarkup,
            'qty'                   => $compute->qty
        ];

        return response()->json($returndata1);
       
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
        // $quoteitemid       = "29";
        $quoteitemid    = $req->input("quoteitemid");

        $itemdetails    = Quoteitemstbl::where("quoteitemid",$quoteitemid)->get(["productlineid","markupvalue","quoteidfk"]);
        $markups        = GlobalComputation::checkminimummarkup($itemdetails[0]->productlineid);
        // $markups        = GlobalComputation::getminimummarkup();

        $quoteidfk      = $itemdetails[0]->quoteidfk;
        // $markupstandard = null;
  
        // foreach($markups as $mk) {
        //     if ($mk->thegrpid == $itemdetails[0]->productlineid) {
        //         $markupstandard = $mk->minimum;
        //     }
        // }
    
        $status = null;

        if ($itemdetails[0]->markupvalue < $markups) {
            $status = "0";
        } else {
            $status = "1";
        }

        $updateitemstatus  = Quoteitemstbl::where("quoteitemid",$quoteitemid)->update(["status" => $status]);
        
        if ($status == "0" || $status == 0) {
            return view("quotesapplets.checkformarkups", compact("quoteidfk"));
        } else {
            return response()->json(0);
        }
    }

    function checkitemneedsapproval(Request $req) {
        $quoteidfk = $req->input("grpidfk");
        // var_dump($quoteidfk);
        if (GlobalComputation::checkneedsapproval($quoteidfk) == true) {
            return view("quotesapplets.checkformarkups", compact("quoteidfk"));
        } else {
            return response()->json(0);
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
                            // "sellprice"     => $csvfile[5],
                            "supplierid"    => $csvfile[5],
                            "suppliername"  => $csvfile[6],
                            "mfgid"         => $csvfile[7],
                            "mfgname"       => $csvfile[8],
                            "istaxable"     => (int) $csvfile[9],
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

    function viewitemdetails(Request $req) {
        $uniqueid  = $req->input("uniqueid");

        $data      = Quoteitemstbl::where("quoteitemid",$uniqueid)->get();

        $otherinfo = itemreferencetbl::where("theitemid",$uniqueid)->get();

        $itemgrpid = md5(md5(md5(date("mdyhisA"))));

        if (count($otherinfo) > 0) {
            $itemgrpid = $otherinfo[0]->itemgrpid;
        }

        return view("quotesapplets.viewitemdetails", compact("data","otherinfo","itemgrpid"));
    }

    function insertotheritems(Request $req) {
        $percentage   = markuptbl::all();
        $itemtype     = DB::select(DB::raw("select * from productlines where status = '0' group by thegrpid"));

        $itemgrpid  = md5(md5(md5(date("mdyhis"))));
        
        return view("quotesapplets.insertotheritem",compact("percentage","itemtype","itemgrpid"));
    }

    function loadingcomments(Request $req) {
        $quoteitemid = $req->input("id");
        $quoteidfk   = $req->input("anotherid");

        $comment = DB::select(
            DB::raw("select * from comments_tbls where quoteitemidfk = '{$quoteitemid}'")
        );

        $action = null;
        
        if (count($comment) > 0) {
            $action = "update";
        } else {
            $action = "new";
        }

        $overallqtdets = QuotationCorner::where("quoteid", $quoteidfk)->get("inputby");

        $owner   = $overallqtdets[0]->inputby;
        $viewer  = Auth::id();

        $allowed = false;
        $isowner = false;

        if ($owner == $viewer) {
            $allowed = true;
            $isowner = true;
        } else {
            $allowed = GlobalComputation::checkifhaveaccess($viewer, "quotation_corners" ,$quoteidfk);
        }

        return view ("quotesapplets.itemcomment", compact("comment","action","allowed","isowner"));
    }

    function editsubqty(Request $req) {
        $subtotalid = $req->input("id");

        $data       = Subtotaltbl::where("subtotalid",$subtotalid)->get();

        return view ("quotesapplets.editsubqty", compact("data"));
    }

    function viewoptionsorders(Request $req) {
        $qtid = $req->input("id");

        $data = viewquoteopts::where(["quoteidfk"=>$qtid,"optiontype"=>"fld"])->get("viewoptiontxt");
        return view("quotesapplets.viewoptionsorders", compact("data"));
    }

}
