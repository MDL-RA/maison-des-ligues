document.addEventListener("DOMContentLoaded", function() {
    let modal = document.getElementById("flash-modal");
    let closeButton = document.querySelector("#close");
    if(modal){
        modal.style.opacity = "1";
    }

    if (closeButton) {
        closeButton.onclick = function() {
            if (modal) {
                modal.style.opacity = "0";
                setTimeout(function() {
                    modal.style.display = "none";
                }, 300);
            }
        }
    }

    if(modal) {
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.opacity = "0";
                setTimeout(function() {
                    modal.style.display = "none";
                }, 300);
            }
        }
    }
});