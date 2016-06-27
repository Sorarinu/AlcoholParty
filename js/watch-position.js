var syncerWatchPosition = {
    count: 0,
    lastTime: 0,
    map: null,
    marker: null
};

function isSuccess(req)
{
    return (req.readyState == 4 && req.status == 200) ? true : false;
}

function successFunc(position) {
    ++syncerWatchPosition.count;
    console.log("GetLocation Start: " + syncerWatchPosition.count);
    var req = new XMLHttpRequest();
    var nowTime = ~~( new Date() / 1000 );	// UNIX Timestamp
    var users;
    var i = 0;

    if ((syncerWatchPosition.lastTime + 3) > nowTime) {
        return false;
    }

    syncerWatchPosition.lastTime = nowTime;

    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    req.onreadystatechange = function () {
        if(isSuccess(req)) {
            console.log(req.responseText);
            users = JSON.parse(req.responseText);

            if (syncerWatchPosition.map == null) {
                syncerWatchPosition.map = new google.maps.Map(document.getElementById('map-canvas'), {
                    zoom: 15,
                    center: latlng
                });

                syncerWatchPosition.marker = null;

                for(i = 0; i < users.length; i++)
                {
                    console.log(users[i]["user"]);
                    console.log("Session: " + users[i]["session"]);

                    latlng = new google.maps.LatLng({
                        lat: users[i]["latitude"],
                        lng: users[i]["longitude"]
                    });

                    syncerWatchPosition.marker = new google.maps.Marker({
                        position: latlng,
                        map: syncerWatchPosition.map
                    });
                }
            }
            else {
                var users = JSON.parse(req.responseText);

                syncerWatchPosition.marker = null;

                for(i = 0; i < users.length; i++) {
                    console.log(users[i]["user"]);
                    console.log("Session: " + users[i]["session"]);

                    latlng = new google.maps.LatLng({
                        lat: users[i]["latitude"],
                        lng: users[i]["longitude"]
                    });

                    syncerWatchPosition.marker = new google.maps.Marker({
                        position: latlng,
                        map: syncerWatchPosition.map
                    });

                    if (users[j]["user"] == users[j]["session"]) {
                        syncerWatchPosition.map.setCenter(latlng);
                    }
                    syncerWatchPosition.marker.setPosition(latlng);
                }
            }
        }
    };

    req.open('POST', '/AlcoholParty/jsMysql.php', true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send('latitude=' + position.coords.latitude + '&longitude=' + position.coords.longitude);
}

function errorFunc(error) {
    var errorMessage = {
        0: "Error: Cause unknown error",
        1: "Error: Permission denied",
        2: "Error: Could not get a GPS position",
        3: "Error: Timeout"
    };

    //alert(errorMessage[error.code]);
}

var optionObj = {
    "enableHighAccuracy": false,
    "timeout": 10000000,
    "maximumAge": 0
};

navigator.geolocation.watchPosition(successFunc, errorFunc, optionObj);
