
function fnShowPosition(pos) {
	//alert("geolocation API를 사용할 수 있습니다.");
	window.location.href="result_geo.php";
}

function fnError() {
	alert("오류가 발생해 위치정보를 얻어오지 못했습니다.");
}

function callGeolocation() {
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(fnShowPosition, fnError);
	}
	else {
		alert("geolocation API를 사용할 수 없습니다.");
	}
}

var elGps = document.getElementById('gps');
elGps.onclick = callGeolocation;