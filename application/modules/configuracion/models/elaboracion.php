<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Constantes de conexion a la base de datos al anteproyecto
/* define('DB_HOST_2', '192.168.22.222');
define('DB_USER_2', 'root');
define('DB_PASSWORD_2', 'w3c-swuT');
define('DB_NAME_2', 'anteproyecto'); */

// $connection_db_anteproyecto = mysqli_connect(DB_HOST_2, DB_USER_2, DB_PASSWORD_2, DB_NAME_2);

class elaboracion extends CI_Model
{
    public function searchEjercicio($ejercicio)
    {
        $this->db->where('ejercicio', $ejercicio);
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function getProgramas($ejercicio)
    {
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('programas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getSubprogramas($programa)
    {
        $this->db->where('programa_id', $programa);
        $this->db->from('subprogramas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getInfo($tabla, $ejercicio)
    {
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from($tabla);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getMesesProyectos($proyecto)
    {
        $this->db->where('proyecto_id', $proyecto);
        $this->db->from('meses_proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getMetas($proyecto)
    {
        $this->db->where('proyecto_id', $proyecto);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getMetasProgramadas($meta)
    {
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getMetasAlcanzadas($meta){
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getIndicadores($meta){
        $this->db->where('meta_id', $meta);
        $this->db->from('indicadores');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getAccionesSustantivas($proyecto)
    {
        $this->db->where('proyecto_id', $proyecto);
        $this->db->from('acciones_sustantivas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUnidad($unidad)
    {
        $this->db->where('unidad_medida_id', $unidad);
        $this->db->from('unidades_medidas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function getUnidadActual($nombre, $ejercicio)
    {
        $this->db->where('nombre', $nombre);
        $this->db->where('ejercicio_id', $ejercicio);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function insert($tabla, $datos)
    {
        if($tabla && $datos){
            $this->db->insert($tabla, $datos);
            if ($this->db->affected_rows() == 1){
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getAnios()
    {
        $this->db->select('ejercicio');
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Datos para el ejercicio de elaboración
     */
    public function getEjercicioElaboracion()
    {
        $this->db->select('ejercicio_id');
        $this->db->where('operacion_ejercicio_id', '1');
        $this->db->from('operaciones_ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    /**
     * Datos para la configuración de elaboración
     */
    public function getConfiguracion($ejercicio)
    {
        $this->db->select('ejercicios.permitir_edicion_elaboracion, ejercicios.ejercicio, operaciones_ejercicios.habilitado');
        $this->db->join('operaciones_ejercicios', 'ejercicios.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('ejercicios.ejercicio_id', $ejercicio);
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    /**
     * Datos para la generación del anteproyecto
     */

    public function respaldo_db_anteproyecto($ejercicio_anterior){
        // Se crea un respaldo del sistema de "anteproyecto"
        $source = "C:/xampp/htdocs/anteproyecto";
        $dest = "C:/xampp/htdocs/anteproyecto" . $ejercicio_anterior;
        xcopy($source, $dest);

        // Reemplazamos el nombre de la base de datos en los archivos de conexiones del anteproyecto respaldado
        $file = "$dest/Connections/conector.php";
        $file_contents = file_get_contents($file);
        $fh = fopen($file, "w");
        $file_contents = str_replace('anteproyecto', 'anteproyecto' . $ejercicio_anterior, $file_contents);
        fwrite($fh, $file_contents);
        fclose($fh);

        $file = "$dest/Connections/conn_anteproy.php";
        $file_contents = file_get_contents($file);
        $fh = fopen($file, "w");
        $file_contents = str_replace('anteproyecto', 'anteproyecto' . $ejercicio_anterior, $file_contents);
        fwrite($fh, $file_contents);
        fclose($fh);

        // Cambiamos los años dentro de los scripts "documentacion.php", "header.php", "index.php", "memoria-calculo-proyecto.php"
        // y "resumen-costo-proyecto" para el anteproyecto actual
        $file = "$source/documentacion.php";
        $file_contents = file_get_contents($file);
        $fh = fopen($file, "w");
        $file_contents = str_replace($ejercicio_anterior, $ejercicio, $file_contents);
        fwrite($fh, $file_contents);
        fclose($fh);

        $file = "$source/header.php";
        $file_contents = file_get_contents($file);
        $fh = fopen($file, "w");
        $file_contents = str_replace($ejercicio_anterior, $ejercicio, $file_contents);
        fwrite($fh, $file_contents);
        fclose($fh);

        $file = "$source/index.php";
        $file_contents = file_get_contents($file);
        $fh = fopen($file, "w");
        $file_contents = str_replace($ejercicio_anterior, $ejercicio, $file_contents);
        fwrite($fh, $file_contents);
        fclose($fh);

        $file = "$source/reportes/memoria-calculo-proyecto.php";
        $file_contents = file_get_contents($file);
        $fh = fopen($file, "w");
        $file_contents = str_replace($ejercicio_anterior, $ejercicio, $file_contents);
        fwrite($fh, $file_contents);
        fclose($fh);

        $file = "$source/reportes/resumen-costo-proyecto.php";
        $file_contents = file_get_contents($file);
        $fh = fopen($file, "w");
        $file_contents = str_replace($ejercicio_anterior, $ejercicio, $file_contents);
        fwrite($fh, $file_contents);
        fclose($fh);
    }

    public function crea_db_anteproyecto($source_db,$db,$tablas){
        $create_db = "CREATE DATABASE " . $db;
        if (mysqli_query($connection_db_anteproyecto, $db)) {
            foreach ($tablas as $tab) {
                mysqli_select_db($connection_db_anteproyecto, $db);
                mysqli_query($connection_db_anteproyecto, "CREATE TABLE $tab LIKE " . $source_db . "." . $tab);
                mysqli_query($connection_db_anteproyecto, "INSERT INTO $tab SELECT * FROM " . $source_db . "." . $tab);

                // Generar stored procedures
                mysqli_query($connection_db_anteproyecto,
                    "CREATE PROCEDURE comparacionClavePresupuestal(IN clave VARCHAR(50))
                    BEGIN
                    SELECT FORMAT(SUM(enero), 2) as 'enero', FORMAT(SUM(febrero), 2) as 'febrero', FORMAT(SUM(marzo), 2) as 'marzo', 
                    FORMAT(SUM(abril), 2)as 'abril', FORMAT(SUM(mayo), 2) as 'mayo', FORMAT(SUM(junio), 2) as 'junio', FORMAT(SUM(julio), 2) as 'julio', 
                    FORMAT(SUM(agosto), 2) as 'agosto', FORMAT(SUM(septiembre), 2) as 'septiembre', FORMAT(SUM(octubre), 2) as 'octubre', 
                    FORMAT(SUM(noviembre), 2) as 'noviembre', FORMAT(SUM(diciembre), 2) as 'diciembre', FORMAT(SUM(scp.costo_tot), 2) as 'total',  
                    scp.observacion, scp.justificacion, consecutivo FROM urgs urg
                    INNER JOIN scp_bienservicio scp
                    ON scp.id_unidad = urg.id_unidad
                    INNER JOIN responsables_operativos ro
                    ON ro.id_ro = scp.id_dirarea
                    INNER JOIN programas p
                    ON p.programa_id = scp.id_programa
                    INNER JOIN subprogramas sp
                    ON sp.subprograma_id = scp.id_sprograma
                    INNER JOIN proyectos py
                    ON py.proyecto_id = scp.id_proyecto
                    WHERE CONCAT(numero_unidad,' - ',numero_ro,' - ',numero_pg,' - ',numero_sp,' - ',numero_py,' - ',id_partida) = clave;	
                    END");

                mysqli_query($connection_db_anteproyecto,
                    "CREATE PROCEDURE obtenerIdsReales(IN clave VARCHAR(50))
                    BEGIN
                    SELECT urg.id_unidad as 'urg_id', ro.id_ro as 'ro_id', pg.programa_id, sp.subprograma_id, py.proyecto_id
                    FROM urgs urg, responsables_operativos ro, programas pg, subprogramas sp, proyectos py
                    WHERE urg.id_unidad = ro.id_unidad
                    AND py.responsable_operativo_id = ro.id_ro
                    AND pg.programa_id = sp.programa_id
                    AND py.subprograma_id = sp.subprograma_id
                    AND CONCAT(urg.numero_unidad, '-', ro.numero_ro, '-', pg.numero_pg, '-', sp.numero_sp, '-', py.numero_py) = clave;
                    END");
                mysqli_query($connection_db_anteproyecto,
                    "CREATE PROCEDURE obtenerRegistros()
                 BEGIN
                 SELECT CONCAT(urg.numero_unidad, ro.numero_ro, pg.numero_pg, sp.numero_sp, py.numero_py, bs.id_partida) as 'clave',
                 bs.enero, bs.febrero, bs.marzo, bs.abril, bs.mayo, bs.junio, bs.julio, bs.agosto, bs.septiembre, bs.octubre, bs.noviembre, bs.diciembre
                 FROM scp_bienservicio bs, urgs urg, responsables_operativos ro, programas pg, subprogramas sp, proyectos py
                 WHERE bs.id_unidad = urg.id_unidad
                 AND bs.id_dirarea = ro.id_ro
                 AND bs.id_programa = pg.programa_id
                 AND bs.id_sprograma = sp.subprograma_id
                 AND bs.id_proyecto = py.proyecto_id;
                 END");
                mysqli_query($connection_db_anteproyecto,
                    "CREATE PROCEDURE saludo()
                 BEGIN
                 SELECT 'it works';
                 END");
            }
        }
    }

    public function genera_nuevo_ejercicio($ejercicio){
        $ejercicio_anterior = $ejercicio - 1;
        $ejercicio_ = $this->searchEjercicio('20'.$ejercicio);
        $ejercicio_id = $ejercicio_->ejercicio_id;
        print_r($ejercicio_);
        echo "######################################{$ejercicio_id}";
        $ejercicio_anterior_ = $this->searchEjercicio('20'.$ejercicio_anterior);
        print_r($ejercicio_anterior_);

        $ejercicio_anterior_id = $ejercicio_anterior_->ejercicio_id;
        echo "######################################{$ejercicio_anterior_id}";
        $ejercicio_anteproyecto = $this->searchEjercicioAnteproyecto('20'.$ejercicio);
        print_r($ejercicio_anteproyecto);
        die();
        if(!$ejercicio_anteproyecto){
            $source_db = "anteproyecto";
            $new_db = "anteproyecto" . $ejercicio_anterior;

            $query = "SHOW TABLES";
            $result = mysqli_query($connection_db_anteproyecto, $query);

            $table_names = array();
            while ($row = mysqli_fetch_array($result)) {
                $table_names[] = $row[0];
            }

            // Crear base de datos si no existe
            $db_selected = mysqli_select_db($connection_db_anteproyecto, $new_db);

            if($db_selected){
                $this->crea_db_anteproyecto($source_db,$new_db,$table_names);
                $this->respaldo_db_anteproyecto('20'.$ejercicio_anterior);

                // Se copian las tablas que integran las claves programáticas y los usuarios del Sistema POA al Anteproyecto
                mysqli_select_db($connection_db_anteproyecto, $source_db);

                // Programas y subprogramas
                $query = "TRUNCATE programas";
                mysqli_query($connection_db_anteproyecto, $query);
                $query = "TRUNCATE subprogramas";
                mysqli_query($connection_db_anteproyecto, $query);

                $query = "SELECT programa_id, ejercicio_id, numero, nombre FROM programas WHERE ejercicio_id = $ejercicio_id";
                $sql = $this->db->query($query);
                $programas = $sql->result();
                //return $sql->row();
                print_r($programas);
                foreach ($programas as $key => $value) {
                    print_r($key);
                    echo "############";
                    print_r($value);
                    // $programa_id = $row['programa_id'];
                    // $ejercicio_id = $row['ejercicio_id'];
                    // $numero = $row['numero'];
                    // $nombre = $row['nombre'];
                }
            }
        }


    }

    public function generaNuevoEjercicio(){

    }

    public function searchEjercicioAnteproyecto($ejercicio)
    {
        $this->db->where('ejercicio', $ejercicio);
        $this->db->from('ejercicios_anteproyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        } else {
            return false;
        }
    }
}
