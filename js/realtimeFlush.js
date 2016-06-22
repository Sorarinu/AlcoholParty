/**
 * Created by Sorarinu on 2016/06/22.
 */
$(document).ready(function (){
    setInterval(function() {
        $.ajax({
            type: 'POST',
            url: 'getConnection.php',
            cache: false,
            dataType: 'text',
            success: function(data) {
                document.getElementById('after').style.display = "block";
                $('#after_detail').html(data);
            },
            error: function() {
                //alert("読み込み失敗");
            }
        });
    }, 3000);
});