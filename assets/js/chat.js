const ws = new WebSocket(`ws://${getDomainName()}:33002/websocket/client/chat`);
let chatInput = document.getElementById('chatMessage');
let chatButton = document.getElementById('button-addon2');
let username = document.getElementById('username').value;
ws.addEventListener("open", () => {

    chatInput.addEventListener("keyup", (e) => {
        e.preventDefault();
        if (e.key === "Enter") {
            sendMsgToWS();
        }

    })

    chatButton.addEventListener("click", (e) => {
        e.preventDefault();
        sendMsgToWS();
    })

    ws.addEventListener("message", ({
        data
    }) => {
        let res = JSON.parse(data);

        if (res.msg) {
            showMessage(res);
        } 
    })

})

function sendMsgToWS() {
    if (chatInput.value.trim() != "") {
        let body = {
            "username": username,
            "msg": ""
        }

        body.msg = chatInput.value;
        chatInput.value = "";
        showMessage(body);
        ws.send(JSON.stringify(body));
    }
}

function showMessage(data) {
    let chatLine = document.querySelector('.chatmessage-container');

    let div = document.createElement('div');
    let spanUsername = document.createElement('span');
    let spanMessage = document.createElement('span');

    div.setAttribute('class', 'chatLine my-2');
    spanUsername.setAttribute('class', 'fw-bold');
    spanMessage.setAttribute('class', 'message');

    spanUsername.innerHTML = data.username + ": ";
    spanMessage.innerHTML = data.msg;

    chatLine.appendChild(div);
    div.appendChild(spanUsername);
    div.appendChild(spanMessage);
}