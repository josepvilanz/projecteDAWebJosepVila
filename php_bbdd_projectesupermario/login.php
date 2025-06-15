<?php
session_start(); 

// Variables
$error = "";
$completat = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 


    $servidor = "localhost";
    $usuariBD = "root";
    $contrasenyaBD = "";
    $baseDeDades = "mydb";


    $connexio = new mysqli($servidor, $usuariBD, $contrasenyaBD, $baseDeDades);

    if ($connexio->connect_error) {
        die("Connexió fallida: " . $connexio->connect_error); 
    }

    //Recollir i netejar els camps 
    $nomLogin = trim($_POST['login']);
    $contrasenya = trim($_POST['contrasenya']);

    $consulta = $connexio->prepare("SELECT * FROM usuari WHERE login = ?");

    $consulta->bind_param("s", $nomLogin);
    $consulta->execute();

    $resultat = $consulta->get_result();

    if ($resultat->num_rows === 1) {
        $usuari = $resultat->fetch_assoc();

        //Comprovar la encriptacio de la contrasenya com en programacio
        if (password_verify($contrasenya, $usuari['contrasenya'])) {
            $_SESSION['idUsuari'] = $usuari['idUsuari'];

            //Agafar el nom de perfilpropi
            $consultaNom = $connexio->prepare("SELECT nom FROM perfilpropi WHERE Usuari_idUsuari = ?");
            $consultaNom->bind_param("i", $usuari['idUsuari']);
            $consultaNom->execute();
            $resultatNom = $consultaNom->get_result();
            if ($resultatNom->num_rows === 1) {
                $perfil = $resultatNom->fetch_assoc();
                $_SESSION['nom'] = $perfil['nom'];
            }

            $completat = "Sessió iniciada correctament!"; 

        } else {

            $error = "La contrasenya és incorrecta"; 
        }
    } else {

        $error = "Aquest usuari no existeix";
    }
    $consulta->close();

    $connexio->close();
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sessió</title>
    <link rel="stylesheet" href="../css/estil.css">
</head>
<body>
<div class="form-container">
    
    <!-- Sintaxi alternativa per a condicions PHP amb HTML -->
    <?php if ($completat != ""): ?>
        <h2>Sessió iniciada!</h2>
        <p style="color:green;"><?php echo $completat; ?></p>
        <button onclick="window.location.href='/ProjecteJosepFentse/index.html'">Tornar a la pàgina principal</button>
    <?php else: ?>
        <h2>Iniciar Sessió</h2>
        <form method="POST" action="login.php">
            <label>Nom d'usuari:</label>
            <input type="text" name="login" required><br>
            <label>Contrasenya:</label>
            <input type="password" name="contrasenya" required><br>
            <button type="submit">Entrar</button>
            <?php if ($error != ""): ?>
                <div style="color:red;"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
        <form action="/ProjecteJosepFentse/index.html" method="get" style="margin-top: 20px;">
            <button type="submit">Tornar a la pàgina principal</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
