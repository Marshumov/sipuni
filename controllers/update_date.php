<?php

//проверяем, что сохранение данных в БД успешно
if($checkSaveBD) {
//проверяем, существует ли в БД данная таблица и запись в ней
    if($first_work) {
        //Если таблицы не существует, то создает её. В качестве 
        $update_info = R::dispense('updateinfo');
    }
    $update_info ->project = $project;
    $update_info ->last_date = $to;
    $update_info ->last_time = $time;
    R::store($update_info);
    $checkUpdateTime = true;
}

?>