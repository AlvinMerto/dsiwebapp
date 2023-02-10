<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Customerstbl;
use App\Models\Sourcetbl;
use App\Models\User;
use App\Models\contactstbl;
use App\Models\contactfluidtbl;
use App\Models\contacthistorytbl;
use App\Models\Notestbl;
use App\Models\Linkstbl;
use App\Models\Taskstbl;
use App\Models\historytbl;
use App\Models\intereststbl;
use App\Models\itemstbl;
use App\Models\QuotationCorner;

use DB;
class CustomerstblController extends Controller
{
    function newrecord(Request $reqs){
        $data = ["companyname"     => $reqs->input("companyname"),
                 "contactperson"   => $reqs->input("contactperson"),
                 "contactnumber"   => $reqs->input("contactnumber"),
                 "email"           => $reqs->input("emailadd"),
                 "salespersonidfk" => Auth::id()
                ];
        $save = Customerstbl::create($data);
        
        $newrecord = Customerstbl::all();

        return response()->json($newrecord[count($newrecord)-1]->id);
    }

    function customersview($id = null, $notif = false, $tbl = false, $tblid = false) {
        if ($id != null) {
            $data        = null;
            $source      = null;
            $salesperson = null;

            // $data        = customerstbl::where("id",$id)->get();
            $data        = DB::table("customerstbls")
                                ->select("customerstbls.*","intereststbls.theinterest","intereststbls.interid")
                                ->leftJoin("intereststbls","customerstbls.interest","=","intereststbls.interid")
                                ->where("customerstbls.id",$id)->get();
            
            $salesperson = User::where("id",$data[0]->salespersonidfk)->get("name")->toArray()[0]['name'];
            $source      = Sourcetbl::all();
            $interest    = intereststbl::all();
            
            return view('customer',compact('data','source','salesperson','id','interest'));
        } else {
            $data       = customerstbl::all();
            
            $quotecount = DB::select(
                DB::raw("select count(quoteid) as qcount, custidfk from quotation_corners GROUP by custidfk")
            );
            
            $qtcnt = [];
            foreach($quotecount as $qc) {
                $qtcnt[$qc->custidfk] = $qc->qcount;
            }

            return view('customerlist', compact('data','qtcnt'));
        }
    }

    function saveinfo(Request $req) {
        $data = (array) $req->input("basicinfo");
        $id = $req->input("id");

        $update = customerstbl::where("id",$id)->update($data);

        return response()->json($update);
    }

    function contacts(Request $req) {
        if ($req->input("id") == false || $req->input("id") == "false") {
            return view("applets.contactview");
        } else {
            if ($req->input('viewdeck') == true) {
                $contid = $req->input("id");
                // $data = contactstbl::where("contid",$contid)->get();
                $data    = DB::table("contactstbls")
                                ->select("contactstbls.*","customerstbls.companyname")
                                ->join("customerstbls","contactstbls.custidfk","=","customerstbls.id")
                                ->where("contid",$contid)->get();

                // $data    = DB::table("contactstbls")
                //             ->select("contactstbls.*","customerstbls.companyname")
                //             ->join("customerstbls","contactstbls.custidfk","=","customerstbls.id")
                //             ->where(["contactstbls.contid"=>$contid])->get();

                return view("applets.contactview", compact("data"));
            } else {
                $custid = $req->input("id");
                $data   = contactstbl::where(["custidfk"=>$custid,"status" => "1"])->get();
                return view("applets.contacts", compact('data','custid'));
            }
        }
    }

    function notes(Request $req) {
        $custid = $req->input("id");
        
        $data    = Notestbl::where("custid",$custid)->get();

        $users   = User::all();
        $groupid = $custid."_".md5( date("mdyhis") );

        return view("applets.notes", compact('data','users','custid','groupid'));
    }

    function allnotes(Request $req) {
            $custid = $req->input("id");
            
            $ownerid = Auth::id();
            // $data   = DB::select( 
            //     DB::raw(
            //         "select * from 
            //             (select notestbls.*, users.name, sharewithtbns.swid from notestbls 
            //                 join sharewithtbns on notestbls.groupidfk = sharewithtbns.groupidpk 
            //                 join users on notestbls.inputby = users.id 
            //                 where sharewithtbns.sharedwith = '{$ownerid}' or sharewithtbns.sharedwith = 'all') 
            //             as tbl1 where tbl1.custid = '{$custid}'"
            //         )
            // );
            $data = DB::select(
                DB::raw("
                        select tbl1.*, users.name from 
                            (select * from notestbls where groupidfk in 
                                (select groupidpk from sharewithtbns where sharedwith = '{$ownerid}' or sharedwith = 'all' and status = 1)) as tbl1 
                                join users on tbl1.inputby = users.id where tbl1.custid = '{$custid}';  
                ")
            );

            //  or tbl1.inputby = '{$ownerid}'
            // var_dump($data);
           return view("applets.allnotes",compact("data", 'custid', "ownerid"));
    }

    function viewnote(Request $req) {
        $noteid = $req->input("id");
        // $notes  = Notestbl::where("noteid", $noteid)->get()->toArray();
        $notes     = DB::table("notestbls")
                        ->select("notestbls.*","users.name")
                        ->join("users","notestbls.inputby","=","users.id")
                        ->where("notestbls.noteid",$noteid)->get()->toArray();

        $viewer = Auth::id();
        return view("applets.viewnote", compact('notes',"viewer"));
    }

    function profiles(Request $req) {
        if ($req->input("id") == false || $req->input("id") == "false") {
            return view("applets.profiles");
        } else {
            return view("applets.profileview");
        }
    }

    function referrals(Request $req) {
        if ($req->input("id") == false || $req->input("id") == "false") {
            return view("applets.referrals");
        } else {
            return view("applets.addreference");
        }
    }

    function pendings(Request $req) { // tasks
        $custid = $req->input("id");

        $ownerid = Auth::id();
        // $data    = DB::select( 
        //         DB::raw(
        //             "select * from 
        //                 (select taskstbls.*, users.name, sharewithtbns.swid from taskstbls 
        //                     join sharewithtbns on taskstbls.groupidfk = sharewithtbns.groupidpk 
        //                     join users on taskstbls.inputby = users.id 
        //                     where sharewithtbns.sharedwith = '{$ownerid}' or sharewithtbns.sharedwith = 'all') 
        //                 as tbl1 where tbl1.custid = '{$custid}'"
        //             )
        //     );

        $data = DB::select(
            DB::raw("
                    select tbl1.*, users.name from 
                        (select * from taskstbls where groupidfk in 
                            (select groupidpk from sharewithtbns where sharedwith = '{$ownerid}' or sharedwith = 'all' and status = 1)) as tbl1 
                    join users on tbl1.inputby = users.id where tbl1.custid = '{$custid}';  
            ")
        );

        return view("applets.pendings",compact('data'));
    }

    function viewpending(Request $req) { // view task
        $taskid = $req->input("id");

        $data = DB::table("taskstbls")
                    ->select("taskstbls.*", "contactstbls.contactname")
                    ->join("contactstbls","taskstbls.contactid","=","contactstbls.contid")
                    ->where("taskstbls.taskid",$taskid)->get();
        
        $replies = DB::table("replytbls")
                    ->select("replytbls.*","users.name")
                    ->join("users","replytbls.inputby","=","users.id")
                    ->where("replytbls.taskid",$taskid)->orderBy("replyid","DESC")->get();
        
        return view("applets.pendingview", compact("data","replies"));
    }

    function histories(Request $req) {
        if ($req->input("id") == false || $req->input("id") == "false") {            
           //  return view("applets.historiesview");
        } else {
            // $data = historytbl::where("custidfk",$req->input("id"))->get();
            $data    = DB::table("historytbls")
                            ->select("historytbls.*","users.name")
                            ->join("users","historytbls.inputby","=","users.id")
                            ->where("historytbls.custidfk",$req->input("id"))->get();

            return view("applets.histories", compact("data"));
        }
    }

    function historyview(Request $req) {
        $data    = $req->input("id");
        $id      = explode("_",$data)[0];
        $table   = explode("_",$data)[1];

        $tablekey = [
            "contactfluidtbls"      => "cffid",
            "contacthistorytbls"    => "conthisid",
            "contactstbls"          => "contid",
            "customerstbls"         => "id",
            "linkstbls"             => "sourceid",
            "notestbls"             => "noteid",
            "quotations"            => "id",
            "replytbls"             => "replyid",
            "sharewithtbns"         => "swid",
            "sourcetbls"            => "id",
            "taskstbls"             => "taskid",
            "users"                 => "id"
        ];
      //  var_dump($index);
        $details = DB::table($table)
                    ->select($table.".*","users.name")
                    ->join("users", $table.".inputby","=","users.id")
                    ->where($tablekey[$table],$id)->get();

        return view("applets.historiesview", compact("id","table", 'details'));
    }

    function links(Request $req) {
        $custid  = $req->input("id");

        $users   = User::all();
        $groupid = $custid."_".md5( date("mdyhis") );

        $ownerid = Auth::id();
        // $data    = DB::select( 
        //         DB::raw(
        //             "select * from 
        //                 (select linkstbls.*, users.name, sharewithtbns.swid from linkstbls 
        //                     join sharewithtbns on linkstbls.groupidfk = sharewithtbns.groupidpk 
        //                     join users on linkstbls.inputby = users.id 
        //                     where sharewithtbns.sharedwith = '{$ownerid}' or sharewithtbns.sharedwith = 'all') 
        //                 as tbl1 where tbl1.custid = '{$custid}'"
        //             )
        //     );

        $data = DB::select(
            DB::raw("
                    select tbl1.*, users.name from 
                        (select * from linkstbls where groupidfk in 
                            (select groupidpk from sharewithtbns where sharedwith = '{$ownerid}' or sharedwith = 'all' and status = 1)) as tbl1 
                    join users on tbl1.inputby = users.id where tbl1.custid = '{$custid}';  
            ")
        );

        return view("applets.links", compact('users','groupid',"custid","data"));        
    }

    function linkview(Request $req) {
        $linkid   = $req->input("id");

        // $alllinks = Linkstbl::where("sourceid",$linkid)->get()->toArray();
        $alllinks  = DB::table("linkstbls")
                        ->select("linkstbls.*","users.name")
                        ->join("users","linkstbls.inputby","=","users.id")
                        ->where("sourceid",$linkid)->get()->toArray();

        $viewer   = Auth::id();
        return view("applets.linksview", compact("alllinks","viewer"));
    }

    function summary(Request $req) {
        return view("applets.summary");
    }

    function quotations(Request $req){
        $clientid = $req->input("id");

        $data = DB::select(
            DB::raw(
                "SELECT quotation_corners.*, totalpricetbls.profit, totalpricetbls.gp, totalpricetbls.cost, 
                    totalpricetbls.subtotal, totalpricetbls.tax , contactstbls.contactname, users.name 
                    FROM `quotation_corners` left join totalpricetbls on quotation_corners.quoteid = totalpricetbls.quoteidfk 
                    left join contactstbls on quotation_corners.quotationsentto = contactstbls.contid 
                    join users on quotation_corners.inputby = users.id where quotation_corners.custidfk = {$clientid}"
            )
        );

        return view("applets.quotations",compact('clientid',"data"));
    }

    function contacthistory(Request $req) {
        $contactid = $req->input("id");

        $data = contacthistorytbl::where("contidfk",$contactid)->orderBy("conthisid","DESC")->get();
        
        return view("applets.contacthistory", compact('contactid','data'));
    }

    function viewadditionalinfo(Request $req) {
        $contactid = $req->input("id");

        $data = contactfluidtbl::where(["contidfk"=>$contactid,"status"=>'1'])->get();
        return view("applets.viewadditionalinfo", compact('contactid','data'));
    }
    
    function additionalinfo(Request $req) {
        $contactid = $req->input("id");

        $fields = contactfluidtbl::all();
        return view("applets.contactaddinfo", compact('contactid','fields'));
    }

    function activities(Request $req) {
        $custid  = $req->input("id");

        $users   = User::all();
        $groupid = $custid."_".md5( date("mdyhis") );
         
        $ownerid = Auth::id();
        // $data    = DB::select( 
        //         DB::raw(
        //             "select * from 
        //                 (select taskstbls.*, users.name, sharewithtbns.swid from taskstbls 
        //                     join sharewithtbns on taskstbls.groupidfk = sharewithtbns.groupidpk 
        //                     join users on taskstbls.inputby = users.id 
        //                     where sharewithtbns.sharedwith = '{$ownerid}' or sharewithtbns.sharedwith = 'all') 
        //                 as tbl1 where tbl1.custid = '{$custid}'"
        //             )
        //     );

        $data = DB::select(
            DB::raw("
                    select tbl1.*, users.name from 
                        (select * from taskstbls where taskstbls.status = '2' and groupidfk in 
                            (select groupidpk from sharewithtbns where sharedwith = '{$ownerid}' or sharedwith = 'all' and status = 1)) as tbl1 
                    join users on tbl1.inputby = users.id where tbl1.custid = '{$custid}';  
            ")
        );

        return view("applets.activities", compact("data"));
   
    }

    function activityview(Request $req) {
        $taskid = $req->input("id");

        $data = DB::table("taskstbls")
                    ->select("taskstbls.*", "contactstbls.contactname")
                    ->join("contactstbls","taskstbls.contactid","=","contactstbls.contid")
                    ->where("taskstbls.taskid",$taskid)->orderBy("taskid","DESC")->get();
        
        $replies = DB::table("replytbls")
                    ->select("replytbls.*","users.name")
                    ->join("users","replytbls.inputby","=","users.id")
                    ->where("replytbls.taskid",$taskid)->orderBy("replyid","DESC")->get();

        $users   = User::all();
    //    $groupid = 
        return view("applets.activityview", compact("data","replies","users"));
    }

    function workorders(Request $req) {
        switch($req->input("applet")) {
            case "invoice":
                return view("workorders.invoice");
                break;
            case "workreqs":
                    return view("workorders.workrequest");
                break;
            case "items":
                    return view("workorders.itemdropped");
                break;
            case "workcomplete":
                    return view("workorders.workcomplete");
                break;
            default:
                return view("applets.workorders");
                break;
        }
    }

    function opportunities() {
        return view("applets.opportunities");
    }

    function tracking() {
        return view("applets.tracking");
    }

    function transfertonew(Request $req) {
        $contid = $req->input("id");

        $data = Customerstbl::all();
        return view("applets.transfertonew", compact('data','contid'));
    }

    function schedule(Request $req) {
        $custid  = $req->input("id");
        $users   = User::all();

        $customercontacts = contactstbl::where(["custidfk"=>$custid,'status'=>1])->get();

        $groupid = $custid."_".md5( date("mdyhis") ); 
        return view("applets.schedule", compact("users","groupid","customercontacts","custid"));
    }

    function completedactivity(Request $req) {
        $custid  = $req->input("id");
        $users   = User::all();

        $customercontacts = contactstbl::where(["custidfk"=>$custid,'status'=>1])->get();

        $groupid = $custid."_".md5( date("mdyhis") ); 
        return view("applets.completedactivity", compact("users","groupid","customercontacts","custid"));
    }

    function forecastedsale(Request $req) {
        return view("applets.forecastedsale");
    }

    function contactswindow(Request $req) {
        $contacts = DB::table("contactstbls")
                        ->select("contactstbls.*","customerstbls.companyname","customerstbls.id")
                        ->join("customerstbls","contactstbls.custidfk","=","customerstbls.id")->get();

        $customer = Customerstbl::all();
        return view("contactwindow",compact('contacts',"customer"));
    }

    function removemultiple(Request $req) {
        $theids = $req->input("theids");
        $table  = $req->input("table");
        $idfld  = $req->input("idfld");

        $delete = false;
        foreach($theids as $ti) {
            $delete = DB::table($table)->where($idfld,$ti)->delete();
        }

        return response()->json($delete);
    }

    function displayitemview(Request $req) {
        $itemid = $req->input("id");

        $details = itemstbl::where("itemid", $itemid)->get();
        return view("applets.displayitemview", compact("details"));
    }
}
