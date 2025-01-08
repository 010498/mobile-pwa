

   <!-- Constante que permite obtener siempre el enlace -->
   <script>
      const base_url = "<?= base_url() ?>";
   </script>
  
    <!-- jQuery -->
    <script src="<?= media() ?>/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= media() ?>/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="<?= media() ?>/vendors/fastclick/lib/fastclick.js"></script>
    <!-- Skycons -->
    <script src="<?= media() ?>/vendors/skycons/skycons.js"></script>
    <!-- DateJS -->
    <script src="<?= media() ?>/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?= media() ?>/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?= media() ?>/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?= media() ?>/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?= media() ?>/vendors/moment/min/moment.min.js"></script>
    <script src="<?= media() ?>/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?= media() ?>/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
   
    <!-- Custom Theme Scripts -->
    <script src="<?= media() ?>/vendors/custom.min.js"></script>

    <script type="module" src="<?= media() ?>/js/local/<?= $data['data_functions_js'] ?>"></script>
    <script type="module" src="<?= media() ?>/js/<?= $data['app'] ?>"></script>
    




  </body>
</html>
