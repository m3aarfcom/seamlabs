<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartoneController extends Controller
{
   function low_int_post(Request $req)
    {
        $arr = $req->arr_values;
        $newArr = [];
        foreach($arr as $val)
        {
            if($val>0)
            array_push($newArr,$val);
        }
        $unique = array_flip($newArr);
        ksort($unique);
        for($i = array_key_first($unique); isset($unique[$i]);$i++);

        return ["Lowest Integer Number is "=>$i];

    }
    function DonotFive(Request $req)
    {
        $start = $req->start; $end = $req->end;
        $count = 0;
        for($i = $start;$i <= $end; $i++)
        {
          $str =  (string) $i;
          if(strpos($str,"5") ===  false)
          $count++;
        }
        return ['Result'=>$count];
    }
    function alphaIndex(Request $req)
    {
        $string  = $req->input_string;
        $alpha   = array_flip(range('A','Z'));
        $letters = str_split($string);
        $output  = 0;
         foreach($letters as $index => $char)
         {
             $output = $output +  ($alpha[$char]+1);
             if($index < count($letters)-1)
             {
                $output *= 26;
             }
         }
        return ["Output is"=>$output];
    }
}
