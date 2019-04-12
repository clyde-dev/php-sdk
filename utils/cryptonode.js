const crypto = require('crypto');


const hash = crypto.createHash('sha256');
const hash_digest = hash.update('x').digest();

const hmac = crypto.createHmac('sha512', 'x');
const hmac_digest = hmac.update('x' + hash_digest).digest('base64');

console.log('hash', hmac_digest);