<?php

namespace Crimsoncircle\Model;

class LeapYear
{
    /**
     *
     * Calc if a year is a leap year
     *
     * @param int $year
     * @return int
     */
    public function isLeapYear(int $year): int
    {
        $response = 0;
        //TODO: Logic must be implemented to calculate if a year is a leap year

        // validar si es divisible entre 4 y despues validar si es año secular
        $isDivisibleBy4 = $year % 4 === 0;
        if ($isDivisibleBy4){
            // Validar si termina en 00 si es asi dividir entre 400 si el residuo es 0 aplica
            if (strpos($year, '00', -2)){
                $isDivisibleBy400 = $year % 400 === 0;
                if ($isDivisibleBy400){
                    $response = 1;
                }
            }else{
                $response = 1;
            }

        }

        return $response;
    }
}