<?php
class tiendaModelo extends sistema\nucleo\APModelo
{

    /**
     *
     */

    public function cargarMenu()
    {
        try {
            $sMenu = $this->_bd->consulta('select men.menuId, itm.itemsid , itm.nombre, itm.url from tblmenu as men inner JOIN tblitems as itm ON men.menuId = itm.menuid');

            $sMenu        = $this->_bd->ejecucion();
            return $sMenu = $this->_bd->resultset();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

    }

    public function cargarProductosFlag()
    {
        try {
            $gProductos = $this->_bd->consulta('SELECT producto_id, codigo, nombre, imagen, precio, detalle, clase FROM tblproductos where flag =1 ');

            $gProductos        = $this->_bd->ejecucion();
            return $gProductos = $this->_bd->resultset();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function cargarProductos()
    {
        try {
            $gProductos = $this->_bd->consulta('SELECT producto_id, codigo, nombre, imagen, precio, detalle, clase FROM tblproductos where flag =0 ');

            $gProductos        = $this->_bd->ejecucion();
            return $gProductos = $this->_bd->resultset();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function cargarOrdenes()
    {
        try {
            $gOrdenes = $this->_bd->consulta('
                SELECT
                usu.id_usuario,
                usu.customer_name as nombre_usuario,
                usu.customer_email,
                ord.order_id,
                est.nombre as nombre_estado,
                sum(dord.cantidad) as cantidad,
                sum(dord.precio) as precio
               

                FROM tblordenes as ord
                        INNER JOIN tbldetalle_orden as dord
                              ON ord.`order_id` = dord.tblorders_order_id
                        INNER JOIN tblusuarios  as usu
                              ON ord.tblusuarios_id_usuario = usu.id_usuario
                        INNER JOIN tblestado_orden  as est
                              ON ord.tblstatusorder_status_order_id  = est.status_order_id
                              group by (dord.detalle_id)
                       
  ');

            $gOrdenes        = $this->_bd->ejecucion();
            return $gOrdenes = $this->_bd->resultset();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function registrarOrdenM()
    {
        try {
            $tblusuarios_id_usuario         = $this->_bd->lastInsertId();
            $tblstatusorder_status_order_id = 1;
            $post                           = $this->_bd->consulta('INSERT INTO tblordenes (tblusuarios_id_usuario,   tblstatusorder_status_order_id) VALUES (:tblusuarios_id_usuario, :tblstatusorder_status_order_id)');

            $post = $this->_bd->enlace(':tblusuarios_id_usuario', $tblusuarios_id_usuario);
            $post = $this->_bd->enlace(':tblstatusorder_status_order_id', $tblstatusorder_status_order_id);

            $post      = $this->_bd->ejecucion();
            $insert_id = $this->_bd->lastInsertId();

            return $insert_id;

        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function registrarDetallesM($order_id, $id, $cantidad, $precio)
    {
        try {
            $post = $this->_bd->consulta('INSERT INTO tbldetalle_orden (tblorders_order_id, tblproductos_producto_Id, cantidad, precio) VALUES (:tblorders_order_id, :tblproductos_producto_Id, :cantidad, :precio)');

            $post = $this->_bd->enlace(':tblorders_order_id', $order_id);
            $post = $this->_bd->enlace(':tblproductos_producto_Id', $id);
            $post = $this->_bd->enlace(':cantidad', $cantidad);
            $post = $this->_bd->enlace(':precio', $precio);

            $post = $this->_bd->ejecucion();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
