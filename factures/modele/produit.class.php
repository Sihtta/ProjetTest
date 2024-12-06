<?php
class Produit {
    
    private $codeProd;
    private $libProd;
    private $type;
    private $origine;
    private $conditionnement;
    private $tarifHt;

    public function __construct(
        string $codeProd = '',
        string $libProd = '',
        string $type = '',
        string $origine = '',
        string $conditionnement = '',
        float $tarifHt = 0.0
    ) {
        $this->codeProd = $codeProd;
        $this->libProd = $libProd;
        $this->type = $type;
        $this->origine = $origine;
        $this->conditionnement = $conditionnement;
        $this->tarifHt = $tarifHt;
    }

    public function getCodeProd(): string {
        return $this->codeProd;
    }

    public function getLibProd(): string {
        return $this->libProd;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getOrigine(): string {
        return $this->origine;
    }

    public function getConditionnement(): string {
        return $this->conditionnement;
    }

    public function getTarifHt(): float {
        return $this->tarifHt;
    }

    public function setCodeProd(string $codeProd): void {
        $this->codeProd = $codeProd;
    }

    public function setLibProd(string $libProd): void {
        $this->libProd = $libProd;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function setOrigine(string $origine): void {
        $this->origine = $origine;
    }

    public function setConditionnement(string $conditionnement): void {
        $this->conditionnement = $conditionnement;
    }

    public function setTarifHt(float $tarifHt): void {
        $this->tarifHt = $tarifHt;
    }
}
?>