const ws = new WebSocket(`ws://${getDomainName()}:33003/websocket/robot`);

let selectBot = document.querySelector('#selectBot');
let selectBotBtn = document.querySelector('#selectBotBtn');
let deleteGamesBtn = document.querySelector('#deleteGames');
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

deleteGamesBtn.addEventListener('click', (ev) => {
    sendAction({
        "action": "delete_games"
    });
    clearGameCard();
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

        let pAction = document.createElement('p');
        pAction.innerHTML = "Actie: " + game[index].action;

        let p = document.createElement('p');
        p.innerHTML = "Status: " + game[index].status;
        
        let buttonStart = document.createElement('button');
        buttonStart.setAttribute('class', 'btn btn-primary mx-2 float-end');
        buttonStart.setAttribute('id', game[index].id);
        buttonStart.setAttribute('value', "start");
        buttonStart.innerHTML = "Start";

        let buttonEnd = document.createElement('button');
        buttonEnd.setAttribute('class', 'btn btn-primary mx-2 float-end');
        buttonEnd.setAttribute('id', game[index].id);
        buttonEnd.setAttribute('value', "ended");
        buttonEnd.innerHTML = "End";

        // send game action to bots to start game
        buttonStart.addEventListener("click", (e) => {
            
            for (let index = 0; index < game.length; index++) {
                if (game[index].id == e.target.id) {                   
                    action = e.target.value
                    curruntGame = game[index].game
                    robots = game[index].bots
                    robotadres = [];
                    robots.forEach(robot => {
                        robotadres.push(robot.botId);
                    });

                    sendAction({
                        "action": action,
                        "game": curruntGame,
                        "gameId": e.target.id,
                        "for" : robotadres
                    })
                }
                
            }
        })

         // send game action to bots to end
        buttonEnd.addEventListener("click", (e) => {
            for (let index = 0; index < game.length; index++) {
                if (game[index].id == e.target.id) {
                    action = e.target.value
                    curruntGame = game[index].game
                    robots = game[index].bots
                    robotadres = [];
                    robots.forEach(robot => {
                        robotadres.push(robot.botId);
                    });

                    sendAction({
                        "action": action,
                        "game": curruntGame,
                        "gameId": e.target.id,
                        "for" : robotadres
                    })

                    sendAction({
                        "action": "delete_games"
                    })
                    
                }
                
            }
        })
        
        let p2 = document.createElement('p');
        p2.innerHTML = "Bots: ";

        gameBody.appendChild(h4);
        gameBody.appendChild(pAction);
        gameBody.appendChild(p);
        gameBody.appendChild(p2);
        game[index].bots.forEach(bot => {
            let p = document.createElement('p');
            p.innerHTML =  botAdresToName(bot.botId) + ": " + bot.status;
            gameBody.appendChild(p);
        });

        gameBody.appendChild(buttonEnd);
        gameBody.appendChild(buttonStart);
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