<?php
class ForfaitLivraison {
    
    private $idForfait;
    private $libForfait;
    private $mtForfait;

    public function __construct(
        string $idForfait = '',
        string $libForfait = '',
        float $mtForfait = 0.0
    ) {
        $this->idForfait = $idForfait;
        $this->libForfait = $libForfait;
        $this->mtForfait = $mtForfait;
    }

    public function getIdForfait(): string {
        return $this->idForfait;
    }

    public function getLibForfait(): string {
        return $this->libForfait;
    }

    public function getMtForfait(): float {
        return $this->mtForfait;
    }

    public function setIdForfait(string $idForfait): void {
        $this->idForfait = $idForfait;
    }

    public function setLibForfait(string $libForfait): void {
        $this->libForfait = $libForfait;
    }

    public function setMtForfait(float $mtForfait): void {
        $this->mtForfait = $mtForfait;
    }
}
?>