<!DOCTYPE html>
<html>
<head>
	<title>Front End Test</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<style type="text/css">
		.dinesh {
    display: flex;
    align-items: center;
    justify-content: center;
	border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
	background-color: #ebe834;
}

.data1{
	border-top-right-radius: 10px;
}
.data2{
	border-bottom-right-radius: 10px;
}

	</style>
</head>
<body>
	<div class="container" style="background-color:skyblue;">
		<div class="row">
			<div class="col-sm-8 offset-2 p-2">
				<div class="row">
					<div class="col-sm-8">
						<h1 class="text-white">People Data</h1>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-success" onclick="getNextData();">Next Person</button>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" id="showData">
						
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		localStorage.setItem('lastIndex', 3);
		$.get('data.json',function(result){
			var i = 1 ;
			var data = '';
			$.each(result,function(index,value){
				
				data = data+'<div class="row p-2 userData no-gutters" id="'+i+'" >'+
								'<div class="col-sm-2 dinesh" ><b>'+i+'</b></div>'+
								'<div class="col-sm-8">'+
									'<div class="col-sm-12 bg-warning data1">&nbsp;'+value.name+'</div>'+
									'<div class="col-sm-12 bg-white data2">&nbsp;'+value.location+'</div>'+
								'</div>'+
							'</div>';
						i++;
					localStorage.setItem('lastValue', i);
					});

			$("#showData").append(data);
			$(".userData").hide();
			$("#1,#2,#3").show();
		});
		
	});

	function getNextData(){
		var visibleId = parseInt($('.userData:visible').last().attr('id'));
		
		var lastValue = localStorage.getItem('lastValue');

		var lastIndex = localStorage.getItem('lastIndex');
		var nextFirst = parseInt(lastIndex)+1;
		var nextSecond = parseInt(lastIndex)+2;
		var nextThird = parseInt(lastIndex)+3;
		
		if(visibleId+1 == lastValue){
			alert("No more people!");
		}else{
			$(".userData").hide();
			$("#"+nextFirst+",#"+nextSecond+",#"+nextThird).show();
			localStorage.setItem('lastIndex',nextThird);
		}
	}
</script>


</body>
</html>