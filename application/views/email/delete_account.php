<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete My Account</title>
</head>
<body style="font-family: sans-serif;">


	<div style="width:100%">
		<div style="display: flex;">
			<h3>Delete My Supreme Technocom  Account</h3>
		</div>
		<div>
			<p>Hi <?php echo $user_name; ?>,</p>
			<p>Someone has requested delete account for the following account on Supreme Technocom:</p>
			<p>Username: <b> <?php echo $user_name; ?></b></p>
			<p>If you didn't make this request, just ignore this email. If you'd like to proceed:</p>
			<p ><a href="<?php echo $link; ?>" style="color: #ff700a;">Click here to delete your account</a></p>
			<p>Note: (This is irreversible process. Your account will delete permanently)</p>
			<p>Team Supreme Technocom</p>
		</div>
	</div>

</body>
</html>
