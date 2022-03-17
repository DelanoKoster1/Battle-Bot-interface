const router = require("express").Router();
const WebSocket = require("ws");

const wss = new WebSocket.Server({
    port: 3002
});

wss.on('connection', ws => {

    console.info("Total connected clients:", wss.clients.size);

    wss.clients.forEach((client) => {

        client.send(JSON.stringify({
            "amountOfWatchers": wss.clients.size
        }));
    })

    ws.on('message', data => {

        wss.clients.forEach((client) => {
            if (client !== ws && client.readyState === WebSocket.OPEN) {
                client.send(data.toString());
            }
        });
    })

    ws.on('close', () => {
        console.info("Total connected clients:", wss.clients.size);

        wss.clients.forEach((client) => {

            client.send(JSON.stringify({
                "amountOfWatchers": wss.clients.size
            }));
        })
    })

})


module.exports = router;