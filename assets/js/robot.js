const ws = new WebSocket("ws://localhost:3003/websocket/robot");

ws.onopen = function(e) {
    console.log("Connection established");
    
};

ws.addEventListener("open", (req) => {

})


