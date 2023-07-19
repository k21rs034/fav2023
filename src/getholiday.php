<?php
function calculateCalendar($y, $m, $d)
{
  $date = $y . '-' . $m . '-' . $d;
  $md1 = date('t', strtotime($date));

  $result = [
    'totalDays' => $md1,
    'weekday' => getWeekday($date),
    'calendar' => []
  ];

  //$firstDayOfMonth = date("w", mktime(0, 0, 0, $m, 1, $y));
  $lastDayOfMonth = date("t", mktime(0, 0, 0, $m, 1, $y));

  // 日にちと曜日の計算
  for ($day = 1; $day <= $lastDayOfMonth; $day++) {
    $currentDayOfWeek = date("w", mktime(0, 0, 0, $m, $day, $y));
    $dayOfWeek = ['日', '月', '火', '水', '木', '金', '土'];

    $holidayName = getHolidayName($y, $m, $day);

    $result['calendar'][] = [
      'day' => $day,
      'weekday' => $dayOfWeek[$currentDayOfWeek],
      'holiday' => $holidayName
    ];
  }

  return $result;
}

function getWeekday($date)
{
  $weekday = date('w', strtotime($date));
  $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
  return $weekdays[$weekday];
}

function getHolidayName($year, $month, $day)
{
  $holidayName = '';

  // 固定祝日
  $fixedHolidays = [
    '01-01' => '元日',
    '02-11' => '建国記念の日',
    '02-23' => '天皇誕生日',
    '04-29' => '昭和の日',
    '05-03' => '憲法記念日',
    '05-04' => 'みどりの日',
    '05-05' => 'こどもの日',
    '08-11' => '山の日',
    '11-03' => '文化の日',
    '11-23' => '勤労感謝の日'
  ];

  $date = date('m-d', mktime(0, 0, 0, $month, $day, $year));

  if (isset($fixedHolidays[$date])) {
    $holidayName = $fixedHolidays[$date];
  } else {
    // 春分の日の計算
    $springEquinox = floor(20.8431 + 0.242194 * ($year - 1980)) - floor(($year - 1980) / 4);
    $springEquinoxTimestamp = mktime(0, 0, 0, 3, 21 + $springEquinox, $year);
    $springEquinoxDate = date('m-d', $springEquinoxTimestamp);

    // 秋分の日の計算
    $autumnEquinox = floor(23.2488 + 0.242194 * ($year - 1980)) - floor(($year - 1980) / 4);
    $autumnEquinoxTimestamp = mktime(0, 0, 0, 9, 23 + $autumnEquinox, $year);
    $autumnEquinoxDate = date('m-d', $autumnEquinoxTimestamp);

    // 第2月曜日を計算
    $secondMonday = strtotime("second monday of $year-$month");
    $secondMondayDate = date('m-d', $secondMonday);

    // 第3月曜日を計算
    $thirdMonday = strtotime("third monday of $year-$month");
    $thirdMondayDate = date('m-d', $thirdMonday);

    // 成人の日の計算（1月の場合）
    if ($month == '01' && $date == $secondMondayDate) {
      $holidayName = '成人の日';
    }

    // 海の日の計算
    if ($month == '07' && $date == $thirdMondayDate) {
      $holidayName = '海の日';
    }

    // 敬老の日の計算（9月の場合）
    if ($month == '09' && $date == $thirdMondayDate) {
      $holidayName = '敬老の日';
    }

    // スポーツの日の計算（10月の場合）
    if ($month == '10' && $date == $secondMondayDate) {
      $holidayName = 'スポーツの日';
    }

    if ($date == $springEquinoxDate) {
      $holidayName = '春分の日';
    } else if ($date == $autumnEquinoxDate) {
      $holidayName = '秋分の日';
    }

    // 振替休日の判定
    $prevDay = strtotime('-1 day', strtotime("$year-$month-$day"));
    $prevDayOfWeek = date('w', $prevDay);
    if ($prevDayOfWeek == 0 && isset($fixedHolidays[date('m-d', $prevDay)])) {
      // 前日が日曜でかつ前日が祝日の場合は振替休日とする
      $holidayName = '振替休日';
    }
  }

  return $holidayName;
}


if (isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day'])) {
  $y = $_POST['year'];
  $m = $_POST['month'];
  $d = $_POST['day'];

  $result = calculateCalendar($y, $m, $d);

  echo "<h2><br>{$y}年{$m}月は{$result['totalDays']}日あります。";
  echo "{$y}-{$m}-{$d}は{$result['weekday']}曜日です。</h2>";

  $lastDayOfMonth = date('t', strtotime("$y-$m-01"));

  echo "<h2>{$y}年{$m}月の祝日</h2>";

  for ($day = 1; $day <= $lastDayOfMonth; $day++) {
    $holidayName = getHolidayName($y, $m, $day);
    $weekday = getWeekday("$y-$m-$day");

    if (!empty($holidayName)) {
      echo "{$m}月{$day}日({$weekday}): {$holidayName}<br>";
    } 
  }

  // カレンダーの表示
  echo "<h2>{$y}年{$m}月</h2>";

  // 日にちと曜日の出力
  foreach ($result['calendar'] as $dayInfo) {
    echo $dayInfo['day'].'('.$dayInfo['weekday'].'):'. $dayInfo['holiday'].'<br>';
  }
}

?>