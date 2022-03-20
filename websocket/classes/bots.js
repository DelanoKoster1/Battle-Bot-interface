class Bots {
    constructor(){
        this.BotList = {};
    }

    saveBot(id, bot){
        this.BotList[id] = bot;
    }

    getBot(id){
        return this.BotList[id];
    }

    getAllBots(){
        return this.BotList;
    }
} 

module.exports = Bots 
