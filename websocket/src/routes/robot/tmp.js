const router = require("express").Router();
const Bots = require('../../classes/bots.js')
const WebSocket = require("ws");

const wss = new WebSocket.Server({
    port: 3003
});


const heartbeat = (client) => {
    client.isAlive = true;
    // console.log("pong: " + client.id);
}

const setAttributeToClient = (name, value, target = "all") => {

    if(target == "all"){
        wss.clients.forEach((client) => {
            if(client.role == "bot"){
                client[name] = value;
            }
        })
    }else{
        target[name] = value
    }
}


wss.on('connection', (client, req) => {
    console.info("Total connected clients:", wss.clients.size);

    // client.isAlive = true;

    setAttributeToClient("isAlive", true, client);

    client.on('message', message => {

        if (isValidJSONString(message)) {
            let body = JSON.parse(message);

            switch (body.action) {
                case "login":
                    if (body.key == "111") {
                        setAttributeToClient("role", "admin", client);
                    } else {
                        setAttributeToClient("role", "bot", client);
                    }
                    client.id = body.id;
                    break;
                case "prepare":
                case "start":
                case "ended":
                    if (body.for == "all" && botsReady()) {
                    console.log(body);

                        setAttributeToClient("game", body.game);

                        sendMessageToAllBots({
                            "action": body.action,
                            "game": body.game
                        })

                        sendMessageToInterface({
                            "status": true,
                            "action": body.action,
                            "game": body.game,
                            "for": "all"
                        })
                    } else{
                        sendMessageToInterface({
                            "status": false,
                            "msg": "NOT_READY"
                        }, client)
                    }
                    break;
                    default: 
                    sendMessageToInterface({
                        "error": "UNVALID_ACTION"
                    }, client)

            }

            if (body.status) {
                setAttributeToClient("status", body.status, client);
                
                
                console.log(body, client.id);
                wss.clients.forEach(function each(client) {
                    if(client.role == "bot"){
                        console.log('Client.status: ' + client.game);
                    }
                });
            }

            if(body.error){
                
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

const interval = setInterval(() => {
    wss.clients.forEach((client) => {
        if (client.isAlive === false) {
            return client.terminate()
        }

        client.isAlive = false
        client.ping()
    })
}, 5000)


function sendMessageToAllBots(message){

}

function sendMessageToInterface(message, target = "all"){
    if(target == "all"){
        wss.clients.forEach((client) => {
            if(client.role == "admin"){
                client.send(JSON.stringify(message));
            }
        })
    } else{
        target.send(JSON.stringify(message));
    }
}

 
function botsReady() {
    let ready = false
    wss.clients.forEach((client) => {
        if (client.role == "bot") {
            if (client.status == "ready") {
                ready = true
            } else {
                ready = false;
            }
        }
    });

    return ready;
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