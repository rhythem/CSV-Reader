<?php
	class database{

		private $db_host;				// Database Host
	    private $db_user;				// Username
	    private $db_pass;				// Password
	    private $db_name;				// Database
	    private $con;				// Checks to see if the connection is active
	    private $result;				// Results that are returned from the query

		public function __construct() {
		
			$this->db_host	='localhost';
			$this->db_user	='root';
			$this->db_pass	='';
			
			$this->db_name	='froiden';
			$this->con		=false;
			$this->result	=array();
			$this->connect();
		}

		public function connect() {
	        if(!$this->con)
	        {
	            $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
	            if($myconn)
	            {
	                $seldb = @mysql_select_db($this->db_name,$myconn);
	                if($seldb)
	                {
	                    $this->con = true;
	                    return true;
	                }
	                else
	                    return false;
	            }
	            else
	                return false;
	        }
	        else
	            return true;
	    }
	    /*
	    * Changes the new database, sets all current results
	    * to null
	    */
	    public function setDatabase($name) {
	        if($this->con)
	        {
	            if(@mysql_close())
	            {
	                $this->con = false;
	                $this->results = null;
	                $this->db_name = $name;
	                $this->connect();
	            }
	        }

	    }

	    /*
	    * Checks to see if the table exists when performing
	    * queries
	    */
	    private function tableExists($table) {
	        $tablesInDb = mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
	         
	        if($tablesInDb)
	        {
	            if(mysql_num_rows($tablesInDb)==1)
	                return true;
	            else{
	                return false;

	            }
	        }
	    }
		/*
	    * Insert values into the table
	    * Required: table (the name of the table)
	    *           values (the values to be inserted)
	    * Optional: rows (if values don't match the number of rows)
	    */
	    public function insert($table,$values,$rows = null) {
			
			if($this->tableExists($table))
	        {
	            $insert = 'INSERT INTO '.$table;
	            if($rows != null)
	            {
	                $insert .= ' ('.$rows.')';
	            }

	            for($i = 0; $i < count($values); $i++)
	            {
	                if(is_string($values[$i]))
	                    $values[$i] = '"'.$values[$i].'"';
	            }
	            $values = implode(',',$values);
	            $insert .= ' VALUES ('.$values.')';
	           
	            $ins = @mysql_query($insert);
	            
	            if($ins)
	                return true;
	            else
	                return false;
	        }
	    }
	/*
    * Selects information from the database.
    * Required: table (the name of the table)
    * Optional: rows (the columns requested, separated by commas)
    *           where (column = value as a string)
    *           order (column DIRECTION as a string)
    */
    public function select($table, $rows = '*', $where = null, $order = null, $limit = "")
    {
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;

        if($limit != "")
            $q .= ' LIMIT '.$limit;
        $query = @mysql_query($q);
        
        if($query)
        {
            $this->numResults = mysql_num_rows($query);
            for($i = 0; $i < $this->numResults; $i++)
            {
                $r = mysql_fetch_array($query);
                $key = array_keys($r);
                for($x = 0; $x < count($key); $x++)
                {
                    // Sanitizes keys so only alphavalues are allowed
                    if(!is_int($key[$x]))
                    {
                        if(mysql_num_rows($query) > 1)
                            $this->result[$i][$key[$x]] = $r[$key[$x]];
                        else if(mysql_num_rows($query) < 1)
                            $this->result = null;
                        else
                            $this->result[$key[$x]] = $r[$key[$x]];
                    }
                }
            }
            return true;
        }
        else
        {
            return false;
        }
    }
    /*
    * Returns the result set
    */
    public function getResult()
    {
		$temp = $this->result;
		$this->result='';
        return $temp;
		
    }

	}

?>