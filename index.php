<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- leaflet css link  -->
    <link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    />

    <title>Web-GIS with Geoserver and Leaflet</title>

    <style>
      body {
        margin: 0;
        padding: 0;
      }
      #map {
        width: 100%;
        height: 100vh;
      }
    </style>
  </head>

  <body>
    <div id="map"></div>

    <!-- leaflet js link  -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
      // BASE MAP
      var map = L.map("map").setView([-7.732521, 110.402376], 11);

      var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "© OpenStreetMap contributors",
      }).addTo(map);

      // LAYER WMS DARI GEOSERVER

      // 1. BATAS ADMINISTRASI
      var desa = L.tileLayer.wms(
        "http://localhost:8080/geoserver/pgweb/wms",
        {
          layers: "pgweb:ADMINKEC_SLEMAN_FIXPOL",
          format: "image/png",
          transparent: true
        }
      ).addTo(map);

      // 2. JALAN_LN_25K
      var jalan = L.tileLayer.wms(
        "http://localhost:8080/geoserver/pgweb/wms",
        {
          layers: "pgweb:JALAN_LN_25K",
          format: "image/png",
          transparent: true
        }
      ).addTo(map);

      // 3. data_kecamatan
      var kecamatan = L.tileLayer.wms(
        "http://localhost:8080/geoserver/pgweb/wms",
        {
          layers: "pgweb:penduduk_sleman_view",
          format: "image/png",
          transparent: true
        }
      ).addTo(map);

        // Layer WMS: Jalan Kabupaten Sleman
        var wmsLayer2 = L.tileLayer.wms("https://geoportal.slemankab.go.id/geoserver/geonode/wms", {
            layers: "geonode:jalan_kabupaten_sleman_2023",
            format: "image/png",
            transparent: true,
            crs: L.CRS.EPSG4326
        });
        wmsLayer2.addTo(map);


      // LAYER CONTROL
      var overlayLayers = {
        "Administrasi kecamatan (AR_25K)": desa,
        "Jalan 25K": jalan,
        "Data Kecamatan": kecamatan,
        "Jalan Portal": wmsLayer2
      };

      L.control.layers(null, overlayLayers).addTo(map);

    </script>
  </body>

</html>
