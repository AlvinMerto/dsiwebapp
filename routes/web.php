<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerstblController;
use App\Http\Controllers\QuotationsController;
use App\Http\Controllers\Processhandler;
use App\Http\Controllers\Offsitecontrol;
use App\Http\Controllers\TheOrdersController;
use App\Http\Controllers\ProductlineController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect("/dashboard");
});

Route::get("/reroute/{id?}/{action?}/{routeto?}",[Processhandler::class,"reroute"])->name("reroute");

Route::get("/approve/{idfk?}/{code?}",[Offsitecontrol::class,"approvenow"])->middleware(['auth', 'verified'])->name("approvenow");

Route::get("/quotation/{quoteid?}/{code?}/{preview?}",[Offsitecontrol::class,"quotation"])->name("quotation");
Route::post("/quotation/{quoteid?}/{code?}",[Offsitecontrol::class,"quotation"])->name("quotation");

Route::get("/optoutnotification/{grpidpk?}/{action?}",[Offsitecontrol::class,"optoutnotification"])->name("optoutnotification")->middleware(['auth', 'verified'])->name('optoutnotification');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/productline/{grpcode?}/{action?}",[ProductlineController::class,"productline"])->middleware(['auth', 'verified'])->name("productline");
Route::post("/productline/{grpcode?}/{action?}",[ProductlineController::class,"productline"])->middleware(['auth', 'verified'])->name("productline");

Route::get("/test", function(){
    date_default_timezone_set("asia/manila");
    echo date_default_timezone_get();

    $datetoday  = date("Y-m-d H:i:s A");

    $createdate = "2023-02-17 05:56:28";
    $compare    = "+1 hour";

    $datetocomp = date('Y-m-d H:i:s A', strtotime($createdate . ' '.$compare.' '));
    
    // echo date('Y-m-d H:i:s', strtotime($createdate . ' '.$compare.' ')); echo " :: "; echo date("Y-m-d h:i:s");
    echo "<br/>";
      echo $datetocomp; echo " = "; echo $datetoday; echo "<br/>";

    if ($datetoday == $datetocomp) {
        echo "equal";
    } else if ($datetocomp > $datetoday) {
        echo "valid";
    } else if ($datetocomp < $datetoday) {
        echo "expired";
    }
});

Route::get("/customer/{id?}/{notif?}/{tbl?}/{tblid?}", [CustomerstblController::class,"customersview"])->middleware(['auth', 'verified'])->name('customer');
Route::get("/phonebook", [CustomerstblController::class,"contactswindow"])->middleware(['auth', 'verified'])->name('phonebook');

// applets
Route::get("/contacts",[CustomerstblController::class,"contacts"])->middleware(['auth', 'verified'])->name('contact');
Route::get("/notes",[CustomerstblController::class,"notes"])->middleware(['auth', 'verified'])->name('notes');
Route::get("/allnotes",[CustomerstblController::class,"allnotes"])->middleware(['auth', 'verified'])->name('allnotes');
Route::get("/viewnote",[CustomerstblController::class,"viewnote"])->middleware(['auth', 'verified'])->name('viewnote');
Route::get("/profiles",[CustomerstblController::class,"profiles"])->middleware(['auth', 'verified'])->name('profiles');
Route::get("/referrals",[CustomerstblController::class,"referrals"])->middleware(['auth', 'verified'])->name('referrals');
Route::get("/pendings",[CustomerstblController::class,"pendings"])->middleware(['auth', 'verified'])->name('pendings');
Route::get("/viewpending",[CustomerstblController::class,"viewpending"])->middleware(['auth', 'verified'])->name('viewpending');
Route::get("/histories",[CustomerstblController::class,"histories"])->middleware(['auth', 'verified'])->name('histories');
Route::get("/historyview",[CustomerstblController::class,"historyview"])->middleware(['auth', 'verified'])->name('historyview');
Route::get("/links",[CustomerstblController::class,"links"])->middleware(['auth', 'verified'])->name('links');
Route::get("/linkview",[CustomerstblController::class,"linkview"])->middleware(['auth', 'verified'])->name('linkview');
Route::get("/summary",[CustomerstblController::class,"summary"])->middleware(['auth', 'verified'])->name('summary');
Route::get("/quotations/{id?}",[CustomerstblController::class,"quotations"])->middleware(['auth', 'verified'])->name('quotations');
Route::get("/contacthistory",[CustomerstblController::class,"contacthistory"])->middleware(['auth', 'verified'])->name('contacthistory');
Route::get("/viewadditionalinfo",[CustomerstblController::class,"viewadditionalinfo"])->middleware(['auth', 'verified'])->name('viewadditionalinfo');
Route::get("/additionalinfo",[CustomerstblController::class,"additionalinfo"])->middleware(['auth', 'verified'])->name('additionalinfo');
Route::get("/activities/{id?}",[CustomerstblController::class,"activities"])->middleware(['auth', 'verified'])->name('activities');
Route::get("/activityview",[CustomerstblController::class,"activityview"])->middleware(['auth', 'verified'])->name('activityview');
Route::get("/workorders",[CustomerstblController::class,"workorders"])->middleware(['auth', 'verified'])->name('workorders');
Route::get("/opportunities",[CustomerstblController::class,"opportunities"])->middleware(['auth', 'verified'])->name('opportunities');
Route::get("/tracking",[CustomerstblController::class,"tracking"])->middleware(['auth', 'verified'])->name('tracking');
Route::get("/transfertonew",[CustomerstblController::class,"transfertonew"])->middleware(['auth', 'verified'])->name('transfertonew');
Route::get("/schedule",[CustomerstblController::class,"schedule"])->middleware(['auth', 'verified'])->name('schedule');
Route::get("/completedactivity",[CustomerstblController::class,"completedactivity"])->middleware(['auth', 'verified'])->name('completedactivity');
Route::get("/forecastedsale",[CustomerstblController::class,"forecastedsale"])->middleware(['auth', 'verified'])->name('forecastedsale');
Route::post("/removemultiple",[CustomerstblController::class,"removemultiple"])->middleware(['auth', 'verified'])->name('removemultiple');
Route::get("/displayitemview",[CustomerstblController::class,"displayitemview"])->middleware(['auth', 'verified'])->name('displayitemview');
// applets

// quotation routes
Route::middleware("auth")->group(function(){
    Route::get("/quotes/{id?}/{quoteid?}/{approvalcode?}/{reqsid?}/{aprvcode?}",[QuotationsController::class,"quotes"])->name('quotes');
    Route::get("/taxable",[QuotationsController::class,"taxable"])->name('taxable');
    Route::get("/nontaxable",[QuotationsController::class,"nontaxable"])->name('nontaxable');
    Route::get("/additem",[QuotationsController::class,"additem"])->name('additem');
    Route::get("/computetotal",[QuotationsController::class,"computetotal"])->name('computetotal');
    Route::get("/displayquote",[QuotationsController::class,"displayquote"])->name('displayquote');
    Route::get("/displayperitem",[QuotationsController::class,"displayperitem"])->name('displayperitem');
    Route::post("/saveperitem_qt",[QuotationsController::class,"saveperitem_qt"])->name('saveperitem_qt');
    Route::get("/taxationtbl",[QuotationsController::class,"taxationtbl"])->name('taxationtbl');
    Route::post("/removeqtitems",[QuotationsController::class,"removeqtitems"])->name('removeqtitems');
    Route::post("/checkformarkups",[QuotationsController::class,"checkformarkups"])->name('checkformarkups');
    Route::get("/uploaditems/{cats?}",[QuotationsController::class,"uploaditems"])->middleware(['auth', 'verified'])->name('uploaditems');
    Route::post("/uploaditems/{cats?}",[QuotationsController::class,"fileupload"])->middleware(['auth', 'verified'])->name('fileupload');
    Route::post("/changevalidity",[QuotationsController::class,"changevalidity"])->name('changevalidity');
    Route::post("/loadmarkups",[QuotationsController::class,"loadmarkups"])->name('loadmarkups');
    Route::post("/viewitemdetails",[QuotationsController::class,"viewitemdetails"])->name('viewitemdetails');
    Route::post("/checkitemneedsapproval",[QuotationsController::class,"checkitemneedsapproval"])->name('checkitemneedsapproval');
    Route::get("/insertotheritems",[QuotationsController::class,"insertotheritems"])->name('insertotheritems');
    Route::get("/loadingcomments",[QuotationsController::class,"loadingcomments"])->name('loadingcomments');
    Route::get("/editsubqty",[QuotationsController::class,"editsubqty"])->name('editsubqty');
    Route::get("/viewoptionsorders",[QuotationsController::class,"viewoptionsorders"])->name("viewoptionsorders");
});
// end of quotes applets


// the orders 
Route::middleware("auth")->group(function(){
    Route::get("/orders/{orderdate?}/{fromvendor?}/{weeklyorder?}",[TheOrdersController::class,"ordertable"])->name('orders');
    Route::post("/orders/{orderdate?}/{fromvendor?}/{weeklyorder?}",[TheOrdersController::class,"ordertable"])->name('orders');
    Route::get("/processed/{weekorderid?}/{fromvendor?}",[TheOrdersController::class,"showprocessedorder"])->name('processed');
    Route::post("/totalestsh",[TheOrdersController::class,"totalestsh"])->name('totalestsh');
    Route::post("/gettotalcost",[TheOrdersController::class,"gettotalcost"])->name('gettotalcost');
});
// end 

// utilities 
Route::middleware("auth")->group(function(){
    Route::post("/savetodatabase", [Processhandler::class,"savetodatabase"])->name("savetodatabase");    
    Route::post("/saveperitem", [Processhandler::class,"saveperitem"])->name("saveperitem");       
    Route::post("/removeitem",[Processhandler::class,"removeitem"])->name('removeitem');
    Route::post("/transfer",[Processhandler::class,"transfer"])->name('transfer');
    Route::post("/gettasks",[Processhandler::class,"gettasks"])->name('gettasks');
    Route::post("/saveexisting",[Processhandler::class,"saveexistingitem"])->name('saveexisting');
    Route::post("/sendemail",[Processhandler::class,"sendemail"])->name('sendemail');
    Route::post("/sendtocontact",[Processhandler::class,"sendtocontact"])->name('sendtocontact');
    Route::post("/updatefields",[Processhandler::class,"updatefields"])->name('updatefields');
    Route::post("/sendnotification",[Processhandler::class,"sendnotification"])->name('sendnotification');
    Route::post("/updatemultipleitems",[Processhandler::class,"updatemultipleitems"])->name('updatemultipleitems');
    Route::post("/sendgenericemail",[Processhandler::class,"sendgenericemail"])->name('sendgenericemail');
    Route::post("/saveorupdate",[Processhandler::class,"saveorupdate"])->name('saveorupdate');
    Route::post("/getitemdetails",[Processhandler::class,"getitemdetails"])->name("getitemdetails");
    // Route::post("/saveaddoninfo",[Processhandler::class,"saveaddoninfo"])->name("saveaddoninfo");
});
// end utilities

Route::post("/newrecord", [CustomerstblController::class,"newrecord"])->middleware(['auth', 'verified'])->name('contact');
Route::post("/saveinfo",[CustomerstblController::class,"saveinfo"])->middleware(['auth', 'verified'])->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
