<?php

/**
 * Trieda PageContent je súčasťou prezentačnej vrstvy. Jej úlohou je zhromažďovať dáta, ktoré sa
graficky vykreslia pomocou triedy MojeSmarty, ktorá je potomkom triedy externého
śablónovacieho systému Smarty. Dáta, ktoré zhromažďuje môžeme rozdeliť na dve skupiny:
       Statické dáta – sú tie, ktoré sa nemenia a sú prítomné v grafickej šablóne v nezmenenej
    •
       podobe počas celej doby, čo je prihlásený aktuálny užívateľ. Napríklad dátum, meno
       prihláseného užívateľa alebo kontrolný token.
       Dynamické dáta – sú tie, ktoré zväčša prichádzajú z aplikačnej vrstvy a boli vygenerované
    •
       niektorým z modulov. Napríklad dáta z databázy alebo výpočty.
Dáta sa zhromažďujú pomocou metódy Assigning() a Assigning_more_than_one(). Ak je potrebné
stránkovanie na stránke, je možné zavolať metódu Paging(), ktorá dáta nastránkuje, vypočíta počet
stránok a nastaví príslušné hodnoty premenných next a previous.

 * 
 * @author       juraj
 */

class PageContent extends Core
{


	/**
	 * @var      int
	 */
	private $act_user;

	/**
	 * @var      array
	 */

	private $menu_item;

	/**
	 * @var      string
	 */
	private $date;

	/**
	 * @var      int
	 */
	private $records_per_page;

	/**
	 * @var object
	 */
	private $smarty;

	/**
	 * @var name of system
	 */
	private $_name;

	public function __construct()
	{
		
		$this->init();
	}

	private function init()
	{
		try{
                    $this->smarty = new MojeSmarty();

                    $this->cfg = new Config();

                    $this->_name = $this->cfg->system_name;
                    $this->records_per_page = $this->cfg->records_per_page;

                    if (isset($_SESSION['username']))
                    $this->act_user = $_SESSION['username'];
                    $this->date = getdate();
		}
		catch (Exception $e){
			echo $e;
		}
	}

	/**
	 * @return   string
	 */
	public function get_act_user()
	{
		$this->assigning(array(
       		'var' => 'username',
       		'val' => $_SESSION['username'],
		));
	}

	/**
	 * @return   string
	 */
	public function get_act_date()
	{
		$date = $this->date['mday'] . ". " .
		$this->date['mon'] . ". " . $this->date['year'];
		$this->assigning(array(
     		'var' => 'date',
     		'val' => $date, 
		));
	}

	/**
	 * Inicializuje token
	 * 
	 * @return   array
	 */

	public function get_token(){
		$this->assigning(array(
    		'var' => 'token',
    		'val' => $_SESSION['token'],
		));
	}

	/**
	 * Metoda prepocita strankovanie a vrati spravne cisla od ktoreho zaznamu chceme udaje a pocet udajov
	 * 
	 * @param $input
	 * @return array pole vystupnych cisel pripravenych na pouzitie v sql dotaze
	 */
	public function paging(array $input)
	{
		$act_page = $input['act_page'];
		$count = $input['count'];
		if (isset($input['per_page']))
		{
			$this->records_per_page = $input['per_page'];
		}
		$_pages = $count / $this->records_per_page;
		if (($count - ($_pages * $this->records_per_page)) > 0){
			$_pages++;
		}
		$_pages = ceil($_pages);
		for ($i = 0; $i < $_pages; $i++){
			$page['cislo'] = $i + 1;
			$pages[] = $page;

		}

		$this->assigning(array(
			'var' => 'pages',
			'val' => $pages,
		));

		$this->assigning(array(
			'var' => 'act_page',
			'val' => $act_page,
		));

		if ($act_page != $_pages){
			$this->assigning(array(
				'var' => 'next_page',
				'val' => ($act_page + 1),
			));
		}
		if ($act_page != 1){
			$this->assigning(array(
				'var' => 'prev_page',
				'val' => ($act_page - 1),
			));
		}

		$from = ($act_page - 1) * $this->records_per_page;
		$to = (($act_page - 1) * $this->records_per_page) + $this->records_per_page;
		return array(
			'from' => $from,
			'to' => $to,
			'per_page' => $this->records_per_page,
		);
	}

	/**
	 * Inicializuje Smarty premennu
	 * 
	 * @param $input - pole 
	 * @return void
	 */
	public function _assigning(array $input)
	{
        if (count($input) == 1){
            $var = array_keys($input);
            $val = array_values($input);
            $this->smarty->assign($var[0], $val[0]);
        }
        else {
            throw new PageContentExceptions(101);
        }
		
	}
	
	/**
	 * Podobne ako u assigning len tato metoda dostane pole hodnot a inicializuje 
	 * Smarty premenne hromadne
	 * @param $input
	 * @return void
	 * @see assigning	
	 */

	public function assigning(array $input)
	{
                $var = array_keys($input);
                
		$val = array_values($input);
		for($i = 0; $i < count($input); $i++)
		{
			$this->smarty->assign($var[$i],$val[$i]);
		}
	}

       /**
	* Zobrazenie sablony s nastavenymi statickymi hodnotami a inicializovanymi dynamickymi hodnotami
	*
	* @param $tpl cesta k sablone
	* @return void
	*/
        public function display($tpl)
	{
            //Core::debug(root . InstanceHandler::getInstance('Config')->templateRoot . substr($tpl, 1, strlen($tpl) - 1));
            if (!(file_exists(root . InstanceHandler::getInstance('Config')->templateRoot . substr($tpl, 1, strlen($tpl) - 1)))){
                throw new PageContentExceptions(array(
                    'num' => 203,
                    'message' => "Template: $tpl doesn't exist",
                ));
            }
            else {
                
                $this->smarty->display($tpl);
            }
        }

	
}

?>