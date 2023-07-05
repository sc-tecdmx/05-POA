<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Model {
    /**
     * Inserta datos en una tablas
     * @patam $datos datos a insertar
     * $tabla tabla de la base a insertar
     * @return int id del nuevo registro, 0 si no hizo nada
     * */
    public function insertaBase($tabla=false, $datos=false){
        if($tabla && $datos){
            $this->db->insert($tabla, $datos);
            if ($this->db->affected_rows() == 1){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /*
    * Actualiza datos en una tabla
    * @param $datos
    * 	datos a insertar
    * 	$tabla
    * 	tabla de la base a insertar
    * @return boolean si se realiza la operación
    * */
    function actualizaBase($tabla=false,$datos=false,$where=false){
        if($tabla && $datos && $where){
            foreach ($where as $key => $value) {
                $this->db->where($key,$value);
            }

            $query=$this->db->update($tabla, $datos);
            //echo $this->db->last_query();
            if ($this->db->affected_rows()==1){
                return true;
            }
        }
        return false;
    }

    /*
    * Actualiza datos en una tabla
    * @patam $datos
    * 			datos a insertar
    * 		 $tabla
    * 			tabla de la base a insertar
    * @return boolean si se realiza la operación
    * */

    function borraBase($tabla=false,$where=false){
        if($tabla  && $where){
            foreach ($where as $key => $value) {
                $this->db->where($key,$value);
            }

            $query=$this->db->delete($tabla);
            //echo $this->db->last_query();
            if ($this->db->affected_rows()==1){
                return true;
            }
        }
        return false;

    }
    /*
    * Consultas generales al catalogo usadas por todos los controladores
    * */
    public function consultaCatalogo($catalogo=false,$where=false,$orden=false,$limit=false,$completo=false){
        if($catalogo){
            if($orden) $this->db->order_by($orden,'ASC');
            if($limit) $this->db->limit($limit);
            if($where) {
                foreach ($where as $key => $value) {
                    $this->db->where($key,$value);
                }
            }
            $query = $this->db->get($catalogo);
            if ($query->num_rows()>0){
                if ($query->num_rows()==1 && !$completo) {
                    return $query->row();
                } else {
                    return $query;
                }
            }
        }
        return false;
    }

    public function consultaCatalogo2($catalogo=false,$where=false,$orden=false,$limit=false,$completo=false){
        if($catalogo){
            if($orden) $this->db->order_by($orden,'DESC');
            if($limit) $this->db->limit($limit);
            if($where) {
                foreach ($where as $key => $value) {
                    $this->db->where($key,$value);
                }
            }
            $query = $this->db->get($catalogo);


            if ($query->num_rows()>0){
                if ( $query->num_rows()==1 && !$completo) {

                    return $query->row();

                }
                else{

                    return $query;

                }
            }


        }
        return false;
    }

    public function new_api_key($nivel,$id_user)
    {
        //verifico que el suario no tenga ya un token
        $this->db->limit(1);
        $token_existente=$this->db->get_where('keys',array('id_egresado'=>$id_user));
        if ($token_existente->num_rows()>0){
            $existe= $token_existente->row();
            // reviso caducidad
            if($existe->caducidad>=strtotime("now")){
                return $existe->key;
            }
            else{
                //Borro key
                $this->db->where('key',$existe->key);
                $this->db->delete('keys');
            }

        }

        // si llego a este punto se tiene que generar llave

        //si no existe generamso uno nuevo
        //generamos la creacion y caducidad
        $date = strtotime("now");
        $caducidad = strtotime("+7 day", $date);
        $creacion=strtotime("now");

        //generamos la key
        $key = $this->generate_token();
        //comprobamos si existe
        $check_exists_key = $this->db->get_where("keys", array("key" => $key));

        //mientras exista la clave en la base de datos buscamos otra
        while($check_exists_key->num_rows() > 0){
            $key = "";
            $key = $this->generate_token();
        }
        //creamos el array con los datos
        $data = array(
            "key"      	  => $key,
            "nivel"    	  => $nivel,
            "creacion" 	  => $creacion,
            "caducidad"   => $caducidad,
            "id_egresado" => $id_user
        );

        $this->db->insert("keys", $data);
        return $key;

    }

    private function generate_token($len = 40)
    {
        //un array perfecto para crear claves
        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );
        //desordenamos el array chars
        shuffle($chars);
        $num_chars = count($chars) - 1;
        $token = '';

        //creamos una key de 40 carácteres
        for ($i = 0; $i < $len; $i++)
        {
            $token .= $chars[mt_rand(0, $num_chars)];
        }
        return $token;
    }

    function validaToken($token=false){
        if($token){
            //hago consulta
            $this->db->limit(1);
            $token_existente=$this->db->get_where('keys',array('key'=>$token));

            if ($token_existente->num_rows()>0){
                //asigno el row
                $existe= $token_existente->row();
                //validamso que no este caduco el token
                if($existe->caducidad>=strtotime("now"))
                {
                    //si existe y es menor a la caducidad regresamos el token

                    return $existe->id_egresado;
                }
                else {
                    return FALSE;
                }


            }
            else {
                return FALSE;
            }

        }
        return false;

    }

    public function obtener_unidades(){
        $sql="select * from unidades_responsables_gastos group by numero";
        $query=$this->db->query($sql);
        return $query;
    }

    public function get_all_modulos($data = FALSE, $table)
    {
        if ($data == FALSE){
            $data = '*';
        }
        $this->db->select($data);
        $this->db->from($table);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->num_rows();
        }
    }

    /**
     * Nombre de la tabla privilegios
     * @return string
     */
    protected function privilegios_tb()
    {
        $table = 's_privilegios';
        return $table;
    }

    /**
     * @return array Consulta de los campos de la tabla privilegios en forma de arreglo
     */
    protected function get_privilegios_arr()
    {
        $data = array(
            $this->privilegios_tb() . '.ids_privilegios',
            $this->privilegios_tb() . '.id_modulo',
            $this->privilegios_tb() . '.nsf',
            $this->privilegios_tb() . '.perfil',
            $this->privilegios_tb() . '.activo',
            's_modulos.modulo',
            's_modulos.controlador',
            //'s_modulos.nombre',
            //'s_modulos.icono'
        );
        return $data;
    }

    /**
     * Consulta a la tabla privilegios y sus campos del usuario
     * @param int $nsf Valor id del usuario
     * @return mixed
     */
    public function get_data_all($nsf = FALSE, $modulo = FALSE, $controlador = FALSE)
    {
        $this->db->select($this->get_privilegios_arr());
        $this->db->from( $this->privilegios_tb());
        if ($nsf != FALSE) {
            $where = array(
                $this->privilegios_tb() . '.nsf' => $nsf
            );
            $this->db->where($where);
        }
        if ($modulo != FALSE) {
            $where = array(
                's_modulos.modulo' => $modulo
            );
            $this->db->where($where);
        }
        if ($controlador != FALSE) {
            $where = array(
                's_modulos.controlador' => $controlador
            );
            $this->db->where($where);
        }
        $this->db->join('s_modulos', 's_modulos.id_modulo = ' . $this->privilegios_tb() . '.id_modulo');
        $query  = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->num_rows();
        }
    }
}
