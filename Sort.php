<?php

class Sort {
    /**
     * Sort an Array of objects by date
     * @var $array = Array to sort
     * @var $key = Key in array or object to date value
     * @var $direction = ASC or DESC (DESC by default)
     * @var $aftertoday = (optionnal) boolean, if true return values only after date of today
     * @return array
     */
    public function sortByDate(array $array, $key, $direction = "DESC", $aftertoday = false)
    {
        $type = 'array';
        foreach($array as $o){
            if(gettype($o) === "object")
                $type = 'object';
        }

        if($aftertoday){
            $today = strtotime(date('Y-m-d'));

            foreach($array as $k => $o)
            {
                if($type === 'object'){
                    if(strtotime($o->{$key}) - $today < 0){
                        unset($array[$k]);
                    }
                } else {
                    if(strtotime($o[$key]) - $today < 0){
                        unset($array[$k]);
                    }
                }
            }
        }

        $result = $this->uSort($array, $type, $key, $direction);

        return $result;
    }

    protected function uSort(array $array, $type, $key, $direction)
    {
        if($type === 'object'){
            if(strtoupper($direction) === 'ASC'){
                usort($array, function($a1, $a2) use($key){
                    return strtotime($a2->{$key}) - strtotime($a1->{$key});
                });
            } else {
                usort($array, function($a1, $a2) use($key){
                    return strtotime($a1->{$key}) - strtotime($a2->{$key});
                });
            }
        } else {
            if(strtoupper($direction) === 'ASC'){
                usort($array, function($a1, $a2) use($key){;
                    return strtotime($a2[$key]) - strtotime($a1[$key]);
                });
            } else {
                usort($array, function($a1, $a2) use($key){
                    return strtotime($a1[$key]) - strtotime($a2[$key]);
                });
            }
        }
        return $array;
    }
}