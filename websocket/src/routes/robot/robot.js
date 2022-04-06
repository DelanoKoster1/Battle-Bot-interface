const router = require("express").Router();
const {
    v4: uuidv4
} = require('uuid');
const Bots = require('../../classes/bots.js')
const WebSocket = require("ws");

const wss = new WebSocket.Server({
    port: 3003
});

var games = [];
var botStats = [];

wss.on('connection', (client, req) => {
    console.info("Total connected clients:", wss.clients.size);
    sendMessageToInterface({
        "total_connected": wss.clients.size
    });
    setAttributeToClient("isAlive", true, client);

    client.on('message', message => {
        if (isValidJSONString(message)) {
            let req = JSON.parse(message);
            switch (req.action) {
                case "login":
                    login(client, req);
                    break;
                case "prepare":
                    if (checkIfBotsExist(req.for)) {
                        if (ready(req.for)) {
                            createGame(req);
                            sendActionToBot(req);
                            setAttributeToClient("preparing", false, client);
                            sendMessageToInterface({
                                "games": games
                            })
                        } else {
                            sendMessageToClient(client, {
                                "error": "NOT_READY"
                            })
                        }
                    } else {
                        sendMessageToClient(client, {
                            "error": "BOT_DOES_NOT_EXIST"
                        })
                    }
                    break;
                case "start":
                case "ended":

                    if (preparingDone()) {
                        updateGameStatus(req);
                        sendActionToBot(req);
                    } else {
                        sendMessageToClient(client, {
                            "error": "NOT_READY"
                        })
                    }
                   
                    break;
                case "delete_games": 
                    games = [];
                    break
            }
            sendMessageToInterface({"req": req, "clientId": client.id});
            switch (req.status) {
                case true:
                    setAttributeToClient("preparing", true, client);
                    break;
                case "preparing_game":
                case "ready":
                case "in_game":
                case "finished":
                    if (client.status !== req.status) {
                        updateBotStatusInGame(client.id, req.status);
                        sendMessageToInterface({
                            "games": games
                        })
                    }
                    case "preparing":
                        setBotStats(client.id, req);
                        setAttributeToClient("status", req.status, client)
                        wss.clients.forEach((interface) => {
                            if (interface.role == "interface") {
                                let body = {

                                }
                                sendMessageToClient(interface, Object.assign(body, botStats));
                            }
                        })
                        break;
            }


            if (req.error) {
                sendMessageToInterface({
                    "status": true,
                    "games": games
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

/**
 * Set bot stats in a arry
 * @param {String} clientId client id
 * @param {Object} stats 
 */
function setBotStats(clientId, stats){
    botStats[`${clientId}`] = stats;
}

/**
 * Set a custom attribute to a client
 * @param {String} name 
 * @param {*} value 
 * @param {WSS Client} target 
 */
const setAttributeToClient = (name, value, targets = "all") => {
    if (targets == "all") {
        wss.clients.forEach((client) => {
            if (client.role == "bot") {
                client[name] = value;
            }
        })
    } else if (Array.isArray(targets)) {
        targets.forEach((target) => {
            wss.clients.forEach((client) => {
                if (client.id == target) {
                    client[name] = value;
                }
            })
        })
    } else {
        targets[name] = value;
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
}, 10000)

/**
 * Updates status of a game
 * @param {Object} body 
 */
function updateGameStatus(body) {
    for(let game of games){
        if(game.id == body.game){
            game.action = body.action;
        }
    }
}

/**
 * updates bot status in games[]
 * @param {String} client Client id
 * @param {String} status 
 */
function updateBotStatusInGame(client, status) {
    games.forEach((game) => {
        game.bots.forEach((bot) => {
            if(bot.id == client){
                bot.stats = status
            }
        })
    })
}

/**
 * check if bots are done with preparing
 * @param {String} targets bot ids
 * @returns true || false
 */
function preparingDone(targets = "all") {
    let ready = false
    if (targets == "all") {
        wss.clients.forEach((client) => {
            if (client.role == "bot") {
                if (client.preparing) {
                    ready = true
                } else {
                    ready = false;
                }
            }
        });
    } else {
        for (let i of targets) {
            wss.clients.forEach((client) => {
                if (client.id == i) {
                    if (client.preparing) {
                        ready = true;
                    } else {
                        ready = false;
                    }
                }
            })
        }
    }

    return ready;
}

/**
 * Send JSON String to a bot
 * @param {Object} message 
 */
function sendActionToBot(message) {
    let body = {
        "action": message.action,
        "game": message.game
    }

    if (message.for == "all") {
        sendMessageToAllBots(body);
    } else {
        message.for.forEach((botId) => {
            wss.clients.forEach((client) => {
                if (client.id == botId) {
                    sendMessageToClient(client, body)
                }
            })
        })
    }
}

/**
 * Log client in and give them role and id
 * @param {WSS Client} client 
 * @param {Object} req 
 */
function login(client, req) {
    if (req.key == 111) {
        setAttributeToClient("role", "admin", client);
        client.send(JSON.stringify({
            "games": games
        }));
    } else if (req.key == 115) {
        setAttributeToClient("role", "interface", client);

    } else {
        setAttributeToClient("role", "bot", client);
        sendMessageToClient(client, {
            "loggedin": true
        });

    }
    setAttributeToClient("id", req.id, client);
}

/**
 * Send JSON String to all bots that are connected
 * @param {Object} message 
 */
function sendMessageToAllBots(message) {
    wss.clients.forEach((client) => {
        if (client.role == "bot") {
            client.send(JSON.stringify(message));
        }
    })
}

/**
 * Send JSON String to admin/admins
 * @param {Object} message 
 * @param {WSS client} target default = all admins 
 */
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
 * Checks if bots are ready to play a game
 * @param {String || Array} target botId
 * @returns true || false
 */
function ready(target) {
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
    } else {
        for (let i of target) {
            wss.clients.forEach((client) => {
                if (client.role == "bot") {
                    if (client.id == i) {
                        if (client.status == "ready") {
                            ready = true;
                        } else {
                            ready = false;
                        }
                    }
                }
            })
        }
    }

    return ready;
}

/**
 * check if bots exist and loggedin
 * @param {String} bots botId
 * @returns true || false
 */
function checkIfBotsExist(bots) {
    if (bots != "all") {
        let clients = [];
        wss.clients.forEach((client) => {
            if (client.role == "bot") {
                clients.push(client.id);
            }
        })

        let exist = false;

        bots.forEach((bot) => {
            if (clients.includes(bot)) {
                exist = true;
            } else {
                exist = false
            }
        })

        return exist;
    } else {
        return true;
    }
}

/**
 * Creates game and push to Arry
 * @param {Object} req 
 */
function createGame(req) {
    let game = {
        "id": uuidv4(),
        "game": req.game,
        "action": req.action,
        "status": false,
        "bots": []
    }
    let bots = [];


    wss.clients.forEach((client) => {
        if (client.role == "bot") {
            if (req.for == "all") {
                bots.push({
                    "botId": client.id,
                    "status": client.status
                })
            } else {
                if (req.for.includes(client.id)) {
                    bots.push({
                        "botId": client.id,
                        "status": client.status
                    })
                }
            }
        }
    })

    game.bots = bots

    games.push(game);
}

/**
 * Send JSON String to client 
 * @param {WSS client} client 
 * @param {Object} message  
 */
function sendMessageToClient(client, message) {
    client.send(JSON.stringify(message));
}

/**
 * Check is String is a valid json string
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
