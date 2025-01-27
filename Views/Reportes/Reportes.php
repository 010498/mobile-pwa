<!-- Permite agregar la informacion del encabezado -->
<?php  
    headerAdmin($data);
?>

<!-- Estructura de la pagina -->
 <div class="right_col" role="main">
    <!-- FORM -->
    <div class="x_panel">
          
        <!-- Seleccionar placa -->
        <div class="row">
            <form id="form-reportes" name="form-reportes">
                <div class="col-md-3">
                    <!-- Informacion que permite seleccionar placa -->
                    <div class="form-group">
                        <label for="">Seleccionar placa</label>
                        <select class="form-control form-control-sm" id="select-placa" name="select-placa" required></select>
                    </div>
                </div>
                <!-- Informacion fecha inicial -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fecha Inicial</label>
                        <div class="input-group date" >
                            <input type="text" class="date-picker form-control form-control-sm" id="fechaInicial" name="fechaInicial" autocomplete="off" required>
                            <span class="input-group-addon">
                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Informacion de fecha final -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fecha Final</label>
                        <div class="input-group date" >
                            <input type="text" class="date-picker form-control form-control-sm" id="fechaFinal" name="fechaFinal" autocomplete="off" required>
                            <span class="input-group-addon">
                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Informacion del tipo de soporte -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tipo de soporte</label>
                        <select class="form-control form-control-sm" id="select-soporte" name="select-soporte" required>
                            <option value="0">Seleccionar reporte</option>
                            <option value="1">EXC VELOCIDAD</option>
                            <option value="2">HORAS DE OPERACION</option>
                            <option value="3">TEMPERATURA</option>
                            <!-- <option value="4">COMBUSTIBLE</option> -->
                        </select>
                    </div>
                </div>
                <!--    Opcion de exc de velocidad -->
                <div class="col-md-3" id="dtVelocidad">
                    <div class="form-group">
                        <label for="">Exc de velocidad</label>
                        <input type="text" class="form-control form-control-sm" id="exc-velocidad" name="exc-velocidad" autocomplete="off" value="80">
                    </div>
                </div>

                <!-- Btn que permite consultar la informacion -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="color: white">Btn consulta</label>
                        <button type="submit" class="form-control form-control-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> CONSULTAR</button>
                    </div>
                </div>
            </form>
            <div id="spinner" class="spinner" ></div>
        </div>
    </div> 

    <!-- <div id="spinnerLoad"></div> -->
    <!-- TABLA EXC VELOCIDAD -->
     <div class="x_panel" id="x_tb" style="display: none;">
        <div class="clearfix"></div>
        <div class="x_content">
            <!-- Tabla con el resumen de los excesos -->
            <div class="col-md-12 div-tb">
                <table class="table table-bordered datatable-fixed-header" >
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Excesos </th>
                            <th>Distancia</th>
                            <th>Vel Max</th>
                            <th>Vel Prom</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-resumen"></tbody>
                </table>
             </div>
            <!-- Tabla con el historial de los excesos -->
            <div class="col-md-12 div-tb" >
                <table class="table table-bordered datatable-fixed-header">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Posicion</th>
                            <th>Velocidad</th>
                            <th>Evento</th>
                        </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                </table>
            </div>
            <br>
            <!-- Informacion del mapa, donde se refleja la informacion de los exceoss -->
            <div class="col-md-12" style="margin-top: 10px;">
                <div id="map"></div>
            </div>
             <!-- / Mapa -->
        </div>
     </div>
     <!-- TABLA CON LA INFORMACION DE LAS OPERACIONES -->
      <!-- TABLA HORAS DE OPERACION -->
     <div class="x_panel" id="x_tb_operacion" style="display: none;">
        <div class="clearfix"></div>
        <div class="x_content">
            <div class="col-md-12 div-tb">
                <table  class="table table-bordered datatable-fixed-header">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tiempo ( H:m )</th>
                            <th>Desplazamiento ( KM )</th>
                            <th>Velocidad Proemdio</th>
                            <th>Velocidad Maxima</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-operacion"></tbody>
                </table>
            </div>
        </div>
     </div>

     <!-- TABLA QUE PERMITE MOSTRAR LA INFORMACION DEL RESUMEN E HISTORICO DE LA TEMPERATURA DE THERMO -->
      <div class="x_panel" id="x_tb_temperatura" style="display: none">
        <div class="clearfix"></div>
        <div class="x_content">
            <div class="col-md-12 div-tb">
                <table class="table table-bordered datatable-fixed-header ">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Temperatura Max</th>
                            <th>Temperatura Min</th>
                            <th>Temperatura Pro</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-resumen-temp"></tbody>
                </table>
            </div>
            <div class="col-md-12 div-tb">
                <table class="table table-bordered datatable-fixed-header">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Posicion</th>
                            <th>Temperatura</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-temp"></tbody>
                </table>
            </div>
        </div>
      </div>

      <!-- TABLA QUE PERMITE MOSTRAR LA INFORMACION DETALLADA DE COMBUSTIBLE -->
       <div class="x_panel" id="x_tb_combustible" style="display: none">
        <div class="clearfix"></div>
        <div class="x_content">
            <!-- TABLA CON LA INFORMACION DEL CARGUE -->
            <div class="col-md-12 div-tb" >
                <table class="table table-bordered datatable-fixed-header" >
                    <thead>
                        <tr>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>Total Combustible</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-cargue"></tbody>
                </table>
            </div>
            <!-- TABLA CON LA INFORMACION DEL CONSUMO -->
             <div class="col-md-12 div-tb">
                <table class="table table-bordered datatable-fixed-header">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Consumo</th>
                            <th>Desplazamiento</th>
                            <th>Promedio</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-consumo"></tbody>
                </table>
             </div>
             <!-- TABLA CON LA INFORMACION DEL DESCARGUE -->
              <div class="col-md-12 div-tb">
                <table class="table table-bordered datatable-fixed-header">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Descargue</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-descargue"></tbody>
                </table>
              </div>
        </div>
       </div>
    

   
</div>


 <?php 
    footerAdmin($data);
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdiMTUFD30u4Qi79dB4suIWf5liRTlaZs&signed_in=true"></script>

