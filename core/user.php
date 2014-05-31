<?php
	include 'database.php';
	class users extends database{

		function __construct(){
			parent::__construct();  
		}
		/*
    	*   Function creates an entry of all the data in the file being passed as parameter
    	*/
		function entry($file_name){
			$file = fopen($file_name,"r");
				$feilds = fgetcsv($file);
				
				$feild = array_filter($feilds);
				$feild = '`'.implode('`, `', $feild).'`';  //parsing the feilds according to need

				while(! feof($file)){
					
					$temp = fgetcsv($file);
					
					if($temp !=''){
						$data = array_values(array_filter($temp));
						if($this->insert("users",$data,$feild))  //inserting into database(refer to insert function in database.php)
							$flag = true;
						else
							$flag = false;
					} 

				}
			return $flag;
		}	
				
		function fetch(){
			$this->select('users');
			return $this->parse($this->getResult());
		}

		/*
    	*  	Parsing the database values and creating a table to display
    	*/	
		function parse($data){
			$resultHead = "<table class='table'>";

			$resultEntry=
				"<tr class='row head'>".
					"<td class='entry'>ID</td>".
					"<td class='entry'>Name</td>".
					"<td class='entry'>Email</td>".
					"<td class='entry'>Title</td>".
					"<td class='entry'>Subject</td>".
					"<td class='entry'>Age</td>".
					"<td class='entry'>Gender</td>".
					"<td class='entry'>Company</td>".
				"</tr>";

			$resultFoot = "</table>";

			$temp = "";
			if(empty($data)===false){
				foreach($data as $row){
					$temp .="<tr class='row'>";
					foreach($row as $entry)
						$temp .= "<td class='entry'>".$entry."</td>";
					$temp .="</tr>";
				}
			}

			return $resultHead.$resultEntry.$temp.$resultFoot;
		}
	}

?>