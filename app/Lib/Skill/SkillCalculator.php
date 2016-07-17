<?php

namespace App\Lib\Skill;

use App\Models\Work\Catalogs\Skill;

class SkillCalculator
{
    /** @var SkillArtifact[] */
    private $artifacts;
    /** @var  int[] */
    private $artifactSums;

    /** @var int */
    private $startSumma;
    /** @var int */
    private $resultSumma;

    public function __construct($startSumma)
    {
        $this->startSumma = $startSumma;
        $this->resultSumma = 0;

        $this->artifacts = [];
        $this->artifactSums = [];
    }

    public function addArtifact(SkillArtifact $artifact)
    {
        $this->artifacts[] = $artifact;
    }

    public function resultSumma()
    {
        if ($this->resultSumma > 0) {
            $this->resultSumma;
        }

        foreach ($this->artifacts as $artifact) {
            $this->artifactSums[] = $this->startSumma / 100 * $artifact->getBonusPercent();
        }

        $resultBonus = array_reduce($this->artifactSums, function ($accSum, $itemSum) {
            return $accSum + $itemSum;
        });

        $this->resultSumma = $this->startSumma - $resultBonus;
        
        return $this->resultSumma;
    }
}
