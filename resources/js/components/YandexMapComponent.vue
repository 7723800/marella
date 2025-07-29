<template>
    <div class="y-map">
        <div id="map"></div>

    </div>
</template>

<script>
import ymaps from 'ymaps';

export default {
  mounted() {
    this.mapInit()
  },
  methods: {
   mapInit() {
      const mapContainer = document.getElementById('map');
      ymaps
        .load('https://api-maps.yandex.ru/2.1/?lang=ru_RU')
        .then(maps => {
          const map = new maps.Map(mapContainer, {
            center: [ 51.161808, 71.425104 ],
            zoom: 17
          },{
            searchControlProvider: 'yandex#search'
        });
        map.behaviors.disable('drag');
        let placemark = new maps.Placemark([ 51.161788, 71.425004 ], null, {
            iconLayout: 'default#image',
            iconImageHref: 'images/donato-logo.png',
            iconImageSize: [50, 18],
            iconImageOffset: [-10, -45]
        });
        map.geoObjects
          .add(placemark)
      })
      .catch(error => console.log('Failed to load Yandex Maps', error));
    },
  }
}
</script>

<style lang="scss">
.y-map {
    #map {
        height: 70vh;
        margin: 2rem -1rem;
            @include get-media($laptop, $desktop) {
            height: 360px;
            margin: auto 0;
        }
    }
}

</style>
