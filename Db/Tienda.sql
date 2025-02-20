DROP DATABASE IF EXISTS TIENDA;
CREATE DATABASE TIENDA;
USE TIENDA;

-- Tabla: Tipo de Producto
CREATE TABLE tipo_producto (
    id_tipo INT PRIMARY KEY AUTO_INCREMENT,
    des_tipo VARCHAR(255),
    tipo_producto_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo_producto_update DATETIME ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: Clientes
CREATE TABLE clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nom_cliente VARCHAR(255),
    celular VARCHAR(15),
    prestamo_total DECIMAL(10,2) DEFAULT 0, -- Saldo del cliente
    cliente_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    cliente_update DATETIME ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: Empleados
CREATE TABLE empleados (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    nom_empleado VARCHAR(255),
    ape_empleado VARCHAR(255),
    celular VARCHAR(15),
    foto_empleado TEXT,
    empleado_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    empleado_update DATETIME ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: Empresas
CREATE TABLE empresas (
    id_empresa INT PRIMARY KEY AUTO_INCREMENT,
    nit VARCHAR(20) UNIQUE NOT NULL,
    nom_empresa VARCHAR(255),
    empresa_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    empresa_update DATETIME ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: Proveedores
CREATE TABLE proveedores (
    id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
    nom_proveedor VARCHAR(255),
    celular VARCHAR(15),
    proveedor_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    proveedor_update DATETIME ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: Productos
CREATE TABLE productos (
    id_producto BIGINT PRIMARY KEY AUTO_INCREMENT,
    cod_barra VARCHAR(50),  -- Puede ser NULL
    nom_producto VARCHAR(255),
    descripcion TEXT,
    foto_producto TEXT,
    precio_compra DECIMAL(10,2),
    precio_venta DECIMAL(10,2),
    fecha_vencimiento DATE DEFAULT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    tipo_empaque VARCHAR(50),
    id_fk_tipo INT,
    producto_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    producto_update DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_fk_tipo) REFERENCES tipo_producto(id_tipo) ON DELETE CASCADE 
);

-- Tabla: Usuarios (Solo para empleados)
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nom_usuario VARCHAR(50) UNIQUE,
    clave VARCHAR(255),
    rol VARCHAR(100),
    estado TINYINT,
    id_fk_empleado INT UNIQUE,
    usuario_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_update DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_fk_empleado) REFERENCES empleados(id_empleado) ON DELETE CASCADE
);

-- Tabla: Compras
CREATE TABLE compras (
    id_compra BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_fk_empresa INT,
    id_fk_proveedor INT,
    precio_total_compra DECIMAL(10,2),
    cantidad_comprada INT,
    fecha_compra DATETIME DEFAULT CURRENT_TIMESTAMP,
    compras_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    compras_update DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_fk_empresa) REFERENCES empresas(id_empresa) ON DELETE CASCADE,
    FOREIGN KEY (id_fk_proveedor) REFERENCES proveedores(id_proveedor) ON DELETE CASCADE
);

-- Tabla: Ventas
CREATE TABLE ventas (
    id_venta BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_fk_empleado INT,
    id_fk_cliente INT DEFAULT NULL, -- Puede ser una venta sin cliente (venta libre)
    precio_total_venta DECIMAL(10,2),
    cantidad_vendida INT,
    prestamo decimal(10,2),
    fecha_venta DATETIME DEFAULT CURRENT_TIMESTAMP,
    venta_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    venta_update DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_fk_empleado) REFERENCES empleados(id_empleado) ON DELETE CASCADE,
    FOREIGN KEY (id_fk_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE
);

-- Tabla: Compras_Productos (Relación entre compras y productos)
CREATE TABLE compras_productos (
    id_fk_compra BIGINT,
    id_fk_producto BIGINT,
    cantidad_pc INT,
    precio_total_pc DECIMAL(10,2),
    -- PRIMARY KEY (id_fk_compra, id_fk_producto),
    FOREIGN KEY (id_fk_compra) REFERENCES compras(id_compra) ON DELETE CASCADE,
    FOREIGN KEY (id_fk_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
);

-- Tabla: Ventas_Productos (Relación entre ventas y productos)
CREATE TABLE ventas_productos (
    id_fk_venta BIGINT,
    id_fk_producto BIGINT,
    cantidad_pv INT,
    precio_total_pv DECIMAL(10,2),
    -- PRIMARY KEY (id_fk_venta, id_fk_producto),
    FOREIGN KEY (id_fk_venta) REFERENCES ventas(id_venta) ON DELETE CASCADE,
    FOREIGN KEY (id_fk_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
);