<?php
// Text
$_['text_title']       = 'Фиксированная стоимость доставки';


if(date("D", time()) == "Tue") {
  $date = new DateTime();
  date_add($date, date_interval_create_from_date_string('8 days'));
  $_['text_description'] = 'Доставка на следующий вторник ' . date_format($date, 'Y-m-d');
} else {
  $_['text_description'] = 'Доставка на следующий вторник ' . date('d-m-Y', strtotime('next tuesday'));
}


