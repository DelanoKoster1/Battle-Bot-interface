const ws = new WebSocket("ws://localhost:3002/websocket/chat");
let chatInput = document.getElementById('chatMessage');

ws.addEventListener("open", () => {
    
    let body = { 
        "username": "JohnDoe",
        "msg": ""
    }

    chatInput.addEventListener("keyup", (e) => {
        e.preventDefault();
        if (e.keyCode === 13) {
            let date = new Date();
            body.msg = chatInput.value;
            chatInput.value = "";
            showMessage(body);
            ws.send(JSON.stringify(body));
        }

    })

    ws.addEventListener("message", ({ data }) => {
        let res = JSON.parse(data);

        if(res.msg){
            showMessage(res);
        }
    })
  
})


function showMessage(data){
    let chatLine = document.querySelector('.chatmessage-container');

    let div = document.createElement('div');
    let spanUsername = document.createElement('span');
    let spanMessage = document.createElement('span');

    div.setAttribute('class', 'chatLine my-2');
    spanUsername.setAttribute('class', 'fw-bold');
    spanMessage.setAttribute('class', 'message');

    spanUsername.innerHTML=data.username + ": ";
    spanMessage.innerHTML=data.msg;
    
    chatLine.appendChild(div);
    div.appendChild(spanUsername);
    div.appendChild(spanMessage);
}