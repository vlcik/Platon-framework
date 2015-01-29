<?php

/**
 * Zámer vytvoriť jednoduchú databázovú abstrakciu, ktorá by umožňovala prácu s dátovou vrstvou
 * nezávisle od aplikačnej a jednoduché implementovanie nových DBMS(DataBase Management
 * System), si vyžaduje vytvoriť samostatné triedy, ktorých základnou úlohou je komunikovať s
 * databázou. Trieda Database však nekomunikuje s databázou priamo. Jej úlohou je rozhodovať na
 * základe konfiguračných nastavení, ktorý driver si zavolá na vykonanie príslušnej operácie. Pod
 * pojmom „driver“ môžeme rozumieť triedu, v ktorej sú implementované funkcie na prácu s
 * konkrétnou databázou.
 * Z toho vyplýva, že pre použitie hocakého databázového systému v aplikácii, je potrebné
 * naprogramovať príslušný databázový driver implementujúci funkcie na prácu s týmto systémom.
 * Ľahkou rozšíriteľnosťou o ďalší databázový systém sa dosiahne okrem iného i väčšia univerzálnosť
 * aplikácie.

 * 
 * @author  Juraj Vlk juajvk@gmail.com
 */

class Database {
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

	/**
	 * @var      object
	 */
	private $cfg;

	/**
	 * @var      object
	 */
	private $db;

	/**
	 * @return   void
	 */
	public function __construct(array $input)
	{
		$this->init($input);

	}

	/**
	 * Inicializacia premennych,
         * Nacitanie spravneho driveru, pri rozsireni o dalsi je potrebny zasah do kodu
	 *
         * @param   array $input    pole so vstupnymi parametrami
	 * @return   void
	 */
	private function init(array $input)
	{
            //init global configuration
            $cfg = new DbConfig();

            $this->type = $cfg->dbConfig['type'];
           
            if ($this->type == "mysql"){
                    $this->db = new MySQL_driver($cfg, $input['table']);
            }
            elseif ($this->type == "pgsql"){
                    $this->db = new PostgreSQL_driver($cfg->db_config, $input[ 'table' ]);
            }

	}

	public function prepare_item($item){
		return mysql_real_escape_string($item, $this->link);
	}

        /**
	 * Vlozenie zaznamu - DB ABSTRACTION
	 * 
	 * @param array
	 * @return   void
	 */
	public function updateItem(array $input)
	{
		return $this->db->updateItem($input);
	}

	/**
	 * Vratenie zaznamu - DB ABSTRACTION
	 * 
	 * @param array 
	 * @return   void
	 */
	public function getItem(array $input)
	{
		return $this->db->getItem($input);
	}

	/**
	 * Vratenie poctu zaznamov z db - DB ABSTRACTION
	 * 
	 * @param array pole vstupnych parametrov
	 * @return   int
	 */
	public function getCountItems(array $input){
		return $this->db->getCountItems($input);
	}

	/**
	 * Vrati pole zaznamov - DB ABSTRACTION
	 * 
	 * @param $input
	 * @return array records
	 */
	public function getList(array $input){
		return $this->db->getList($input);
	}

	/**
	 * Ulozi zaznam - DB ABSTRACTION
	 * 
	 * @param $input
	 * @return boolean
	 */
	public function insertItem(array $input){
		return $this->db->insertItem($input);
	}

	/**
	 * Ulozi zaznam - DB ABSTRACTION
	 * 
	 * @param $input
	 * @return boolean
	 */
	public function deleteItem(array $input)
	{
		return $this->db->deleteItem($input);
	}

        /**
	 * Joining tabuliek
	 *
	 * @param $input
	 * @return boolean
	 */
	public function joinTables(array $input)
	{
            $input['config'] = $this->cfg;
            return $this->db->joinTables($input);
	}
}



?>