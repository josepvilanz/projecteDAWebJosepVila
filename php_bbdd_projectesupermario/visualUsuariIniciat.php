<?php
session_start();
if (isset($_SESSION['nom'])) {
    echo '<span>Hola, ' . htmlspecialchars($_SESSION['nom']) . ' | <a href="#" id="logout-btn">Tancar sessió</a></span>';
} else {
    echo '<a href="login.html" id="login-link">Iniciar sessio</a> | <a href="registre.html" id="register-link">Registrar-se</a>';
}
?>
