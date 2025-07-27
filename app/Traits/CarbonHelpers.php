<?php

namespace App\Traits;

use Carbon\Carbon;

trait CarbonHelpers
{
    /**
     * Safely add months to a Carbon instance
     *
     * @param Carbon $date
     * @param mixed $months
     * @return Carbon
     */
    protected function safeAddMonths(Carbon $date, $months): Carbon
    {
        $months = (int) $months;
        
        if ($months < 0) {
            throw new \InvalidArgumentException('Months must be a positive integer');
        }
        
        return $date->addMonths($months);
    }
    
    /**
     * Safely add days to a Carbon instance
     *
     * @param Carbon $date
     * @param mixed $days
     * @return Carbon
     */
    protected function safeAddDays(Carbon $date, $days): Carbon
    {
        $days = (int) $days;
        
        if ($days < 0) {
            throw new \InvalidArgumentException('Days must be a positive integer');
        }
        
        return $date->addDays($days);
    }
    
    /**
     * Safely add weeks to a Carbon instance
     *
     * @param Carbon $date
     * @param mixed $weeks
     * @return Carbon
     */
    protected function safeAddWeeks(Carbon $date, $weeks): Carbon
    {
        $weeks = (int) $weeks;
        
        if ($weeks < 0) {
            throw new \InvalidArgumentException('Weeks must be a positive integer');
        }
        
        return $date->addWeeks($weeks);
    }
    
    /**
     * Safely add years to a Carbon instance
     *
     * @param Carbon $date
     * @param mixed $years
     * @return Carbon
     */
    protected function safeAddYears(Carbon $date, $years): Carbon
    {
        $years = (int) $years;
        
        if ($years < 0) {
            throw new \InvalidArgumentException('Years must be a positive integer');
        }
        
        return $date->addYears($years);
    }
    
    /**
     * Create a new Carbon instance with safe month addition
     *
     * @param mixed $months
     * @return Carbon
     */
    protected function nowPlusMonths($months): Carbon
    {
        return $this->safeAddMonths(now(), $months);
    }
    
    /**
     * Create a new Carbon instance with safe day addition
     *
     * @param mixed $days
     * @return Carbon
     */
    protected function nowPlusDays($days): Carbon
    {
        return $this->safeAddDays(now(), $days);
    }
    
    /**
     * Validate and cast duration input
     *
     * @param mixed $duration
     * @param int $min
     * @param int $max
     * @param string $unit
     * @return int
     * @throws \InvalidArgumentException
     */
    protected function validateDuration($duration, int $min = 1, int $max = 12, string $unit = 'months'): int
    {
        $duration = (int) $duration;
        
        if ($duration < $min || $duration > $max) {
            throw new \InvalidArgumentException("Duration must be between {$min} and {$max} {$unit}.");
        }
        
        return $duration;
    }
}