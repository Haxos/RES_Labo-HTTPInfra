$(function() {
    console.log("Loading transactions");

    function loadTransactions() {
        $.getJSON("/api", function(transactions) {
            console.log(transactions);
            let message = "";

            if(transactions.length == 0) {
                message = "No transactions";
            } else {
                for (let i = 0; i < transactions.length; i++) {
                    message += transactions[i].from.firstName 
                    + " " + transactions[i].from.lastName 
                    + " -- " + transactions[i].quantity
                    + " --> " + transactions[i].to.firstName 
                    + " " + transactions[i].to.lastName 
                    + " || "
                }
                
            }
            
            $(".displayer").text(message);
        })
    }

    loadTransactions();
    setInterval(loadTransactions, 2000);
});