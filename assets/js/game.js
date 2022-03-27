const ws = new WebSocket(`ws://${getDomainName()}:3003/websocket/src/websocket/robot`);

// document.querySelectorAll('.game-card-all').forEach(item => {
//     item.addEventListener('click', ev => {
//         let itemId = item.id;
//         // startButton.setAttribute('id', itemId);
//     })
// })

ws.addEventListener("open", () => {

    ws.send(JSON.stringify({
        "action": "login",
        "key": "111",
        "id": "admin1"
    }));

    document.querySelectorAll('.action-button').forEach(item => {
        item.addEventListener('click', ev => {
            let itemIds = item.id.split('-');
            let action = itemIds[1];
            let game = itemIds[0];

            let body = {
                "for": "all",
                "action": action,
                "game": game
            }

            // setStatus(item);
            setButton(item, true)
            ws.send(JSON.stringify(body));


            ws.addEventListener("message", res => {
                let response = JSON.parse(res.data);
                console.log(response);
                if (response.status) {
                    setButton(item);
                }

            })
        })



    })

    function setButton(button, disabled = false) {
        let itemIds = button.id.split('-');
        let game = itemIds[0];
        let action = itemIds[1];
        if (!disabled) {
            console.log(action);

            if(action == "prepare"){
                action = "start";
            }else if(action == "start"){
                action = "stop";
            }else if(action == "stop"){
                action = "prepare";
            }

            // switch (action) {
            //     case "prepare":
            //         action = "start";
            //         break;
            //     case "start":
            //         action = "stop";
            //         break;
            //     case "stop":
            //         action = "prepare";
            //         break;
            // }
            console.log(action);
        }
        if (disabled) {
            button.setAttribute('class', 'btn btn-secondary disabled');
        } else {
            button.setAttribute('class', 'btn btn-primary action-button');
        }
        // action log
        button.setAttribute('id', `${game}-${action}`);
        button.innerHTML = action;

    }



    // startButton.addEventListener('click', (ev) => {
    //     let selectedGame = startButton.id;

    //     if (selectedGame == "") {
    //         console.log('Geen game geselecteerd');
    //     }else{
    //         let body = {
    //             "for": "all",
    //             "action": "prepare",
    //             "game": selectedGame
    //         }

    //         ws.send(JSON.stringify(body));
    //     }

    // })


    // document.querySelectorAll('.game-card-single').forEach(item => {
    //     item.addEventListener('click', ev => {
    //         let itemId = item.id.split('-');
    //         let game = itemId[0];
    //         let botId = itemId[1];

    //         let body = {
    //             "action": "start_game",
    //             "for": "single",
    //             "game": game,
    //             "id": botId
    //         }

    //         ws.send(JSON.stringify(body));

    //     })
    // })


})


// function setStatus(button) {
//     let button = document.querySelector(`#${id}`);

//     button.setAttribute('class', 'btn btn-secondary disabled');
//     button.innerHTML = "Preparing.";
// }