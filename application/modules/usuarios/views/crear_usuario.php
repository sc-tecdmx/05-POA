<div class="row">
    <div class="col-12">
        <?php if(isset($mensaje)) echo $mensaje;?>
    </div>
</div>
<div class="row">
    <div class="col-10 offset-1 col-sm-8 offset-sm-2">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">
                        <i class="fa fa-users"></i> Alta de usuarios / <?php  echo (isset($user->nombre) ? 'Edita registro' : 'Nuevo registro') ?>
                    </div>
                    <div class="col-md-2">
                        <?php if($this->uri->segment(3) != ''): ?>
                        <a href="<?php echo base_url('usuarios/verUsuario/' . $this->uri->segment(3));?>">
                        <?php else: ?>
                        <a href="<?php echo base_url('usuarios');?>">
                        <?php endif; ?>
                            <button type="button" class="btn btn-danger pull-right" >
                                <span class="glyphicon glyphicon-remove"></span>&nbsp;Regresar
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
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
                    <div class="col-md-3">
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

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="apellido" class="control-label">Apellido paterno</label>
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

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="apellido" class="control-label">Apellido materno</label>
                            <?php
                            $field = array(
                                'name'      => 'sApellido',
                                'class'		=> 'form-control',
                                'id'        => 'sApellido',
                                'value'     => set_value('sApellido',(isset($user->segundo_apellido) ? $user->segundo_apellido : '')),
                                'maxlength' => '80',
                                'type'		=> 'text'
                            );
                            echo form_input($field);
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="genero" class="control-label">Sexo</label>
                            <?php
                            echo form_dropdown('genero',$genero, set_value('genero', (isset($user->genero) ? $user->genero : '')),'id="genero" class="form-control"');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>

                    <div class="col-md-4">
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

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="genero" class="control-label">Area:</label>
                            <?php
                            echo form_dropdown('area_id',$areas, set_value('area_id', (isset($user->area_id) ? $user->area_id : '')),'id="area_id" class="form-control"');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>

                    <div class="col-md-12">
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

                    <!--<div class="col-md-6">
                        <div class="form-group">
                            <label for="permiso" class="control-label">Tipo de Usuario:</label>
                            <?php
                            echo form_dropdown('permiso',$permiso, set_value('permiso', (isset($user->permiso) ? $user->permiso : '')),'id="permiso" class="selectpicker"');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>-->

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
