CREATE TABLE usuario (
  id_usuario int AUTO_INCREMENT PRIMARY KEY,
  login_usuario varchar(30) NOT NULL,
  password varchar(255) NOT NULL,
  perfil varchar(30) NOT NULL,
  estado_usuario tinyint(1) DEFAULT 1,
  ultimo_login datetime DEFAULT NULL,
  fecha_registro date DEFAULT curdate(),
  photo varchar(50) DEFAULT NULL
);

CREATE TABLE leyenda (
  id_leyenda int AUTO_INCREMENT PRIMARY KEY,
  desc_leyenda varchar(100) NOT NULL
);

CREATE TABLE cufd (
  id_cufd int AUTO_INCREMENT PRIMARY KEY,
  codigo_cufd varchar(100) NOT NULL,
  codigo_control varchar(50) NOT NULL,
  fecha_vigencia varchar(50) NOT NULL
);

CREATE TABLE cliente (
  id_cliente int AUTO_INCREMENT PRIMARY KEY,
  razon_social_cliente varchar(100) NOT NULL,
  nit_ci_cliente varchar(50) NOT NULL,
  direccion_cliente varchar(100) NOT NULL,
  nombre_cliente varchar(100) NOT NULL,
  telefono_cliente varchar(50) NOT NULL,
  email_cliente varchar(50) NOT NULL
);

CREATE TABLE factura (
  id_factura int AUTO_INCREMENT PRIMARY KEY,
  codigo_factura varchar(30) NOT NULL,
  id_cliente int(11) NOT NULL,
  detalle text NOT NULL,
  neto decimal(10,2) NOT NULL,
  descuento decimal(10,2) NOT NULL,
  total decimal(10,2) NOT NULL,
  fecha_emicion datetime NOT NULL,
  cufd varchar(100) NOT NULL,
  cuf varchar(200) NOT NULL,
  xml text NOT NULL,
  id_punto_venta int(11) NOT NULL,
  id_usuario int(11) NOT NULL,
  usario varchar(50) NOT NULL,
  leyenda text DEFAULT NULL,
  estado_factura tinyint(1) DEFAULT 1,
);

CREATE TABLE producto (
  id_producto int AUTO_INCREMENT PRIMARY KEY,
  cod_producto varchar(50) NOT NULL,
  cod_producto_sin int(11) NOT NULL,
  nombre_producto varchar(100) NOT NULL,
  precio_producto decimal(10,2) NOT NULL,
  unidad_medida varchar(30) NOT NULL,
  unidad_medida_sin int(11) NOT NULL,
  imagen_producto varchar(50) NOT NULL,
  disponible tinyint(1) NOT NULL DEFAULT 1
);
