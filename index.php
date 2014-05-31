<!doctype>
<?php
	//initializing the database class
	include "core/init.php";
?>
<html>
<head>
	<title>Froiden</title>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/dropzone.js"></script>
	<script type="text/javascript" src="scripts/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600|Lato:300,900|Inconsolata' rel='stylesheet' type='text/css'>

	<link href="css/style.css" rel="stylesheet">
	
</head>
<body>
	<div class="page-wrap">
		<div class="container">
			<div class="inner">
				<div id="page-bound">
					<div id="main-container" class="clearfix">
						<div class="clearfix">
							<div class="tile1 lfloat" id="upload">
								<div class="tile-text">Upload Files</div>
							</div>
							<div class="tile2 lfloat" id="viewdb">
								<div class="tile-text">View Database</div>
							</div>
						</div>
						<div id="tile3" class="hidden">
							<div id="dragandrophandler"><div class="tile-text">Drag & Drop Files here</div></div>
							<div id="uploadDisplay"></div>
						</div>
						<div id="tile4" class="hidden">
							<div id='data'><div>
						</div>
					<div>
				</div>
			</div>
		</div>
	</div>
	
<script>
		/*
		*	This Functions handels upload element display.
		*/
		function handelUpload(){
			$("#data").hide();
			if(flag == 0){
				$("#tile3").show(200);
				flag=1
			}
			else{
				$("#tile3").hide(200);
				flag=0;
			}

		}
		/*
		*	This Functions fetches the data stored in the database using ajax.
		*/
		function handelViewdb(){
			$("#data").show();
			$.ajax({
			    url: 'fetch.php',
			    type: 'POST',
			    cache: false,
			    contentType: false,
			    processData: false,
			    success: function(message){
			    	$('#tile4').show();
			    	$("#data").html(message);
			    }
			});
		}
		
		var flag=0;

		//Binding elements with events
		var upload = document.getElementById("upload");
		var viewdb = document.getElementById("viewdb");
		upload.addEventListener('click', handelUpload, false);
		viewdb.addEventListener('click', handelViewdb, false);
		
	</script>
</body>
</html>
