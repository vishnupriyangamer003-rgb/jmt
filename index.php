<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans);
.btn { display: inline-block; *display: inline; *zoom: 1; padding: 4px 10px 4px; margin-bottom: 0; font-size: 13px; line-height: 18px; color: #333333; text-align: center;text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75); vertical-align: middle; background-color: #f5f5f5; background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6); background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6)); background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6); background-image: -o-linear-gradient(top, #ffffff, #e6e6e6); background-image: linear-gradient(top, #ffffff, #e6e6e6); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr=#ffffff, endColorstr=#e6e6e6, GradientType=0); border-color: #e6e6e6 #e6e6e6 #e6e6e6; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); border: 1px solid #e6e6e6; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer; *margin-left: .3em; }
.btn:hover, .btn:active, .btn.active, .btn.disabled, .btn[disabled] { background-color: #e6e6e6; }
.btn-large { padding: 9px 14px; font-size: 15px; line-height: normal; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; }
.btn:hover { color: #333333; text-decoration: none; background-color: #e6e6e6; background-position: 0 -15px; -webkit-transition: background-position 0.1s linear; -moz-transition: background-position 0.1s linear; -ms-transition: background-position 0.1s linear; -o-transition: background-position 0.1s linear; transition: background-position 0.1s linear; }
.btn-primary, .btn-primary:hover { text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); color: #ffffff; }
.btn-primary.active { color: rgba(255, 255, 255, 0.75); }
.btn-primary { background-color: #4a77d4; background-image: -moz-linear-gradient(top, #6eb6de, #4a77d4); background-image: -ms-linear-gradient(top, #6eb6de, #4a77d4); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#6eb6de), to(#4a77d4)); background-image: -webkit-linear-gradient(top, #6eb6de, #4a77d4); background-image: -o-linear-gradient(top, #6eb6de, #4a77d4); background-image: linear-gradient(top, #6eb6de, #4a77d4); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr=#6eb6de, endColorstr=#4a77d4, GradientType=0);  border: 1px solid #3762bc; text-shadow: 1px 1px 1px rgba(0,0,0,0.4); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.5); }
.btn-primary:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled] { filter: none; background-color: #4a77d4; }
.btn-block { width: 100%; display:block; }

* { -webkit-box-sizing:border-box; -moz-box-sizing:border-box; -ms-box-sizing:border-box; -o-box-sizing:border-box; box-sizing:border-box; }

html { width:100%; height:100vh; height:100dvh; overflow:hidden; margin:0; padding:0; }
body.jhe-login-body {
  width: 100%;
  height:100vh;
  height:100dvh;
  margin:0;
  padding:0!important;
  overflow:hidden;
  font-family: 'Open Sans', 'Segoe UI', Arial, sans-serif;
  background:#0b1220;
  background: radial-gradient(ellipse at 85% 10%, rgba(29,78,216,.35) 0%, rgba(29,78,216,0) 45%), linear-gradient(135deg, #0b1220 0%, #0f172a 50%, #1e3a8a 100%);
}
.jhe-login-body .login{ margin:0!important; padding:0!important; }
.jhe-login-page{ height:100vh; height:100dvh; min-height:0; display:flex; align-items:center; justify-content:center; padding:12px 20px; overflow:hidden; }
.jhe-login-shell{ width:100%; max-width:880px; max-height:calc(100vh - 24px); max-height:calc(100dvh - 24px); display:flex; border-radius:16px; overflow:hidden; box-shadow:0 24px 70px rgba(0,0,0,.55); background:#fff; }
.jhe-login-brand{ flex:1 1 46%; background:linear-gradient(160deg,#0f172a 0%,#172554 55%,#1e3a8a 100%); color:#fff; padding:32px 36px; position:relative; display:flex; flex-direction:column; justify-content:center; }
.jhe-login-brand::after{ content:''; position:absolute; inset:0; background:repeating-linear-gradient(115deg, rgba(255,255,255,.035) 0 2px, transparent 2px 14px); pointer-events:none; }
.jhe-login-brand > *{ position:relative; }
.jhe-login-mono{ width:58px; height:58px; border-radius:50%; background:#eab308; color:#0f172a; font-weight:800; font-size:22px; display:flex; align-items:center; justify-content:center; margin-bottom:18px; }
.jhe-login-brand h2{ margin:0 0 6px; font-size:23px; font-weight:800; letter-spacing:.2px; }
.jhe-login-brand .jhe-tag{ margin:0 0 22px; font-size:13px; color:#bfdbfe; letter-spacing:1.5px; text-transform:uppercase; }
.jhe-login-points{ list-style:none; margin:0 0 26px; padding:0; }
.jhe-login-points li{ display:flex; gap:10px; align-items:flex-start; font-size:13.5px; color:#e0e7ff; margin-bottom:12px; line-height:1.5; }
.jhe-login-points li i{ color:#eab308; margin-top:3px; }
.jhe-login-brandfoot{ margin-top:auto; font-size:11.5px; color:#93c5fd; }
.jhe-login-formside{ flex:1 1 54%; background:#fff; padding:32px 36px; }
.jhe-login-formside h3{ margin:0 0 4px; font-size:21px; font-weight:800; color:#0f172a; }
.jhe-login-formside .jhe-sub{ margin:0 0 16px; font-size:13px; color:#64748b; }
.jhe-field{ margin-bottom:10px; text-align:left; }
.jhe-field label{ display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:6px; letter-spacing:.3px; }
.jhe-input-group{ position:relative; }
.jhe-input-group > i.fa{ position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px; }
.jhe-input-group input{
  width:100%; margin:0; padding:11px 12px 11px 36px; font-size:14px; color:#0f172a;
  background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; outline:none;
  text-shadow:none; box-shadow:none; transition:border-color .15s ease, box-shadow .15s ease;
}
.jhe-input-group input:focus{ border-color:#eab308; box-shadow:0 0 0 3px rgba(234,179,8,.25); background:#fff; }
.jhe-pass-toggle{ position:absolute; right:10px; top:50%; transform:translateY(-50%); border:0; background:transparent; color:#94a3b8; cursor:pointer; font-size:14px; padding:2px 4px; }
.jhe-pass-toggle:hover{ color:#0f172a; }
#submit.jhe-login-btn{
  width:100%; margin-top:12px; padding:11px; font-size:15px; font-weight:800; letter-spacing:.3px;
  color:#0f172a; background:#eab308; border:1px solid #a16207; border-radius:8px; cursor:pointer;
  text-shadow:none; box-shadow:0 6px 16px rgba(234,179,8,.35); transition:background .15s ease, transform .05s ease;
}
#submit.jhe-login-btn:hover{ background:#ca8a04; border-color:#854d0e; color:#fff; }
#submit.jhe-login-btn:active{ transform:translateY(1px); }
#submit.jhe-login-btn:disabled{ opacity:.7; cursor:wait; }
.jhe-login-secure{ margin-top:10px; font-size:11.5px; color:#94a3b8; text-align:center; }
#successmsg{
	text-align: center;
	width: 100%!important;
	font-weight:700;
	color: #64748b!important;
	font-size: 14px;
	margin-top: 8px;
	min-height:18px;
	display: inherit;
	word-break:break-word;
}
/* ===== Responsive fit: never scroll, shell always fits viewport ===== */
@media (max-width: 991px){
	.jhe-login-page{ padding:10px 16px; }
	.jhe-login-shell{ max-width:440px; flex-direction:column; }
	.jhe-login-brand{ padding:24px 24px 18px; }
	.jhe-login-brand .jhe-login-points, .jhe-login-brandfoot{ display:none; }
	.jhe-login-mono{ width:44px; height:44px; font-size:17px; margin-bottom:8px; }
	.jhe-login-brand h2{ font-size:18px; }
	.jhe-login-brand .jhe-tag{ margin-bottom:0; }
	.jhe-login-formside{ padding:26px 24px; }
}
@media (max-width: 575px){
	.jhe-login-page{ padding:10px 8px; }
	.jhe-login-shell{ border-radius:12px; }
	.jhe-login-brand{ padding:18px 20px 14px; }
	.jhe-login-brand h2{ font-size:17px; }
	.jhe-login-formside{ padding:24px 18px; }
	.jhe-login-formside h3{ font-size:18px; }
	.jhe-login-formside .jhe-sub{ margin-bottom:12px; }
	.jhe-input-group input{ font-size:16px; padding:10px 12px 10px 36px; }
	#submit.jhe-login-btn{ padding:11px; margin-top:10px; }
	.jhe-login-secure{ margin-top:8px; }
}
@media (max-width: 360px){
	.jhe-login-page{ padding:8px 6px; }
	.jhe-login-formside{ padding:20px 14px; }
	.jhe-login-brand{ padding:14px 16px 12px; }
	.jhe-login-brand h2{ font-size:16px; }
}
/* Short heights (landscape phones, small laptops): compress, keep row, no scroll */
@media (max-height: 600px){
	.jhe-login-page{ padding:8px 16px; }
	.jhe-login-brand{ padding:16px 20px; }
	.jhe-login-brand .jhe-login-points, .jhe-login-brandfoot{ display:none; }
	.jhe-login-mono{ display:none; }
	.jhe-login-brand .jhe-tag{ margin-bottom:0; }
	.jhe-login-formside{ padding:20px 22px; }
	.jhe-login-formside .jhe-sub{ margin-bottom:10px; }
	.jhe-field{ margin-bottom:8px; }
	.jhe-input-group input{ padding:10px 12px 10px 36px; }
	#submit.jhe-login-btn{ margin-top:10px; padding:10px; }
	#successmsg{ margin-top:6px; min-height:16px; }
	.jhe-login-secure{ display:none; }
}
</style>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Spares)</title>
    <link rel="icon" type="image/png" href="userdata/images/favicon.png">

    <!-- begin::global styles -->
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">
    <!-- end::global styles -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="css/app.min.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- end::custom styles -->

</head>

<body class="jhe-login-body">
<div class="login">
	<div class="jhe-login-page">
		<div class="jhe-login-shell">
			<div class="jhe-login-brand">
				<div class="jhe-login-mono">JH</div>
				<h2>Jayam Hydraulic Engineering</h2>
				<p class="jhe-tag">Spares &amp; Service Billing</p>
				<ul class="jhe-login-points">
					<li><i class="fa fa-check-circle"></i><span>GST &amp; Non-GST spares billing with receipts and outstanding tracking.</span></li>
					<li><i class="fa fa-check-circle"></i><span>Service billing for Workshop &amp; Outdoor jobs with payment history.</span></li>
					<li><i class="fa fa-check-circle"></i><span>Reports for sales, stock, day book and profit &amp; loss.</span></li>
				</ul>
				<div class="jhe-login-brandfoot">Secure sign-in &bull; Authorised users only</div>
			</div>
			<div class="jhe-login-formside">
				<h3>Welcome back</h3>
				<p class="jhe-sub">Sign in to continue to your dashboard</p>
				<form action="#" id="loginform" method="POST" autocomplete="off">
					<div class="jhe-field">
						<label for="uname">Username or Email</label>
						<div class="jhe-input-group">
							<i class="fa fa-user"></i>
							<input type="text" id="uname" name="uname" autofocus placeholder="Enter username" autocomplete="username" />
						</div>
					</div>
					<div class="jhe-field">
						<label for="pass">Password</label>
						<div class="jhe-input-group">
							<i class="fa fa-lock"></i>
							<input type="password" id="pass" name="pass" placeholder="Enter password" autocomplete="current-password">
							<button type="button" class="jhe-pass-toggle" id="passtoggle" title="Show password"><i class="fa fa-eye"></i></button>
						</div>
					</div>
					<button name="submit" id="submit" class="btn btn-primary btn-block btn-large jhe-login-btn">Sign In</button>
					<span id="successmsg" style=""></span>
					<div class="jhe-login-secure"><i class="fa fa-shield"></i> Protected session &bull; Contact admin for access</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- begin::global scripts -->
<script src="vendors/bundle.js"></script>
<!-- end::global scripts -->

<!-- begin::custom scripts -->
<script src="js/app.min.js"></script>
<!-- end::custom scripts -->
<script>
$(document).on('click', '#passtoggle', function(){
	var $p = $('#pass');
	var show = $p.attr('type') === 'password';
	$p.attr('type', show ? 'text' : 'password');
	$(this).html('<i class="fa fa-eye' + (show ? '-slash' : '') + '"></i>');
});
</script>

<script>
$(document).ready(function(){
	$("#loginform").on('submit', function(e){
		e.preventDefault();
		var $btn = $("#submit");
		var $msg = $("#successmsg");
		var uname = String($("#uname").val() || '').trim();
		var pwd   = String($("#pass").val()   || '');
		if (uname === ''){ $msg.css("color","red").html("* Enter Username"); return false; }
		if (pwd   === ''){ $msg.css("color","red").html("* Enter Password"); return false; }
		$btn.prop('disabled', true).text('Signing in...');
		$msg.css("color","green").html("Processing . . .");
		var isStaff = (uname.slice(-4) === "@jmt" || uname.slice(-13) === "@krrchamberss");
		$.ajax({
			type: "POST",
			url: isStaff ? "phpservices/emp_login.php" : "phpservices/login.php",
			data: { uname: uname, pass: pwd },
			dataType: "text",
			timeout: 20000,
			success: function(raw){
				var text = raw;
				try {
					var obj = JSON.parse(raw);
					if (obj && typeof obj.op !== 'undefined') text = String(obj.op);
				} catch (err) { /* raw body is not JSON - show it */ }
				text = String(text || '').trim();
				if (text === '1'){
					$msg.css("color","green").html("Login Successfully !");
					setTimeout(function(){ window.location.href = "dashboard.php"; }, 2000);
				} else if (text === ''){
					$msg.css("color","red").html("Login failed - empty response from server.");
				} else {
					$msg.css("color","red").html(text.length > 300 ? text.substring(0,300) : text);
				}
			},
			error: function(xhr){
				var text = String(xhr.responseText || '').trim();
				var msg  = text.length > 300 ? text.substring(0,300) : text;
				try {
					var obj = JSON.parse(text);
					if (obj && obj.op) msg = String(obj.op);
				} catch (err) { /* keep raw */ }
				$msg.css("color","red").html(msg || ("Server error (" + xhr.status + "). Please retry."));
			},
			complete: function(){
				$btn.prop('disabled', false).text('Sign In');
			}
		});
		return false;
	});
});
</script>
</body>
</html>