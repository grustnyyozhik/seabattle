var xmlHttp = createXmlHttpRequestObject();

function createXmlHttpRequestObject()
{
var xmlHttp;

if(window.AcriveXObject)
{
	try{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP")
	}catch(e){
		xmlHttp=false;
	}
}else{
try{
		xmlHttp = new XMLHttpRequest()
	}catch(e){
		xmlHttp=false;
	}
}

if(!xmlHttp){
	alert("Failed to create the request object");
}

else
	return xmlHttp;

}

function process(){

if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	user_id=encodeURIComponent(document.getElementById("user_id").innerHTML);
	xmlHttp.open("POST", "free_players.php", true);
	xmlHttp.onreadystatechange = handleServerResponse;
	var temp = "user_id=" + user_id;
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.send(temp); 
}
else{
	setTimeout('process()', 1000);
}

}


function handleServerResponse()
{	
	if(xmlHttp.readyState==4){
		if(xmlHttp.status==200){
			xmlResponse = xmlHttp.responseXML;
			xmlDocumentElement = xmlResponse.documentElement;
			message = xmlDocumentElement.firstChild.data;
			document.getElementById("server_answer").innerHTML = message;
			setTimeout('process()', 1000);
		}
		else{alert("smth went wrong");}
	}
}





