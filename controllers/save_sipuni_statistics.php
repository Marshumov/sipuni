<?php
//Тип;Статус;Время;ID схемы звонка;Схема;Исходящая линия;Откуда;Куда;Кто ответил;Длительность звонка;Длительность разговора;Время ответа;Оценка;ID записи;Метка;Теги;Инициатор завершения звонка;ID заказа звонка;Запись существует;Новый клиент;Состояние перезвона;Время перезвона;Информация из CRM;Ответственный из CRM"   
    $array_with_data = [];
    $array_for_import = [];
 
    function save_in_BD($table, $line, $project) {
        $table -> project = $project;
        $table -> type = $line[0];
        $table -> status = $line[1];
        $table -> time = $line[2];
        $table -> idschema = $line[3];
        $table -> schema = $line[4];
        $table -> outgoingline = $line[5];
        $table -> fromphone = $line[6];
        $table -> tophone = $line[7];
        $table -> whoanswer = $line[8];
        $table -> durationall = $line[9];
        $table -> durationtalking = $line[10];
        $table -> idrecording = $line[13];
        $table -> idcall = $line[17];
        $table -> newclient = $line[19];
        $table -> mark = $line[14];
        return $table;   
    }
    $sipuni_statistics_count = count($sipuni_statistics);
    sleep(1);
    $batch_size = 100;
    for ($i = 0; $i < $sipuni_statistics_count; $i += $batch_size) {
        $batch = array_slice($sipuni_statistics, $i, $batch_size);
        foreach ($batch as $call) {
            if ($call[0] != null && $call[0] != '') {
                $sipuni_statistics_table = R::dispense('sipunistatisticstable');
                $line = explode(";", $call[0]);
                $checkPhone = false;
                $typeUnic = 'Входящий';
                $phone = str_replace("+", '', $line[6]);
                //СОХРАНЕНИЕ В БД:
                save_in_BD($sipuni_statistics_table, $line, $project);
                if($unic) {
                    $checkPhone = R::findOne('sipunistatisticstable', 'fromphone = ? AND type = ?', array($phone, $typeUnic));      
                }
                if(!$checkPhone||$checkPhone==""){
                // generate_new_array($sipuni_statistics_table);
                array_push($array_with_data, $sipuni_statistics_table);
                }
                R::store($sipuni_statistics_table);
                
            }
        }
        sleep(1);
    }
    $checkSaveBD = true;
    $date_length = count($array_with_data);
    $array_for_import = array(
        'data' => $array_with_data,
        'date_length' => $date_length,
        'spreadsheetId' => $google_table_id,
        'code_service_sheet' => $code_service_sheet
    );
    $json_data_import = json_encode($array_for_import);
    /*
    echo "<br>";
    echo "Сохранение окончено, длина массива для импорта и он сам:";
    echo "<br>";
    echo $date_length;
    echo "<br>";
    print_r($array_for_import); 
    echo "<br>";
    echo "<br>";
    echo "json_data_import";
    echo "<br>";
    print_r($json_data_import); 
    echo "<br>";
    */
?>