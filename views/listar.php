<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Mi Pokedex</h2>
<a href="index.php?action=crear">Capturar otro</a>

<table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%; text-align: center;">
    <thead>
        <tr style="background-color: #eee;">
            <th>ID</th>
            <th>Nombre</th>
            <th>Tipos</th>
            <th>Stats</th>
            <th>Rareza</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pkmn as $p): ?>
            <?php $s = $p->getStats(); ?>
            <tr>
                <td><?= $p->getId() ?></td>
                <td class="<?= $p->getShiny() ? 'nombre-shiny' : '' ?>">
                    <strong><?= $p->getNombre() ?></strong>
                </td>
                <td>
                    <?= $p->getTipo1() ?> <?= $p->getTipo2() ? "/ " . $p->getTipo2() : "" ?>
                </td>
                <td>
                    HP: <?= $s['hp'] ?> | AT: <?= $s['ataque'] ?> | DF: <?= $s['defensa'] ?>
                </td>
                <td><?= $p->getRareza() ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>