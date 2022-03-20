const router = require("express").Router();
const Bots = require('../../../classes/bots.js')
const WebSocket = require("ws");

const bots = new Bots();
const wss = new WebSocket.Server({
    port: 3003
});

wss.on('connection', (client) => {
    let admin = {};
    client.on('message', data => {
        let req = JSON.parse(data.toString());
        console.log(req);
        switch (req.action) {
            case "login":
                if(req.role == "admin"){
                    admin[req.id] = client;
                }else{
                    bots.saveBot(req.id, client);
                }
                break;
            case "start_game":
                if(req.for == "single"){
                    startSingle(bots.getBot(req.id), req.game);
                }else{
                    startAll(bots.getAllBots(), req.game);
                }
                break;
            default:
                break;
        }
    })


})


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


module.exports = router;