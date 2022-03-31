<?php
function connexionControleur($twig, $db){
        $form= array();
        if(isset($_POST['btConnecter'])){
            $inputEmail = $_POST['inputEmail'];
            $inputPassword = $_POST['inputPassword'];
            $utilisateur = new Utilisateur($db);
            $unutilisateur = $utilisateur->connect($inputEmail);
            if ($unutilisateur!=null){
                if(!password_verify($inputPassword,$unutilisateur['mdp'])){
                    $form['valide'] = false;
                    $form['message'] = 'Login ou mot de passe incorrect';
                }else {
                    $_SESSION['login'] = $inputEmail;
                    $_SESSION['role'] = $unutilisateur['idRole'];
                    $_SESSION['id'] = $unutilisateur['id'];
                    header("Location:?page=accueil");
                }
            } else {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            }
        }
        echo $twig->render('compte/connexion.html.twig', array('form'=>$form,'session'=>$_SESSION));
    }

    function deconnexionControleur($twig, $db){
        session_unset();
        session_destroy();
        header("Location:index.php");
    }    

    function inscriptionControleur($twig, $db)
{
    $form = array();
    if (isset($_POST['btInscrire'])) {
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $inputPassword2 = $_POST['inputPassword2'];
        $nom = $_POST['inputNom'];
        $prenom = $_POST['inputPrenom'];
        $dateInscription = date('Y-m-d');
        $form['valide'] = true;
        if ($inputPassword != $inputPassword2) {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        } else {
            $utilisateur = new Utilisateur($db);
            $exec = $utilisateur->insert($nom, $prenom, $inputEmail, password_hash($inputPassword, PASSWORD_DEFAULT),2, $dateInscription);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
            }
        }
        $form['nom'] = $nom;
    }
    echo $twig->render('compte/inscription.html.twig', array('form' => $form));
}
?>