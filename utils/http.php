<?php

/*
const buildHeaders = (clientKey:string, clientSecret:string, method:string, uri:string, body?:any) => {
  const timestamp = Math.floor(Date.now()/1000); //Unix timestamp, not js
  const nonce = timestamp + Math.ceil(Math.random() * 100);
  const signature = signMessage(clientSecret, method, uri, body || '', nonce, timestamp);
  const headers = {
    'Authorization': `${clientKey}:${signature}`,
    'X-Auth-Timestamp': timestamp,
    'X-Auth-Nonce': nonce,
    'Content-Type': 'application/vnd.api+json'
  };
  return headers;
}
*/

?>