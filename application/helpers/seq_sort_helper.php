<?php
//arr为2维数组
	public function seq_sort($arr,$seq='seq'){
		$c_arr = count($arr);
		$temp = array();
			for ($i = 0; $i < $c_arr; $i++) {
				for ($j = 0; $j < $c_arr - $i - 1; $j++) {
					if ($arr[$j][$seq] > $arr[$j + 1][$seq]) {
						$temp = $arr[$j];
						$arr[$j] = $arr[$j + 1];
						$arr[$j + 1] = $temp;
					}
				}
			}
		return $arr;
	}
?>