//-------------------------//-------------------------//-------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//
//----------------  php-eb UE Battle Result Calculator/Simulator ----------------//
//-------------------       Calculation Script v3.0Alpha     --------------------//
//-------------------------//-------------------------//-------------------------//

// Player Class - Start
function player(){

	// Basic Information
	this.oxGrowthPt = null;
	this.oLevel = null;
	this.oSpecifyLevel = null;
	// Set-On-Demand vars
	this.TypeIndex = 'nat';
	this.TypeLv = 1;
	this.oTypeName = null;
	this.oTypeInf = null;

	// Base Ability Stats
	this.oAt = null;
	this.oDe = null;
	this.oRe = null;
	this.oTa = null;

	// Fix Ability Stats
	this.At_Fix = 0;
	this.De_Fix = 0;
	this.Re_Fix = 0;
	this.Ta_Fix = 0;
	this.oAt_Fix = null;
	this.oDe_Fix = null;
	this.oRe_Fix = null;
	this.oTa_Fix = null;
	this.oAt_Bonus = null;
	this.oDe_Bonus = null;
	this.oRe_Bonus = null;
	this.oTa_Bonus = null;

	// General Object Elements
	this.oLevelR = null;
	this.oGrowR = null;
	this.oPtLeft = null;
	this.oSeedMode = null;
	this.oExamActi = null;

	// MS Related
	this.MS_atf = 0;
	this.MS_def = 0;
	this.MS_ref = 0;
	this.MS_taf = 0;
	this.MS_Catf = 0;
	this.MS_Cdef = 0;
	this.MS_Cref = 0;
	this.MS_Ctaf = 0;
	this.MS_AtFix = 0;
	this.MS_DeFix = 0;
	this.MS_ReFix = 0;
	this.MS_TaFix = 0;
	this.MS_ID = '0';
	this.oMS       = null;
	this.oMS_atf   = null;
	this.oMS_atf_t = null;
	this.oMS_atf_c = null;
	this.oMS_def   = null;
	this.oMS_def_t = null;
	this.oMS_def_c = null;
	this.oMS_ref   = null;
	this.oMS_ref_t = null;
	this.oMS_ref_c = null;
	this.oMS_taf   = null;
	this.oMS_taf_t = null;
	this.oMS_taf_c = null;

	// Weapon Related
	this.oWep_ATK = null;
	this.oWep_RDS = null;
	this.oWep_HIT = null;
	this.oWep_ATK_Raw = null;
	this.oWep_RDS_Raw = null;
	this.oWep_HIT_Raw = null;
	this.oWep_ATK_Add = null;
	this.oWep_RDS_Add = null;
	this.oWep_HIT_Add = null;
	this.oWep_T_Dam   = null;
	this.oWepA     = null;
	this.oWepE     = null;
	this.oWepP     = null;
	this.oSpecPool = null;
	this.oRange    = null;
	this.oAttrb    = null;
	
	this.WepA_ID = 0;
	this.WepE_ID = 0;
	this.WepP_ID = 0;

	// Tactics
	this.oTactics = null;

	// Calculator Use
	this.dprd_max = 0;
	this.dprd_min = 0;
	this.accprd = 0;
	this.cl_pi_at = 0;
	this.cl_pi_de = 0;
	this.cl_pi_re = 0;
	this.cl_pi_ta = 0;
	this.cl_ms_at = 0;
	this.cl_ms_de = 0;
	this.cl_ms_re = 0;
	this.cl_ms_ta = 0;
	this.oDprd_Max = null;
	this.oDprd_Min = null;
	this.oAccPrd   = null;
	this.oExpdHits = null;
	this.oDamMin   = null;
	this.oDamMax   = null;
	this.oDamAvg   = null;
	this.oExpdDam  = null;

	// Special Abilities
	this.spec_p_var = "";  // Special Ability Pool Variable
	this.spec_prc = "";    // Special Ability Pool Display

	// Setter Functions / Mutators
	this.setElements = function(fLevelR, fGrowR, fPtLeft, fSeedMode, fExamActi){
		this.oLevelR = fLevelR;
		this.oGrowR = fGrowR;
		this.oPtLeft = fPtLeft;
		this.oSeedMode = fSeedMode;
		this.oExamActi = fExamActi;
	}

	this.setAbilityElm = function(fatf, fdef, fref, ftaf, fatb, fdeb, freb, ftab){
		this.oAt_Fix = fatf;
		this.oDe_Fix = fdef;
		this.oRe_Fix = fref;
		this.oTa_Fix = ftaf;
		this.oAt_Bonus = fatb;
		this.oDe_Bonus = fdeb;
		this.oRe_Bonus = freb;
		this.oTa_Bonus = ftab;
	}

	this.setXGrowth = function(xGrowth){
		this.oxGrowthPt = xGrowth;
	}
	this.setLevel = function(lv){
		this.oLevel = lv;
	}
	this.setSpcLv = function(spcLevel){
		this.oSpecifyLevel = spcLevel;
	}

	this.setBase = function(att, def, ref, taf){
		this.oAt = att;
		this.oDe = def;
		this.oRe = ref;
		this.oTa = taf;
	}

	// Getter Functions
	this.getLevelR = function(){
		if(this.oLevelR != null)	return parseInt(this.oLevelR.innerHTML);
		else return 1;
	}

	//
	// Classified Functions
	//

	// Pilot Functions

	this.At = function(){
		return parseInt(this.oAt.value);
	}
	this.De = function(){
		return parseInt(this.oDe.value);
	}
	this.Re = function(){
		return parseInt(this.oRe.value);
	}
	this.Ta = function(){
		return parseInt(this.oTa.value);
	}

	this.getAtBonus = function(){
		return parseInt(this.oAt_Bonus.innerHTML);
	}
	this.getDeBonus = function(){
		return parseInt(this.oDe_Bonus.innerHTML);
	}
	this.getReBonus = function(){
		return parseInt(this.oRe_Bonus.innerHTML);
	}
	this.getTaBonus = function(){
		return parseInt(this.oTa_Bonus.innerHTML);
	}

	this.xGrowthPt = function(){
		return parseInt(this.oxGrowthPt.value);
	}
	this.Level = function(){
		return parseInt(this.oLevel.value);
	}
	this.SpecifyLevel = function(){
		return this.oSpecifyLevel.checked;
	}

	// MS Related Functions
	this.setMSID = function(msid){
		this.MS_ID = msid;
	}

	this.setMS_vars = function(at, de, re, ta){
		this.MS_atf = parseInt(at);
		this.MS_sef = parseInt(de);
		this.MS_ref = parseInt(re);
		this.MS_taf = parseInt(ta);
	}

	this.setMS_elms = function(fMS){
		this.oMS = fMS;
	}

	this.setMS_At_Elms = function( felm, telm, celm ){
		this.oMS_atf   = felm;
		this.oMS_atf_t = telm;
		this.oMS_atf_c = celm;
	}
	this.setMS_De_Elms = function( felm, telm, celm ){
		this.oMS_def   = felm;
		this.oMS_def_t = telm;
		this.oMS_def_c = celm;
	}
	this.setMS_Re_Elms = function( felm, telm, celm ){
		this.oMS_ref   = felm;
		this.oMS_ref_t = telm;
		this.oMS_ref_c = celm;
	}
	this.setMS_Ta_Elms = function( felm, telm, celm ){
		this.oMS_taf   = felm;
		this.oMS_taf_t = telm;
		this.oMS_taf_c = celm;
	}
	this.getMS_At = function(){
		return parseInt(this.oMS_atf.innerHTML);
	}
	this.getMS_De = function(){
		return parseInt(this.oMS_def.innerHTML);
	}
	this.getMS_Re = function(){
		return parseInt(this.oMS_ref.innerHTML);
	}
	this.getMS_Ta = function(){
		return parseInt(this.oMS_taf.innerHTML);
	}
	this.getMS_tAt = function(){
		return parseInt(this.oMS_atf_t.innerHTML);
	}
	this.getMS_tDe = function(){
		return parseInt(this.oMS_def_t.innerHTML);
	}
	this.getMS_tRe = function(){
		return parseInt(this.oMS_ref_t.innerHTML);
	}
	this.getMS_tTa = function(){
		return parseInt(this.oMS_taf_t.innerHTML);
	}
	this.getMS_cAt = function(){
		return parseInt(this.oMS_atf_c.value);
	}
	this.getMS_cDe = function(){
		return parseInt(this.oMS_def_c.value);
	}
	this.getMS_cRe = function(){
		return parseInt(this.oMS_ref_c.value);
	}
	this.getMS_cTa = function(){
		return parseInt(this.oMS_taf_c.value);
	}

	// Weapon-related functions

	this.setWeaponElms = function(fWepA, fWepE, fWepP, ft, specpool, range, attrb){
		this.oWepA = fWepA;
		this.oWepE = fWepE;
		this.oWepP = fWepP;
		this.oWep_T_Dam = ft;
		this.oSpecPool = specpool;
		this.oRange = range;
		this.oAttrb = attrb;
	}
	
	this.setWeaponARH = function(fatk, frds, fhit){
		this.oWep_ATK = fatk;
		this.oWep_RDS = frds;
		this.oWep_HIT = fhit;
	}

	this.setWeaponARH_Raw = function(fatkr, frdsr, fhitr){
		this.oWep_ATK_Raw = fatkr;
		this.oWep_RDS_Raw = frdsr;
		this.oWep_HIT_Raw = fhitr;
	}

	this.setWeaponARH_Add = function(fatka, frdsa, fhita){
		this.oWep_ATK_Add = fatka;
		this.oWep_RDS_Add = frdsa;
		this.oWep_HIT_Add = fhita;
	}

	this.getWeaponAtk = function(){
		return parseInt(this.oWep_ATK.innerHTML);
	}
	this.getWeaponRDS = function(){
		return parseInt(this.oWep_RDS.innerHTML);
	}
	this.getWeaponHit = function(){
		return parseInt(this.oWep_HIT.innerHTML);
	}
	this.getWeaponAtkRaw = function(){
		return parseInt(this.oWep_ATK_Raw.innerHTML);
	}
	this.getWeaponRDSRaw = function(){
		return parseInt(this.oWep_RDS_Raw.innerHTML);
	}
	this.getWeaponHitRaw = function(){
		return parseInt(this.oWep_HIT_Raw.innerHTML);
	}
	this.getWeaponAtkAdd = function(){
		return parseInt(this.oWep_ATK_Add.value);
	}
	this.getWeaponRDSAdd = function(){
		return parseInt(this.oWep_RDS_Add.value);
	}
	this.getWeaponHitAdd = function(){
		return parseInt(this.oWep_HIT_Add.value);
	}

	// Tactics Functions
	this.setTactics = function(fTact){
		this.oTactics = fTact;
	}

	this.getTacticInf = function(stat){
		return parseInt(TacticsID[this.oTactics.value][stat]);
	}

	this.getTacticSpec = function(){
		return TacticsID[this.oTactics.value][7];
	}

	//
	// End Classified Functions
	//

	//
	// Event Handlers - Start
	//
	
	
	this.statChanged = function(){
		this.StatnLevelCalc();
		this.changeType();		
	}
	
	
	//
	// Event Handlers - Ends
	//

	// Calculation of Stat and Level
	this.StatnLevelCalc = function(){
		var AtRSt = CalcTotalStatPtsR(this.At());
		var DeRSt = CalcTotalStatPtsR(this.De());
		var ReRSt = CalcTotalStatPtsR(this.Re());
		var TaRSt = CalcTotalStatPtsR(this.Ta());
		var TTlStR = parseInt(AtRSt+DeRSt+ReRSt+TaRSt-this.xGrowthPt());

		if (this.SpecifyLevel() == false)
			this.oLevelR.innerHTML = CalcLevelRec(0, TTlStR) + 1;
		else
			this.oLevelR.innerHTML = this.Level();

		if (TTlStR > 0)
			this.oGrowR.innerHTML = TTlStR;
		else
			this.oGrowR.innerHTML = '0';

		this.oPtLeft.innerHTML = CalcTotalStatPtsG( parseInt(this.oLevelR.innerHTML) - 1 ) - TTlStR;
	}

	// De/Activate Specified Level
	// Accepts Raw Object Input
	this.chk_dis_spcflv = function(){
			if (this.SpecifyLevel() == true){
				this.oLevel.disabled = false;
			}
			else{
				this.oLevel.disabled = true;
			}
	}

	// Change Pilot Type
	this.changeType = function(){

		// Set Elements
		this.TypeIndex = this.oTypeInf.value;

		// Update Displayed Type Name
		this.updateTypeLevel();
		this.oTypeName.innerHTML = TypeID[this.TypeIndex][this.TypeLv][0];

		// Update Pilot Fixes
		this.calcPiFixes();
	}

	this.updateTypeLevel = function(){
		this.TypeLv = Math.floor( this.getLevelR() / 10 ) + 1;
		if (this.TypeLv > 16) this.TypeLv = 16;
	}

	this.calcPiFixes = function(){

		this.updateTypeLevel();

		this.At_Fix = TypeID[this.TypeIndex][this.TypeLv][1];
		this.De_Fix = TypeID[this.TypeIndex][this.TypeLv][2];
		this.Re_Fix = TypeID[this.TypeIndex][this.TypeLv][3];
		this.Ta_Fix = TypeID[this.TypeIndex][this.TypeLv][4];

		// SEED Mode Fix
		if (this.oSeedMode.checked == true){
			if(this.TypeIndex == 'co') {
				this.At_Fix += Math.floor(this.At() * 0.15);
				this.De_Fix += Math.floor(this.De() * 0.15);
				this.Re_Fix += Math.floor(this.Re() * 0.15);
				this.Ta_Fix += Math.floor(this.Ta() * 0.15);
			}
			else if(this.TypeIndex == 'ext') {
				this.At_Fix += Math.floor(this.At() * 0.15);
				this.Re_Fix += Math.floor(this.Re() * 0.15);
				this.Ta_Fix += Math.floor(this.Ta() * 0.05);
			}
			else if(this.TypeIndex == 'nat') {
				this.De_Fix += Math.floor(this.De() * 0.175);
				this.Re_Fix += Math.floor(this.Re() * 0.175);
			}
		}

		// EXAM System Activation Check
		if (this.oExamActi.checked == true){
			if(this.TypeIndex == 'nat') {
				this.De_Fix -= 6;
				this.Re_Fix -= 4;
				this.At_Fix += 15;
				this.Ta_Fix += 10;
				if(this.getLevelR() >= 100){
					this.De_Fix -= 3;
					this.Re_Fix -= 2;
					this.At_Fix += 10;
					this.Ta_Fix += 5;
				}
			}
			else if(this.TypeIndex == 'ext' || this.TypeIndex == 'enh') {
				this.De_Fix -= 3;
				this.Re_Fix -= 2;
				this.At_Fix += 10;
				this.Ta_Fix += 10;
				if(this.getLevelR() >= 100){
					this.At_Fix += 5;
					this.Ta_Fix += 5;
				}
			}
		}

		if (this.spec_p_var.match('底力') || (this.TypeIndex == 'psy' && this.TypeLv >= 8) || (this.TypeIndex == 'enh' && this.TypeLv >= 8)) {
			this.De_Fix += 15;
			if (this.spec_p_var.match('底力') && (this.TypeIndex == 'psy' && this.TypeLv >= 8)) this.De_Fix += 15;
			}

		if (this.spec_p_var.match('興奮')) this.At_Fix += 20;

		// Update to View
		this.updateAbilityFix();
		this.updateHiddenAbility();

	}

	// Update Ability Fixes
	this.updateAbilityFix = function(){
		this.oAt_Fix.innerHTML = this.At_Fix;
		this.oDe_Fix.innerHTML = this.De_Fix;
		this.oRe_Fix.innerHTML = this.Re_Fix;
		this.oTa_Fix.innerHTML = this.Ta_Fix;
	}
	// Hidden Abilty Bonus
	this.updateHiddenAbility = function(){
		var At_ttl = this.At() + this.At_Fix;
		var De_ttl = this.De() + this.De_Fix;
		var Re_ttl = this.Re() + this.Re_Fix;
		var Ta_ttl = this.Ta() + this.Ta_Fix;
		this.oAt_Bonus.innerHTML = Math.floor( At_ttl * At_ttl/1500 );
		this.oDe_Bonus.innerHTML = Math.floor( De_ttl * De_ttl/1500 );
		this.oRe_Bonus.innerHTML = Math.floor( Re_ttl * Re_ttl/1500 );
		this.oTa_Bonus.innerHTML = Math.floor( Ta_ttl * Ta_ttl/1500 );
	}

	// Weapon Switched Event Handler
	this.switchWep = function(Op, pos){

		if(pos == 'a' || pos == 'all'){
			if(this.oWepA.value != null) this.WepA_ID = this.oWepA.value;
			else this.WepA_ID = 0;
			this.oWep_ATK_Raw.innerHTML = this.oWep_ATK.innerHTML = WepID[this.WepA_ID][1];
			this.oWep_RDS_Raw.innerHTML = this.oWep_RDS.innerHTML = WepID[this.WepA_ID][2];
			this.oWep_HIT_Raw.innerHTML = this.oWep_HIT.innerHTML = WepID[this.WepA_ID][3];
			this.oWep_T_Dam.innerHTML = this.getWeaponAtk() * this.getWeaponRDS();
			if(pos == 'a'){
				this.oRange.innerHTML = getRange(WepID[this.WepA_ID][6]);
				this.oAttrb.innerHTML = getAttrb(WepID[this.WepA_ID][7]);
				alert(WepID[this.WepA_ID][0]+'\n裝備有以下特效:\n' + brToNL(WepID[this.WepA_ID][5]));
			}
		}

		if(pos == 'e' || pos == 'all'){
			if(this.oWepE.value != null) this.WepE_ID = this.oWepE.value;
			else this.WepE_ID = 0;
			if(pos == 'e')
				alert('裝備有以下特效:\n' + brToNL(WepID[this.WepE_ID][5]));
		}

		if(pos == 'p' || pos == 'all'){
				if(this.oWepP.value != null) this.WepP_ID = this.oWepP.value;
				else this.WepP_ID = 0;
			if(pos == 'p')
				alert('裝備有以下特效:\n' + brToNL(WepID[this.WepP_ID][5]));
		}

		if(pos == 'ms' || pos == 'all'){
			if(this.oMS.value != null) this.MS_ID = this.oMS.value;
			else this.MS_ID = 0;
			this.oMS_atf.innerHTML = this.MS_atf = parseInt(MSID[this.MS_ID][1]);
			this.oMS_def.innerHTML = this.MS_def = parseInt(MSID[this.MS_ID][2]);
			this.oMS_ref.innerHTML = this.MS_ref = parseInt(MSID[this.MS_ID][3]);
			this.oMS_taf.innerHTML = this.MS_taf = parseInt(MSID[this.MS_ID][4]);
			this.oMS_atf_t.innerHTML = this.MS_atf + this.getMS_cAt();
			this.oMS_def_t.innerHTML = this.MS_def + this.getMS_cDe();
			this.oMS_ref_t.innerHTML = this.MS_ref + this.getMS_cRe();
			this.oMS_taf_t.innerHTML = this.MS_taf + this.getMS_cTa();
			if(pos == 'ms')
				alert(MSID[this.MS_ID][0] + '\n' + brToNL(MSID[this.MS_ID][5]));
		}

		this.spec_p_var = WepID[this.WepA_ID][5] + WepID[this.WepE_ID][5] + WepID[this.WepP_ID][5] + MSID[this.MS_ID][5];

		this.spec_prc = this.spec_p_var.match('完全防禦') + ', '
		 + this.spec_p_var.match('加速') + ', '
		 + this.spec_p_var.match('超前') + ', '
		 + this.spec_p_var.match('閃避') + ', '
		 + this.spec_p_var.match('逃離') + ', '
		 + this.spec_p_var.match('簡單推進') + ', '
		 + this.spec_p_var.match('強力推進') + ', '
		 + this.spec_p_var.match('最佳化推進') + ', '
		 + this.spec_p_var.match('高級推進') + ', '
		 + this.spec_p_var.match('極級推進') + ', '
		 + this.spec_p_var.match('校準') + ', '
		 + this.spec_p_var.match('瞄準') + ', '
		 + this.spec_p_var.match('集中') + ', '
		 + this.spec_p_var.match('預測') + ', '
		 + this.spec_p_var.match('自動鎖定') + ', '
		 + this.spec_p_var.match('高級校準') + ', '
		 + this.spec_p_var.match('無誤校準') + ', '
		 + this.spec_p_var.match('多重鎖定') + ', '
		 + this.spec_p_var.match('完美鎖定') + ', '
		 + this.spec_p_var.match('簡單防禦') + ', '
		 + this.spec_p_var.match('正常防禦') + ', '
		 + this.spec_p_var.match('強化防禦') + ', '
		 + this.spec_p_var.match('高級防禦') + ', '
		 + this.spec_p_var.match('最終防禦') + ', '
		 + this.spec_p_var.match('厚甲') + ', '
		 + this.spec_p_var.match('抗衝擊') + ', '
		 + this.spec_p_var.match('彈開') + ', '
		 + this.spec_p_var.match('Phase Shift') + ', '
		 + this.spec_p_var.match('V. P. S.') + ', '
		 + this.spec_p_var.match('耐熱') + ', '
		 + this.spec_p_var.match('熱轉移') + ', '
		 + this.spec_p_var.match('扭曲') + ', '
		 + this.spec_p_var.match('折射') + ', '
		 + this.spec_p_var.match('消散') + ', '
		 + this.spec_p_var.match('念動干擾') + ', '
		 + this.spec_p_var.match('重力操縱') + ', '
		 + this.spec_p_var.match('空間干擾') + ', '
		 + this.spec_p_var.match('時空擾亂') + ', '
		 + this.spec_p_var.match('次元連結') + ', '
		 + this.spec_p_var.match('格擋') + ', '
		 + this.spec_p_var.match('抗衡') + ', '
		 + this.spec_p_var.match('干涉') + ', '
		 + this.spec_p_var.match('堅壁') + ', '
		 + this.spec_p_var.match('空間相對位移') + ', '
		 + this.spec_p_var.match('底力') + ', '
		 + this.spec_p_var.match('興奮') + ', '
		 + this.spec_p_var.match('高熱能') + ', '
		 + this.spec_p_var.match('熔解') + ', '
		 + this.spec_p_var.match('禁錮') + ', '
		 + this.spec_p_var.match('貫穿') + ', '
		 + this.spec_p_var.match('網絡干擾') + ', '
		 + this.spec_p_var.match('雷達干擾') + ', '
		 + 'null';

		this.spec_prc = this.spec_prc.replace(/(null, )/g,'');
		this.spec_prc = this.spec_prc.replace(/(null)/g,'');

		this.oSpecPool.innerHTML = this.spec_prc;

		this.calcPiFixes();
		this.AdjustSt(Op);
		Op.AdjustSt(this);
	}

	this.AdjustSt = function(Op){

		this.oWep_ATK.innerHTML = this.getWeaponAtkRaw() + this.getWeaponAtkAdd();
		this.oWep_RDS.innerHTML = this.getWeaponRDSRaw() + this.getWeaponRDSAdd();
		this.oWep_HIT.innerHTML = this.getWeaponHitRaw() + this.getWeaponHitAdd();

		this.MS_AtFix = this.getMS_At() + this.getMS_cAt();
		this.MS_DeFix = this.getMS_De() + this.getMS_cDe();
		this.MS_ReFix = this.getMS_Re() + this.getMS_cRe();
		this.MS_TaFix = this.getMS_Ta() + this.getMS_cTa();

		//Type Lower-Case Specs of Hit Values
		var Pl_TarSGd = 0;
		var Pl_TarSEffect = 0;
		var Op_TarSGd = 0;
		var Op_TarSEffect=0;

		//Analyze MobS Grade - Basic
		if(Pl_TarSGd < 6 && Op_TarSGd < 6){
			if(this.spec_p_var.match('自動鎖定')) Pl_TarSGd = 1;
			if(this.spec_p_var.match('高級校準')) Pl_TarSGd = 2;
			if(this.spec_p_var.match('無誤校準')) Pl_TarSGd = 3;
			if(this.spec_p_var.match('多重鎖定')) Pl_TarSGd = 4;
			if(this.spec_p_var.match('完美鎖定')) Pl_TarSGd = 5;
			if(Op.spec_p_var.match('自動鎖定')) Op_TarSGd = 1;
			if(Op.spec_p_var.match('高級校準')) Op_TarSGd = 2;
			if(Op.spec_p_var.match('無誤校準')) Op_TarSGd = 3;
			if(Op.spec_p_var.match('多重鎖定')) Op_TarSGd = 4;
			if(Op.spec_p_var.match('完美鎖定')) Op_TarSGd = 5;
		}
		//End Lower-Case Specs of Hit Values

		//Insert Upper Case Effects
		var CeaseFlag;
		if(Op.spec_p_var.match('禁錮')){
			this.MS_ReFix -= 5;
			this.MS_TaFix -= 5;
			CeaseFlag = 1;
		}
		else CeaseFlag = 0;

		if 	(this.spec_p_var.match('逃離'))                     this.MS_ReFix += 14;
		else if (this.spec_p_var.match('閃避'))                 this.MS_ReFix += 10;
		else if (this.spec_p_var.match('超前') && !CeaseFlag)   this.MS_ReFix +=  6;
		else if (this.spec_p_var.match('加速') && !CeaseFlag)   this.MS_ReFix +=  2;

		if 	(this.spec_p_var.match('預測'))                     this.MS_TaFix += 14;
		else if (this.spec_p_var.match('集中'))                 this.MS_TaFix += 10;
		else if (this.spec_p_var.match('瞄準') && !CeaseFlag)   this.MS_TaFix +=  6;
		else if (this.spec_p_var.match('校準') && !CeaseFlag)   this.MS_TaFix +=  2;

		//Apply TarS
		if(Pl_TarSGd > Op_TarSGd && Pl_TarSGd < 6 && Op_TarSGd < 6){
			var Pl_TarSEffect = (Pl_TarSGd) / 10;
			this.MS_TaFix = Math.floor(this.MS_TaFix * (1 + Pl_TarSEffect));
		}

		//Upper Case Def Specs
		if	(this.spec_p_var.match('最終防禦'))     this.MS_DeFix += 15;
		else if	(this.spec_p_var.match('高級防禦')) this.MS_DeFix += 12;
		else if	(this.spec_p_var.match('強化防禦')) this.MS_DeFix +=  9;
		else if	(this.spec_p_var.match('正常防禦')) this.MS_DeFix +=  6;
		else if	(this.spec_p_var.match('簡單防禦')) this.MS_DeFix +=  3;

		if	(Op.spec_p_var.match('熔解'))	          this.MS_DeFix -= 10;
		else if	(Op.spec_p_var.match('高熱能'))	    this.MS_DeFix -=  5;

		if(this.MS_AtFix < 0) this.MS_AtFix = 0;
		if(this.MS_DeFix < 0) this.MS_DeFix = 0;
		if(this.MS_ReFix < 0) this.MS_ReFix = 0;
		if(this.MS_TaFix < 0) this.MS_TaFix = 0;

		this.oMS_atf_t.innerHTML = this.MS_AtFix;
		this.oMS_def_t.innerHTML = this.MS_DeFix;
		this.oMS_ref_t.innerHTML = this.MS_ReFix;
		this.oMS_taf_t.innerHTML = this.MS_TaFix;
		this.oWep_T_Dam.innerHTML = this.getWeaponAtk() * this.getWeaponRDS();
	}

	this.switchTactics = function(Op){
		alert('已方:\n　戰法名稱: '+TacticsID[this.oTactics.value][0]+'\n'+'　　機師修正\n　　　Attacking: '+TacticsID[this.oTactics.value][1]+'\n　　　Defending: '+TacticsID[this.oTactics.value][2]+'\n　　　Reacting: '+TacticsID[this.oTactics.value][3]+'\n　　　Targeting: '+TacticsID[this.oTactics.value][4]+'\n'+'　　機體修正: \n　　　命中: '+TacticsID[this.oTactics.value][5]+'\n　　　回避: '+TacticsID[this.oTactics.value][6]+'\n　　特殊效果: '+brToComma(TacticsID[this.oTactics.value][7]) +
		'\n______________________________\n\n敵方:\n　戰法名稱: '+TacticsID[Op.oTactics.value][0]+'\n'+'　　機師修正\n　　　Attacking: '+TacticsID[Op.oTactics.value][1]+'\n　　　Defending: '+TacticsID[Op.oTactics.value][2]+'\n　　　Reacting: '+TacticsID[Op.oTactics.value][3]+'\n　　　Targeting: '+TacticsID[Op.oTactics.value][4]+'\n'+'　　機體修正: \n　　　命中: '+TacticsID[Op.oTactics.value][5]+'\n　　　回避: '+TacticsID[Op.oTactics.value][6]+'\n　　特殊效果: '+brToComma(TacticsID[Op.oTactics.value][7]));
	}
	
	this.dataToStr = function(){
		var str;
		str =
			this.oAt.selectedIndex + ',' +
			this.oDe.selectedIndex + ',' +
			this.oRe.selectedIndex + ',' +
			this.oTa.selectedIndex + ',' +
			
			this.SpecifyLevel() + ',' +
			this.Level() + ',' +
			this.xGrowthPt() + ',' +
			this.oTypeInf.selectedIndex + ',' +
			this.oSeedMode.checked + ',' +
			this.oExamActi.checked + ',' +
			
			this.oWepA.selectedIndex + ',' +
			this.oWepE.selectedIndex + ',' +
			this.oWepP.selectedIndex + ',' +
			this.getWeaponAtkAdd() + ',' +
			this.getWeaponRDSAdd() + ',' +
			this.getWeaponHitAdd() + ',' +
			
			this.oMS.selectedIndex + ',' +
			this.getMS_cAt() + ',' +
			this.getMS_cDe() + ',' +
			this.getMS_cRe() + ',' +
			this.getMS_cTa() + '';
		return str;
	}
	
	this.strToData = function(str,Op){
		var dataArray;
		
		if( str == '' ){
			alert('請先在下方貼上資料字串！');
			return;
		}

		dataArray = str.split(',');
		
		if(dataArray.length != 21){
			alert('資料字串不完整或格式不符！');
			return;
		}
		
		this.oAt.selectedIndex = parseInt(dataArray[0]);
		this.oDe.selectedIndex = parseInt(dataArray[1]);
		this.oRe.selectedIndex = parseInt(dataArray[2]);
		this.oTa.selectedIndex = parseInt(dataArray[3]);
		
		if(dataArray[4] == 'true') this.oSpecifyLevel.checked = true;
		else this.oSpecifyLevel.checked = false;
		this.oLevel.value = parseInt(dataArray[5]);
		this.oxGrowthPt.value = parseInt(dataArray[6]);
		this.oTypeInf.selectedIndex = parseInt(dataArray[7]);
		if(dataArray[8] == 'true') this.oSeedMode.checked  = true;
		else this.oSeedMode.checked = false;
		if(dataArray[9] == 'true') this.oExamActi.checked  = true;
		this.oExamActi.checked  = false;
			
		this.oWepA.selectedIndex = parseInt(dataArray[10]);
		this.oWepE.selectedIndex = parseInt(dataArray[11]);
		this.oWepP.selectedIndex = parseInt(dataArray[12]);
		this.oWep_ATK_Add.value = parseInt(dataArray[13]);
		this.oWep_RDS_Add.value = parseInt(dataArray[14]);
		this.oWep_HIT_Add.value = parseInt(dataArray[15]);
			
		this.oMS.selectedIndex = parseInt(dataArray[16]);
		this.oMS_atf_c.value = parseInt(dataArray[17]);
		this.oMS_def_c.value = parseInt(dataArray[18]);
		this.oMS_ref_c.value = parseInt(dataArray[19]);
		this.oMS_taf_c.value = parseInt(dataArray[20]);
			
		this.statChanged();
		this.chk_dis_spcflv();
		this.switchWep(Op,'all');
			
		alert('資料匯入完成！');
	}
	
	this.saveToCookie = function(slot){
		var exdate = new Date();
		var dataStr = this.dataToStr();
		exdate.setDate(exdate.getDate() + 365);
		document.cookie = "pebueCalc" + slot + "=" + escape(dataStr) + ";expires="+exdate.toGMTString();
	}
	
	this.LoadFromCookie = function(slot, Op){
		var cookieStr = this.getSlotCookie(slot);
		this.strToData(cookieStr, Op);
	}
	
	this.getSlotCookie = function(slot){
		var c_name = "pebueCalc" + slot;
		if (document.cookie.length > 0){
		  c_start = document.cookie.indexOf(c_name + "=");
		  if( c_start != -1 ){
				c_start = c_start + c_name.length + 1;
				c_end = document.cookie.indexOf(";", c_start);
				if( c_end == -1) c_end = document.cookie.length;
				return unescape(document.cookie.substring(c_start, c_end));
			}
		}
		return "";
	}

}
// Player Class - End

//
// Calculations: Battle Simulation
//

// Parameters
var damage_cons_MS_Bias = 1;
var damage_cons_MS_Sense = 40;
var damage_cons_Pi_Bias = 1;
var damage_cons_Pi_Sense = 100;
var acc_cons_MS_Bias = 1;
var acc_cons_MS_Sense = 40;
var acc_cons_Pi_Bias = 0.8;
var acc_cons_Pi_Sense = 100;

function pd_CalHitDam(Pl, Op){

	var AtkByMS = damage_cons_MS_Bias + ( Pl.cl_ms_at - Op.cl_ms_de ) / damage_cons_MS_Sense ;
	var AtkByPi = damage_cons_Pi_Bias + ( Pl.cl_pi_at - Op.cl_pi_de ) / damage_cons_Pi_Sense ;

	if(AtkByMS < 0) AtkByMS = 0;
	else if(AtkByPi < 0) AtkByPi = 0;

	Pl.dprd_max = Pl.getWeaponAtk() * AtkByMS * AtkByPi;
	Pl.dprd_min = GetWAtkL(Pl.dprd_max, Pl.Ta(), Op.Re());

	var rds_multiplier = 1;
	if (Pl.spec_p_var.match('三連擊') || Pl.getTacticSpec().match('三連擊') ) rds_multiplier = 3;
	else if (Pl.spec_p_var.match('二連擊') || Pl.getTacticSpec().match('三連擊') ) rds_multiplier = 2;

	if(Pl.spec_p_var.match('實彈擊落') && Op.oAttrb.innerHTML.match('飛彈')) rds_multiplier *= 0.6;
	if(Pl.spec_p_var.match('密集射擊') ) rds_multiplier /= 0.6;

	var T_Rds = Math.round(Pl.getWeaponRDS() * rds_multiplier);
	var DamagePrevent = 0;

	if(Pl.spec_p_var.match('貫穿') == null){
		if(Op.spec_p_var.match('空間相對位移')) DamagePrevent = 5000;
		else if (Op.spec_p_var.match('堅壁'))	DamagePrevent = 3500;
		else if (Op.spec_p_var.match('干涉'))	DamagePrevent = 2000;
		else if (Op.spec_p_var.match('抗衡'))	DamagePrevent = 1000;
		else if (Op.spec_p_var.match('格擋'))	DamagePrevent = 400;
	
		var myDamAvg = (Pl.dprd_max + Pl.dprd_min) / 2 * T_Rds;
		DamagePrevent += tryGetPv(myDamAvg, Pl, Op, 'Beam');
		DamagePrevent += tryGetPv(myDamAvg, Pl, Op, '實體');
		DamagePrevent += tryGetPv(myDamAvg, Pl, Op, '特殊');
	}

	if( DamagePrevent > 0 ){
		Pl.dprd_max -= DamagePrevent / T_Rds;
		Pl.dprd_min -= DamagePrevent / T_Rds;
	}

	if(Pl.dprd_max < 0) Pl.dprd_max = 0;
	if(Pl.dprd_min < 0) Pl.dprd_min = 0;

	Pl.oDprd_Max.innerHTML = Pl.dprd_max;
	Pl.oDprd_Min.innerHTML = Pl.dprd_min;

	var Op_MobS_Fix = 1.0;

	if(Op.spec_p_var.match('極級推進'))  Op_MobS_Fix = 0.5;
	else if(Op.spec_p_var.match('高級推進'))  Op_MobS_Fix = 0.6;
	else if(Op.spec_p_var.match('最佳化推進'))Op_MobS_Fix = 0.7;
	else if(Op.spec_p_var.match('強力推進'))  Op_MobS_Fix = 0.8;
	else if(Op.spec_p_var.match('簡單推進'))  Op_MobS_Fix = 0.9;

	var AccByMS = acc_cons_MS_Bias + ( Pl.cl_ms_ta - Op.cl_ms_re ) / acc_cons_MS_Sense ;
	var AccByPi = acc_cons_Pi_Bias + ( Pl.cl_pi_ta - Op.cl_pi_re ) / acc_cons_Pi_Sense ;

	if(AccByMS < 0) AccByMS = 0;
	else if(AccByPi < 0) AccByPi = 0;

	Pl.accprd = Math.floor(100 * Pl.getWeaponHit() * AccByMS * AccByPi * Op_MobS_Fix)/100;
	if (Pl.accprd < 0) Pl.accprd = 0;
	if (Pl.accprd > 100) Pl.accprd = 100;

	Pl.oAccPrd.innerHTML = Pl.accprd;
	Pl.oExpdHits.innerHTML = Math.round(Pl.accprd * T_Rds)/100;

	var tmpMin = Math.round( Pl.dprd_min * T_Rds * Pl.accprd / 100 );
	var tmpMax = Math.round( Pl.dprd_max * T_Rds * Pl.accprd / 100 );
	if(tmpMin < 0) tmpMin = 0;
	if(tmpMax < 0) tmpMax = 0;
	var tmpAvg = ( tmpMax + tmpMin )/2 * Pl.accprd / 100;

	Pl.oDamMin.innerHTML = tmpMin;
	Pl.oDamMax.innerHTML = tmpMax
	Pl.oDamAvg.innerHTML  = Math.round( tmpAvg );
	Pl.oExpdDam.innerHTML = Math.round( tmpAvg * T_Rds );

}

function pd_Calc(Pl, Op){

	Pl.calcPiFixes();
	Op.calcPiFixes();

	Pl.cl_pi_at = parseInt( Pl.At() + Pl.At_Fix + Pl.getAtBonus() + Pl.getTacticInf(1) );
	Pl.cl_pi_de = parseInt( Pl.De() + Pl.De_Fix + Pl.getDeBonus() + Pl.getTacticInf(2) );
	Pl.cl_pi_re = parseInt( Pl.Re() + Pl.Re_Fix + Pl.getReBonus() + Pl.getTacticInf(3) );
	Pl.cl_pi_ta = parseInt( Pl.Ta() + Pl.Ta_Fix + Pl.getTaBonus() + Pl.getTacticInf(4) );
	Op.cl_pi_at = parseInt( Op.At() + Op.At_Fix + Op.getAtBonus() + Op.getTacticInf(1) );
	Op.cl_pi_de = parseInt( Op.De() + Op.De_Fix + Op.getDeBonus() + Op.getTacticInf(2) );
	Op.cl_pi_re = parseInt( Op.Re() + Op.Re_Fix + Op.getReBonus() + Op.getTacticInf(3) );
	Op.cl_pi_ta = parseInt( Op.Ta() + Op.Ta_Fix + Op.getTaBonus() + Op.getTacticInf(4) );

	Pl.cl_ms_at = Pl.getMS_tAt();
	Pl.cl_ms_de = Pl.getMS_tDe();
	Pl.cl_ms_re = Pl.getMS_tRe() + Pl.getTacticInf(6);
	Pl.cl_ms_ta = Pl.getMS_tTa() + Pl.getTacticInf(5);
	Op.cl_ms_at = Op.getMS_tAt();
	Op.cl_ms_de = Op.getMS_tDe();
	Op.cl_ms_re = Op.getMS_tRe() + Op.getTacticInf(6);
	Op.cl_ms_ta = Op.getMS_tTa() + Op.getTacticInf(5);

	pd_CalHitDam(Pl, Op);
	pd_CalHitDam(Op, Pl);

}

// Range Convert
function getRange(r){
	r = parseInt(r);
	switch(r){
		case 0: return '遠距離';
		case 1: return '近距離';
		case 2: return '特殊距離';
	}
}
// Attribute Convert
function getAttrb(a){
	a = parseInt(a);
	switch(a){
		case 0: return 'Beam';
		case 1: return '實體';
		case 2: return '飛彈';
		case 3: return '特殊';
		case 4: return '要塞武器';
	}
}

function tryGetPv(myDamAvg, Pl, Op, pvAttrb){
	
	var PvTypes = null;
	DamagePrevent = 0;

	if(Pl.oAttrb.innerHTML.match(pvAttrb)){
		if(pvAttrb == 'Beam'){
			PvTypes = new Array('耐熱','熱轉移','扭曲','折射','消散');
		}
		else if (pvAttrb == '實體'){
			PvTypes = new Array('厚甲','抗衝擊','彈開','Phase Shift','V. P. S.');
		}
		else if (pvAttrb == '特殊'){
			PvTypes = new Array('念動干擾','重力操縱','空間干擾','時空擾亂','因果律干涉');
		}
		if (Op.spec_p_var.match(PvTypes[0])) DamagePrevent += getPvAmount(myDamAvg, 0.10, 200, 1200);
		if (Op.spec_p_var.match(PvTypes[1])) DamagePrevent += getPvAmount(myDamAvg, 0.15, 500, 2000);
		if (Op.spec_p_var.match(PvTypes[2])) DamagePrevent += getPvAmount(myDamAvg, 0.20, 1000, 4000);
		if (Op.spec_p_var.match(PvTypes[3])) DamagePrevent += getPvAmount(myDamAvg, 0.27, 1700, 6500);
		if (Op.spec_p_var.match(PvTypes[4])) DamagePrevent += getPvAmount(myDamAvg, 0.35, 2500, 10000);
	}
	
	return DamagePrevent;
	
}

function getPvAmount(Atk, ByPc, ByValue, PvMax){
	Pv = Atk * ByPc + ByValue;
	return (Pv < PvMax) ? Pv : PvMax;
}

//
// General Functions
//

// Calculate Stat Points
function CalcStatPt(Lv_N){
	var Stat_Gain=3;
	var Lv;

	for(Lv=1;Lv<=Lv_N;Lv++){
		if (Lv%5 == 0)Stat_Gain++;
	}

	return Stat_Gain;
}

// Calculate Stats Required
function CalcStatReq(Stat_N){
	var Stat_Req=2;
	var Stat;
	for(Stat=1;Stat<=Stat_N;Stat++){
		if ((Stat)%10 == 0 && Stat>1) Stat_Req++;
	}
	return Stat_Req;
}

// Calculate Experience Required to advance
function CalcExp (NowLv){
	var Lv = parseInt(NowLv) + 1;
	var expr = Math.floor((4*Math.pow(Lv,3) - 5.34*Math.pow(Lv,2) - 41.5*Lv) + 161);
	return expr;
}

// Parse an integer into numeric format
function numFormat(num){
	num = parseInt(num);
	var r = num%1000;
	var q = Math.floor(num/1000);

	var sR = r + "";
	if( Math.floor(r / 100) < 1 && q != 0){
		if(Math.floor(r / 10) >= 1) sR = "0" + r;
		else sR = "00" + r;
	}

	var output = sR + "";

	while( q != 0 ){
		r = q%1000;
		sR = r + "";
		if( Math.floor(r / 100) < 1 && Math.floor(q / 1000) != 0){
			if(Math.floor(r / 10) >= 1) sR = "0" + r;
			else sR = "00" + r;
		}
		output = sR + "," + output;
		q = Math.floor(q/1000);
	}
	return output;
}

// Parse integer from string value
function parseNumber_c(val){
	val = val.replace(/[a-zA-Z+&!?=,<>@#$%\^\*\#\/\\\\[\]\{\}\'\"]+/,'');
	val = parseInt(val);
	if (!val) val = 0;
	return val;
}

// Parse integer from object
function numParse(obj){
	obj.value = parseNumber_c(obj.value);
}

// Calculate Total Growth Points
function CalcTotalStatPtsG(NowLv){
	var lv_loop_ct;
	var Growth_Total = 36;
		for(lv_loop_ct=1;lv_loop_ct <= NowLv;lv_loop_ct++){
			Growth_Total += CalcStatPt(lv_loop_ct);
		}
	return Growth_Total;
}

// Calculate Total Stat Points Required
function CalcTotalStatPtsR (NowStat){
	var stat_loop_ct;
	var stat_now = 0;
	for(stat_loop_ct=1;stat_loop_ct < NowStat;stat_loop_ct++){
		stat_now += CalcStatReq(stat_loop_ct);
	}
	return stat_now;
}

// Calculate Levels Required
function CalcLevelRec (NowStat, NPt){
	if (!NPt)	var NPt = CalcTotalStatPtsR(NowStat);
	var Lv;
	var LvPt = 36;
	for(Lv = 1; LvPt < NPt; Lv++){
		LvPt = CalcTotalStatPtsG(Lv);
	}
	return Lv-1;
}

// Get Weapon Attack Lower Limit
function GetWAtkL(Atk, Tar, Re){
	//武器攻擊力, 攻方Targeting, 守方回避值
	if (Tar < Re/3)	AtkL = Atk/5;
	else
	AtkL=Atk * (Math.floor(Tar-Re/3) * 0.01);
	if (AtkL < Atk/5) AtkL = Atk/5;
	if (AtkL > Atk) AtkL = Atk;
	AtkL = Math.round(AtkL);
	return AtkL; //攻方攻擊值計算下限
}

// <br> Converting Functions
function brToNL(Str){
	Str = Str.replace(/(<br>)/g,'\n');
	return Str;
}
function brToComma(Str){
	Str = Str.replace(/(<br>)/g,', ');
	return Str;
}


