//
// Weapon Customization Calculation Script
//

function getInnerValue(elmStr){
	return document.getElementById(elmStr).innerHTML;
}

function getInnerInt(elmStr){
	return parseInt(getInnerValue(elmStr));
}

function getObjInt(obj){
	if(obj.value != null && obj.value != '') return parseInt(obj.value);
	else if(obj.innerHTML != null && obj.innerHTML != '') return parseInt(obj.innerHTML);
}

function indicateColor(val1, val2, obj){
		if (val1 == val2) obj.style.color = 'Yellow';
		else obj.style.color = 'DodgerBlue';
}

function custom(type) {
	var PtMax_Atk = 100 - (getObjInt(oSysGrade) - 1) * 2;
	var PtMax_Hit = 50  - (getObjInt(oSysGrade) - 1) * 2;
	var PtMax_Rds = 100;
	var PtMax_Enc = 60;
	var percentage = 50 - getObjInt(oSysGrade) * 2;
	
	if( usePointCalc == false ) refreshStats(PtMax_Atk, PtMax_Hit, PtMax_Rds, PtMax_Enc);

	var atkcpt = getObjInt(oAtkCPt);
	var hitcpt = getObjInt(oHitCPt);
	var rdcpt  = getObjInt(oRdsCPt);
	var enccpt = getObjInt(oEncCPt);

	if(type == 'atk' || type == ''){
		var tempShow = getObjInt(oSysAtk) * atkcpt * 0.005;
		oAtkC.innerHTML = Math.floor(getObjInt(oSysAtk) + tempShow);
		indicateColor(atkcpt, PtMax_Atk, oAtkC);
	}
	if(type == 'hit' || type == ''){
		var tempShow = getObjInt(oSysHit) * hitcpt * 0.005;
		oHitC.innerHTML = Math.floor(getObjInt(oSysHit) + tempShow);
		indicateColor(hitcpt, PtMax_Hit, oHitC);
	}
	if(type == 'rd' || type == ''){
		var tempShow = getObjInt(oSysRds) * rdcpt * 0.005;
		oRdsC.innerHTML = Math.floor(getObjInt(oSysRds) + tempShow);
		indicateColor(rdcpt, PtMax_Rds, oRdsC);
	}
	
	var showencc = getObjInt(oSysEnc) * (1 + atkcpt * 0.01);
	showencc *= (1 + rdcpt * 0.01);
	showencc *= (1 + hitcpt * 0.01);

	oEncCMin.innerHTML = Math.ceil(showencc*0.7);

	var showencc2 = showencc * enccpt * 0.005;
	oEncC.innerHTML = Math.ceil(showencc-showencc2);

	if (getObjInt(oEncC) == getObjInt(oEncCMin)) oEncC.style.color = 'yellow';
	else if (getObjInt(oEncC) > getObjInt(oSysEnc)) oEncC.style.color = 'orange';
	else oEncC.style.color = 'blue';

	var point_lft = atkcpt+hitcpt+rdcpt+enccpt;

	if( usePointCalc == true )  adjustPtLeft( point_lft );

	var point_use_max = PtMax_Atk + PtMax_Hit + PtMax_Rds + PtMax_Enc;
	percentage += Math.floor((point_use_max-point_lft)/point_use_max*100);
	if (percentage > 100){percentage = 100;}
	oSuccessPc.innerHTML = percentage;
	
}

// Tact Custom Specific
function adjustPtLeft(point_lft){

	var extrapt = 0;
	if(oSecureCust.checked == true) extrapt += (getObjInt(oSysGrade)*10);
	
	oPtLeft.innerHTML = point_lft + extrapt;
		
	var i = getObjInt(oPtLeft);
	var j = getObjInt(oCPoints);
	
	if (i > j) {oPtLeft.style.color = 'red';}
	else if (i == j) {oPtLeft.style.color = 'yellow';}
	else {oPtLeft.style.color = 'blue';}

// Calculator Specific
function refreshStats(mAtk, mHit, mRds, mEnc){
	oAtkMax.innerHTML = mAtk;
	oHitMax.innerHTML = mHit;
	oRdsMax.innerHTML = mRds;
	oEncMax.innerHTML = mEnc;
	if(getObjInt(oAtkCPt) > mAtk)	oAtkCPt.value = mAtk;
	if(getObjInt(oHitCPt) > mHit) oHitCPt.value = mHit;
	if(getObjInt(oRdsCPt) > mRds)	oRdsCPt.value = mRds;
	if(getObjInt(oEncCPt) > mEnc)	oEncCPt.value = mEnc;
}


}

