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
            let body = JSON.parse(clientReq);

            if (bots.getAllBots().hasOwnProperty(wsKey) || admins.hasOwnProperty(wsKey)) {
                if(body.action){
                    sendActionToAllBots(body)
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


// function startSingle(bot, game){
//     if(bot != undefined){
//         bot.send(JSON.stringify({
//             "start": game
//         }))
//     } else{
//         // send msg to admins
//     }
// }

// function startAll(game){
//     if(bots != undefined){
//         for (let id in bots) {
//             bots[id].send(JSON.stringify({ 
//                 "start": game
//             }))
//         }
//     } else{
//         // send msg to admins
//     }
// }


// let request = JSON.parse(clientReq);
// console.log(req.headers['sec-websocket-key']);
// switch (request.action) {
//     case "login":
//         login(request, req.headers['sec-websocket-key'], client)
//         break;
//     case "prepare":
//         if (request.for == "single") {

//         } else {
//             sendActionToAllBots(request.action, request.game);
//         }
//         break;
//     default:
// }