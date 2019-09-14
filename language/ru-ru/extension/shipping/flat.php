<?php
// Text
$_['text_title']       = 'Фиксированная стоимость доставки';


if(date("D", time()) == "Tue") {
  $date = new DateTime();
  date_add($date, date_interval_create_from_date_string('8 days'));
  $_['text_description'] = 'Доставка на среду ' . date_format($date, 'd m Y') . ' (Доставка на ближайщую среду не доступна!)';
} else {
  $_['text_description'] = 'Доставка на следующую среду ' . date('d m Y', strtotime('next wednesday'));
}


