<?php
session_start();
include '../modele/connexion.php';

function obtenirProchainIdCli($connexion)
{
    $query = "SELECT COUNT(id_cli) AS total_clients FROM client";
    $result = $connexion->execSQL($query);
    return $result[0]['total_clients'] + 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connexion = new Connexion();

    $login = $_POST['login'];
    $civ_cli = $_POST['civ_cli'];
    $nom_cli = $_POST['nom_cli'];
    $prenom_cli = $_POST['prenom_cli'];
    $tel_cli = $_POST['tel_cli'];
    $mel_cli = $_POST['mel_cli'];
    $adr_cli = $_POST['adr_cli'];
    $cp_cli = $_POST['cp_cli'];
    $commune_cli = $_POST['commune_cli'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $query = "SELECT * FROM client WHERE mel_cli = :mel_cli OR tel_cli = :tel_cli OR login = :login";
    $existingClient = $connexion->execSQL($query, ['mel_cli' => $mel_cli, 'tel_cli' => $tel_cli, 'login' => $login]);

    if (!empty($existingClient)) {
        if ($existingClient[0]['login'] == $login) {
            header("Location: ./inscription.php?error=login_taken");
        } elseif ($existingClient[0]['mel_cli'] == $mel_cli) {
            header("Location: ./inscription.php?error=email_taken");
        } elseif ($existingClient[0]['tel_cli'] == $tel_cli) {
            header("Location: ./inscription.php?error=phone_taken");
        }
        exit();
    }

    $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $id_cli = obtenirProchainIdCli($connexion);

    $query = "INSERT INTO client (id_cli, login, civ_cli, nom_cli, prenom_cli, tel_cli, mel_cli, adr_cli, cp_cli, commune_cli, tauxmax_remise_cli, mot_de_passe) 
    VALUES (:id_cli, :login, :civ_cli, :nom_cli, :prenom_cli, :tel_cli, :mel_cli, :adr_cli, :cp_cli, :commune_cli, :tauxmax_remise_cli, :mot_de_passe)";
    $connexion->execSQL($query, [
        'id_cli' => $id_cli,
        'login' => $login,
        'civ_cli' => $civ_cli,
        'nom_cli' => $nom_cli,
        'prenom_cli' => $prenom_cli,
        'tel_cli' => $tel_cli,
        'mel_cli' => $mel_cli,
        'adr_cli' => $adr_cli,
        'cp_cli' => $cp_cli,
        'commune_cli' => $commune_cli,
        'tauxmax_remise_cli' => 10,
        'mot_de_passe' => $hashed_password
    ]);

    header("Location: ../vue/login.view.php?success=1");
    exit();
} else {
    $connexion = new Connexion();
    $prochain_id_cli = obtenirProchainIdCli($connexion);
    $_SESSION['prochain_id_cli'] = $prochain_id_cli;
}

include '../vue/inscription.view.php';
