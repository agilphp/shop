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
 * @license https://github.com/webcol/Calima/blob/master/LICENSE    MIT
 * @version ##BETA 1.0##, ##2014 - 2015##
 * <http://www.calimaframework.com>.
 */

//verificamos la version de php en tu servidor web o local
if (version_compare(PHP_VERSION, '5.3.20', '<')) {
    die('Su Hosting tiene una version < a PHP 5.3.20 debes actualizar para esta version de Calima. su version actual de PHP es: ' . PHP_VERSION);
}

//Cargamos los Espacios de nombres para el nucleo y los ayudantes
//Utilizamos un alias
use sistema\nucleo as Sisnuc;

class CarritoControlador extends Sisnuc\APControlador
{
    //aquí guardamos el contenido del carrito
    private $carrito   = array();
    private $articulos = array();
    private $_menu;
    private $_ayuda;
    private $_sesion;

    public function __construct()
    {
        parent::__construct();

        $this->_ayuda  = new sistema\ayudantes\APPHPAyuda;
        $this->_seg    = new sistema\ayudantes\APPHPSeguridad;
        $this->_sesion = new sistema\nucleo\APSesion();

        $this->_sesion->iniciarSesion('_s', false);
        if (!isset($_SESSION["carrito"])) {
            $_SESSION["carrito"]              = null;
            $this->carrito["precio_total"]    = 0;
            $this->carrito["articulos_total"] = 0;
        }

        $this->carrito = $_SESSION['carrito'];

    }

    public function index()
    {

    }

    public function listar()
    {
        $this->_vista->titulo = 'EfraShop';
        $gtienda              = $this->cargaModelo('tienda');

        $this->_vista->menu = $gtienda->cargarMenu();
        if ($this->get_content()) {
            $this->_vista->itensC = array_values($this->get_content());
        } else {
            $this->_vista->itensC = 0;
        }
        $this->_vista->imprimirVista('carrito', 'carrito');
    }

    public function checkOut()
    {
        $this->_vista->titulo = 'EfraShop';
        $gtienda              = $this->cargaModelo('tienda');

        $this->_vista->menu = $gtienda->cargarMenu();

        $this->_vista->itensC = array_values($this->get_content());

        $this->_vista->imprimirVista('checkout', 'carrito');
    }

    public function registrarUsuario()
    {
        $sTienda = $this->cargaModelo('tienda');

        $sUsuario = $this->cargaModelo('usuario');

        $sUsuario->registrarUsuarioM($_POST['nombre'], $_POST['email'], $_POST['identificacion'], $_POST['movil']);

        $order_id = $sTienda->registrarOrdenM();

        $itens = array_values($this->get_content());

        /* echo "<pre>";
        print_r($itens);
        echo "<pre>";exit();*/
        //$order_id=1;

        foreach ($itens as $itens_user => $val) {

            $sTienda->registrarDetallesM($order_id, $val['id'], $val['cantidad'], $val['precio']);

        }
    }

    public function inicio()
    {

        $precios = $this->cargaModelo('carro');

        $this->_vista->precio  = $precios->preciosEventosI($_GET['id']);
        $this->_vista->preciot = $precios->cargarGrupoLocalidad($_GET['id']);
        //$this->_vista->mapa=$precios->verificarSiHayMapaEvento($_GET['id']);

        $this->destroyCartTotal();

        //$this->_vista->grupo=$precios->cargarGrupoLocalidad($_GET['id']);
        $this->_vista->Total_Localidades = $precios->getContarLocalidades();
        $this->_id_loc1                  = $precios->getLocalidades();
        $this->_vista->evento            = $precios->eventos($_GET['id']);
        $this->_vista->fotoEvento        = $precios->eventosFotoGet($_GET['id']);
        $this->_vista->imprimirVista('inicio_compra', 'carrito');
    }

    public function compraSegura()
    {

        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        if (isset($_SESSION["carrito"])) {
            unset($_SESSION["carrito"]);
            unset($_SESSION['id_prod']);
            $this->carrito = null;
        }
        $precios = $this->cargaModelo('carro');
        //antes de hacer los cálculos, compruebo que el usuario está logueado
        //utilizamos el mismo script que antes
        if ($_SESSION["ultimoAcceso"]) {
            //sino, calculamos el tiempo transcurrido
            $fechaGuardada       = $_SESSION["ultimoAcceso"];
            $ahora               = time();
            $tiempo_transcurrido = $ahora - $fechaGuardada;

            //comparamos el tiempo transcurrido
        } elseif ($tiempo_transcurrido >= 600) {
            //si pasaron 10 minutos o más
            $this->destroy(); // destruyo la sesión
            $this->_ayuda->redireccionUrl('carrito/compraSegura');
            //sino, actualizo la fecha de la sesión
        } else {
            $_SESSION["ultimoAcceso"] = $ahora;
        }

        $this->_vista->titulo  = 'Escojo mis boletas';
        $this->_vista->error   = 'Escojo mis boletas';
        $this->_vista->menu    = $this->_menu->menuBasico();
        $this->_vista->precio  = $precios->preciosEventos($_GET['id']);
        $this->_vista->evento  = $precios->eventos($_GET['id']);
        $this->_vista->estados = $precios->estados($_GET['id']);
        $this->_vista->mesas   = $precios->getMesas($_GET['id']);
        if ($_GET['tipo'] == 3) {
            $precios->estadoPalco($_GET['press'], '1');
        }
        $this->_vista->fotoEvento = $precios->eventosFotoGet($_GET['id']);
        $this->_vista->imprimirVista('compra', 'carrito');
    }

    public function compraSeguraEnLinea()
    {
        $precios = $this->cargaModelo('carro');
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        $this->_vista->titulo      = ' Veo mi recibo / Realizo mi pago';
        $this->_vista->error       = ' Veo mi recibo / Realizo mi pago';
        $this->_vista->menu        = $this->_menu->menuBasico();
        $this->_vista->carro       = $this->get_content();
        $datosCarro                = $this->get_content();
        $this->_vista->evento      = $precios->eventos($_SESSION['id_prod']);
        $this->_vista->localidades = $precios->localidades($_SESSION['localidad']);
        foreach ($datosCarro as $producto) {
            $this->_vista->entrega = $precios->entrega($producto['entrega']);}
        $this->_vista->datosUsuario = $precios->datosUsuario($_SESSION['id_usuario']);
        $this->_vista->imprimirVista('compra2', 'carrito');
    }

    public function compraSeguraLogin()
    {
        $precios = $this->cargaModelo('carro');
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        $this->_vista->titulo = 'CalimaFramework Login';
        $this->_vista->error  = 'CalimaFramework Login';
        $this->_vista->menu   = $this->_menu->menuBasico();
        $this->_vista->carro  = $this->get_content();
        $this->_vista->evento = $precios->eventosLogin();
        $this->_vista->imprimirVista('compra3', 'carrito');
    }

    public function sesionPagos()
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        $_SESSION['articulo']     = $_POST['account'];
        $_SESSION['cantidad']     = $_POST['cantidad'];
        $_SESSION['entrega']      = $_POST['entrega'];
        $_SESSION["ultimoAcceso"] = time();

        $this->_ayuda->redireccionUrl('carrito/registro');
    }

    public function addSesionPagos()
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        $_SESSION['articulo'] += $_POST['account'];
        $_SESSION['cantidad'] += $_POST['cantidad'];
        $_SESSION['entrega'] += $_POST['entrega'];
        $_SESSION["ultimoAcceso"] = time();

        $this->_ayuda->redireccionUrl('carrito/compraSeguraEnLinea');
    }

    public function addProducto()
    {

        $this->articulos = array(
            "id"       => $_GET['id'],
            "cantidad" => $_GET['cantidad'],
            "precio"   => $_GET['precio'],
            "nombre"   => $_GET['nombre'],

        );

        $this->add();
    }

    public function recibo()
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);

        if ($_SESSION['nivel'] == 256) {
            $this->_vista->titulo = 'CalimaFramework Login';
            $this->_vista->error  = 'CalimaFramework Login';
            $this->_vista->menu   = $this->_menu->menuBasico();
            $this->_vista->imprimirVista('recibo', 'carrito');
        } elseif ($_SESSION['nivel'] != 256) {

            $this->_vista->titulo = 'CalimaFramework Login';
            $this->_vista->error  = 'CalimaFramework Login';
            $this->_vista->menu   = $this->_menu->menuBasico();
            $this->_vista->imprimirVista('login', 'carrito');
        }
    }

    //añadimos un producto al carrito
    public function add()
    {
        ////$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        //primero comprobamos el articulo a añadir, si está vacío o no es un
        //array lanzamos una excepción y cortamos la ejecución
        if (!is_array($this->articulos) || empty($this->articulos)) {
            throw new Exception("Error, el articulo no es un array!", 1);
        }

        //nuestro carro necesita siempre un id producto, cantidad y precio articulo
        if (!$this->articulos["id"] || !$this->articulos["cantidad"] || !$this->articulos["precio"]) {
            throw new Exception("Error, el articulo debe tener un id, cantidad y precio!", 1);
        }

        //nuestro carro necesita siempre un id producto, cantidad y precio articulo
        if (!is_numeric($this->articulos["id"]) || !is_numeric($this->articulos["cantidad"]) || !is_numeric($this->articulos["precio"])) {
            throw new Exception("Error, el id, cantidad y precio deben ser números!", 1);
        }

        //debemos crear un identificador único para cada producto
        $unique_id = md5($this->articulos["id"]);

        //creamos la id única para el producto
        $this->articulos["unique_id"] = $unique_id;

        //si no está vacío el carrito lo recorremos
        if (!empty($this->carrito)) {
            foreach ($this->carrito as $row) {
                //comprobamos si este producto ya estaba en el
                //carrito para actualizar el producto o insertar
                //un nuevo producto
                if ($row["unique_id"] === $unique_id) {
                    //si ya estaba sumamos la cantidad
                    $this->articulos["cantidad"] = $row["cantidad"] + $this->articulos["cantidad"];
                }
            }
        }

        //evitamos que nos pongan números negativos y que sólo sean números para cantidad y precio
        $this->articulos["cantidad"] = trim(preg_replace('/([^0-9\.])/i', '', $this->articulos["cantidad"]));
        $this->articulos["precio"]   = trim(preg_replace('/([^0-9\.])/i', '', $this->articulos["precio"]));

        //añadimos un elemento total al array carrito para
        //saber el precio total de la suma de este artículo
        $this->articulos["total"] = $this->articulos["cantidad"] * $this->articulos["precio"];

        //primero debemos eliminar el producto si es que estaba en el carrito
        $this->unset_producto($unique_id);

        ///ahora añadimos el producto al carrito
        $_SESSION["carrito"][$unique_id] = $this->articulos;

        //actualizamos el carrito
        $this->update_carrito();

        //actualizamos el precio total y el número de artículos del carrito
        //una vez hemos añadido el producto
        $this->update_precio_cantidad();

        $this->_ayuda->redireccionUrl('tienda/index');
    }

    //método que actualiza el precio total y la cantidad
    //de productos total del carrito
    private function update_precio_cantidad()
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        //seteamos las variables precio y artículos a 0
        $precio    = 0;
        $articulos = 0;

        //recorrecmos el contenido del carrito para actualizar
        //el precio total y el número de artículos
        foreach ($this->carrito as $row) {
            $precio += ($row['precio'] * $row['cantidad']);
            $articulos += $row['cantidad'];
        }

        //asignamos a articulos_total el número de artículos actual
        //y al precio el precio actual
        $_SESSION['carrito']["articulos_total"] = $articulos;
        $_SESSION['carrito']["precio_total"]    = $precio;

        //refrescamos él contenido del carrito para que quedé actualizado
        $this->update_carrito();
    }

    //método que retorna el precio total del carrito
    public function precio_total()
    {
        //si no está definido el elemento precio_total o no existe el carrito
        //el precio total será 0
        if (!isset($this->carrito["precio_total"]) || $this->carrito === null) {
            return 0;
        }
        //si no es númerico lanzamos una excepción porque no es correcto
        if (!is_numeric($this->carrito["precio_total"])) {
            throw new Exception("El precio total del carrito debe ser un número", 1);
        }
        //en otro caso devolvemos el precio total del carrito
        return $this->carrito["precio_total"] ? $this->carrito["precio_total"] : 0;
    }

    //método que retorna el número de artículos del carrito
    public function articulos_total()
    {
        //si no está definido el elemento articulos_total o no existe el carrito
        //el número de artículos será de 0
        if (!isset($this->carrito["articulos_total"]) || $this->carrito === null) {
            return 0;
        }
        //si no es númerico lanzamos una excepción porque no es correcto
        if (!is_numeric($this->carrito["articulos_total"])) {
            throw new Exception("El número de artículos del carrito debe ser un número", 1);
        }
        //en otro caso devolvemos el número de artículos del carrito
        return $this->carrito["articulos_total"] ? $this->carrito["articulos_total"] : 0;
    }

    //este método retorna el contenido del carrito
    public function get_content()
    {
        //asignamos el carrito a una variable
        $carrito = $this->carrito;
        //debemos eliminar del carrito el número de artículos
        //y el precio total para poder mostrar bien los artículos
        //ya que estos datos los devuelven los métodos
        //articulos_total y precio_total
        unset($carrito["articulos_total"]);
        unset($carrito["precio_total"]);
        return $carrito == null ? null : $carrito;
    }

    //método que llamamos al insertar un nuevo producto al
    //carrito para eliminarlo si existia, así podemos insertarlo
    //de nuevo pero actualizado
    private function unset_producto($unique_id)
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        unset($_SESSION["carrito"][$unique_id]);
    }

    //para eliminar un producto debemos pasar la clave única
    //que contiene cada uno de ellos
    public function remove_producto($unique_id)
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        //si no existe el carrito
        if ($this->carrito === null) {
            throw new Exception("El carrito no existe!", 1);
        }

        //si no existe la id única del producto en el carrito
        if (!isset($this->carrito[$unique_id])) {
            throw new Exception("La unique_id $unique_id no existe!", 1);
        }

        //en otro caso, eliminamos el producto, actualizamos el carrito y
        //el precio y cantidad totales del carrito
        unset($_SESSION["carrito"][$unique_id]);
        $this->update_carrito();
        $this->update_precio_cantidad();
        return true;
    }

    //eliminamos el contenido del carrito por completo
    public function destroy()
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        unset($_SESSION["carrito"]);
        $this->carrito = null;
        //return true;
        $this->_ayuda->redireccionUrl('tienda/index');
    }

    public function destroyCart()
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        unset($_SESSION["carrito"]);
        unset($_SESSION['id_prod']);
        unset($_SESSION['usuario']);
        unset($_SESSION['id_usuario']);
        unset($_SESSION['nivel']);
        $this->carrito = null;
        //return true;
        $this->_ayuda->redireccionUrl('tienda/index');
    }

    public function destroyCartTotal()
    {
        //$this->_sesion->iniciarSesion('_s', Cf_SESION_PARAMETRO_SEGURO);
        unset($_SESSION["carrito"]);
        unset($_SESSION['id_prod']);
        unset($_SESSION['usuario']);
        unset($_SESSION['id_usuario']);
        unset($_SESSION['nivel']);
        $this->carrito   = null;
        $this->articulos = null;
        //return true;
        //$this->_ayuda->Redireccion('http://www.zonaticket.com.co');
    }

    //actualizamos el contenido del carrito
    public function update_carrito()
    {
        if (!isset($_SESSION["carrito"])) {
            $_SESSION["carrito"]              = null;
            $this->carrito["precio_total"]    = 0;
            $this->carrito["articulos_total"] = 0;
        }
    }

}
