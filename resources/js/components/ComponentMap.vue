<template>
    <div>
  <GmapMap
    :center="center"
    :zoom="18"
    map-style-id="roadmap"
    :options="mapOptions"
    style="width: 100vmin; height: 50vmin"
    ref="mapRef"
    @click="handleMapClick"
  >
    <GmapMarker
      :position="marker.position"
      :clickable="true"
      :draggable="true"
      @drag="handleMarkerDrag"
      @click="panToMarker"
    />
  </GmapMap>
  <button @click="geolocate">Detect Location</button>

  <p>Selected Position: {{ marker.position }}</p>
</div>

</template>

<script>
export default {
      data() {
    return {
      marker: { position: { lat: 10, lng: 10 } },
      center: { lat: 10, lng: 10 },

      mapOptions: {
        disableDefaultUI: true,
      },
    };
  },

   methods: {
    //detects location from browser
    geolocate() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.marker.position = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };

        this.panToMarker();
      });
    },

    //sets the position of marker when dragged
    handleMarkerDrag(e) {
      this.marker.position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
    },

    //Moves the map view port to marker
    panToMarker() {
      this.$refs.mapRef.panTo(this.marker.position);
      this.$refs.mapRef.setZoom(18);
    },

    //Moves the marker to click position on the map
    handleMapClick(e) {
      this.marker.position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
      console.log(e);
    },
  },
   mounted() {
    this.geolocate();
  },

};


</script>
