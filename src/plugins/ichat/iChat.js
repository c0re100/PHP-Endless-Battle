var oXmlRequest	= createXmlHttpRequestObject();
var iChatURL	= "iChat.php";
var updateRate	= 1000;

var cache	= new Array();
var lastId	= -1;
var orgChannel = false;

var parentRef;
var oMsg, sMsg, oUser, sUser, oTar, sTar, phpebUser, phpebPass;

var unloadCfm = 0;
var autoNtf = 1;

// Function for updating element references
function initiate(){
	parentRef = window.opener;
	oMsg = document.getElementById('messageBox');
	sMsg = oMsg.value;
	oUser = document.getElementById('userName');
	sUser = oUser.value;
	oTar = document.getElementById('targetName');
	sTar = oTar.value;
	oSdBtn = document.getElementById('sendButton');
	oMsg.setAttribute("autocomplete", "off");
	phpebUser = document.getElementById('phpeb_username').value;
	phpebPass = document.getElementById('phpeb_password').value;
	document.title += " - Logged in as " + sUser;
	makeRequest();
}

window.onbeforeunload = terminate;
function terminate(){
	return "關閉此視窗會失去聊天紀錄。";
}

function changeUnloadConfirm(){
	if(unloadCfm == 0){
		unloadCfm = 1;
		document.getElementById('unloadCfmBtn').value = "防止關閉";
		window.onbeforeunload = null;
	}else{
		unloadCfm = 0;
		document.getElementById('unloadCfmBtn').value = "容許關閉";
		window.onbeforeunload = terminate;
	}
}

function changeAutoNotification(){
	if(autoNtf == 1){
		autoNtf = 0;
		document.getElementById('autoNoteBtn').value = "自動提示";
	}else{
		autoNtf = 1;
		document.getElementById('autoNoteBtn').value = "關閉提示";
	}
}

function autoNotify(){
	// Try Focusing
	if(autoNtf == 1){
		try{
			window.focus();
		}
		catch(ex){
		}
		// IE would fail here
		try{
			oMsg.focus();
		}
		catch(ex){
		}
	}
}

function updateElm(elm){
	switch(elm){
		case 'Msg':
			sMsg = oMsg.value;
			break;
		case 'Tar':
			sTar = oTar.value;
			break;
	}
}

// Creates an XMLHttpRequest instance
function createXmlHttpRequestObject(){
	// Stores the reference to the XMLHttpRequest object
	var xmlHttp;

	// For browsers other than IE6 and older
	try
	{
		// try to create XMLHttpRequest object
		xmlHttp = new XMLHttpRequest();
	}
	catch(e)
	{
		// assume IE6 or older
		var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
						"MSXML2.XMLHTTP.5.0",
						"MSXML2.XMLHTTP.4.0",
						"MSXML2.XMLHTTP.3.0",
						"MSXML2.XMLHTTP",
						"Microsoft.XMLHTTP");
		// try every prog id until one works
		for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++)
		{
			try
			{
				// try to create XMLHttpRequest object
				xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
			}
			catch (e) {}
		}
	}
	// return the created object or display an error message
	if (!xmlHttp)
		alert("Error creating the XMLHttpRequest object.");
	else
		return xmlHttp;
}

function postMessage(){
	var params = "";
	sMsg = trim(sMsg);
	if (sMsg != '' && sMsg != '!'){
		orgChannel = false;
		var msgType = 1;		// Default public channel
		if(sTar) msgType = 2;	// Switch to private 1:1 if target is set
		// Switch to Organization channel on demand
		else if(sMsg.match(/^!.*/g)){
			msgType = 3;
			sMsg = sMsg.replace(/^!/g,'');
			orgChannel = true;
		}
		else if(sMsg.match(/^\$GM.*/g)){
			if(sMsg.match(/^\$GM \/clear.*/g)){
				msgType = -2;
			}
			else{
				msgType = -1;
				sMsg = sMsg.replace(/^\$GM/g,'');
			}
		}
		params =	"action=send";
		if(msgType == -2){
			params =	"action=clear";
		}
		params +=	"&username=" + encodeURIComponent(phpebUser) +
					"&password=" + encodeURIComponent(phpebPass) +
					"&type=" + msgType +
					"&target=" + encodeURIComponent(sTar) +
					"&msg=" + encodeURIComponent(sMsg) +
					"&lastId=" + encodeURIComponent(lastId);
		cache.push(params);
		oMsg.value = sMsg = '(Sending...)';
		oMsg.disabled = true;
		oSdBtn.disabled = true;
	}
}

function makeRequest(){
	if(oXmlRequest){
		try{
			if(oXmlRequest.readyState == 4 || oXmlRequest.readyState == 0){
				var params = "";
				if(cache.length > 0) params = cache.shift();
				else params = "action=retrieve" +
					"&username=" + encodeURIComponent(phpebUser) +
					"&password=" + encodeURIComponent(phpebPass) +
					"&lastId=" + encodeURIComponent(lastId);
				
				// Make server call
				oXmlRequest.open("POST", iChatURL, true);
				oXmlRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				oXmlRequest.onreadystatechange = handleResponse;
				oXmlRequest.send(params);
				
			}
			else{
				setTimeout("makeRequest();", updateRate);
			}
		}
		catch(e){
			// Execute Error Handlers
			alert('Cannot make request\n');
		}
	}
}

function handleResponse(){
	if(oXmlRequest.readyState == 4){
		if(oXmlRequest.status == 200){
			try{
				// Execute Handlers
				readMessages();
			}
			catch(e){
				// Execute Error Handlers
				alert('Cannot read message: ' + e.toString());
			}
		}
	}
}

function readMessages(){
	var xmlResponse = oXmlRequest.responseXML;
	var response = xmlResponse.documentElement;
	
	if(!response || !xmlResponse) {
		throw("Invalid XML structure: \n" + oXmlRequest.responseText);
	}
	
	var entries = response.getElementsByTagName("entry");
	var aId = response.getElementsByTagName("id");
	var aName = response.getElementsByTagName("name");
	var aType = response.getElementsByTagName("type");
	var aTar = response.getElementsByTagName("target");
	var aMsg = response.getElementsByTagName("message");
	
	if(aId.length > 0){
		try{
			displayMessages(entries, aName, aType, aTar, aMsg);
		}
		catch(ex){
			alert('Cannot Display Messages\n' + ex.toString());
		}
		lastId = aId.item(aId.length - 1).firstChild.data;
		if(oMsg.disabled){
			oMsg.disabled = false;
			oSdBtn.disabled = false;
			oMsg.value = sMsg = (orgChannel) ? '!' : '';
			oMsg.focus();
		}
	}

	setTimeout("makeRequest();", updateRate);
	
}

function displayMessages(entries, aName, aType, aTar, aMsg){
	var output = "";
	for(var i = 0; i < entries.length; i++){
		var username = getChildString(aName,i);
		var type = getChildString(aType,i);
		var message = getChildString(aMsg,i);
		var target = getChildString(aTar,i);
		output += processMessage(username,message,target,type);
	}
	var oScroll = document.getElementById("scroll");
	var isScrollDown = ( oScroll.scrollHeight - oScroll.scrollTop <= oScroll.offsetHeight );
	oScroll.innerHTML += output;
	oScroll.scrollTop = isScrollDown ? oScroll.scrollHeight : oScroll.scrollTop;
	autoNotify();
}

function processMessage(username,message,target,type){
	var sResult = "";
	type = parseInt(type);
	switch(type){
		case 1:
			sResult = "<div class=\"item\"" 
					+	(
							(username == sUser) 
							? " style=\"font-weight: Bold; cursor: default\">" 
							: " onclick=\"pmUser('"+username+"');\">"
						)
					+	username + ": " + message
					+	"</div>";
			break;
		case 2:
			if(username == sUser){
				sResult = "<div class=\"pm\" onclick=\"pmUser('"+target+"');\"> [To: "
						+	target + "]: " + message
						+	"</div>";
			}else{
				sResult = "<div class=\"pm\" onclick=\"pmUser('"+username+"');\"> [From: "
					+	username + "]: " + message
					+	"</div>";
			}
			break;
		case 3:
			sResult = "<div class=\"om\"" 
					+	(
							(username == sUser)
							? " style=\"font-weight: Bold; cursor: default\">"
							: " onclick=\"pmUser('"+username+"')\">"
						)
					+	username + ": " + message
					+	"</div>";
			break;
		case 4:
			sResult = "<div class=\"pm\" style=\"font-weight: 700; cursor: default\">(沒有此人物名稱)</div>";
			break;
		case -1:
			sResult = "<div class=\"announcement\">"
					+	"[" +username + "] " + message
					+	"</div>";
			break;
		case -2:
			sResult = "<div class=\"pm\" style=\"font-weight: 700; cursor: default\">(訊息已消除)</div>";
			break;
	}
	return sResult;
}

function getChildString(objectArray,i){
	return objectArray.item(i).firstChild.data.toString();
}

function trim(s){
	return s.replace(/(^\s+|\s+$)/g, "");
}

function handleKey(e){
  // Get the event
  e = (!e) ? window.event : e;
  // Get the code of the character that has been pressed        
  code = (e.charCode) ? e.charCode :
         ((e.keyCode) ? e.keyCode :
         ((e.which) ? e.which : 0));
  // handle the keydown event       
  if (e.type == "keydown") 
  {
    // if enter (code 13) is pressed
    if(code == 13)
    {
      // send the current message  
    	updateElm('Msg');
    	postMessage();
    }
  }
}

function setPublic(){
	if(sMsg.match(/^!.*/g)){
		oMsg.value = sMsg.replace(/^!/g,'');
	}
	oTar.value = '';
	updateElm('Msg');
	updateElm('Tar');
	oMsg.focus();
}

function setOrg(){
	if(!sMsg.match(/^!.*/g)){
		oMsg.value = '!' + oMsg.value;
	}
	oTar.value = '';
	updateElm('Msg');
	updateElm('Tar');
	oMsg.focus();
}

function pmUser(user){
	if(sMsg.match(/^!.*/g)){
		oMsg.value = sMsg.replace(/^!/g,'');
	}
	oTar.value = user;
	updateElm('Msg');
	updateElm('Tar');
	oMsg.focus();
}

function resizeChat(dir){
	var oScroll = document.getElementById("scroll");
	var sizeNow = oScroll.className;
	switch(sizeNow){
	case 'sHigh':
		if(dir == 'up') {
			oScroll.className = 'sMed';
			resizeBy(0,-200);
		}
	break;
	case 'sMed':
		if(dir == 'up') {
			oScroll.className = 'sLow';
			resizeBy(0,-100);
		}
		else {
			oScroll.className = 'sHigh';
			resizeBy(0,200);
		}
	break;
	case 'sLow':
		if(dir == 'down') {
			oScroll.className = 'sMed';
			resizeBy(0,100);
		}
	break;
	}
}



















