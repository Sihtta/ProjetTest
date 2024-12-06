<?php
require_once 'produit.class.php';

class ProduitByFacture {
    
    private $numFact;
    private $produit;
    private $qteProd;

    public function __construct(int $numFact = 0, Produit $produit = null, int $qteProd = 0) {
        $this->numFact = $numFact;
        $this->produit = $produit;
        $this->qteProd = $qteProd;
    }

    public function getNumFact(): int {
        return $this->numFact;
    }

    public function getProduit(): Produit {
        return $this->produit;
    }

    public function getQteProd(): int {
        return $this->qteProd;
    }

    public function setNumFact(int $numFact): void {
        $this->numFact = $numFact;
    }

    public function setProduit(Produit $produit): void {
        $this->produit = $produit;
    }

    public function setQteProd(int $qteProd): void {
        $this->qteProd = $qteProd;
    }
}
?>