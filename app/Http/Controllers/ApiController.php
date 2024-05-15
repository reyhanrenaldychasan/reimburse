<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getDatesBetweenTwoDates(Request $request) {

        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $data = [
            'data' => $this->date_range($request->from_date, $request->to_date, '+1 day', 'Y-m-d'),
        ];

        return response()->json($data, 200);
    }

    function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y')
    {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }
}
