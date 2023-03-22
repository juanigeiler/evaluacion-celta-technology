<?php
$db = new PDO("mysql:host=127.0.0.1;dbname=evaluacion;charset=utf8mb4", "root", "",[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); ?>
<!doctype html>
<html lang="es" id="page">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.tiny.cloud/1/2qg5f7f0v50ejby1rxnik4pl7ycrmbjb63pjeofwkht6xidx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    </head>
    <body><?php
        if(isset($_POST['guardar'])){
            $update_producto = $db->prepare("UPDATE productos SET nombre=:0, descripcion=:1, moneda=:2, precio=:3 WHERE idProducto LIKE '".$_POST['guardar']."'");
            $update_producto->bindParam(':0', $_POST["nombre"]);
            $update_producto->bindParam(':1', $_POST["descripcion"]);
            $update_producto->bindParam(':2', $_POST["moneda"]);
            $update_producto->bindParam(':3', $_POST["precio"]);
            //$update_producto->bindParam(':4', $_POST["idCategoria"]);
            $update_producto->execute();
            ?><meta http-equiv="Refresh" content="0;URL=/evaluacion/listado_productos.php"><?php 
        }
        if(isset($_POST['eliminar'])){
            $eliminar_producto = $db->prepare("UPDATE productos SET habilitado='0' WHERE idProducto LIKE '".$_POST['eliminar']."'");
            $eliminar_producto->execute();
            ?><meta http-equiv="Refresh" content="0;URL=/evaluacion/listado_productos.php"><?php 
        }
        if(isset($_POST['habilitar'])){
            $eliminar_producto = $db->prepare("UPDATE productos SET habilitado='1' WHERE idProducto LIKE '".$_POST['habilitar']."'");
            $eliminar_producto->execute();
            ?><meta http-equiv="Refresh" content="0;URL=/evaluacion/listado_productos.php"><?php 
        }?>
        <div class="container-fluid">
            <div class="modal fade" id="modalMod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleM">Modificar producto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col-sm-3">
                                        <label for="">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">Descripcion</label>
                                        <input type="text" name="descripcion" id="descripcion" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="">Categoria</label><?php
                                        $consulta_categoria = $db->prepare("SELECT * FROM categorias");
                                        $consulta_categoria->execute();
                                        $categoria = $consulta_categoria->fetchAll(PDO::FETCH_ASSOC);?>
                                        <select name="idCategoria" id="idCategoria" class="form-control form-control-sm" disabled><?php
                                            foreach($categoria as $cat){?>
                                                <option id="cat-<?php echo $cat['idCategoria']?>" value=""><?php echo $cat['nombre']?></option><?php
                                            }?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="">Moneda</label>
                                        <input type="text" name="moneda" id="moneda" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="">Precio</label>
                                        <input type="text" name="precio" id="precio" class="form-control form-control-sm">
                                    </div>
                                </div><?php
                                $consulta_depositos = $db->prepare("SELECT * FROM depositos");
                                $consulta_depositos->execute();
                                $depositos = $consulta_depositos->fetchAll(PDO::FETCH_ASSOC);
                                foreach($depositos as $d){?>
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            <label for="">Deposito</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $d['nombre']." - ".$d['direccion']?>" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="">Stock disponible</label>
                                            <input type="number" class="form-control form-control-sm" name="disponibles" id="depo<?php echo $d['idDeposito']?>dispo" value="">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="">Stock mínimo</label>
                                            <input type="number" class="form-control form-control-sm" name="stock_minimo" id="depo<?php echo $d['idDeposito']?>minimo" value="">
                                        </div>
                                    </div><?php
                                }?>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger btn-center" id="idProducto_el" name="eliminar">Eliminar</button>
                                <button type="submit" class="btn btn-info btn-center" id="idProducto_hab" name="habilitar">Habilitar</button>
                                <button type="submit" class="btn btn-success btn-center" id="idProducto_sv" name="guardar">Guardar</button>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
            <h3>Listado de productos</h3><hr>
            <div class="row"><?php
                $consulta_productos = $db->prepare("SELECT * FROM productos ORDER BY habilitado DESC");
                $consulta_productos->execute();
                $productos = $consulta_productos->fetchAll(PDO::FETCH_ASSOC);
                foreach($productos as $p){?>
                    <div class="col-md-3 my-2">
                        <div class="card" style="width: 18rem;"><?php
                            $consulta_imagen = $db->prepare("SELECT * FROM productos_imagenes WHERE por_defecto LIKE '1' AND idProducto LIKE '".$p['idProducto']."'");
                            $consulta_imagen->execute();
                            $image = $consulta_imagen->fetchAll(PDO::FETCH_ASSOC);?>
                            <img src="<?php echo $image[0]['path'] ?>" style="width:80%" class="card-img-top" alt="Imagen de la tarjeta">
                            <div class="card-title">
                                <h3><?php echo $p['nombre'] ?></h3>
                            </div>
                            <div class="card-body">
                                <p class="card-title"><?php echo $p['descripcion']; ?></p><?php
                                $consulta_categoria = $db->prepare("SELECT * FROM categorias WHERE idCategoria LIKE '".$p['idCategoria']."'");
                                $consulta_categoria->execute();
                                $categoria = $consulta_categoria->fetchAll(PDO::FETCH_ASSOC);?>
                                <p>Categoria: <?php echo $categoria[0]['nombre'] ?></p>
                                <p class="card-text"><?php echo $p['moneda'].$p['precio']; ?></p><?php
                                $consulta_depositos = $db->prepare("SELECT * FROM productos_depositos INNER JOIN depositos ON productos_depositos.idDeposito = depositos.idDeposito WHERE productos_depositos.idProducto LIKE '".$p['idProducto']."'");
                                $consulta_depositos->execute();
                                $depositos = $consulta_depositos->fetchAll(PDO::FETCH_ASSOC);
                                foreach($depositos as $d){?>
                                    <p>Depósito <?php echo $d['direccion'].' - '.$d['nombre'].': <br> '.$d['disponibles'].' / '.$d['stock_minimo'];?></p><?php
                                }
                                if($p['habilitado']==1){?>
                                    <h5 class="text-success">Producto habilitado</h5><?php
                                }else{?>
                                    <h5 class="text-danger">Producto inactivo</h5><?php
                                }?>
                                <button type="button" data-toggle="modal" data-target="#modalMod" data-id="<?php echo $p['idProducto']?>" class="btn btn-primary">Modificar</a>
                            </div>
                        </div>
                    </div><?php
                }?>
            </div>
        </div>
    </body>
</html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    $('#modalMod').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var idProducto = button.data('id')
        xhhtp = new XMLHttpRequest();
        xhhtp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const response=(this.responseText)
                if(response!="[]"){
                    const data = JSON.parse(response);
                    let depositos=<?php echo json_encode($depositos);?>;
                    document.getElementById('nombre').value=data.nombre
                    document.getElementById('descripcion').value=data.descripcion
                    document.getElementById('cat-'+data.idCategoria).selected=true
                    document.getElementById('moneda').value=data.moneda
                    document.getElementById('precio').value=data.precio
                    for (var depo of depositos) {
                        document.getElementById('depo'+depo.idDeposito+'dispo').value=data[depo.idDeposito].disponibles
                        document.getElementById('depo'+depo.idDeposito+'minimo').value=data[depo.idDeposito].stock_minimo
                    }
                    document.getElementById('idProducto_sv').value=idProducto
                    document.getElementById('idProducto_el').value=idProducto
                    document.getElementById('idProducto_hab').value=idProducto

                    if(data.habilitado=="1"){
                        document.getElementById('idProducto_hab').style.display="none"
                        document.getElementById('idProducto_el').style.display=""
                    }else{
                        console.log(data.habilitado);
                        document.getElementById('idProducto_hab').style.display=""
                        document.getElementById('idProducto_el').style.display="none"
                    }
                }
            }
        };
        xhhtp.open("GET", "/evaluacion/ajaxProductos.php?idProducto="+idProducto, true);
        xhhtp.send();
    })
</script>