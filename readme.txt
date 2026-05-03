
INSERT INTO pokemon (nombre, tipo1, tipo2, hp, ataque, defensa, ataque_esp, defensa_esp, velocidad, rareza, shiny, entrenador_id) 
VALUES 
('test1', 'Planta',   'Veneno', 45, 49, 49, 65, 65, 45, 'Comun', 0, 2),
('test2', 'Fuego',    NULL,     60, 70, 55, 80, 60, 75, 'Comun', 0, 2),
('test3', 'Agua',     NULL,     85, 90, 80, 85, 80, 95, 'PseudoLegendario', 1, 2),
('test4', 'Psiquico', 'Tierra',    106, 110, 90, 154, 90, 130, 'Legendario', 0, 2),
('test5', 'Electrico', 'Agua',   100, 100, 100, 100, 100, 100, 'Mitico', 1, 2);

Buenas, para que todo el script funcione adecudamente necesitas implementar el archivo "Pokedex.sql" en MyAdminPhp, este ya viene con bastantes
entradas Pokemon.

A continuacion, puede iniciar sesion mediante el usuario "admin" y contraseña  "test", este tiene control total sobre las funciones de los
pokemon.

Tambien esta implementado el usuario "adrian" con contraseña "1234", este como cualquier otro usuario a excepcion del admin solo puede
editar los pkmn capturados por si mismo

Ademas puede probar la insercion que esta indicada arriba para hacer unas implentaciones controladas