<?php
// Text
$_['text_title']       = 'Самовывоз';

if(date("D", time()) == "Fri") {
  $date = new DateTime();
  date_add($date, date_interval_create_from_date_string('8 days'));
  $_['text_description'] = 'Доставка на субботу ' . date_format($date, 'd m Y') . ' (Доставка на ближайщую субботу не доступна!)';
} else {
  $_['text_description'] = 'Доставка на следующую субботу ' . date('d m Y', strtotime('next saturday'));
}

