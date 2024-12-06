<?php
class Facture {
    
    private $num_fact;
    private $date_fact;
    private $comment_fact;
    private $taux_remise_fact;
    private $id_cli;
    private $id_forfait;

    public function __construct(
        int $num_fact = 0,
        string $date_fact = '',
        string $comment_fact = '',
        float $taux_remise_fact = 0.0,
        int $id_cli = 0,
        string $id_forfait = ''
    ) {
        $this->num_fact = $num_fact;
        $this->date_fact = $date_fact;
        $this->comment_fact = $comment_fact;
        $this->taux_remise_fact = $taux_remise_fact;
        $this->id_cli = $id_cli;
        $this->id_forfait = $id_forfait;
    }

    public function getNumFact(): int {
        return $this->num_fact;
    }

    public function getDateFact(): string {
        return $this->date_fact;
    }

    public function getCommentFact(): string {
        return $this->comment_fact;
    }

    public function getTauxRemiseFact(): float {
        return $this->taux_remise_fact;
    }

    public function getIdCli(): int {
        return $this->id_cli;
    }

    public function getIdForfait(): string {
        return $this->id_forfait;
    }

    public function setNumFact(int $num_fact): void {
        $this->num_fact = $num_fact;
    }

    public function setDateFact(string $date_fact): void {
        $this->date_fact = $date_fact;
    }

    public function setCommentFact(string $comment_fact): void {
        $this->comment_fact = $comment_fact;
    }

    public function setTauxRemiseFact(float $taux_remise_fact): void {
        $this->taux_remise_fact = $taux_remise_fact;
    }

    public function setIdCli(int $id_cli): void {
        $this->id_cli = $id_cli;
    }

    public function setIdForfait(string $id_forfait): void {
        $this->id_forfait = $id_forfait;
    }
}
?>
