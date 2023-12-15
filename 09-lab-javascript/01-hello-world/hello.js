console.log("Hello World");

//span id=ciao

/*soluzione 1*/
//const tagHello = document.getElementById("ciao");

/*soluzione 2*/
const tagHello = document.querySelector("#ciao");


tagHello.innerHTML = "Hello World";





//class=anno

/*soluzione 1*/
//const tagYear = document.getElementsByClassName("anno")[0];

/*soluzione 2*/
//const tagYear = document.querySelector(".anno");


tagYear.innerHTML = "2021";


