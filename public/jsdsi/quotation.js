// call after body onload
window.onload = function(){
    if ( undefined !== $(document).find("#quoteidfk").val() ) {
        a.displaythequoteitems( $(document).find("#quoteidfk").val() ) 
        a.computatethetotal( $(document).find("#quoteidfk").val() );
    }

    let ht = $(document).find("#motherdiv").height();
    $(document).find("#contextmenu").css("min-height",ht+"px");
}   
// end 

let extendedprice = 0;
let qtid = [];

// insert new custom item
    $(document).on("click","#insertcustomitem", function(){
        let itemgrpid = $(document).find("#itemgrpid").val();

        // custpertxt
        let tblorder  = $(document).find("#tbodyrow").children().length;
        let quoteidfk = $(document).find("#quoteidfk").val();
        let itemcost  = $("#insertitem").find("#costtxt").val();

        let interid   = $(document).find("#interid").val();

        let basicinfo                   = new Object();
            basicinfo.quoteidfk         = quoteidfk;
            basicinfo.tblorder          = tblorder+1;
            basicinfo.itemtype          = "custom";
            basicinfo.itemdesc          = $("#insertitem").find("#itemdesc").val();
            basicinfo.itemcost          = itemcost;
            basicinfo.suppname          = $("#insertitem").find("#suppname").val();
            basicinfo.supppart          = $("#insertitem").find("#supppart").val();
            basicinfo.manuname          = $("#insertitem").find("#mfgname").val();
            basicinfo.manupart          = $("#insertitem").find("#mfgpart").val();
            basicinfo.markup            = "markup"; // $(document).find("#markupselect").val();

            if ($("#insertitem").find("#percentageselect").val() == "customper") {
                basicinfo.markupvalue       = $("#insertitem").find("#custpertxt").val();
            } else {
                basicinfo.markupvalue       = $("#insertitem").find("#percentageselect").val();
            }


            // ## shipping 
            if ( $('#addshippingbtn').is(":checked") ) {
                basicinfo.withshipping       = "1";
                basicinfo.shippingcost       = $("#insertitem").find("#shipcost").val();
                basicinfo.shippingmarkup     = $("#insertitem").find("#shipmarkup").val();
                //basicinfo.shippingfinalprice = $(document).find("#shipvalue").val();
            } else {
                delete basicinfo.withshipping;
                delete basicinfo.shippingcost;
                delete basicinfo.shippingmarkup;
                //delete basicinfo.shippingfinalprice;
            }
            // ## end shipping

            // ## expiry date 
            if ( $("#addexpirybtn").is(":checked") ) {
                basicinfo.withexpiry = "1";
                basicinfo.expnumber  = $("#insertitem").find("#expirynumber").val();
                basicinfo.expunit    = $("#insertitem").find("#expiryunit").val();
                basicinfo.expnote    = $("#insertitem").find("#expirynote").val(); 
            } else {
                delete basicinfo.withexpiry;
                delete basicinfo.expnumber;
                delete basicinfo.expunit;
                delete basicinfo.expnote;
            }
            // ## end expiry
            
            basicinfo.qty               = "1";

            if ( $('#istax').is(":checked") ) {
                basicinfo.taxable           = "1";
            } else {
                basicinfo.taxable           = "0";
            }

            let vals    = $("#insertitem").find("#productlineselect").val();
            let valtext = "";

            basicinfo.productlineid = vals.split("_")[2];

            if (vals.split("_")[1] == "0") {
                valtext = $("#insertitem").find("#productlineselect :selected").text();
            } else if (vals.split("_")[1] == "1") {
                valtext = $("#insertitem").find("#customitemtypetxt").val();
            }

            if (valtext.length == 0) {
                alert("Please choose the product line");
                return;
            }

            basicinfo.productline   = valtext;

            if (itemcost.length == 0) {
                alert("Item cost cannot be empty"); return;
            }

            // console.log(basicinfo); return;
            a.savetodatabase(basicinfo, "quoteitemstbls", false, false, function(data){
                $(document).find("#insertitem").hide();
                $(document).find(".modal-backdrop").hide();
                $('body').removeClass("modal-open");

                a.displaytotable(interid, data);
                
                let theitems           = new Object();
                    theitems.theitemid = data;

                a.updateentries(theitems, "itemreferencetbls", itemgrpid, "itemgrpid");
                a.computatethetotal(quoteidfk);
                a.checkformarkupstatus(data);
            }, false, false);

    });
// end 

// percentage select 
    $(document).on("change","#percentageselect", function(e){
        if ($(document).find("#costtxt").val().length == 0) {
            e.preventDefault();
            alert("Please enter Cost"); return;
        }

        if ($(this).val() == "customper") {
            $(document).find("#custpertxt").show();
        } else {
            $(document).find("#custpertxt").hide();
            
            let sellingprice = a.sellingprice( $(document).find("#costtxt").val(), $(this).val());
            $(document).find("#sellpricetxt").val(sellingprice);
        }

        let qty       = $(document).find("#qtytxt").val();
        let price     = $(document).find("#sellpricetxt").val();
    
        extendedprice = parseInt(qty)*parseFloat(price);
        $(document).find("#extendedprice").text(extendedprice);
    });
// send 

// percentage change 
    
// end 

$(document).on("input change", "#costtxt", function(){
    let costval = $(this).val()
    let markup  = null;

    if ($(document).find("#percentageselect").val() == "customper") {
        markup = $(document).find("#custpertxt").val();
    } else {
        markup = $(document).find("#percentageselect").val();
    }

    let sellingprice = a.sellingprice( costval, markup );
    $(document).find("#sellpricetxt").val(sellingprice);

    let qty       = $(document).find("#qtytxt").val();
    let price     = $(document).find("#sellpricetxt").val();

    extendedprice = parseInt(qty)*parseFloat(price);
    $(document).find("#extendedprice").text(extendedprice);
});

// custom percentage value 
    $(document).on("input change","#custpertxt", function(){
        if ($(document).find("#costtxt").val().length == 0) {
            alert("Please enter Cost"); return;
        }

        let sellingprice = a.sellingprice( $(document).find("#costtxt").val(), $(this).val());
        $(document).find("#sellpricetxt").val(sellingprice);

        let qty       = $(document).find("#qtytxt").val();
        let price     = $(document).find("#sellpricetxt").val();
    
        extendedprice = parseInt(qty)*parseFloat(price);
        $(document).find("#extendedprice").text(extendedprice);

    });
// end 

// qty change 
    $(document).on("input change", "#qtytxt, #sellpricetxt", function(){
        let qty       = $(document).find("#qtytxt").val();
        let price     = $(document).find("#sellpricetxt").val();

        extendedprice = parseInt(qty)*parseFloat(price);
        $(document).find("#extendedprice").text(extendedprice);
    });
// end 

// td click 
    $(document).on("click","#tbodyrow tr td", function(){
        // alert("hi")
    });
// end 

// edit data qt
    $(document).on("dblclick",".editdataqt", function(){
        $(document).find(".inlineeditbox").remove();
        
        let quoteidfk = $(document).find("#quoteidfk").val();
        
        let dataid  = $(this).data("id"); // table id 
        let datafld = $(this).data("fld"); // field name
        let content = $(this).data('cont'); // value

        let idname  = $(this).data("idname");
        let dis     = $(this);

        let parenttr = dis.parent();

        $(this).html("");
        

        $("<input type='text' class='inlineeditbox' value='"+content+"'/>")
            .on("blur", function(){
            //    alert($(this).val());
            //    if (content == $(this).val()) {
            //        alert("equal")
            //    } else {
                    let a = new Dsifronprocs();

                    if (datafld == "suppname" || 
                        datafld == "supppart" || 
                            datafld == "manuname" || 
                            datafld == "manupart" || 
                                datafld == "itemdesc") {
                        let tv = $(this).val();
                        a.saveperitem("quoteitemstbls", dataid, "quoteitemid", datafld, tv , function(){
                            if (datafld == "suppname") {
                                $(document).find("#suppname_"+idname).html(tv);
                            }

                            if (datafld == "supppart") {
                                $(document).find("#supppart_"+idname).html(tv);
                            }

                            if (datafld == "manuname") {
                                $(document).find("#manuname_"+idname).html(tv);
                            }

                            if (datafld == "manupart") {
                                $(document).find("#manupart_"+idname).html(tv);
                            }

                            if (datafld == "itemdesc") {
                                $(document).find("#itemdesc_"+idname).html(tv);
                            }
                        });
                    } else {
                        a.saveperitem_qt("quoteitemstbls",dataid,"quoteitemid",datafld, $(this).val() ,function(data){
                            $(document).find("#profit_"+idname).html(data['profit']);
                            $(document).find("#extended_"+idname).html(data['extended']);
                            $(document).find("#price_"+idname).html(data['price']);
                            $(document).find("#qty_"+idname).html(data['qty']);
                            $(document).find("#itemcost_"+idname).html(data['itemcost']);
                            $(document).find("#markup_"+idname).html(data['markupvalue']);

                            // shipping
                            $(document).find("#shippingcost_"+idname).html(data['shippingcost']);
                            $(document).find("#shippingmarkup_"+idname).html(data['shippingmarkup']);
                            $(document).find("#shippingfinalprice_"+idname).html(data['shippingfinalprice']);

                            a.computatethetotal(quoteidfk);
                            a.checkitemneedsapproval(quoteidfk);
                            a.checkformarkupstatus(dataid, function(data){
                                if (data == 0 || data == "0") {
                                    parenttr.removeClass("needsapproval");
                                } else {
                                    parenttr.addClass("needsapproval");
                                }
                            });
                        });
                    }
            //    }

                dis.data("cont",$(this).val())
                dis.html( $(this).val() )
                
                $(this).remove();
            }).appendTo($(this)).focus();

        // $(this).html("");
    });
// end 

// istaxable checkbox 
$(document).on("click",".istaxable",function(){
    let quoteidfk = $(document).find("#quoteidfk").val();

    $state        = $(this).is(":checked");
    $quoteitem    = $(this).data("id");

    if ($state == false || $state == "false") {
        $istaxable = "0";
    } else if ($state == true || $state == "true") {
        $istaxable = "1";
    }

    a.saveperitem("quoteitemstbls",$quoteitem,"quoteitemid","taxable",$istaxable,function(){
        a.computatethetotal(quoteidfk);   
    });
});
// end 

// remove button
$(document).on("click","#removebtn, #removebtncontext", function(){
    if (qtid.length <= 0) {
        alert("Please select item to delete");
        return;
    }

    var conf = confirm("Are you sure you want to delete this?");

    if (!conf) {
        return;
    }

    a.removequoteitems(qtid, $(document).find("#quoteidfk").val());
    
});
// end remove

// checkboxes 
$(document).on("click",".qtcheckbox", function(){
    let state = $(this).is(":checked");
    
    if (state == true || state == "true") {
        qtid.push( $(this).val() );
    } else if (state == false || state == "false") {
        let indx  = qtid.indexOf( $(this).val() );
        qtid.splice(indx,1);
    }

    // console.log(qtid);
});
// end 

// add this item
$(document).on("click",".addthisitem", function(){
    let itemid  = $(this).data("itemid");
    let quoteid = $(document).find("#quoteidfk").val();
    let tblorder = $(document).find("#tbodyrow").children().length;

    a.saveexistingitem(itemid, quoteid, tblorder);
});
// end 

// ask for approval btn 
$(document).on("click","#askforapproval", function() {
    let link    = window.location.href;
    let subject = $(document).find("#thesubject").val();
    let message = $(document).find("#themessage").val();
    let quoteidfk = $(document).find("#quoteidfk").val();

    $("<p style='margin-top: 5px;margin-bottom: 0px;margin-left: 15px;'> sending message... please wait </p>").appendTo("#messagestatus");

    a.sendemail(subject, message, link , quoteidfk, "quoteidfk", "quoteitemstbls", function(){
        alert("Message sent");
        window.location.reload();
        // $("#messagestatus").html("<p style='margin-top: 5px;margin-bottom: 0px;margin-left: 15px;'> Message is sent </p>");
    });
});
// end 

// save quotation 
    $(document).on("click","#savequotation", function(){
        let theitems                 = new Object();
            theitems.quotationname   = $(document).find("#documentname").val();
            theitems.quotationsentto = $(document).find("#documentcontact").val();

        let thekey = $(document).find("#quoteidfk").val();
        
        a.updateentries(theitems, "quotation_corners", thekey, "quoteid", function(){
            alert("Successfully Saved");
            window.location.reload();
        });
    });
// end quotation

// send quotation 
    $(document).on("click","#sendquotationbtn", function(){

        if ( needsapproval ) {
           alert("Cannot proceed. You need to ask approval first.");
           return;
        }

        //let na = $(document).find("#na").val();
        // if (na == 1 || na == "1") {
        //     alert("Cannot proceed with the sending. This document needs to be approved first.");
        //     return;
        // }

        //window.location.href;

        let subject = $(document).find("#documentsubject").val();
        let message = $(document).find("#emailmsgtxt").val();
        let id      = $(document).find("#quoteidfk").val();
        let to      = $(this).data("toid");
        let link    = url+"/quotation/"+id;
        let idfld   = "quoteid";
        let tbl     = "quotation_corners";

        $(" <p style='margin-top: 9px;margin-bottom: 0px;margin-left: 13px;'> Sending quotation please wait... </p>").appendTo("#sendqtspan");
        a.sendtocontact("sendquotation",subject, message, link , to, id , idfld , tbl , function(){
            alert("Quotation is sent");
            window.location.reload();
        });
    });
    // na
// end 

// reset expiry 
// resetexpirybtn
$(document).on("click","#resetexpirybtn", function(){
    let quoteid = $(document).find("#quoteidfk").val();

    let theobject               = new Object();
        theobject.quotevalidity = $(document).find("#expirydate").val();
        theobject.status        = 1;
    
        a.updateentries(theobject, "quotation_corners", quoteid, "quoteid", function(data){
            if (data) {
                alert("Expiration date reset");
                window.location.reload();
            }
        });
});
// end 

// add item
$(document).on("click",".additemtab", function(){
    let tab = $(this).data("tabname");
    
    $(document).find(".additemtab_div").hide();

    $(document).find("#tabgroupdiv").children().removeClass("selecteditemtab");
    $(this).addClass("selecteditemtab");

    $(document).find("#"+tab).show();
})
// end 

// add additional information 
$(document).on("click","#savenewreference", function(){
    let quoteidfk = $(document).find("#quoteidfk").val();
    let itemgrpid = $(document).find("#itemgrpid").val();

    let theobject = new Object();
        theobject.quoteidfk = quoteidfk;
        theobject.criteria  = $(document).find("#info_criteriaid").val();
        theobject.reference = $(document).find("#info_referenceid").val();
        theobject.thevalue  = $(document).find("#info_thevalue").val();
        theobject.itemgrpid = itemgrpid;
        theobject.status    = "1";

    let idname = theobject.criteria.replace(/\s/g, '')+quoteidfk;

    a.savetodatabase(theobject, "itemreferencetbls", false, false, function(data){
        // tabgroupdiv
        // criteriadivdisplay
        $("<p class='additemtab' style='margin-bottom: 20px;' data-tabname='"+idname+"' id='tab"+idname+"'>"+theobject.criteria+"</p>").prependTo("#tabgroupdiv");
        $("<div id = '"+idname+"' class='additemtab_div pd-t-10 pd-b-10 pd-b-10 pd-r-15 pd-l-15'>"+
            "<p> Reference: <input type='text' class='pd-15 dsitxtbox thetextinput mg-b-0 pd-15' style='padding:6px 13px;' data-fld='reference' data-idfld='itemrefid' data-id='"+data+"' data-tbl='itemreferencetbls' value='"+theobject.reference+"' style='width: auto;'/> <small class='peritemedit'> edit </small> </p>"+
            "<p> Value: <input type='text' class='pd-15 dsitxtbox thetextinput mg-b-0' style='padding:6px 13px;' data-fld='thevalue' data-idfld='itemrefid' data-id='"+data+"' data-tbl='itemreferencetbls' value='"+theobject.thevalue+"' style='width: auto;'/> <small class='peritemedit'> edit </small> </p>"+
            "<button id='deletethisdiv' data-tblid='"+data+"' data-domid='"+idname+"' class='btn btn-danger btn-sm mg-t-5'> Delete </button>"+
         "</div>").appendTo("#criteriadivdisplay");

        $(document).find("#info_criteriaid").val("");
        $(document).find("#info_referenceid").val("");
        $(document).find("#info_thevalue").val("");

    }, false, false);
});
// end 

// delete this tab 
    $(document).on("click","#deletethisdiv", function(){
        let domid = $(this).data("domid");
        a.removeitem("itemreferencetbls", $(this).data("tblid"), "itemrefid", function(){
            $(document).find("#tab"+domid).remove();
            $(document).find("#"+domid).remove();
        }, true);
    })
// end deleting tab

// duplicate a quotation 
    $(document).on("click","#saveasnewtonewcust", function(){
        let thekey      = $(document).find("#quoteidfk").val();
        let customerid  = $(this).data("custidfrom");

        // a.savetonewcustomer()
    });
// end 

// change validity 
    $(document).on("click","#changevaliditynowbtn", function(){
        let quoteid   = $(document).find("#quoteidfk").val();
        let theperiod = $(document).find("#validitydate").val();

        a.changevalidityperiod(quoteid, theperiod, function(data){
            if (data == "false" || data == false) {
                alert("The new validity period is less than the current one. Please change.");
            } else {
                alert("Validity Changed successfully");
                window.location.reload();
            }
        });
        // validitydate 
    });
// end validity period

// insert subtotal 
    $(document).on("click","#insertsubtotal", function(){
        let subtotaldesc = $(document).find("#subtotaldesc").val();
        let subtotalqty  = $(document).find("#subtotalqty").val();
        let quoteidfk    = $(document).find("#quoteidfk").val();

        let theobject              = new Object();
            theobject.subtotalname = subtotaldesc;
            theobject.subtotalqty  = subtotalqty;
            theobject.quoteidfk    = quoteidfk;

        a.savetodatabase(theobject, "subtotaltbls", false, false, function(data){
            let a = new Dsifronprocs();

            a.updatemultipleitems(data, "quoteitemstbls", qtid ,"subtotalidfk" , "quoteitemid", function(data){
                alert("Subtotal Added");
                
                qtid = [];

                $(document).find("#subtotaldesc").val("");
                $(document).find("#subtotalqty").val("");
                $("#subtotaldiv").modal("hide");

                a.displaythequoteitems( $(document).find("#quoteidfk").val() ) 
                a.computatethetotal( $(document).find("#quoteidfk").val() );
            });
        });
    });
// ens subtotal

// add shipping button 
    $(document).on("click","#addshippingbtn", function(){
        let state = null;

        if ( $('#addshippingbtn').is(":checked") ) {
            $(document).find("#shippingcosttable").removeClass("hidethis");
        } else {
            $(document).find("#shippingcosttable").addClass("hidethis");
        }
    })
// end

// add expiry button
    $(document).on("click","#addexpirybtn", function(){
        let state = null;

        if ( $('#addexpirybtn').is(":checked") ) {
            $(document).find("#expirytable").removeClass("hidethis");
        } else {
            $(document).find("#expirytable").addClass("hidethis");
        }
    });
// end 

// product line select 
    $(document).on("change","#productlineselect", function(){
        let vals = $(this).val();
        
        let id    = vals.split("_")[0];
        let isdef = vals.split("_")[1];
        let grpid = vals.split("_")[2];

        if (isdef == 1) {
            $(document).find("#customitemtypetxt").show();
        } else {
            $(document).find("#customitemtypetxt").hide();
        }

        if (undefined == grpid) {
            $(document).find("#percentageselspan").html("select from the item type...");
        } else {
            a.loadmarkups(grpid, function(data){
                $(document).find("#percentageselspan").html(data);
            });
        }
    });
// end 

// start of mark up line
$(document).on("change","#markuplineselect", function(){
    let vals = $(this).val();
    
    let id    = vals.split("_")[0];
    let isdef = vals.split("_")[1];
    let grpid = vals.split("_")[2];

    if (isdef == 1) {
        $(document).find("#customitemtypetxt").show();
    } else {
        $(document).find("#customitemtypetxt").hide();
    }

    if (undefined == grpid) {
        $(document).find("#markupselspan").html("select from the item type...");
    } else {
        a.loadmarkups(grpid, function(data){
            $(document).find("#markupselspan").html(data);
        });
    }
});
// end of markup line

// call window 
    // callawindow(uniqueid, windowtocall, displayin, somefunction = false)
    $(document).on("click","#itemdetails", function(){
        if (qtid.length == 0) {
           $(document).find("#showitemdetailshere").html("Please select an item");
           return;
        }

        a.callawindow(qtid[0], "viewitemdetails", function(data){
            $(document).find("#showitemdetailshere").html(data);
        });
    })
// end call window

// open window 
    $(document).on("click",".openwindow", function(){
        
        if ( $(this).siblings(".referencevalues").hasClass("hidethis") ) {
            $(this).siblings(".referencevalues").removeClass("hidethis");
            $(this).siblings(".referencevalues").show("slow");
        } else {
            $(this).siblings(".referencevalues").addClass("hidethis");
            $(this).siblings(".referencevalues").hide("slow");
        }
    });
// end opening window

// expirytxtbox 
    $(document).on("blur",".expirytxtbox", function(){
        let table = $(this).data("tbl");
        let idfld = $(this).data("idfld");
        let id    = $(this).data("id");
        let field = $(this).data("fld");
        let value = $(this).val();

        if (value.length > 0) {
            a.saveperitem(table, id, idfld, field, value, function(){
                let a      = new Dsifronprocs();

                a.saveperitem(table, id, idfld, "withexpiry", "1" , function(){
                    $(document).find("#removeexpiry").removeClass("hidethis");
                }, false);
            }, false);
        }
    });
// end 

// frequency select 
    $(document).on("change","#freqselect", function(){
        let val = $(this).val();

        if (val != "def") {
            let table   = $(this).data("tbl");
            let idfld   = $(this).data("idfld");
            let id      = $(this).data("id");
            let field   = $(this).data("fld");

            let numberbox = $(document).find("#numbertxtbox").val();

            if ( numberbox.length == 0 ) {
                alert("Cannot proceed with empty number"); return;
            }

            a.saveperitem(table, id, idfld, field, val, function(){

                let a = new Dsifronprocs();
                a.saveperitem(table, id, idfld, "withexpiry", "1", function(){
                    $(document).find("#removeexpiry").removeClass("hidethis");
                }, false);
            }, false);
        }
    }); 
// end 

// remove expiry

$(document).on("click","#removeexpiry", function(){
    var conf = confirm("Are you sure you want to remove expiry?");

    if (!conf) { return; }

    let table = $(this).data("tbl");
    let id    = $(this).data("id");
    let idfld = $(this).data("idfld");

    a.saveperitem(table, id, idfld, "withexpiry", null, function(){
        let a = new Dsifronprocs();
        
        a.saveperitem(table, id, idfld, "expnumber", null , function(){
            let a = new Dsifronprocs();
        
            a.saveperitem(table, id, idfld, "expunit", null, function(){
                let a = new Dsifronprocs();
        
                a.saveperitem(table, id, idfld, "expnote", null, function(){
                    window.location.reload();
                }, false);
            }, false);       
        }, false);
    }, false);
});

// save this new information 
    $(document).on("click","#savethisnewinfo", function(){

        if (qtid.length > 1) {
            alert("Too many item are selected");
            return;
        }

        let quoteidfk = $(document).find("#quoteidfk").val();
        let itemgrpid = $(this).data("itemgrpid");

        let theobject = new Object();
            theobject.quoteidfk = quoteidfk;
            theobject.criteria  = $(document).find("#categorytxt").val();
            theobject.reference = $(document).find("#referencetxt").val();
            theobject.thevalue  = $(document).find("#valuetxt").val();
            theobject.theitemid = qtid[0];
            theobject.itemgrpid = itemgrpid;
            theobject.status    = "1";

        a.savetodatabase(theobject, "itemreferencetbls", false, false, function(data){
            // let theitems           = new Object();
            // theitems.theitemid     = data;

            alert("New information is saved");
            
            $(document).find("#categorytxt").val("");
            $(document).find("#referencetxt").val("");
            $(document).find("#valuetxt").val("");

            $(document).find("#newinformationdiv").addClass("hidethis");

            // a.updateentries(theitems, "itemreferencetbls", itemgrpid, "itemgrpid" , function(){
               
            // });            
        });
    })
// end 

// add additional info
    $(document).on("click","#addadditionalinfo", function(){
        if ( $(document).find("#newinformationdiv").hasClass("hidethis") ) {
            $(document).find("#newinformationdiv").removeClass("hidethis");
        } else {
            $(document).find("#newinformationdiv").addClass("hidethis");
        }
    });    
// end 

// ask permission button
    $(document).on("click","#askpermissionbtn", function(){
        let subject = "Permission to edit your quotation.";
        let message = $(document).find("#reasontxt").val();
        let idfld   = "idfk";
        let id      = $(document).find("#quoteidfk").val();
        let tbl     = "allowed_users";
        let emailto = $(this).data('owner');
        // let link    = url+"/allowedit/"+tbl+"/"+id;
        let link    = window.location.href;
        
        let thedata             = new Object();
            thedata.table       = "quotation_corners";
            thedata.idfk        = id;
            thedata.idfld       = "quoteid";
            thedata.alloweduser = $(this).data("reqs");
            thedata.status      = "0";

        $(document).find("#sendingemailstatus").html("Saving item...");
        a.savetodatabase(thedata, "allowed_users", false, false, function(){
            $(document).find("#sendingemailstatus").html("sending email..");

            let a = new Dsifronprocs();

                a.sendemail(subject, message, link , id , idfld , tbl , function(data){
                    alert("Your email is sent.");
                }, emailto);
        });
            
    });
// end 

// remove user access 
    $(document).on("click",".removespan", function(){
        let tblid = $(this).data("auid");

        let dis   = $(this).parent();

        a.removeitem("allowed_users", tblid, "auid", function(data){
            if (data) {
                alert("User have successfully been removed from editing this quotation.");
                dis.remove();
            }
        }, true);
    });
// end user access 


// save this other item
$(document).on("click","#savethisotheritem", function(){
    let itemgrpid = $(document).find("#itemgrpid").val();

    // custpertxt
    let tblorder  = $(document).find("#tbodyrow").children().length;
    let quoteidfk = $(document).find("#quoteidfk").val();
    let itemcost  = $(document).find("#costtxt").val();

    let interid   = $(document).find("#interid").val();

    let basicinfo                   = new Object();
        basicinfo.quoteidfk         = quoteidfk;
        basicinfo.tblorder          = tblorder+1;
        basicinfo.itemtype          = $(document).find("#thetypeofitem").val();
        basicinfo.itemdesc          = $(document).find("#itemdesc").val();
        basicinfo.itemcost          = itemcost;
        basicinfo.suppname          = null;
        basicinfo.supppart          = null;
        basicinfo.manuname          = null;
        basicinfo.manupart          = null;
        basicinfo.markup            = "markup"; // $(document).find("#markupselect").val();

        if ($(document).find("#percentageselect").val() == "customper") {
            basicinfo.markupvalue       = $(document).find("#custpertxt").val();
        } else {
            basicinfo.markupvalue       = $(document).find("#percentageselect").val();
        }

        if (basicinfo.itemtype == "Freight") {
            basicinfo.qty    = "1";
        } else {
            basicinfo.qty    = $(document).find("#qtytxt").val();
        }

        // ## shipping 
            // if (basicinfo.itemtype == "Freight") {
            //     basicinfo.itemcost           = "0";
            //     basicinfo.markupvalue        = "0";

            //     basicinfo.withshipping       = "1";
            //     basicinfo.shippingcost       = itemcost;
            //     basicinfo.shippingmarkup     = basicinfo.markupvalue;
            //     basicinfo.qty                = "1";
            // } else {
            //     delete basicinfo.withshipping;
            //     delete basicinfo.shippingcost;
            //     delete basicinfo.shippingmarkup;

            //     basicinfo.itemcost           = itemcost;
            //     basicinfo.qty               = $(document).find("#qtytxt").val();

            //     if ($(document).find("#percentageselect").val() == "customper") {
            //         basicinfo.markupvalue       = $(document).find("#custpertxt").val();
            //     } else {
            //         basicinfo.markupvalue       = $(document).find("#percentageselect").val();
            //     }
                
            // }
        // ## end shipping

        // ## expiry date 
        // if ( $("#addexpirybtn").is(":checked") ) {
        //     basicinfo.withexpiry = "1";
        //     basicinfo.expnumber  = $(document).find("#expirynumber").val();
        //     basicinfo.expunit    = $(document).find("#expiryunit").val();
        //     basicinfo.expnote    = $(document).find("#expirynote").val(); 
        // } else {
        //     delete basicinfo.withexpiry;
        //     delete basicinfo.expnumber;
        //     delete basicinfo.expunit;
        //     delete basicinfo.expnote;
        // }
        // ## end expiry
        
        
        if ( $('#istax').is(":checked") ) {
            basicinfo.taxable           = "1";
        } else {
            basicinfo.taxable           = "0";
        }

        let vals    = $(document).find("#markuplineselect").val();

        console.log(vals);

        let valtext = "";

        basicinfo.productlineid = vals.split("_")[2];

        if (vals.split("_")[1] == "0") {
            valtext = $(document).find("#thetypeofitem :selected").text();
        } else if (vals.split("_")[1] == "1") {
            valtext = $(document).find("#customitemtypetxt").val();
        }

        if (valtext.length == 0) {
            alert("Please choose the product line");
            return;
        }

        basicinfo.productline   = valtext;

        if (itemcost.length == 0) {
            alert("Item cost cannot be empty"); return;
        }

        // console.log(basicinfo); return;
        a.savetodatabase(basicinfo, "quoteitemstbls", false, false, function(data){
            $(document).find("#insertotheritem").hide();
            $(document).find(".modal-backdrop").hide();
            $('body').removeClass("modal-open");

            a.displaytotable(interid, data);
            
            let theitems           = new Object();
                theitems.theitemid = data;

            a.updateentries(theitems, "itemreferencetbls", itemgrpid, "itemgrpid");
            a.computatethetotal(quoteidfk);
            a.checkformarkupstatus(data);
        }, false, false);
});
// end 

// 
$(document).on("change", "#thetypeofitem", function(){
    let itemselect = $(this).val();

    if (itemselect == "Labor") {
        $(document).find(".forlabor").show();
        $(document).find(".forfreight").hide();
    } else if (itemselect == "Freight") {
        $(document).find(".forlabor").hide();
        $(document).find(".forfreight").show();
    } else {
        $(document).find(".forlabor").hide();
        $(document).find(".forfreight").hide();
    }
});

// add comment 
    $(document).on("click","#addcommentbtn", function(){
        if (qtid.length > 1){
            alert("Select only one(1) item.");
            return;
        }

        let quoteidfk = $(document).find("#quoteidfk").val();

        let basicinfo                   = new Object();
            basicinfo.quoteidfk         = quoteidfk;
            basicinfo.quoteitemidfk     = qtid[0];
            basicinfo.thecomment        = $(document).find("#thecommenttxt").val();
            basicinfo.status            = "1";

        a.savetodatabase(basicinfo, "comments_tbls", false, false, function(data){
            alert("comment saved");
            $("#addcomment").modal("hide");
        });

    });
// end add comment btn

// update comment btn 
    $(document).on("click","#updatecommentbtn", function(){
        let theitems            = new Object();
            theitems.thecomment = $(document).find("#thecommenttxt").val();

        if (qtid.length >  1) {
            alert("Select only one(1) item.");
            return;
        }

        a.updateentries(theitems, "comments_tbls", qtid[0], "quoteitemidfk", function(){
            alert("updated");
            $("#addcomment").modal("hide");
        });
    })
// end

// remove subtotal 
    $(document).on("click",".removesubtotal", function(){
        let subtotalid = $(this).data("subtotalid");

        a.removeitem("subtotaltbls", subtotalid, "subtotalid", function(data){
            let a = new Dsifronprocs();

            let theitems                = new Object();
                theitems.subtotalidfk   = null;

            a.updateentries(theitems, "quoteitemstbls", subtotalid, "subtotalidfk", function(data){
                a.displaythequoteitems( $(document).find("#quoteidfk").val() ) 
                a.computatethetotal( $(document).find("#quoteidfk").val() );
            });
        }, true);
    });
// end removal 

$(document).on("dblclick",".allowedsubqty", function(){
    $("#editsubsqty").modal("show");

    let id = $(this).data("id");
    
    a.showdwindow_to_here("editsubqty", id, "loadsubtotalspan", false );
});

// edit subtotal
$(document).on("click","#updatesubtotal", function(){
    let subtotalid = $(this).data("id");

    let theitems                = new Object();
        theitems.subtotalname   = $(document).find("#subtotdesc").val();
        theitems.subtotalqty    = $(document).find("#subtotqty").val();
        
    a.updateentries(theitems, "subtotaltbls", subtotalid, "subtotalid", function(data){
        let a = new Dsifronprocs();

            a.displaythequoteitems( $(document).find("#quoteidfk").val() ) 
            a.computatethetotal( $(document).find("#quoteidfk").val() );

            $("#editsubsqty").modal("hide");
    });
});
// edit subtotal

// sendoption 
 $(document).on("click",".sendoptionchck", function(){
    let val    = $(this).val();
    let vtype  = $(this).data("vtype");
    let qidfk  = $(document).find("#quoteidfk").val();

    if ( $(this).is(":checked") ) {
        let basicinfo               = new Object();
            basicinfo.viewoptionfld = val;
            basicinfo.viewoptiontxt = $(this).data("datatxt");
            basicinfo.quoteidfk     = qidfk;
            basicinfo.optiontype    = vtype;
            basicinfo.status        = "1";
        // console.log(basicinfo); return;
        let dis = $(this);

        $(document).find("#savingoptions").html("saving...");
        a.savetodatabase(basicinfo, "viewquoteopts", false, false, function(data){
            dis.attr("data-tblid",data);
            alert("saved");

            let a = new Dsifronprocs();
                a.showdwindow_to_here("viewoptionsorders",qidfk,"columntds");

            $(document).find("#savingoptions").html("");
        });
    } else {
        $(document).find("#savingoptions").html("removing...");
        a.removeitem("viewquoteopts", $(this).data("tblid"), "vopid", function(){
            alert("removed");
            
            let a = new Dsifronprocs();
                a.showdwindow_to_here("viewoptionsorders",qidfk,"columntds");

            $(document).find("#savingoptions").html("");
        }, true, true);
    }

 })
// end 

// set computation 
 $(document).on("click",".setcomputation", function(){
    var conf = confirm("Are you sure you want to continue?");

    if (!conf) {
        return;
    }

    let quoteidfk            = $(document).find("#quoteidfk").val();

    let basicinfo            = new Object();
        basicinfo.custid     = $(this).data("custid");
        basicinfo.quoteidfk  = quoteidfk;
        basicinfo.grttypeid  = $(this).data("value");
        basicinfo.grtvalue   = $(this).data("text");
        // basicinfo.grttypeid  = $(document).find("#grtselect").val();
        // basicinfo.grtvalue   = $(document).find("#grtselect :selected").text();
        
    a.savetodatabase(basicinfo, "grttables", false, false, function(data){
        alert("Saved");
        window.location.reload();
    });
 })
// end setting computation

$(document).on("click",".viewingoptions",function(){
    let qidfk  = $(document).find("#quoteidfk").val();
    a.showdwindow_to_here("viewoptionsorders",qidfk,"columntds");
});
// showdwindow_to_here

// send back button 
$(document).on("click","#sendbackbtn", function(){
    let link            = window.location.href;
    let subject         = $("#sendbackwindow").find("#sendbacksubject").val();
    let message         = $("#sendbackwindow").find("#sendbackmessage").val();
    let idto            = $(this).data("owner");
    let usertablefrom   = "users";
    let usertablepkid   = "id";
    let fieldtoget      = "email";

    let quoteidfk = $(document).find("#quoteidfk").val();
    // let ownerid   = $(this).data("owner");

    // let thedata       = new Object();
    //     thedata.table = "quotation_corners",
    //     thedata.idfk  = quoteidfk,
    //     thedata.

    $("<p style='margin-top: 5px;margin-bottom: 0px;margin-left: 15px;'> sending message... please wait </p>").appendTo("#msgstat");

    a.sendgenericemail("emailtemplates.sendbackemail", subject, message, idto, usertablefrom, usertablepkid, fieldtoget ,link, function(data){
        // alert("Message sent");
        // let a = new Dsifronprocs();

        // a.saveorupdate(thedata, checkforthis, table, function(){

        // });
        $("#msgstat").html("<p style='margin-top: 5px;margin-bottom: 0px;margin-left: 15px;'> Message Sent </p");
        // window.location.reload();
    });
});
// end 