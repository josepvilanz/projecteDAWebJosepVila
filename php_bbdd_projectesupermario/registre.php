<?php
session_start(); 

//Variables
$error = ""; 
$exito = ""; 

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
    $nomPerfil = trim($_POST['nom'] ?? '');
    $nomLogin = trim($_POST['login'] ?? '');
    $contrasenya = trim($_POST['contrasenya'] ?? '');
    $emailUsuari = trim($_POST['email'] ?? '');
    $telefonUsuari = trim($_POST['n_telefon'] ?? '');

    // Comprovar que cap camp estiga buida
    if ($nomPerfil === "" || $nomLogin === "" || $contrasenya === "" || $emailUsuari === "" || $telefonUsuari === "") {
        $error = "Tots els camps són obligatoris per registrar-se";
    } else {

        // Comprovar si ja existeix un usuari amb el mateix nom d'usuari
        $consultaUsuari = $connexio->prepare("SELECT * FROM usuari WHERE login = ?");

        $consultaUsuari->bind_param("s", $nomLogin);
        $consultaUsuari->execute();

        $resultat = $consultaUsuari->get_result();

        if ($resultat->num_rows > 0) {

            $error = "Aquest nom d'usuari ja existeix perfavor escriu un altre";

        } else {

            //Encriptar la contrasenya com en programacio
            $contrasenyaEncriptada = password_hash($contrasenya, PASSWORD_DEFAULT);

            
            $insercioUsuari = $connexio->prepare("INSERT INTO usuari (login, contrasenya, email, n_telefon) VALUES (?, ?, ?, ?)");
            
            //la ssss esque els quatre valors son cadenees dde text 
            $insercioUsuari->bind_param("ssss", $nomLogin, $contrasenyaEncriptada, $emailUsuari, $telefonUsuari);

            if ($insercioUsuari->execute()) {

                $idUsuariCreat = $connexio->insert_id; 

                $insercioPerfil = $connexio->prepare("INSERT INTO perfilpropi (nom, Usuari_idUsuari) VALUES (?, ?)");
                
                $insercioPerfil->bind_param("si", $nomPerfil, $idUsuariCreat);

                if ($insercioPerfil->execute()) {

                    $_SESSION['idUsuari'] = $idUsuariCreat;

                    $_SESSION['nom'] = $nomPerfil;

                    // Si la petició es AJAX retorna "OK" i se ix de ahi
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {

                        echo "OK";
                        exit();
                    }

                    
                    $completat = "Registre completat correctament! Ja pots continuar navegant.";

                } else {

                    $error = "Error en crear el perfil: " . $connexio->error;

                }
                $insercioPerfil->close();

            } else {
                $error = "Error en crear l'usuari: " . $connexio->error;
            }

            $insercioUsuari->close();
        }
        $consultaUsuari->close();
    }

    $connexio->close();

    // Si la petició es AJAX retorna "OK" i se ix de ahi
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {

        echo $error ?:  $completat;
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Registre</title>
    <link rel="stylesheet" href="../css/estil.css">
</head>
<body>
<div id="main-content">

    <!-- Sintaxis amb condicions de php per estar amb html -->
    <?php if ($completat != ""): ?>

        <h2>Registre completat!</h2>

        <p style="color:green;"><?php echo  $completat; ?></p>
        <button onclick="window.location.href='/ProjecteJosepFentse/index.html'">Tornar a la pàgina principal</button>
    <?php else: ?>
        <h2>Registre</h2>
        <?php if ($error != ""): ?>


            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="registre.php" id="registreForm">
            <label>Nom:</label>
            <input type="text" name="nom" required><br>
            <label>Nom d'usuari (necessari per iniciar sessió):</label>
            <input type="text" name="login" required><br>
            <label>Contrasenya:</label>
            <input type="password" name="contrasenya" required><br>
            <label>Email:</label>
            <input type="email" name="email" required><br>
            <label>Telèfon:</label>
            <input type="text" name="n_telefon" required><br>
            <button type="submit">Registrar</button>
            <div id="mensaje-registre"></div>
        </form>

    <?php endif; ?>
</div>
<script src="../app.js"></script>
</body>
</html>
