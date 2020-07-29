<div class="container">
    <div class="row">
        <?php
        echo "<div class='col'>";
        if(isset($mensaje)) echo $mensaje;
        if(validation_errors()!=""){
            echo '<div class="errormsj" > <span> Error </span>'.validation_errors().'</div>';
        }
        echo "</div>";
        ?>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Lista de usuarios
                                <a href="<?php echo base_url('usuarios/nuevoUsuario');?>">
                                    <button type="button" class="btn btn-success float-right" >Agregar</button>
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3>Tabla con los registros de usuarios</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered" id="tablaUsuarios" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Área de Adscripción</th>
                                    <th>Ultima Conexión</th>
                                    <th>Estatus</th>
                                    <th>Opción</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ( $listado_personal && count((array)$listado_personal) > 0 ):?>
                                    <?php foreach ($listado_personal as $info): ?>
                                        <tr>
                                            <td><?php echo $info['usuario'];?></td>
                                            <td><?php echo $info['nombre'];?></td>
                                            <td><?php echo $info['anom'];?></td>
                                            <td><?php echo $info['ingreso'];?></td>
                                            <td><?php echo $info['activo'];?></td>
                                            <td align="center">
                                                <a class="btn btn-info" href="<?php echo base_url('usuarios/verUsuario/'. $info['nsf'])?>">
                                                    <span class="fa fa-eye"></span>&nbsp; Detalle
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php else:?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">No hay registros</td>
                                    </tr>
                                <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Example DataTables Card-->
</div>
