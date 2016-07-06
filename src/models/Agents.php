<?php
	include_once 'src/models/Masterfile.php';
	/**
	* 
	*/
	class Agents extends Masterfile
	{
		
		function addAfyapoaAgent($ro, $champion, $attached_superchampion, $agent_code, $customer_id)
		{
			// var_dump($customer_id);exit;
			$date_created = date("Y-m-d");
        	$register_afyapoa_agent="INSERT INTO ".DATABASE.".afyapoa_agent
            (customer_id,status,agent_code, date_created,ro_customer_id, champ_customer_id, super_champ_customer_id)
            VALUES ('".$customer_id."','1','".$agent_code."','".$date_created."','".$ro."', '".$champion."', 
            	'".$attached_superchampion."') "
                . "RETURNING afyapoa_agent_id";

	        // var_dump($register_afyapoa_agent);exit; 
	       	if(run_query($register_afyapoa_agent)){
	       		return true;
	       	}else{
	       		return pg_last_error();
	       	}
		}

		public function getAgentCode($afyapoa_role, $customer_id){
			if($afyapoa_role == 1)
		        return "AA".$customer_id;
		    elseif($afyapoa_role == 2)                        
		        return "AR".$customer_id;
		    elseif($afyapoa_role == 3)
		        return "AC".$customer_id;
		    elseif($afyapoa_role == 4)
		        return "ASC".$customer_id;
		}

		public function addNdovuAgents($customer_id){
			// var_dump('ndovu agents: '.$customer_id);exit;
			$register_kashpoa_agentfile = "INSERT INTO ".DATABASE.".ndovu_agents
            (customer_id,agent_balance, lower_limit,upper_limit,commission_rate)
            VALUES ('".$customer_id."',0,0,0,0) "
                . "RETURNING agent_id";
        	return $result = run_query($register_kashpoa_agentfile);
		}
	}
?>