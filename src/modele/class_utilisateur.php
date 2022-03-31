<?php
class Utilisateur{

 private $db;
 private $insert;
 private $connect;
 private $selectById;

 public function __construct(PDO $db){
 $this->db = $db;
 $this->insert = $this->db->prepare("insert into utilisateur (nom, prenom, email, mdp, idRole, dateInscription) value(:nom, :prenom, :email, :mdp, :role, :dateInscription)");
 $this->connect = $this->db->prepare("select id, email, mdp from utilisateur where email=:email");
 $this->selectById  = $this->db->prepare("select id, Nom, Prenom, Mail, Date_de_naissance  from  utilisateur where id=:id");
 }

 public function insert($nom, $prenom, $email, $mdp, $role, $dateInscription)
 {
     $r = true;
     $this->insert->execute(array(':nom' => $nom,':prenom' => $prenom,':email' => $email,':mdp' => $mdp, ':role' => $role, ':dateInscription' => $dateInscription));
     if ($this->insert->errorCode() != 0) {
         print_r($this->insert->errorInfo());
         $r = false;
     }
     return $r;
 }
    public function connect($email)
    {
        $unutilisateur = $this->connect->execute(array(':email' => $email));
        if ($this->connect->errorCode() != 0) {
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }

    public function selectById($id){
        $this->selectById->execute(array(':id'=>$id));
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo());  
        }
        return $this->selectById->fetch();
    }
}
?>