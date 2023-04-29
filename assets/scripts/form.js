const form_1 = document.querySelector(".form_1");
const form_2 = document.querySelector(".form_2");
const form_3 = document.querySelector(".form_3");
const form_1_btns = document.querySelector(".form_1_btns");
const form_2_btns = document.querySelector(".form_2_btns");
const form_3_btns = document.querySelector(".form_3_btns");
const form_1_next_btn = document.querySelector(".form_1_btns .btn_next");
const form_2_back_btn = document.querySelector(".form_2_btns .btn_back");
const form_2_next_btn = document.querySelector(".form_2_btns .btn_next");
const form_3_back_btn = document.querySelector(".form_3_btns .btn_back");
const form_2_progessbar = document.querySelector(".form_2_progessbar");
const form_3_progessbar = document.querySelector(".form_3_progessbar");
const btn_done = document.querySelector(".btn_done");
const modal_wrapper = document.querySelector(".modal_wrapper");
const shadow = document.querySelector(".shadow");

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('#atelier_select');

    function updateRequiredStatus() {
        const checkedCheckboxes = document.querySelectorAll('#atelier_select:checked');
        const maxChecked = 5;
        const requiredCheckboxes = checkedCheckboxes.length >= maxChecked;

        checkboxes.forEach(checkbox => {
            checkbox.required = !requiredCheckboxes;
        });

        if (requiredCheckboxes) {
            checkboxes.forEach(c => {
                if (!c.checked) {
                    c.disabled = true;
                }
            });
        } else {
            checkboxes.forEach(c => {
                c.disabled = false;
            });
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateRequiredStatus();
        });
    });

    updateRequiredStatus();
});
form_1_next_btn.addEventListener("click", function(){
    form_1.style.display = "none";
    form_2.style.display = "block";

    form_1_btns.style.display = "none";
    form_2_btns.style.display = "flex";

    form_2_progessbar.classList.add("active");
});

form_2_back_btn.addEventListener("click", function(){
    form_1.style.display = "block";
    form_2.style.display = "none";

    form_1_btns.style.display = "flex";
    form_2_btns.style.display = "none";

    form_2_progessbar.classList.remove("active");
});

form_2_next_btn.addEventListener("click", function(){
    form_2.style.display = "none";
    form_3.style.display = "block";

    form_3_btns.style.display = "flex";
    form_2_btns.style.display = "none";

    form_3_progessbar.classList.add("active");
});

form_3_back_btn.addEventListener("click", function(){
    form_2.style.display = "block";
    form_3.style.display = "none";

    form_3_btns.style.display = "none";
    form_2_btns.style.display = "flex";

    form_3_progessbar.classList.remove("active");
});

btn_done.addEventListener("click", function(){
    modal_wrapper.classList.add("active");
})

shadow.addEventListener("click", function(){
    modal_wrapper.classList.remove("active");
})

