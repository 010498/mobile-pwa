
<div class="modal fade" id="streetViewModal" tabindex="-1" role="dialog" aria-labelledby="streetViewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="streetViewModalLabel">Street View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Street View Content -->
                <div id="street-view-container" style="height: 400px;">
                    <!-- Google Street View will be embedded here -->
                        <div id="mapStreet"></div>
                        <div id="pano"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mostrar mapa con la posicon en streetView -->
<script>


function initialize(lat, lng) {
    const fenway = { lat: parseFloat(lat), lng: parseFloat(lng) };
      const map = new google.maps.Map(document.getElementById("mapStreet"), {
        center: fenway,
        zoom: 14,
      });

      new google.maps.Marker({
        position: fenway,
        map,
      
      });

      const panorama = new google.maps.StreetViewPanorama(
        document.getElementById("pano"),
        {
          position: fenway,
          pov: {
            heading: 34,
            pitch: 10,
          },
        }
      );

      map.setStreetView(panorama);
    }



    window.initialize = initialize;
</script>
