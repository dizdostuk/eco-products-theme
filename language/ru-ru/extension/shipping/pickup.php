<?php
// Text
$_['text_title']       = 'Самовывоз';

if(date("D", time()) == "Fri") {
  $date = new DateTime();
  date_add($date, date_interval_create_from_date_string('8 days'));
  $_['text_description'] = 'Доставка на следующую субботу ' . date_format($date, 'Y-m-d');
} else {
  $_['text_description'] = 'Доставка на следующую субботу ' . date('d-m-Y', strtotime('next saturday'));
}

