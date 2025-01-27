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
            <form id="form-historico" name="form-historico">
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
                <!-- Btn que permite consultar la informacion -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="color: white">Btn consulta</label>
                        <button type="submit" class="form-control form-control-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> CONSULTAR</button>
                    </div>
                </div>

            </form>
            <!-- Espacio para agregar el spinner  -->
            <div id="spinner" class="spinner" ></div>
        </div>
    </div> 

    <!-- MAP -->
    <div class="x_panel" id="x_map" style="display: none;">
        <div class="row">
            <div class="col-md-12">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <!-- INFORMACION DE LA TABLA -->
     <div class="x_panel" id="x_tb" style="display: none;">
        <div class="clearfix"></div>
        <div class="x_content">
            <div class="col-md-12 div-tb">
                <table class="table table-bordered datatable-fixed-header">
                    <thead>
                        <tr>
                            <th>Desplazamiento</th>
                            <th>Horas Operacion ( H:m )</th>
                            <th>Horas Ralenti ( H:m )</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-resumenDesplazamiento"></tbody>
                </table>
            </div>
            <div class="col-md-12 div-tb" >
                <table  class="table table-bordered datatable-fixed-header" >
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Posición</th>
                            <th>Ignición</th>
                            <th>Velocidad</th>
                            <th>Evento</th>
                        </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                </table>
            </div>
        </div>        
     </div>
</div>


 <?php 
    footerAdmin($data);
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdiMTUFD30u4Qi79dB4suIWf5liRTlaZs&signed_in=true"></script> 


