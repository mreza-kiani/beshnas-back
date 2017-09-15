<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 9/15/17
 * Time: 5:47 PM
 */

namespace App\Utils\Services\ReportServices;

use App\Models\Option;
use Exception;

abstract class Reporter
{
    private $stats;
    private $progress;
    private $progressCount;
    private $report;
    private $personalityType;
    private $personalityCategories;

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

    public function setPersonalityCategories()
    {
        $this->personalityCategories = [];
        $mappingCategories = [
            "mind" => ["I" => "introvert", "E" => "extrovert"],
            "energy" => ["S" => "observant", "N" => "intuitive"],
            "nature" => ["T" => "thinking", "F" => "feeling"],
            "tactics" => ["J" => "judging", "P" => "prospecting"],
            "identity" => ["A" => "assertive", "T" => "turbulent"],
        ];
        $index = 0;
        $type = str_split($this->personalityType);
        foreach ($mappingCategories as $key => $mappingCategory) {
            try{
            $this->personalityCategories[$key] = trans('personality.'.$key .'.'.$mappingCategory[$type[$index]]);
            } catch (Exception $e){
                $this->personalityCategories[$key] = "?";
            }
            $index++;
        }
    }

    public function formatReport()
    {
        return [
            "data" => [
                "progress" => number_format($this->progress),
                "detail" => $this->report,
                "personalityType" => substr_replace($this->personalityType, "-", 4, 0),
                "personalityCategories" => $this->personalityCategories
            ]
        ];
    }

    public function getReport()
    {
        $this->setOptions();
        $this->calcStats();
        $this->generateReport();
        $this->setPersonalityType();
        $this->setPersonalityCategories();
        return $this->formatReport();
    }

    abstract public function setOptions();

}