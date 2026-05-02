<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokédex - Acceso</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); width: 320px; border-top: 10px solid #cc0000; text-align: center; }
        h2 { color: #333; }
        input { width: 100%; padding: 0.8rem; margin: 0.8rem 0; border: 2px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 1rem; background-color: #cc0000; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #ff0000; }
        .error { color: #cc0000; background: #ffe6e6; padding: 0.5rem; border-radius: 5px; margin-bottom: 1rem; font-size: 0.9rem; }
        .switch { margin-top: 1rem; font-size: 0.85rem; }
        .switch a { color: #3b4cca; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="card">
    <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/International_Pok%C3%A9mon_logo.svg" alt="Pokemon" width="120">
    <h2>Acceso de Entrenador</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?accion=login" method="POST">
        <input type="text" name="usuario" placeholder="Nombre de Entrenador" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">¡Yo te elijo! (Entrar)</button>
    </form>

    <div class="switch">
        ¿Eres nuevo en la región? <br>
        <a href="index.php?accion=alta">Regístrate aquí</a>
    </div>
</div>

</body>
</html>