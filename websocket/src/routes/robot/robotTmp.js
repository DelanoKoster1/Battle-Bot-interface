const router = require("express").Router();
const Bots = require('../../classes/bots.js')
const WebSocket = require("ws");

const wss = new WebSocket.Server({
    port: 3003
});

const bots = new Bots();
let admins = {};
let games = [];

// {
//     "game": "maze", 
//     "bots": [{"id": "edsdfsf", "status": "true"}, {"id": "edsdfsf", "status": "true"}],
//     "action": "prepare"
// }
wss.on('connection', (client, req) => {
    console.info("Total connected clients:", wss.clients.size);

    client.on('message', clientReq => {
        if (isValidJSONString(clientReq)) {
            let wsKey = req.headers['sec-websocket-key'];
            let body = JSON.parse(clientReq);
            if (clientIsBot(wsKey) || clientIsAdmin(wsKey)) {
                if (body.action && clientIsAdmin(wsKey)) {
                    let selectedGame = body.game;
                    let action = body.action;
                    let target = body.for;
                    // let for = body.for;
                   

                    if(selectedGame == "maze" || selectedGame == "race" || selectedGame == "butler"){
                        let game = {
                            "game": selectedGame,
                            "action": action,
                            "bots": []
                        }

                        if(target == "all"){
                            let botsList = bots.getAllBots();
                            Object.keys(botsList).forEach(wsKey => {
                                game.bots.push({ "wsKey": wsKey, "status": false})
                                bots.setGame(wsKey, game);
                                sendActionToBot(wsKey, {
                                    "status": action,
                                    "game": selectedGame
                                })
                            });

                        }

                        games.push(game);

                    }else{
                        sendMsgToAdmin(wsKey, { "error": "UNVALID_GAME"})
                    }


                    // switch (body.for) {
                    //     case "all":
                    //         sendActionToAllBots(body);
                    //         break;
                    //     case "single":
                    //         // sendActionToBot(body);
                    //         break;
                    //     default:
                    //         sendMsgToClient(client, {
                    //             "error": "INVALID_COMMAND"
                    //         })
                    // }

                }

                if (body.status) {

                    let botGame = bots.getGame(wsKey);
                    games.forEach((game) => {
                        if(game == botGame){
                            game.bots.forEach((bot) => {
                                if(bot.wsKey == wsKey){
                                    bot.status = true;
                                }
                            })
                        }
                    })

                    // if (bots.botsReady()) {
                        // sendMsgToAllAdmins({
                            // "status": true
                        // })
                    // }
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
        bots.setConnAttempt(req.headers['sec-websocket-key'], 0);
    });

    setInterval(() => {
        let botsList = bots.getAllBots();
        Object.keys(botsList).forEach(wsKey => {
            if (botsList[wsKey].connAttempt < 1) {
                botsList[wsKey].client.ping();
                bots.setConnAttempt(wsKey, botsList[wsKey].connAttempt + 1);
            } else {
                botsList[wsKey].client.terminate();
                bots.removeBot(wsKey);
            }
        })
    }, 1000 * 5)



})


function clientIsAdmin(wsKey) {
    return admins.hasOwnProperty(wsKey)
}

function clientIsBot(wsKey) {
    return bots.getAllBots().hasOwnProperty(wsKey)
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

function sendActionToBots(bots, body){
    bots.forEach((i) => {
        console.log(bots[i]);
    //     sendMsgToClient(bots[i].wsKey, {
    //         "status": body.action,
    //         "game": body.game})
    })
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


function sendMsgToAllAdmins(body) {
    Object.keys(admins).forEach(wsKey => {
        admins[wsKey].send(JSON.stringify(body));
    })
}

function sendActionToBot(wsKey, body) {
    let bot = bots.getBotByWsKey(wsKey);
    sendMsgToClient(bot.client, body);

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