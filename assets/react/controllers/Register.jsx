// assets/react/controllers/MyComponent.jsx
import React from 'react';
import {createRoot} from "react-dom/client";


function RegistrationForm(){
    return (
        <>
            <h1>Coucou react</h1>
        </>
    )
}

class Register extends HTMLElement {
    connectedCallback() {
        const root = createRoot(this)
        root.render(<RegistrationForm />)
    }
}

customElements.define('registration-form',Register)