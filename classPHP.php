<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI</title>
    <style>
        body {
            display: grid;
            color:aliceblue;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: x-large;
            font-style: italic;
        }
        a{
            color:aliceblue;
        }

        table {
            border: 1px ridge red;
            border-collapse: collapse;
            
            background-color: gray;
        }
        thead{
            font-style: oblique;
        }
        td {

            border: 1px ridge red;
            
        }
    </style>
</head>

<body>
    <?php
    session_start();
    // "航班"、"目的地"、"起飛"三欄加上超連結，點選該連結，後台重新送出依該欄排序的航班表
    // 升幂(ASC)排序請將欄位名修改為 : 欄位名^、降幂(DESC)排序則顯示：欄位名v，
    // 這三欄位連結的行為實作為 toggle 模式 (ASC <--> DESC)

    // $array = array("asd","qwe,");
    // $array += ["colo" => "red" , "year" => 2001];
    $dataBase = @file('C:\Users\鄭裕憲\Downloads\ChinaAirLine.csv');
    // echo sizeof($array) . "<br>";
    ?>
    <table>
        <?php
        $qq = "香山";
        foreach ($dataBase as $key => $value) :
            //把第N個資料以逗號紛紛開放到list 4個變數裡
            list($flight, $destination, $flydata, $landingdata)  = explode(",", $value);
            //將四個變數指定為valuearray李地N個陣列的指定的欄位
            $valuearray[$key] = array(
                'flight' => $flight,
                'destination' => $destination,
                'flydata' => $flydata,
                'landingdata' => $landingdata
            );
            echo "<tr>";
            if ($_SESSION['state'] == 0) {
                if ($key == 0) {
                    echo "<thead><td><a href='fl.php'>" . $valuearray[$key]['flight'] . "</td></a>";
                    echo "<td><a href='da.php'>" . $valuearray[$key]['destination'] . "</td></a>";
                    echo "<td><a href='fly.php'>" . $valuearray[$key]['flydata'] . "</td></a>";
                    echo "<td>" . $valuearray[$key]['landingdata'] . "</td><thead>";
                } else {
                    $qq = $valuearray[$key]['destination'];
                    echo "<td>" . $valuearray[$key]['flight'] . "</td>";
                    echo "<td><a href='https://www.google.com/search?q=$qq'>" . $valuearray[$key]['destination'] . "</td>";
                    echo "<td>" . $valuearray[$key]['flydata'] . "</td>";
                    echo "<td>" . $valuearray[$key]['landingdata'] . "</td>";
                }
                echo "</tr>";
            }
        endforeach;

        //航班排序
        if (isset($_SESSION) && $_SESSION['state'] == 1) {
            //把分開的項目合併好做排序
            foreach ($valuearray as $k => $v) {
                //將項目細項結合
                //做分割
                if ($k == 0) {
                    $fakeflightsort[0] =  implode(",", $array = [$valuearray[$k]['destination'], $valuearray[$k]['flight'], $valuearray[$k]['flydata'], $valuearray[$k]['landingdata']]);
                } else {
                    $flightsort[$k] = implode(",", $array = [$valuearray[$k]['flight'], $valuearray[$k]['destination'], $valuearray[$k]['flydata'], $valuearray[$k]['landingdata']]);
                }
            }
            $flightsort = Allsort('flight','rflight',$flightsort);
            
            //把排好的flightsort丟回並印出
            foreach ($flightsort as $key => $value) {

                    list($destination, $flight, $flydata, $landingdata)  = explode(",", $fakeflightsort[0]);
                    $valuearrayF[$key] = array(
                        'flight' => $flight,    'destination' => $destination,
                        'flydata' => $flydata,  'landingdata' => $landingdata
                    );

                    list($flight, $destination, $flydata, $landingdata)  = explode(",", $value);
                    $valuearray[$key] = array(
                        'flight' => $flight,    'destination' => $destination,
                        'flydata' => $flydata,  'landingdata' => $landingdata
                    );
                echo "<tr>";

                $valuearrayF[0]['flight'] = readstatus($valuearrayF,'flight','rflight');

                printTime($key,$valuearrayF,$valuearray);

                echo "</tr>";
            }
            // print_r( $flightsort[0]);
        }
        //目的地排序
        if (isset($_SESSION) && $_SESSION['state'] == 2) {
            //把分開的項目合併好做排序
            foreach ($valuearray as $k => $v) {
                //將項目細項結合
                //做分割
                if ($k == 0) {
                    $fakedestinationsort[0] =  implode(",", $array = [$valuearray[$k]['destination'], $valuearray[$k]['flight'], $valuearray[$k]['flydata'], $valuearray[$k]['landingdata']]);
                } else {
                    $destinationsort[$k] = implode(",", $array = [$valuearray[$k]['destination'], $valuearray[$k]['flight'], $valuearray[$k]['flydata'], $valuearray[$k]['landingdata']]);
                }
            }
            $destinationsort = Allsort('destination','rdestination',$destinationsort);

            //把排好的destinationsort丟回並印出
            foreach ($destinationsort as $key => $value) {

                    list($destination, $flight, $flydata, $landingdata)  = explode(",", $fakedestinationsort[0]);
                    $valuearrayF[$key] = array(
                        'flight' => $flight,    'destination' => $destination,
                        'flydata' => $flydata,  'landingdata' => $landingdata
                    );

                    list($destination, $flight, $flydata, $landingdata)  = explode(",", $value);
                    $valuearray[$key] = array(
                        'flight' => $flight,    'destination' => $destination,
                        'flydata' => $flydata,  'landingdata' => $landingdata
                    );

                echo "<tr>";

                $valuearrayF[0]['destination'] = readstatus($valuearrayF,'destination','rdestination');

                printTime($key,$valuearrayF,$valuearray);

                echo "</tr>";
            }
            
        }
        //起飛時間排序
        if (isset($_SESSION) && $_SESSION['state'] == 3) {
            //把分開的項目合併好做排序
            foreach ($valuearray as $k => $v) {
                //將項目細項結合
                //做分割
                if ($k == 0) {
                    $fakeflydata[0] =  implode(",", $array = [$valuearray[$k]['destination'], $valuearray[$k]['flight'], $valuearray[$k]['flydata'], $valuearray[$k]['landingdata']]);
                } else {
                    $flydatasort[$k] = implode(",", $array = [$valuearray[$k]['flydata'], $valuearray[$k]['destination'], $valuearray[$k]['flight'], $valuearray[$k]['landingdata']]);
                }
            }
            $flydatasort = Allsort('flydata','rflydata',$flydatasort);

            //把排好的flightsort丟回並印出
            foreach ($flydatasort as $key => $value) {

                    list($destination, $flight, $flydata, $landingdata)  = explode(",", $fakeflydata[0]);
                    $valuearrayF[$key] = array(
                        'flight' => $flight,    'destination' => $destination,
                        'flydata' => $flydata,  'landingdata' => $landingdata
                    );

                    list($flydata, $destination, $flight, $landingdata)  = explode(",", $value);
                    $valuearray[$key] = array(
                        'flight' => $flight,    'destination' => $destination,
                        'flydata' => $flydata,  'landingdata' => $landingdata
                    );

                echo "<tr>";

                $valuearrayF[0]['flydata'] = readstatus($valuearrayF,'flydata','rflydata');
                printTime($key,$valuearrayF,$valuearray);

                echo "</tr>";
            }
            // echo $key;
        }
        $_SESSION['state'] = 0;

        function Allsort($data,$rdata,$dataname){
            if($_SESSION['statesort'] == $data){
                sort($dataname);
                return $dataname;
            }else if($_SESSION['statesort'] == $rdata){
                rsort($dataname);
                return $dataname;
            }
        }
        function readstatus($valuearrayF,$dataname,$rdataname){
            if($_SESSION['statesort'] == $dataname){
                return $valuearrayF[0][$dataname] = $valuearrayF[0][$dataname] . "^"; 
            }else if($_SESSION['statesort'] == $rdataname){
                return $valuearrayF[0][$dataname] = $valuearrayF[0][$dataname] . "v";
            }
        }
        function printTime($key,$valuearrayF,$valuearray){
            if ($key == 0) {
                echo "<thead><td><a href='fl.php'>" . $valuearrayF[0]['flight'] . "</td></a>";
                echo "<td><a href='da.php'>" . $valuearrayF[0]['destination'] . "</td></a>";
                echo "<td><a href='fly.php'>" . $valuearrayF[0]['flydata'] . "</td></a>";
                echo "<td>" . $valuearrayF[0]['landingdata'] . "</td><thead>";
            }
                $qq = $valuearray[$key]['destination'];
                echo "<td>" . $valuearray[$key]['flight'] . "</td>";
                echo "<td><a href='https://www.google.com/search?q=$qq'>" . $valuearray[$key]['destination'] . "</td>";
                echo "<td>" . $valuearray[$key]['flydata'] . "</td>";
                echo "<td>" . $valuearray[$key]['landingdata'] . "</td>";
        }
        
        ?>
    </table>
</body>

</html>