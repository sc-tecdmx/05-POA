<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#pesos">Gráficas del avance</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#avances">Avances</a>
        </li>
    </ul>

    <div class="tab-content clearfix">
        <div class="tab-pane active" id="pesos">
            <!--<canvas id="myChart"></canvas>-->
           <div class="row mt-5">
               <div class="col-12">
                   <div id="pie" style="width: 700px;height:500px;"></div>
               </div>
           </div>
        </div>
        <div class="tab-pane" id="avances">
            <div class="row">
                <div class="col-12">
                <canvas id="chartProgress"></canvas>
                <!--<div id="barras" style="width: 700px;height:500px;"></div>-->
                </div>
            </div>

            <!--<canvas id="chartProgress"></canvas>-->
        </div>
    </div>
</div>
