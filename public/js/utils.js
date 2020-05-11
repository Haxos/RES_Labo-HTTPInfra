import Chance from 'chance'
export default {
    generateTransaction() {
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