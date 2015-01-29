<?php


    /**
     * Reprezentuje užívateľa aplikácie. Trieda je potomkom triedy Person, od ktorej dedí základné
     * informácie spoločné pre oboch aktérov aplikácie. Navyše obsahuje privátne premenné, ktoré súvisia
     * s oprávneniami užívateľa.
     *
     * @author       juraj
     */
    class BlCommonAuth extends BlCommon {

            /**
             * @return   void
             */
            public function __construct()
            {
                parent::__construct();
            }

            /*
             * Pridanie usera
             *
             * TODO
             */
            public function addUser(array $input){

                $auth = new Authentication();
                $message = "";
                $bool = true;

                $data = array(
                    'meno' => $input['meno'],
                    'priezvisko' => $input['priezvisko'],
                    'login' => $input['login'],
                    'datum_pridania' => time(),
                );
                
                //checking udajov
                if ($input['pass'] == $input['pass2']){
                    $data['pass'] = md5($input['pass']);
                }
                else {
                    $message .= "Vlozene hesla sa nezhoduju<br/>";
                    $bool = false;
                }

                // Kontrola vstupnych udajov
                if (isset($input['mail']) && (preg_match("/^[a-zA-Z_\-.0-9]+@[a-zA+-Z_\-.0-9]+\.[a-zA-Z]{2,4}$/", $input['mail']))){
                    $data['mail'] = $input['mail'];
                }
                else {
                    $message .= "Mail ma nespravny format<br/>";
                    $bool = false;
                }

                if (isset($input['pohlavie'])){
                    $data['pohlavie'] = $input['pohlavie'];
                }
                if (isset($input['adresa'])){
                    $data['adresa'] = $input['adresa'];
                }


                if ($bool){
                    $this->getDb('Users')->insertItem(array(
                        'data'=> $data,
                    ));
                    $message = "Boli ste uspesne zaregistrovany";
                
                }

                return array(
                    'result' => true,
                    'data' => array(
                        'message' => $message, 
                    ),
                );
            }

            /*
             * Pridanie usera
             *
             * TODO
             */
            public function login(array $input){

                $auth = new Authentication();
                $message = "";
                $bool = true;

                try {
                    if ($auth->logIn($input)){
                        
                        Header("Location: index.php?mode=user&module=user&action=index");exit;
                    }
                }
                catch (Exception $e){
                    $message = $e->getMessage();
                    
                }
                
                return array(
                    'result' => true,
                    'data' => array(
                        'message' => $message,
                    ),
                );
            }

            /*
             * Pridanie usera
             *
             * TODO
             */
            public function updateUser(array $input){

                $this->getDb('Users')->updateItem(array(
                    'table' => "Users",
                    'data'=> $input,
                    'filter' => array(
                        'id' => array(
                            'id', '=', $input['id']
                        ),
                    ),
                ));

                return array(
                    'result' => true,
                    'data' => array(),
                );
            }

            public function getListUser(){
                $result = $this->getDb('files')->getList(array(
                    'sort' => array(
                        "id", "asc",
                    ),
                    'expand' => array(
                        'table' => 'files_info',
                    ),
                    'result' => 'array',
                ));

                Core::debug($result);
                
                return array(
                    'result' => 1,
                    'data' => $result,
                );
            }
            
            /*
             * Vrati informacie o jednom uzivatelovi
             *
             * @param   array   $input = array(
             *                      'table' => {tabulka}
             *                      'pk' => {primarny kluc}
             *                      'result' => {format vysledku array|object}
             *                  );
             */

            public function getUser(array $input){
                
                $result = $this->getDb('Users')->getItem(array(
                    'pk' => $input['id'],
                    'result' => 'array',
                ));


                Core::debug($result);
                return array(
                    'result' => 1,
                    'data' => $result,
                );
            }

            

            
    }

?>