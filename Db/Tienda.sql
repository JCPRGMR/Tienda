-- Active: 1740008239233@@127.0.0.1@3306@tienda
DROP DATABASE IF EXISTS TIENDA;
CREATE DATABASE TIENDA;
USE TIENDA;

-- CREACION DE LA BASE 
CREATE TABLE productos(
    id_producto bigint primary key auto_increment,
    cod_barra text,
    name_product text,
    marca text,
    detalles text,
    producto_create datetime default current_timestamp not null,
    producto_update datetime on update current_timestamp not null
);
CREATE TABLE categorias(
    id_categoria int primary key auto_increment,
    des_categoria varchar(50),
    categoria_create datetime default current_timestamp not null,
    categoria_update datetime on update current_timestamp not null
);
CREATE TABLE productos_categorias(
    id_fk_producto bigint not null,
    id_fk_categoria int not null,
    producto_categoria_create datetime default current_timestamp not null,
    producto_categoria_update datetime on update current_timestamp not null,
    foreign key (id_fk_producto) references productos(id_producto) on delete cascade,
    foreign key (id_fk_categoria) references categorias(id_categoria) on delete cascade
);
CREATE TABLE presentaciones(
    id_presentacion int primary key auto_increment,
    des_presentacion varchar(25) not null,
    presentacion_create datetime default current_timestamp not null,
    presentacion_update datetime on update current_timestamp not null
);
CREATE TABLE productos_presentaciones(
    id_fk_producto bigint not null,
    id_fk_presentacion int not null,
    cantidad int not null default 1,
    producto_presentacion_create datetime default current_timestamp not null,
    producto_presentacion_update datetime on update current_timestamp not null,
    foreign key (id_fk_producto) references productos(id_producto) on delete cascade,
    foreign key (id_fk_presentacion) references presentaciones(id_presentacion) on delete cascade
);
CREATE TABLE tipos_precios(
    id_tipo_precio int primary key auto_increment,
    des_tipo_precio varchar(25),
    tipo_precio_create datetime default current_timestamp not null,
    tipo_precio_update datetime on update current_timestamp not null
);
CREATE TABLE historial_precios(
    id_historial_precio bigint primary key auto_increment,
    id_fk_producto bigint not null,
    id_fk_tipo_precio int not null,
    valor_precio decimal not null,
    precio_create datetime default current_timestamp not null,
    precio_update datetime on update current_timestamp not null,
    foreign key (id_fk_producto) references productos(id_producto) on delete cascade,
    foreign key (id_fk_tipo_precio) references tipos_precios(id_tipo_precio) on delete cascade
);
CREATE TABLE personas(
    id_persona bigint primary key auto_increment,
    identificacion varchar(100) not null,
    nombres varchar(50) not null,
    apellidos varchar(100),
    persona_create datetime default current_timestamp not null,
    persona_update datetime on update current_timestamp not null
);
CREATE TABLE empresas(
    id_empresa int primary key auto_increment,
    nom_empresa varchar(50) not null,
    NIT varchar(100) not null,
    direccion text,
    empresa_create datetime default current_timestamp not null,
    empresa_update datetime on update current_timestamp not null
);
CREATE TABLE proveedores(
    id_proveedor int primary key auto_increment,
    id_fk_persona bigint not null,
    id_fk_empresa int not null,
    foreign key (id_fk_persona) references personas(id_persona) on delete cascade,
    foreign key (id_fk_empresa) references empresas(id_empresa) on delete cascade
);
CREATE TABLE clientes(
    id_cliente int primary key auto_increment,
    id_fk_persona bigint not null,
    prestamo decimal default 0,
    estado varchar(25),
    cliente_create datetime default current_timestamp,
    cliente_update datetime on update current_timestamp,
    foreign key (id_fk_persona) references personas(id_persona) on delete cascade
);
CREATE TABLE celulares(
    id_celular bigint primary key auto_increment,
    id_fk_persona bigint not null,
    celular varchar(25),
    prefijo varchar(10),
    linea varchar(25),
    celular_create datetime default current_timestamp,
    celular_update datetime on update current_timestamp,
    foreign key (id_fk_persona) references personas(id_persona) on delete cascade
);
CREATE TABLE empleados(
    id_empleado int primary key auto_increment,
    id_fk_persona bigint not null,
    cargo varchar(25),
    sueldo decimal,
    empleado_create datetime default current_timestamp,
    empleado_update datetime on update current_timestamp,
    foreign key (id_fk_persona) references personas(id_persona) on delete cascade
);
CREATE TABLE usuarios(
    id_usuario int primary key auto_increment,
    nom_usuario varchar(25),
    clave text,
    rol varchar(25),
    estado tinyint default 1,
    usuario_create datetime default current_timestamp,
    usuario_update datetime on update current_timestamp
);
CREATE TABLE ventas(
    id_venta bigint primary key auto_increment,
    venta_cantidad_total int not null,
    venta_precio_total decimal not null,
    id_fk_empleado int not null,
    id_fk_cliente int not null,
    venta_create datetime default current_timestamp,
    venta_update datetime on update current_timestamp,
    foreign key (id_fk_empleado) references empleados(id_empleado) on delete cascade,
    foreign key (id_fk_cliente) references clientes(id_cliente) on delete cascade
);
CREATE TABLE ventas_productos(
    id_fk_venta bigint not null,
    id_fk_producto bigint not null,
    vp_cantidad int,
    vp_precio_unidad decimal not null,
    vp_precio_total decimal not null,
    venta_productos_create datetime default current_timestamp,
    venta_productos_update datetime on update current_timestamp,
    foreign key (id_fk_venta) references ventas(id_venta) on delete cascade,
    foreign key (id_fk_producto) references productos(id_producto) on delete cascade
);
CREATE TABLE compras(
    id_compra bigint primary key auto_increment,
    compra_cantidad_total int not null,
    compra_precio_total decimal,
    id_fk_empleado int not null,
    id_fk_proveedor int not null,
    compra_create datetime default current_timestamp,
    compra_update datetime on update current_timestamp,
    foreign key (id_fk_empleado) references empleados(id_empleado) on delete cascade,
    foreign key (id_fk_proveedor) references proveedores(id_proveedor) on delete cascade
);
CREATE TABLE compras_productos(
    id_fk_compra bigint not null,
    id_fk_producto bigint not null,
    cp_cantidad int not null,
    cp_precio_unidad decimal not null,
    cp_precio_total decimal not null,
    compras_productos_create datetime default current_timestamp,
    compras_productos_update datetime on update current_timestamp,
    foreign key (id_fk_compra) references compras(id_compra) on delete cascade,
    foreign key (id_fk_producto) references productos(id_producto) on delete cascade
);
CREATE TABLE pedidos(
    id_pedido bigint primary key auto_increment,
    pedido_cantidad int not null,
    pedido_precio_total decimal not null,
    f_entrega date not null,
    id_fk_proveedor int not null,
    id_fk_empleado int not null,
    pedido_create datetime default current_timestamp,
    pedido_update datetime on update current_timestamp
);
CREATE TABLE pedidos_productos(
    id_fk_pedido bigint not null,
    id_fk_producto bigint not null,
    pp_cantidad int not null,
    pp_precio_unidad decimal not null,
    pp_precio_total decimal not null,
    pedido_producto_create datetime default current_timestamp,
    pedido_producto_update datetime on update current_timestamp,
    foreign key (id_fk_pedido) references pedidos(id_pedido) on delete cascade,
    foreign key (id_fk_producto) references productos(id_producto) on delete cascade
);
CREATE TABLE invetario(
    id_inventario bigint primary key auto_increment,
    movimiento varchar(10), -- ('salida', 'entrada')
    inventario_cantidad int not null,
    id_fk_producto bigint not null,
    f_vencimiento date not null,
    inventario_create datetime default current_timestamp,
    inventario_update datetime on update current_timestamp,
    foreign key (id_fk_producto) references productos(id_producto) on delete cascade
);
CREATE TABLE existencias(
    id_existencia bigint primary key auto_increment,
    existencia_cantidad int not null, 
    id_fk_producto bigint not null,
    f_vencimiento date not null,
    existencia_create datetime default current_timestamp,
    existencia_update datetime on update current_timestamp,
    foreign key (id_fk_producto) references productos(id_producto) on delete cascade
);