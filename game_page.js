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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function load(){

if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	user_id=encodeURIComponent(document.getElementById("user_id").innerHTML);	
	xmlHttp.open("POST", "load_server.php", true);
	var info = "user_id="+ user_id;
	xmlHttp.onreadystatechange = refresh;
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.send(info); 
}
else{
	setTimeout('load()', 1000);
}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function process_submit(board_info){

if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	var user_id=encodeURIComponent(document.getElementById("user_id").innerHTML);
	board_info = board_info + ',' + user_id;
	var parm = "board_info=" + board_info;
	xmlHttp.open("POST", "submit_server.php", true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.onreadystatechange = submit_refresh;
	xmlHttp.send(parm); 
}
else{
	setTimeout(function(){process_submit(board_info); ships_info = null},1000);
}

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function submit_refresh()
{	
		if(xmlHttp.readyState==4){
		if(xmlHttp.status==200){
			
			xmlResponse = xmlHttp.responseXML;
			xmlDocumentElement = xmlResponse.documentElement;
			message = xmlDocumentElement.firstChild.data;
			if(message == 'ok'){
			button = document.getElementById("button");
			button.disabled = true;
			load();
			}		
		}
		
		else{alert("smth went wrong");}
		}


}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function move_refresh()
{
		if(xmlHttp.readyState==4){
		if(xmlHttp.status==200){
			
			xmlResponse = xmlHttp.responseXML;
			xmlDocumentElement = xmlResponse.documentElement;
			user = xmlDocumentElement.getElementsByTagName("USER");
			turn = xmlDocumentElement.getElementsByTagName("TURN");  //players turn
			partner_fleet = xmlDocumentElement.getElementsByTagName("PBOX");
			winner = xmlDocumentElement.getElementsByTagName("WINNER");
			
					coord = partner_fleet[0].getElementsByTagName("COORD");
					var pship = partner_fleet[0].getElementsByTagName("PSHIP");	
					var ship = document.createElement('div');
					ship.setAttribute('class', 'pship');
					box = document.getElementById("pbox_" + coord[0].firstChild.nodeValue);
					box.innerHTML='';
					
					if(pship[0].firstChild.nodeValue == 'missed')
					{
						ship.style.background = 'green';
						ship.setAttribute('id', coord + '_missed');
						ship.onclick = close;
						box.appendChild(ship);
						
						
					}
					else if(pship[0].firstChild.nodeValue=='killed')
					{
						ship.style.background = 'red';
						ship.setAttribute('id', coord + '_killed');
						ship.onclick = close;
						box.appendChild(ship);
					}
			
			var turn_label = document.getElementById("turn");
			if(winner[0].firstChild.nodeValue == 'none')//game is not finished
			{
					if(turn[0].firstChild.nodeValue != user[0].firstChild.nodeValue) //if not users turn
					{
						turn_label.innerHTML="Your partners turn";
					}
					else{
						turn_label.innerHTML="Your turn";
						
					}	
				load();
			}
			else//inform about win
			{
					turn_label.innerHTML="Game over";
					if(winner[0].firstChild.nodeValue==user[0].firstChild.nodeValue)
					{
					alert("YOU WON!!!")
					}
					else
					{
					alert("YOU LOST!!!")
					}
					window.location.href="statistics.php";
					
					
			}
		
		}
		
		else{alert("smth went wrong");}
		}


}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function refresh()
{
if(xmlHttp.readyState==4){
		if(xmlHttp.status==200){
			var i, j, board, turn, free_ships, own_board, own_fleet, ship_num, ship_id, submit, temp, box, coord, button, user, page, partner_fleet, winner;
			xmlResponse = xmlHttp.responseXML;
			xmlDocumentElement = xmlResponse.documentElement;
			user = xmlDocumentElement.getElementsByTagName("USER");
			submit = xmlDocumentElement.getElementsByTagName("SUBMIT");
			turn = xmlDocumentElement.getElementsByTagName("TURN");  //players turn
			free_ships = xmlDocumentElement.getElementsByTagName("FREESHIPS"); //num of free ships
			own_fleet = xmlDocumentElement.getElementsByTagName("SHIP");
			partner_fleet = xmlDocumentElement.getElementsByTagName("PBOX");
			winner = xmlDocumentElement.getElementsByTagName("WINNER");
			//player board
				
					
					
					if(own_fleet.length>0)
						{
							for (i=0;i<=99;i++)		
							{
							
							box = document.getElementById("box_" + i);
							var temp = i.toString();
							coord = own_fleet[i].getElementsByTagName("COORD");
							ship_num = own_fleet[i].getElementsByTagName("NUM");
							state = own_fleet[i].getElementsByTagName("STATE");
							if(ship_num.length>0)
								{
									var ship = document.createElement('div');
									ship.setAttribute('class', 'ship'); 
									ship.setAttribute('id', ship_num[0].firstChild.nodeValue);
									if(state[0].firstChild.nodeValue=='killed')
										{
											ship.style.background = 'red';
										}
									
									if(submit[0].firstChild.nodeValue == 'yes')
									{
									ship.setAttribute('draggable', 'false');
									ship.setAttribute('ondragstart', 'return false')
									}
									else{
									ship.setAttribute('draggable', 'true');
									ship.setAttribute('ondragstart', 'drag(event)');
									}
									box.innerHTML='';
									box.appendChild(ship);
		
								}
						
		
								
								else{
								if(state[0].firstChild.nodeValue=='missed')
										{
											box.style.background = 'green';
										}
								
								}
							}
						}
		
			if(submit[0].firstChild.nodeValue == 'yes')
			{
				button = document.getElementById("button");
				button.disabled = false;
				button.setAttribute('id', 'button');
				button.setAttribute('type', 'button');
				button.setAttribute('onclick', 'surrender()');
				button.innerHTML = "Surrender";
			}
			
			/////////////////////////////////////////////////
			var free_ship_box = document.getElementById("freeShipBox");
			free_ship_box.innerHTML = '';
			ship_id = 20 - parseInt(free_ships[0].firstChild.nodeValue) + 1 ;
			for(i=ship_id; i<=20; i++)
				{
					var t = i.toString();
					var free_ship = document.createElement('div');
					free_ship.setAttribute('class', 'ship'); 
					free_ship.setAttribute('id', t);
					free_ship.setAttribute('draggable', 'true');
					free_ship.setAttribute('ondragstart', 'drag(event)');
					free_ship_box.appendChild(free_ship);
				}
			//partner board
			
			for (i=0; i<partner_fleet.length; i++)
				{	
					coord = partner_fleet[i].getElementsByTagName("COORD");
					var pship = partner_fleet[i].getElementsByTagName("PSHIP");
					var ship = document.createElement('div');
					ship.setAttribute('class', 'pship');
					temp = i.toString();
					box = document.getElementById("pbox_" + coord[0].firstChild.nodeValue);
					box.innerHTML='';
					if(pship[0].firstChild.nodeValue == 'missed')
					{
						ship.style.background = 'green';
						ship.setAttribute('id', temp + '_missed');
						ship.onclick = close;
						box.appendChild(ship);
						
					}
					else if(pship[0].firstChild.nodeValue=='killed')
					{
						ship.style.background = 'red';
						ship.setAttribute('id', temp + '_killed');
						ship.onclick = close;
						box.appendChild(ship);
					}
					else if(pship[0].firstChild.nodeValue=='ok')
					{
						ship.style.background = 'transparent';
						ship.setAttribute('id', temp + '_ok');
						if(turn[0].firstChild.nodeValue == user[0].firstChild.nodeValue)
						{
								ship.onclick = function(){makeMove(this.id);};
						}
						else
						{
								ship.onclick = close;
						}
						box.appendChild(ship);
					}
					else if(pship[0].firstChild.nodeValue=='none')
					{
						ship.style.background = 'transparent';
						ship.setAttribute('id', temp + '_none');
						if(turn[0].firstChild.nodeValue == user[0].firstChild.nodeValue)
						{
								ship.onclick = function(){makeMove(this.id);};
						}
						else
						{
								ship.onclick = close;
						}
						box.appendChild(ship);
						
					}
					
				
				}
			
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			var turn_label = document.getElementById("turn");
			
			if(winner[0].firstChild.nodeValue == 'none')//game is not finished
			{
				if(turn[0].firstChild.nodeValue != 'none')
				{
					if(turn[0].firstChild.nodeValue != user[0].firstChild.nodeValue) //if not users turn
					{
					
						turn_label.innerHTML="Your partners turn";
					}
					else{
						turn_label.innerHTML="Your turn";
					}	
					setTimeout('load()', 5000);
				}
				else if( turn[0].firstChild.nodeValue == 'none' && submit[0].firstChild.nodeValue=='yes' )
					{
				setTimeout('load()', 5000);
					}
			
			}
			else//inform about win
			{
					turn_label.innerHTML="Game over";
					if(winner[0].firstChild.nodeValue==user[0].firstChild.nodeValue)
					{
					alert("YOU WON!!!")
					}
					else
					{
					alert("YOU LOST!!!")
					}
					window.location.href="statistics.php";
			}
			
			}
				else{alert("smth went wrong");}
		}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function loadPage()
{	

			var i;
			var player = document.createElement('label'); 
			player.setAttribute('class', 'headers'); 
			player.innerHTML = "Player Board";
			var container = document.createElement('div'); 
			container.setAttribute('class', 'container'); 
			
	  for (i=0;i<=99;i++)
      {
		temp = i.toString();
		box = document.createElement('div');
		if(!(i%10))
		{    	
			 box.setAttribute('class', 'box break'); 
			 box.setAttribute('id', 'box_' + temp);
			 box.setAttribute('ondragover', 'allowDrop(event)');
			 box.setAttribute('ondrop', 'drop(event)');
			 
		}
		else{
			box.setAttribute('class', 'box');
			box.setAttribute('id', 'box_' + temp);
			box.setAttribute('ondragover', 'allowDrop(event)');
			box.setAttribute('ondrop', 'drop(event)');
		}
	 container.appendChild(box);
	  }
    button = document.createElement('button');
	button.setAttribute('class', 'button'); 
	button.setAttribute('id', 'button');
	button.setAttribute('type', 'button');
	button.setAttribute('onclick', 'submitFunction()');
	button.innerHTML = "Submit";
	var player_ships = document.createElement('label');
	player_ships.setAttribute('class', 'headers'); 
	player_ships.innerHTML = "Free ships";
	var free_ship_box= document.createElement('div');
			free_ship_box.setAttribute('class', 'freeShipBox'); 
			free_ship_box.setAttribute('id', 'freeShipBox');
	var turn_label = document.createElement('label');
	turn_label.setAttribute('class', 'headers'); 
	turn_label.setAttribute('id', 'turn'); 
	turn_label.innerHTML = "Game not stared yet";
	
    document.getElementById("right_side").appendChild(player);
	document.getElementById("right_side").appendChild(container);
	document.getElementById("right_side").appendChild(player_ships);
	document.getElementById("right_side").appendChild(free_ship_box);
	document.getElementById("right_side").appendChild(turn_label);
	document.getElementById("right_side").appendChild(button);
	
	//partner side
	
	
	var partner = document.createElement('label'); 
			partner.setAttribute('class', 'headers'); 
			partner.innerHTML = "Partner Board";
			var pcontainer = document.createElement('div'); 
			pcontainer.setAttribute('class', 'container'); 
			
	  for (i=0;i<=99;i++)
      {
		temp = i.toString();
		box = document.createElement('div');
		if(!(i%10))
		{    	
			 box.setAttribute('class', 'box break'); 
			 box.setAttribute('id', 'pbox_' + temp);
			 
		}
		else{
			box.setAttribute('class', 'box');
			box.setAttribute('id', 'pbox_' + temp);
		}
	 pcontainer.appendChild(box);
	  }
	
    document.getElementById("left_side").appendChild(partner);
	document.getElementById("left_side").appendChild(pcontainer);
	
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function submitFunction()
{

var i, valid, ship_id, box_id;
var board_info = new Array(100);
for(i=0; i<100; i++)
	{
	board_info[i] = "none"; 
	}
	
for (i=0;i<100;i++){

var ship = document.getElementById('box_' + i).childNodes;
if (ship.length == 1)//if there's ship on a board cell
{
	ship_id = ship[0].id;
	ship[0].setAttribute('draggable', 'false');
	ship[0].setAttribute('ondragstart', 'return false')
	board_info[i] = ship_id + '_ok';  
}
}
//check validity

valid = ValidityCheck(board_info);

if(valid == false)//reset in case of  location mistake
{
alert('Ship location is wrong. Redo please!');
window.location.reload();
}
//insert info to the database;
else{
var message = board_info.join();
process_submit(message);
}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function makeMove(id)
{
var temp;
var ship = document.getElementById(id);
if(ship.id.indexOf("ok") != -1)//if shot the ship
{
temp =ship.id.replace("ok","killed");
ship.setAttribute('id', temp);
ship.onclick = close;
}
else if (ship.id.indexOf("none") != -1)//if shot the empty cell
{
temp =ship.id.replace("none","missed");
ship.setAttribute('id', temp);
ship.onclick = close;
}
send_move(ship.id);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function send_move(ship_id)
{
xmlHttp.abort();
if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	var user_id=encodeURIComponent(document.getElementById("user_id").innerHTML);
	var info = ship_id + ',' + user_id;
	xmlHttp.open("POST", "move_server.php", true);
	var temp = "info=" + info;
	xmlHttp.onreadystatechange = move_refresh;
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.send(temp); 
}
else{
	setTimeout(function(){send_move(ship_id); ship_id = null},1000);
}  
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function surrender()
{
	xmlHttp.abort();
if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	user_id=encodeURIComponent(document.getElementById("user_id").innerHTML);	
	xmlHttp.open("POST", "surrender_server.php", true);
	var info = "user_id="+ user_id;
	xmlHttp.onreadystatechange = refresh;
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.send(info); 
}
else{
	setTimeout('surrender()', 1000);
}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function ValidityCheck(FilledSquares)
{
	var new_FilledSquares = new Array(144);
	var i, j, four, three, two, one, temp;
	four=0;
	three=0;
	two=0;
	one=0;
	temp=0;
	total = 0;
	for(i = 0; i<144; i++)
	{
		new_FilledSquares[i]="none";
	}
	
	for(i = 0; i<100; i++)
	{
		new_FilledSquares[i+13+2* Math.floor(i/10)] = FilledSquares[i];
		
	}
	for(i = 0; i<144; i++)
	{	
		if(new_FilledSquares[i] != 'none')
		{
			temp++;
			total++;
			
		}
		else
		{
			if(temp>5)
			{
				return false;
			}
			else if(temp==4)
			{
				four++;
				
			}
			else if(temp==3)
			{
				three++;
				
			}
			else if(temp==2)
			{
				two++;
				
			}
			else if(temp==1)
			{
				if(new_FilledSquares[i+11]=='none' && new_FilledSquares[i-13] == 'none')
				{
				one++;
				
				}
			}
			temp=0;
			
		}
	}
	
	for(i = 0; i<=11; i++)
	{
		for(j = 0; j<=11; j++)
		{
			var k = i+(12*j);
			if(new_FilledSquares[k] != 'none')
		{
			temp++;
			total++;
		}
		else
		{
			if(temp>5)
			{
				return false;
			}
			else if(temp==4)
			{
				four++;
			}
			else if(temp==3)
			{
				three++;
			}
			else if(temp==2)
			{
				two++;
			}
			else if(temp==1)
			{
				if(new_FilledSquares[k-13]=='none' && new_FilledSquares[k-11]=='none')
				{
				one++;
				}
			}
			temp=0;
		}	
	}
	}
	
	//alert('four ' + four);
	//alert('two ' + two);
	//alert('one ' + one);
	//alert('three ' + three);
	if(four==1 && three==2 && two == 3 && one==8 && total==40)
	{
	return true;
	}

	return false;
	
}	
	
	
	
	
	
	
	





