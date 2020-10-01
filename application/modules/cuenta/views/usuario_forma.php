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
                                    <a href="<?php echo base_url('inicio/proyectos');?>">
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
                       // cuerppo del formulario
                       echo '<div class="modal-body">';
                       //iniciamos campos
                       if(isset($mensaje)) echo $mensaje;
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

                           <!--<div class="col-md-6">
                               <div class="form-group">
                                   <label for="genero" class="control-label">Género</label>
                                   <?php
                                   echo form_dropdown('genero',$genero, set_value('genero', (isset($user->genero) ? $user->genero : '')),'id="genero" class="form-control"');
                                   ?>
                                   <small class="form-text text-muted">*Campo obligatorio</small>
                               </div>
                           </div>-->

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

                           <!--<div class="col-md-6">
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
                           </div>-->

                           <!--<div class="col-md-6">
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
                           </div> -->

                           <div class="col-md-12">
                               <div class="row">
                                   <div class="col-6 col-sm-6 col-md-6">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalPass">
                                                    Cambiar Contraseña
                                        </button>
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

<!-- Modal -->
<div class="modal fade" id="modalPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambio de contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="" action="<?php echo base_url('cuenta/cuenta/cambiarPassword');?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pass" class="control-label">Contraseña</label>
                                <?php
                                    $field = array(
                                        'name'      => 'pass',
                                        'class'		=> 'form-control',
                                        'id'        => 'pass',
                                        'value'     => set_value('pass',(isset($password) ? $password : '')),
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
                                        'value'     => set_value('pass2',(isset($pass2) ? $pass2 : '')),
                                        'maxlength' => '80',
                                        'type'      => 'password'
                                    );
                                    echo form_input($field);
                                ?>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>

