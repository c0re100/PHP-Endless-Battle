function cfmAddStat(iGrowth, sStat, targetStat, rqStat, bChk){
  if(bChk) return true;
  targetStat = (parseInt(targetStat) + 1);
  return confirm("你現在有 "+ iGrowth +" 成長點數。\n要把"+ sStat +"加到 "+ targetStat +" 的話需要 "+ rqStat +" 點數。\n確定嗎?");
}

function highlightSS(elm){
  document.getElementById(elm).className = 'highLight';
}

function lowlightSS(elm){
  document.getElementById(elm).className = 'lowLight';
}

var active_A = active_B = active_C = active_L = 0;
function SetStill(elm){
  if(elm == 'btn1' && active_A == 0){active_A = 1;}
  else if(elm == 'btn1' && active_A == 1){active_A = 0;}
  if(elm == 'btn2' && active_B == 0){active_B = 1;}
  else if(elm == 'btn2' && active_B == 1){active_B = 0;}
  if(elm == 'btn3' && active_C == 0){active_C = 1;}
  else if(elm == 'btn3' && active_C == 1){active_C = 0;}
  if(elm == 'btnlog' && active_L == 0){active_L = 1;}
  else if(elm == 'btnlog' && active_L == 1){active_L = 0;}
}

function menuOver(elm,tbl){
  var num=0;switch(elm){case 'btn1': num=125;break;case 'btn2': num=140;break;case 'btn3': num=165;case 'btnlog': num=180;break;}
  highlightSS(elm);document.getElementById(tbl).style.right = num;
}

function menuOut(elm,tbl){
  if(elm == 'btn1' && active_A == 1){return false;}
  else if(elm == 'btn2' && active_B == 1){return false;}
  else if(elm == 'btn3' && active_C == 1){return false;}
  else if(elm == 'btnlog' && active_L == 1){return false;}
  else {lowlightSS(elm);document.getElementById(tbl).style.right = -1250;}
}

function focusZ(elm){
  document.getElementById(elm).style.zIndex = 2;
}

function blurZ(elm){
  document.getElementById(elm).style.zIndex = 1;
}

function setLayer(posX,posY,Width,Height,msgText){
  var X = posX + document.body.scrollLeft + 10;
  var Y = posY + document.body.scrollTop + 10;
  if(eval(posX + Width + 30) > document.body.clientWidth){
    X = eval(posX - Width + document.body.scrollLeft - 20);
  }if(eval(posY + Height + 30) > document.body.clientHeight){
    Y = eval(posY - Height + document.body.scrollTop - 20);
  }if(X<0){
    X = 0;
  }if(Y<0){
    Y = 0;
  }
  tmpTxt = eval(msgText);
  document.getElementById("wepinfo").style.width = Width;
  document.getElementById("wepinfo").style.height = 'auto';
  document.getElementById("wepinfo").style.backgroundColor = "ffffdd";
  document.getElementById("wepinfo").style.padding = 10;
  document.getElementById("wepinfo").innerHTML = tmpTxt;
  document.getElementById("wepinfo").style.border = "solid 1px #000000";
  document.getElementById("wepinfo").style.left = X;
  document.getElementById("wepinfo").style.top  = Y;
}

function offLayer(){
  document.getElementById("wepinfo").style.width = 0;
  document.getElementById("wepinfo").style.height = 0;
  document.getElementById("wepinfo").innerHTML = "";
  document.getElementById("wepinfo").style.backgroundColor = "transparent";
  document.getElementById("wepinfo").style.border = 0;
}

function proceedAddStat(typeStr){
  HideSTiF();
  document.addstat.action='statsmod.php?action=addstat';
  document.addstat.target='$SecTarget';
  document.addstat.actionb.value=typeStr;
  document.addstat.submit();
}

function failAddStat(oSubject, sMsg){
  if(sMsg != '') alert(sMsg);
  oSubject.visibility = 'visible';
  return false;
}
