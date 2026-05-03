<?php 
$bg_color = $_COOKIE['pokedex_color'] ?? '#f4f4f9'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokédex - Editar Mote</title>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background-color: <?php echo $bg_color; ?>; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
            transition: background-color 0.5s ease;
        }
        .card { 
            background: white; 
            padding: 2rem; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 350px; 
            border-top: 10px solid #3b4cca; 
            text-align: center; 
        }
        .pkmn-preview {
            background: #f8f8f8;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        h2 { color: #333; margin-bottom: 5px; }
        p { color: #666; font-size: 0.9em; margin-bottom: 20px; }
        input { 
            width: 100%; 
            padding: 0.8rem; 
            margin: 0.8rem 0; 
            border: 2px solid #ddd; 
            border-radius: 8px; 
            box-sizing: border-box; 
            font-size: 1em;
        }
        .btn-save { 
            width: 100%; 
            padding: 1rem; 
            background-color: #3b4cca; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.3s; 
        }
        .btn-save:hover { background-color: #2a3a8c; }
        .cancel-link { 
            display: block; 
            margin-top: 15px; 
            color: #888; 
            text-decoration: none; 
            font-size: 0.85em; 
        }
        .cancel-link:hover { color: #cc0000; }
    </style>
</head>
<body>

<div class="card">
    <div class="pkmn-preview">
        <?php 
            srand($pkmn->getId());
            $idVisual = rand(1, 1025);
            srand();
        ?>
        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/<?php echo $idVisual; ?>.png" width="80">
    </div>

    <h2>Editar Mote</h2>
    <p>Estás editando a <strong><?php echo $pkmn->getNombre(); ?></strong></p>

    <!-- CAMBIO 1: Añadimos &page al action del formulario[cite: 1] -->
    <form action="index.php?accion=editar&id=<?php echo $pkmn->getId(); ?>&page=<?php echo $paginaOrigen; ?>" method="POST">
        <label for="nombre" style="display:block; text-align:left; font-size: 0.8em; color: #888;">NUEVO NOMBRE:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $pkmn->getNombre(); ?>" required autofocus>
        
        <button type="submit" class="btn-save">Guardar Cambios</button>
    </form>

    <!-- CAMBIO 2: Añadimos ?page al enlace de cancelar[cite: 1] -->
    <a href="index.php?page=<?php echo $paginaOrigen; ?>" class="cancel-link">Volver sin cambios</a>
</div>

</body>
</html>