
function Computer(processore, disco, ram){
    this.processore = processore;
    this.disco = disco;
    this.ram = ram;
}

Computer.prototype.infoComputerConsole = function(){
    console.log("processore: " + this.processore +" disco: "+ this.disco+" ram: "+this.ram);
}

Computer.prototype.infoComputerDom = function(id){
    document.getElementById(id).innerHTML = 
        "<p>Processore:" + this.processore + "</p> <p>Disco: " + this.disco  + "</p> <p>Ram: " + this.ram + "</p>"
    ;
    


}









class Computer2 {
    constructor(processore, disco, ram){
        this.processore = processore;
        this.disco = disco;
        this.ram = ram;
    }

    infoComputerConsole = function(){
        console.log("processore: " + this.processore+" disco: "+this.disco+" ram: "+this.ram);
    }

    infoComputerDOM(id){
        document.getElementById(id).innerHTML = 
        "<p>Processore:" + this.processore + "</p> <p>Disco: " + this.disco  + "</p> <p>Ram: " + this.ram + "</p>"
    ;
    }
}


const mioPc = new Computer("i7", "500", "16");
mioPc.infoComputerConsole()
mioPc.infoComputerDom("miopc");

const mioPC2 = new Computer("i5", "250", "16");
mioPC2.infoComputerConsole();
mioPC2.infoComputerDom("miopc2");