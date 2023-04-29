function displaySummary() {
    const summaryElement = document.getElementById('summary');
    const totalElement = document.getElementById('total');

    // Récupérez les valeurs des éléments de formulaire
    const ateliers = document.querySelectorAll('#atelier_select:checked');
    const firstHotel = document.getElementById('first_reservation_hotel');
    const firstCategorie = document.getElementById('first_reservation_categorie');
    const secondHotel = document.getElementById('second_reservation_hotel');
    const secondCategorie = document.getElementById('second_reservation_categorie');
    const registrationCost = 110;

    let summary = `<h5 style="text-decoration: underline; color: #e11f31">Frais d\'inscription : ${registrationCost} €</h5>`;
    // let summary = '<h5>Ateliers :</h5><ul>';
    let total = registrationCost;
     summary+=`<h5 style="text-decoration: underline; color: #e11f31">Ateliers :</h5><ul>`;

    // Ajoutez les ateliers sélectionnés au résumé
    ateliers.forEach(atelier => {
        summary += `<li>${atelier.nextElementSibling.textContent}</li>`;
    });
    summary += '</ul>';

    summary += '<h5 style="text-decoration: underline; color: #e11f31">Réservation hotel :</h5><ul>';

    // Ajoutez les choix d'hôtels et de catégories au résumé et calculez le total
    if (firstHotel.value && firstCategorie.value) {
        const selectedHotel = firstHotel.selectedIndex;
        const prixHotel1 = parseFloat(firstCategorie.selectedOptions[0].getAttribute(`data-prix-hotel${selectedHotel}`));
        summary += `<p>${firstHotel.selectedOptions[0].textContent} - ${firstCategorie.selectedOptions[0].textContent}</p>`;
        total += prixHotel1;
    }

    if (secondHotel.value && secondCategorie.value) {
        const selectedHotel = secondHotel.selectedIndex;
        const prixHotel2 = parseFloat(secondCategorie.selectedOptions[0].getAttribute(`data-prix-hotel${selectedHotel}`));
        summary += `<p>${secondHotel.selectedOptions[0].textContent} - ${secondCategorie.selectedOptions[0].textContent} </p>`;
        total += prixHotel2;
    }
    // Ajoutez les repas accompagnant sélectionnés au résumé et calculez le total
    const accompagnantCheckboxes = document.querySelectorAll('.input_wrap_select_accompagnant input[type="checkbox"]:checked');
    if (accompagnantCheckboxes.length > 0) {
        summary += '<h5 style="text-decoration: underline; color: #e11f31">Repas accompagnant :</h5><ul>';
        accompagnantCheckboxes.forEach(checkbox => {
            summary += `<li>${checkbox.nextElementSibling.textContent} - 30€</li>`;
            total += 30;
        });
        summary += '</ul>';
    }


    // Insérez le résumé et le total dans la modal
    summaryElement.innerHTML = summary;
    totalElement.textContent = total.toFixed(2);
}

const summaryModal = document.getElementById('summary-modal');
const instance =M.Modal.init(summaryModal);

const confirmButton = document.querySelector('#modal-inscription-button');

confirmButton.addEventListener('click', function () {
    console.log('boutton de la modal');
    displaySummary();
    instance.open();
});