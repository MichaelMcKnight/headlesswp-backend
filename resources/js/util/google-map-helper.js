/* global google */

import $ from 'jquery';

const GoogleMapHelpers = () => {
  const retroStyle = [
    {elementType: 'geometry', stylers: [{color: '#ebe3cd'}]},
    {elementType: 'labels.text.fill', stylers: [{color: '#523735'}]},
    {elementType: 'labels.text.stroke', stylers: [{color: '#f5f1e6'}]},
    {
      featureType: 'administrative',
      elementType: 'geometry.stroke',
      stylers: [{color: '#c9b2a6'}],
    },
    {featureType: 'poi', stylers: [{visibility: 'off'}]},
    {
      featureType: 'road',
      elementType: 'geometry',
      stylers: [{color: '#ffffff'}],
    },
    {
      featureType: 'water',
      elementType: 'geometry.fill',
      stylers: [{color: '#b9d3c2'}],
    },
  ];

  function initMarker($marker, map) {
    const lat = $marker.data('lat');
    const lng = $marker.data('lng');
    const latLng = {lat: parseFloat(lat), lng: parseFloat(lng)};

    const marker = new google.maps.Marker({
      position: latLng,
      map: map,
      icon: {
        url:
          'data:image/svg+xml;charset=UTF-8,' +
          encodeURIComponent(`
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="42" viewBox="0 0 30 42">
              <path fill="#8e5122" d="M15,0 C6.71572875,0 0,6.71572875 0,15 C0,25.5 15,42 15,42 C15,42 30,25.5 30,15 C30,6.71572875 23.2842712,0 15,0 Z"/>
              <circle fill="#fff" cx="15" cy="15" r="6"/>
            </svg>
          `),
        scaledSize: new google.maps.Size(30, 42),
      },
    });

    map.markers.push(marker);

    if ($marker.html()) {
      const infowindow = new google.maps.InfoWindow({
        content: $marker.html(),
      });

      google.maps.event.addListener(marker, 'click', () => {
        infowindow.open(map, marker);
      });
    }
  }

  function centerMap(map) {
    const bounds = new google.maps.LatLngBounds();
    map.markers.forEach((marker) => {
      bounds.extend(marker.getPosition());
    });

    if (map.markers.length === 1) {
      map.setCenter(bounds.getCenter());
    } else {
      map.fitBounds(bounds);
    }
  }

  function initMap($el) {
    if ($el[0].dataset.mapInitialized) return;
    $el[0].dataset.mapInitialized = 'true';

    const $markers = $el.find('.marker');

    const mapArgs = {
      zoom: $el.data('zoom') || 16,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: retroStyle,
    };

    const map = new google.maps.Map($el[0], mapArgs);
    map.markers = [];

    $markers.each(function () {
      initMarker($(this), map);
    });

    centerMap(map);
  }

  function observeMaps() {
    $('.acf-map').each(function () {
      initMap($(this));
    });

    const observer = new MutationObserver(() => {
      $('.acf-map').each(function () {
        initMap($(this));
      });
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true,
    });
  }

  // Start once document is ready
  $(document).ready(() => {
    if (typeof google !== 'undefined' && google.maps) {
      observeMaps();
    } else {
      console.warn('Google Maps API not loaded.');
    }
  });
};

export default GoogleMapHelpers;
