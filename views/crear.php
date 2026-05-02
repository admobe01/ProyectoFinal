<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Capturar Nuevo Pokémon</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; border-top: 10px solid #ff4444; }
        h2 { text-align: center; color: #333; margin-bottom: 1.5rem; }
        label { display: block; font-size: 0.8rem; font-weight: bold; color: #666; margin-bottom: 5px; }
        input, select { width: 100%; padding: 0.8rem; margin-bottom: 1.5rem; border: 2px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-group { display: flex; gap: 10px; }
        .btn { flex: 1; padding: 1rem; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; text-decoration: none; text-align: center; }
        .btn-submit { background: #ff4444; color: white; }
        .btn-cancel { background: #eee; color: #666; }
    </style>
</head>
<body>

<div class="card">
    <h2>Registrar Captura</h2>
    <form action="index.php?accion=crear" method="POST">
        <label>Mote del Pokémon</label>
        <input type="text" name="nombre" placeholder="¿Cómo se llama?" required>

        <?php $tipos = ["Acero", "Agua", "Bicho", "Dragon", "Electrico", "Fantasma", "Fuego", "Hada", "Hielo", "Lucha", "Normal", "Planta", "Psiquico", "Roca", "Siniestro", "Tierra", "Veneno", "Volador"]; ?>

        <label>Tipo Principal</label>
        <select name="tipo1" required>
            <?php foreach($tipos as $t): ?>
                <option value="<?= $t ?>"><?= $t ?></option>
            <?php endforeach; ?>
        </select>

        <label>Tipo Secundario (Opcional)</label>
        <select name="tipo2">
            <option value="">Ninguno</option>
            <?php foreach($tipos as $t): ?>
                <option value="<?= $t ?>"><?= $t ?></option>
            <?php endforeach; ?>
        </select>

        <div class="btn-group">
            <a href="index.php" class="btn btn-cancel">Volver</a>
            <button type="submit" class="btn btn-submit">Capturar</button>
        </div>
    </form>
</div>

</body>
</html>