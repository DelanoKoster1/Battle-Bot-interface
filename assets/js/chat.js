const ws = new WebSocket("ws://localhost:3002/websocket/chat")
let chatInput = document.getElementById('chatMessage');
ws.addEventListener("open", () => {
    
    let body = { 
        "username": "JohnDoe",
        "msg": "",
        "time": ""
    }

    chatInput.addEventListener("keyup", (e) => {
        e.preventDefault();
        if (e.keyCode === 13) {
            let date = new Date();
            body.msg = chatInput.value;
            body.time = date.getTime();

            ws.send(JSON.stringify(body));
        }

    })

    ws.addEventListener("message", ({ data }) => {
        console.log(data);
    })
  
})