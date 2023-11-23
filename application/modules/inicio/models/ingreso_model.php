<?php

class Ingreso_model extends CI_Model {

	/*
	*Obtiene el password almacenado de un usuario
	@param $usuario
	Usuario propocionado en la forma de ingreso
	@return
	Hash almacenado del password del usuario y nsf -o- Falso si no encuentra un usuario
	*/
	function getPassUsr($usuario)
    {
		if($usuario){
			$sql="
			SELECT *
			FROM s_control
			WHERE	usuario='$usuario'
			LIMIT 1";
			$query = $this->db->query($sql);
			if ($query->num_rows()== 1){
				return $query->row();
			}
		}
		return false;
	}

	function getPassData($nsf)
    {
		if($nsf){
			/*$sql="
			SELECT *
			FROM g_registros
			WHERE nsf='$nsf'
			LIMIT 1";*/
			$this->db->select('*');
			$this->db->from('g_registros');
			$this->db->where('nsf', $nsf);
			$this->db->limit('1');
			//$query = $this->db->query($sql);
			$query = $this->db->get();
			if ($query->num_rows()== 1){
				return $query->row();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function getPrivData($nsf){
		if($nsf){
			$this->db->select('*');
			$this->db->from('s_privilegios');
			$this->db->where('nsf', $nsf);
			$query = $this->db->get();
			if($query->num_rows()>0){
				return $query->row();
			} else{
				return false;
			}
		} else{
			return false;
		}
	}

	function actualizaPass($pass,$nsf)
    {
		$sql="UPDATE s_registros SET password=? WHERE nsf=? LIMIT 1";
		/*$query=*/$this->db->query($sql,array($pass,$nsf));
		if ($this->db->affected_rows()==1){
			return true;
		} else {
			return false;
		}
	}

	/*
	Registra el acceso de un usuario al sistema y regresa el identificacor de ese acceso
	@param $nsf
	Identificador de usuario
	@param $ip
	Direccion ip desde la que se conecta
	@param $dispositivo
	Registro del sistema operativo y navegador del que se conecta
	@return
	Hash almacenado del password del usuario -o- Falso si no encuentra un usuario
	*/
	function setAcceso($nsf,$ip,$dispositivo)
    {
		if($nsf && $ip && $dispositivo){
			$time=time();
			$sql="INSERT INTO s_accesos(nsf,ip,dispositivo,ingreso) VALUES ('$nsf','$ip','$dispositivo','$time')";
			/*$query=*/$this->db->query($sql,array($nsf,$ip,$dispositivo));
			if ($this->db->affected_rows()==1){
				return $this->db->insert_id();
			}
		}
		return false;
	}

	/*
	Cierra sesion de acceso el unixtimestamp del cierre de sesion del usuario
	@param
	@return
	Boolean que dice si se hizo o no la operacion
	*/
	function cierraAcceso()
    {
		if($this->session->userdata('id_acceso')){
			$time=time();
			$sql="UPDATE s_accesos SET salida=$time WHERE id_acceso=? LIMIT 1";
			/*$query=*/$this->db->query($sql,array($this->session->userdata('id_acceso')));
			if ($this->db->affected_rows()==1){
				return true;
			}
		}
		return false;
	}

	/*
	Regresa el unixtimestam de la ultima vistia del usuario
	@param
	@retrun
	Objeto de base de datos con unixtimestam de la ultima vistia del usuario
	*/
	function getUltimaVisita()
    {
		if($this->session->userdata('nsf') && $this->session->userdata('id_acceso')){
			$sql="SELECT * FROM s_accesos WHERE nsf=? AND id_acceso!=? ORDER BY ingreso DESC LIMIT 1";
			$query = $this->db->query($sql,array($this->session->userdata('nsf'),$this->session->userdata('id_acceso')));
			if ($query->num_rows() == 1){
				return $query->row();
			}
		}
		return false;
	}

	function refreshActividad()
    {
		if($this->session->userdata('id_acceso')){
			$sql="SELECT user_data FROM ci_sessions WHERE session_id=? LIMIT 1";
			$query = $this->db->query($sql,array($this->session->userdata('session_id')));
			if ($this->db->affected_rows()==1){
				$result=$query->row();
				$user_data=$result->user_data;
			}

			$ultimaUrl=uri_string();
			if(((strpos($ultimaUrl,'ajax'))===FALSE) && ((strpos($ultimaUrl,'exporta'))===FALSE) && ((strpos($ultimaUrl,'preview'))===FALSE)){
				//no hacer nada
				$this->session->set_userdata('ultimaUrl',$ultimaUrl);
			}

			$sql="
			UPDATE s_accesos
			SET ultimaActividad=UNIX_TIMESTAMP(NOW()),
			ultimaUrl=?, data=?
			WHERE id_acceso=? LIMIT 1";

			$query = $this->db->query($sql,array($this->session->userdata('ultimaUrl'),$user_data,$this->session->userdata('id_acceso')));
			if ($this->db->affected_rows()==1){
				return true;
			}
		}
		return false;
	}

	/*
	Valida permisos de acceso al modulo en la base
	@param
	@return
	Objeto de base con informacion de privilegios del perfil del usuario -o-
	falso cuando el usuario no tenga acceso al modulo
	*/
	function validaAccesoModulo()
    {
		if($this->session->userdata('nsf') && $this->session->userdata('modulo')){
			$sql="SELECT b.controlador,b.nombre FROM s_control a, modulos b WHERE a.idmodulos=b.idmodulos AND idpersonal=? AND b.controlador=?";
			$query = $this->db->query($sql,array($this->session->userdata('nsf'),$this->session->userdata('modulo')));
			if ($query->num_rows() == 1){
				$result=$query->row();
				return $result;
			}
		}
		return false;
	}

	function getInfoUsr()
    {
		if($this->session->userdata('id_usr')){
			$sql="
			SELECT r.nombre, r.apellido, r.correo, p.id_modulo, c.usuario, c.activo
			FROM s_privilegios as p,g_registros as r, s_control as c
			WHERE r.nsf=?
			AND p.nsf=r.nsf AND c.nsf=r.nsf
			LIMIT 1";
			$query = $this->db->query($sql,array($this->session->userdata('id_usr')));
			if ($query->num_rows()==1){
				return $query->row();
			}
		}
		return false;
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
            $this->privilegios_tb() . '.condicion',
            's_modulos.modulo',
            's_modulos.controlador',
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

    public function get_menu_states($where, $join = FALSE)
    {
        $data = array(
            'inmuebles.id_entidad',
            'inmuebles.entidad_federativa'
        );
        $this->db->select('*');
        $this->db->join('acciones','inmuebles.id_inmuebles=acciones.inmuebles_id');
        $this->db->from('inmuebles');
        $this->db->where('inmuebles.id_entidad', $where);
        $query = $this->db->get();

        if ($query->num_rows() >= 1){
            return $query->num_rows();
        } else {
            return FALSE;
        }
    }

    /**
     * Arreglo para consultar los datos de los estados de la república
     * @return array
     */
    protected function array_entidad()
    {
        $data = array(
            'cat_estados.id_estados',
            'cat_estados.nombre_estado',
        );
        return $data;
    }

    /**
     * Método que consulta un estado a la vez
     * @param $where
     * @return bool
     */
    public function get_states($where)
    {
        $this->db->select($this->array_entidad());
        $this->db->join('inmuebles','inmuebles.id_inmuebles=cat_estados.id_estados');
        $this->db->from('cat_estados');
        $this->db->where('cat_estados.id_estados', $where);
        $query = $this->db->get();
        if ($query->num_rows() >= 1){
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_ejercicio()
    {
        $this->db->select('ejercicios.*');
        $this->db->join('ejercicios', 'operaciones_ejercicios.ejercicio_id = ejercicios.ejercicio_id');
        $this->db->where('operaciones_ejercicios.habilitado', 'si');
        $this->db->where('operaciones_ejercicios.operacion_ejercicio_id', '1');
        // $this->db->where('permitir_edicion_seguimiento', 'si');
        $this->db->from('operaciones_ejercicios');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function getEjercicioSeguimiento()
    {
        $this->db->select('ejercicios.*');
        $this->db->join('ejercicios', 'operaciones_ejercicios.ejercicio_id = ejercicios.ejercicio_id');
        $this->db->where('operaciones_ejercicios.operacion_ejercicio_id', '2');
        // $this->db->where('permitir_edicion_seguimiento', 'si');
        $this->db->from('operaciones_ejercicios');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function verificaPermisos($user)
    {
        $this->db->where('usuario', $user);
        $this->db->from('s_control');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function getEjercicios()
    {
        $this->db->select('ejercicios.ejercicio, operaciones_ejercicios.operacion_ejercicio_id');
        $this->db->join('operaciones_ejercicios', 'ejercicios.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getAreaAccesos($usuario)
    {
        $this->db->where('usuario_poa_id', $usuario);
        $this->db->from('usuarios_responsables_operativos');
        $query = $this->db->get();
        return $query->result();
    }
}
