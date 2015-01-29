<?php


    /**
     * Reprezentuje užívateľa aplikácie. Trieda je potomkom triedy Person, od ktorej dedí základné
     * informácie spoločné pre oboch aktérov aplikácie. Navyše obsahuje privátne premenné, ktoré súvisia
     * s oprávneniami užívateľa.
     *
     * @author       juraj
     */
    class BlUserUser extends BlUser {

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
            public function checkSession(){
                
                if (!(isset($_SESSION['id'])) || (strlen($_SESSION['id']) == 0) || (strlen($_SESSION['username']) == 0)){
                       
                    Header("Location: index.php?mode=common&module=auth&action=index");
                    return false;
                }
                else {
                    return true;
                }
            }

            /*
             * Pridanie usera
             *
             * TODO
             */
            public function logout(){

                $auth = new Authentication();
                
                try {
                    if ($auth->logOut()){
                        Header("Location: index.php?mode=common&module=auth&action=index");
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
            public function editUser(array $input){

                $this->getDb('Users')->updateItem(array(
                    'data'=> $input,
                    'filter' => array(
                        'id' => array(
                            'id', '=', $input['id']
                        ),
                    ),
                ));

                Header("Location: index.php?mode=user&module=user&action=editForm");

                return array(
                    'result' => true,
                    'data' => array(
                        'message' => "Editacia bola uspesna",
                    ),
                );
            }

            /*
             * Priprava formularu
             *
             * TODO
             */
            public function editForm(array $input){

                //Vyberie sa z databazy aktualne prihlaseny uzivatel
                $result = $this->getDb('Users')->getItem(array(
                    'pk' => array(
                        'id' => $input['id'],
                    ),
                ));

                return array(
                    'result' => true,
                    'data' => $result,
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