// call after body onload
window.onload = function(){
    a.displaythequoteitems( $(document).find("#quoteidfk").val() ) 
    a.computatethetotal( $(document).find("#quoteidfk").val() );

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
        let itemcost  = $(document).find("#costtxt").val();

        let basicinfo                   = new Object();
            basicinfo.quoteidfk         = quoteidfk;
            basicinfo.tblorder          = tblorder+1;
            basicinfo.itemtype          = "custom";
            basicinfo.itemdesc          = $(document).find("#itemdesc").val();
            basicinfo.itemcost          = itemcost;
            basicinfo.suppname          = $(document).find("#suppname").val();
            basicinfo.supppart          = $(document).find("#supppart").val();
            basicinfo.manuname          = $(document).find("#mfgname").val();
            basicinfo.manupart          = $(document).find("#mfgpart").val();
            basicinfo.markup            = $(document).find("#markupselect").val();

            if ($(document).find("#percentageselect").val() == "customper") {
                basicinfo.markupvalue       = $(document).find("#custpertxt").val();
            } else {
                basicinfo.markupvalue       = $(document).find("#percentageselect").val();
            }
            
            let qty      = $(document).find("#qtytxt").val();
            let price    = $(document).find("#sellpricetxt").val();
            // let extprice = parseInt(qty)*parseFloat(price);

            basicinfo.qty               = qty;
            basicinfo.price             = price;

            basicinfo.extended          = extendedprice;
            basicinfo.status            = "1";

            let thefinalitemcost        = (parseFloat(itemcost)*qty);
            basicinfo.profit            = parseFloat(extendedprice) - parseFloat(thefinalitemcost);

            // if ($("input[name='istax']:checked")) {
            if ( $('#istax').is(":checked") ) {
                basicinfo.taxable           = "1";
            } else {
                basicinfo.taxable           = "0";
            }
            
            // console.log(basicinfo); return;
            a.savetodatabase(basicinfo, "quoteitemstbls", false, false, function(data){
                $(document).find("#insertitem").hide();
                $(document).find(".modal-backdrop").hide();
                $('body').removeClass("modal-open");

                a.displaytotable(basicinfo, data);
                
                let theitems           = new Object();
                    theitems.theitemid = data;

                a.updateentries(theitems, "itemreferencetbls", itemgrpid, "itemgrpid");
                a.computatethetotal(quoteidfk);
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

        $(this).html("");
        

        $("<input type='text' class='inlineeditbox' value='"+content+"'/>")
            .on("blur", function(){

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

                            a.computatethetotal(quoteidfk);   
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
$(document).on("click","#removebtn", function(){
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

    a.sendemail(subject, message, link , quoteidfk, "quoteid", "quotation_corners", function(){
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
        let na = $(document).find("#na").val();

        if (na == 1 || na == "1") {
            alert("Cannot proceed with the sending. This document needs to be approved first.");
            return;
        }

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
        $("<p class='additemtab' data-tabname='"+idname+"' id='tab"+idname+"'>"+theobject.criteria+"</p>").prependTo("#tabgroupdiv");
        $("<div id = '"+idname+"' class='additemtab_div pd-t-10 pd-b-10 pd-b-10 pd-r-15 pd-l-15'>"+
            "<p> Reference: <input type='text' class='dsitxtbox thetextinput mg-b-5' data-fld='reference' data-idfld='itemrefid' data-id='"+data+"' data-tbl='itemreferencetbls' value='"+theobject.reference+"' style='width: auto;'/> <small class='peritemedit'> edit </small> </p>"+
            "<p> Value: <input type='text' class='dsitxtbox thetextinput mg-b-5' data-fld='thevalue' data-idfld='itemrefid' data-id='"+data+"' data-tbl='itemreferencetbls' value='"+theobject.thevalue+"' style='width: auto;'/> <small class='peritemedit'> edit </small> </p>"+
            "<button id='deletethisdiv' data-tblid='"+data+"' data-domid='"+idname+"' class='btn btn-danger btn-sm mg-t-5'> Delete </button>"+
         "</div>").appendTo("#criteriadivdisplay");

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