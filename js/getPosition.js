/**
 * Created by Sorarinu on 2016/06/28.
 */
jQuery(function ($) {
    if (!navigator.geolocation) {
        $("#map-canvas").text("お使いの端末はGPS非対応です．");
        return false;
    }

    var optionObj = {
        "enableHighAccuracy": true,
        "timeout": 10000000,
        "maximumAge": 0
    };

    var req = new XMLHttpRequest();
    var maps = null;
    var markerArray = new google.maps.MVCArray();
    var nowTime = ~~( new Date() / 1000 );	// UNIX Timestamp
    var lastTime = 0;

    if ((lastTime + 3) > nowTime) {
        return false;
    }
    lastTime = nowTime;

    $("#map-canvas").text("Getting for GPS Location...");

    navigator.geolocation.watchPosition(function (position) {
        req.onreadystatechange = function () {
            if(isSuccess(req)){
                var users = JSON.parse(req.responseText);

                if(maps == null) {
                    maps = new google.maps.Map($("#map-canvas").get(0), {
                        center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        zoom: 15
                    });
                }

                console.log(users.length);
                console.log(users);

                markerArray.forEach(function(marker, i){
                   marker.setMap(null);
                });

                for(var i = 0; i < users.length; i++){
                    var currentPosition = new google.maps.LatLng(users[i]["latitude"], users[i]["longitude"]);
                    currentMarker = new google.maps.Marker({
                        position: currentPosition
                    });
                    var markerInfo = new google.maps.InfoWindow({
                       content: users[i]["user"]
                    });
                    markerArray.push(currentMarker);
                    currentMarker.setMap(maps);
                    markerInfo.open(maps, currentMarker);
                }
            }
        };

        req.open('POST', '/AlcoholParty/jsMysql.php', true);
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.send('latitude=' + position.coords.latitude + '&longitude=' + position.coords.longitude);
    }, function () {
        $("#map-canvas").text("位置情報の取得が出来ませんでした．");
        return false;
    }, optionObj);
});

function isSuccess(req)
{
    return (req.readyState == 4 && req.status == 200) ? true : false;
}