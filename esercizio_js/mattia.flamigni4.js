const images = document.querySelectorAll('.slider-image img');

document.addEventListener("DOMContentLoaded", function () {

    for (let i = 2; i < images.length; i++) {
        images[i].style.display = "none";
    }

    images[0].classList.add('current');

});


for(let i = 0; i<images.length; i++){

    images[i].addEventListener('click', function(){

        for(let i = 0; i<images.length; i++){
            images[i].style.display="none";
            images[i].classList.remove("current");
        }

        if(! images[i].classList.contains('current')){
            images[i].classList.add('current');

            images[i].style.display="inline-block";
            if(i<images.length-1){
                images[i+1].style.display="inline-block";
            }
            if(i>0){
                images[i-1].style.display="inline-block";
            }
            
        }
    })
}







