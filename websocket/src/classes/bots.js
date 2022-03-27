class Bots {
    constructor() {
        this.BotList = {};
    }

    saveBot(id, wsKey, client) {
        if(this.getBotByWsKey(wsKey) == null){
            this.BotList[wsKey] = {
                "id": id, 
                "game": "", 
                "client": client, 
                "connAttempt": 0};
            return true;   
        }else{
            return false;
        }

        
    }

    getBotByWsKey(wsKey) {
        return this.BotList[wsKey];
    }

    getBotById(id){
        let botsList = this.getAllBots();
        Object.keys(botsList).forEach(wsKey => {
            if(botsList[wsKey].id == id){
                return botsList[wsKey];
            }
        });
    }

    botsReady(){
        let botsList = this.getAllBots();
        Object.keys(botsList).forEach(wsKey => {
            if (!botsList[wsKey].status && botsList[wsKey].action != ""){
                return false;
            }
        });
        
        return true;
    }

    setConnAttempt(wsKey, attempts){
        this.BotList[wsKey].connAttempt = attempts;
    }

    setGame(wsKey, game){
        this.BotList[wsKey].game = game;
    }

    getGame(wsKey){
        return this.BotList[wsKey].game
    }

    removeBot(wsKey){
        delete this.BotList[wsKey];
    }

    getAllBots() {
        return this.BotList;
    }
}
module.exports = Bots