//Proves
console.log("JS carregat de forma correcta"); 


// Configuració de ruta base del projecte
// Ruta base per a totes les peticions AJAX
const basePath = '/ProjecteJosepFentse/'; 


//Funció per a poderr carregar contingut parcial per AJAX
function loadPart(url, elementId) {

    const xhr = new XMLHttpRequest();

    xhr.open('GET', basePath + url, true);

    xhr.onload = function () {

        if (xhr.status === 200) {

            document.getElementById(elementId).innerHTML = xhr.responseText;

            eventsinsertats(); 
            
        } else {

            console.error('Error en carregar ' + url);
            document.getElementById(elementId).innerHTML = '<p>Error carregant la pàgina</p>';
        }
    };

    xhr.onerror = function () {

        console.error('Error en la sol.licitud de AJAX');
        document.getElementById(elementId).innerHTML = '<p>Error de connexió</p>';
    };

    xhr.send();
}


//Funció que assigna esdeveniments a enllaços amb classe .nav-link
function eventsinsertats() {

    document.querySelectorAll('.nav-link').forEach(link => {

        //Evitar duplicats de esdeveniments
        if (!link.hasAttribute('data-listener')) {
            
            
            link.addEventListener('click', function (event) {

                event.preventDefault(); 
                const url = this.getAttribute('href');
                if (url && url !== "#") {

                    loadPart(url, 'main-content'); 
                }

                const menuToggle = document.getElementById('menu-toggle');
                if (menuToggle) menuToggle.checked = false;

            });
            link.setAttribute('data-listener', 'true'); 
        }
    });
}


//Login i registre AJAX

document.addEventListener('DOMContentLoaded', function () {

    //Formulari de registre AJAX
    const formRegistre = document.getElementById('registreForm');
    if (formRegistre) {
        formRegistre.addEventListener('submit', function (event) {

            event.preventDefault(); 
            const datos = new FormData(formRegistre);

            const xhr = new XMLHttpRequest();

            xhr.open('POST', basePath +'php_bbdd_projectesupermario/registre.php', true);

            xhr.onload = function () {

                if (xhr.status === 200) {

                    if (xhr.responseText.trim() === 'OK') {

                        window.location.href = 'benvinguda.html';
                        actualizaUsuariBarra();

                    } else {

                        document.getElementById('mensaje-registre').innerHTML = xhr.responseText;
                    }
                }
            };
            xhr.send(datos);
        });
    }

    //Formulari de login AJAX
    const formLogin = document.getElementById('loginForm');
    if (formLogin) {

        formLogin.addEventListener('submit', function (event) {

            event.preventDefault();
            const datos = new FormData(formLogin);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', basePath + 'php_bbdd_projectesupermario/login.php', true);

            xhr.onload = function () {

                if (xhr.status === 200) {

                    if (xhr.responseText.trim() === 'OK') {

                        loadPart('inici.html', 'main-content');
                        actualizaUsuariBarra();

                    } else {

                        document.getElementById('mensaje-login').innerHTML = xhr.responseText;
                    }
                }
            };
            xhr.send(datos);
        });
    }
});

// Funcions duplicades per les crides
function enviarLogin(event) {

    
    event.preventDefault();
    const form = document.getElementById('loginForm');
    const datos = new FormData(form);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', basePath + 'php_bbdd_projectesupermario/login.php', true);

    xhr.onload = function () {

        if (xhr.status === 200) {

            if (xhr.responseText.trim() === 'OK') {
                loadPart('inici.html', 'main-content');
                actualizaUsuariBarra();
            } else {

                document.getElementById('mensaje-login').innerHTML = xhr.responseText;
            
            }
        }
    };
    xhr.send(datos);
    return false;
}

function enviarRegistre(event) {

    event.preventDefault();
    const form = document.getElementById('registreForm');
    const datos = new FormData(form);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', basePath + 'php_bbdd_projectesupermario/registre.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            if (xhr.responseText.trim() === 'OK') {
                window.location.href = 'benvinguda.html';
                actualizaUsuariBarra();
            } else {
                document.getElementById('mensaje-registre').innerHTML = xhr.responseText;
            }
        }
    };

    xhr.send(datos);
    return false;
}

//Actualitzar la barra de dalt amb dades de l'usuari
function actualizaUsuariBarra() {
    // Carrega la barra d'usuari login/logout per AJAX
    const xhrUsuari = new XMLHttpRequest();
    xhrUsuari.open('GET', basePath + 'php_bbdd_projectesupermario/visualUsuariIniciat.php', true);

    xhrUsuari.onload = function () {

        if (xhrUsuari.status === 200) {

            const usuariBarra = document.getElementById('usuari-barra');
            if (usuariBarra) {

                usuariBarra.innerHTML = xhrUsuari.responseText;
            }
        }
    };
    xhrUsuari.send();
}

//Logout
document.addEventListener('click', function (e) {

    //Si es fa clik al botó de logout tanca la sessió via AJAX
    if (e.target && e.target.id === 'logout-btn') {

        e.preventDefault();
        const xhr = new XMLHttpRequest();

        xhr.open('GET', basePath + 'php_bbdd_projectesupermario/logout.php', true);

        xhr.onload = function () {

            loadPart('inici.html', 'main-content'); 
            actualizaUsuariBarra();
        };
        xhr.send();
    }
});

//Carrega automàtica de la pàgina inicial
window.onload = function () {

    //Detectar si està en registre per no sobreescriure el contingut
    const currentPage = window.location.pathname.split('/').pop();
    const isOnRegistre = currentPage === 'registre.html';

    if (!isOnBenvinguda && !isOnRegistre) {
        // Si no està en registre carrega inici.html dins de main-content
        const element = document.getElementById('main-content');
        if (element) {
            loadPart('inici.html', 'main-content');
        }
    }

    eventsinsertats(); 
    actualizaUsuariBarra(); 
};
