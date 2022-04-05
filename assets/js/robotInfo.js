const ws = new WebSocket(`ws://${getDomainName()}:3003/websocket/robot`);

ws.addEventListener("open", () => {
    ws.send(
        JSON.stringify({
            action: "login",
            key: "115",
            id: "interface",
        })
    );

    ws.addEventListener("message", (message) => {
        let data = JSON.parse(message.data);
        console.log(data);
        clearLiveCard();
        createLiveCard(data);
    });
});

function clearLiveCard() {
    divs = document.querySelectorAll(".liveStatus");
    divs.forEach((div) => {
        div.innerHTML = "";
    });
}

function createLiveCard(bots) {
    let statusDivs = document.querySelectorAll(".liveStatus");

    Object.entries(bots).forEach(([key, bot]) => {
        statusDivs.forEach((botAdres) => {
            let dataAttribute = botAdres.getAttribute("macAdres");
            if (key == dataAttribute) {
                curruntDiv = botAdres;

                let driveDiv = document.createElement("div");
                driveDiv.setAttribute("class", "card d-inline-block me-");

                let driveBody = document.createElement("div");
                driveBody.setAttribute("class", "card-body");

                let titleCol = document.createElement("div");
                titleCol.setAttribute("class", "col-12");

                let titleLive = document.createElement("h1");
                titleLive.setAttribute("class", "col-12");
                titleLive.innerText = 'Live status'

                let driveTitle = document.createElement("div");
                driveTitle.setAttribute("class", "card-title");

                let driveHeader = document.createElement("h5");
                if (bot.isDriving) {
                    driveHeader.setAttribute(
                        "class",
                        "card-header bg-success text-white"
                    );
                    driveTitle.innerHTML = "Vroemmm";
                } else {
                    driveHeader.setAttribute("class", "card-header");
                    driveTitle.innerHTML = "Stil";
                }
                driveHeader.innerText = "Rijdend";

                let accelerationDiv = document.createElement("div");
                accelerationDiv.setAttribute("class", "card d-inline-block");

                let accelerationHeader = document.createElement("h5");

                accelerationHeader.innerText = "Acceleratatie";

                let accelerationBody = document.createElement("div");
                accelerationBody.setAttribute("class", "card-body");

                let accelerationTitle = document.createElement("div");
                accelerationTitle.setAttribute("class", "card-title");

                if (bot.acceleration > 0) {
                    accelerationHeader.setAttribute(
                        "class",
                        "card-header bg-success text-white"
                    );
                } else {
                    accelerationHeader.setAttribute("class", "card-header");
                }
                accelerationTitle.innerText = bot.acceleration;


                driveDiv.appendChild(driveHeader);
                driveBody.appendChild(driveTitle);
                driveDiv.appendChild(driveBody);

                accelerationDiv.appendChild(accelerationHeader);
                accelerationBody.appendChild(accelerationTitle);
                accelerationDiv.appendChild(accelerationBody);

                titleCol.appendChild(titleLive);

                curruntDiv.appendChild(titleCol);
                curruntDiv.appendChild(driveDiv);
                curruntDiv.appendChild(accelerationDiv);
            }
        });
    });
}
