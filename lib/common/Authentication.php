<?php


/**
 * Primárnou úlohou triedy Authentication je kontrolovať identitu užívateľa. Za týmto účelom obsahuje metódy check_session_admin() určená pre administrátorský režim a metódu check_session_user() určenú pre užívateľský režim. Hodnoty premenných priradené pri prihlásení sú uložené v superglobálnom poli $_SESSION. Metódy kontrolujú: 
 * Či je ten, kto posiela požiadavku na server prihlásený
 * Či ten, kto poslal požiadavku na server je skutočne ten, za koho sa vydáva
 * Či sa kontrolný token v URL adrese rovná kontrolnému tokenu priradenému pri prihlasovaní užívateľovi posielajúcemu požiadavku na server.

 * Kontrolný token je 32 znakový reťazec, ktorý sa pri prihlásení užívateľa vygeneruje náhodným spôsobom. Zväčša je to hash náhodného reťazca. Uloží sa do session a je vkladaný sa do každej URL adresy, ktorá odkazuje na stránku v autorizovanej zóne aplikácie. V praxi to znamená, že medzi GET parametrami, ktoré sú poslané na server s požiadavkou sa nachádza i reťazec kontrolného tokenu a metóda, ktorá kontroluje identitu užívateľa môže jednoducho skontrolovať či sa rovná tej, ktorá je uložená v session. Ak bude tento parameter chýbať alebo sa reťazce nebudú rovnať, tak aplikácia vyhodnotí takúto požiadavku ako neoprávnený vstup a presmeruje užívateľa na prihlasovací formulár. 
 *	Ďalšie dôležitá metóda tejto triedy je metóda log_in(), ktorá kontroluje prihlasovacie údaje, ktoré sú odoslané pri prihlasovaní užívateľa. Taktiež nastavuje hodnoty v poli $_SESSION. Naproti tomu metóda log_out() odhlasuje užívateľa. To znamená, že vymaže hodnoty zo superglobálneho poľa $_SESSION.
 *	Trieda Authentication rieši tiež problematiku prístupov do aplikácie. Obsahuje metódu, ktorá po úspešnom prihlásení ukladá údaje do tabuľky Login_report.  
 * 
 * @author       juraj
 */



class Authentication extends Core
{

	/**
	 * @var      string
	 */
	private $sid;

	/**
	 * @var      string
	 */
	private $token;

	/**
	 * @return   void
	 */
	public function __construct()
	{
		//parent::__construct();
		$this->init();
	}

	/**
	 * Inicializacia triedy
	 * 
	 * @return   void
	 */
	private function init()
	{
		session_start();
		$this->sid = session_id();
		$this->token = $_SESSION['token'];

	}

	/**
	 * Kontroluje zadane heslo s ulozenym heslom v db
	 * 
	 * @param array pole so vstupnymi parametrami prichodzimi z formulara
	 * @return   boolean
	 */
	public function checkPass(array $input)
	{
		$inputQuery = array(
                    'pk' => array(
                            'login' => $input['login'],
                    ),
		);
		$data = $this->getDb('Users')->getItem($inputQuery);
                
		if ($data['pass'] === md5($input['pass'])){

			return true;
		}
		else {

			return false;
		}
	}
	
	/**
	 * Kontroluje ci uz dany login existuje alebo nie
	 * 
	 * @param $input
	 * @return int pocet zaznamov s konkretnym loginom
	 */

	private function check_login(array $input)
	{
		$login = $this->db->prepare_item($input['login']);
		
		$result = array(
				'table' =>"users",
				'columns' => "all",
				'filter' => array(
					array("login", "=", $input['login']),
					array("is_active", "=", 0),
				),
		);
		$data = $this->db->get_count_items($result);
		
		return $data;
	}

	/**
	 * Zabezpecuje prihlasenie uzivatela
	 * 
	 * @return   void
	 */

	public function logIn(array $input)
	{
		
		if ($this->checkPass($input)){
                    $inputQuery = array(
                        
                        'pk' => array(
                                'login' => $input['login'],
                        ),
                        'result' => "object",
                    );

                    $data = $this->getDb('Users')->getItem($inputQuery);

                    $_SESSION['id'] = (int) $data->id;
                    $_SESSION['username'] = $data ->login;
                    $_SESSION['meno'] = $data->meno . " " . $data->priezvisko;

                    return array(
                            'result' => true,
                    );
		}
		else
		{
                    throw new Exception("Nespravne prihlasovacia meno alebo heslo");
		}

	}

	/**
	 * Po uspesnom prihlaseni nejakeho uzivatela, ulozi zaznam do tabulky login_report
	 * 
	 * @return void
	 */
	private function insert_report_log()
	{
		//http://www.hawkee.com/snippet/1358/
		$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

		$input = array(
			'table' =>"login_report",
			'data' => array(
					'user_id' => mysql_real_escape_string($_SESSION['id_user']),
					'time' => mysql_real_escape_string(time()),
					'ip' => mysql_real_escape_string($ip),	
			),
		);
		$this->db->add_item($input);
		/*
		 $query = sprintf("INSERT INTO login_report(user_id, time, ip) VALUES(%s, '%s', '%s')",
		 mysql_real_escape_string($_SESSION['id_user']),
		 mysql_real_escape_string(time()),
		 mysql_real_escape_string($ip)
		 );
		 $this->db->insert_item($query);*/
	}

	/**
	 * Odhlasi uzivatela - zrusi session
	 * 
	 * @return   void
	 */
	public function logOut()
	{
		if(isset($_SESSION['username'])){
			unset($_SESSION["username"]);
			session_destroy();
			session_regenerate_id();
		}
			
		if(isset($_SESSION['username'])){
			echo 'SESSION existuje.';
		}
		//var_dump("ahjoj");
		unset($_SESSION['id']);
		unset($_SESSION['username']);

                return true;

	}

	/**
	 * Kontroluje integritu administratorskeho rezimu
	 * 
	 * @param string token, ktory pride z URL adresy
	 * @return   boolean
	 */
	public function check_session_admin($token)
	{
		if ((strlen($_SESSION["username"]) == 0) || ($_SESSION["role"] != 0) || ($token != $_SESSION['token'])) {
			
			//var_dump($_SESSION);
			$_SESSION['role'] = 0;
			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * Kontroluje integritu uzivatelskeho rezimu
	 * 
	 * @param string token, ktory pride z URL adresy
	 * @return   boolean
	 */
	public function check_session_user($token)
	{
		//var_dump($token);
		if ((strlen($_SESSION["username"]) == 0) || ($_SESSION["role"] != 1) || ($this->token != $token)) {
			return false;
		}
		else {
			return true;
		}
	}
	
	/**
	 * Meni heslo uzivatela
	 * 
	 * @param $input
	 * @return array so spravou o uspechu/neuspechu operacie
	 */

	public function change_pass(array $input)
	{
		$message = "";
		$old = $input['old'];
		$new = $input['new'];
		$new2 = $input['new2'];

		$input = array(
				'table' =>"users",
				'pk' => $input['user_id'],
		);
		$data = $this->db->get_item($input);

		$old_pass = $data->password;
		if (strlen($old) == 0)
		{
			return array(
				'result' => false,
				'message' => "<span style=\"color:red\">Nevyplnili ste povinn&uacute; položku - star&eacute; heslo</span>",
			);
		}
		if (strlen($new) == 0)
		{
			return array(
				'result' => false,
				'message' => "<span style=\"color:red\">Nevyplnili ste povinn&uacute; položku - nov&eacute; heslo</span>",
			);
		}
		if (strlen($new2) == 0)
		{
			return array(
				'result' => false,
				'message' => "<span style=\"color:red\">Nepotvrdili ste nov&eacute; heslo</span>",
			);
		}

		if (md5($old) != $old_pass)
		{
			return array(
				'result' => false,
				'message' => "<span style=\"color:red\">Nezadali ste spr&aacute;vne s&uacute;časn&eacute; heslo</span>",
			);
		}
		else
		{
			if ($new == $new2)
			{
				$hash = md5($new);
				$input = array(
					'table' =>"users",
					'change' => array(
						'password' => $hash,	
					),
					'filter' => array(
						array(
							"id", "=", (int) $_SESSION['id_user'] 
						),
					),
				);
				var_dump($this->db->update_items($input));
				if ($this->db->update_items($input))
				{
					return array(
					'result' => true,
					'message' => "<span style=\"color:green\">Heslo bolo zmenen&eacute;</span>",
					);
				}

			}
			else
			{
				return array(
					'result' => false,
					'message' => "<span style=\"color:red\">Hesl&aacute; sa nezhoduj&uacute;</span>",
				);
			}
		}
	}
}

?>
