<?php

namespace App\Services;


use App\Models\ClassSeries;
use App\Models\Lookup;
use Carbon\Carbon;

class ScheduleSeries
{
    /**
     * @var null
     */
    public $class = null;

    /**
     * Construct the Service
     */
    public function __construct($class)
    {
        $this->class = $class;
    }


    /**
     * Storing class series if they are recurring.
     */
    public function storeSeries()
    {
        $firstGoesOf = Carbon::parse($this->class['first_goes_of']);
        $numberOfOccurrences = $this->class['number_of_occurrences'] ? $this->class['number_of_occurrences'] : $this->checkRepeatDifference();
        $seriesCategories = Lookup::whereIn('slug', $this->class['category'])->pluck('id');

        $this->class['class_id'] = $this->class['id'];
        unset($this->class['id']);
        for ($i = 0; $i < $numberOfOccurrences; $i++) {
            $class = new ClassSeries($this->class);
            $class->timestamp = $firstGoesOf;
            $class->save();
            $class->seriesCategories()->attach($seriesCategories);
            $firstGoesOf = $this->checkRepeatEvery($firstGoesOf);
        }
    }

    /**
     * @param $firstGoesOf
     * @return Carbon|null
     */
    public function checkRepeatEvery($firstGoesOf)
    {
        $timestamp = null;
        switch ($this->class['repeat_every']) {
            case 'day':
                {
                    $timestamp = Carbon::parse($firstGoesOf)->addDay();
                    break;
                }
            case 'week':
                {
                    $timestamp = Carbon::parse($firstGoesOf)->addWeek();
                    break;
                }
            case 'month':
                {
                    $timestamp = Carbon::parse($firstGoesOf)->addMonth();
                    break;
                }
            case 'year':
                {
                    $timestamp = Carbon::parse($firstGoesOf)->addYear();
                    break;
                }
        }
        return $timestamp;
    }

    /**
     * @return int|null
     */
    public function checkRepeatDifference()
    {
        $numberOfOccurrences = null;
        $firstGoesOf = Carbon::parse($this->class['first_goes_of']);
        $endsAt = Carbon::parse($this->class['ends_at']);

        switch ($this->class['repeat_every']) {
            case 'day':
                {
                    $numberOfOccurrences = ($endsAt->addDay())->diffInDays($firstGoesOf->subDay());
                    break;
                }
            case 'week':
                {
                    $numberOfOccurrences = ($endsAt->addWeek())->diffInWeeks($firstGoesOf->subWeek());
                    break;
                }
            case 'month':
                {
                    $numberOfOccurrences = ($endsAt->addMonth())->diffInMonths($firstGoesOf);
                    break;
                }
            case 'year':
                {
                    $numberOfOccurrences = ($endsAt->addYear())->diffInYears($firstGoesOf);
                    break;
                }
        }
        return $numberOfOccurrences;
    }

    /**
     *Storing only one class in class series if they are not recurring
     */
    public function storeClass()
    {
        $seriesCategories = Lookup::whereIn('slug', $this->class['category'])->pluck('id');

        $this->class['class_id'] = $this->class['id'];
        $this->class['id'] = null;
        $class = new ClassSeries($this->class);
        $class->save();
        $class->seriesCategories()->attach($seriesCategories);
    }
}
