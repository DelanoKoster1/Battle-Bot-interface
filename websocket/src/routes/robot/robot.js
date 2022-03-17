const router = require("express").Router();
const WebSocket = require("ws");

const wss = new WebSocket.Server({
    port: 3003
});

wss.on('connection', ws => {

    console.info("Total connected:", wss.clients.size); 

    console.info(wss.clients.info);
    ws.on('message', data => {

        wss.clients.forEach((client) => {
            if (client !== ws && client.readyState === WebSocket.OPEN) {

                client.send(data.toString());
            
            }
        });
    })



    ws.on('close', () => {
        console.info("Total connected:", wss.clients.size);

    })

})


module.exports = router;
