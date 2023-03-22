<?php
$db = new PDO("mysql:host=127.0.0.1;dbname=evaluacion;charset=utf8mb4", "root", "",[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$idProducto=$_GET['idProducto'];
$consulta = $db->prepare("SELECT * FROM productos INNER JOIN productos_depositos ON productos.idProducto = productos_depositos.idProducto WHERE productos.idProducto LIKE '".$idProducto."'");
$consulta->execute();
$producto = $consulta->fetchAll(PDO::FETCH_ASSOC);
foreach($producto as $product){
    $array_datos['idCategoria']=$product['idCategoria'];
    $array_datos['nombre']=$product['nombre'];
    $array_datos['descripcion']=$product['descripcion'];
    $array_datos['moneda']=$product['moneda'];
    $array_datos['precio']=$product['precio'];
    $array_datos['habilitado']=$product['habilitado'];
    $array_datos[$product['idDeposito']]['disponibles']=$product['disponibles'];
    $array_datos[$product['idDeposito']]['stock_minimo']=$product['stock_minimo'];
}
echo json_encode($array_datos);