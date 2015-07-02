function chooser()
{
	var	answer = document.getElementById("server_answer").innerHTML;
	var user_id=encodeURIComponent(document.getElementById("user_id").innerHTML);
	if (answer == user_id){
		window.location.assign("game_page.php");
		}
}

function chooseDirection()
{
setInterval("chooser()", 2000);
}