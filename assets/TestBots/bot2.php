<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>bot 2</h1>
<script> 
const ws = new WebSocket("ws://localhost:3003/websocket/robot");
let clientBody = {
    "status": "ready",
    "isDriving": true,
    "acceleration": 22 
}
ws.addEventListener("open", () => {

    ws.send(JSON.stringify({ 
        "action": "login",
        "id": "F0:08:D1:D1:72:A0"
    }))


    const interval = setInterval(() => {

        ws.send(JSON.stringify(clientBody))

    }, 5000);

    ws.addEventListener("message", ({data}) => {
        console.log(data);
        let body = JSON.parse(data);
        if(body.status == "prepare"){
            clientBody.status = "preparing_game";
            ws.send(JSON.stringify({"status": true, "game": body.game}))
        }else if(body.status == "start"){
            ws.send(JSON.stringify({"status": true, "game": body.game}))
            clientBody.status = "in_game";
        }else if(body.status == "stop"){
            // ws.send(JSON.stringify({"status": true, "game": body.game}))

        }
    });



});


</script>

</body>
</html>