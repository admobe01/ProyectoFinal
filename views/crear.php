<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Capturar Nuevo Pokémon</h2>

<form action="index.php?action=guardar" method="POST">
    <div>
        <label>Nombre del Pokémon:</label><br>
        <input type="text" name="nombre" required placeholder="Ej: Pikachu">
    </div>
    <br>
    <div>
        <label>Tipo 1:</label><br>
        <select name="tipo1" required>
            <option value="Fuego">Fuego</option>
            <option value="Agua">Agua</option>
            <option value="Planta">Planta</option>
            <option value="Electrico">Eléctrico</option>
            <option value="Normal">Normal</option>
        </select>
    </div>
    <br>
    <div>
        <label>Tipo 2 (Opcional):</label><br>
        <input type="text" name="tipo2" placeholder="Ej: Volador">
    </div>
    <br>
    <button type="submit">¡Lanzar Pokéball!</button>
</form>

<br>
<a href="index.php?action=listar">Ver mi Pokedex</a>
</body>
</html>
