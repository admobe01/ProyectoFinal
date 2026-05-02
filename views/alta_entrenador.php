<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokédex - Registro</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); width: 320px; border-top: 10px solid #3b4cca; text-align: center; }
        h2 { color: #333; }
        input { width: 100%; padding: 0.8rem; margin: 0.8rem 0; border: 2px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 1rem; background-color: #3b4cca; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #4a61e1; }
        .error { color: #cc0000; background: #ffe6e6; padding: 0.5rem; border-radius: 5px; margin-bottom: 1rem; font-size: 0.9rem; }
        .switch { margin-top: 1rem; font-size: 0.85rem; }
        .switch a { color: #cc0000; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="card">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Pok%C3%A9_Ball_icon.svg" alt="Pokeball" width="60">
    <h2>Nueva Licencia</h2>
    <p style="font-size: 0.9rem; color: #666;">Crea tu perfil de entrenador para empezar tu colección.</p>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?accion=alta" method="POST">
        <input type="text" name="usuario" placeholder="Elige tu nombre de usuario" required>
        <input type="password" name="password" placeholder="Crea una contraseña segura" required>
        <button type="submit">Comenzar Aventura</button>
    </form>

    <div class="switch">
        ¿Ya tienes una cuenta? <br>
        <a href="index.php?accion=login">Inicia sesión</a>
    </div>
</div>

</body>
</html>