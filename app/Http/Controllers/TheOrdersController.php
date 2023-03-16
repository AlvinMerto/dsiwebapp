<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QuotationCorner;
use App\Models\TheOrders;

use DB;
use Auth;
use Carbon\Carbon;

class TheOrdersController extends Controller
{
    //

    public function ordertable($orderdate = null, $fromvendor = null, $weeklyorder = null) {
        $data    = null;
        $headers = null;
        $totals  = null; 
        $qtidfks = null;

        if (isset($_POST['genweeklyid'])) {
            $orderdate = $_POST['orderdate'];
        }

        if ($orderdate != null) {
            list($from, $to) = explode("_", $orderdate);
            
            if (strlen($from) <= 0 || strlen($to) <= 0) { die("Dates cannot be empty"); }

            $to    = date("Y-m-d", strtotime("+1 day", strtotime($to)));
            
            $where = null;

            if($fromvendor != null) {
                $where = "where tbl1.suppname = '{$fromvendor}'";
            }

            $qtidfks  = [];

            $wherein = "select quoteid from quotation_corners where status='3' and orderdate between '{$from}' and '{$to}'";

            if (isset($_POST['genweeklyid'])) {
                $qtidfks = (array) json_decode($_POST['qtidfks']);

                $wherein_inner = "'".implode("','",$qtidfks)."'";
                // save to the orderstable 
                // redirect to this page with weeklyorder id 
                $getdata = "select tbl1.*, tbl1.totalqty*totalprice as extendedprice 
                                    from (select *, sum(qty) as totalqty, sum(itemcost) as totalprice 
                                        from quoteitemstbls where quoteidfk in ({$wherein_inner}) GROUP by itemdesc, itemcost, suppname) as tbl1";
                $dataforsave    = DB::select(DB::raw($getdata));

                $bulkorderid    = md5(md5(md5( date("mdyhis") )));
                $processeddate  = date("Y-m-d");

                // var_dump($qtidfks); return;

                if (count($dataforsave) > 0) {
                    foreach($dataforsave as $dfs) {
                        $total  = $dfs->extendedprice+0;

                        $saveorders = TheOrders::create([
                            "quoteid" 	        => $dfs->quoteidfk,
                            "custidfk" 	        => null,
                            "contidfk" 	        => null,
                            "processeddate" 	=> $processeddate,
                            "bulkorderid" 	    => $bulkorderid,
                            "vendor" 	        => $dfs->suppname,
                            "description" 	    => $dfs->itemdesc,
                            "qty" 	            => $dfs->totalqty,
                            "unitcost" 	        => $dfs->totalprice,
                            "extendedcost" 	    => $dfs->extendedprice,
                            "estimatedsh" 	    => null,
                            "estimatedshtax" 	=> null,
                            "tax" 	            => null,
                            "totalcost" 	    => $total,
                            "inputby" 	        => Auth::id(),
                            "status"            => "1"
                        ]);
                    }
                    
                    // update the QuotationCorner
                    
                    foreach($qtidfks as $qs) {
                        echo "hello".$qs."<br/>"; // buffer to the screen
                        $updateqtc = QuotationCorner::where("quoteid",$qs)->update(["status"=>"8"]);
                    }

                    return redirect("processed/{$bulkorderid}");
                    
                }
            } else {
                // $wherein = "select quoteid from quotation_corners where orderdate between '{$from}' and '{$to}'";
            }

            if ($weeklyorder != null) {
                // select from the the_orders table
            } else {
                $itemsdata = "select tbl1.*, tbl1.totalqty*totalprice as extendedprice 
                                    from (select *, sum(qty) as totalqty, sum(itemcost) as totalprice 
                                        from quoteitemstbls where quoteidfk in ({$wherein}) GROUP by itemdesc, itemcost, suppname) as tbl1";
                    
                $itemsdata1 = "select distinct(tbl1.suppname) as suppname
                                    from (select *, sum(qty) as totalqty, sum(price) as totalprice 
                                        from quoteitemstbls where quoteidfk in ({$wherein}) GROUP by itemdesc, itemcost, suppname) as tbl1";
            }
            // echo $itemsdata1;
            // echo $itemsdata; // return;
            $data    = DB::select(DB::raw($itemsdata." ".$where));
            $headers = DB::select(DB::raw($itemsdata1));

            $totals = [
                "totalqty"          => 0,
                "totalprice"        => 0,
                "totalextendprice"  => 0,
                "totalestimatedsh"  => 0,
                "totaltotalcost"    => 0
            ];

            if (count($data) > 0) {
                foreach($data as $d) {
                    $total  = $d->extendedprice+0;

                    $totals['totalqty']           = $totals['totalqty']+$d->totalqty;
                    $totals['totalprice']         = $totals['totalprice']+$d->totalprice;
                    $totals['totalextendprice']   = $totals['totalextendprice']+$d->extendedprice;
                    $totals['totalestimatedsh']   = 0;
                    $totals['totaltotalcost']     = $totals['totaltotalcost']+$total;

                    //$totals['grand']
                    if (count($qtidfks) == 0 || !in_array($d->quoteidfk, $qtidfks)) {
                        array_push($qtidfks,$d->quoteidfk);
                    }
                }
            }

            // var_dump($qtidfks);
            $orderdate = "orders/".$orderdate;
            $title     = "Orders";
            $funcfrom  = "ordertable";
            return view("theorders", compact("data","headers","orderdate","fromvendor","totals","qtidfks","title","funcfrom"));
        } else {
            $orderswaiting   = DB::table("quotation_corners")
                                    ->select("quotation_corners.*","customerstbls.companyname")
                                    ->join("customerstbls","quotation_corners.custidfk","=","customerstbls.id")
                                    ->where("quotation_corners.status","3")->get();

            $processedorders = DB::select(DB::raw(
                "select *, sum(totalcost) as totalcost from the_orders GROUP BY bulkorderid"
            ));
            return view("allorders", compact('processedorders','orderswaiting'));
        }

    }

    public function showprocessedorder($weeklyorder = null, $fromvendor = null) {
        $where = null;
        if ($fromvendor != null) {
            $where = " and vendor = '{$fromvendor}'";
        }
        $data = DB::select(DB::raw(
            "select 
                theorderid,
                vendor as suppname, 
                description as itemdesc,
                qty as totalqty,
                unitcost as totalprice,
                extendedcost as extendedprice,
                estimatedsh,
                estimatedshtax,
                totalcosttax,
                tax from the_orders where bulkorderid = '{$weeklyorder}' {$where}
            "
        ));

        $orderdate  = "processed/".$weeklyorder;
        $qtidfks    = [];
        $totals = [
            "totalqty"          => 0,
            "totalprice"        => 0,
            "totalextendprice"  => 0,
            "totalestimatedsh"  => 0,
            "totaltotalcost"    => 0,
            "extcostwithtax"    => 0,
            "estshwithtax"      => 0,
            "totcostwithtax"    => 0
        ];

        if (count($data) > 0) {
            foreach($data as $d) {
                $total  = $d->extendedprice+$d->estimatedsh;

                $totals['totalqty']           = $totals['totalqty']+$d->totalqty;
                $totals['totalprice']         = $totals['totalprice']+$d->totalprice;
                $totals['totalextendprice']   = $totals['totalextendprice']+$d->extendedprice;
                $totals['totalestimatedsh']   = $totals['totalestimatedsh']+$d->estimatedsh;
                $totals['totaltotalcost']     = $totals['totaltotalcost']+$total;

                // if (count($qtidfks) == 0 || !in_array($d->quoteidfk, $qtidfks)) {
                //     array_push($qtidfks,$d->quoteidfk);
                // }
            }

            $extendtax  = $data[0]->tax/100;
            $estshtax   = $data[0]->estimatedshtax/100;
            $totcosttax = $data[0]->totalcosttax/100;
            
            $extval     = $totals['totalextendprice']*$extendtax;
            $estshval   = $totals['totalestimatedsh']*$estshtax;
            $totcostval = $totals['totaltotalcost']*$totcosttax;

            $totals['extcostwithtax']  = $totals['totalextendprice']+$extval;
            $totals['estshwithtax']    = $totals['totalestimatedsh']+$estshval;
            $totals['totcostwithtax']  = $totals['totaltotalcost']+$totcostval;
        }

        $headers   = TheOrders::where("bulkorderid",$weeklyorder)->get("vendor as suppname");
        $title     = "Processed Orders";
        $funcfrom  = "processed";

        // $ddate = "2012-10-18";
        // $date = new DateTime($ddate);
        // $week = $date->format("W");
        // echo $week;
        // echo Carbon::today();
        return view("theorders", compact("data","headers","orderdate","fromvendor","totals","qtidfks","title","funcfrom","weeklyorder"));
    }

    function totalestsh(Request $req) {
        $grpid      = $req->input("grpid");
        $fromvendor = $req->input("fromvendor");

        $getthetotalfrom = $req->input("gettotalfrom");

        $where      = null;
        if (strlen($fromvendor) > 0) {
            $where = " and vendor = '{$fromvendor}'";
        }

        if ($getthetotalfrom == "totestimatedsh") {
            $data = DB::select(DB::raw(
                "select sum(estimatedsh) as totalestimatedsh from the_orders where bulkorderid = '{$grpid}' {$where}"
            ));

            $value = 0;
            if (count($data) > 0) {
                $value = $data[0]->totalestimatedsh;
            }
        } else if ($getthetotalfrom == "totalcost") {
            $data = DB::select(DB::raw(
                "select sum(totalcost) as grandtotalcost from the_orders where bulkorderid = '{$grpid}' {$where}"
            ));

            $value = 0;
            if (count($data) > 0) {
                $value = $data[0]->grandtotalcost;
            }
        } else if ($getthetotalfrom == "grandextendedcost") {
            $data = DB::select(DB::raw(
                "select sum(extendedcost) as grandextendedcost, tax from the_orders where bulkorderid = '{$grpid}' {$where}"
            ));

            $value = 0;
            if (count($data) > 0) {
                $tax   = $data[0]->tax/100;
                $tt    = $data[0]->grandextendedcost*$tax;
                $value = $data[0]->grandextendedcost+$tt;
            }

        } else if ($getthetotalfrom == "grandestsh") {
            $data = DB::select(DB::raw(
                "select sum(estimatedsh) as grandestsh, estimatedshtax from the_orders where bulkorderid = '{$grpid}' {$where}"
            ));

            $value = 0;
            if (count($data) > 0) {
                $tax   = $data[0]->estimatedshtax/100;
                $tt    = $data[0]->grandestsh*$tax;
                $value = $data[0]->grandestsh+$tt;
            }
        } else if ($getthetotalfrom == "gggrandtotalcost") {
            $data = DB::select(DB::raw(
                "select sum(totalcost) as grandtotalcost, totalcosttax from the_orders where bulkorderid = '{$grpid}' {$where}"
            ));

            $value = 0;
            if (count($data) > 0) {
                $tax   = $data[0]->totalcosttax/100;
                $tt    = $data[0]->grandtotalcost*$tax;
                $value = $data[0]->grandtotalcost+$tt;
            }
        }

        return response()->json( number_format($value,2) );
    }

    function gettotalcost(Request $req) {
        $orderid   = $req->input("orderid");
        // $vendor    = $req->input("vendor");

        $thevalues = TheOrders::where(["theorderid"=>$orderid])->get(["estimatedsh","extendedcost"]); // 

        $totalcost = $thevalues[0]->extendedcost+$thevalues[0]->estimatedsh;

        $update    = TheOrders::where("theorderid",$orderid)->update(["totalcost"=>$totalcost]);
        
        return response()->json( number_format($totalcost,2));
    }

}
