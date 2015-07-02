function drag(ev)
{
ev.dataTransfer.setData("Text",ev.target.id);
}

function allowDrop(ev)
{
ev.preventDefault();
}

function drop(ev)
{
ev.preventDefault();
var data=ev.dataTransfer.getData("Text");
var id = ev.target.id;
if(id.indexOf('box')!= -1 && ev.target.childNodes.length==0)
{
ev.target.appendChild(document.getElementById(data));
}
else{
alert('Sorry. You can\'t put a ship above another');
}
}





function close()
{
alert('false');
return false;
}