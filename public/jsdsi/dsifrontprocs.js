// const { get } = require("lodash");
let needsapproval = false;

class Dsifronprocs {
    numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    removecommas(x) {
        return x.replace(/,/g, '');
    }

    showdwindow(thewindow, id = false) {
        $(document).find("#showwindowhere").html("...loading data");
        $.ajax({
            url  : url+"/"+thewindow,
            type : "GET",
            data : { id : id },
            dataType : "html",
            success : function(data) {
                $(document).find("#showwindowhere").html(data);
            }, error : function() {
                alert("error");
            }
        });
    }

    showdwindow_to_here(thewindow, id = false, displayhere, anotherid = false) {
        $(document).find("#"+displayhere).html("...loading data");
        $.ajax({
            url  : url+"/"+thewindow,
            type : "GET",
            data : { id : id , anotherid : anotherid},
            dataType : "html",
            success : function(data) {
                $(document).find("#"+displayhere).html(data);
            }, error : function() {
                alert("error");
            }
        });
    }

    intablinkwindow(thewindow, id = false , viewdeck = false, theviewspan = false) {
        if (theviewspan == false) {
            theviewspan = "intabviewspan";
        }

        $(document).find("#"+theviewspan).html("...loading data");
        $.ajax({
            url  : url+"/"+thewindow,
            type : "GET",
            data : { id : id, viewdeck : viewdeck },
            dataType : "html",
            success : function(data) {
                $(document).find("#"+theviewspan).html(data);
            }, error : function() {
                alert("error displaying in tab link");
            }
        });
    }

    ajaxsetup() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    savenewrecord(companyname,contactperson,contactnumber,emailadd) {
        if (companyname.length==0) {
            alert("Company's name cannot be empty");
            return;
        }

        $.ajax({
            url      : url+"/newrecord",
            type     : "post",
            data     : { companyname:companyname, contactperson:contactperson, contactnumber:contactnumber, emailadd:emailadd },
            dataType : "json",
            success  : function(data) {
                window.location.href = url+"/customer/"+data;
            }, error : function() {
                alert("error");
            }
        });
    }

    saveinfo(basicinfo, id) {
        $.ajax({
            url      : url+"/saveinfo",
            type     : "post",
            data     : {basicinfo : basicinfo, id:id},
            dataType : "json",
            success  : function(data){
                window.location.reload();
            }, error : function(){
                alert("hi")
            }
        });
    }

    savetodatabase(thedata, table, id = false, action = false, somefunction, share = false, history = false){
        $.ajax({
            url     : url+"/savetodatabase",
            type    : "post",
            data    : { thedata : thedata , 
                        table   : table, 
                        id      : id, 
                        action  : action,
                        share   : share,
                        history : history
                    },
            dataType: "json",
            success : function(data){
                // if (data == true) {
                    somefunction(data);
                // }
            }, error: function(){
                alert("Error Saving to database");
            }
        });
    }

    showitemcats(applet, cats = false) {
        $(document).find("#itemdivbox").addClass("maxwidth");

        $(document).find("#categoryselect").removeClass("dsihide");
        $(document).find("#categoryselect").addClass("dsishow");

        $(document).find("#windowselected").text("");
        switch(applet) {
            case "nontaxable":
                ///$(document).find("#windowselected").text("Non-Taxable");
                break;
            case "taxable":
                ///$(document).find("#windowselected").text("Taxable");
                break;
            case "additem":
                $(document).find("#categoryselect").removeClass("dsishow");
                $(document).find("#categoryselect").addClass("dsihide");
                $(document).find("#windowselected").text(": Custom Item");
                $(document).find("#itemdivbox").removeClass("maxwidth");
            break;
        }
       
        $.ajax({
            url      : url+"/"+applet,
            type     : "GET",
            data     : { applet : applet, cats : cats },
            dataType : "html",
            success  : function(data) {
                $(document).find("#additemsshow").html(data);
            }, error : function() {
                alert("error")
            }
        });
    }

    showwowindow(woapplet, id) {
        $.ajax({
            url      : url+"/workorders",
            type     : "GET",
            data     : { applet : woapplet, id : id },
            dataType : "html",
            success  : function(data){
                $(document).find("#showwohere").html(data);
            }, error : function() {
                alert("error")    
            }
        });
    }

    setdocumenttitle(title) {
        document.title = title;
    }

    // saving per item
    saveperitem(table, id, idfld, field, value, somefunction, otherinfo = false) {
        $.ajax({
            url     : url+"/saveperitem",
            type    : "post",
            data    : { table: table, id : id, idfld : idfld, field : field, value : value, otherinfo : otherinfo},
            dataType: "json",
            success : function(data) {
                somefunction(data);
            }, error: function() {
                
            }
        });
    }
    // end 

    // save per item to quotations tbl
    saveperitem_qt(table, id, idfld, field, value, somefunction) {
        $.ajax({
            url     : url+"/saveperitem_qt",
            type    : "post",
            data    : { table: table, id : id, idfld : idfld, field : field, value : value },
            dataType: "json",
            success : function(data) {
                somefunction(data);
            }, error: function() {
                
            }
        });
    }
    // end 

    // remove item :: hide 
    removeitem(tbl, id, idfld, somefunction, truedelete = false, bypassalert = false) {
        if (bypassalert == false) {
            var conf  = confirm("Are you sure you wanted to delete this data?");
            
            if (!conf) {
                return;
            }
        }

        $.ajax({
            url     : url+"/removeitem",
            type    : "post",
            data    : { tbl:tbl, id:id,idfld:idfld, truedelete : truedelete },
            dataType: "json",
            success : function(data) {
                somefunction();
            }, error : function() {
                alert("error removing data")
            }
        });
    }
    // end 

    // transfer to new customer 
    transfertonew(custid, contid, somefunction) {
        var conf = confirm("You are about to transfer this contact to another customer. Proceed?");

        if (!conf) {
            return;
        }

        $.ajax({
            url      : url+"/transfer",
            type     : "POST",
            data     : { custid : custid, contid : contid },
            dataType : "json",
            success  : function(){
                somefunction();
            }, error : function(){
                alert("Error transferring to new customer");
            }
        });
    }
    // end 

    // get the tasks 
    getthetasks() {
        $.ajax({
            url     : url+"/gettasks",
            type    : "post",
            dataType: "html",
            success : function(data){
                $(document).find("#tasksdivappear").html(data);
            }, error: function() {
                alert("Error getting tasks");
            }
        });
    }
    // end 

    // display to quotation table 
    displaytotable(info, uniqueid) { // 
        $.ajax({
            url      : url+"/displayperitem",
            type     : "get",
            data     : { info : info, uniqueid : uniqueid },
            dataType : "html",
            success  : function(data){
                // console.log(data);
                $(document).find("#tbodyrow").append(data);
            }, error : function(){
                alert("error displaying the data");
            }
        });

    }
    // end 

    // compute the total 
    computatethetotal(quoteidfk) {
        $.ajax({
            url        : url+"/computetotal",
            type       : "get",
            data       : { quoteidfk : quoteidfk },
            dataType   : "html",
            success    : function(data) {
                $(document).find("#totaldiv").html(data);

                let a = new Dsifronprocs();
                    a.checkitemneedsapproval(quoteidfk);

            }, error : function(){
                // alert("error computing");
                console.log("error computing...");
            }
        });
    }
    // end 

    // check for markup status 
    checkformarkupstatus(quoteitemid, somefunction = false) {
        $.ajax({
            url        : url+"/checkformarkups",
            type       : "post",
            data       : { quoteitemid : quoteitemid },
            dataType   : "html",
            success    : function(data) {
                if (data != "0" || data != 0) {
                    needsapproval = true;
                } else {
                    needsapproval = false;
                }

                if (somefunction == false) {
                    if (data != "0" || data != 0) {
                        $(document).find("#checkformarkups").html(data);
                    } else {
                        $(document).find("#checkformarkups").html("");
                    }
                } else {
                    somefunction(data);
                }
            }, error : function(){
                // alert("error computing");
                console.log("error computing...");
            }
        });
    }
    // end 

    // compute for selling price 
    sellingprice(price, percentage) {
        // return (price/(100/percentage))+price;
        let per   = (100/percentage);
        let addon = (price/per);
        
        let sellprice = parseFloat(price) + parseFloat(addon);

        // grt 
            let grt = $(document).find("#interid").val();

            if (grt == 2) { // private
                let grtadd    = (sellprice*.05);
                sellprice     = parseFloat(grtadd)+parseFloat(sellprice);
            } else {  // 

            }
        // end grt 
        
        if (sellprice == price) {
            //sellprice = parseFloat(sellprice) + parseFloat(1.0);
        }

        return Math.ceil(sellprice)+".00";
    }
    // end 

    // display the quoteitems 
    displaythequoteitems(quoteid) {
        $.ajax({
            url      : url+"/displayquote",
            type     : "get",
            data     : { quoteid : quoteid },
            dataType : "html",
            success  : function(data){
                $(document).find("#tbodyrow").html(data);
            }, error : function() {
                alert("error retrieving data");
            }
        });
    }
    // end 

    // remove quote items 
    removequoteitems(id, quoteid) {
        $.ajax({
            url      : url+"/removeqtitems",
            type     : "post",
            data     : { id : id },
            dataType : "json",
            success  : function(data) {
                let a = new Dsifronprocs();
                a.displaythequoteitems(quoteid);
                a.computatethetotal(quoteid);
                a.checkitemneedsapproval(quoteid);
            }, error : function() { 
                alert("error deleting");
            }
        });
    }
    // end 

    saveexistingitem(itemid, quoteid, tblorder) {
        $.ajax({
            url      : url+"/saveexisting",
            type     : "post",
            data     : { itemid : itemid , quoteid : quoteid, tblorder : tblorder },
            dataType : "html",
            success   : function(data){
                let a = new Dsifronprocs();
                $(document).find("#tbodyrow").append(data);

                $(document).find("#insertitem").hide();
                $(document).find(".modal-backdrop").hide();
                $('body').removeClass("modal-open");

                a.computatethetotal(quoteid);
            }, error : function() {
                alert("error on saving this item")
            }
        });
    }

    removemultipleitems(theids, table, idfld, somefunction) {
        $.ajax({
            url      : url+"/removemultiple",
            type     : "post",
            data     : { theids : theids, table : table, idfld : idfld },
            dataType : "json",
            success  : function(data) {
                somefunction();
            }, error : function(){
                alert("Error removing the items");
            }
        }); 
    }

    sendemail(subject, message, link , id = false , idfld = false, tbl = false , somefunction = false, emailto = false) {
        
        $.ajax({
            url        : url+"/sendemail",
            type       : "post",
            data       : { subject : subject, 
                           message : message , 
                           link : link, 
                           id : id, 
                           idfld : idfld,
                           tbl : tbl,
                           emailto : emailto
                        },
            success    : function(){
                if (somefunction != false) {
                    somefunction();
                }
            }, error   : function(){
                alert("error sending email")
            }
        });
    }

    sendtocontact(template, subject, message, link , to = false, id = false , idfld = false, tbl = false , somefunction = false) {
        $.ajax({
            url        : url+"/sendtocontact",
            type       : "post",
            data       : { template : template,
                           subject : subject, 
                           message : message,
                           to      : to,
                           link : link, 
                           id : id, 
                           idfld : idfld,
                           tbl : tbl
                        },
            success    : function(){
                if (somefunction != false) {
                    somefunction();
                }
            }, error   : function(){
                alert("error sending email")
            }
        });
    }

    updateentries(theitems, table, thekey, keyfld, somefunction = false) {
        $.ajax({
            url     : url+"/updatefields",
            type    : "post",
            data    : { theitems : theitems, 
                        table    : table,
                        thekey   : thekey,
                        keyfld   : keyfld
                        },
            dataType: "json",
            success : function(data) {
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error: function(){
                alert("Error updating");
            }
        });
    }

    sendnotification(reference, message, grpidfk, link, item , redirect , somefunction = false) {

        $(document).find("#loadinginformation").show();
        $(document).find("#loadinginfo_span").html("verifying...");

        $.ajax({
            url     : url+"/sendnotification",
            type    : "post",
            data    : {
                reference : reference,
                message : message,
                grpidfk : grpidfk,
                item    : item,
                link    : link,
                redirect : redirect
            }, dataType : "json",
            success : function(data){
                if (somefunction != false) {
                    $(document).find("#loadinginformation").hide();
                    $(document).find("#successfulinformation").show();
                    $(document).find("#successinfo_span").html("Notification sent.");
                    somefunction(data);
                }
            }, error : function(){
                alert("error sending message");
            }
        })
    }

    savetonewcustomer(custid, quoteid, somefunction =  false) {
        // $.ajax({
        //     url     : url+'/savetonewcustomer',
        //     type    : "post",
        //     data    : 
        // });
    }

    saveorupdate(thedata, checkforthis, table, somefunction = false) {
        $.ajax({
            url     : url+"/saveorupdate",
            type    : "post",
            data    : {
                thedata      : thedata,
                checkforthis : checkforthis,
                table        : table
            }, success : function(data){
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error : function(){
                alert("Error saving or updating data");
            }
        });
    }

    changevalidityperiod(quoteid, theperiod, somefunction = false) {
        $.ajax({
            url      : url+"/changevalidity",
            type     : "post",
            data     : { quoteid : quoteid, theperiod : theperiod },
            dataType : "json",
            success  : function(data) {
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error : function() {
                alert("Error changing date validity");
            }
        }) 
    }

    gettotalestsh(grpid, fromvendor, gettotalfrom ,somefunction = false) {
        $.ajax({
            url      : url+"/totalestsh",
            type     : "post",
            data     : { grpid : grpid , fromvendor  : fromvendor , gettotalfrom : gettotalfrom },
            dataType : "json",
            success  : function(data) {
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error : function() {
                alert("error computing total estimated SH");
            }
        });
    }

    gettotalcost(orderid, vendor, somefunction = false) {

        $.ajax({
            url      : url+"/gettotalcost",
            type     : "post",
            data     : { orderid : orderid , vendor : vendor},
            dataType : "json",
            success  : function(data) {
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error : function() {
                alert("Error total cost")
            }
        })
    }

    updatemultipleitems(thevalue, table, pkidstoupdate ,fieldtoupdate , pkfield, somefunction = false ) {
        
        $.ajax({
            url     : url+"/updatemultipleitems",
            type    : "post",
            data    : {
                thevalue      : thevalue,
                table         : table,
                pkidstoupdate : pkidstoupdate,
                fieldtoupdate : fieldtoupdate,
                pkfield       : pkfield
            }, dataType : "json",
            success : function(data){
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error : function(){
                alert("error saving to "+table+" table");
            }
        })
    }

    loadmarkups(groupid, somefunction = false) {
        $.ajax({
            url      : url+"/loadmarkups",
            type     : "post",
            data     : { groupid : groupid },
            dataType : "html",
            success  : function(data){
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error : function(){
                alert("error retrieving mark ups");
            }
        });
    }

    callawindow(uniqueid, windowtocall, somefunction = false) {
        $.ajax({
            url      : url+"/"+windowtocall,
            type     : "post",
            data     : { uniqueid : uniqueid },
            dataType : "html",
            success  : function(data){
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error : function(){
                alert("error getting the window");
            }
        });
    }

    checkitemneedsapproval(grpidfk, somefunction = false) {
        $.ajax({
            url      :  url+"/checkitemneedsapproval",
            type     : "post",
            data     : { grpidfk : grpidfk },
            dataType : "html",
            success  : function(data){

                if (data != "0" || data != 0) {
                    needsapproval = true;
                    $(document).find("#checkformarkups").html(data);
                } else {
                    needsapproval = false;
                    $(document).find("#checkformarkups").html("");
                }

                if (somefunction != false) {
                    somefunction(data);
                }
                
            }, error : function(){
                alert("error checking items that needs approval");
            }
        });
    }

    sendgenericemail(template, subject, message, idto, usertablefrom, usertablepkid, fieldtoget ,link, somefunction = false) {
        $.ajax({
            url      : url+"/sendgenericemail",
            type     : "post",
            data     : { template : template, subject : subject, message : message, idto : idto, usertablefrom : usertablefrom, usertablepkid : usertablepkid, fieldtoget : fieldtoget, link : link }, 
            dataType : "json",
            success  : function(data){
                if (somefunction != false) {
                    somefunction(data);
                }
            }, error : function(a,b,c){
                alert("Error in sending email");
            }
        });
    }

    // callgrandtotal(id, affectid) {
    //     gettotalestsh(id, vendor, affectid, function(data){
    //         $(document).find("#"+affectid).html(data);
    //     });
    // }
}
