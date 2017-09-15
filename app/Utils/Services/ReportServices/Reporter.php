<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 9/15/17
 * Time: 5:47 PM
 */

namespace App\Utils\Services\ReportServices;

use App\Models\Option;

abstract class Reporter
{
    private $stats;
    private $progress;
    private $progressCount;
    private $report;
    private $personalityType;

    protected $user;
    protected $match;
    protected $options;

    public function __construct($user, $match = null)
    {
        $this->report = [];
        $this->progress = 0;
        $this->progressCount = 0;
        $this->user = $user;
        $this->match = $match;
    }

    /**
     * @param $category
     * @return integer
     */
    private function getQuestionNumbers($category)
    {
        return Option::where($category, '!=', null)->count() / 2;
    }

    private function initialStats()
    {
        $this->stats = [
            "mind" => ["introvert" => 0, "extrovert" => 0],
            "energy" => ["observant" => 0, "intuitive" => 0],
            "nature" => ["thinking" => 0, "feeling" => 0],
            "tactics" => ["judging" => 0, "prospecting" => 0],
            "identity" => ["assertive" => 0, "turbulent" => 0],
        ];
    }

    private function addOptionStats($option)
    {
        foreach ($this->stats as $key => $value)
            if (isset($option->{$key}))
                $this->stats[$key][array_search($option->{$key}, Option::$personalityTypes[$key])]++;
    }

    private function calcStats()
    {
        $this->initialStats();
        foreach ($this->options as $option)
            $this->addOptionStats($option);
    }

    private function generateReport()
    {
        foreach ($this->stats as $key => $types){
            $totalCategoryQuestions = $this->getQuestionNumbers($key);

            $categoryCount = 0;
            $categoryProgress = 0;
            foreach ($types as $type => $count) {
                $this->report[$type] = number_format(($count / $totalCategoryQuestions) * 100);
                $categoryProgress += $this->report[$type];
                $categoryCount += $count;
            }

            $this->updateProgress($categoryCount, $categoryProgress);
        }
    }

    public function updateProgress($categoryCount, $categoryProgress)
    {
        if ($this->progressCount + $categoryCount != 0)
            $this->progress  = (($this->progress * $this->progressCount) + ($categoryProgress * $categoryCount))
                / ($this->progressCount + $categoryCount);
    }

    public function setPersonalityType()
    {
        $this->personalityType = "";
        $shortTypes = [["I", "E"], ["S", "N"], ["T", "F"], ["J", "P"], ["A", "T"]];
        $counter = 0;
        foreach ($this->stats as $key => $types){
            $i = [];
            foreach ($types as $type => $count)
                $i[] = $count;
            if ($i[0] == $i[1])
                $this->personalityType .= "?";
            elseif ($i[0] > $i[1])
                $this->personalityType .= $shortTypes[$counter][0];
            else
                $this->personalityType .= $shortTypes[$counter][1];
            $counter ++;
        }
    }

    public function formatReport()
    {
        return [
            "data" => [
                "progress" => number_format($this->progress),
                "detail" => $this->report,
                "personalityType" => $this->personalityType
            ]
        ];
    }

    public function getReport()
    {
        $this->setOptions();
        $this->calcStats();
        $this->generateReport();
        $this->setPersonalityType();
        return $this->formatReport();
    }

    abstract public function setOptions();

}