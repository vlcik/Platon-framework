<?php

/**
 * Trieda MySQL_driver implementuje funkcie potrebné na komunikáciu aplikácie s databázovým
 * systémom MySQL.
 * 
 * @author       juraj
 */

class MySQL_driver extends Driver {


	/**
	 * @var      int
	 */
	private $link;

	/**
	 * @var      int
	 */
	private $type;

	/**
	 * @var      string
	 */
	private $host;

	/**
	 * @var      string
	 */
	private $user;

	/**
	 * @var      string
	 */
	private $pass;

        /*
         * @var string  nazov asociovanej tabulky s instanciou db
         */
        private $table;

        /*
         * @var object  config db
         */
        private $cfg;

//----------------------------------------------------------------------------//
//----------------------------- IMPLEMENTATION -------------------------------//
//----------------------------------------------------------------------------//

	/**
	 * @return   void
	 */
	public function __construct($cfg, $table){
                parent::__construct();
		$this->init($cfg, $table);
	}

	/**
	 * Metoda inicializuje konfiguracne nastavenia databazy
	 * 
	 * @param $input
	 * @return void
	 */
	private function init($cfg, $table){
            
            $this->host = $cfg->dbConfig['host'];
            $this->user = $cfg->dbConfig['user'];
            $this->pass = $cfg->dbConfig['pass'];
            $this->db = $cfg->dbConfig['db'];
            $this->table = $table;

            $this->paging = $cfg->paging;
            $this->cfg = $cfg;

            $this->openConnection();
            mysql_query("SET NAMES 'utf8'");
            mysql_query("SET CHARACTER SET utf8");
	}

	/**
	 * Otvori spojenie s databazou
	 *
	 * @return void
	 *
	 */

	private function openConnection()
	{
            if (!($this->link = mysql_connect($this->host, $this->user, $this->pass))){
                throw new DatabaseExceptions(302);
            }

            $db_selected = mysql_select_db($this->db, $this->link);
            if (!$db_selected) {
                    throw new DatabaseExceptions(303);
            }

	}

	/**
	 * @param array of input parameters
	 *
	 * $input = array(
	 * 		'table' => {tabulka z ktorej sa udaje vyberaju}
	 * 		'columns' => {moze byt konkretny, to bude pole stlpcov, inak ak vsetky => string "all"}
	 * 		'filter' => {podmienky vyberu}
	 * 		'sort' => {pole podmienok utriedenia}
	 * 		'limit' => {limit najdenych zaznamov}
	 * 		'sql_functions' => {pole so specialnymi funkciami sql napr. sum() alebo avg()}
         *              'result' => {indikuje v akom formate chceme vysledky - ci ich chceme ako pole alebo object}
         *              'expand' => {nazov tabulky o ktoru sa tabulka expandne - pomocou joinu}
	 * );
	 *
	 * @return array of records
	 */

	public function getList(array $input){
		$from = $this->table;

                if (isset($input['columns'])){
                    if (is_array($input['columns']))
                    {
                            $columns = "";
                            foreach($input['columns'] as $column)
                            {
                                    $columns .= $column . ",";
                            }
                            $columns = substr($columns, 0, strlen($columns) - 1);
                    }
                    elseif(($input['columns'] == "all") && (is_string($input['columns'])))
                    {
                            $columns = "*";
                    }
                }
                else {
                    $columns = "*";
                }

		//ak su zadane sql funkcie, tak sa pridaju do dotazu
		if(isset($input['sql_functions']))
		{
			
			$sql_functions = "";
			foreach ($input['sql_functions'] as $sf)
			{
				$key = array_keys($sf);
				$value = array_values($sf);
				$sql_functions .= $key[0] . "(" . $value[0] . ") as $key[0], ";
			} 
			if (strlen($columns) > 0)
			{
				$sql_functions = substr($sql_functions, 0, strlen($sql_functions) - 1);
			}
			else
			{
				$sql_functions = substr($sql_functions, 0, strlen($sql_functions) - 2);	
			}
			
			$query = "SELECT " . $sql_functions . " " . $columns . " FROM " . $from;
		}
		else
		{
			$query = "SELECT " . $columns . " FROM " . $from;	
		}

                //--------------- EXPAND --------------------------------------//

                if (isset($input['expand']) && (count($input['expand']) > 0))
		{
                    $query .=  $this->expandTables($input['expand']);
		}
		
		//-------------- FILTROVANIE ---------------------------------//
			
		if (isset($input['filter']) && (count($input['filter']) > 0))
		{
                    $query .=  " WHERE " . $this->filtering($input['filter']);
		}

                //--------------- SORTING ----------------------------------------------//

		if (isset($input['sort']))
		{
			$query .= $this->sorting($input['sort']);
		}
                else {
                    $query .= $this->sorting(array());
                }

                //--------------- LIMIT -------------------------------------------------//


                if (isset($this->params['page']) && (strlen($this->params['page']) > 0)){
                    $array = array(
                        'actualPage' => $this->params['page'],
                    );
                }
                else {
                    $array = array(
                        'actualPage' => 1,
                    );
                }
                $paging = $this->paging($array);
                $from = $paging['from'];
                $to = $paging['to'];
                
                $limit = " LIMIT " . $from . "," . $to;
                $query .= $limit;
		
		
		
		//var_dump($query);
                $array = array(
                    'query' => $query,
                );
                if (isset($input['result'])){
                    $array['result'] = $input['result'];
                }
		
                $data = $this->fetchingData($array);
		
		return array(
                    'paging' => $paging,
                    'data' => $data,
                    
                );
	}

	/**
	 * Pridavanie poloziek do db
	 * 
	 * @param array of input parameters
	 *
    	 * $input = array(
	 * 		'{nazov stlpca v tabulke}' => {vkladana hodnota}
	 * );
	 *
	 * @return array of records
	 */

	public function insertItem(array $input)
	{
		$from = $this->table;

		try
		{
			$query .= "INSERT INTO " . $from;

			$columns = "(";
			$values = "(";

			$a_keys = array_keys($input['data']);
			$a_values = array_values($input['data']);

			for($i = 0; $i < count($a_keys); $i++)
			{
				if (is_string($a_values[$i]))
				{
					$a_values[$i] = "'" . $a_values[$i] . "'";
				}
				$values .= $a_values[$i] . ", ";
				$columns .= $a_keys[$i]  . ", ";
			}

			$columns = substr($columns, 0, strlen($columns) - 2) . ")";
			$values = substr($values, 0, strlen($values) - 2) . ")";
			$query .= $columns ." VALUES" . $values;
			//var_dump($query);
			/*
			 foreach($input['columns'] as $column)
			 {
				$columns .= $column . ",";
				}
				$columns = substr($columns, 0, strlen($columns) - 1) . ")";
				$query .= " " . $columns . " VALUES";

				$values = "(";

				foreach($input['values'] as $value)
				{
				if (is_string($value))
				$value = "'" . $value . "'";
				$values .= $value . ",";
				}
				$values = substr($values, 0, strlen($values) - 1) . ")";
				$query .= " " . $values;*/
		}
		catch (Exception $e)
		{
			echo "Problem" . $e->getMessage() . " " . $e->getTrace();
		}

		$array = array(
                    'query' => $query,
                );
                if (isset($input['result'])){
                    $array['result'] = $input['result'];
                }

                $data = $this->runQuery($array);
	}

	/**
	 * Mazanie poloziek z databazy
	 * 
	 * @param array of input parameters
	 *
	 * $input = array(
	 * 		'filter' => {pole podmienok vyberu}
	 *	);
	 *
	 * @return boolean
	 */

	public function deleteItem(array $input)
	{
		$query = "DELETE FROM " . $this->table;

		$filters = "";
		if (isset($input['filter']) && (count($input['filter']) > 0))
		{
                    $query .=  " WHERE " . $this->filtering($input['filter']);
		}
		//var_dump($query);
		$array = array(
                    'query' => $query,
                );
                if (isset($input['result'])){
                    $array['result'] = $input['result'];
                }

                $data = $this->fetchingData($array);

		//
	}

	/**
	 * Aktualizovanie poloziek v db podla poziadaviek uzivatela
	 * 
	 * @param array of input parameters
	 *
	 * $input = array(
	 * 		'data' => {asociativne pole : kluc - stlpec, hodnota - nova hodnota stlca }
	 * 		'filter' => {pole podmienok vyberu}
	 *	);
	 *
	 * @return array of records
	 */

	public function updateItem(array $input)
	{
               
                $pk = $this->getPrimaryKey();
		$query = "UPDATE " . $this->table;

		$keys = array_keys($input['data']);
		$values = array_values($input['data']);

		for($i = 0; $i < count($keys); $i++)
		{
			if (is_string($values[$i]))
			{
				$values[$i] = "'" . $values[$i] . "'";
			}
			$change .= $keys[$i] . " = " . $values[$i] . ", ";
		}

		$change = substr($change, 0, strlen($change) - 2);
		$query .= " SET " . $change;

		if (isset($input['filter']) && (count($input['filter']) > 0))
		{
                    $query .=  " WHERE " . $this->filtering($input['filter']);
		}

                $array = array(
                    'query' => $query,
                );
             
                $data = $this->runQuery($array);

		return array(
                    'paging' => $paging,
                    'data' => $data,

                );

		
	}

	/**
	 * Vrati riadok z databazy s primarnym klucom zadanym v parametri
	 *
	 * @param array $input of input parameters
	 *
	 * - pole ak stlpec primarneho kluca v tabulke ma nazov implicitne id
	 * $input = array(
	 * 		'table' => {tabulka},
	 * 		'pk' => {primarny kluc hladaneho prvku}
	 * );
	 *
	 * - pole ak stlpec primarneho kluca v tabulke nema nazov implicitne id
	 * - nazov je zadany ako kluc pola
	 * $input = array(
	 * 		'table' => {tabulka},
	 * 		'pk' => array(
	 * 			'column_pk' => 'pk',
	 * 		),
	 * );
	 *
	 * @return array of record
	 */

	public function getItem(array $input){
            
		if (is_array($input['pk'])){
			$key = array_keys($input['pk']);
			$value = array_values($input['pk']);

			if (is_string($value[0]))
			{
				$pk = "'" . $value[0] . "'";
			}
			else
			{
				$pk = $value[0];
			}

			$query = "SELECT * FROM " . $this->table . " WHERE " . $key[0] . " = " . $pk;
		}
		else{
			if (is_string($input['pk']))
			{
				$pk = "'" . $input['pk'] . "'";
			}
			else
			{
				$pk = $input['pk'];
			}

			$query = "SELECT * FROM " . $this->table . " WHERE id = " . $pk;
		}
                
		$array = array(
                    'query' => $query,
                );
                if (isset($input['result'])){
                    $array['result'] = $input['result'];
                }

                $data = $this->fetchingData($array);
	
		return $data[0];
	}
	
        /**
	 * Count of records from database
	 *
	 * @param $input = array(
	 * 		
	 * 		'columns' => {moze byt konkretny, to bude pole stlpcov, inak ak vsetky => string "all"}
	 * 		'filter' => {podmienky vyberu}
	 * 		'limit' => {limit najdenych zaznamov}
	 * );
	 *
	 * @return array of records
	 */

	public function getCountItems(array $input)
	{
		$from = $this->table;
		$query = "";	
		if (is_array($input['columns']))
		{
			$columns = "";
			foreach($input['columns'] as $column)
			{
				$columns .= $column . ",";
			}
			$columns = substr($columns, 0, strlen($columns) - 1);
		}
		else
		{
			$columns = "*";
		}
			
		$query = "SELECT " . $columns . " FROM " . $from;
			
			
		if (isset($input['filter']) && (count($input['filter']) > 0))
		{
                    $query .=  " WHERE " . $this->filtering($input['filter']);
		}

		if (isset($input['limit']))
		{
			$limit = " LIMIT " . $input['limit'][0] . "," . $input['limit'][1];
			$query .= $limit;
		}
		//var_dump($query);
		try
		{
			$result = mysql_query($query);
			
			if(!($result))
			{
                            throw new DatabaseExceptions(array(
                                'num' =>304,
                                'message' => "Query: \"$query\" failed. " . mysql_errno($this->link) . ": " . mysql_error($this->link),
                            ));
			}
			$num_rows = mysql_num_rows($result);
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		mysql_free_result($result);
		return $num_rows;
	}

        /**
	 * priamy dotaz - DB abstraction
	 *
	 * @param array $input = array(
         *                  'sql' => {sql dotaz},
         *                  'result'=> {format vysledku array|object}
         *              );
         *
         *
	 * @return   $data result
	 */
	public function directQuery(array $input)
	{
            //TODO
            $result = mysql_query($input['sql'], $this->link);

            if (!($result)){
                throw new DatabaseExceptions(array(
                    'num' =>304,
                    'message' => "Query: \"$sql\" failed. " . mysql_errno($this->link) . ": " . mysql_error($this->link),
                ));
            }
            else {
                if ($input['result'] == "array"){
                    while($row = mysql_fetch_assoc($result)){
                            $data[] = $row;
                    }
                 }
                elseif ($input['result'] == "object") {
                    while($row = mysql_fetch_object($result))
                    {
                            $data[] = $row;
                    }
                }
            }

            return $data;
	}

        /*
         * Metoda vrati v poli nazvy stlpcov nad ktorymi je cudzi kluc
         *
         * @param
         * @return  array   pole s nazvami stlpcov
         */
        public function getForeignKeys(){
            
        }

        /*
         * Metoda spoji tabulky na zaklade vstupnych parametrov
         *
         * @param
         * @return  array|object   pole s nazvami stlpcov
         */
        public function expandTables(array $input){

            $expand = "";

            if (!(isset($this->cfg->foreignKeys[$this->table])) || !(isset($this->cfg->foreignKeys[$this->table]['target']))){
                throw new DatabaseExceptions(array(
                    'num' => 306,
                ));
            }

            if (isset($input['how']) && (strlen($input['how']) > 0)){
                $expand .= $input['how'];
            }
            else {
                $expand .= " LEFT JOIN ";
            }

            if (isset($input['table']) && (strlen($input['table']) > 0)){
                $expand .= $input['table'] . " ON ";
            }
            else {
                throw new Exceptions(array(
                    'num' => 305,
                ));
            }

            $on = $this->table . "." . $this->cfg->foreignKeys[$this->table]['columns']['source'] . " = " .
                  $this->cfg->foreignKeys[$this->table]['target'] . "." . $this->cfg->foreignKeys[$this->table]['columns']['target'] . " ";
            return $expand . $on;
        }

        private function filtering(array $input){
            $filter = "";
            foreach($input as $fil)
            {
                    if (is_string($fil[2]))
                    $fil[2] = "'" . $fil[2] . "'";
                    $filter .= $fil[0] . " " . $fil[1] . " " . $fil[2] . " AND ";
            }
            $filter = substr($filter, 0, strlen($filter) - 5);
            return $filter;
        }

        /*
         * Metoda pripravi sorting cast sql dotazu
         *
         * @return  string
         */
        private function sorting(array $input){
            $sort = "";
            if (isset($this->params['sort']) && (strlen($this->params['sort']) > 0)){
                $sorting = explode("^", $this->params['sort']);
                $sort = " ORDER BY " . $sorting[0] . " " . $sorting['1'];
            }
            else {
                if (count($input) > 0){
                    $sort = " ORDER BY " . $input[0] . " " . $input['1'];
                }
            }
            return $sort;
        }

        /*
         * Metoda, ktora spusti query
         *
         * @param   array
         * @result  MySQL object
         *
         */
        private function runQuery(array $input){

            $result = mysql_query($input['query'], $this->link);

            if (!($result)){
                throw new DatabaseExceptions(array(
                    'num' =>304,
                    'message' => "Query: \"$sql\" failed. " . mysql_errno($this->link) . ": " . mysql_error($this->link),
                ));
            }

            return $result;
        }

        /*
         * Metoda fetchne data bud do pola alebo do objektu
         *
         */
        private function fetchingData(array $input){

            $result = $this->runQuery($input);
            
            if (isset($input['result'])){
                if ($input['result'] == "array"){
                    while($row = mysql_fetch_assoc($result)){
                            $data[] = $row;
                        }
                     }
                elseif ($input['result'] == "object") {
                    while($row = mysql_fetch_object($result))
                    {
                            $data[] = $row;
                    }
                }
            }
            else {
                while($row = mysql_fetch_assoc($result)){
                    $data[] = $row;
                }
             }
        
            mysql_free_result($result);
            return $data;
        }

        

        /**
	 * Metoda prepocita strankovanie a vrati spravne cisla od ktoreho zaznamu chceme udaje a pocet udajov
	 *
	 * @param $input
	 * @return array pole vystupnych cisel pripravenych na pouzitie v sql dotaze
	 */
	private function paging(array $input)
	{
            
            $actualPage = $input['actualPage'];
            $allRecords = $this->getCountItems(array());

            $recordsPerPage = $this->paging['recordsPerPage'];
            
            $pages = $allRecords / $recordsPerPage;

            if (($count - ($_pages * $this->records_per_page)) > 0){
                    $_pages++;
            }
            
            $_pages = ceil($_pages);
            for ($i = 0; $i < $_pages; $i++){
                    $page['cislo'] = $i + 1;
                    $pages[] = $page;

            }

            if ($actualPage > 1){
                $prev = $actualPage - 1;
            }

            if ($actualPage < $pages){
                $next = $actualPage + 1;
            }

            $from = ($actualPage - 1) * $recordsPerPage;
            $to = (($actualPage - 1) * $recordsPerPage) + $recordsPerPage;



            return array(
                'page' => $actualPage,
                'prev' => $prev,
                'next' => $next,
                'from' => $from,
                'to' => $to,
                'perPage' => $recordsPerPage,
            );
	}


//---------------------- INFO METHODS ----------------------------------------//

        /**
	 * Returns metadata for all columns in a table.
	 * 
	 * @return array
	 */
	public function getColumns()
	{
		
            $result = $this->fetchingData(array(
                'query' => "SHOW FULL COLUMNS FROM `$this->table`"
            ));

            return $result;
	}



	/**
	 * Returns metadata for all indexes in a table.
	 * @param  string
	 * @return array
	 */
	public function getIndexes()
	{
            $result = $this->fetchingData(array(
                'query' => "SHOW INDEX FROM `$this->table`"
            ));

            return $result;
	}

        /**
	 * Returns metadata for primary key in table
	 * @param  string
	 * @return array
	 */
	public function getPrimaryKey()
	{
            $indexes = $this->getIndexes();

            foreach ($indexes as $index){
                if ($index['Key_name'] == "PRIMARY"){
                    return $index;
                }
            }

            		
	}

        /**
	 * Returns list of tables.
	 * @return array
	 */
	public function getTables()
	{
            $result = $this->fetchingData(array(
                'query' => "SHOW FULL TABLES"
            ));

            return $result;
	}
}
?>