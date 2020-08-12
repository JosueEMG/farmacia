<?php
include 'Conexion.php';
class Producto{
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }
    function crear($nombre,$concentracion,$adicional,$precio,$laboratorio,$tipo,$presentacion,$avatar){
        $sql="SELECT id_producto FROM producto where nombre=:nombre and concentracion=:concentracion and adicional=:adicional and prod_lab=:laboratorio and prod_tip_prod=:tipo and prod_present=:presentacion";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre'=>$nombre, ':concentracion'=>$concentracion, ':adicional'=>$adicional, ':laboratorio'=>$laboratorio, ':tipo'=>$tipo, ':presentacion'=>$presentacion));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }
        else{
            $sql="INSERT INTO producto(nombre,concentracion,adicional,precio,prod_lab,prod_tip_prod,prod_present,avatar) values (:nombre,:concentracion,:adicional,:precio,:laboratorio,:tipo,:presentacion,:avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre, ':concentracion'=>$concentracion, ':adicional'=>$adicional, ':laboratorio'=>$laboratorio, ':tipo'=>$tipo, ':presentacion'=>$presentacion, ':precio'=>$precio, ':avatar'=>$avatar));
            echo 'add';
        }        
    }
    function editar($id,$nombre,$concentracion,$adicional,$precio,$laboratorio,$tipo,$presentacion){
        $sql="SELECT id_producto FROM producto where id_producto!=:id and nombre=:nombre and concentracion=:concentracion and adicional=:adicional and prod_lab=:laboratorio and prod_tip_prod=:tipo and prod_present=:presentacion";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id,':nombre'=>$nombre, ':concentracion'=>$concentracion, ':adicional'=>$adicional, ':laboratorio'=>$laboratorio, ':tipo'=>$tipo, ':presentacion'=>$presentacion));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noedit';
        }
        else{
            $sql="UPDATE producto SET nombre=:nombre, concentracion=:concentracion, adicional=:adicional, prod_lab=:laboratorio, prod_tip_prod=:tipo, prod_present=:presentacion, precio=:precio where id_producto=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id,':nombre'=>$nombre, ':concentracion'=>$concentracion, ':adicional'=>$adicional, ':laboratorio'=>$laboratorio, ':tipo'=>$tipo, ':presentacion'=>$presentacion, ':precio'=>$precio));
            echo 'edit';
        }        
    }
    
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT id_producto, producto.nombre as nombre, concentracion, adicional, precio, laboratorio.nombre as laboratorio, tipo_producto.nombre as tipo, presentacion.nombre as presentacion, producto.avatar as avatar, prod_lab, prod_tip_prod, prod_present
            FROM producto 
            JOIN laboratorio on prod_lab=id_laboratorio
            JOIN tipo_producto on prod_tip_prod=ip_tip_prod
            JOIN presentacion on prod_present=id_presentacion and producto.nombre LIKE :consulta LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT id_producto, producto.nombre as nombre, concentracion, adicional, precio, laboratorio.nombre as laboratorio, tipo_producto.nombre as tipo, presentacion.nombre as presentacion, producto.avatar as avatar, prod_lab, prod_tip_prod, prod_present
            FROM producto 
            JOIN laboratorio on prod_lab=id_laboratorio
            JOIN tipo_producto on prod_tip_prod=ip_tip_prod
            JOIN presentacion on prod_present=id_presentacion and producto.nombre NOT LIKE '' order by producto.nombre LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function cambiar_logo($id,$nombre){
        $sql="UPDATE producto SET avatar=:nombre where id_producto=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id,':nombre'=>$nombre));
    }
    function borrar($id){
        $sql="DELETE from producto where id_producto=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id)))){
            echo 'borrado';
        }else{
            echo 'no borrado';
        }
    }
}
?>