<?php
// Recuperamos el color de la cookie o usamos el predeterminado
$bgColor = $_COOKIE['pokedex_color'] ?? '#f4f4f9';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokédex - Acceso de Entrenador</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: <?= htmlspecialchars($bgColor) ?>; /* Persistencia de color[cite: 1, 2] */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 350px;
            border-top: 10px solid #cc0000; /* Rojo Pokéball */
            text-align: center;
        }
        .login-card h2 { color: #333; margin-bottom: 1.5rem; }
        .input-group { margin-bottom: 1rem; text-align: left; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #555; }
        input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 1rem;
            background-color: #cc0000;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover { background-color: #ff0000; }
        .error { color: #cc0000; background: #ffe6e6; padding: 0.5rem; border-radius: 5px; margin-bottom: 1rem; }
        .footer-link { margin-top: 1.5rem; font-size: 0.9rem; }
        .footer-link a { color: #3b4cca; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-card">
    <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/International_Pok%C3%A9mon_logo.svg" alt="Pokemon" width="150" style="margin-bottom: 10px;">
    <h2>Acceso de Entrenador</h2>

    <!-- Mostramos error si el controlador lo detecta[cite: 1] -->
    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?accion=login" method="POST">
        <div class="input-group">
            <label for="usuario">Nombre de Entrenador:</label>
            <input type="text" id="usuario" name="usuario" required placeholder="Ej: AshKetchum">
        </div>
        
        <div class="input-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">¡Yo te elijo! (Entrar)</button>
    </form>

    <div class="footer-link">
        ¿Eres un entrenador nuevo? <br>
        <a href="index.php?accion=alta">Regístrate aquí</a>
    </div>
</div>

</body>
</html>