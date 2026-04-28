<!DOCTYPE html>
<html>
<head>
  <title>Listado de Productos</title>
</head>
<body>
   <div style="background-color: #f0f0f0; padding: 10px; margin-bottom: 20px;">
       <?php if (isset($_SESSION['usuario_id'])): ?>
          Bienvenido, <b><?= $_SESSION['usuario_email'] ?></b> |
           <a href="index.php?accion=logout">Cerrar Sesión</a>
       <?php else: ?>
           <a href="index.php?accion=login">Iniciar Sesión</a> | 
           <a href="index.php?accion=registro">Registrarse</a>
       <?php endif; ?>
   </div>
 
  <h1>Productos</h1>
 
   <?php if (isset($_SESSION['usuario_id'])): ?>
       <a href="index.php?accion=crear">Agregar Producto</a><br><br>
   <?php endif; ?>
 
   <table border="1" cellpadding="10">
       <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Eléctrica</th>
           <?php if (isset($_SESSION['usuarioId'])): ?>
              <th>Acciones</th>
           <?php endif; ?>
       </tr>
 
       <?php foreach ($productos as $p): ?>
       <tr>
          <td><?= $p->getId() ?></td>
          <td><?= $p->getNombre() ?></td>
          <td><?= $p->getPrecio() ?></td>
          <td><?= ($p->getElectrica() == 0) ? "Muscular" : "Eléctrica"; ?></td>
          
           <?php if (isset($_SESSION['usuarioId'])): ?>
           <td>
               <a href="index.php?accion=editar&id=<?= $p->getId() ?>">Editar</a>
               |
               <a href="index.php?accion=eliminar&id=<?= $p->getId() ?>">Eliminar</a>
          </td>
           <?php endif; ?>
       </tr>
       <?php endforeach; ?>
 
   </table>
</body>
</html>