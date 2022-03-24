class Bots {
    constructor() {
        this.BotList = {};
    }

    saveBot(id, wsKey, client) {
        if(this.getBotByWsKey(wsKey) == null){
            this.BotList[wsKey] = {
                "id": id, 
                "action": "",
                "status": "", 
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

    setAction(wsKey, action){
        this.BotList[wsKey].status = action;
    }

    setStatus(wsKey, status){
        this.BotList[wsKey].status = status;
    }

    removeBot(wsKey){
        delete this.BotList[wsKey];
    }

    getAllBots() {
        return this.BotList;
    }
}
module.exports = Bots