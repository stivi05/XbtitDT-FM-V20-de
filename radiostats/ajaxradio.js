// The AJAX function...

function AJAX(){
try{
xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
return xmlHttp;
}
catch (e){
try{
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
return xmlHttp;
}
catch (e){
try{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
return xmlHttp;
}
catch (e){
alert("Your browser does not support AJAX.");
return false;
}
}
}
}

// Timestamp for preventing IE caching the GET request (common function)

function fetch_unix_timestamp()
{
 return parseInt(new Date().getTime().toString().substring(0, 10))
}

////////////////////////////////
//
// Refreshing the DIV TIMEDIV
//
////////////////////////////////

function refreshdiv_timediv(){

// Customise those settings

//var seconds = 6;
var divid = "timediv";
var url = "radiostats/fetch.php";

// Create xmlHttp

var xmlHttp_one = AJAX();

// No cache

var timestamp = fetch_unix_timestamp();
var nocacheurl = url+"?t="+timestamp;

// The code...

xmlHttp_one.onreadystatechange=function(){
if(xmlHttp_one.readyState==4){
document.getElementById(divid).innerHTML=xmlHttp_one.responseText;
setTimeout('refreshdiv_timediv()',40000);
}
}
xmlHttp_one.open("GET",nocacheurl,true);
xmlHttp_one.send(null);
}

// Start the refreshing process

window.onload = function startrefresh(){
setTimeout('refreshdiv_timediv()',40000);
}



