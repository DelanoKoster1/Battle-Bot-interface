const ws = new WebSocket(`ws://${getDomainName()}:3003/websocket/src/websocket/robot`);
let startButton = document.querySelector('.start-button-all');

document.querySelectorAll('.game-card-all').forEach(item => {
    item.addEventListener('click', ev => {
        let itemId = item.id;
        startButton.setAttribute('id', itemId);
    })
})

ws.addEventListener("open", () => {

    ws.send(JSON.stringify({
        "action": "login",
        "key": "111",
        "id": "admin1"
    }));

    startButton.addEventListener('click', (ev) => {
        let selectedGame = startButton.id;

        if (selectedGame == "") {
            console.log('Geen game geselecteerd');
        }else{
            let body = {
                "for": "all",
                "action": "prepare",
                "game": selectedGame
            }
        
            ws.send(JSON.stringify(body));
        }

    })


    document.querySelectorAll('.game-card-single').forEach(item => {
        item.addEventListener('click', ev => {
            let itemId = item.id.split('-');
            let game = itemId[0];
            let botId = itemId[1];

            let body = {
                "action": "start_game",
                "for": "single",
                "game": game,
                "id": botId
            }

            ws.send(JSON.stringify(body));

        })
    })


})