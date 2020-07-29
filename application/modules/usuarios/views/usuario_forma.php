<div class="row">
    <div class="col">
        <?php if(isset($mensaje)) echo $mensaje;?>
    </div>
</div>
<div class="col-lg-12">
    <div class="row">
        <div class="col">
            <div class="card mb-3">
                <div class="row">
                    <div class="col">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <i class="fa fa-users"></i> Registros administradores / <?php  echo (isset($user->nombre) ? 'Edita registro' : 'Nuevo registro') ?>
                                </div>
                                <div class="col-md-2">
                                    <a href="<?php echo base_url('usuarios/verUsuario/' . $this->uri->segment(3));?>">
                                        <button type="button" class="btn btn-danger pull-right" >
                                            <span class="glyphicon glyphicon-remove"></span>&nbsp;Regresar
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="row">
                   <div class="col">
                       <div class="modal-header">
                           <h4 class="modal-title">Por favor <?php  echo (isset($user->nombre) ? 'edita los datos necesarios': 'completa los datos' ) ?></h4>
                       </div>
                       <?php
                       $attributes = array('id' => 'usuario_form', 'data-form'=>'validate');
                       echo form_open('', $attributes);

                       if(validation_errors()!=""){
                           echo '<div class="errormsj" > <span> Error </span>'.validation_errors().'</div>';
                       }
                       ?>
                       <div class="clearfix"></div>
                       <!-- Fomrma_layout-->
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="nombre" class="control-label">Nombre</label>
                                   <?php
                                   $field = array(
                                       'name'      => 'nombre',
                                       'class'		=> 'form-control',
                                       'id'        => 'nombre',
                                       'value'     => set_value('nombre',(isset($user->nombre) ? $user->nombre : '')),
                                       'maxlength' => '80',
                                       'type'		=> 'text'
                                   );
                                   echo form_input($field);
                                   ?>
                                   <small class="form-text text-muted">*Campo obligatorio</small>
                               </div>
                           </div>

                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="apellido" class="control-label">Apellido</label>
                                   <?php
                                   $field = array(
                                       'name'      => 'apellido',
                                       'class'		=> 'form-control',
                                       'id'        => 'apellido',
                                       'value'     => set_value('apellido',(isset($user->apellido) ? $user->apellido : '')),
                                       'maxlength' => '80',
                                       'type'		=> 'text'
                                   );
                                   echo form_input($field);
                                   ?>
                                   <small class="form-text text-muted">*Campo obligatorio</small>
                               </div>
                           </div>

                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="genero" class="control-label">Género</label>
                                   <?php
                                   echo form_dropdown('genero',$genero, set_value('genero', (isset($user->genero) ? $user->genero : '')),'id="genero" class="form-control"');
                                   ?>
                                   <small class="form-text text-muted">*Campo obligatorio</small>
                               </div>
                           </div>

                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="correo" class="control-label">Correo</label>
                                   <?php
                                   $field = array(
                                       'name'      => 'correo',
                                       'class'		=> 'form-control',
                                       'id'        => 'correo',
                                       'value'     => set_value('correo',(isset($user->correo) ? $user->correo : '')),
                                       'maxlength' => '80',
                                       'type'		=> 'email'
                                   );
                                   echo form_input($field);
                                   ?>
                                   <small class="form-text text-muted">*Campo obligatorio</small>
                               </div>
                           </div>

                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="usuario" class="control-label">Usuario</label>
                                   <?php
                                   $field = array(
                                       'name'      => 'usuario',
                                       'class'		=> 'form-control',
                                       'id'        => 'usuario',
                                       'value'     => set_value('usuario',(isset($user->usuario) ? $user->usuario : '')),
                                       'maxlength' => '80',
                                       'type'		=> 'text'
                                   );
                                   echo form_input($field);
                                   ?>
                                   <small class="form-text text-muted">*Campo obligatorio</small>
                               </div>
                           </div>
                           <?php if(!isset($user->password)):?>
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="pass" class="control-label">Contraseña</label>
                                       <?php
                                       $field = array(
                                           'name'      => 'pass',
                                           'class'		=> 'form-control',
                                           'id'        => 'pass',
                                           'value'     => set_value('pass',(isset($user->password) ? $user->password : '')),
                                           'maxlength' => '80',
                                           'type'		=> 'password'
                                       );
                                       echo form_input($field);
                                       ?>
                                       <small class="form-text text-muted">*Campo obligatorio</small>
                                   </div>
                               </div>

                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="pass2" class="control-label">Confirmar Contraseña</label>
                                       <?php
                                       $field = array(
                                           'name'      => 'pass2',
                                           'class'     => 'form-control',
                                           'id'        => 'pass2',
                                           'value'     => set_value('pass2',(isset($user->pass2) ? $user->pass2 : '')),
                                           'maxlength' => '80',
                                           'type'      => 'password'
                                       );
                                       echo form_input($field);
                                       ?>
                                       <small class="form-text text-muted">*Campo obligatorio</small>
                                   </div>
                               </div>
                           <?php endif;?>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="naciemiento" class="control-label">Fecha de nacimiento</label>
                                   <?php
                                   $field = array(
                                       'name'      => 'nacimiento',
                                       'class'     => 'form-control',
                                       'id'        => 'nacimiento',
                                       'value'     => set_value('nacimiento',(isset($user->nacimiento) ? $user->nacimiento : '')),
                                       'maxlength' => '80',
                                       'type'      => 'date'
                                   );
                                   echo form_input($field);
                                   ?>
                                   <small class="form-text text-muted">*Campo obligatorio</small>
                               </div>
                           </div>

                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="edad" class="control-label">Edad</label>
                                   <?php
                                   $field = array(
                                       'name'      => 'edad',
                                       'class'     => 'form-control',
                                       'id'        => 'edad',
                                       'value'     => set_value('edad',(isset($user->edad) ? $user->edad : '')),
                                       'maxlength' => '2',
                                       'min'       => '0',
                                       'max'       => '100',
                                       'type'      => 'number'
                                   );
                                   echo form_input($field);
                                   ?>
                                   <small class="form-text text-muted">*Campo obligatorio</small>
                               </div>
                           </div>

                           <!--<div class="col-md-6">
                               <div class="form-group">
                                   <label for="correo-a" class="control-label">Correo alternativo</label>
                                   <?php
                                   $field = array(
                                       'name'      => 'correo2',
                                       'class'		=> 'form-control',
                                       'id'        => 'correo-a',
                                       'value'     => set_value('correo2',(isset($user->correo2) ? $user->correo2 : '')),
                                       'maxlength' => '80',
                                       'type'		=> 'email'
                                   );
                                   echo form_input($field);
                                   ?>
                                   <span class="help-block"></span>
                               </div>
                           </div>-->

                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="info" class="control-label">Información complementaria</label>
                                   <?php
                                   $field = array(
                                       'name'      => 'info_complementaria',
                                       'class'		=> 'form-control',
                                       'id'        => 'info',
                                       'value'     => set_value('info_complementaria',(isset($user->info_complementaria) ? $user->info_complementaria : '')),
                                       'type'		=> 'text'
                                   );
                                   echo form_input($field);
                                   ?>
                                   <span class="help-block"></span>
                               </div>
                           </div>

                           <?php  if(isset($activo)): ?>
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="titulo" class="control-label">Estatus</label>
                                       <?php
                                       echo form_dropdown('activo', $user->activo, set_value('activo',(isset($user->activo) ? $user->activo : '')),'id="activo" class="form-control"');
                                       ?>
                                       <span class="help-block"></span>
                                   </div>
                               </div>
                           <?php endif; ?>

                           <div class="col-md-12">
                               <div class="row">
                                   <div class="col-6 col-sm-6 col-md-6">
                                       <a href="<?php echo base_url('usuarios');?>"><button type="button" class="btn btn-danger pull-right" >
                                               <span class="glyphicon glyphicon-remove"></span>&nbsp;Regresar</button>
                                       </a>
                                   </div>
                                   <div class="col-6 col-sm-3 offset-sm-3 col-md-3 offset-md-3">
                                       <button type="submit"  class="btn btn-success pull-right"><span class="glyphicon glyphicon-saved"></span>Guardar</button>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <?php echo form_close();?>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>
