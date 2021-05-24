<?php
 /**
  *
  */
 class DbOperations{

    private $con;

   function __construct(){

     require_once dirname(__FILE__) . '/DbConnect.php';

     $db= new DbConnect;
     $this->con=$db->connect();

   }
   public function CreateCard($Size,$Paper_Type,$Folding,$Sides_Printed, $Quantity,$Price){




            $stmt= $this->con->prepare("INSERT INTO cards (Size, Paper_Type, Folding, Sides_Printed, Quantity,Price)
            VALUES ('$Size','$Paper_Type', '$Folding', '$Sides_Printed', '$Quantity' ,'$Price')");

              if($stmt->execute()){
                    return CARD_CREATED;
              }else {
                    return CARD_FAILURE;
              }

      return MEDICAMENT_EXISTS;

  }


    public function getAllCards(){

      $stmt = $this->con->prepare("SELECT Size, Paper_Type, Folding, Sides_Printed, Quantity , Price FROM cards ORDER BY Paper_Type DESC;");
      $stmt->execute();
            $stmt->bind_result($Size,$Paper_Type,$Folding,$Sides_Printed, $Quantity,$Price);
            $cards=array();
            while ($stmt->fetch()) {
              $card=array();
              $card['Size']=$Size;
              $card['Paper_Type']=$Paper_Type;
              $card['Folding']=$Folding;
              $card['Sides_Printed']=$Sides_Printed;
              $card['Quantity']=$Quantity;
              $card['Price']=$Price;


              array_push($cards, $card);

      }
      return $cards;

    }




}
