var syncerWatchPosition = {
    count: 0,
    lastTime: 0,
    map: null,
    marker: null
};

function successFunc(position) {
    var nowTime = ~~( new Date() / 1000 );	// UNIX Timestamp

    if ((syncerWatchPosition.lastTime + 1) > nowTime) {
        return false;
    }

    syncerWatchPosition.lastTime = nowTime;

    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    if (syncerWatchPosition.map == null) {
        syncerWatchPosition.map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 15,
            center: latlng
        });

        syncerWatchPosition.marker = new google.maps.Marker({
            map: syncerWatchPosition.map,
            position: latlng
        });
    }
    else {
        syncerWatchPosition.map.setCenter(latlng);
        syncerWatchPosition.marker.setPosition(latlng);
    }
}

function errorFunc(error) {
    var errorMessage = {
        0: "Error: Cause unknown error",
        1: "Error: Permission denied",
        2: "Error: Could not get a GPS position",
        3: "Error: Timeout"
    };

    alert(errorMessage[error.code]);
}

var optionObj = {
    "enableHighAccuracy": false,
    "timeout": 1000000,
    "maximumAge": 0
};

navigator.geolocation.watchPosition(successFunc, errorFunc, optionObj);
