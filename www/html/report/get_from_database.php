<?php


class teamReport {
	
	public $team;

	private $searchError = false;
	public $numberOfMatches;

/*
	
	public $portcullisVar;
	public $chevalDeFriseVar;
	public $moatVar;
	public $rampartsVar;
	public $drawbridgeVar;
	public $sallyPortVar;
	public $rockWallVar;
	public $roughTerrainVar;
	public $lowBarVar;
	*/

	private $portcullisSearch;
	private $chevalDeFriseSearch;
	private $moatSearch;
	private $rampartsSearch;
	private $drawbridgeSearch;
	private $sallyPortSearch;
	private $rockWallSearch;
	private $roughTerrainSearch;
	private $lowBarSearch;

	private $numportcullis;
	private $numchevalDeFrise;
	private $nummoat;
	private $numramparts;
	private $numdrawbridge;
	private $numsallyPort;
	private $numrockWall;
	private $numroughTerrain;
	private $numlowBar;

	private $autoBreachedSearch;
	private $autoReachedSearch;
	private $towerScaleSearch;
	private $towerChallengeSearch;
	private $commentsSearch;


	private $MLGAS;
	private $autoLowGoalsMade;
	private $lowGoalAutoMisses;
	private $MHGAS;
	private $autoHighGoalsMade;
	private $highGoalAutoMisses;
	private $autoOther;
	private $autoLowBar;

	private $numFouls;
	private $numTechFouls;
	private $numRedCards;
	private $numYellowCards;
	private $numDisabled;

	private $lgma;
	private $lgha;
	private $hgma;
	private $hgha; 


	private $total;
	private $portcullisTotal;
	private $moatTotal;
	private $rampartsTotal;
	private $drawbridgeTotal;
	private $sallyPortTotal;
	private $rockWallTotal;
	private $roughTerrainTotal;
	private $lowBarTotal;

    function __construct($team) {
    	$this->team = $team;

		require('/var/www/sqli_connect.php');

    	// Creates querys for the database
	
		$portcullisQuery = "SELECT categoryAScore AS PortcullisCrosses FROM `match` WHERE `team` = {$this->team} AND `categoryA` ='Portcullis'";
		$chevalDeFriseQuery = "SELECT categoryAScore AS ChevalCrosses FROM `match` WHERE `team` = {$this->team} AND `categoryA` ='ChevaldeFrise'";
		$moatQuery = "SELECT categoryBScore AS MoatCrosses FROM `match` WHERE `team` = {$this->team} AND `categoryB` ='Moat'";
		$rampartsQuery = "SELECT categoryBScore AS RampartCrosses FROM `match` WHERE `team` = {$this->team} AND `categoryB` ='Ramparts'";
		$drawbridgeQuery = "SELECT categoryCScore AS DrawbridgeCrosses FROM `match` WHERE `team` = {$this->team} AND `categoryC` ='Drawbridge'";
		$sallyPortQuery = "SELECT categoryCScore AS SallyPortCrosses FROM `match` WHERE `team` = {$this->team} AND `categoryC` ='Sally Port'";
		$rockWallQuery = "SELECT categoryDScore AS RockWallCrosses FROM `match` WHERE `team` = {$this->team} AND `categoryD` ='Rock Wall'";
		$roughTerrainQuery = "SELECT categoryDScore AS RoughTerrainCrosses FROM `match` WHERE `team` = {$this->team} AND `categoryD` ='Rough Terrain'";
		$lowBarQuery = "SELECT lowBarScore AS LowBarCrosses FROM `match` WHERE `team` = {$this->team}";
		
		$lowGoalHitsQuery = "SELECT SUM(lowGoalShots) AS LowGoalHits FROM `match` WHERE `team` = {$this->team}";
		$lowGoalMissesQuery = "SELECT SUM(missedLowGoalShots) AS LowGoalMisses FROM `match` WHERE `team` = {$this->team}";
		$highGoalHitsQuery = "SELECT SUM(highGoalShots) AS HighGoalHits FROM `match` WHERE `team` = {$this->team}";
		$highGoalMissesQuery = "SELECT SUM(missedHighGoalShots) AS HighGoalMisses FROM `match` WHERE `team` = {$this->team}";
		$numMatchesQuery = "SELECT team FROM `match` WHERE `team` = {$this->team}";
		$towerScaleQuery = "SELECT scaleTower FROM `match` WHERE `team` = {$this->team} AND `scaleTower` = 'Yes'";
		$towerChallengeQuery = "SELECT challengeTower FROM `match` WHERE `team` = {$this->team} AND `challengeTower` = 'Yes'";
		$commentsQuery = "SELECT comments FROM `match` WHERE `team` = {$this->team} AND `comments` != 'N/A'";

		$autoBreachedQuery = "SELECT autoDefence FROM `match` WHERE `team` = {$this->team} AND `autoDefence` = 'Breached'";
		$autoReachedQuery = "SELECT autoDefence FROM `match` WHERE `team` = {$this->team} AND `autoDefence` = 'Reached'";
		$autoBreachedLowBarQuery = "SELECT breachDefence FROM `match` WHERE `team` = {$this->team} AND `breachDefence` = 'Low Bar'";
		$autoBreachedOtherQuery = "SELECT breachDefence FROM `match` WHERE `team` = {$this->team} AND `breachDefence` = 'Other'";
		
		$highGoalAutoShotsMadeQuery = "SELECT SUM(highGoalAutoShotsMade) AS HGAutoMade FROM `match` WHERE `team` = {$this->team}";
		$highGoalAutoMissesQuery = "SELECT SUM(highGoalAutoMisses) AS HGAutoMisses FROM `match` WHERE `team` = {$this->team}";
		$lowGoalAutoShotsMadeQuery = "SELECT SUM(lowGoalAutoShotsMade) AS LGAutoMade FROM `match` WHERE `team` = {$this->team}";
		$lowGoalAutoMissesQuery = "SELECT SUM(lowGoalAutoMisses) AS LGAutoMisses FROM `match` WHERE `team` = {$this->team}";
		$maxHighGoalAutoShotQuery = "SELECT MAX(highGoalAutoShotsMade) AS HGAutoMax FROM `match` WHERE `team` = {$this->team}";
		$maxLowGoalAutoShotQuery = "SELECT MAX(lowGoalAutoShotsMade) AS LGAutoMax FROM `match` WHERE `team` = {$this->team}";
		

		$foulQuery = "SELECT SUM(fouls) AS FoulSum FROM `match` WHERE `team` = {$this->team}";
		$techFoulQuery = "SELECT SUM(techFouls) AS TechFoulSum FROM `match` WHERE `team` = {$this->team}";
		$redCardQuery = "SELECT redCard FROM `match` WHERE `team` = {$this->team} AND `redCard` = 'Yes'";
		$yellowCardQuery = "SELECT yellowCard FROM `match` WHERE `team` = {$this->team} AND `yellowCard` = 'Yes'";
		$disabledQuery = "SELECT disabled FROM `match` WHERE `team` = {$this->team} AND `disabled` = 'Yes'";




		$sumchevaldefriseQuery = "SELECT SUM(categoryAScore) AS sumCheval FROM `match` WHERE `team` = {$this->team} AND `categoryA` ='ChevaldeFrise'";
		$sumChevalDeFriseSearch = $dbc->query($sumchevaldefriseQuery);
		$this->total = mysqli_fetch_assoc($sumChevalDeFriseSearch); 
		$sumPortcullisQuery = "SELECT SUM(categoryAScore) AS sumPortcullis FROM `match` WHERE `team` = {$this->team} AND `categoryA` ='Portcullis'";
		$sumPortcullisSearch = $dbc->query($sumPortcullisQuery);
		$this->portcullisTotal = mysqli_fetch_assoc($sumPortcullisSearch);
		$sumMoatQuery = "SELECT SUM(categoryBScore) AS sumMoat FROM `match` WHERE `team` = {$this->team} AND `categoryB` ='Moat'";
		$sumMoatSearch = $dbc->query($sumMoatQuery);
		$this->moatTotal = mysqli_fetch_assoc($sumMoatSearch);
		$sumRampartsQuery = "SELECT SUM(categoryBScore) AS sumRamparts FROM `match` WHERE `team` = {$this->team} AND `categoryB` ='Ramparts'";
		$sumRampartsSearch = $dbc->query($sumRampartsQuery);
		$this->rampartsTotal = mysqli_fetch_assoc($sumRampartsSearch);
		$sumDrawbridgeQuery = "SELECT SUM(categoryCScore) AS sumDrawbridge FROM `match` WHERE `team` = {$this->team} AND `categoryC` ='Drawbridge'";
		$sumDrawbridgeSearch = $dbc->query($sumDrawbridgeQuery);
		$this->drawbridgeTotal = mysqli_fetch_assoc($sumDrawbridgeSearch);
		$sumSallyPortQuery = "SELECT SUM(categoryCScore) AS sumSallyPort FROM `match` WHERE `team` = {$this->team} AND `categoryC` ='Sally Port'";
		$sumSallyPortSearch = $dbc->query($sumSallyPortQuery);
		$this->sallyPortTotal = mysqli_fetch_assoc($sumSallyPortSearch);
		$sumRockWallQuery = "SELECT SUM(categoryDScore) AS sumRockWall FROM `match` WHERE `team` = {$this->team} AND `categoryD` ='Rock Wall'";
		$sumRockWallSearch = $dbc->query($sumRockWallQuery);
		$this->rockWallTotal = mysqli_fetch_assoc($sumRockWallSearch);
		$sumRoughTerrainQuery = "SELECT SUM(categoryDScore) AS sumRoughTerrain FROM `match` WHERE `team` = {$this->team} AND `categoryD` ='Rough Terrain'";
		$sumRoughTerrainSearch = $dbc->query($sumRoughTerrainQuery);
		$this->roughTerrainTotal = mysqli_fetch_assoc($sumRoughTerrainSearch);
		$sumLowBarQuery = "SELECT SUM(lowBarScore) AS sumLowBar FROM `match` WHERE `team` = {$this->team}";
		$sumLowBarSearch = $dbc->query($sumLowBarQuery);
		$this->lowBarTotal = mysqli_fetch_assoc($sumLowBarSearch);
		// Searching Database for what we need //




		$this->portcullisSearch = $dbc->query($portcullisQuery);
		$this->chevalDeFriseSearch = $dbc->query($chevalDeFriseQuery);
		$this->moatSearch = $dbc->query($moatQuery);
		$this->rampartsSearch = $dbc->query($rampartsQuery);
		$this->drawbridgeSearch = $dbc->query($drawbridgeQuery);
		$this->sallyPortSearch = $dbc->query($sallyPortQuery);
		$this->rockWallSearch = $dbc->query($rockWallQuery);
		$this->roughTerrainSearch = $dbc->query($roughTerrainQuery);
		$this->lowBarSearch = $dbc->query($lowBarQuery);

		$lowGoalHitsSearch = $dbc->query($lowGoalHitsQuery);
		$lowGoalMissesSearch = $dbc->query($lowGoalMissesQuery);
		$highGoalHitsSearch = $dbc->query($highGoalHitsQuery);
		$highGoalMissesSearch = $dbc->query($highGoalMissesQuery);
		
		$this->towerScaleSearch = $dbc->query($towerScaleQuery);
		$this->towerChallengeSearch = $dbc->query($towerChallengeQuery);

		$numMatchesSearch = $dbc->query($numMatchesQuery);
		$this->commentsSearch = $dbc->query($commentsQuery);

		$this->autoBreachedSearch = $dbc->query($autoBreachedQuery);
		$this->autoReachedSearch = $dbc->query($autoReachedQuery);
		$autoBreachedLowBarSearch = $dbc->query($autoBreachedLowBarQuery);
		$autoBreachedOtherSearch = $dbc->query($autoBreachedOtherQuery);
		
		$highGoalAutoShotsMadeSearch = $dbc->query($highGoalAutoShotsMadeQuery);
		$highGoalAutoMissesSearch = $dbc->query($highGoalAutoMissesQuery);
		$lowGoalAutoShotsMadeSearch = $dbc->query($lowGoalAutoShotsMadeQuery);
		$lowGoalAutoMissesSearch = $dbc->query($lowGoalAutoMissesQuery);
		$maxHighGoalAutoShotSearch = $dbc->query($maxHighGoalAutoShotQuery);
		$maxLowGoalAutoShotSearch = $dbc->query($maxLowGoalAutoShotQuery);

		$foulSearch = $dbc->query($foulQuery);
		$techFoulSearch = $dbc->query($techFoulQuery);
		$redCardSearch = $dbc->query($redCardQuery);
		$yellowCardSearch = $dbc->query($yellowCardQuery);
		$disabledSearch = $dbc->query($disabledQuery);

		    // Search Test
		if(!($this->portcullisSearch && $this->chevalDeFriseSearch && $this->moatSearch && $this->rampartsSearch && 
		$this->drawbridgeSearch && $this->sallyPortSearch && $this->rockWallSearch && $this->roughTerrainSearch &&
		$this->lowBarSearch && $lowGoalHitsSearch && $lowGoalMissesSearch && $highGoalHitsSearch &&
		$highGoalMissesSearch && $this->towerScaleSearch && $this->towerChallengeSearch && $numMatchesSearch &&
		$this->autoBreachedSearch && $this->autoReachedSearch &&
		$autoBreachedLowBarSearch && $autoBreachedOtherSearch && $highGoalAutoShotsMadeSearch &&
		$highGoalAutoMissesSearch && $lowGoalAutoShotsMadeSearch && $lowGoalAutoMissesSearch &&
		$maxLowGoalAutoShotSearch && $maxHighGoalAutoShotSearch)){
			$this->searchError = true;
			echo "Couldn't issue database query/'s";
			echo mysqli_error($dbc);
		}
	
			// Varriables //

		$this->numberOfMatches = mysqli_num_rows($numMatchesSearch);

		$this->numportcullis = mysqli_num_rows($this->portcullisSearch);
		$this->numchevalDeFrise = mysqli_num_rows($this->chevalDeFriseSearch);
		$this->nummoat = mysqli_num_rows($this->moatSearch);
		$this->numramparts = mysqli_num_rows($this->rampartsSearch);
		$this->numdrawbridge = mysqli_num_rows($this->drawbridgeSearch);
		$this->numsallyPort = mysqli_num_rows($this->sallyPortSearch);
		$this->numrockWall = mysqli_num_rows($this->rockWallSearch);
		$this->numroughTerrain = mysqli_num_rows($this->roughTerrainSearch);
		$this->numlowBar = mysqli_num_rows($this->lowBarSearch);



		$this->MLGAS = mysqli_fetch_assoc($maxLowGoalAutoShotSearch);
		$this->autoLowGoalsMade = mysqli_fetch_assoc($lowGoalAutoShotsMadeSearch);
		$this->lowGoalAutoMisses = mysqli_fetch_assoc($lowGoalAutoMissesSearch);
		$this->MHGAS = mysqli_fetch_assoc($maxHighGoalAutoShotSearch);
		$this->autoHighGoalsMade = mysqli_fetch_assoc($highGoalAutoShotsMadeSearch);
		$this->highGoalAutoMisses = mysqli_fetch_assoc($highGoalAutoMissesSearch);
		$this->autoOther = mysqli_num_rows($autoBreachedOtherSearch);
		$this->autoLowBar = mysqli_num_rows($autoBreachedLowBarSearch);

		$this->numFouls = mysqli_fetch_assoc($foulSearch);
		$this->numTechFouls = mysqli_fetch_assoc($techFoulSearch);
		$this->numRedCards = mysqli_num_rows($redCardSearch);
		$this->numYellowCards = mysqli_num_rows($yellowCardSearch);
		$this->numDisabled = mysqli_num_rows($disabledSearch);

		$this->lgma = mysqli_fetch_assoc($lowGoalMissesSearch);
		$this->lgha = mysqli_fetch_assoc($lowGoalHitsSearch);
		$this->hgma = mysqli_fetch_assoc($highGoalMissesSearch);
		$this->hgha = mysqli_fetch_assoc($highGoalHitsSearch); 



/*
		$this->total = 0;
		$numRows = 0;
		while($row = mysqli_fetch_assoc($this->chevalDeFriseSearch)){
			$numRows += 1;
			foreach ($row as $key => $value){
				$this->total += $value;
			}
		}
		if($numRows != 0){
			$this->total = 0;
		}
		$this->total = $this->total*3;
*/
	}

	public function check_error(){
		return $this->searchError;
	}
	public function team_number(){
		return $this->team;
	}


		// Functions which return data //

	private function query_sum($search){
		$total = 0;
		$numRows = 0;
		while($row = mysqli_fetch_assoc($search)){
			$numRows += 1;
			foreach ($row as $key => $value){
				$total += $value;
			}
		}
		if($numRows != 0){
			return $total;
		} else {
			return 0;
		}
	} //[RETURNS] Query data sum

	private function defence_crosses($defsearch, $defnum){
		if($defnum >= 1){
			return "{$this->query_sum($defsearch)}/{$defnum}";
		} else {
			return "0/{$defnum}";
		}
	} // [RETURNS] Defence report

	private function defence_score($defsearch, $defnum){
		//if($defnum == 0)
		//	return 0;
		//$avgCrosses = $this->query_sum($defsearch) / $defnum;
		//$score = 0;
		//for ($i = 0; $i <= $defnum; $i++){
		//	if($i <=2){
		//		$score += 4.5;
		//	} else {
		//		$score += 2;
		//	}
		//}
		//return $score;
		$score =  ($this->query_sum($defsearch) * 3);
		return $score;
	}

	public function auto_low_goals(){
		
		$totalAutoLowGoalShots = $this->autoLowGoalsMade['LGAutoMade'] + $this->lowGoalAutoMisses['LGAutoMisses'];

		if($this->MLGAS['LGAutoMax'] > 1){
			return "{$this->autoLowGoalsMade['LGAutoMade']}/{$totalAutoLowGoalShots}(Can Make {$this->MLGAS['LGAutoMax']} Shots in Auto)";
		} else {
			return "{$this->autoLowGoalsMade['LGAutoMade']}/{$totalAutoLowGoalShots}";
		}
	} //[RETURNS] STRING

	public function auto_high_goals(){

		$totalAutoHighGoalShots = $this->autoHighGoalsMade['HGAutoMade'] + $this->highGoalAutoMisses['HGAutoMisses'];

		if($this->MHGAS['HGAutoMax'] > 1){
			return "{$this->autoHighGoalsMade['HGAutoMade']}/{$totalAutoHighGoalShots}(Can Make {$this->MHGAS['HGAutoMax']} Shots in Auto)";
		} else {
			return "{$this->autoHighGoalsMade['HGAutoMade']}/{$totalAutoHighGoalShots}";
		}
	} //[RETURNS] STRING
	
	public function highest_auto_movement(){
		if(mysqli_num_rows($this->autoBreachedSearch) >= 1){
			return 'Breach';
		} elseif(mysqli_num_rows($this->autoReachedSearch) >= 1) {
			return 'Reach';
		} else {
			return 'No Interaction';
		}
	} //[RETURNS] STRING
	
	public function auto_times_breached(){ // [NOTE] Displays Times crossed low bar : times crossed everything else
		if($this->autoLowBar > 0){
			return "{$this->autoLowBar} : {$this->autoOther}";
		} elseif($this->autoOther > 0) {
			return "{$this->autoLowBar} : {$this->autoOther}";
		} else {
			return "0 : 0";
		}
	} //[RETURNS] STRING

	public function times_scaled(){
		$numScale = mysqli_num_rows($this->towerScaleSearch);
		if($numScale > 0){
			return "{$numScale}/{$this->numberOfMatches}";
		} else {
			return "N/A";
		}
	} //[RETURNS] STRING
	
	public function times_challenged(){
		$numChallenge = mysqli_num_rows($this->towerChallengeSearch);
		if($numChallenge > 0){
			return "{$numChallenge}/{$this->numberOfMatches}";
		} else {
			return "N/A";
		}
	} //[RETURNS] STRING
		

		// [NOTE] May have to fix having 2 lgha, lowgoalhits, hgha, highgoalhits in following functions


	public function low_goal_accuracy(){
		$lowGoalHits = $this->lgha['LowGoalHits'];
		$lowGoalMisses = $this->lgma['LowGoalMisses'];
		$totalLowGoalShots = ($lowGoalHits+$lowGoalMisses);
		if($totalLowGoalShots > 0){
			$lowGoalAccuracy = (($lowGoalHits/$totalLowGoalShots)*100);
			$lowGoalAccuracy = round($lowGoalAccuracy, 1, PHP_ROUND_HALF_UP); 
			return "({$lowGoalAccuracy}%)"; // [MAYBE ADDED] {$this->lowGoalHits}/{$this->totalLowGoalShots} 
		} else {
			return "N/A";
		}
	} // [RETURNS] STRING

	public function avg_low_goal_shots_per_match(){
		$lowGoalHits = $this->lgha['LowGoalHits'];
		$lowGoalAccuracyFraction = ($lowGoalHits/$this->numberOfMatches); 
		$lowGoalAccuracyFraction = round($lowGoalAccuracyFraction, 1, PHP_ROUND_HALF_UP);
		return "{$lowGoalAccuracyFraction}";
	} // [RETURNS] STRING (1'st decimal place)
		

		
	public function high_goal_accuracy(){
		$highGoalHits = $this->hgha['HighGoalHits'];
		$highGoalMisses = $this->hgma['HighGoalMisses'];
		$totalHighGoalShots = ($highGoalHits+$highGoalMisses);
		if($totalHighGoalShots > 0){
			$highGoalAccuracy = (($highGoalHits/$totalHighGoalShots)*100); 
			$highGoalAccuracy = round($highGoalAccuracy, 1, PHP_ROUND_HALF_UP);
			return "({$highGoalAccuracy}%)"; //[MAYBE ADDED] {$this->highGoalHits}/{$this->totalHighGoalShots} 
		} else {
			return "N/A";
		}
	} // [RETURNS] STRING

	public function avg_high_goal_shots_per_match(){
		$highGoalHits = $this->hgha['HighGoalHits'];
		$highGoalAccuracyFraction = ($highGoalHits/$this->numberOfMatches); 
		$highGoalAccuracyFraction = round($highGoalAccuracyFraction, 1, PHP_ROUND_HALF_UP);
		return "{$highGoalAccuracyFraction}";
	} // [RETURNS] STRING (1'st decimal place)


	public function portcullis_crosses(){
		return $this->defence_crosses($this->portcullisSearch, $this->numportcullis);
	} // [RETURNS] STRING
	public function cheval_de_frise_crosses(){
		return $this->defence_crosses($this->chevalDeFriseSearch, $this->numchevalDeFrise);
	} // [RETURNS] STRING
	public function moat_crosses(){
		return $this->defence_crosses($this->moatSearch, $this->nummoat);
	} // [RETURNS] STRING
	public function ramparts_crosses(){
		return $this->defence_crosses($this->rampartsSearch, $this->numramparts);
	} // [RETURNS] STRING
	public function drawbridge_crosses(){
		return $this->defence_crosses($this->drawbridgeSearch, $this->numdrawbridge);
	} // [RETURNS] STRING
	public function sally_port_crosses(){
		return $this->defence_crosses($this->sallyPortSearch, $this->numsallyPort);
	} // [RETURNS] STRING
	public function rockwall_crosses(){
		return $this->defence_crosses($this->rockWallSearch, $this->numrockWall);
	} // [RETURNS] STRING
	public function rough_terrain_crosses(){
		return $this->defence_crosses($this->roughTerrainSearch, $this->numroughTerrain);
	} // [RETURNS] STRING
	public function low_bar_crosses(){
		return $this->defence_crosses($this->lowBarSearch, $this->numlowBar);
	} // [RETURNS] STRING
	public function report_cards(){
		return "{$this->numYellowCards} : {$this->numRedCards}";
		//{$this->numFouls['FoulSum']} : {$this->numTechFouls['TechFoulSum']} : 
	} //[RETURNS] STRING
	public function times_disabled(){
		return $this->numDisabled;
	} // [RETURNS] INT
	public function all_comments(){
		$comments = (string)" ";
		while($row = mysqli_fetch_assoc($this->commentsSearch)){
			foreach ($row as $key => $value){
				$comments .= "{$value}; ";
			}
		}
		return $comments;
	} //[RETURNS] all comments



						///////////////////////////////////
						////                           //// 
						////          OPR STATS        ////
						////                           ////
						///////////////////////////////////



	public function portcullis_score(){
		$score = $this->portcullisTotal['sumPortcullis'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT
	public function cheval_de_frise_score(){
 		$score = $this->total['sumCheval'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT
	public function moat_score(){
		$score = $this->moatTotal['sumMoat'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT
	public function ramparts_score(){
		$score = $this->rampartsTotal['sumRamparts'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT
	public function drawbridge_score(){
		$score = $this->drawbridgeTotal['sumDrawbridge'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT
	public function sally_port_score(){
		$score = $this->sallyPortTotal['sumSallyPort'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT
	public function rockwall_score(){
		$score = $this->rockWallTotal['sumRockWall'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT
	public function rough_terrain_score(){
		$score = $this->roughTerrainTotal['sumRoughTerrain'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT
	public function low_bar_score(){
		$score = $this->lowBarTotal['sumLowBar'];
 		$score = $score / $this->numberOfMatches;
		return $score;
	} // [RETURNS] FLOAT

	public function challenge_and_scale_score(){
		$numChallenge = mysqli_num_rows($this->towerChallengeSearch);
		$numScale = mysqli_num_rows($this->towerScaleSearch);
		$score = (($numChallenge + $numScale) / $this->numberOfMatches);
		$score = round($score, 3, PHP_ROUND_HALF_UP);
		return $score;
	} // [RETURNS] FLOATs

	public function avg_high_goal_score(){
		$highGoalHits = $this->hgha['HighGoalHits'];
		$highGoalMisses = $this->hgma['HighGoalMisses'];
		$totalHighGoalShots = ($highGoalHits+$highGoalMisses);
		if($totalHighGoalShots > 0){
			$totalScore = ($highGoalHits / $this->numberOfMatches);
			$totalScore = round($totalScore, 3, PHP_ROUND_HALF_UP);
			return $totalScore;
		} else {
			return 0;
		}
	} // [RETURNS] FLOAT

	public function high_goal_score(){
		$highGoalHits = $this->hgha['HighGoalHits'];
		$highGoalMisses = $this->hgma['HighGoalMisses'];
		$totalHighGoalShots = ($highGoalHits+$highGoalMisses);
		$multiplier = 1.0;
		if($totalHighGoalShots > 0){
			$highGoalAccuracy = (($highGoalHits/$totalHighGoalShots)*100); 
			$highGoalAccuracy = round($highGoalAccuracy, 3, PHP_ROUND_HALF_UP);
			if($highGoalAccuracy > .75)
				$multiplier = 1.15; 
			elseif($highGoalAccuracy > .5 && $highGoalAccuracy <= .75)
				$multiplier = 1.0;
			elseif($highGoalAccuracy >.25 && $highGoalAccuracy <= .5)
				$multiplier = 0.9;
			else 
				$multiplier = 0.8;
			$totalScore = (($highGoalHits * 5) * $multiplier);
			$totalScore = ($totalScore / $this->numberOfMatches);
			return $totalScore;
		} else {
			return 0;
		}
	} // [RETURNS] FLOAT

	public function high_goal_accuracy_num(){
		$highGoalHits = $this->hgha['HighGoalHits'];
		$highGoalMisses = $this->hgma['HighGoalMisses'];
		$totalHighGoalShots = ($highGoalHits+$highGoalMisses);
		if($totalHighGoalShots > 0){
			$totalScore = ($highGoalHits/$totalHighGoalShots); 
			$totalScore = round($totalScore, 3, PHP_ROUND_HALF_UP);
			return $totalScore;
		} else {
			return 0;
		}
		
	}

	public function challenge_precentage(){
		$numChallenge = mysqli_num_rows($this->towerChallengeSearch);
		$score = ($numChallenge / $this->numberOfMatches);
		$score = round($score, 3, PHP_ROUND_HALF_UP);
		return $score;
	}

	public function low_goal_score(){
		$lowGoalHits = $this->lgha['LowGoalHits'];
		$lowGoalMisses = $this->lgma['LowGoalMisses'];
		$totalLowGoalShots = ($lowGoalHits+$lowGoalMisses);
		$multiplier = 1.0;                          // MULTIPLIER IS SUBJECT TO CHANGE / GET RID OF
		if($totalLowGoalShots > 0){
			$lowGoalAccuracy = (($lowGoalHits/$totalLowGoalShots)*100);
			$lowGoalAccuracy = round($lowGoalAccuracy, 1, PHP_ROUND_HALF_UP); 
			if($lowGoalAccuracy > .75)
				$multiplier = 1.15; 
			elseif($lowGoalAccuracy > .5 && $lowGoalAccuracy <= .75)
				$multiplier = 1.0;
			elseif($lowGoalAccuracy >.25 && $lowGoalAccuracy <= .5)
				$multiplier = 0.9;
			else 
				$multiplier = 0.8;
			$totalScore = (($lowGoalHits * 2) * $multiplier);
			$totalScore = ($totalScore / $this->numberOfMatches);
			return $totalScore;
		} else {
			return 0;
		}
	} // [RETURNS] FLOAT

	public function avg_low_goal_score(){
		$lowGoalHits = $this->lgha['LowGoalHits'];
		$lowGoalMisses = $this->lgma['LowGoalMisses'];
		$totalLowGoalShots = ($lowGoalHits+$lowGoalMisses);
		if($totalLowGoalShots > 0){ 
			$totalScore = ($lowGoalHits / $this->numberOfMatches);
			$totalScore = round($totalScore, 3, PHP_ROUND_HALF_UP);
			return $totalScore;
		} else {
			return 0;
		}
	} // [RETURNS] FLOAT

	public function low_goal_accuracy_num(){
		$lowGoalHits = $this->lgha['LowGoalHits'];
		$lowGoalMisses = $this->lgma['LowGoalMisses'];
		$totalLowGoalShots = ($lowGoalHits+$lowGoalMisses);
		if($totalLowGoalShots > 0){
			$lowGoalAccuracy = ($lowGoalHits/$totalLowGoalShots);
			$lowGoalAccuracy = round($lowGoalAccuracy,3, PHP_ROUND_HALF_UP);
			return $lowGoalAccuracy;
		} else {
			return 0;
		}
	}

	public function scale_score(){
		$numScale = mysqli_num_rows($this->towerScaleSearch);
		if($numScale > 0){
			return $numScale / $this->numberOfMatches;
		} else {
			return 0;
		}
	} //[RETURNS] FLOAT

	public function auto_score(){
		$cumulativeScore = 0;
		if(mysqli_num_rows($this->autoBreachedSearch) > 0){
			$cumulativeScore += (mysqli_num_rows($this->autoBreachedSearch) * 10);
			$totalAutoLowGoalShots = ($this->autoLowGoalsMade['LGAutoMade'] + $this->lowGoalAutoMisses['LGAutoMisses']);
			$totalAutoHighGoalShots = ($this->autoHighGoalsMade['HGAutoMade'] + $this->highGoalAutoMisses['HGAutoMisses']);

			if($totalAutoLowGoalShots > 0){
				$lowGoalsMade = $this->autoLowGoalsMade['LGAutoMade'];
				if($this->MLGAS['LGAutoMax'] > 1){
					$cumulativeScore += (($lowGoalsMade * 5) * 1.15);
				} else {
					$cumulativeScore += ($lowGoalsMade * 5);
				}
			}
			if($totalAutoHighGoalShots > 0){
				$highGoalsMade = $this->autoHighGoalsMade['HGAutoMade'];
				if($this->MHGAS['HGAutoMax'] > 1){
					$cumulativeScore += (($highGoalsMade * 10) * 1.15);
				} else {
					$cumulativeScore += ($highGoalsMade * 10);
				}
			}  
		}
		if(mysqli_num_rows($this->autoReachedSearch) > 0) {
			$cumulativeScore += (mysqli_num_rows($this->autoReachedSearch) * 2);
		} 
		$cumulativeScore = $cumulativeScore / $this->numberOfMatches;
		$cumulativeScore = round($cumulativeScore, 3, PHP_ROUND_HALF_UP);
		return $cumulativeScore;
	} //[RETURNS] FLOAT

	public function foul_score(){
		$foulpts = ($this->numFouls['FoulSum'] * 5) / $this->numberOfMatches;
		return $foulpts;
	}//[RETURNS] INT
	
	public function tech_foul_score(){
		$foulpts = ($this->numTechFouls['TechFoulSum'] * 15) / $this->numberOfMatches;
		return $foulpts;
	}//[RETURNS] INT

	public function card_score(){
		$foulpts = $this->numRedCards + $this->numYellowCards;
		return $foulpts;
	}//[RETURNS] INT

	public function breach_sum(){
		$score = 0;
		$score = ($this->portcullis_score() + $this->cheval_de_frise_score() + $this->moat_score() + $this->ramparts_score() + 
			$this->drawbridge_score() + $this->sally_port_score() + $this->rockwall_score() + $this->rough_terrain_score() + 
			$this->low_bar_score());
		$score = round($score, 3, PHP_ROUND_HALF_UP);
		return $score;
	}// [RETURNS] FLOAT

	public function score_sum(){
		$score = 0;
		$score = (($this->breach_sum() * 5) + $this->high_goal_score() + $this->low_goal_score() + 
			($this->scale_score() * 15) + 
			$this->auto_score() - $this->foul_score() - $this->tech_foul_score());
		$score = round($score, 3, PHP_ROUND_HALF_UP);
		return $score;
	}// [RETURNS] FLOAT





};
// Close connection to the database
//mysqli_close($dbc);
// mysqli_num_rows()
//mysqli_fetch_lengths() Returns an array if integer that represents the size of each field (column)
// mysqli_fetch_array will return a row of data from the query until no further data is available

//todo:

?>
