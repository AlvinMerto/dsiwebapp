let a = new Dsifronprocs();
let tabname   = null;
let overallid = null;

let theids    = [];

a.ajaxsetup();

let months    = ["January","February","March","April","May","June","July","August","September","October","November","December"];
window.onload = function(){
    $(document).find(".tabs").eq(0).addClass("nowactive");
    a.showdwindow("summary");

    // a.setdocumenttitle( "DSI Webapp | "+$(document).find("#doctitle").val() );

    a.getthetasks();
};

$(document).on("click",".tabs",function(e){
    document.title = " DSI Webapp "+$(this).data("doctitle");
    $(this).siblings().removeClass("nowactive");
    $(this).addClass("nowactive")
    
    tabname        = $(this).data("tabname");
    overallid      = $(this).data("id");

    a.showdwindow(tabname,overallid);
});

$(document).on("click",".intablink",function(){
    //  modalname
    $(document).find("#modalname").html( $(this).text() );

    let intabviewspan = $(this).data("viewspan");

    if (undefined == intabviewspan) {
        intabviewspan = false;
    }

    a.intablinkwindow( $(this).data("tab"), $(this).data('id'), true, intabviewspan );
});

$(document).on("click","#savenewrecord", function(){
    var companyname   = $(document).find("#companyname").val(),
        contactperson = $(document).find("#contactperson").val(),
        contactnumber = $(document).find("#contactnumber").val(),
        emailadd      = $(document).find("#emailaddress").val();

    a.savenewrecord(companyname,contactperson,contactnumber,emailadd);
});

$(document).on("click","#savebasicinfo",function(){
    var basicinfo                = new Object();
        basicinfo.companyname    = $(document).find("#compname").val();
        basicinfo.contactperson  = $(document).find("#contper").val();
        basicinfo.contactnumber  = $(document).find("#contnum").val();
        basicinfo.dept           = $(document).find("#depttxt").val();
        basicinfo.srcidfk        = $(document).find("#srctxt").val();
        basicinfo.email          = $(document).find("#emailadd").val();
        basicinfo.website        = $(document).find("#websitetxt").val();

    var id = $(this).data('custid');

        a.saveinfo(basicinfo,id);
});

$(document).on("click","#saveaddress", function(){
    var basicinfo         = new Object();
        basicinfo.address = $(document).find("#address").val();
        basicinfo.city    = $(document).find("#city").val();
        basicinfo.zip     = $(document).find("#zip").val();
        basicinfo.country = $(document).find("#country").val();
        basicinfo.state   = $(document).find("#state").val();

    var id = $(this).data("custid");
        a.saveinfo(basicinfo,id);
});

$(document).on("click","#savebusiness",function(){
    var basicinfo = new Object();
        basicinfo.industry = $(document).find("#industry").val();
        basicinfo.interest = $(document).find("#interest").val();
        basicinfo.siccode  = $(document).find("#siccode").val();

    var id = $(this).data("custid");

        a.saveinfo(basicinfo,id);
});

$(document).on("click","#findarecord", function(){
    window.location.href = url+"/customer";
});

$(document).on("click" ,function(e) {
    $(document).find(".contextmenushow").remove();
});

$(document).on("contextmenu", "#contextmenu" ,function(e) {
    e.preventDefault();

    $(document).find(".contextmenushow").remove();
    $("<div class='contextmenushow'>"+
        "<ul>"+
            "<li id='itemdetails' data-toggle='modal' data-target='#viewitemdetails'> Item details </li>"+
            "<li data-toggle='modal' data-target='#insertitem' class='callitemssource' data-window='additem'> Add Custom Item </li>"+
            "<li data-toggle='modal' data-target='#insertitem' class='callitemssource' data-window='taxable'> Insert item from a product line </li>"+
            "<li data-toggle='modal' data-target='#subtotaldiv'> Subtotal </li>"+
            "<li data-toggle='modal' data-target='#insertotheritem' class='callwindow' data-window='insertotheritems' data-insertospan='insertotheritemspan'> <i class='fa fa-angle-right' aria-hidden='true'></i> Labor </li>"+
            "<li data-toggle='modal' data-target='#insertotheritem' class='callwindow' data-window='insertotheritems' data-insertospan='insertotheritemspan'> <i class='fa fa-angle-right' aria-hidden='true'></i> Freight </li>"+
            "<li data-toggle='modal' data-target='#addcomment' class='callwindowwithid' data-window='loadingcomments' data-insertospan='loadingcommentsspan'> Comment </li>"+
            "<li id='removebtncontext'> Remove </li>"+
        "</ul>"+
     "</div>").css({
            top: e.clientY - $(".contextmenushow").height() / 2,
            left: e.clientX
        }).appendTo("#contextmenu");
});

let windowselected = null;

$(document).on("change","#categorylist", function(){
    a.showitemcats( windowselected, $(this).val() );
});

$(document).on("click",".callitemssource", function(){
    windowselected = $(this).data("window");

    a.showitemcats( windowselected, $(document).find("#categorylist").val() );
    
    $(document).find("#industrytype").html( $(document).find("#intervalue").val() )
});

// $(document).on("change","#percentageselect",function(){
//     if ($(this).val() == "customper") {
//         $(document).find("#custpertxt").show();
//     } else {
//         $(document).find("#custpertxt").hide();
//     }
// });

$(document).on("blur","#textchangetxt", function(e) {
    if ($(this).val().length > 0) {
        $("<span class='sharewith'>"+$(this).val()+"</span>,")
            .on("click", function(){
                $(this).remove();
            }).appendTo("#sharei");
        $(this).val("");
    }
});

$(document).on("click",".showwobtn", function() {
    $(this).siblings().removeClass("nowactive");
    $(this).addClass("nowactive")
    a.showwowindow($(this).data('pagereq'), $(this).data("id"));
});

// save to new contact 
    $(document).on("click","#savenewcontact", function(){
        if ($(document).find("#contactname").val().length == 0) {
            alert("Contact Name cannot be empty");
            return;
        }

        let custidfk = null;
        let fromwindow = null;

        if ( $(this).data("custid").length == 0) {
            custidfk = $(document).find("#companynametxt").val();
            fromwindow = true;
        } else {
            custidfk = $(this).data("custid");
            fromwindow = false;
        }

        var basicinfo            = new Object();
        basicinfo.custidfk       = custidfk;
        basicinfo.contactname    = $(document).find("#contactname").val();
        basicinfo.title          = $(document).find("#contacttitle").val();
        basicinfo.contactnumber  = $(document).find("#contactnumber").val();
        basicinfo.email          = $(document).find("#emailaddress").val();
        basicinfo.address        = $(document).find("#addresstxt").val();
        basicinfo.city           = $(document).find("#citytxt").val();
        basicinfo.state_country  = $(document).find("#statecountry").val();
        basicinfo.zip            = $(document).find("#ziptxt").val();
        basicinfo.notes          = $(document).find("#thenotes").val();
        basicinfo.status         = "1";
        // basicinfo.inputby        = $(document).find("#").val();

        a.savetodatabase(basicinfo, "contactstbls",custidfk,false, function(){
            if (fromwindow == true) {
                window.location.reload();
            } else {
                a.showdwindow(tabname,overallid);
                $(document).find(".modal-backdrop").remove();
            }
        }, false, "Contacts");
    });
// end saving to new contact

// per item edit
    $(document).on("click",".peritemedit",function(){
        let a = $(this).parent().children("input").removeAttr("disabled");
            a.addClass("enabledtxtbox");
            a.focus();
    });

    $(document).on("blur",'.thetextinput', function(){
        let field = $(this).data("fld");
        let id    = $(this).data("id");
        let idfld = $(this).data("idfld");
        let tbl   = $(this).data("tbl");
        let value = $(this).val();

        let otherinfo = false;
        if (undefined !== $(this).data("othid")) {
            otherinfo           = new Object();
            otherinfo.otherfld  = $(this).data('othfld');
            otherinfo.othid     = $(this).data('othid');
        }

        let dis = $(this);
        
        let call    = $(this).data("callcompute");
        let quoteid = null;

        if (call == "true" || call == true) {
            quoteid = $(document).find("#quoteidfk").val();
        }
       
        a.saveperitem(tbl,id,idfld,field,value,function(){
            if (call == "true" || call == true) {
                let a = new Dsifronprocs();
                    a.computatethetotal(quoteid);
            }
            
            dis.attr("disabled","disabled");
            dis.removeClass("enabledtxtbox");
        }, otherinfo);
    });
// end 

// save additional item 
    $(document).on("click","#saveaddoninfo", function(){
        let custid = $(this).data("contid");
        let basicinfo = new Object();
            basicinfo.contidfk = custid;
            basicinfo.thefield = $(document).find("#referencename").val();
            basicinfo.thevalue = $(document).find("#referencevalue").val();
            basicinfo.status   = "1";

        a.savetodatabase(basicinfo, "contactfluidtbls",custid,false, function(){
            // a.showdwindow(tabname,id);
            // $(document).find(".modal-backdrop").remove();
            alert("Additional Information is saved");
        }, false, "Additional Information");
    });
// end 

// remove item 
    $(document).on("click",".removeitem", function(){
        let dis = $(this);
        a.removeitem( $(this).data("tbl"), $(this).data("id") , $(this).data("idfld"), function() {
            dis.parent().parent().remove();
        });
    });
// end 

// transfer 
    $(document).on("click",".transfertocompbtn", function(){
        let custid = $("input[name='transferto']:checked").val();
        let contid = $(this).data("contid");

        a.transfertonew(custid, contid, function(){
            if (tabname == null) {
                window.location.reload();
            } else {
                a.showdwindow(tabname,overallid);
                $(document).find(".modal-backdrop").remove();
            }
        });
    });
// end 

// remove contact details 
    $(document).on("click",".removecont", function(){
        a.removeitem("contactstbls", $(this).data("contid") , "contid", function(){
            if (tabname == null) {
                window.location.reload();
            } else {
                a.showdwindow(tabname,overallid);
                $(document).find(".modal-backdrop").remove();
            }
        });
    });
// end 

// recover contact
$(document).on("click",".recovercont", function(){
    var conf = confirm("Are you sure you want to recover this?");

    if (!conf) {
        return;
    }
    a.saveperitem("contactstbls",$(this).data("contid"),"contid","status","1",function(){
        window.location.reload();
    });
});
// end recover

// proceed save note 
    $(document).on("click",".proceedsavenote", function(){
        let thenote = $("#dsieditor").summernote("code");
        let ref     = $("#referencebox").val();
        let label   = $("#labelnote").val();
        let grpid   = $(this).data("groupid");
        let custid  = $(this).data("custid");
        let link    = url+"/optoutnotification/"+grpid+"/deactivate";
        let item    = "Note";

        let basicinfo = new Object();
            basicinfo.custid    = custid;
            basicinfo.reference = ref;
            basicinfo.label     = label;
            basicinfo.thenote   = thenote;
            basicinfo.groupidfk = grpid;
            basicinfo.status    = "1";
        //    basicinfo.sharewith = sharewith;
        
        
        // console.log(thenote); return;
        a.savetodatabase(basicinfo, "notestbls",custid,false,function(data){
            a.showdwindow(tabname,overallid);
            $(document).find(".modal-backdrop").remove();

            let redirect = url+"/customer/"+custid+"/notes/"+data;

            a.sendnotification(ref, thenote, grpid, link, item , redirect , function(data){
                // alert("sending notification success");
            });

        }, true, "Notes");
    });
// end 

// sharenote
$(document).on("blur",".notesharetxt" ,function(e) {
    let showhere = $(this).data("showid");
    if ($(this).val().length > 0) {
        let theval     = $(this).val();

        let thesplit   = "all";
        let thesplitid = "all";

        if (theval != "all") {
            thesplit   = theval.split("_")[1];
            thesplitid = theval.split("_")[0];
        }

        let sharewith            = new Object();
            sharewith.groupidpk  = $(this).data("groupid");
        //    sharewith.tableid    = "";
        //    sharewith.tablefrom  = "";
            sharewith.sharedwith = thesplitid;
            sharewith.status     = "0";

        // $(document).find("#"+showhere).html("saving...");
        
        let dis = $(this);
        a.savetodatabase(sharewith, "sharewithtbns", false, false, function(a){
            
            $("<span class='sharewith' data-shrid='"+a+"' >"+thesplit+"</span>")
                .on("click", function(){
                    let ddis = $(this);
                    
                    let a = new Dsifronprocs();

                    a.removeitem("sharewithtbns",$(this).data("shrid"),"swid",function(){
                        ddis.remove();    
                    }, true);
                }).appendTo("#"+showhere); 
            dis.val("");
        });
    }
});
// share note

// save to link 
    $(document).on("click","#savelinkbtn", function(){
        let custid = $(this).data("custid");
        let basicinfo = new Object();
            basicinfo.custid       = custid;
            basicinfo.documentname = ref = $(document).find("#documentname").val();
            basicinfo.notes        = $(document).find("#linknote").val();
            basicinfo.filename     = $(document).find("#linkfilename").val();
            basicinfo.url          = $(document).find("#linkurl").val();
            basicinfo.groupidfk    = grpid = $(this).data("groupid");
            basicinfo.status       = "1";
        
        let thenote = basicinfo.notes +"<br/><br/>"+ basicinfo.url;

        let link    = url+"/optoutnotification/"+grpid+"/deactivate";
        let item    = "Sources";

        a.savetodatabase(basicinfo, "linkstbls",custid,false, function(data){
            a.showdwindow(tabname,overallid);
            $(document).find(".modal-backdrop").remove();

            let redirect = url+"/customer/"+custid+"/sources/"+data;

            a.sendnotification(ref, thenote, grpid, link, item , redirect , function(data){
                // alert("sending notification success");
            });

        }, true,"Sources and Links");
    });
// end saving to link

let activityname = null;
$(document).on("change","#activity", function(){
    if ($(this).val() == "Custom Task") {
        $(document).find("#customactivity").show();
        activityname = "custom";
    } else {
        $(document).find("#customactivity").hide();
        activityname = $(this).val();
    }
});

// schedule now btn 
    $(document).on("click","#schedulenowbtn", function(){
        let actname = null;

        if (activityname == "custom") {
            actname = $(document).find("#customactivity").val();
        } else {
            if (activityname == null) {
                actname = $(document).find("#activity").val();
            } else {
                actname = activityname;
            }
        }

        let custid                  = $(this).data("custid");
        let basicinfo               = new Object();
            basicinfo.custid        = custid;
            basicinfo.contactid     = $(document).find("#contactname").val();
            basicinfo.activity      = actname;
            basicinfo.reference     = ref = $(document).find("#reference").val();
            basicinfo.notes         = thenote = $(document).find("#thenotes").val();
            basicinfo.groupidfk     = grpid = $(this).data("groupid");
            basicinfo.taskdatetime  = $(document).find("#datetimetxt").val();
            basicinfo.status        = "1";
        
        // console.log(basicinfo); return;

        let id   = $(this).data("custid");
        let link = url+"/optoutnotification/"+grpid+"/deactivate";
        
            a.savetodatabase(basicinfo, "taskstbls",custid,false, function(data){
                activityname = null;
                a.showdwindow("pendings",overallid);
                $(document).find("#scheduletaskdivbox").hide();
                $(document).find(".modal-backdrop").remove();
                $('body').removeClass("modal-open");

                let redirect = url+"/customer/"+custid+"/tasks/"+data;

                a.sendnotification(ref, thenote, grpid, link, actname , redirect ,function(data){
                    // alert("sending notification success");
                });
            }, true, "Tasks");
    });
// end 

// completed activity now btn 
$(document).on("click","#completedactivitybtn", function(){
    let actname = null;

    if (activityname == "custom") {
        actname = $(document).find("#customactivity").val();
    } else {
        if (activityname == null) {
            actname = $(document).find("#activity").val();
        } else {
            actname = activityname;
        }
    }

    let custid                  = $(this).data("custid");

    let basicinfo               = new Object();
        basicinfo.custid        = custid;
        basicinfo.contactid     = $(document).find("#contactname").val();
        basicinfo.activity      = actname;
        basicinfo.reference     = ref = $(document).find("#reference").val();
        basicinfo.notes         = thenote = $(document).find("#thenotes").val();
        basicinfo.groupidfk     = grpid = $(this).data("groupid");
        basicinfo.taskdatetime  = $(document).find("#datetimetxt").val();
        basicinfo.status        = "2";

    let id = $(this).data("custid");

    let link = url+"/optoutnotification/"+grpid+"/deactivate";
    // let ref = $(document).find("#taskreference").html();

        a.savetodatabase(basicinfo, "taskstbls",custid,false, function(data){
            a.showdwindow(tabname,overallid);
            $(document).find("#modalpopupview").hide();
            $(document).find(".modal-backdrop").remove();
            $('body').removeClass("modal-open");

            let redirect = url+"/customer/"+custid+"/tasks/"+data;

            a.sendnotification(ref, thenote, grpid, link, actname , redirect ,function(data){
                // alert("sending notification success");
            });

        }, true, "Complete Activities");
});
// end 

// reply btn as task button 
    $(document).on("click","#replybtn", function(){
        let custid              = $(this).data("custid");

        let basicinfo           = new Object();
            basicinfo.taskid    = $(this).data("taskid");
            basicinfo.custid    = custid;
            basicinfo.groupidfk = grpid = $(this).data("groupid");
            basicinfo.thereply  = thenote = $("#dsieditor").summernote("code");
            basicinfo.status    = "1";

        let link = url+"/optoutnotification/"+grpid+"/deactivate";
        let ref = $(document).find("#taskreference").html();

            a.savetodatabase(basicinfo, "replytbls",custid,false, function(data){
                a.showdwindow("pendings",overallid);
                $(document).find(".modal-backdrop").remove();
                $('body').removeClass("modal-open");

                let redirect = url+"/customer/"+custid+"/tasks/"+data;

                a.sendnotification(ref, thenote, grpid, link, "Reply" , redirect ,function(data){
                    // alert("sending notification success");
                });

            }, false, "Reply");
    }); 
// end 

// reply btn on the activity tab
$(document).on("click","#replybtnactivity", function(){
    let custid              = $(this).data("custid");

    let basicinfo           = new Object();
        basicinfo.taskid    = $(this).data("taskid");
        basicinfo.custid    = custid;
        basicinfo.groupidfk = grpid = $(this).data("groupid");
        basicinfo.thereply  = thenote = $("#dsieditor").summernote("code");
        basicinfo.status    = "1";

    let link = url+"/optoutnotification/"+grpid+"/deactivate";
    let ref = $(document).find("#taskreferenceactivity").html();

        a.savetodatabase(basicinfo, "replytbls",custid,false, function(data){
            a.showdwindow("activities",overallid);
            $(document).find(".modal-backdrop").remove();
            $('body').removeClass("modal-open");

            let redirect = url+"/customer/"+custid+"/tasks/"+data;

            a.sendnotification(ref, thenote, grpid, link, "Reply" , redirect ,function(data){
                // alert("sending notification success");
            });

        }, false, "Reply");
}); 
// end 

// mark as complete btn 
    $(document).on("click","#completebtn",function(){
        var conf = confirm("You are about to mark this complete. Proceed?");

        if (!conf) {
            return;
        }

        let tbl   = "taskstbls";
        let id    = $(this).data("taskid");
        let idfld = "taskid";
        let field = "status";
        let value = "2";

        // save to replies
        let currdate = new Date();
        let cday     = currdate.getDate();
        let cmonth   = currdate.getMonth();
        let cyear    = currdate.getFullYear();

        let completeddate = months[cmonth]+" "+cday+", "+cyear;
        let custid        = $(this).data("custid");

        let basicinfo = new Object();
            basicinfo.taskid    = $(this).data("taskid");
            basicinfo.custid    = custid;
            basicinfo.groupidfk = grpid = $(this).data("groupid");
            basicinfo.thereply  = thenote = "Completed on "+completeddate;
            basicinfo.status    = "1";

        let link = url+"/optoutnotification/"+grpid+"/deactivate";
        let ref  = $(document).find("#taskreference").html();

            a.savetodatabase(basicinfo, "replytbls",custid,false, function(data){
                a.showdwindow("pendings",overallid);
                $(document).find(".modal-backdrop").remove();
                $('body').removeClass("modal-open");

                let redirect = url+"/customer/"+custid+"/tasks/"+data;

                a.sendnotification(ref, thenote, grpid, link, "Completed Task" , redirect , function(data){
                    // alert("sending notification success");
                });
            }, false,"Completed Task");
        // save to replies
      
            a.saveperitem(tbl,id,idfld,field,value,function(){
                a.showdwindow(tabname,overallid);
                $(document).find("#modalpopupview").hide();
                $(document).find(".modal-backdrop").remove();
            });
        
    });
// end 

// reply and complete btn 
$(document).on("click","#replycompletebtn",function(){
    var conf = confirm("You are about to mark this complete. Proceed?");

    if (!conf) {
        return;
    }

    let tbl   = "taskstbls";
    let id    = $(this).data("taskid");
    let idfld = "taskid";
    let field = "status";
    let value = "2";

    // save to replies
    let currdate = new Date();
    let cday     = currdate.getDate();
    let cmonth   = currdate.getMonth();
    let cyear    = currdate.getFullYear();

    let completeddate = months[cmonth]+" "+cday+", "+cyear;
    let custid        = $(this).data("custid");

    let basicinfo = new Object();
        basicinfo.taskid    = $(this).data("taskid");
        basicinfo.custid    = custid;
        basicinfo.groupidfk = grpid = $(this).data("groupid");
        basicinfo.thereply  = thenote = $("#dsieditor").summernote("code");
        basicinfo.status    = "1";

    let link = url+"/optoutnotification/"+grpid+"/deactivate";
    let ref  = $(document).find("#taskreference").html();

        a.savetodatabase(basicinfo, "replytbls",custid,false, function(data){
            a.showdwindow("pendings",overallid);
            $(document).find(".modal-backdrop").remove();
            $('body').removeClass("modal-open");

            let redirect = url+"/customer/"+custid+"/tasks/"+data;

            a.sendnotification(ref, thenote, grpid, link, "Completed Task" , redirect , function(data){
                // alert("sending notification success");
            }); 

        }, false,"Completed Task");
    // save to replies
  
        a.saveperitem(tbl,id,idfld,field,value,function(){
            a.showdwindow(tabname,overallid);
            $(document).find("#modalpopupview").hide();
            $(document).find(".modal-backdrop").remove();
        });
    
});
// end 

// re-task button 
    $(document).on("click","#retaskbutton", function(){
        let tbl   = "taskstbls";
        let id    = $(this).data("taskid");
        let idfld = "taskid";
        let field = "status";
        let value = "1";
        
        let custid    = $(this).data("custid");

        let basicinfo = new Object();
            basicinfo.taskid    = $(this).data("taskid");
            basicinfo.custid    = custid;
            basicinfo.groupidfk = grpid = $(this).data("groupidfk");
            basicinfo.thereply  = thenote = $("#dsieditor").summernote("code");
            basicinfo.status    = "1";
        
        let link = url+"/optoutnotification/"+grpid+"/deactivate";
        let ref  = $(document).find("#taskreferenceactivity").html();

        a.savetodatabase(basicinfo, "replytbls",custid,false, function(data){
            a.showdwindow("activities",overallid);
            $(document).find(".modal-backdrop").remove();
            $('body').removeClass("modal-open");

            let redirect = url+"/customer/"+custid+"/tasks/"+data;

            a.sendnotification(ref, thenote, grpid, link, "Re-Task" , redirect , function(data){
                // alert("sending notification success");
            }); 

        }, true,"Re-tasking");

        a.saveperitem(tbl,id,idfld,field,value,function(){
            a.showdwindow(tabname,overallid);
            $(document).find("#modalpopupview").hide();
            $(document).find(".modal-backdrop").remove();
        });
    });
// end retasking 

// create tax 
    $(document).on("click",".createtax", function(){
        let custidfk            = $(this).data("custidfk");

        let basicinfo           = new Object();
            basicinfo.custidfk  = custidfk;
            basicinfo.thetax    = "12";
            basicinfo.status    = "1";

        a.savetodatabase(basicinfo, "taxationtbls",custidfk,false, function(){
            $("#taxationdivbox").modal("hide");
            // $(document).find("#modalpopupview").hide();
            // $(document).find(".modal-backdrop").remove();
            // $('body').removeClass("modal-open");
        });
    });
// end 

// filter button in items 
    $(document).on("click","#filterbutton", function(){
        let category = $(document).find("#thecategoryselect").val();

        window.location.href = url+"/uploaditems/"+category;
    });
// end 

// remove items from items tbl 
    $(document).on("click","#removeitemfromitemstbl", function(){
        if (theids.length == 0) {
            alert("Please select the items you want to delete.");
            window.location.reload();
        }

        var conf = confirm("Are you sure you want to delete?");

        if (!conf) {
            return;
        }

        a.removemultipleitems(theids, "itemstbls", "itemid", function(){
            window.location.reload();
        });
    });
// end 

// 
// checkboxes 
$(document).on("click",".itemscheckbox", function(){
    let state = $(this).is(":checked");
    
    if (state == true || state == "true") {
        theids.push( $(this).val() );
    } else if (state == false || state == "false") {
        let indx  = theids.indexOf( $(this).val() );
        theids.splice(indx,1);
    }
});
// end 

// checkbox change 
$(document).on("click",".checkboxchange", function() {
    let state = $(this).is(":checked");

    let table = $(this).data("tbl");
    let id    = $(this).data("id");
    let idfld = $(this).data("idfld");
    let val   = null;

    if (state == true || state == "true") {
        val = 1;
    } else {
        val = 0;
    }
// console.log(val);
    a.saveperitem(table, id, idfld, "istaxable", val, function(){

    });
});
// end 

// create new category 
$(document).on("click","#createnewcategory", function(){
    let thecategory      = $(document).find("#categorytxtbox").val();

    let theitem          = new Object();
        theitem.category = thecategory;

    // a.savetodatabase(theitem, "itemstbls", false, false, function(data){
    //    if (data) {
            window.location.href = url+"/uploaditems/"+thecategory;
    //    }
    // }, false, false);
});
// end 

// proceed save note 

// end proceed saving note

// navigation ul 
    $(document).on("click",".navigationuls li", function(){
        $(this).siblings().removeClass("selectednavli");
        $(this).addClass("selectednavli");

        $(document).find(".hidwindow").hide();

        let thewindow = $(this).data("tab");
        $(document).find("#"+thewindow).show();
    });
// end navigation ul

// product line change
    $(document).on("change","#productlinechange", function(){
        let value   = $(this).val();
        let valtext = $("#productlinechange :selected").text();

        window.location.href = url+"/productline/"+value;
    });
// end

// delete product line markup
    $(document).on("click","#deletebtn", function(){
        let id = $(this).data('id');

        let dis = $(this);

        a.removeitem("productlines", id, "productlineid", function(data){
            dis.parent().remove();    
        }, true);
    });
// end 

// delete product line
    $(document).on("click","#deleteproductline", function(){
        let grpid = $(this).data('grpid');

        a.removeitem("productlines", grpid, "thegrpid", function(data){
            window.location.href = url+"/productline";
        }, true);
    });
// end 

// add new product line 
    $(document).on("click","#addnewproductline", function(){
        let iscustom      = null;
        let isproductline = null;

        if ($("#iscustomval").is(":checked")) {
            iscustom = "1";
        } else {
            iscustom = "0";
        }

        if ($("#isproductline").is(":checked")) {
            isproductline = "1";
        } else {
            isproductline = "0";
        }

        let basicinfo                  = new Object();
            basicinfo.theproductline   = $(document).find("#productlinename").val();
            basicinfo.minimummarkup    = $(document).find("#initialmarkup").val();
            basicinfo.iscustom         = iscustom;
            basicinfo.thegrpid         = $(document).find("#newgrpid").val();
            basicinfo.status           = isproductline;

        a.savetodatabase(basicinfo, "productlines", false, false, function(data){
            window.location.reload();
        }, false, false);
    })
// end  

// ask customer id change
    $(document).on("click","#askcustomnameid", function(){
        let grpid       = $(this).data("grpid");
        let basicinfo   = new Object();

        if ( $(this).is(":checked") ) {
            basicinfo.iscustom    = "1";
        } else {
            basicinfo.iscustom    = "0";
        }
       
        a.updateentries(basicinfo, "productlines", grpid , "thegrpid", function(data){
            window.location.reload();
        });
    });
// end 

// ask customer id change
$(document).on("click","#asproductline", function(){
    let grpid       = $(this).data("grpid");
    let basicinfo   = new Object();

    if ( $(this).is(":checked") ) {
        basicinfo.status    = "1";
    } else {
        basicinfo.status    = "0";
    }
   
    a.updateentries(basicinfo, "productlines", grpid , "thegrpid", function(data){
        window.location.reload();
    });
});
// end 


// expdivbox
    $(document).on("click","#setexpirybtn", function(){
        if ( $(document).find(".expdivbox").hasClass("hidethis") ) {
            $(document).find(".expdivbox").removeClass("hidethis");
            $(document).find(".expirytxtbox").removeAttr("disabled");
            $(document).find("#freqselect").removeAttr("disabled");
        } else {
            $(document).find(".expdivbox").addClass("hidethis");
            $(document).find(".expirytxtbox").attr("disabled");
            $(document).find("#freqselect").attr("disabled");
        }
    })
//

// call window 
    $(document).on("click",".callwindow", function(){
        // insertotheritemspan
        a.showdwindow_to_here($(this).data("window"), false, $(this).data("insertospan"));
    });
// end call window

    $(document).on("click",".callwindowwithid", function(){
        
        if (qtid.length > 1) {
            alert("Please select one(1) item only"); return;
        } 

        let quoteitemid = $(document).find("#quoteidfk").val();

        a.showdwindow_to_here($(this).data("window"), 
                             qtid[0], 
                             $(this).data("insertospan"),
                             quoteitemid);
    });