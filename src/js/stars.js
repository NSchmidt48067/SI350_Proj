/**
 * Description: js functions to assist with rating meals 
 * Creation Date: 14NOV2025
 * Author: George Prielipp
 */

function uncheckRadios() {
    let radios = document.querySelectorAll("input[type='radio']");

    for(let radio of radios) {
        radio.checked = false;
    }
}

function init() {
    document.querySelectorAll('.star-rating:not(.readonly) label').forEach(star => {
        star.addEventListener('click', function(ev) {
            let radio = document.getElementById(this.htmlFor);
            if(!radio.checked) {
                this.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            }
            else if (radio.checked) {
                setTimeout( () => {uncheckRadios();}, 100); // I want my code to run not theirs
            }
        });
    });
}

// run when the document is loaded
document.addEventListener("DOMContentLoaded", () => {
    init();
})