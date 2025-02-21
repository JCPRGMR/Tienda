-- Active: 1740008239233@@127.0.0.1@3306@tienda
-- SELECT * FROM empleados;


-- Posible vista para ver usuaris_empleados
CREATE VIEW view_empleados_usuarios
AS
SELECT * FROM empleados 
INNER JOIN usuarios ON empleados.id_empleado = usuarios.id_fk_empleado;

-- SELECT * FROM view_empleados_usuarios

-- SELECT * FROM empleados;