<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>x License</title>
  <link 
		href='https://fonts.googleapis.com/css?family=Raleway:300,200' 
		rel='stylesheet' type='text/css'><link rel="stylesheet" 
		href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"
  >




</head>
<style>
body {
  font-size: 62.5%;
  width: 100%;
  height: 100%;
  font-family: Raleway;
  background-size: cover;
  background-position: 50%;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  background:#d2d5de;
  position:absolute;
} 

.form{
	width:300px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);	
	background: #004ea0;
    border-radius: 10px;
	padding: 50px;
    box-shadow: 0px 5px 15px 5px rgb(0 0 0 / 10%);
}

.input{
	padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: none;	
}

.submit-btn{
	background: #4eaab8;
    cursor: pointer;
}

.input:focus-visible{outline:none}

#form-login{
	display:grid;
}

.background{
	position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
	background:url(/img/login-back.jpg);
	background-size: contain;
}

.container{
	width: 100%;
    height: 100%;
    background: rgb(210 213 222 / 90%);
    backdrop-filter: blur(20px);
}

</style>
<body>
<!-- <button id="findpass">Help Me !!!</button> -->
	<div class="background"></div>
	<div class="container">
	<!-- partial:index.partial.html -->
		<div class="form">
		  <div class="forceColor"></div>
		  <div class="topbar">
			<h5 
				id="logon" 
				style=""
			>
				<span 
					style="font-family:LPalatino Linotype !important; 
							font-style: oblique !important; 
							font-size: 65px;">i
				</span> SALES
			</h5>
			
			<br>
			
			<div class="spanColor"></div>
				<form class="m-t"  id="form-login">
					<input type="text" name="un" class="input" placeholder="Email" id="username" required="">
					<input type="password" name="pw" class="input" id="password" placeholder="Password" required="">
					
					<button class="submit-btn input" id="submit" >Login</button>
					<p style="padding: 5px;text-align: center;font-size: 15px;" id="fetch_msg"></P>
				</form>          
			</div>
			<p class="m-t"> <small style="color:#999;">Introps 2020-<?=date('Y')?></small> </p>
		</div>

		
	</div> 
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  
  <script>
	
	const username = document.getElementById('username')	
	const password = document.getElementById('password')	
	const form = document.getElementById('form-login')	
	const fetch_msg = document.getElementById('fetch_msg')	
	
	
	const fetch_data = (e)=>{
		const url  = '/Login/login_submit?u='+username.value+'&p='+password.value;
		e.preventDefault();
		fetch(url)
		.then((res)=>res.json())
		.then((reslt)=>{
			if(reslt == 'no'){
				fetch_msg.style.color='#ffa2a2'
				fetch_msg.innerHTML = 'Login error. Check your user email & passoword!'
			}else{
				fetch_msg.style.color='#a2ffb2'
				fetch_msg.innerHTML = 'Login success'
				setTimeout(function(){
					//location.reload();
					window.location.href="/"; 
				},1000)
			}
			console.log(reslt)
		}).
		catch((e)=>{
			console.log(e)
				fetch_msg.style.color='#ffa2a2'
				fetch_msg.innerHTML = 'Something went wrong.Check your internet connection & try again!'		
		})
	}
	form.addEventListener('submit',(e)=>fetch_data(e))
	

  </script>

</body>
</html>


<style>
#clock{color:#fff;font-weight:100; font-size:34px;}
#logon {
    color: #D7D7D7;
    font-size: 55px;
    z-index: 99999;
    position: relative;
    text-align: center;
}

.pg-canvas{
	opacity: 0.6;
}
</style>



            



	<script>
		function startTime() {
		  var today = new Date();
		  var h = today.getHours();
		  
			if (h > 12) {
				h -= 12;
			} else if (h === 0) {
			   h = 12;
			}
		  
		  var m = today.getMinutes();
		  var s = today.getSeconds();
		  m = checkTime(m);
		  s = checkTime(s);
		  document.getElementById('clock').innerHTML =
		  h + ":" + m + ":" + s;
		  var t = setTimeout(startTime, 500);
		}
		function checkTime(i) {
		  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
		  return i;
		}
		startTime();
	</script>
</body>

</html>
