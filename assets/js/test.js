const ws = new WebSocket(`ws://localhost:3003/websocket/robot`);


ws.addEventListener("open", () => {

    ws.send(JSON.stringify({
        "action": "login",
        "key": "115",
        "id": "interface"
    }));

    ws.addEventListener('message', (message) => {
        let data = JSON.parse(message.data); 
        console.log(data);

    })

})