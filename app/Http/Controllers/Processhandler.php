<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contactfluidtbl;
use App\Models\contacthistorytbl;
use App\Models\contactstbl;
use App\Models\Customerstbl;
use App\Models\Sharewithtbn;
use App\Models\historytbl;
use App\Models\itemstbl;
use App\Models\Quoteitemstbl;
use App\Models\User;
use App\Models\emaillinkstbl;
use App\Models\grttable;

use App\Models\GlobalComputation;

use DB;
use Mail;

use Illuminate\Support\Facades\Auth;

class Processhandler extends Controller
{
    //
    function savetodatabase(Request $req) {
        date_default_timezone_set("asia/manila");
        
        $data = (array) $req->input("thedata");

        if ($req->input("action") == false || $req->input("action") == "false") {
            $data = array_merge($data,['inputby'=>Auth::id()]);
        }

        $data = array_merge($data, ['created_at' => date("Y-m-d H:i:s")]);

        $save = DB::table($req->input('table'))->insertGetId($data);

        if ($req->input('table') == "contactstbls" || $req->input("table") == "contactfluidtbls") { // saving to contacts database
            $thefield = null;

            switch($req->input("table")) {
                case "contactstbls":   
                    $custid       = $data["custidfk"];
                    $thefield     = "Company Name"; 
                    $thevalue     = $custid;
                    $thevaluename = Customerstbl::where("id",$custid)->get("companyname")->toArray()[0]['companyname'];
                    $save         = $save;
                    break;
                case "contactfluidtbls": 
                    $thefield = $data['thefield']; 
                    $thevalue = $data['thevalue'];
                    $thevaluename = null;
                    $save     = $data['contidfk'];
                    break;
            }

            $details  = [  
                "contidfk"     => $save,
                "thefield"     => $thefield,
                "thevalue"     => $thevalue,
                "thevaluename" => $thevaluename,
                "inputby"      => Auth::id(),
                "status"       => 1
            ];

            $bullshit = contacthistorytbl::create($details);
        }

        // a trigger for share is on
        $share = (string) $req->input("share");

        if ( $share != "false" ) {
            $grpidpk = $data['groupidfk'];

            $updateshare = [
                "tableid"    => $save,
                "tablefrom"  => $req->input('table'),
                "status"     => "1"
            ];
            
            $insertarr       = array_merge($updateshare, ["sharedwith"=>Auth::id(),"groupidpk"=>$grpidpk,"inputby"=>Auth::id()]);

            $insertsharetome = Sharewithtbn::create($insertarr);

            $update          = Sharewithtbn::where("groupidpk",$grpidpk)
                                            ->update($updateshare);
            
        }
        // end share 

        // trigger to put to history table
        $history = (string) $req->input("history");

        if ($history != "false") {
            // save to history 
            // $tablehistoryname = [
            //     "contactfluidtbls"   => "",
            //     "contacthistorytbls" => "",
            //     "contactstbls"       => "",
            //     "customerstbls"      => "",
            //     "failed_jobs"        => "",
            //     "historytbls"        => "",
            //     "linkstbls"          => "",
            //     "notestbls"          => "",
            //     "quotations"         => "",
            //     "replytbls"          => "",
            //     "taskstbls"          => "",
            // ];
            // $custid = isset($data["custidfk"])?$data["custidfk"]:"false";
            $custid    = $req->input("id");
            $historytbl = [
                "custidfk"        => $custid,
                "tableid"         => $save,
                "tablefrom"       => $req->input('table'),
                "historyactivity" => "New log inputted to ".$history,
                "status"          => "1",
                "inputby"         => Auth::id()
            ];

            $savehistory   = historytbl::create($historytbl);
        }
        // end history
        

        return response()->json($save);
    }

    function saveperitem(Request $req) {
        $tbl    = $req->input("table");
        $fld    = $req->input("field");
        $id     = $req->input("id");
        $idfld  = $req->input("idfld");
        $val    = $req->input("value");

        $update = DB::table($tbl)
                ->where($idfld,$id)
                ->update([$fld=>$val]);

        if ($req->input("otherinfo") != false || $req->input("otherinfo") != "false") {
            $otherinfo = (array) $req->input("otherinfo");
            
            $fld       = isset($otherinfo['otherfld'])?$otherinfo['otherfld']:$fld;
            $id        = isset($otherinfo['othid'])?$otherinfo['othid']:$id;
        }

        // save to contact history 
        if ($tbl == "contactstbls" || $tbl == "contactfluidtbls") {
                $details  = [  
                "contidfk"  => $id,
                "thefield"  => $fld,
                "thevalue"  => $val,
                "inputby"   => Auth::id(),
                "status"    => 1
                ];

                $conthist = contacthistorytbl::create($details);
        }
        // end 
        return response()->json($update);
    }



    function removeitem(Request $req) {
        $tbl   = $req->input("tbl");
        $id    = $req->input("id");
        $idfld = $req->input("idfld");

        if ($req->input("truedelete") == "false" || $req->input("truedelete") == false) {
            $delete = DB::table($tbl)
                    ->where($idfld, $id)
                    ->update(["status"=>'0']);
                    // ->delete();
        } else {
            $delete = DB::table($tbl)
                        ->where($idfld, $id)
                        ->delete();
        }
        
        return response()->json($delete);
    }

    function transfer(Request $req) {
        $custid = $req->input("custid");
        $contid = $req->input("contid");

        $update = contactstbl::where("contid",$contid)->update(["custidfk"=>$custid]);
        
        // save to contact history 
            $details  = [  
                "contidfk"     => $contid,
                "thefield"     => "Company Name",
                "thevalue"     => $custid,
                "thevaluename" => Customerstbl::where("id",$custid)->get("companyname")->toArray()[0]['companyname'],
                "inputby"      => Auth::id(),
                "status"       => 1
            ];
            // "thevalue"  => Customerstbl::where("id",$custid)->get("companyname")->toArray()[0]['companyname'],
            $save = contacthistorytbl::create($details);
        // end 

        return response()->json($update);
    }

    function gettasks() {
        $id   = Auth::id();

        $data = DB::select(
                    DB::raw("select taskstbls.*, customerstbls.companyname from taskstbls 
                            join customerstbls on taskstbls.custid = customerstbls.id
                                where taskstbls.status=1 and taskid in (select tbl2.tableid from 
                                (select * from (select tableid, tablefrom, status from sharewithtbns where sharedwith = '{$id}' or sharedwith ='all') 
                                as tbl1 where tbl1.tablefrom = 'taskstbls') as tbl2);")
                );
        
        return view("applets.alltasks", compact("data"));
    }

    function saveexistingitem(Request $req) {
        $itemid   = $req->input("itemid");
        $quoteid  = $req->input("quoteid");
        $tblorder = $req->input("tblorder");

        $theitems = itemstbl::where("itemid",$itemid)->get();

        $sellprice     = 0; // $theitems[0]->sellprice;

        $extended      = 0; // ($theitems[0]->sellprice*1);
        $totalitemcost = 0; // ($theitems[0]->itemprice*1);
        $profit        = 0; // ($extended-$totalitemcost);

        $dddd = [
            "quoteidfk"          => $quoteid,
            "tblorder"           => ($tblorder+1),
            "itemtype"           => "existing",
            "itemdesc"           => $theitems[0]->description,
            "itemcost"           => $theitems[0]->itemprice,
            "suppname"           => $theitems[0]->suppliername,
            "supppart"           => $theitems[0]->supplierid,
            "manuname"           => $theitems[0]->mfgname,
            "manupart"           => $theitems[0]->mfgid,
            "profit"             => $profit,
            "markup"             => "markup",
            "markupvalue"        => $theitems[0]->markup,
            "qty"                => "1",
            "taxable"            => (int) $theitems[0]->istaxable,
            "inputby"            => Auth::id(),
            "expnumber"          => null,
            "expunit"            => null,
            "withexpiry"         => null,
            "productline"        => $theitems[0]->category,
            "productlineid"      => null,
            "shippingcost"       => null,
            "shippingmarkup"     => null,
            "shippingfinalprice" => null,
            "status"             => "1",
            "created_at"    => date("Y-m-d h:i:s")
        ];

        $savetoqt         = Quoteitemstbl::create($dddd);
        // $lastidinsert = $savetoqt->quoteitemid;
        $id               = $savetoqt->quoteitemid;

        $ciinfo           = DB::table("customerstbls")
                                    ->select("customerstbls.interest")
                                    ->join("quotation_corners","customerstbls.id","=","quotation_corners.custidfk")
                                    ->where("quotation_corners.quoteid",$quoteid)->get();

            $grt          = grttable::where("quoteidfk",$quoteid)->get();
            $custint      = $grt[0]->grttypeid; 

            // set defaults
            $compute                    = new GlobalComputation();
            $compute->unitcost          = $theitems[0]->itemprice;
            $compute->unitcostmarkup    = $theitems[0]->markup;
            $compute->qty               = 1;
            // end 

            // $compute->custint           = $ciinfo[0]->interest;
            $compute->custint              = $custint;

            // start compute 
            $compute->compute();
            // end 

            $status                     = 1;
            $returndata = [
                "profit"                => $compute->profit,
                "itemcost"              => $compute->unitcost,
                "markupvalue"           => $compute->unitcostmarkup,
                "price"                 => $compute->sellprice,
                "extended"              => $compute->extended,
                "shippingfinalprice"    => 0,
                "withshipping"          => 0,
                "shippingcost"          => 0,
                "shippingmarkup"        => 0,
                "status"                => $status,
                "qty"                   => 1
            ];

            $update    = Quoteitemstbl::where("quoteitemid",$id)->update($returndata);
            
        // 2023-03-20 03:55:02
        $data[0] = (Object) array_merge($dddd,["quoteitemid" => $id, "price" => $compute->sellprice, "extended" => $compute->extended, "profit"=>$compute->profit]);

        return view("quotesapplets.displayperitem", compact('data'));
    }

    function sendemail(Request $req) {
        $link    = $req->input("link");
        $subject = $req->input("subject");
        $message = $req->input("message");

        $idfk    = $req->input("id");
        $idfld   = $req->input("idfld");
        $tbl     = $req->input("tbl");

        $emailto    = $req->input("emailto");

        $thecode    = md5(md5(md5(date("mdyhis"))));

        $id       = Auth::id();
        $empreq   = User::where("id",$id)->get(["name","email"])->toArray();

        $appendcode = null;
        if ($emailto == false || $emailto == "false") {
            // $to       = "ajbmerto@gmail.com";
            $to          = "merto.alvinjay@gmail.com";
            // $to         = "Alvin@dimensionsystems.com";
            $emailto    = "Alvin Merto DSI";
            $appendcode = "/".$thecode;
        } else {
            $sendtodetails = User::where("id",$emailto)->get(["name","email"]);
            $to       = $sendtodetails[0]->email;
            $emailto  = $sendtodetails[0]->name;
            $appendcode = "/askingpermission/".$id."/".$thecode;
        }

        $from     = $empreq[0]['email'];
        $fromname = $empreq[0]['name'];

        $emaillink = [
            "thecode"        => $thecode,
            "linktoapprove"  => $link,
            "idfk"           => $idfk,
            "idfld"          => $idfld,
            "thetbl"         => $tbl,
            "requestor"      => $id,
            "approver"       => $to,
            "inputby"        => $id,
            "status"         => "0"
        ];

        $saveemaillink = emaillinkstbl::create($emaillink);

        $info    = ['paytitle'    => $subject, 
                    'email'       => $to,
                    'emailto'     => $emailto,
                    'link'        => $link.$appendcode, 
                    'subject'     => $subject,
                    'fromemail'   => $from,
                    'fromname'    => $fromname,
                    'themessage'  => $message,
                    'approvelink' => url('')."/approve/{$idfk}/{$thecode}",
                    'thedate'     => date("M. d, Y | h:i A")];

        Mail::send('emailview',$info, function($msg) use ($info) {
            $msg->to($info['email'],"{$info['emailto']}")->subject("{$info['paytitle']}");
            $msg->from("{$info['fromemail']}","{$info['fromname']}");
        });
    }

    function updatefields(Request $req) {
        $theitems = (array) $req->input("theitems");
        $tbl      = $req->input("table");
        $thekey   = $req->input("thekey");
        $keyfld   = $req->input("keyfld");

        $update   = DB::table($tbl)->where($keyfld,$thekey)->update($theitems);

        return response()->json($update);
    }

    function sendtocontact(Request $req) {
        $link     = $req->input("link");
        $subject  = $req->input("subject");
        $message  = $req->input("message");

        $template = $req->input("template");

        // to details   
            $toid       = $req->input("to");
            $todetails  = contactstbl::where("contid", $toid)->get(["email","contactname"])->toArray();
            $emailto    = $todetails[0]['contactname'];
            $to         = $todetails[0]['email'];
        // end contact details

        $idfk     = $req->input("id");
        $idfld    = $req->input("idfld");
        $tbl      = $req->input("tbl");

        $id       = Auth::id();
        $empreq   = User::where("id",$id)->get(["name","email"])->toArray();

        $from     = $empreq[0]['email'];
        $fromname = $empreq[0]['name'];

        $thecode  = md5(md5(md5(date("mdyhis"))));

        $link     = $link."/".$thecode;

        $emaillink = [
            "thecode"        => $thecode,
            "linktoapprove"  => $link,
            "idfk"           => $idfk,
            "idfld"          => $idfld,
            "thetbl"         => $tbl,
            "requestor"      => $id,
            "approver"       => $from,
            "inputby"        => $id,
            "status"         => "0"
        ];

        $saveemaillink = emaillinkstbl::create($emaillink);

        $info    = ['paytitle'    => $subject, 
                    'email'       => $to,
                    'emailto'     => $emailto,
                    'link'        => $link,
                    'subject'     => $subject,
                    'fromemail'   => $from,
                    'fromname'    => $fromname,
                    'themessage'  => $message,
                    'approvelink' => url('')."/approve/{$idfk}/{$thecode}",
                    'thedate'     => date("M. d, Y | h:i A")];

        Mail::send($template,$info, function($msg) use ($info) {
            $msg->to($info['email'],"{$info['emailto']}")->subject("{$info['paytitle']}");
            $msg->from("{$info['fromemail']}","{$info['fromname']}");
        });
    }

    public function sendgenericemail(Request $req) {
        $link     = $req->input("link");
        $subject  = $req->input("subject");
        $message  = $req->input("message");

        $template = $req->input("template");

        $idfk     = $req->input("idto");
        $idfld    = $req->input("usertablepkid");
        $tbl      = $req->input("usertablefrom");

        $fieldtoget = $req->input("fieldtoget");
        // to details   
            $toid       = $req->input("idto");
            // $todetails  = contactstbl::where("contid", $toid)->get(["email","contactname"])->toArray();
            $todetails  = DB::select(
                DB::raw(
                    "select {$fieldtoget} from {$tbl} where {$idfld} = '{$idfk}'"
                )
            );

            // $emailto    = $todetails[0]['contactname'];
            $to         = $todetails[0]->$fieldtoget;
        // end contact details

        $id       = Auth::id();
        $empreq   = User::where("id",$id)->get(["name","email"])->toArray();

        $from     = $empreq[0]['email'];
        $fromname = $empreq[0]['name'];

        $thecode  = md5(md5(md5(date("mdyhis"))));

        $link     = $link."/".$thecode;

        $emaillink = [
            "thecode"        => $thecode,
            "linktoapprove"  => $link,
            "idfk"           => $idfk,
            "idfld"          => $idfld,
            "thetbl"         => $tbl,
            "requestor"      => $id,
            "approver"       => $from,
            "inputby"        => $id,
            "status"         => "0"
        ];

        $saveemaillink = emaillinkstbl::create($emaillink);

        $info    = ['paytitle'    => $subject, 
                    'email'       => $to,
                    'link'        => $link,
                    'subject'     => $subject,
                    'fromemail'   => $from,
                    'fromname'    => $fromname,
                    'themessage'  => $message,
                    'thedate'     => date("M. d, Y | h:i A")];

        Mail::send($template,$info, function($msg) use ($info) {
            $msg->to($info['email'],"{$info['email']}")->subject("{$info['paytitle']}");
            $msg->from("{$info['fromemail']}","{$info['fromname']}");
        });

        return response()->json("true");
    }

    public function sendnotification(Request $req) {
        $grpid    = $req->input("grpidfk");
        $link     = $req->input("link");
        $item     = $req->input("item");
        $redirect = $req->input("redirect");

        // $pkid  = $req->input("pkid");
        
        $reference = $req->input("reference");
        $message   = $req->input("message");

        $from      = Auth::user()['name'];
        $fromemail = Auth::user()['email'];
        
        $template  = "notifications";
        
        $recips    = DB::table("sharewithtbns")
                        ->select("sharewithtbns.sharedwith","users.email","users.name")
                        ->join("users","sharewithtbns.sharedwith","=","users.id")
                        ->where(["sharewithtbns.groupidpk"=>$grpid,"sharewithtbns.status"=>"1"])->get();
        
        if (count($recips) > 0) {
            foreach($recips as $rc) {
                if ($fromemail != $rc->email) {
                    $info = [
                        "email"     => $rc->email,
                        "emailto"   => $rc->name,
                        "paytitle"  => "Notification from {$from} on: {$item}",
                        "fromemail" => $fromemail,
                        "fromname"  => $from,
                        "reference" => $reference,
                        "msg"       => (string) $message,
                        "link"      => $link,
                        "thedate"   => date("M. d, Y"),
                        "type"      => $item,
                        "redirect"  => $redirect
                    ];

                    Mail::send($template,$info, function($msg) use ($info) {
                        $msg->to($info['email'],"{$info['emailto']}")->subject("{$info['paytitle']}");
                        $msg->from("{$info['fromemail']}","{$info['fromname']}");
                    });
                }
            }
        }
        
        return response()->json("true");
        // $table  = $recips[0]->tablefrom;
        // $tblid  = $recips[0]->tableid;

    }

    public function updatemultipleitems(Request $req) {
        $thevalue       = $req->input("thevalue");
        $table          = $req->input("table");
        $pkidstoupdate  = (array) $req->input("pkidstoupdate");
        $pkfield        = $req->input("pkfield");
        $fieldtoupdate  = $req->input("fieldtoupdate");

        $updated        = false;
        $a              = "";
        foreach($pkidstoupdate as $pks) {
            $updated = Quoteitemstbl::where($pkfield,$pks)->update([$fieldtoupdate=>$thevalue]);
            // $a .= $pkfield."=".$pks.":";
        }

        return response()->json($updated);
    }

    public function reroute($id = null, $action = null, $routeto = null) {
        return redirect($routeto."/".$id."/".$action);
    }
}
