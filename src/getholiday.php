<?php
 if (isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day'])) {
  $y = $_POST['year'];
  $m = $_POST['month'];
  $d = $_POST['day'];
  $date = $y . '-' . $m . '-' . $d;
  $md1 = date('t', strtotime($date));

  $spHoliday = [
    '1-1' => '元日',
    '1-2' => '振替休日',
    '1-9' => '成人の日',
    '2-11' => '建国記念の日',
    '2-23' => '天皇誕生日',
    '3-21' => '春分の日',
    '4-29' => '昭和の日',
    '5-3' => '憲法記念日',
    '5-4' => 'みどりの日',
    '5-5' => 'こどもの日',
    '7-17' => '海の日',
    '8-11' => '山の日',
    '9-18' => '敬老の日',
    '9-23' => '秋分の日',
    '10-9' => 'スポーツの日',
    '11-3' => '文化の日',
    '11-23' => '勤労感謝の日'
  ];

  echo "<br>{$y}年{$m}月は{$md1}日あります。";

  function getWeekday($date)
  {
    $weekday = date('w', strtotime($date));
    $weekdays = ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'];
    return $weekdays[$weekday];
  }

  $wd = getWeekday($date);
  echo "{$date}は{$wd}です。";

  $firstDayOfMonth = date("w", mktime(0, 0, 0, $m, 1, $y));
  $lastDayOfMonth = date("t", mktime(0, 0, 0, $m, 1, $y));

  // カレンダーの表示
  echo "<h2>{$y}年{$m}月</h2>";

  // 日にちと曜日の出力
  for ($day = 1; $day <= $lastDayOfMonth; $day++) {
    $currentDayOfWeek = date("w", mktime(0, 0, 0, $m, $day, $y));
    $dayOfWeek = ['日', '月', '火', '水', '木', '金', '土'];

    $holidayKey = "{$m}-{$day}";
    $holidayName = isset($spHoliday[$holidayKey]) ? $spHoliday[$holidayKey] : '';

    echo "{$day} ({$dayOfWeek[$currentDayOfWeek]}): {$holidayName}<br>";
  }
}
?>