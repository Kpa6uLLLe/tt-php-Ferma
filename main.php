<?php
//01.01.2000 - saturday
class Date{
    const STARTING_DAY = 4;
    const FRIDAY = 4;
    const STARTING_YEAR = 2000;
    const YEAR_TOO_FEW_MSG = "There was no shop yet";
    const DAYS_IN_WEEK = 7;
    const CHAIR = "chair";
    const DESK = "desk";
    const MONTH_NAMES = ["янв.", "фев.", "мар.", "апр.","мая", "июня", "июля", "авг.", "сен.", "окт.", "нояб.", "дек."];
    private $chairs = 0;
    private $desks = 0;
    private $lastMonthDay = 0;

    public function getAllDatesUntilYear($year){
        if ($year < $this::STARTING_YEAR) {
            return $this::YEAR_TOO_FEW_MSG;
        }
        $this->lastMonthDay = $this::STARTING_DAY;
        $str = "";
        for ($i = $this::STARTING_YEAR; $i <= $year; $i++){

            $str .= $this->getAllDatesYear( $i );
        }
        
        $this->reset();
        return $str;
    }
    private function reset(){
        $this->chairs = 0;
        $this->desks = 0;
        $this->lastMonthDay = 0;
    }
    private function getAllDatesYear($year){
        $str = "";
        $chairs = 0;
        $desks = 0;
        $difference = $this ->desks - $this->chairs;
        $months = [31,28,31,30,31,30,31,31,30,31,30,31];
        if($year % 4 == 0){
            $months[1] = 29;
        }
        for ($i = 0; $i < count($months); $i++){
            $saleDay = ($this::DAYS_IN_WEEK + $this::FRIDAY - $this->lastMonthDay)%$this::DAYS_IN_WEEK;
            
            if ($saleDay == 0){
                $saleDay += $this::DAYS_IN_WEEK;
            }
            if($difference != 0){
                if ($difference > 0){
                    $chairs += 1;
                    $difference -=1;
                } else {
                    $desks += 1;
                    $str .= ($saleDay) . "-е ";
                    $str .= ($this::MONTH_NAMES[$i]) . " ";
                    $str .= ($year);
                    $str .= "  ";
                    $difference +=1;
                }
            }
            else if ($saleDay %2 == 0 ) {
                $chairs += 1;
            } else if ($saleDay %2 == 1) {
                $desks += 1;
                $str .= ($saleDay) . "-е ";
                $str .= ($this::MONTH_NAMES[$i]) . " ";
                $str .= ($year);
                $str .= "  ";
            }
            $this->lastMonthDay = ($this->lastMonthDay + ($months[$i])%$this::DAYS_IN_WEEK)%$this::DAYS_IN_WEEK; 
        }
        $this->chairs += $chairs;
        $this->desks += $desks;
        
        return $str;
    }
}

$date = new Date();
$year = readline("Enter a year:   ");
echo $date->getAllDatesUntilYear($year);
?>