<div class="col-sm-12">
    <div class="row">
        <div class="col">
            <?php
                //var_dump($mensaje_password);
                if(isset($mensaje)) echo $mensaje;
                echo "<div>";
                if(isset($mensaje_password)) echo $mensaje_password;
                echo "</div>";
            ?>
            <?php if (validation_errors()!=""): ?>
                <div class="errormsj" > <span> Error </span><?php echo validation_errors();?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="row justify-content-end">
                <div class="m-1">
                    <a class="btn btn-danger" href="<?php echo base_url('usuarios');?>">
                        <span class="far fa-times-circle"></span>&nbsp; Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <ul class="nav nav-pills nav-pills-rose" id="pills-tab" role="tablist">
                    <li class="nav-item hvr-bounce-in">
                        <a class="nav-link hvr-bounce-in active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                            <i class="far fa-address-card"></i> Datos Generales
                        </a>
                    </li>
                    <li class="nav-item hvr-bounce-in">
                        <a class="nav-link hvr-bounce-in" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                            <i class="fas fa-boxes"></i> Módulos y privilegios
                        </a>
                    </li>
                    <li class="nav-item hvr-bounce-in">
                        <a class="nav-link hvr-bounce-in" id="conection-tab" data-toggle="tab" href="#conection" role="tab" aria-controls="conection" aria-selected="false">
                            <i class="fas fa-boxes"></i> Conexiones del usuario
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="row">
                            <div class="col-12 col-sm-10 offset-sm-1">
                                <?php foreach ($usuario as $user):?>
                                    <div class="mb-3 mt-5" >
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="card-title tex">
                                                    <i class="far fa-user"></i>
                                                    <?php echo (isset($user->nombre))? $user->nombre : FALSE;?>
                                                    <?php echo (isset($user->apellido))? $user->apellido : FALSE;?>
                                                    <?php echo (isset($user->sApellido))? $user->sApellido : FALSE;?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-12 col-sm-6">
                                                <i class="fas fa-venus-mars"></i> Sexo:
                                                <?php echo $genero[$user->genero];?>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <i class="fas fa-user-tag"></i> Usuario:
                                                <?php echo $user->usuario;?>
                                            </div>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-12 col-sm-6">
                                                <i class="fas fa-at"></i> Correo electónico:
                                                <?php echo $user->correo;?>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <i class="fas fa-user-check"></i> Estado:
                                                <?php echo ($user->activo == 0)? 'Inactivo' : 'Activo';?>
                                            </div>

                                        </div>
                                        <div class="row p-3">
                                            <div class="col">
                                                <i class="fas fa-cash-register"></i> Fecha de registro:
                                                <?php echo $user->registro;?>
                                            </div>
                                            <div class="col">
                                                <i class="fas fa-calendar-check"></i> Fecha de activación:
                                                <?php echo $user->activacion;?>
                                            </div>
                                            <div class="col">
                                                <i class="fas fa-exchange-alt"></i> Fecha de modificación:
                                                <?php echo $user->modificacion;?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <a class="btn btn-info" href="<?php echo base_url('usuarios/editarUsuario/'. $this->uri->segment(3));?>">
                                                    <span class="fa fa-eye"></span>&nbsp; Editar
                                                </a>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalPass">
                                                    Cambiar Contraseña
                                                </button>
                                            </div>
                                            <?php if ($user->activo == 1):?>
                                                <div class="col">
                                                    <a class="btn btn-danger" href="<?php echo base_url('usuarios/baja/'. $this->uri->segment(3));?>">
                                                        <span class="fas fa-ban"></span>&nbsp; Dar de baja
                                                    </a>
                                                </div>
                                            <?php else:?>
                                                <div class="col">
                                                    <a class="btn btn-success" href="<?php echo base_url('usuarios/reactivar/'. $this->uri->segment(3));?>">
                                                        <span class="far fa-check-circle"></span>&nbsp;Reactivar usuario
                                                    </a>
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-12 col-sm-10 offset-sm-1">
                                <?php foreach ($usuario as $user):?>
                                    <div class="row mt-5">
                                        <h5 class="card-title">Permisos de usuarios</h5>
                                    </div>
                                    <div class="row p-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="permiso" class="control-label">Tipo de Usuario:</label>
                                                <?php
                                                echo form_dropdown('permiso',$permiso, set_value('permiso', (isset($user->permiso) ? $user->permiso : '')),'id="permiso" class="selectpicker"');
                                                ?>
                                                <small class="form-text text-muted">*Campo obligatorio</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ejercicio" class="control-label">Ejercicios:</label>
                                                <?php
                                                echo form_dropdown('ejercicio',$ejercicio, set_value('ejercicio', (isset($user->permiso) ? $user->permiso : '')),'id="ejercicio" class="selectpicker" multiple');
                                                ?>
                                                <small class="form-text text-muted">*Campo obligatorio</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <h5 class="card-title">Permisos (URGs y ROs)</h5>
                                    </div>
                                    <?php echo $inputs; ?>
                                    <div class="row mb-3 mt-2">
                                        <div class="col-md-12">
                                            <button class="btn btn-outline-success float-right" id="btnAsignar">
                                                Aplicar
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="conection" role="tabpanel" aria-labelledby="conection-tab">
                        <div class="row">
                            <div class="col-sm-10 offset-sm-1">
                                <h3>Tabla con las últimas conexiones del usuario</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 offset-sm-1">
                                <!--Empieza tabla-->
                                <?php if (isset($table)) echo $table;?>
                            </div>
                        </div>
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
            <form class="" action="<?php echo base_url('usuarios/cambiarpassword/' . $this->uri->segment(3));?>" method="post">
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
