<?php

namespace App\Libraries;

class Calendar
{

    private function _div($a, $b)
    {
        return (int) ($a / $b);
    }

    public function gregorianToJalali($g_y, $g_m, $g_d, $str)
    {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

        $gy = $g_y - 1600;
        $gm = $g_m - 1;
        $gd = $g_d - 1;

        $g_day_no = 365 * $gy + $this->_div($gy + 3, 4) - $this->_div($gy + 99, 100)
         + $this->_div($gy + 399, 400);

        for ($i = 0; $i < $gm; ++$i) {
            $g_day_no += $g_days_in_month[$i];
        }
        if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0))) {
            $g_day_no++;
        }
        $g_day_no += $gd;

        //$j_day_no = $g_day_no - 79;

        $j_np = $this->_div($g_day_no - 79, 12053);
        $j_day_no = ($g_day_no - 79) % 12053;

        $jy = 979 + 33 * $j_np + 4 * $this->_div($j_day_no, 1461);

        $j_day_no %= 1461;

        if ($j_day_no >= 366) {
            $jy += $this->_div($j_day_no - 1, 365);
            $j_day_no = ($j_day_no - 1) % 365;
        }

        for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) {
            $j_day_no -= $j_days_in_month[$i];
        }
        $jm = $i + 1;
        $jd = $j_day_no + 1;
        if ($str) {
            return $jy . '/' . $jm . '/' . $jd;
        }
        return array($jy, $jm, $jd);
    }

    public function jalaliToGregorian4param($j_y, $j_m, $j_d, $str)
    {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

        $jy = (int) ($j_y) - 979;
        $jm = (int) ($j_m) - 1;
        $jd = (int) ($j_d) - 1;

        $j_day_no = 365 * $jy + $this->_div($jy, 33) * 8
         + $this->_div($jy % 33 + 3, 4);

        for ($i = 0; $i < $jm; ++$i) {
            $j_day_no += $j_days_in_month[$i];
        }

        $j_day_no += $jd;

        //$g_day_no = $j_day_no + 79;

        $gy = 1600 + 400 * $this->_div($j_day_no + 79, 146097);
        $g_day_no = ($j_day_no + 79) % 146097;

        $leap = true;
        if ($g_day_no >= 36525) {
            $g_day_no--;
            $gy += 100 * $this->_div($g_day_no, 36524);
            $g_day_no = $g_day_no % 36524;

            if ($g_day_no >= 365) {
                $g_day_no++;
            } else {
                $leap = false;
            }

        }

        $gy += 4 * $this->_div($g_day_no, 1461);
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = false;

            $g_day_no--;
            $gy += $this->_div($g_day_no, 365);
            $g_day_no = $g_day_no % 365;
        }

        for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++) {
            $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
        }

        $gm = $i + 1;
        $gd = $g_day_no + 1;
        if ($str) {
            return $gy . '-' . $gm . '-' . $gd;
        }

        return array($gy, $gm, $gd);
    }

    public function jalaliToGregorian($jalali_date)
    {
        if (empty($jalali_date)) {
            return '';
        }
        
        $date_array = explode('/', $jalali_date);
        return $this->jalaliToGregorian4param(
            $date_array[0],
            $date_array[1],
            $date_array[2],
            true
        );
    }

    public function compareDate($_date_mix_jalaly, $_date_mix_gregorian)
    {
        $_date_arr_jalaly = explode('/', $_date_mix_jalaly);
        $_date_arr_gregorian = explode('/', $_date_mix_gregorian);

        $arr_jtg = $this->jalaliToGregorian4param(
            $_date_arr_jalaly[0], $_date_arr_jalaly[1], $_date_arr_jalaly[2], false
        );

        if ($_date_arr_gregorian[0] > $arr_jtg[0]) {
            return false;
        } else if ($_date_arr_gregorian[0] == $arr_jtg[0]
            && $_date_arr_gregorian[1] > $arr_jtg[1]
        ) {
            return false;
        } else if ($_date_arr_gregorian[0] == $arr_jtg[0]
            && $_date_arr_gregorian[1] == $arr_jtg[1]
            && $_date_arr_gregorian[2] > $arr_jtg[2]
        ) {
            return false;
        }
        return true;
    }
}
