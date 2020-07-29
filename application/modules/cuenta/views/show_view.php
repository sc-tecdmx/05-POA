<div class="card">
    <div class="card-header">
        <div class="row m-2">
            <div class="col">
                <h3 class="card-text">
                    Detalle del inmueble
                </h3>
            </div>
            <div class="col">
                <h3 class="card-text">
                    <a href="<?php echo base_url('operaciones/inmuebles'); ?>" class="btn btn-danger float-right">Regresar</a>
                </h3>
            </div>
        </div>
    </div>
    <div id="integration-list">
        <ul>
            <li>
                <a class="expand">
                    <div class="right-arrow">+</div>
                    <div>
                        <h2>Datos</h2>
                        <span></span>
                    </div>
                </a>

                <div class="detail">
                    
                    <div id="right" style="width:85%;float:right;height:100%;padding-left:20px;">
                        <div id="sup">
                            <div><span>
                                <?php if(is_array($cct)): ?>
                                CCT:
                                <?php foreach($cct as $ren){
                                    echo '<a href="'.base_url().'operaciones/cct/detalles/'.$ren->id_cct.'">'.$ren->cct.'</a>&nbsp;&nbsp;';
                                } ?>
                                <?php endif; ?><br />
                                Nivel: <?php echo $ren->nivel;?><br />
                                Tipo: <?php echo $ren->tipo;?><br>
                                Marginación Localidad: <?php echo $row->marginacion_localidad;?>
                                Localidad indigena: <?php echo $row->localidad_indigena;?><br>
                                21 regiones por violencia: <?php echo $row->regiones_violencia;?><br>
                                Fecha alta: <?php echo $row->fecha_alta;?>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a class="expand">
                    <div class="right-arrow">+</div>
                    <h2>Dirección</h2>
                    <span></span>
                </a>

                <div class="detail">
                
                    <div id="right" style="width:85%;float:right;height:100%;padding-left:20px;">
                        <div id="sup">
                            <div>
                                <span>
                                    Domicilio: <?php echo $row->domicilio;?><br>
                                    Estado: <?php echo $row->entidad_federativa;?><br>
                                    Municipio: <?php echo $row->municipio;?><br>
                                    Localidad: <?php echo $row->localidad;?><br>
                                    Código Postal: <?php echo $row->codigo_postal;?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a class="expand">
                    <div class="right-arrow">+</div>
                    <h2>Georeferencia</h2>
                    <span></span>
                </a>

                <div class="detail">
                
                    <div id="right" style="width:85%;float:right;height:100%;padding-left:20px;">
                        <div id="sup">
                            <div>
                                <span>
                                    Latitud: <?php echo $row->latitud;?><br>
                                    Longitud: <?php echo $row->longitud;?><br>
                                    Liga Google Maps: <a class="text-dark"" href="<?php echo $row->liga_google_maps;?>" target="_blank"><?php echo $row->cuie;?></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a class="expand">
                    <div class="right-arrow">+</div>
                    <h2>Observaciones</h2>
                    <span></span>
                </a>

                <div class="detail">
                
                    <div id="right" style="width:85%;float:right;height:100%;padding-left:20px;">
                        <div id="sup">
                            <div><span><?php echo $row->observaciones;?></span>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        
        </ul>
    </div>
</div>    