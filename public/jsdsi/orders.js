// const { join } = require("lodash");

// find orders btn 
let globalfrom = null;
let globalto   = null;

// onload 
window.onload = function() {
    // let a     = new Dsifronprocs();
    // let grpid = $(document).find("#theorderdate").val();

    // a.gettotalestsh(grpid, function(data){
    //     let a   = new Dsifronprocs();
    //     let val = a.numberWithCommas(data);

    //     $(document).find("#totalestimatedsh").val(val);
    // });
}
// end onload

    $(document).on("click","#findordersbtn", function(){
        let from = globalfrom = $(document).find("#fromdatetxt").val();
        let to   = globalto   = $(document).find("#todatetxt").val();

        if (from.length == 0 || to.length == 0) {
            alert("Dates cannot be empty");
            return;
        } 
        window.location.href = url+"/orders/"+from+"_"+to;
    })
// end 

// supplier change 
    $(document).on("change","#suppliername", function(){
        let selecteditem = $(this).val();
        let orderdate    = $(document).find("#theorderdate").val();

        if( selecteditem != "default") {
            window.location.href = url+"/"+orderdate+"/"+selecteditem;
        } else {
            window.location.href = url+"/"+orderdate;
        }
    });
// end 

// orderdsitxtbox
    $(document).on("blur",".orderdsitxtbox", function(){
        let tbl    = $(this).data("tbl");
        let id     = $(this).data("id");
        let idfld  = $(this).data("idfld");
        let field  = $(this).data("fld");
        let value  = $(this).val();
        let grpid  = $(document).find("#theorderdate").val();
        let vendor = $(this).data("vendor"); 
        // alert(vendor); return;
            grpid = grpid.split("/")[1];
            //value = value.split(".")[0];

        let dis   = $(this);
            value = a.removecommas(value);
        
        let affectid = $(this).data("affectid");

        a.saveperitem(tbl,id,idfld,field,value,function(){
            let a = new Dsifronprocs();
            let v = a.numberWithCommas(value);
            dis.val(v);

            a.gettotalestsh(grpid, vendor, "totestimatedsh", function(data){
                $(document).find("#totalestimatedsh").html(data);

                let a = new Dsifronprocs();    
                    a.gettotalestsh(grpid, vendor, "totalcost", function(data){
                        $(document).find("#grandtotalcost").html(data);
                    });
            });

            $(document).find("#"+affectid).html("computing");
            a.gettotalcost(id, vendor ,function(data){
                $(document).find("#"+affectid).html(data);
            });

            $(document).find("#gggrandtotalcost").html("computing");
            a.gettotalestsh(grpid, vendor, "gggrandtotalcost", function(data){
                $(document).find("#gggrandtotalcost").html(data);
            });

            $(document).find("#grandestsh").html("computing");
            a.gettotalestsh(grpid, vendor, "grandestsh", function(data){
                $(document).find("#grandestsh").html(data);
            });
        });
    });

    $(document).on("blur",".grandtaxtxt", function() {
        let tbl    = $(this).data("tbl");
        let id     = $(this).data("id");
        let idfld  = $(this).data("idfld");
        let field  = $(this).data("fld");
        let value  = $(this).val();
        //let grpid  = $(document).find("#theorderdate").val();
        let vendor = $(this).data("vendor"); 

        let affectid = $(this).data("affectid");

        a.saveperitem(tbl,id,idfld,field,value,function(){
            let a = new Dsifronprocs();

            a.gettotalestsh(id, vendor, affectid, function(data){
                $(document).find("#"+affectid).html(data);
            });
        });
    });
//