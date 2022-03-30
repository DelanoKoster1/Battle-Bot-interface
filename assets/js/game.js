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
        console.log(data);
        if(data.games && data.games.length != 0){
            clearGameCard();
            createGameCard(data.games);
        }
    })

});


function createGameCard(game){
    for (let index = 0; index < game.length; index++) {      
    
        var gameDiv;
        if(!document.getElementById(`${game[index].game}`)){
            gameDiv = document.createElement('div');
            gameDiv.setAttribute('class','card mb-3');
        }else { 
            gameDiv = document.getElementById(`${game[index].game}`)
        }
        
        let gameBody = document.createElement('div');
        gameBody.setAttribute('class','card-body')

        let h4 = document.createElement('h4');
        h4.innerHTML = game[index].game;

        let p = document.createElement('p');
        p.innerHTML = "Status: " + game[index].status;

        let button = document.createElement('button');
        button.setAttribute('class', 'btn btn-primary float-end');
        
        if (game.action == "preparing_game") {
            button.setAttribute('id', 'preparing_game');
        }else {
            button.setAttribute('id', 'start');
        }

        button.innerHTML = game[index].action;
        let p2 = document.createElement('p');
        p2.innerHTML = "Bots: ";

        gameBody.appendChild(h4);
        gameBody.appendChild(p);
        gameBody.appendChild(p2);
        game[index].bots.forEach(bot => {
            let p = document.createElement('p');
            p.innerHTML =  botAdresToName(bot.botId) + ": " + bot.status;
            gameBody.appendChild(p);
        });

        gameBody.appendChild(button);
        gameDiv.appendChild(gameBody);
        gamesDiv.appendChild(gameDiv);
    }
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
