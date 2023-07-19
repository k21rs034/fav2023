## 祝日自動計算プログラム
1. Composerをインストール
2. リポジトリ**fav2023**を`htdocs`以下にClone
3. `fav2023`フォルダに入って、以下のコマンドで、パッケージインストール<br> (`vendor`フォルダが現れることを確認)<br>
`composer install`
1. yaml.phpを実行<br>http://localhost/fav2023/yaml.php

5. 仕様
    - calculateCalendar($y, $m, $d)関数 この関数は、指定された年($y)、月($m)、日($d)に基づいてカレンダーを計算する。<br> まず、指定された日付の月の総日数を取得し、その他の情報を格納するための空の配列を準備する。<br>次に、1日から月末までの日にちごとにループを行い、各日にちの曜日と祝日名（もしあれば）を計算し、配列に追加していく。最終的に、カレンダーの計算結果を配列として返す。

    - getWeekday($date)関数
    この関数は、指定された日付($date)の曜日を取得する。<br>まず、strtotime()関数を使って指定された日付をUnixタイムスタンプに変換し、date('w')を使って曜日を数値で取得する。<br>その後、数値に基づいて対応する曜日の文字列を取得し、返す。

    - getHolidayName($year, $month, $day)関数
    この関数は、指定された年($year)、月($month)、日($day)が祝日か振替休日かを判定する。<br>まず、固定祝日のリストを用意する。指定された日付を使って、固定祝日や春分の日、秋分の日、そして月によって異なる成人の日、海の日、敬老の日、スポーツの日を計算する。<br>さらに、前日が日曜であり、前日が祝日である場合には振替休日と判定する。最終的に、判定された祝日名または振替休日名を返す。

    - プログラムの最後では、POSTリクエストで送信された年、月、日の値が存在する場合にのみ実行される。<br>指定された年月日に基づいてカレンダーを計算し、結果を出力する。また、各日付に対して祝日や振替休日がある場合は、それを出力する。

6. コーディング規約
    + 命名規則: 変数や関数名にはキャメルケースを使用しており、わかりやすい名前を付けるようにしている。<br>例えば、calculateCalendarやgetWeekdayなどの関数名、$fixedHolidaysや$holidayNameなどの変数名が該当する。

    + インデントとスペース: インデントにはスペースを使用し、通常は4つのスペースで1レベルのインデントを行っている。<br>これにより、コードの階層構造が視覚的にわかりやすくなっている。

    + 括弧の位置: 制御構造（if文やforeach文など）の括弧は、開始行の末尾に置かれるスタイルを採用している。例えば、if文の条件式の後ろに括弧を配置している。

    + コメント: コードの可読性を高めるために、適切な場所にコメントを追加している。関数の役割や処理の概要などがコメントで説明されている。

    + 条件分岐: 条件分岐の際には、等価比較演算子（==）を使用している。また、条件分岐の複数の条件はifとelse ifで連鎖させている。

    + コードの組織化: 関数を使って機能を分割し、それぞれの関数が特定の機能を担当するようにしている。これにより、コードの再利用性や保守性が向上する。

