document.addEventListener('DOMContentLoaded', () => {
    const dni = prompt("Introdueix el teu DNI:");
    const nom = prompt("Introdueix el teu nom complet:");
    const email = prompt("Introdueix el teu correu electrònic:");

    let errors = [];

    let partsNom = nom.split(' ');
    if (partsNom.length !== 2) {
        errors.push("El nom ha de tenir les dos paraules");
    }

    if (dni.length !== 9) {
        errors.push("El DNI ha de tindre 9 caràcters");
    } else {
        let numDNI = dni.substring(0, 8);
        if (isNaN(numDNI)) {
            errors.push("Els primers 8 caràcters del DNI han de ser números");
        }
    }

    if (!email.includes('@') || !email.includes('.')) {
        errors.push("El email ha de tindre '@' i '.'");
    }

    if (errors.length > 0) {
        alert("Errors:\n" + errors.join("\n"));
    } else {

        let nomFormatejat = partsNom[0].charAt(0).toUpperCase() + partsNom[0].slice(1) +
                            " " +
                            partsNom[1].charAt(0).toUpperCase() + partsNom[1].slice(1);


                            let dniFormatejat = dni.substring(0, 8) + dni.slice(-1).toUpperCase();

        alert("Dades:\nNom: " + nomFormatejat + "\nDNI: " + dniFormatejat + "\nEmail: " + email);
    }
});
