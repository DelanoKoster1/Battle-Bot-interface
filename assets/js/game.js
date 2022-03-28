const ws = new WebSocket(`ws://${getDomainName()}:33003/websocket/robot`);

let selectBot = document.querySelector('#selectBot');
let selectGame = document.querySelector('#selectGame');

let selectBotDiv = document.querySelector('#bot');
let selectGameDiv = document.querySelector('#game');

let gamesDiv = document.querySelector('.games');

let selectedBot;
let selectedGame;

selectBot.addEventListener('change', (ev) => {
    selectedBot = selectBot.value;
    selectBotDiv.setAttribute('class', 'd-none');
    selectBot.value = "";
    selectGameDiv.setAttribute('class', '');
})

selectGame.addEventListener('change', (ev) => {
    selectedGame = selectGame.value;
    selectGameDiv.setAttribute('class', 'd-none');
    selectGame.value = "";
    selectBotDiv.setAttribute('class', '');
    sendAction({
        "action": "prepare",
        "game": selectedGame,
        "for": selectedBot
    })
})

ws.addEventListener("open", () => {

    ws.send(JSON.stringify({
        "action": "login",
        "key": "111",
        "id": "admin1"
    }));

    ws.addEventListener('message', (message) => {
        let data = JSON.parse(message.data); 
        console.log(data);
        
        if(data.games){
            createGameCard(game)
        }
    })

});


function createGameCard(game){

}

function sendAction(message){
    ws.send(JSON.stringify(message));
}
