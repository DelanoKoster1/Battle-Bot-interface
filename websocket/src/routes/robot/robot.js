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
        if(isValidJSONString(clientReq)){
            let request = JSON.parse(clientReq);

            switch(request.action){
                case "login":
                    login(request, req.headers['sec-websocket-key'], client)
                    break;
                case "start": 
                    break;
                default:
            }

           


        }else{
            client.send(JSON.stringify({
                "error": "INVALID_JSON"
            }))
        }
    })

    client.on('pong', () => {
        console.log('pong on: ' + req.headers['sec-websocket-key']);
        bots.setConnAttempt(req.headers['sec-websocket-key'], 2);
    });


   



    setInterval(() => {
        let botsList = bots.getAllBots();
        Object.keys(botsList).forEach(wsKey => {
            if(botsList[wsKey].connAttempt != 0){ 
                botsList[wsKey].client.ping();
                console.log("ping on: " + wsKey);
                bots.setConnAttempt(wsKey, botsList[wsKey].connAttempt -1);
            }else{
                botsList[wsKey].client.terminate();
                bots.removeBot(wsKey);
            }
        })
    }, 1000 * 5)
    

 
})





async function login(req, wsKey, client){
    if(req.role == "admin"){
        admins[req.id] = client;
        console.log(bots.getAllBots());
    }else{
        
        if(bots.saveBot(req.id, wsKey, client)){
            // console.log(bots.getAllBots());
            console.log('login ok');
            sendMsgToClient(client, {"loggedin": true})
        }else{
            sendMsgToClient(client, {"loggedin": false})
        }   
    }
}

function startSingle(bot, game){
    if(bot != undefined){
        bot.send(JSON.stringify({
            "start": game
        }))
    } else{
        // send msg to admins
    }
}

function startAll(bots, game){
    if(bots != undefined){
        for (let id in bots) {
            bots[id].send(JSON.stringify({ 
                "start": game
            }))
        }
    } else{
        // send msg to admins
    }
}

function sendMsgToClient(client, msg){
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



// let admin = {};
// client.on('message', data => {
//     let req = JSON.parse(data.toString());
//     console.log(req);
//     switch (req.action) {
//         case "login":
//             if(req.role == "admin"){
//                 admin[req.id] = client;
//             }else{
//                 bots.saveBot(req.id, client);
//             }
//             break;
//         case "start_game":
//             if(req.for == "single"){
//                 startSingle(bots.getBot(req.id), req.game);
//             }else{
//                 startAll(bots.getAllBots(), req.game);
//             }
//             break;
//         default:
//             break;
//     }
// })