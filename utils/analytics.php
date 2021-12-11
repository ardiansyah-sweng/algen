<?php

class Analytics
{
    public $numOfLastResult;

    function evaluation($iter, $analitics)
    {
        if ($iter >= ($this->numOfLastResult - 1)) {
            $residual = count($analitics) - $this->numOfLastResult;
            
            if ($residual === 0 && count(array_unique($analitics)) === 1) {
                return true;
            }

            if ($residual > 0) {
                for ($i = 0; $i < $residual; $i++) {
                    array_shift($analitics);
                }
                if (count(array_unique($analitics)) === 1) {
                    return true;
                }
            }
        }
    }

    function improvementUnderCertainPercentage($baseline, $iter, $analitics)
    {
        // for ($i = 0; $i < 10; $i++){
        //     $randoms[] = rand(1, 10);
        // }

        // foreach ($randoms as $key => $val){
        //     if ( ($key+1) < 10) {
        //         $residual[]  = ($randoms[$key+1] - $val) / $val;
        //     }        
        // }

        if ($iter >= ($this->numOfLastResult - 1)) {
            $residual = count($analitics) - $this->numOfLastResult;
            
            if ($residual === 0 && count(array_unique($analitics)) === 1) {
                return true;
            }

            if ($residual > 0) {
                for ($i = 0; $i < $residual; $i++) {
                    array_shift($analitics);
                }
                if (count(array_unique($analitics)) === 1) {
                    return true;
                }
            }
        }
        
        if (array_sum($residual) > $baseline){
            return true;
        }
    }
}