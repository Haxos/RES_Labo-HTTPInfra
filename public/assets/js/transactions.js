$(function() {
    console.log("Loading transactions");

    let container = $('#transactionsDisplayer');
    let baseTemplate = $('#transactionsDisplayer').find('template')[0];

    function refreshTransactions()
    {
        $.getJSON("/api", function(transactions) {
            container.html('');
            displayTransactions(transactions);
        });
    }

    function displayTransactions(transactions)
    {
        for (let i in transactions)
        {
            let newNode = $(baseTemplate.content.cloneNode(true));
            newNode.find('[data-from-first-name]').text(transactions[i].from.firstName);
            newNode.find('[data-from-last-name]').text(transactions[i].from.lastName);
            newNode.find('[data-to-first-name]').text(transactions[i].to.firstName);
            newNode.find('[data-to-last-name]').text(transactions[i].to.lastName);
            newNode.find('[data-quantity]').text(transactions[i].quantity);

            container.append(newNode);
        }
    }

    refreshTransactions();
    setInterval(refreshTransactions, 2000);
});
