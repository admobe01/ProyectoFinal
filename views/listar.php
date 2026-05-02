<?php 
$bg_color = $_COOKIE['pokedex_color'] ?? '#f4f4f9'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex Procedural</title>
<style>
    /* --- ESTILOS GENERALES --- */
    body {
        background-color: <?php echo $bg_color; ?> !important; /* Persistencia del tema */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 20px;
        color: #333;
        transition: background-color 0.5s ease;
    }

    /* --- CABECERA Y ACCIONES (NUEVO LAYOUT) --- */
    .pokedex-header {
        text-align: center;
        margin-bottom: 60px; /* Aire antes de las tarjetas */
    }

    .pokedex-header h1 {
        margin-bottom: 5px;
    }

    .header-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 30px; /* Aire entre el botón de capturar y los ajustes */
        margin-top: 20px;
    }

    /* Botones y Enlaces de la Cabecera */
    .btn-capturar {
        background-color: #ff4444;
        color: white;
        padding: 15px 40px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 5px 15px rgba(255, 68, 68, 0.4);
        transition: transform 0.2s;
        display: inline-block;
    }

    .btn-capturar:hover {
        transform: scale(1.05);
    }

    .guest-msg {
        font-size: 1.1em;
        color: #555;
    }

    .link-auth {
        color: #ff4444;
        font-weight: bold;
        text-decoration: none;
    }

    /* Barra Inferior (Ajustes y Usuario) */
    .settings-bar {
        background: rgba(255, 255, 255, 0.95);
        padding: 12px 30px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 40px; /* Aire entre Temas y Usuario */
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #eee;
    }

    .theme-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .color-options {
        display: flex;
        gap: 8px;
    }

    .color-dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s, border-color 0.2s;
        display: inline-block;
    }

    .color-dot:hover {
        transform: scale(1.2);
        border-color: #ccc;
    }

    /* Colores de las Piedras de Tema */
    .default { background-color: #f4f4f9; }
    .electric { background-color: #ffeb3b; }
    .fire { background-color: #ffcdd2; }
    .water { background-color: #bbdefb; }
    .grass { background-color: #c8e6c9; }

    /* Badge del Usuario Logueado */
    .user-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        border-left: 2px solid #ddd;
        padding-left: 20px;
    }

    .user-name {
        font-size: 0.95em;
        font-weight: 600;
        color: #444;
    }

    .logout-x {
        color: #ff4444;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1em;
        transition: transform 0.2s;
    }
    
    .logout-x:hover { transform: scale(1.2); }

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
        text-align: center;
    }

    .types-row {
        margin-bottom: 15px;
        text-align: center;
    }

    .type-pill {
    display: inline-block;
    padding: 5px 15px;
    border-radius: 15px;
    font-size: 0.8em;
    font-weight: bold;
    color: white;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    margin: 0 2px;
    text-transform: uppercase;
    }


    .type-acero      { background-color: #B7B7CE; }
    .type-agua       { background-color: #6390F0; }
    .type-bicho      { background-color: #A6B91A; }
    .type-dragon     { background-color: #6F35FC; }
    .type-electrico  { background-color: #F7D02C; color: #333; text-shadow: none; } /* Texto oscuro para mejor lectura */
    .type-fantasma   { background-color: #735797; }
    .type-fuego      { background-color: #EE8130; }
    .type-hada       { background-color: #D685AD; }
    .type-hielo      { background-color: #96D9D6; color: #333; text-shadow: none; }
    .type-lucha      { background-color: #C22E28; }
    .type-normal     { background-color: #A8A77A; } 
    .type-planta     { background-color: #7AC74C; }
    .type-psiquico   { background-color: #F95587; }
    .type-roca       { background-color: #B6A136; }
    .type-siniestro  { background-color: #705746; }
    .type-tierra     { background-color: #E2BF65; }
    .type-veneno     { background-color: #6B246B; }
    .type-volador    { background-color: #A98FF3; }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        background: #f8f8f8;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 15px;
        text-align: center;
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

    /* Acciones en la Tarjeta */
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

<header class="pokedex-header">
    <h1>Mi Pokédex Procedural</h1>

    <div class="header-container">
        <!-- 1. Fila de Acción Principal (Privada vs Pública) -->
        <div class="action-row">
            <?php if (isset($_SESSION['entrenador_id'])): ?>
                <!-- Funcionalidad exclusiva: Solo aparece si está autenticado[cite: 1] -->
                <a href="index.php?accion=crear" class="btn-capturar">Capturar Nuevo Pokémon</a>
            <?php else: ?>
                <!-- Mensaje para invitados -->
                <p class="guest-msg">
                    <a href="index.php?accion=login" class="link-auth">Inicia sesión</a> para gestionar tu colección.
                </p>
            <?php endif; ?>
        </div>

        <!-- 2. Barra de Ajustes y Usuario (Persistencia y Sesión) -->
        <div class="settings-bar">
            
            <!-- Selector de Temas (Persistencia mediante Cookies) -->
            <div class="theme-wrapper">
                <span>Tema:</span>
                <div class="color-options">
                    <a href="index.php?accion=cambiarColor&color=#f4f4f9" class="color-dot default" title="Normal"></a>
                    <a href="index.php?accion=cambiarColor&color=#ffeb3b" class="color-dot electric" title="Eléctrico"></a>
                    <a href="index.php?accion=cambiarColor&color=#ffcdd2" class="color-dot fire" title="Fuego"></a>
                    <a href="index.php?accion=cambiarColor&color=#bbdefb" class="color-dot water" title="Agua"></a>
                    <a href="index.php?accion=cambiarColor&color=#c8e6c9" class="color-dot grass" title="Planta"></a>
                </div>
            </div>

            <?php if (isset($_SESSION['entrenadorNombre'])): ?>
                <div class="user-badge">
                    <span class="user-name"><?php echo $_SESSION['entrenadorNombre']; ?></span>
                    <a href="index.php?accion=logout" class="logout-x" title="Cerrar Sesión">✕</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
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
                    <?php 
                    // 1. Usamos el ID único del Pokémon para fijar el azar
                    srand($p->getId()); 
                    $idVisualFijo = rand(1, 1025); 
                    
                    // 2. IMPORTANTE: Reseteamos la semilla para no afectar a otros procesos de PHP
                    srand(); 

                    if($p->getShiny()): 
                    ?>
                        <div class="particles">✨</div>
                        <!-- Sprite Shiny Aleatorio (pero fijo para este ID) -->
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/<?php echo $idVisualFijo; ?>.png" alt="Sprite Shiny" class="pkmn-sprite">
                    <?php else: ?>
                        <!-- Arte Oficial Aleatorio (pero fijo para este ID) -->
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?php echo $idVisualFijo; ?>.png" alt="Arte Oficial" class="pkmn-sprite">
                    <?php endif; ?>
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
                    <?php 
                    // Mapeo de nombres de la base de datos a siglas clásicas
                    $siglas = [
                        'hp'              => 'HP',
                        'ataque'          => 'ATT',
                        'defensa'         => 'DEF',
                        'ataqueEspecial'  => 'S.ATT',
                        'defensaEspecial' => 'S.DEF',
                        'velocidad'       => 'VEL'
                    ];

                    foreach ($p->getStats() as $nombre => $valor): 
                        // Usamos la sigla definida o el nombre en mayúsculas como plan B
                        $etiqueta = $siglas[$nombre] ?? strtoupper($nombre);
                    ?>
                        <div class="stat-item">
                            <span class="stat-label"><?php echo $etiqueta; ?></span>
                            <span class="stat-value"><?php echo $valor; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
<div class="card-actions">
    <?php 
    // Ahora permitimos gestionar si es el DUEÑO o si tiene rango de ADMIN
    $esSuEntrenador = (isset($_SESSION['entrenador_id']) && $p->getEntrenadorId() == $_SESSION['entrenador_id']);
    $esAdmin  = (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1);

    if ($esSuEntrenador || $esAdmin): 
    ?>
        <a href="index.php?accion=editar&id=<?php echo $p->getId(); ?>" class="action-link" title="Editar Mote">📝</a>
        <a href="index.php?accion=eliminar&id=<?php echo $p->getId(); ?>" 
           class="action-link" 
           onclick="return confirm('¿Seguro que quieres liberar a <?php echo $p->getNombre(); ?>?')" 
           title="Liberar">🗑️</a>
    <?php else: ?>
        <span style="color: #ccc; font-size: 0.7em;">Solo lectura</span>
    <?php endif; ?>
</div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

</body>
</html>