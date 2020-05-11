import Express from 'express';
import Chance from 'chance';
var chance = new Chance();

const app = Express()
const port = 3000

app.get('/', (req, res) => res.send('Hello World!'))

app.listen(port, () => console.log(`Example app listening at http://localhost:${port}`))