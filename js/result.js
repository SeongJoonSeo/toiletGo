		// gps 아이콘을 눌렀을 때 자신의 위치 주변의 지도로 바뀌게 하는 함수
		function moveMap() {
		   if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(success, fail);
		} else {
			document.getElementById('map').textContent = "지원X";
		}
	   };
	   
	   // geolocation api를 쓸 수 있을 때 쓰는 함수
	   function success(location) {
		   
			var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
				mapOption = { 
					center: new daum.maps.LatLng(location.coords.latitude, location.coords.longitude), // 지도의 중심좌표
					level: 5 // 지도의 확대 레벨
				};
			var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
			
			var position2 = new daum.maps.LatLng(location.coords.latitude, location.coords.longitude);
			var imageSrc = 'img/loc2.png', // 마커이미지의 주소입니다    
			imageSize = new daum.maps.Size(26, 45), // 마커이미지의 크기입니다
			imageOption = {offset: new daum.maps.Point(13, 45)}; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다.
			
			// 마커의 이미지정보를 가지고 있는 마커이미지를 생성합니다
			var markerImage = new daum.maps.MarkerImage(imageSrc, imageSize, imageOption);
			
			var marker2 = new daum.maps.Marker({ // 현재 위치를 나타낼 마커 생성
				position: position2,
				image: markerImage, // 마커이미지 설정 
				clickable: true // 마커를 클릭했을 때 지도의 클릭 이벤트(기본 설정: 아무 일도 일어나지 않는 것)가 발생하지 않도록 설정합니다
			});
			marker2.setMap(map);
		}
		// geolocation api를 쓸 수 없을 때 쓰는 함수
		function fail() {
			document.getElementById('map').textContent = "못 찾음";
		}
		// gps 아이콘 눌렀을 때 이벤트 발생
	   var elGPS = document.getElementById('gps');
	   elGPS.addEventListener('click', moveMap, false);
	   


	   // 좌표값을 받아서 지도 생성
/*	   function makeMap(coords, buildname, lati, long,b_no) {
			var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
				mapOption = { 
					center: coords, // 지도의 중심좌표
					level: 5 // 지도의 확대 레벨
				};
			
			var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다.
								// 마커가 표시될 위치입니다 
			 for(var i=0; i<buildname.length; i++) {
				var markerPosition  = new daum.maps.LatLng(lati[i], long[i]); 

					// 마커를 생성합니다
				var marker = new daum.maps.Marker({
					position: markerPosition
				});

				var b = b_no[i];
			
				//infowindow에 추가할 내용 - 위도 경도를 원하는 페이지에 넘겨준다.
			var msg = 'b='+b;
			var iwContent = '<div style="padding:5px;">'+msg+'</div>',
			iwPosition = marker.position; //인포윈도우 표시 위치입니다

			// 인포윈도우를 생성합니다
			var infowindow = new daum.maps.InfoWindow({
				position : iwPosition, 
				content : iwContent 
			});

				// 마커에 클릭이벤트를 등록합니다
//				daum.maps.event.addListener(marker, 'click', function() {
					// 마커 위에 인포윈도우를 표시합니다
//				get_info(b); });  

				// 마커가 지도 위에 표시되도록 설정합니다
				marker.setMap(map);

			} 	

			var position[];
			

			return map;
	   }  */


	   	   function makeMap(coords, lati, long,b_no) {
			var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
				mapOption = { 
					center: coords, // 지도의 중심좌표
					level: 5 // 지도의 확대 레벨
				};
			
			var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다.
					// 마커가 표시될 위치입니다 

			 for(i = 0; i < b_no.length; i++) {
                // 다중 마커
                var marker = new daum.maps.Marker({
                    position: new daum.maps.LatLng(lati[i], long[i])
                });
                marker.setMap(map);
       
       			var b= b_no[i];
                //인포 윈도우
                daum.maps.event.addListener(marker, 'click', (function(marker, i,b) {
                    return function() {
                    	get_info(b)
                    }
                })(marker, i,b));
            }
            return map;
	   }

		
	   // 마커 만드는 함수
	   function makeMarker(map) {
		   	// 지도를 클릭한 위치에 표출할 마커입니다.
		   var marker = new daum.maps.Marker({ 
				// 지도 중심좌표에 마커를 생성합니다 
				position: map.getCenter() 
			}); 
			// 지도에 마커를 표시합니다
			marker.setMap(map);
			
			//infowindow에 추가할 내용 - 위도 경도를 원하는 페이지에 넘겨준다.
			var msg = '<form action="create_review.php" method="get"><input type="hidden" name="lat" value="'+marker.getPosition().getLat()+'" />'; // 위도 넘겨주는 태그
			msg += '<input type="hidden" name="lng" value="'+marker.getPosition().getLng()+'" /><input type="hidden" name="part" value="1" /><input type="submit" value="추가하기" /></form>';
			msg += '';
			var iwContent = '<div style="padding:5px;">'+msg+'</div>',
			iwPosition = marker.position; //인포윈도우 표시 위치입니다

			// 인포윈도우를 생성합니다
			var infowindow = new daum.maps.InfoWindow({
				position : iwPosition, 
				content : iwContent 
			});

			  
			// 지도를 클릭하면 마지막 파라미터로 넘어온 함수를 호출합니다
			daum.maps.event.addListener(map, 'click', function(mouseEvent) {        
				
				// 클릭한 위도, 경도 정보를 가져옵니다 
				var latlng = mouseEvent.latLng; 
				
				// 마커 위치를 클릭한 위치로 옮깁니다
				marker.setPosition(latlng);
				msg = '<form action="create_review.php" method="get"><input type="hidden" name="lat" value="'+marker.getPosition().getLat()+'" />'; // 위도 넘겨주는 태그
				msg += '<input type="hidden" name="lng" value="'+marker.getPosition().getLng()+'" /><input type="hidden" name="part" value="1" /><input type="submit" value="추가하기" /></form>';
			iwContent = '<div style="padding:5px;">'+msg+'</div>',
				infowindow.setContent(iwContent);
				infowindow.setPosition(latlng);
				
			});
			// 마커 위에 인포윈도우를 표시합니다. 두번째 파라미터인 marker를 넣어주지 않으면 지도 위에 표시됩니다
			infowindow.open(map, marker); 
	   }

var asyncRequest;

function get_info(bi_no) {
		//	document.getElementById("building_info").innerHTML = bi_no;
			try{
				asyncRequest = new XMLHttpRequest();
				var url = "building_board.php?building_no=" + bi_no;
				asyncRequest.addEventListener("readystatechange", stateChange, false);
				asyncRequest.open("GET", url, true);
				asyncRequest.send(null);
			}
			catch (exception){
				alert("Request failed.");
			} 
		}


function stateChange()
{
	if(asyncRequest.readyState == 4 && asyncRequest.status == 200)
	{
		document.getElementById("building_info").innerHTML = asyncRequest.responseText;
	}
}