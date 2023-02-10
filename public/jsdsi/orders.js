// find orders btn 
let globalfrom = null;
let globalto   = null;

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