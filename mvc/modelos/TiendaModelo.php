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
}
