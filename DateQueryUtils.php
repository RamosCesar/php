<?php

class DateQueryUtils {
  // Returns a range of dates by months in Array/SQL format
  public function getRangeByMonth($date1 = NULL, $date2 = NULL){
    if ($this->validateDate($date1,$date2)) {
      $start  = $month = strtotime($date1);
      $end    = strtotime($date2);
      $result = array();
      $count  = 0;

      while($month <= $end) {
        if ($count == 0) {
          $result[$count]['start'] = date('Y-m-d H:i:s', $month);
        }
        else {
          $result[$count]['start'] = date('Y-m-01 H:i:s', $month);
        }
        $result[$count]['month']  = $this->trMonthToEs(date('F', $month));
        $result[$count]['year']   = date('Y', $month);
        $result[$count]['end']    = date('Y-m-t 23:59:59', $month);
        $month                    = strtotime("+1 month", $month);
        $count++;
      }
      $result[$count-1]['end'] = date('Y-m-d 23:59:59', $end);
      return $result;
    }
    else {
      return FALSE;
    }
  }

  private function validateDate($date1 = NULL, $date2 = NULL){
    if (isset($date1) && isset($date2)) {
      $datetime1  = date_create($date1);
      $datetime2  = date_create($date2);
      $interval   = date_diff($datetime1, $datetime2);
      if (is_object($interval) && $interval->format('%R') === '+' && $interval->format('%a') <= 18000) {
        return TRUE;
      }
    }
    return FALSE;
  }

  private function trMonthToEs($month = NULL){
    $months = array(
      'January'   =>  'Enero',
      'February'  =>  'Febrero',
      'March'     =>  'Marzo',
      'April'     =>  'Abril',
      'May'       =>  'Mayo',
      'June'      =>  'Junio',
      'July'      =>  'Julio',
      'August'    =>  'Agosto',
      'September' =>  'Septiembre',
      'October'   =>  'Octubre',
      'November'  =>  'Noviembre',
      'December'  =>  'Diciembre',
    );
    if (isset($months[$month])) {
      return $months[$month];
    }
    else {
      return $month;
    }
  }
}
?>
