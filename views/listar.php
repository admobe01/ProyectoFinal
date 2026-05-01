<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex Procedural</title>
    <style>
        /* --- ESTILOS GENERALES --- */
        body {
            background-color: #f4f4f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-capturar {
            background-color: #ff4444;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(255, 68, 68, 0.3);
            transition: background 0.3s;
        }

        .btn-capturar:hover {
            background-color: #cc0000;
        }

        /* --- GRID DE LA POKÉDEX --- */
        .pokedex-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* --- TARJETA DEL POKÉMON --- */
        .pkmn-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            position: relative;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .pkmn-card:hover {
            transform: translateY(-10px);
        }

        /* Cabecera de la tarjeta */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .pkmn-id {
            font-weight: bold;
            color: #bbb;
            font-size: 1.2em;
        }

        /* Badges de Rareza */
        .badge {
            font-size: 0.7em;
            padding: 4px 10px;
            border-radius: 12px;
            text-transform: uppercase;
            font-weight: bold;
            color: white;
        }
        .badge-comun { background: #919191; }
        .badge-pseudolegendario { background: #4a90e2; }
        .badge-mitico { background: #a33ea1; }
        .badge-legendario { 
            background: linear-gradient(45deg, #ff4400, #ffcc00); 
            box-shadow: 0 0 8px rgba(255, 68, 0, 0.5);
        }

        /* Contenedor del Sprite */
        .sprite-container {
            background: #f9f9f9;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .pkmn-sprite {
            width: 100px;
            height: 100px;
            z-index: 2;
        }

        /* Efecto Shiny */
        .is-shiny {
            border: 2px solid #ffd700;
            background: linear-gradient(135deg, #fffdf5 0%, #ffffff 100%);
        }

        .particles {
            position: absolute;
            top: 0;
            width: 100%;
            text-align: center;
            font-size: 1.5em;
            animation: bounce 1.5s infinite;
            z-index: 1;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); opacity: 0.5; }
            50% { transform: translateY(-10px); opacity: 1; }
        }

        /* Nombre y Tipos */
        .pkmn-name {
            margin: 10px 0;
            font-size: 1.5em;
            text-transform: capitalize;
        }

        .types-row {
            margin-bottom: 15px;
        }

        .type-pill {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
            color: white;
            background: #ccc;
            margin: 0 2px;
            text-transform: uppercase;
        }

        /* Colores por tipo (añade los que necesites) */
        .type-fuego { background-color: #ff4422; }
        .type-agua { background-color: #3399ff; }
        .type-planta { background-color: #77cc55; }
        .type-electrico { background-color: #ffcc33; }
        .type-psiquico { background-color: #ff5599; }
        .type-normal { background-color: #aaaa99; }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            background: #f8f8f8;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 0.6em;
            color: #888;
            font-weight: bold;
        }

        .stat-value {
            font-size: 0.9em;
            font-weight: bold;
        }

        /* Acciones */
        .card-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .action-link {
            text-decoration: none;
            font-size: 1.2em;
            transition: transform 0.2s;
        }

        .action-link:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>

<header>
    <h1>Mi Pokédex Procedural</h1>
    <a href="index.php?accion=crear" class="btn-capturar">Capturar Nuevo Pokémon</a>
</header>

<main class="pokedex-grid">
    <?php if (empty($pkmn)): ?>
        <p style="text-align: center; grid-column: 1 / -1;">No has capturado ningún Pokémon todavía.</p>
    <?php else: ?>
        <?php foreach ($pkmn as $p): ?>
            <div class="pkmn-card <?php echo $p->getShiny() ? 'is-shiny' : ''; ?>">
                
                <div class="card-header">
                    <span class="pkmn-id">#<?php echo str_pad($p->getId(), 3, "0", STR_PAD_LEFT); ?></span>
                    <span class="badge badge-<?php echo strtolower(str_replace(' ', '', $p->getRareza())); ?>">
                        <?php echo $p->getRareza(); ?>
                    </span>
                </div>

                <div class="sprite-container">
                    <?php if($p->getShiny()): ?>
                        <div class="particles">✨</div>
                    <?php endif; ?>
                    <!-- Robohash genera un sprite único basado en el ID -->
                    <img src="https://robohash.org/<?php echo $p->getId(); ?>?set=set2&size=150x150" alt="Sprite" class="pkmn-sprite">
                </div>

                <h2 class="pkmn-name"><?php echo $p->getNombre(); ?></h2>

                <div class="types-row">
                    <span class="type-pill type-<?php echo strtolower($p->getTipo1()); ?>">
                        <?php echo $p->getTipo1(); ?>
                    </span>
                    <?php if ($p->getTipo2()): ?>
                        <span class="type-pill type-<?php echo strtolower($p->getTipo2()); ?>">
                            <?php echo $p->getTipo2(); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="stats-grid">
                    <?php foreach ($p->getStats() as $nombre => $valor): ?>
                        <div class="stat-item">
                            <span class="stat-label"><?php echo strtoupper(substr($nombre, 0, 3)); ?></span>
                            <span class="stat-value"><?php echo $valor; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="card-actions">
                    <a href="index.php?accion=editar&id=<?php echo $p->getId(); ?>" class="action-link" title="Editar Mote">📝</a>
                    <a href="index.php?accion=eliminar&id=<?php echo $p->getId(); ?>" 
                       class="action-link" 
                       onclick="return confirm('¿Seguro que quieres liberar a <?php echo $p->getNombre(); ?>?')" 
                       title="Liberar">🗑️</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

</body>
</html>