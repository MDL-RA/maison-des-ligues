document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les éléments du formulaire
    const firstHotelSelect = document.getElementById('first_reservation_hotel');
    const firstCategorySelect = document.getElementById('first_reservation_categorie');
    const secondHotelSelect = document.getElementById('second_reservation_hotel');
    const secondCategorySelect = document.getElementById('second_reservation_categorie');
    // Mettre à jour l'état activé/désactivé du sélecteur de type de chambre en fonction de la sélection de l'hôtel
    function updateCategoryDisabledStatus(hotelSelect, categorySelect) {
    if (hotelSelect.value) {
        categorySelect.disabled = false;
    } else {
        categorySelect.disabled = true;
        categorySelect.value = "";
    }
}

    // Mettre à jour les options du sélecteur de type de chambre avec les prix en fonction de la sélection de l'hôtel
    function updateCategoryOptionsWithPrices(hotelSelect, categorySelect) {
        const selectedOption = hotelSelect.options[hotelSelect.selectedIndex];
        if (selectedOption) {
                const hotelId = selectedOption.value;
                categorySelect.querySelectorAll('option').forEach(option => {
                if (option.value) {
                    const prix = option.getAttribute(`data-prix-hotel${hotelId}`);
                    option.textContent = `${option.textContent.split(' - ')[0]} - ${prix} €`;
                }
            });
        }
    }

    // Ajouter des écouteurs d'événements pour les sélections d'hôtels
    firstHotelSelect.addEventListener('change', function() {
        updateCategoryDisabledStatus(firstHotelSelect, firstCategorySelect);
        updateCategoryOptionsWithPrices(firstHotelSelect, firstCategorySelect);
    });

    secondHotelSelect.addEventListener('change', function() {
        updateCategoryDisabledStatus(secondHotelSelect, secondCategorySelect);
        updateCategoryOptionsWithPrices(secondHotelSelect, secondCategorySelect);
    });

    // Initialiser l'état du formulaire
    updateCategoryDisabledStatus(firstHotelSelect, firstCategorySelect);
    updateCategoryDisabledStatus(secondHotelSelect, secondCategorySelect);
});

