<?php
class usuarioModelo extends sistema\nucleo\APModelo
{

    public function ValidarUsuario($customer_email, $password)
    {
        try {
            //  Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el mail y password ingresados en pantalla de login
            $query = $this->db->where('Usuario', $customer_email); //  La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
            $query = $this->db->where('Password', $password);
            $query = $this->db->get('Usuarios');
            return $query->row(); //  Devolvemos al controlador la fila que coincide con la búsqueda. (FALSE en caso que no existir coincidencias)
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function insertarUsuario($id_usuario, $customer_name, $customer_email, $clave)
    {
        try {
            $post        = $this->_bd->consulta('INSERT INTO comentarios (id_usuario, customer_name, customer_email, clave) VALUES (:id_usuario, :customer_name, :customer_email, :clave)');
            $post        = $this->_bd->enlace(':id_usuario', $id_usuariio);
            $post        = $this->_bd->enlace(':customer_name', $customer_name);
            $post        = $this->_bd->enlace(':customer_email', $customer_email);
            $post        = $this->_bd->enlace(':clave', $clave);
            $post        = $this->_bd->ejecucion();
            return $post = $this->_bd->resultset();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

    }

    public function seleccionUsuario($customer_email, $clave)
    {
        try {
            $gsent = $this->_bd->consulta('select id_usuario, customer_name, customer_customer_email,  rolId from Tblusuarios where customer_customer_email = :customer_customer_email and clave = :clave');

            $gsent = $this->_bd->enlace(':customer_customer_email', $customer_email);
            $gsent = $this->_bd->enlace(':clave', $clave);
            $row   = $gsent   = $this->_bd->single();
            return $row;
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

    }

    public function insertarRegistro($customer_name, $customer_email, $rolId, $clave)
    {
        try {
            $post = $this->_bd->consulta('INSERT INTO Tblusuarios (customer_name, customer_email, rolId, clave) VALUES (:customer_name, :customer_email, :rolId, :clave)');

            $post = $this->_bd->enlace(':customer_name', $customer_name);
            $post = $this->_bd->enlace(':customer_email', $customer_email);
            $post = $this->_bd->enlace(':rolId', $rolId);
            $post = $this->_bd->enlace(':clave', $clave);
            $post = $this->_bd->ejecucion();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

    }

    public function registrarUsuarioM($customer_name, $customer_email, $identificacion, $customer_mobile, $rolId = 2)
    {
        try {
            $post = $this->_bd->consulta('INSERT INTO Tblusuarios (customer_name, customer_email, customer_mobile, rolId, clave) VALUES (:customer_name, :customer_email, :customer_mobile, :rolId, :clave)');

            $post = $this->_bd->enlace(':customer_name', $customer_name);
            $post = $this->_bd->enlace(':customer_email', $customer_email);
            $post = $this->_bd->enlace(':rolId', $rolId);
            $post = $this->_bd->enlace(':customer_mobile', $customer_mobile);
            $post = $this->_bd->enlace(':clave', $identificacion);
            $post = $this->_bd->ejecucion();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
