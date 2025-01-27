<?php 
 	//Informacion del encabezado
	headerAdmin($data);
  getModal('modelStreetView', $data);
?>

<!-- Contenido de la plataforma INICIO -->
 <div class="right_col" role="main">

  <!-- Agregar btn flotante -->
   <div class="contenedor">
        <button class="btn-flotante-inicio btn btn-round btn-primary " id="btn-toggle-inicio"><i class="fa fa-home" name="btn-inicio"></i></button>
        <button class="btn-flotante btn btn-round btn-primary " id="btn-toggle">+</button>
        <div id="info" class="info">
            <div id="info-list"></div>
        </div>
   </div>

   <!-- Spinner que permite mostrar que se estar cargando la informa -->
    <div id="spinner" class="spinner"></div>
   <!-- Informacion del mapa -->
    <div id="map"></div>
    <div>
      <label for="layer-switcher" style="display:none">Selecciona una capa:</label>
      <select id="layer-switcher" class="form-control form-control-sm">>
        <option value="terrain">Relieve</option>
        <option value="satellite">Satélite</option>
        <option value="traffic">Tráfico</option>
      </select>
    </div>
 </div>

 </div>
 </div>
 
  
<script>
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
      key: "AIzaSyAdiMTUFD30u4Qi79dB4suIWf5liRTlaZs",
      v: "beta",
      // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
      // Add other bootstrap parameters as needed, using camel case.
    });
  </script>
    

    <!-- MarkerClusterer CDN -->
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>

 <?php 

 	// Informacion del footer
 	footerAdmin($data);
  ?>

