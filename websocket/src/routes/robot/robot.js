const router = require("express").Router();
const Bots = require('../../classes/bots.js')
const WebSocket = require("ws");

const wss = new WebSocket.Server({
    port: 3003
});

var games = [];

wss.on('connection', (client, req) => {
    console.info("Total connected clients:", wss.clients.size);

    setAttributeToClient("isAlive", true, client);

    client.on('message', message => {
        if (isValidJSONString(message)) {
            let body = JSON.parse(message);
            console.log(body);

            switch (body.action) {
                case "login":
                    if (body.key == "111") {
                        setAttributeToClient("role", "admin", client);
                        let body = {"games": []}
                        // client.send(JSON.stringify(games))
                    } else {
                        setAttributeToClient("role", "bot", client);
                    }
                    setAttributeToClient("id", body.id, client);
                    break;
                case "prepare":
                case "start":
                case "ended":
                    if (client.role == "admin") {
                        if (body.for == "all" && ready()) {
                            sendActionToAllBots(body.game, body.action);
                        } else {
                            sendMessageToInterface({
                                "status": false,
                                "msg": "NOT_READY"
                            }, client)
                        }
                    } else {
                        client.send(JSON.stringify({
                            "error": "UNAUTHORIZED"
                        }))
                    }
                    break;
            }

            if (body.status && client.role == "bot") {

                switch (body.status) {
                    case "preparing":
                        setAttributeToClient("status", body.status, client)
                        break;
                    case "preparing_game":
                    case "ready":
                    case "in_game":
                    case "finished":
                        // update client status in game
                        if (games["all"]) {
                            games["all"].bots.forEach((bot) => {
                                if (bot.id == client.id && bot.status != body.status) {
                                        bot.status = body.status
                                        // send games to admins
                                        sendMessageToInterface({
                                            "games": games["all"]
                                        })
                                }

                            })
                        }
                        // update client status
                        setAttributeToClient("status", body.status, client)
                        break;
                }

                // wss.clients.forEach(function each(client) {
                //     if (client.role == "bot") {}
                // });
            }

            if (body.error) {
                sendMessageToInterface({
                    "status": true,
                    "game": games
                })
            }

        } else {
            client.send(JSON.stringify({
                "error": "INVALID_JSON"
            }))
        }

    });

    client.on('pong', () => {
        heartbeat(client)
    })

    client.on('close', () => {
        console.info("Total connected clients:", wss.clients.size);
    })


})

const heartbeat = (client) => {
    client.isAlive = true;
}

const setAttributeToClient = (name, value, target = "all") => {

    if (target == "all") {
        wss.clients.forEach((client) => {
            if (client.role == "bot") {
                client[name] = value;
            }
        })
    } else {
        target[name] = value;
    }
}

const interval = setInterval(() => {
    wss.clients.forEach((client) => {
        if (client.isAlive === false) {
            return client.terminate()
        }

        client.isAlive = false
        client.ping()
    })
}, 5000)


function sendMessageToAllBots(message) {
    wss.clients.forEach((client) => {
        if (client.role == "bot") {
            client.send(JSON.stringify(message));
        }
    })
}

function addBotToGame(status, target = "all") {
    if (target == "all") {
        wss.clients.forEach((client) => {
            if (client.role == "bot") {
                games["all"].bots.push({
                    "botId": client.id,
                    "status": status
                });
            }
        })
    }
}

function sendMessageToInterface(message, target = "all") {
    if (target == "all") {
        wss.clients.forEach((client) => {
            if (client.role == "admin") {
                client.send(JSON.stringify(message));
            }
        })
    } else {
        target.send(JSON.stringify(message));
    }
}

/**
 * Check if bot/bots are ready for next command
 * @RETURN true OR false 
 **/
function ready(target = "all") {
    let ready = false
    if (target == "all") {

        wss.clients.forEach((client) => {
            if (client.role == "bot") {
                if (client.status == "ready") {
                    ready = true
                } else {
                    ready = false;
                }
            }
        });
    }

    return ready;
}

/**
 * Start game for all bots
 * @param {Sring} game name of the game
 * @param {String} action action: prepare. start OR ended
 */
function sendActionToAllBots(game, action) {
    if (action == "prepare") {
        games["all"] = {
            "game": game,
            "action": "preparing_game",
            "bots": []
        };

        addBotToGame("preparing_game");

        setAttributeToClient("game", game);

    }

    sendMessageToAllBots({
        "game": game,
        "action": action
    })  
    sendMessageToInterface({
        "status": true,
        "action": action,
        "games": games["all"],
        "for": "all"
    })
}

/**
 * Check is string is a valid json string
 * @param {String} str 
 * @returns true OR false
 */
function isValidJSONString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

module.exports = router;