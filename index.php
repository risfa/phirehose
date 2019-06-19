<html>
	<head>
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jukebox-5D</title>
	
		<script>
		
			// Popup window code
			function newPopup(url) {
				var left = (screen.width/2)-(800/2);
				var top = (screen.height/2)-(500/2);
				popupWindow = window.open(url,'popUpWindow','height=570,width=800,scrollbars=yes, top='+top+', left='+left+'')
				/*popupWindow = window.open(url,'popUpWindow','height=500,width=800,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes, top='+top+', left='+left+'')*/
			}


			window.fbAsyncInit = function() {
				FB.init({
				appId      : '730214766997657', // replace your app id here
				channelUrl : '', 
				status     : true, 
				cookie     : true, 
				xfbml      : true  
				});
			};
			(function(d){
				var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement('script'); js.id = id; js.async = true;
				js.src = "//connect.facebook.net/en_US/all.js";
				ref.parentNode.insertBefore(js, ref);
			}(document));

			function FBLogin(){
				FB.login(function(response){
					if(response.authResponse){
						window.location.href = "../fb/actions.php?action=fblogin&app=solve";
					}
				}, {scope: 'email,user_photos,user_posts,read_stream,user_birthday,user_location,user_work_history, manage_pages,user_about_me,user_hometown,user_likes,publish_actions,user_likes'});
			}

			function goBack() {
				window.history.back()
			}
			
			$("#next").click(function() {
				var $btn = $(this);
				$btn.button('loading');
			});
			
			
		</script>
	</head>
	<body>
	
	<div class="container">
		<div class="col-lg-12 boxT">
		
		
			<div class="header clearfix">
			</div>
		
		
				<div class="col-lg-12" align="center">
						<form>
							<center><h4>Social Media Connect</h4></center>
							<center>
								<?php
								if(isset($_SESSION['err'])) {
									echo "<small style='color:red'>".$_SESSION['err']."</small><br><br>";
									unset($_SESSION['err']);
								}
								?>
								<?php if(isset($_SESSION["fbregis"]) == ""){ ?>
								<!--<a class="btn btn-social btn-lg btn-facebook" style="margin:10px" onclick="FBLogin()">
								<i class="fa fa-facebook"></i> Facebook Connect
								</a>-->
								<?php } ?>
								<?php if(isset($_SESSION["twitterregis"]) == ""){ ?>
									<a class="btn btn-social btn-lg btn-twitter" onclick="newPopup('twitter/index.php');">
									<i class="fa fa-twitter"></i> Twitter Connect
								</a>
								<?php } ?>
							</center>
							<br>
							<small>Hello music lovers, connect your twitter account and share with friends out there. Calm we will not use your data for personal gain or traded. Let us form the music community with full responsibility. Thank you.</small>
							<br>
							<br>
							<center>
							<button class="btn btn-md btn-default" onclick="goBack()"><i class="fa fa-long-arrow-left"></i> Previous</button>
							<!--<a href="process/doPermission.php" id="next" data-loading-text="Processing..." class="btn btn-md btn-danger">Next <i class="fa fa-long-arrow-right"></i></a>-->
							<a href="search.php"><button type="button" id="next" data-loading-text="Processing..." style="width:100px;" class="btn btn-md btn-primary">Next <i class="fa fa-long-arrow-right"></i></button></a>
						</center>
					</form>
				</div>
		</div>
	</div>	
		
	</body>
</html>