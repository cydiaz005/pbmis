<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function html_cut($text, $max_length)
    {
        if(strlen(strip_tags($text)) < $max_length){return $text;}
        $tags   = array();
        $result = "";

        $is_open   = false;
        $grab_open = false;
        $is_close  = false;
        $in_double_quotes = false;
        $in_single_quotes = false;
        $tag = "";

        $i = 0;
        $stripped = 0;
        $stripped_text = strip_tags($text);
        while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
        {
            $symbol  = $text[$i];
            $result .= $symbol;
            switch ($symbol)
            {
            case '<':
                    $is_open   = true;
                    $grab_open = true;
                    break;
            case '"':
                if ($in_double_quotes)
                    $in_double_quotes = false;
                else
                    $in_double_quotes = true;
                break;
                case "'":
                if ($in_single_quotes)
                    $in_single_quotes = false;
                else
                    $in_single_quotes = true;
                break;
                case '/':
                    if ($is_open && !$in_double_quotes && !$in_single_quotes)
                    {
                        $is_close  = true;
                        $is_open   = false;
                        $grab_open = false;
                    }
                    break;
                case ' ':
                    if ($is_open)
                        $grab_open = false;
                    else
                        $stripped++;
                    break;
                case '>':
                    if ($is_open)
                    {
                        $is_open   = false;
                        $grab_open = false;
                        array_push($tags, $tag);
                        $tag = "";
                    }
                    else if ($is_close)
                    {
                        $is_close = false;
                        array_pop($tags);
                        $tag = "";
                    }
                    break;
                default:
                    if ($grab_open || $is_close)
                        $tag .= $symbol;

                    if (!$is_open && !$is_close)
                        $stripped++;
            }
            $i++;
        }
        while ($tags)
            $result .= "</".array_pop($tags).">";
        return $result.'...';
    }
    public function datetime_elapsed($date2)
    {
        $diff = abs(strtotime('now') - strtotime($date2));
        $unit = "min";
        $units = ["min","hour","day","week","month","year"];
        $conversions = [60, 60, 24, 7, 31, 365];
        $unit = "";
        $dt_diff = "Just now";
        $i;
        if($diff > 60){
            for ($i=0; $i < count($conversions); $i++) { 
                if($diff > 60){
                    $diff = $diff / $conversions[$i];
                }
                else{
                    break;
                }
            }
            $unit = $units[$i - 1];
            if((int)$diff > 1){
                $unit = $unit."s";
            }
            $dt_diff = (int)$diff." ".$unit." ago";
        }
        return $dt_diff;
    }
}
