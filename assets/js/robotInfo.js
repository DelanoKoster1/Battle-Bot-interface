const ws = new WebSocket(`ws://localhost:3003/websocket/robot`);


ws.addEventListener("open", () => {

    ws.send(JSON.stringify({
        "action": "login",
        "key": "115",
        "id": "interface"
    }));

    ws.addEventListener('message', (message) => {
        let data = JSON.parse(message.data); 
        console.log(data);
        createLiveCard(data)
    })

})
function clearLiveCard(div){
        div.innerHTML= "";
}

function createLiveCard(bot){
    // for (let index = 0; index < bot.length; index++) {      
        let statusDivs = document.querySelectorAll('.liveStatus');
        
        statusDivs.forEach(botAdres => {
            let dataAttribute = botAdres.getAttribute('macAdres')
            if (bot.botId == dataAttribute) {
              curruntDiv = botAdres  
            }
        })
        
        let driveDiv = document.createElement('div');
        driveDiv.setAttribute('class', 'card d-inline-block')

        let driveBody = document.createElement('div')
        driveBody.setAttribute('class', "card-body")

        let driveTitle = document.createElement('div');
        driveTitle.setAttribute('class', 'card-title');

        let driveHeader = document.createElement('h5')
        if (bot.req.isDriving) {
            driveHeader.setAttribute('class', "card-header bg-success text-white")
            driveTitle.innerHTML= "Vroemmm";
        }else{
            driveHeader.setAttribute('class', "card-header")
            driveTitle.innerHTML= "Stil";
        }
        driveHeader.innerText = "Rijdend"
        

        let accelerationDiv = document.createElement('div');
        accelerationDiv.setAttribute('class', 'card d-inline-block')
        
        let accelerationHeader = document.createElement('h5')
        
        accelerationHeader.innerText = "Acceleratatie"

        let accelerationBody = document.createElement('div')
        accelerationBody.setAttribute('class', "card-body")

        let accelerationTitle = document.createElement('div');
        accelerationTitle.setAttribute('class', 'card-title');
        

        if (bot.req.acceleration > 0) {
            accelerationHeader.setAttribute('class', "card-header bg-success text-white")
        }else{
            accelerationHeader.setAttribute('class', "card-header")
        }
        accelerationTitle.innerText= bot.req.acceleration
        
        

        



        
        driveDiv.appendChild(driveHeader)
        driveBody.appendChild(driveTitle);
        driveDiv.appendChild(driveBody)
        
        accelerationDiv.appendChild(accelerationHeader)
        accelerationBody.appendChild(accelerationTitle);
        accelerationDiv.appendChild(accelerationBody)

        curruntDiv.appendChild(driveDiv);
        curruntDiv.appendChild(accelerationDiv);
    // }
}