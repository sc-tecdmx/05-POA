<?php
/**
 * Helper para mensajes  que se quieran mostrar en los vistas, para la variable
 * de sesión mensaje.
 */


if (!function_exists('message_session')) {
    function message_session($type_msg = FALSE)
    {
        switch ($type_msg) {
            /**
             * Mensaje de ausenscia de privilegios.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_privileges':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡No tiene privilegios!</span>
                    <p> Usted no cuenta con privilegios para ingresar a esta
                    funcionalidad del sistema. Si considera que esto es un error,
                    favor de contactar al administrador del sistema.</p></div>';
                break;

            /**
             * Mensaje para creación de un registro registrado con exito.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_register_field':
                return $msg = '<div class="col-12 success alert"> <span>¡Campo registrado!</span>
                    <p>Se creo con éxito el registro.</p></div>';
                break;

            /**
             * Mensaje para actualización de un registro con exito.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_update_field':
                return $msg = '<div class="col-12 success alert"> <span>¡Campo actualizado!</span>
                    <p>Se actualizo con éxito el registro.</p></div>';
                break;

            /**
             * Mensaje para error al crear un registro y este no se registre.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_error_field_register':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo no registrado!
                    </span> <p> Ocurrió un problema, vuelva a intentarlo.</p></div>';
                break;
            case 'msg_error_goal':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡El valor no puede ser mayor al programado!
                    </span> <p> Ocurrió un problema, vuelva a intentarlo.</p></div>';
                break;
            /**
             * Mensaje para error actuañizar un registro que no tiene cambiso
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_error_field_register_no_changes':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo no registrado!
                    </span> <p> Ocurrió un problema, o no existe cambio alguno en el registro.</p></div>';
                break;

            /**
             * Mensaje para error al actualizar un registro y este no se actualice.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_error_field_update':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo no actualizado!
                    </span> <p> Ocurrió un problema, vuelva a intentarlo.</p></div>';
                break;

            /**
             * Mensaje para error al borrar un registro y este se borre.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_field_delete':
                return $msg = '<div class="col-12 success alert"> <span>¡Campo borrado!
                    </span> <p>Tu registro fue borrado con exito.</p></div>';
                break;

            /**
             * Mensaje para error al eliminar un registro y este no se borre.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_error_field_delete':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo no borrador!
                    </span> <p>Tu registro no fue borrado, verfica tus datos.</p></div>';
                break;

            /**
             * Mensaje para cuando existe un registro identico al intentar registrarlo
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_field_exits':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo ya existe!</span>
                    <p>Tu dato  ya esta registrado, intenta con uno
                    nuevo.</p></div>';
                break;
            case 'msg_field_exits_clavea':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo ya existe!</span>
                    <p>Tu clave de accion ya esta registrado, intenta con uno
                    nuevo.</p></div>';
                break;
            case 'msg_field_exits_cuie':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo ya existe!</span>
                    <p>Tu CUIE ya esta registrado, intenta con uno
                    nuevo.</p></div>';
                break;
            case 'msg_field_exits_cct':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo ya existe!</span>
                    <p>Tu CCT ya esta registrado, intenta con uno
                    nuevo.</p></div>';
                break;
            /**
             * Mensaje para cuando existe un registro identico al intentar registrarlo
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_field_dont_exits':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Campo inexistente!</span>
                    <p>Tu dato no existe, verifica tu información.</p></div>';
                break;

            /**
             * Mensaje para cuando existe un email identico en el registro
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_email_exits':
                return $msg = '<div class="col-12 errormsj alert"> <span>Correo electrónico
                    existente</span> <p>Tu correo eléctronico ya esta registrado,
                    intenta con uno nuevo.</p></div>';
                break;

            /**
             * Mensaje para cuando ya existe un avatar(usuario) en el registro
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_avatar_exits':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Usuario existente!</span>
                    <p> Tu usuario ya esta registrado, intenta con uno nuevo.</p></div>';
                break;

            /**
             * Mensaje para lectura.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_permission_read':
                return $msg = '<div class="col-12 success alert"> <span>¡Cambio a Elaboración!</span>
                    <p>Este módulo sólo permite el rol de eleboración.</p></div>';
                break;

            /**
             * Mensaje para escritura y lectura.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_permission_write_read':
                return $msg = '<div class="col-12 success alert"> <span>¡Cambio a Seguimiento!</span>
                    <p>Este módulo sólo permite el rol de seguimiento.</p></div>';
                break;

            /**
             * Mensaje para no acceso.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_permission_not_access':
                return $msg = '<div class="col-12 success alert"> <span>¡Permiso de No acceso!</span>
                    <p>Este módulo no permite acciones.</p></div>';
                break;

            /**
             * Mensaje para escritura y lectura.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_permission_special':
                return $msg = '<div class="col-12 success alert"> <span>¡Permiso espaciales!</span>
                    <p>Este módulo sólo permite usar permisos especiales.</p></div>';
                break;

             /**
             * Mensaje para el usuario inexistente.
             * @return string Envía mensaje con html integrado.
             */
            case 'msg_user_dont_exist':
                return $msg = '<div class="col-12 errormsj alert"> <span>¡Usuario inexistente!</span>
                    <p>Este usuario no existe, por favor verifique sus datos.</p></div>';
                break;

            default:
                return $msg = FALSE;
                break;
        }
        if (!$type_msg) {
            $msg = '<div class="col-12 errormsj alert"> <span>¡No existe aún un registro!</span><p>Aún no hay un registro.</p></div>';
        return $msg;
        }
    }
}
