function is_empty()
{
	var a = document.getElementById("pseudo").value;
	var d = document.getElementById("email").value;
	var e = document.getElementById("passwd1").value;
	var f = document.getElementById("passwd2").value;
	if (!a)
	{
		var a2 = document.getElementById("pseudo_d");
		a2.innerHTML = "Please choose a pseudo.";
		return false;
	}
	if (!d) 
	{
		var d2 = document.getElementById("email_d");
		d2.innerHTML = "Please enter your e-mail adress.";
		return false;
	}
	if (!e)
	{
		var e2 = document.getElementById("passwd1_d");
		e2.innerHTML = "Please enter a password.";
		return false;
	} 
	if (!f)
	{
		var f2 = document.getElementById("passwd2_d");
		f2.innerHTML = "Please confirm your password.";
		return false;
	}
	else
	{
		console.log("success");
		var succ = document.getElementById("success");
		succ.innerHTML = "Your account has been successfully created !";
		return true;
	}
}
