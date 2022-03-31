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



//  prepareMaze.addEventListener('click', () =>{
//     ws.send(JSON.stringify({
//         "for": ["FC:F5:C4:2F:45:5C"],
//         "action": "prepare",
//         "game": "maze"
//     }))
// })


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
            
            // send game action to bots
            document.addEventListener('click',function(e){
                action = e.target.value
                for (let index = 0; index < data.games.length; index++) {
                    if (data.games[index].id == e.target.id) {
                        action = e.target.value;
                        game = data.games[index].game;
                        
                        robots = data.games[index].bots
                        robotadres = [];
                        robots.forEach(robot => {
                            robotadres.push(robot.botId);
                        });

                        sendAction({
                            "action": action,
                            "game": selectGame,
                            "gameId": e.target.id,
                            "for" : robotadres
                        })
                    }
                    
                }
             });
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

        let buttonPrepare = document.createElement('button');
        buttonPrepare.setAttribute('class', 'btn btn-primary mx-2 float-end');
        buttonPrepare.setAttribute('id', game[index].id);
        buttonPrepare.setAttribute('value', "prepare");
        buttonPrepare.innerHTML = "Prepare";
        
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

        gameBody.appendChild(buttonEnd);
        gameBody.appendChild(buttonStart);
        gameBody.appendChild(buttonPrepare);
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