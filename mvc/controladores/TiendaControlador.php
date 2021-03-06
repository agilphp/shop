<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * @category
 * @package    sistema/nucleo
 * @copyright  Copyright (c) 2006 - 2014 webcol.net (http://www.webcol.net/calima)
 * @license    https://github.com/webcol/Calima/blob/master/LICENSE    MIT
 * @version    ##BETA 1.0##, ##2014 - 2015##
 * <http://www.AgilPhp.com>.
 */

//verificamos la version de php en tu servidor web o local
if (version_compare(PHP_VERSION, '5.3.20', '<')) {
    die('Su Hosting tiene una version < a PHP 5.3.20 debes actualizar para esta version de Calima. su version actual de PHP es: ' . PHP_VERSION);
}

//Cargamos los Espacios de nombres para el nucleo y los ayudantes
//Utilizamos un alias

use sistema\nucleo as Sisnuc;


//use vendor\bin\

class tiendaControlador extends Sisnuc\APControlador
{

    private $_ayuda;
    private $_seg;
    private $_sesion;
    public function __construct()
    {
        parent::__construct();

        // cargamos la clase ayudantes para usar sus metodos de ayuda
        $this->_ayuda  = new sistema\ayudantes\APPHPAyuda;
        $this->_seg    = new sistema\ayudantes\APPHPSeguridad;
        $this->_sesion = new sistema\nucleo\APSesion();
    }

    //include 'Carrito.php';
    public function index()
    {
        $this->_vista->titulo = 'EfraShop';
        $gtienda              = $this->cargaModelo('tienda');

        $this->_vista->menu = $gtienda->cargarMenu();

        $this->_vista->promoProductosF = $gtienda->cargarProductosFlag();

        $this->_vista->promoProductos = $gtienda->cargarProductos();

        $this->_vista->imprimirVista('index', 'tienda');
    }

    public function listarOrdenes()
    {
       $this->_sesion->iniciarSesion('_s', Ap_SESION_PARAMETRO_SEGURO);
       
        $this->_vista->titulo = 'Listar las ordenes de compra';
        $gOrdenes             = $this->cargaModelo('tienda');

        $this->_vista->menu = $gOrdenes->cargarMenu();

       if (isset($_SESSION['id_usuario'])) {
            $this->_vista->getOrdenes = $gOrdenes->cargarOrdenes();
        }

        $this->_vista->imprimirVista('listar_ordenes', 'tienda');
    }

    public function pagado()
    {
        if (!isset($_SESSION["carrito"])) {
            unset($_SESSION["carrito"]);
            $this->carrito = null;
        }
        $this->_vista->titulo = 'EfraShop';
        $gtienda              = $this->cargaModelo('tienda');
        $this->_vista->menu   = $gtienda->cargarMenu();        
        $this->_vista->imprimirVista('pagado', 'tienda');
    }

    public function cancelado()
    {
        $this->_vista->titulo = 'EfraShop';
        $gtienda              = $this->cargaModelo('tienda');
        $this->_vista->menu   = $gtienda->cargarMenu();
        $this->_vista->imprimirVista('cancelado', 'tienda');
    }

}