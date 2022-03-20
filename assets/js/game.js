const ws = new WebSocket("ws://localhost:3003/websocket/src/websocket/robot");
let startButton = document.querySelector('.start-button');

document.querySelectorAll('.game-card').forEach(item => {
    item.addEventListener('click', ev => {
        let itemId = item.id;
        startButton.setAttribute('id', itemId);
    })
})

ws.addEventListener("open", () => {

    ws.send(JSON.stringify({
        "action": "login",
        "role": "admin",
        "id": "3"
    }));

    startButton.addEventListener('click', (ev) => {
        let selectedGame = startButton.id;

        if (selectedGame == "") {
            console.log('Geen game geselecteerd');
        }

        startGame(selectedGame);

    })


})


function startGame(game) {

    let body = {
        "for": "all",
        "action": "start_game",
        "game": game
    }

    ws.send(JSON.stringify(body));
}