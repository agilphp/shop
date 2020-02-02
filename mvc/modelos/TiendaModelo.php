<?php
class TiendaModelo extends sistema\nucleo\APModelo
{

    /**
     *
     */

    public function cargarMenu()
    {

        $sMenu = $this->_bd->consulta('select men.menuId, itm.itemsid , itm.nombre, itm.url from tblmenu as men inner JOIN tblitems as itm ON men.menuId = itm.menuid');

        $sMenu        = $this->_bd->ejecucion();
        return $sMenu = $this->_bd->resultset();

    }

    public function cargarProductosFlag()
    {
        $gProductos = $this->_bd->consulta('SELECT producto_id, codigo, nombre, imagen, precio, detalle, clase FROM tblproductos where flag =1 ');

        $gProductos        = $this->_bd->ejecucion();
        return $gProductos = $this->_bd->resultset();
    }

    public function cargarProductos()
    {
        $gProductos = $this->_bd->consulta('SELECT producto_id, codigo, nombre, imagen, precio, detalle, clase FROM tblproductos where flag =0 ');

        $gProductos        = $this->_bd->ejecucion();
        return $gProductos = $this->_bd->resultset();
    }
}
