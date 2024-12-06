<?php
class Client {
    
    private $id_cli;
    private $civ_cli;
    private $nom_cli;
    private $prenom_cli;
    private $tel_cli;
    private $mel_cli;
    private $adr_cli;
    private $cp_cli;
    private $commune_cli;
    private $tauxmax_remise_cli;
    private $mot_de_passe;

    // Constructeur    
    function __construct(
        int $id_cli = 0,
        string $civ_cli = '',
        string $nom_cli = '',
        string $prenom_cli = '',
        string $tel_cli = '',
        string $mel_cli = '',
        string $adr_cli = '',
        string $cp_cli = '',
        string $commune_cli = '',
        float $tauxmax_remise_cli = 0.0,
        string $mot_de_passe = ''
    ) {
        $this->id_cli = $id_cli;
        $this->civ_cli = $civ_cli;
        $this->nom_cli = $nom_cli;
        $this->prenom_cli = $prenom_cli;
        $this->tel_cli = $tel_cli;
        $this->mel_cli = $mel_cli;
        $this->adr_cli = $adr_cli;
        $this->cp_cli = $cp_cli;
        $this->commune_cli = $commune_cli;
        $this->tauxmax_remise_cli = $tauxmax_remise_cli;
        $this->mot_de_passe = $mot_de_passe;
    }

    // Getters
    function getIdCli(): int {
        return $this->id_cli;
    }

    function getCivCli(): string {
        return $this->civ_cli;
    }

    function getNomCli(): string {
        return $this->nom_cli;
    }

    function getPrenomCli(): string {
        return $this->prenom_cli;
    }

    function getTelCli(): string {
        return $this->tel_cli;
    }

    function getMelCli(): string {
        return $this->mel_cli;
    }

    function getAdrCli(): string {
        return $this->adr_cli;
    }

    function getCpCli(): string {
        return $this->cp_cli;
    }

    function getCommuneCli(): string {
        return $this->commune_cli;
    }

    function getTauxmaxRemiseCli(): float {
        return $this->tauxmax_remise_cli;
    }

    function getMotDePasse(): string {
        return $this->mot_de_passe;
    }

    // Setters
    function setIdCli(int $id_cli): void {
        $this->id_cli = $id_cli;
    }

    function setCivCli(string $civ_cli): void {
        $this->civ_cli = $civ_cli;
    }

    function setNomCli(string $nom_cli): void {
        $this->nom_cli = $nom_cli;
    }

    function setPrenomCli(string $prenom_cli): void {
        $this->prenom_cli = $prenom_cli;
    }

    function setTelCli(string $tel_cli): void {
        $this->tel_cli = $tel_cli;
    }

    function setMelCli(string $mel_cli): void {
        $this->mel_cli = $mel_cli;
    }

    function setAdrCli(string $adr_cli): void {
        $this->adr_cli = $adr_cli;
    }

    function setCpCli(string $cp_cli): void {
        $this->cp_cli = $cp_cli;
    }

    function setCommuneCli(string $commune_cli): void {
        $this->commune_cli = $commune_cli;
    }

    function setTauxmaxRemiseCli(float $tauxmax_remise_cli): void {
        $this->tauxmax_remise_cli = $tauxmax_remise_cli;
    }

    function setMotDePasse(string $mot_de_passe): void {
        $this->mot_de_passe = $mot_de_passe;
    }
}
?>