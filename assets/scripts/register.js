async function fetchNumLicencie(id)
{
    //const response = await fetch('http://localhost:8000/get/api/licencie/'+id, {
    //    method: "GET",
    //    mode: 'cors',
    //    cache: 'no-cache',
    //    headers: {
    //        "Accept": "application/json",
    //    },
    //})
    
    const response = await fetch('http://api/api/licencies/'+id, {
        method: "GET",
        mode: 'cors',
        cache: 'no-cache',
        headers: {
            "Accept": "application/json",
        },
    })
    if(response.status === 200){
        return response.json();
    }else{
        throw new Error('La ressource demandée n\' a pas été trouvée');
    }

}


window.addEventListener('load', async () => {
    const numLicencie = document.querySelector("#registration_form_numLicence");
    M.CharacterCounter.init(numLicencie);
    numLicencie.addEventListener('change', async () => {
        console.log(numLicencie.value.length);
        if (numLicencie.value.length === 11) {
            await fetchNumLicencie(numLicencie.value).then((data) => console.log(data)).catch((error) => console.log(error));
        }

    })
})