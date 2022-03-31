const ws = new WebSocket(`ws://localhost:3003/websocket/robot`);
let statusDivs = document.querySelector('#liveStatus');

ws.addEventListener("open", () => {

    ws.send(JSON.stringify({
        "action": "login",
        "key": "115",
        "id": "interface"
    }));

    ws.addEventListener('message', (message) => {
        let data = JSON.parse(message.data); 
        console.log(data);
        clearLiveCard();
        createLiveCard(data)
    })

})
function clearLiveCard(){
    statusDivs.innerHTML = "";
}

function createLiveCard(bot){
    // for (let index = 0; index < bot.length; index++) {      
       
        let driveDiv = document.createElement('div');
        driveDiv.setAttribute('class', 'card d-inline-block')

        let driveHeader = document.createElement('h5')
        driveHeader.setAttribute('class', "card-header bg-success text-white")
        driveHeader.innerText = "Rijdend"

        let driveBody = document.createElement('div')
        driveBody.setAttribute('class', "card-body")

        let driveTitle = document.createElement('div');
        driveTitle.setAttribute('class', 'card-title');
        driveTitle.innerHTML= "Vroemmm";

        let accelerationDiv = document.createElement('div');
        accelerationDiv.setAttribute('class', 'card d-inline-block')
        
        let accelerationHeader = document.createElement('h5')
        accelerationHeader.setAttribute('class', "card-header bg-success text-white")
        accelerationHeader.innerText = "Acceleratatie"

        let accelerationBody = document.createElement('div')
        accelerationBody.setAttribute('class', "card-body")

        let accelerationTitle = document.createElement('div');
        accelerationTitle.setAttribute('class', 'card-title');
        accelerationTitle.innerText= "22"



        
        driveDiv.appendChild(driveHeader)
        driveBody.appendChild(driveTitle);
        driveDiv.appendChild(driveBody)
        
        accelerationDiv.appendChild(accelerationHeader)
        accelerationBody.appendChild(accelerationTitle);
        accelerationDiv.appendChild(accelerationBody)

        statusDivs.appendChild(driveDiv);
        statusDivs.appendChild(accelerationDiv);
    // }
}