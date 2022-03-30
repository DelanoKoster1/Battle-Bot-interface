const ws = new WebSocket(`ws://${getDomainName()}:3003/websocket/robot`);

let selectBot = document.querySelector('#selectBot');
let selectBotBtn = document.querySelector('#selectBotBtn');
let selectGame = document.querySelector('#selectGame');

let selectBotDiv = document.querySelector('#bot');
let selectGameDiv = document.querySelector('#game');

let gamesDiv = document.querySelector('.games');

let selectedBot;
let selectedGame;

selectBotBtn.addEventListener('click', (ev) => {
    console.log(getSelectValues(selectBot));
    selectBotDiv.setAttribute('class', 'd-none');
    selectGameDiv.setAttribute('class', '');
    selectGame.value = "";
})



selectGame.addEventListener('change', (ev) => {
    selectedGame = selectGame.value;
    selectGameDiv.setAttribute('class', 'd-none');
    selectBotDiv.setAttribute('class', '');
    result = getSelectValues(selectBot);
    sendAction({
        "action": "prepare",
        "game": selectedGame,
        "for": result
    })
    // result.forEach(result => {
        
    // });
})

document.addEventListener('click',function(e){
    if(e.target && e.target.id == 'preparing_game'){
        let btn = document.getElementById('preparing_game');
        btn.setAttribute("disabled", true)
     }
 });

ws.addEventListener("open", () => {

    ws.send(JSON.stringify({
        "action": "login",
        "key": "111",
        "id": "admin1"
    }));

    ws.addEventListener('message', (message) => {
        let data = JSON.parse(message.data); 
        
        if(data.games && data.games.length != 0){
            console.log(data.games);
            clearGameCard();
            createGameCard(data.games);
        }
    })

});


function createGameCard(game){
    var gameDiv;
    if(!document.getElementById(`${game.game}`)){
        gameDiv = document.createElement('div');
        gameDiv.setAttribute('class','card mb-3');
    }else { 
        gameDiv = document.getElementById(`${game.game}`)
    }
    
    let gameBody = document.createElement('div');
    gameBody.setAttribute('class','card-body')

    let h4 = document.createElement('h4');
    h4.innerHTML = game.game;

    let p = document.createElement('p');
    p.innerHTML = "Status: " + game.action;

    let button = document.createElement('button');
    button.setAttribute('class', 'btn btn-primary float-end');
    
    if (game.action == "preparing_game") {
        button.setAttribute('id', 'preparing_game');
    }else {
        button.setAttribute('id', 'start');
    }

    button.innerHTML = game.action;
    let p2 = document.createElement('p');
    p2.innerHTML = "Bots: ";

    gameBody.appendChild(h4);
    gameBody.appendChild(p);
    gameBody.appendChild(p2);
    console.log(bots);
    game.bots.forEach(bot => {
        let p = document.createElement('p');
        p.innerHTML =  botAdresToName(bot.botId) + ": " + bot.status;
        gameBody.appendChild(p);
    });

    gameBody.appendChild(button);
    gameDiv.appendChild(gameBody);
    gamesDiv.appendChild(gameDiv);
}

function clearGameCard() {
 document.getElementById('gameContainer').innerHTML = "";
}

function sendAction(message){
    ws.send(JSON.stringify(message));
}

function getSelectValues(select) {
    var result = [];
    var options = select && select.options;
    var opt;
  
    for (let i=0, iLen=options.length; i<iLen; i++) {
      opt = options[i];
  
      if (opt.selected) {
        result.push(opt.value);
      }
    }
    return result;
}

function botAdresToName(adres) {
    let selectBot = document.querySelector('#selectBot');

    for (i = 0; i < selectBot.length; i++) { 
        if (selectBot.options[i].value == adres) {
            return selectBot.options[i].text
        }
    }
}