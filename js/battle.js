//attack online player?
function cfmAtkOnline(){
	if (confirm('攻擊在線的玩家可能會有損您的名聲，真的要這樣做？')==true){return true}
	else {return false}
}

//battle again?
setTimeout (function(){
        document.getElementById('battle_submit').disabled = true;
},3000);

var countdownNum = 3;
incTimer();

function incTimer(){
     setTimeout (function(){
         if(countdownNum != 1){
			document.getElementById('battle_submit').value = '再戰 (' + countdownNum + ')';
            countdownNum--;
            incTimer();
         } else {
            document.getElementById('battle_submit').value = '再戰';
			document.getElementById('battle_submit').disabled = false;
         }
     },1000);
}