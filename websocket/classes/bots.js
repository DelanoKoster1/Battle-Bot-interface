class Bots {
    constructor() {
        this.BotList = {};
    }

    saveBot(id, wsKey, client, status = "") {
        if(this.getBotByWsKey(wsKey) == null){
            this.BotList[wsKey] = {"status": status, "id": id ,"client": client, "connAttempt": 2};
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

    removeBot(wsKey){
        delete this.BotList[wsKey];
    }
    // getBotById(id) {
    //     return this.BotList[id];
    // }

    // getBotByWsKey(wsKey){
    //     let botsList = this.getAllBots()
    //     Object.keys(botsList).forEach(id => {
    //         if(botsList[id].wsKey == wsKey){
    //             return botsList[id];
    //         }
    //     });
    // }

    getAllBots() {
        return this.BotList;
    }
}
module.exports = Bots