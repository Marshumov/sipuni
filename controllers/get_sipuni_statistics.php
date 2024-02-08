<?php
    $url = "https://sipuni.com/api/statistic/export";
    //Тип звонка
    //0 — Все звонки
    //1 — Входящий
    //2 — Исходящий
    //3 — Внутренний
    $type = '0';

    //Статус звонка
    //0 — Все звонки
    //1 — Пропущенный
    //2 — Принятый
    $state = '0';

    $tree = '';
    $rating = '0';

    //Отображать ID схемы
    //0 - Нет
    //1 - Да
    $showTreeId = '1';
    $fromNumber = '';
    $numbersRinged = 0;
    $numbersInvolved = 0;
    $names = 0;
    $outgoingLine = 1;
    $toNumber = '';
    $toAnswer = '';
    $anonymous = '1';
    $firstTime = '0';
    $dtmfUserAnswer = 0;
    $hangupinitor = '1';
    $ignoreSpecChar = '1';
    //Подсчет хэша
    $hashString = join('+', array($anonymous, $dtmfUserAnswer, $firstTime, $from, $fromNumber, $hangupinitor, $ignoreSpecChar, $names, $numbersInvolved, $numbersRinged, $outgoingLine, $rating, $showTreeId, $state, $timeFrom, $timeTo, $to, $toAnswer, $toNumber, $tree, $type, $user, $secret));
    $hash = md5($hashString);

    $query = http_build_query(array(
        'anonymous' => $anonymous,
        'dtmfUserAnswer' => $dtmfUserAnswer,
        'firstTime' => $firstTime,
        'from' => $from,
        'fromNumber' => $fromNumber,
        'hangupinitor' => $hangupinitor,
        'ignoreSpecChar' => $ignoreSpecChar,
        'names' => $names,
        'numbersInvolved' => $numbersInvolved,
        'numbersRinged' => $numbersRinged,
        'outgoingLine' => $outgoingLine,
        'rating' => $rating,
        'showTreeId' => $showTreeId,
        'state' => $state,
        'timeFrom' => $timeFrom,
        'timeTo' => $timeTo,
        'to' => $to,
        'toAnswer' => $toAnswer,
        'toNumber' => $toNumber,
        'tree' => $tree,
        'type' => $type,
        'user' => $user,
        'hash' => $hash,
    ));
    echo $url."?".$query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    //$csv= file_get_contents($file);
    $sipuni_statistics = array_map("str_getcsv", explode("\n", $output));
    array_shift($sipuni_statistics);
   

  //  print_r($sipuni_statistics);
   // $json_statistics = json_encode($sipuni_statistics);

?>