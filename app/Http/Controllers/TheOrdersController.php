<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QuotationCorner;
use App\Models\TheOrders;

use DB;
use Auth;

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
                $dataforsave = DB::select(DB::raw($getdata));

                $bulkorderid    = md5(md5(md5("mdyhis")));
                $processeddate  = date("Y-m-d");

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
                            "estimatedsh" 	    => "0",
                            "estimatedshtax" 	=> "0",
                            "tax" 	            => "0",
                            "totalcost" 	    => $total,
                            "inputby" 	        => Auth::id(),
                            "status"            => "1"
                        ]);
                    }
                    
                    // update the QuotationCorner
                    foreach($qtidfks as $qs) {
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
                                        from quoteitemstbls where quoteidfk in ({$wherein}) GROUP by itemdesc) as tbl1";
            }

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

                    if (count($qtidfks) == 0 || !in_array($d->quoteidfk, $qtidfks)) {
                        array_push($qtidfks,$d->quoteidfk);
                    }
                }
            }

            // var_dump($qtidfks);
            $orderdate = "orders/".$orderdate;
            $title   = "Orders";
            return view("theorders", compact("data","headers","orderdate","fromvendor","totals","qtidfks","title"));
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
                vendor as suppname, 
                description as itemdesc,
                qty as totalqty,
                unitcost as totalprice,
                extendedcost as extendedprice,
                totalcost, 
                estimatedsh,
                estimatedshtax,
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
            "totaltotalcost"    => 0
        ];

        $headers = TheOrders::where("bulkorderid",$weeklyorder)->get("vendor as suppname");
        $title   = "Processed Orders";
        return view("theorders", compact("data","headers","orderdate","fromvendor","totals","qtidfks","title"));
    }
}
