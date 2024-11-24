<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;

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

        $variables['reimburses'] = $this->getReimburse($request);

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

        $reimburses = new stdClass;
        $reimburses->totalAmount = 0;
        $reimburses->transports = collect([]);
        $reimburses->parkings = collect([]);
        $reimburses->lunchs = collect([]);
        $reimburses->dinners = collect([]);

        $lunchCost = env('LUNCH_COST', 40000);
        $gasCost = env('GAS_COST', 15000);
        $gasCostPerLiter = env("GAS_LITER_COST");
        $parkingCost = env('PARKING_COST', 2000);
        $dinnerCost = env('DINNER_COST', 40000);

        foreach ($dates as $key => $value) {

            $day = date_create_from_format('Y-m-d', $value)->format('N'); // get numeric representation of day (1 for Monday, 7 for Sunday)

            if($day == 6 || $day == 7 ) continue;
            
            // populating transport
            $transport = new stdClass;

            $transport->date = $value;
            $transport->dateDesc = date_create_from_format('Y-m-d', $value)->format('d/m/Y');
            $transport->time = "09:" . rand(20, 30);
            $transport->no = rand(2000, 2700);
            $transport->amount = $gasCost;
            $transport->costPerLiter = $gasCostPerLiter;
            $transport->tableDesc = "Transport";

            $reimburses->transports->push($transport);
            // end populating transport

            // populating parking
            $parking = new stdClass;

            $str = "";
            for ($i = 0; $i < 5; $i++) {
                $str .= rand(0, 9);
            }
            $parking->no = "4" . $str;
            $date = date_create_from_format('Y-m-d', $value);
            $month = $this->months[$date->format('n')];
            $parking->date = $value;
            $parking->dateStart = $value;
            $parking->dateEnd = $value;
            $parking->dateStartDesc = $date->format("d ") . $month . $date->format(' Y');
            $parking->dateEndDesc = $date->format("d ") . $month . $date->format(' Y');
            $parking->startTime = $this->randomTime(9,9,40,59) . ":" . $this->padLeft(rand(0,59));
            $parking->endTime = $this->randomTime(17,17,0,59) . ":" . $this->padLeft(rand(0,59));
            $parking->amount = $parkingCost*8;
            $parking->tableDesc = "Parkir";

            $reimburses->parkings->push($parking);
            // end populating parking

            // populating lunch
            $lunch = new stdClass;

            $lunch->time = $this->randomTime(12,13,0,59) . " PM";

            $lunch->date = $value;
            $lunch->dateDesc = date_create_from_format('Y-m-d', $value)->format('d M, Y');

            $str = "";
            for ($i = 0; $i < 10; $i++) {
                $str .= rand(0, 3);
            }

            $lunch->no = "02202" . $str . "..";

            $lunch->desc = "Makan Siang";
            $lunch->amount = $lunchCost;
            $lunch->tableDesc = "Makan Siang";

            $reimburses->lunchs->push($lunch);
            // end populating lunch

            $reimburses->totalAmount += ($gasCost) + ($parkingCost*8) + $lunchCost;
        }

        if ($request->overtime_dates) {
            foreach ($request->overtime_dates as $key => $value) {

                $dinner = new stdClass();
                $str = "";
                for ($i = 0; $i < 10; $i++) {
                    $str .= rand(0, 3);
                }

                $dinner->no = "02202" . $str . "..";

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

                $dinner->date = $value;
                $dinner->dateDesc = date_create_from_format('Y-m-d', $value)->format('d M, Y');
                $dinner->time = $this->randomTime(20,21,0,59) . " PM";
                $dinner->fullDate = $value;
                $dinner->desc = "Makan Lembur";
                $dinner->amount = $dinnerCost;
                $dinner->tableDesc = "Makan Lembur";

                $reimburses->dinners->push($dinner);

                $reimburses->totalAmount += $dinnerCost;
            }
        }

        return $reimburses;
    }

    public function print(Request $request)
    {
        $variables['reimburses'] = $this->getReimburse($request);

        return view('reimburse.print', $variables);
    }

    public function randomTime(int $hourFrom, int $hourTo, int $minuteFrom, int $minuteTo)
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

    public function getReimburseMrt($request)
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

        $reimburses = new StdClass;
        $reimburses->dataTransports = [];
        $reimburses->dataParkings = [];
        $reimburses->dataLunchs = [];
        $reimburses->dataDinners = [];
        $reimburses->dataTotal = 0;
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
            
            $lunchCost = env('LUNCH_COST', 40000);
            $gasCost = env('GAS_COST', 15000);
            $parkingCost = env('parkingCost', 16000);

            $transport = new stdClass;

            $transport->gasDate = date_create_from_format('Y-m-d', $value)->format('d/m/Y');
            $transport->gasTime = "09:" . rand(20, 30);
            $transport->gasNo = rand(2000, 2700);
            $transport->gasCost = $gasCost;

            $parking = new stdClass;

            $str = "";
            for ($i = 0; $i < 5; $i++) {
                $str .= rand(0, 9);
            }
            $parking->parkingNo = "4" . $str;
            $date = date_create_from_format('Y-m-d', $value);
            $month = $this->months[$date->format('n')];
            $parking->parkingDate = $date->format("d ") . $month . $date->format(' Y');
            $parking->parkingStartTime = "09:" . rand(40, 59);

            $str = "";
            $str .= rand(0, 59);
            if ($str >= 0 && $str <= 9) $str = str_pad($str, 2, '0', STR_PAD_LEFT);
            $parking->parkingEndTime = "17:" . $str;
            $parking->parkingCost = "Rp".$parkingCost;

            $lunch = new stdClass;

            $str = "";
            $str2 = "";
            $str .= rand(0, 59);
            if ($str >= 0 && $str <= 9) $str = str_pad($str, 2, '0', STR_PAD_LEFT);
            $str2 .= rand(12, 13);
            $lunch->lunchTime = $str2 . ":" . $str . " PM";

            $lunch->lunchDate = date_create_from_format('Y-m-d', $value)->format('d M, Y');

            $str = "";
            for ($i = 0; $i < 10; $i++) {
                $str .= rand(0, 3);
            }

            $lunch->lunchNo = "02202" . $str . "..";

            $lunch->lunchDesc = "Makan Siang";
            $lunch->lunchAmount = "Rp 40.000";

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


            // populating data for table

            $dataTransport = new stdClass();

            $dataTransport->date = $value;
            $dataTransport->desc = "Transport";
            $dataTransport->amount = "Rp " . number_format($gasCost, 0, ',', '.');

            array_push($reimburses->dataTransports, $dataTransport);

            $dataParking = new stdClass();

            $dataParking->date = $value;
            $dataParking->desc = "Parkir";
            $dataParking->amount = "Rp " . number_format($parkingCost, 0, ',', '.');

            array_push($reimburses->dataParkings, $dataParking);
            
            $dataLunch = new stdClass();
            
            $dataLunch->date = $value;
            $dataLunch->desc = "Makan Siang";
            $dataLunch->amount = "Rp " . number_format($lunchCost, 0, ',', '.');
            
            array_push($reimburses->dataLunchs, $dataLunch);

            $dataTotal += ($gasCost) + ($parkingCost) + $lunchCost;

            // end populating data for table
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
                    
                    $gojekTransportWithOvertime = env('GOJEK_COST', 15000) + env('GOJEK_OVERTIME_COST');
                    $v->amount1 = "Rp " . number_format($gojekTransportWithOvertime, 0, ',', '.');
                    $v->amount2 = "Rp " . number_format(env('MRT_COST'), 0, ',', '.');

                }
                
                $dataTotal += env('GOJEK_OVERTIME_COST') + env('DINNER_COST') - env('GOJEK_COST') + env('MRT_COST');
            }
        }

        return [
            'reimburses' => $reimburses,
            'overtimes' => $overtimes,
            'gorides' => $gorides,
            'mrts' => $mrts,
            'dinners' => $dinners,
            'dataTransports' => collect($dataTransports),
            'dataTotal' => number_format($dataTotal, 0, ',', '.'),
        ];
    }
}
