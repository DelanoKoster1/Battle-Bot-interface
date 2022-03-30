<div>
    <button class="prepare-maze">Prepare maze</button> <br>
    <button class="start-maze">start maze</button> <br>
    <button class="stop-maze">stop maze</button><br><br>

    <button class="prepare-race">Prepare race</button> <br>
    <button class="start-race">start race</button> <br>
    <button class="stop-race">stop race</button><br><br>

    <button class="prepare-butler">Prepare butler</button> <br>
    <button class="start-butler">start butler</button> <br>
    <button class="stop-butler">stop butler</button><br>
</div>

<script>
    let prepareMaze = document.querySelector('.prepare-maze');
let startMaze = document.querySelector('.start-maze');
let stopMaze = document.querySelector('.stop-maze');

let prepareRace = document.querySelector('.prepare-race');
let startRace = document.querySelector('.start-race');
let stopRace = document.querySelector('.stop-race');

let prepareButler = document.querySelector('.prepare-butler');
let startButler = document.querySelector('.start-butler');
let stopButler = document.querySelector('.stop-butler');

const ws = new WebSocket(`ws://${getDomainName()}:33003/websocket/robot`);

ws.addEventListener("open", () => {
    ws.send(JSON.stringify({
        "action": "login",
        "key": "111",
        "id": "admin1"
    }));

    // Maze
    prepareMaze.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "prepare",
            "game": "maze"
        }))
    })
    startMaze.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "start",
            "game": "maze"
        }))
    })
    stopMaze.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "ended",
            "game": "maze"
        }))
    })
  
    //race
    prepareRace.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "prepare",
            "game": "race"
        }))
    })
    startRace.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "start",
            "game": "race"
        }))
    })
    stopRace.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "ended",
            "game": "race"
        }))
    })

    // Butler
    prepareButler.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "prepare",
            "game": "butler"
        }))
    })
    startButler.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "start",
            "game": "butler"
        }))
    })
    stopButler.addEventListener('click', () =>{
        ws.send(JSON.stringify({
            "for": "all",
            "action": "ended",
            "game": "butler"
        }))
    })


    ws.addEventListener("message", ({data}) => {

        console.log(JSON.parse(data));
    })



});

function getDomainName(){
    return window.location.href.replace('http://','').replace('https://','').split(/[/?#]/)[0];
}

</script>
