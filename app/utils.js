import Chance from 'chance'
export default {

    /**
     * Generate between 5 and 15 transactions. A transaction is composed of a sender (from)
     * and a reciever (to) with their respective credit cards and the quantity exchanged.
     * 
     * @returns Array of json.
     */
    generateRandomTransaction() {
        let chance = new Chance();
        let nbTransactions = chance.integer({
            min: 5,
            max: 15
        });
        let transactions = [];

        for (let i = 0; i < nbTransactions; i++) {
            let cardTypeFrom = chance.cc_type();
            let cardTypeTo = chance.cc_type();
            
            transactions.push({
                from: {
                    firstName: chance.first(),
                    lastName: chance.last(),
                    card: {
                        no: chance.cc(cardTypeFrom),
                        name: cardTypeFrom
                    }
                },
                to: {
                    firstName: chance.first(),
                    lastName: chance.last(),
                    card: {
                        no: chance.cc(cardTypeTo),
                        name: cardTypeTo
                    }
                },
                quantity: chance.euro()
            });
        }

        return transactions;
    }
}