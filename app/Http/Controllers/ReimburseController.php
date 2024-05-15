<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;

class ReimburseController extends Controller
{
    public $months = [
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    public function index(Request $request)
    {
        $data = $request->all();

        $variables['fromDate'] = null;
        $variables['toDate'] = null;
        $variables['excludeDates'] = [];
        $variables['overtimeDates'] = [];

        // if (!$data) return view('reimburse.index', $variables);

        $variables['fromDate'] = $data['from_date'] ?? null;
        $variables['toDate'] = $data['to_date'] ?? null;

        if ($request->exclude_dates) $variables['excludeDates'] = $data['exclude_dates'];
        if ($request->overtime_dates) $variables['overtimeDates'] = $data['overtime_dates'];

        $reimburse = $this->getReimburse($request);

        foreach ($reimburse as $key => $value) {
            $variables[$key] = $value;
        }

        if(isset($data['motor']))
           return view('reimburse.index_motor', $variables);

        return view('reimburse.index', $variables);
    }

    function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d')
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

    public function getReimburse($request)
    {
        $dates = $this->date_range($request->from_date, $request->to_date);

        if ($request->exclude_dates) {
            foreach ($dates as $key => $value) {
                foreach ($request->exclude_dates as $k => $v) {
                    if ($value != $v) continue;
                    unset($dates[$key]);
                    break;
                }
            }
        }

        $reimburses = [];
        $overtimes = [];
        $gorides = [];
        $mrts = [];
        $dataTransports = [];
        $dataLunchs = [];
        $dinners = [];
        $dataTotal = 0;

        foreach ($dates as $key => $value) {

            $day = date_create_from_format('Y-m-d', $value)->format('N'); // get numeric representation of day (1 for Monday, 7 for Sunday)

            if($day == 6 || $day == 7 ) continue;

            $data = new stdClass();
            $data->gasDate = date_create_from_format('Y-m-d', $value)->format('d/m/Y');
            $data->gasTime = "09:" . rand(20, 30);
            $data->gasNo = rand(2000, 2700);

            $str = "";
            for ($i = 0; $i < 5; $i++) {
                $str .= rand(0, 9);
            }
            $data->parkingNo = "4" . $str;
            $date = date_create_from_format('Y-m-d', $value);
            $month = $this->months[$date->format('n')];
            $data->parkingDate = $date->format("d ") . $month . $date->format(' Y');
            $data->parkingStartTime = "09:" . rand(40, 59);

            $str = "";
            $str .= rand(0, 59);
            if ($str >= 0 && $str <= 9) $str = str_pad($str, 2, '0', STR_PAD_LEFT);
            $data->parkingEndTime = "17:" . $str;

            $str = "";
            $str2 = "";
            $str .= rand(0, 59);
            if ($str >= 0 && $str <= 9) $str = str_pad($str, 2, '0', STR_PAD_LEFT);
            $str2 .= rand(12, 13);
            $data->lunchTime = $str2 . ":" . $str . " PM";

            $data->lunchDate = date_create_from_format('Y-m-d', $value)->format('d M, Y');

            $str = "";
            for ($i = 0; $i < 10; $i++) {
                $str .= rand(0, 3);
            }

            $data->lunchNo = "02202" . $str . "..";

            $data->lunchDesc = "Makan Siang";
            $data->lunchAmount = "Rp 40.000";

            $data->date = $value;

            $data->parkingCost = "Rp16.000";

            $goride = new stdClass();

            // goride date
            $time = $this->randomTime(8, 8, 50, 59);
            $gorideStartTimeMinute = substr($time, -2);
            $gorideDate = date_create_from_format('Y-m-d', $value)->format('d M');
            $goride->startDate1 =  "$gorideDate, $time";

            $time = $this->randomTime(9, 9, 45, 59);
            $goride->startDate2 =  "$gorideDate, $time";

            $time = $this->randomTime(17, 17, 0, 10);
            $gorideEndTimeMinute = substr($time, -2);
            $goride->endDate1 =  "$gorideDate, $time";

            $time = $this->randomTime(18, 18, 15, 25);
            $goride->endDate2 =  "$gorideDate, $time";
            $goride->fullFormatDate = $value;

            // mrt
            $mrt = new stdClass();
            $mrt->date = date_create_from_format('Y-m-d', $value)->format('d');
            $mrt->month = date_create_from_format('Y-m-d', $value)->format('M');
            $mrt->year = date_create_from_format('Y-m-d', $value)->format('Y');
            $mrt->fullFormatDate = $value;

            $startMinute = $gorideStartTimeMinute + rand(10, 15);
            if ($startMinute >= 60)
            $startMinute = $startMinute - 60;

            $endMinute = $startMinute + rand(30,40) - 60;
            if($startMinute <= 15) {
                $hour = 9;
            } else {
                $endMinute = rand(20,30);
            }
            if($endMinute >= 60) {
                // $endMinute = $endMinute - 60;
            } else {
                $hour = 8;
            }
            // $time = $this->randomTime($hour, $hour, $startMinute, $endMinute);
            $time = $this->randomTime(9, 9, 10, 15);
            $sec = $this->padLeft(rand(0,59));
            $mrt->startTime = "$time:$sec";

            // mrt endTime
            $startTime = $gorideEndTimeMinute + rand(10, 15);
            if ($startTime >= 60)
                $endTime = rand(0, 10);
            else
                $endTime = $startTime + rand(30, 40);
            $time = $this->randomTime(17, 17, 20, 30);
            $sec = $this->padLeft(rand(0,59));
            $mrt->endTime = "$time:$sec";

            $dataTransport = new stdClass();

            $dataTransport->date = $value;
            $dataTransport->desc1 = "Transport Gojek";
            $dataTransport->desc2 = "Transport MRT";
            $dataTransport->amount1 = "Rp 60.000";
            $dataTransport->amount2 = "Rp 28.000";

            $dataLunch = new stdClass();

            $dataLunch->date = $value;
            $dataLunch->desc = "Makan Siang";
            $dataLunch->amount = "Rp 40.000";

            $dataTotal += 128000;

            array_push($reimburses, $data);
            array_push($gorides, $goride);
            array_push($mrts, $mrt);
            array_push($dataTransports, $dataTransport);
            array_push($dataLunchs, $dataLunch);
        }

        if ($request->overtime_dates) {
            foreach ($request->overtime_dates as $key => $value) {

                $dinner = new stdClass();
                $str = "";
                for ($i = 0; $i < 10; $i++) {
                    $str .= rand(0, 3);
                }

                $dinner->dinnerNo = "02202" . $str . "..";

                $str = "";
                $str2 = "";
                $str .= rand(6, 7);
                if ($str == 6) {
                    $str2 = rand(45, 59);
                } else {
                    $str2 = rand(0, 10);
                    $str2 = str_pad($str2, 2, '0', STR_PAD_LEFT);
                }
                $str = str_pad($str, 2, '0', STR_PAD_LEFT);
                $dinner->dinnerTime = $str . ":" . $str2 . " PM";

                $dinner->dinnerDate = date_create_from_format('Y-m-d', $value)->format('d M, Y');
                $dinner->fullDate = $value;
                $dinner->desc = "Makan Lembur";
                $dinner->amount = "Rp 80.000";

                
                array_push($dinners, $dinner);

                foreach ($mrts as $k => $v) {
                    if($v->fullFormatDate != $value) continue;
                    $mrts[$k]->isOvertime = 1;
                }
                
                foreach ($gorides as $k => $v) {
                    if($v->fullFormatDate != $value) continue;
                    $gorides[$k]->isOvertime = 1;
                    $gorideDate = date_create_from_format('Y-m-d', $value)->modify('+1 day')->format('d M');
                    $time = $this->randomTime(0, 1, 0, 59);
                    $gorides[$k]->endDate1 = "$gorideDate, $time";
                }

                foreach ($dataTransports as $k => $v) {
                    if($v->date != $value) continue;
                    
                    $v->amount1 = "Rp 82.000";
                    $v->amount2 = "Rp 14.000";

                }
                
                $dataTotal += 88000;
            }
        }

        return [
            'reimburses' => $reimburses,
            'overtimes' => $overtimes,
            'gorides' => $gorides,
            'mrts' => $mrts,
            'dinners' => $dinners,
            'dataTransports' => $dataTransports,
            'dataTotal' => number_format($dataTotal, 0, ',', '.'),
        ];
    }

    public function print(Request $request)
    {
        $data = $request->all();

        $reimburse = $this->getReimburse($request);

        $variables['gorides'] = $reimburse['gorides'];
        $variables['mrts'] = $reimburse['mrts'];
        $variables['lunchs'] = $reimburse['reimburses'];
        $variables['dinners'] = $reimburse['dinners'];

        return view('reimburse.print', $variables);
    }

    public function randomTime($hourFrom, $hourTo, $minuteFrom, $minuteTo)
    {
        $hour = rand($hourFrom, $hourTo);
        $hour = $this->padLeft($hour);

        $minute = rand($minuteFrom, $minuteTo);
        $minute = $this->padLeft($minute);

        return "$hour:$minute";
    }

    public function padLeft($str)
    {
        if ($str >= 0 && $str <= 9) return str_pad($str, 2, '0', STR_PAD_LEFT);
        else return $str;
    }
}
