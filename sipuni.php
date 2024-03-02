<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    require_once "db.php";
    require_once "./config/config.php";
    require_once "./controllers/telegram_notification.php"; 
  //  telegram_post_notification("Тест", $telegram_token, $telegram_chat_id);
    $activeteTesting = false;
    //Добавлять ли в БД только уникальные звонки? 
    $unic = true;
    // Проверка , что сохранение прошло успешно
    $checkSaveBD = false;
    $checkUpdateTime = false; 
    //Базовые настройки получения времени
    $date = date('d.m.Y');
    $time = date('H.i');
    //Сколько новых данных получено
    $date_length = 0;
    function day_minus_step($date, $minus_day) {
        //Отнимаем несколько месяцев для получения истории данных
        return date('d.m.Y', strtotime("-".$minus_day." days", strtotime($date)));
    }   
    function date_minus_step($date, $minus_months) {
        //Отнимаем несколько месяцев для получения истории данных
        return date('d.m.Y', strtotime("-".$minus_months." months", strtotime($date)));
    }
    function time_minus_step($time, $minus_minutes) {
        //Отнимаем несколько минуту, чтобы не упустить данные
        return date('H.i', strtotime("-".$minus_minutes." minute", strtotime($time)));
    }
    //Дата от и до
    $from = $date;
    $to = $date;
    //Время от и до 
    $timeFrom = '00.00';
    $timeTo = $time;
    //Проверка, нужно ли создавать все таблицы при первом запуске программы.
    $first_work = false;
    R::freeze( false );
    $update_info = R::findOne('updateinfo', 'project = ?', array($project));
    sleep(2);
    if($update_info==null||$update_info=="") {
        $from = date_minus_step($date, $minus_months);
        $first_work = true;
        $timeFrom = '00.00';
        $timeTo = '23.59';
    }
    else {
        $last_time = $update_info -> last_time;
        $from = $update_info -> last_date;
        $timeFrom = time_minus_step($last_time, $minus_minutes);
    }
    if($activeteTesting) {
        $from = day_minus_step($date, "2");
        $timeFrom = '00.00';
        $timeTo = '23.59';
    }
    //Получаем данные
    //telegram_post_notification("Начинаю получать данные", $telegram_token, $telegram_chat_id);
    sleep(1);
    require_once "./controllers/get_sipuni_statistics.php";
    require_once "./controllers/save_sipuni_statistics.php";
    sleep(1);
    require_once "./controllers/update_date.php";
    require_once "./controllers/post_to_sheet.php";

?>
