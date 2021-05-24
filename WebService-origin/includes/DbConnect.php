<?php


    class DbConnect {

      private $conn;

      function connect() {

        include_once dirname(__FILE__)  . '/Constants.php';

        $this->conn=new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        mysqli_set_charset($this->conn,"utf8");

        if(mysqli_connect_errno()){
          echo "Échec de la connexion :" . mysqli_connect_errno();
          return null;
        }
        /*if (!mysqli_set_charset($this->conn, "utf8")) {
            printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", mysqli_error($this->conn));
          } else {
            printf("Jeu de caractères courant : %s\n", mysqli_character_set_name($this->conn));
        }*/
        return $this->conn;


      }



    }
