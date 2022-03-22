class Bots {
    constructor() {
        this.BotList = {};
    }

    saveBot(id, wsKey, client) {
        if(this.getBotByWsKey(wsKey) == null){
            this.BotList[wsKey] = {"id": id, "action": "","status": "", "client": client, "connAttempt": 2};
            return true;   
        }else{
            return false;
        }

        
    }

    getBotByWsKey(wsKey) {
        return this.BotList[wsKey];
    }

    getBotById(id){
        let botsList = this.getAllBots()
        Object.keys(botsList).forEach(wsKey => {
            if(botsList[wsKey].id == id){
                return botsList[wsKey];
            }
        });
    }

    setConnAttempt(wsKey, attempts){
        this.BotList[wsKey].connAttempt = attempts;
    }

    setAction(wsKey, action){
        this.BotList[wsKey].status = action;
    }

    removeBot(wsKey){
        delete this.BotList[wsKey];
    }

    getAllBots() {
        return this.BotList;
    }
}
module.exports = Bots