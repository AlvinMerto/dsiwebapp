<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\emaillinkstbl;
use App\Models\QuotationCorner;
use App\Models\Sharewithtbn;
use App\Models\User;
use App\Models\viewquoteopts;
use App\Models\Subtotaltbl;

use DB;
use Auth;
use Mail;

class Offsitecontrol extends Controller
{
    function approvenow($idfk = false, $code = false) {

        if ($code != false && $idfk != false) {
            $thelink = emaillinkstbl::where("thecode",$code)->update(["status"=>"1"]);

            // update the designated table 
                $emaillink = emaillinkstbl::where(["thecode"=>$code,"status" => "1"])->get(["idfk","idfld","thetbl","requestor","linktoapprove"])->toArray();

                $table = $emaillink[0]['thetbl'];
                $idfld = $emaillink[0]['idfld'];
                $idfk  = $emaillink[0]['idfk'];

                $status = null;
                
                if ($table == "quotation_corners") {
                    $status = "2";
                } else if ($table == "quoteitemstbls") {
                    $status = "1";
                } else if ($table == "allowed_users") {
                    $status = "1";
                }
                
                $updatethetbl = DB::table($table)->where($idfld,$idfk)->update(["status"=>"{$status}"]);

                //if ($updatethetbl) {
                    $requestor_id = $emaillink[0]['requestor'];
                    $r_details    = User::where("id",$requestor_id)->get(["name","email"]);

                    $link         = $emaillink[0]["linktoapprove"];
                    $message      = "Request is approved.";

                    $fromemail    = Auth::user()['email']; 
                    $from         = Auth::user()['name'];
                    $reference    = "Quotation";
                    $item         = "Request is approved";

                    $info = [
                        "email"     => $r_details[0]->email,
                        "emailto"   => $r_details[0]->name,
                        "paytitle"  => "Notification from {$from} on: {$item}",
                        "fromemail" => $fromemail,
                        "fromname"  => $from,
                        "reference" => $reference,
                        "msg"       => (string) $message,
                        "thedate"   => date("M. d, Y"),
                        "type"      => "Request for approval",
                        "redirect"  => $link
                    ];

                    $template  = "notifications";

                    Mail::send($template,$info, function($msg) use ($info) {
                        $msg->to($info['email'],"{$info['emailto']}")->subject("{$info['paytitle']}");
                        $msg->from("{$info['fromemail']}","{$info['fromname']}");
                    });
                //}
            // end 
                return view("linkapproved");
        } else {
            return "error";
        }
    }

    function quotation($quoteid = false, $code = false, $ispreview = false) {
        if ( $ispreview == false ) {
            if ($code == false) { die("no code found"); }

            $foundcode = emaillinkstbl::where("thecode",$code)->get("idfk");
            if (count($foundcode) > 0) {
                if ($foundcode[0]->idfk != $quoteid) {
                    die("The code and ID do not matched");
                }
            } else {
                die("code not found");
            }
        }

        $viewoptsdata = viewquoteopts::where("quoteidfk",$quoteid)->get();
        $subtotaltbl  = Subtotaltbl::where("quoteidfk",$quoteid)->get(["subtotalid","quoteidfk","subtotalname","subtotalqty"])->toArray();
        // var_dump($subtotaltbl);
        // return;
        $viewopts = "";

        $count    = 1;
        $sets     = [];
        $flds     = [];
        $fldname  = [];
        
        foreach($viewoptsdata as $vs) {
            if ($vs->optiontype == "fld") {
                $viewopts .= "qit.".$vs->viewoptionfld;
                array_push($flds,$vs->viewoptionfld);
                // array_push($fldname,[$vs->viewoptionfld=>$vs->viewoptiontxt]);
                $fldname[$vs->viewoptionfld]    = $vs->viewoptiontxt;

                if ($count < count($viewoptsdata)) {
                    $viewopts .= ",";
                } else {
                    $viewopts .= ",";
                }

            } else if ($vs->optiontype == "set") {
                array_push($sets,$vs->viewoptionfld);
            }
            
        }

        // var_dump($fldname);

        $data = DB::select(
            DB::raw(
                "SELECT qc.*, ct.companyname, ct.address, ct.city, ct.country, ct.state, ct.zip, ct.contactnumber, 
                ct.email, contt.email, contt.contid, contt.contactname, contt.title, tpt.subtotal, 
                tpt.tax, tpt.taxpercentage, tpt.total, 
                {$viewopts} qit.subtotalidfk, qit.itemcost, qit.qty, qit.price,qit.extended,qit.expnumber, qit.withexpiry, qit.expunit, qit.expnote , users.name  
                FROM `quotation_corners` as qc join customerstbls as ct on qc.custidfk = ct.id 
                left join totalpricetbls as tpt on qc.quoteid = tpt.quoteidfk 
                left join quoteitemstbls as qit on qc.quoteid = qit.quoteidfk 
                join users on qc.inputby = users.id
                join contactstbls as contt on qc.quotationsentto = contt.contid where qc.quoteid = '{$quoteid}'; "
            )
        );
        
       // var_dump($data);
        $quotestatus = null;
        if (count($data) > 0) {
            if ( strtotime(date("Y-m-d")) > strtotime($data[0]->quotevalidity)) {
                // <=2 = quote
                // 3   = order
                // 4   = sales
                // 5   = invoice
                // 6   = cancelled
                // 7   = expired
                $update      = QuotationCorner::where("quoteid",$quoteid)->update(["status"=>"7"]);
                $quotestatus = "expired";
            } else {
                $quotestatus = "valid";
            }

            if ($data[0]->status == "3") {
                $quotestatus = "ORDERED";
            }
        } else {
            die("The quotation is not found");
        }

        if (isset($_POST['signbtn'])) {
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
                if ($data[0]->email == $_POST['approveremail']) {
                    // 2023-02-21 17:54:15
                    $orderdate   = date("Y-m-d H:i:s");
                    $update      = QuotationCorner::where("quoteid",$quoteid)->update(["status"=>"3","orderdate"=>$orderdate]);
                    // $qtcorder    = QuotationCorner::where("quoteid",$quoteid)->get("inputby");

                    $quotestatus = "ORDERED";

                    $qtcorder    = DB::table("quotation_corners")
                                    ->select("quotation_corners.inputby","quotation_corners.quotationname","quotation_corners.quoteid",
                                            "users.email","users.name","customerstbls.companyname","contactstbls.contactname",
                                            "contactstbls.email as contemail")
                                    ->join("users","quotation_corners.inputby","=","users.id")
                                    ->join("customerstbls","quotation_corners.custidfk","=","customerstbls.id")
                                    ->join("contactstbls","quotation_corners.quotationsentto","=","contactstbls.contid")
                                    ->where("quoteid",$quoteid)->get();
               
                    // notify the DSI Account manager
                        $info = [
                            "thedate"      => date("M. d, Y"),
                            "quoteid"   => $qtcorder[0]->quoteid,
                            "quotename" => $qtcorder[0]->quotationname,
                            "email"     => $qtcorder[0]->email,
                            "emailto"   => $qtcorder[0]->name,
                            "fromemail" => $qtcorder[0]->contemail,
                            "fromname"  => $qtcorder[0]->contactname,
                            "paytitle"  => "Order Received from ".$qtcorder[0]->companyname,
                            "companyn"  => $qtcorder[0]->companyname
                        ];

                        $template = "orderreceived";

                        Mail::send($template,$info, function($msg) use ($info) {
                            $msg->to($info['email'],"{$info['emailto']}")->subject("{$info['paytitle']}");
                            $msg->from("{$info['fromemail']}","{$info['fromname']}");
                        });
                    // end 

                } else {
                    // echo $data[0]->email ."=". $_POST['approveremail'];
                    die("You are not allowed to approve this qoute");
                }
            } else {
                die("No data found");
            }
            
        }

        return view("customerquotation", compact("data","quotestatus","quoteid","ispreview","flds","fldname","sets","subtotaltbl"));
    }

    function signandapprovequote() {

    }

    function optoutnotification($grpidpk = false, $action = false) {
        $id      = Auth::id();

        $status  = null;
        switch($action) {
            case "activate":
                $status = "1";
                break;
            case "deactivate":
                $status = "0";
                break;
        }

        $update = Sharewithtbn::where(["groupidpk"=>$grpidpk,"sharedwith"=>$id])
                                ->update(["status"=>$status]);

        return view("optoutnotification", compact("update","action"));
    }
}
