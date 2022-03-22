const router = require("express").Router();
const Bots = require('../../../classes/bots.js')
const WebSocket = require("ws");

const bots = new Bots();
let admins = {};
const wss = new WebSocket.Server({
    port: 3003
});

wss.on('connection', (client, req) => {
    console.info("Total connected clients:", wss.clients.size);

    client.on('message', clientReq => {
        if (isValidJSONString(clientReq)) {
            let wsKey = req.headers['sec-websocket-key'];
            console.log(wsKey);
            let body = JSON.parse(clientReq);

            if ( clientIsBot(wsKey) || clientIsAdmin(wsKey)) {
                if(body.action && clientIsAdmin(wsKey)){
                    sendActionToAllBots(body)
                }else{
                    sendMsgToClient(client, {"error": "INVALID_COMMAND"})
                }

                if(body.status){
                    bots.setStatus(wsKey, body.status); 
                    console.log(this.getAllBots());
                } 

            } else {
                login(body, wsKey, client);
            }

        } else {
            client.send(JSON.stringify({
                "error": "INVALID_JSON"
            }))
        }
    })

    client.on('pong', () => {
        bots.setConnAttempt(req.headers['sec-websocket-key'], 2);
    });

    setInterval(() => {
        let botsList = bots.getAllBots();
        Object.keys(botsList).forEach(wsKey => {
            if (botsList[wsKey].connAttempt != 0) {
                botsList[wsKey].client.ping();
                bots.setConnAttempt(wsKey, botsList[wsKey].connAttempt - 1);
            } else {
                botsList[wsKey].client.terminate();
                bots.removeBot(wsKey);
            }
        })
    }, 1000 * 5)



})


function clientIsAdmin(wsKey){
    return admins.hasOwnProperty(wsKey)
}

function clientIsBot(wsKey){
    bots.getAllBots().hasOwnProperty(wsKey)
}


function login(req, wsKey, client) {
    if (req.key == "111") {
        admins[wsKey] = client;
        // console.log(bots.getAllBots());
    } else {
        if (bots.saveBot(req.id, wsKey, client)) {
            // console.log(bots.getAllBots());
            sendMsgToClient(client, { 
                "loggedin": true
            })
        } else {
            sendMsgToClient(client, {
                "loggedin": false
            })
        }
    }
} 


function sendActionToAllBots(body) {
    let botsList = bots.getAllBots();
    if (Object.keys(botsList).length != 0) {
        Object.keys(botsList).forEach(wsKey => {
            bots.setAction(wsKey, body.action)
            botsList[wsKey].client.send(JSON.stringify({
                "status": body.action,
                "game": body.game
            }))
        });
    } else {
        //geen bots conn
    }
}


function sendMsgToClient(client, msg) {
    client.send(JSON.stringify(msg));
}

function isValidJSONString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


module.exports = router;