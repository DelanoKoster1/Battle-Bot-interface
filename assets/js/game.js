const ws = new WebSocket(`ws://${getDomainName()}:3003/websocket/robot`);

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
            createGameCard(data.games)
        }
    })

});


function createGameCard(game){
    var gameDiv;
    if(!document.getElementById(`${game.game}`)){
        gameDiv = document.createElement('div');
    }else { 
        gameDiv = document.getElementById(`${game.game}`)
    }

    let h4 = document.createElement('h4');
    h4.innerHTML = game.game;

    let p = document.createElement('p');
    p.innerHTML = game.action;

    let button = document.createElement('button');
    button.setAttribute('class', 'btn btn-primary');
    button.innerHTML = game.action;

    gameDiv.appendChild(h4);
    gameDiv.appendChild(p);
    gameDiv.appendChild(button);
    gamesDiv.appendChild(gameDiv);
}

function sendAction(message){
    ws.send(JSON.stringify(message));
}
