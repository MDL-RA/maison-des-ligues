async function fetchNumLicencie()
{
    const response = await fetch('http://localhost:8002/api/licencies/1', {
        method: "GET",
        mode: 'cors',
        cache: 'no-cache',
        headers: {
            "Accept": "application/json",
        },
    })
    return response.json();
}


window.addEventListener('load', async () => {
    const numLicencie = document.querySelector("#registration_form_numLicence");
    const registerContainer = document.querySelector('.container-login');
    M.CharacterCounter.init(numLicencie);
    let data = await fetchNumLicencie();
    numLicencie.addEventListener('change', () => {
        fetchNumLicencie().then((data) => console.log(data));
    })
    if(!data){
        let loader = document.createElement("div");
        let spinner = document.createElement("div");
        let circle = document.createElement("div");
        let circleLeft = document.createElement("div");
        let circleGap = document.createElement("div");
        let circleRight = document.createElement("div");
        loader.classList.add('preloader-wrapper big active');
        spinner.classList.add('spinner-layer spinner-blue-only');
        circle.classList.add('circle');
        circleLeft.classList.add('circle-clipper left');
        circleGap.classList.add('gap-patch');
        circleRight.classList.add('circle-clipper right');
        loader.append(spinner);
        spinner.append(circleLeft);
        circleLeft.append(circle);
        spinner.append(circleGap);
        circleGap.append(circle);
        spinner.append(circleRight);
        circleRight.append(circle);
        registerContainer.innerHTML=loader;
    }
})