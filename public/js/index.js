import Express from 'express';
import Utils from './utils.js';

const app = Express()
const port = 3000

app.get('/', (req, res) => res.send(Utils.generateTransaction()))

app.listen(port, () => console.log(`Example app listening at http://localhost:${port}`))