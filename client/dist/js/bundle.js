(function ($) {
  function initialize() {
    $('.editablemapfield_map_container').each(function () {
      var drawingManager,
        selectedShape = null,
        lastShape = null,
        selectedColor,
        colorButtons = {},
        $container = $(this),
        $map = $('<div class="map"/>').appendTo($container)

      function exportCoordinates(polygon) {
        var out = new Array()
        polygon.getPath().forEach(function (ll) {
          out.push(ll.lat() + ',' + ll.lng())
        })

        $container.next('input').val(out.join(';'))
      }

      function clearSelection() {
        if (selectedShape) selectedShape.setEditable(false)
        selectedShape = null;
      }

      function setSelection(shape) {
        clearSelection();
        shape.setEditable(true);
        selectedShape = shape;
      }

      function deleteSelectedShape() {
        if (selectedShape) {
          selectedShape.setMap(null);
        }
      }

      var map = new google.maps.Map($map[0], {
        zoom: 16,
        center: new google.maps.LatLng(
          $container.data('lat') ? $container.data('lat') : -45.8791459,
          $container.data('long') ? $container.data('long') : 170.501069
        ),
        mapTypeId: google.maps.MapTypeId.SATELLITE,
        disableDefaultUI: true,
        zoomControl: true
      });

      var polyOptions = {
        strokeWeight: 0,
        fillOpacity: 0.45,
        editable: true,
        draggable: true,
        fillColor: '#FF1493',
      };
      // Creates a drawing manager attached to the map that allows the user to draw
      // markers, lines, and shapes.
      drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControlOptions: {
          drawingModes: ['polygon']
        },
        polygonOptions: polyOptions,
        map: map
      });

      google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
        if(lastShape) lastShape.setMap(null)
        drawingManager.setDrawingMode(null);

        google.maps.event.addListener(polygon, 'click', function (e) {
          if (e.vertex !== undefined) {
            var path = polygon.getPaths().getAt(e.path);
            path.removeAt(e.vertex);
            if (path.length < 3) {
              polygon.setMap(null);
            }
          }
          setSelection(polygon);

          google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
            exportCoordinates(polygon)
          });

          google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
            exportCoordinates(polygon)
          });
        })

        lastShape = polygon
        setSelection(polygon)
        exportCoordinates(polygon)
      })

      // Clear the current selection when the drawing mode is changed, or when the
      // map is clicked.
      google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
      google.maps.event.addListener(map, 'click', clearSelection);
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);
})(jQuery)

var z
