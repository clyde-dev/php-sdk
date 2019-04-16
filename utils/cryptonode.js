const crypto = require('crypto');

const timestamp = Math.floor(Date.now()/1000); //Unix timestamp, not js
  const nonce = timestamp + Math.ceil(Math.random() * 100);

const url = 'http://localhost:3100/products';
const message = JSON.stringify(['GET', url, { x: 'y' }, ""+nonce, ""+timestamp]);
console.log('message', message); 
const hash = crypto.createHash('sha256');
  const hmac = crypto.createHmac('sha512', Buffer.from('x'));
  const hash_digest = hash.update(message).digest('hex');
  const hmac_digest = hmac.update(url + hash_digest).digest('base64');

console.log('hash', hmac_digest);