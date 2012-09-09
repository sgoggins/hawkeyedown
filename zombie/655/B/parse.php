<?php

/* -------------------------------------------------- */
/* Okay, now we're serious about this - loop through  */
/* the retrieved query results and do something       */
/* meaningful with them.                              */
/* -------------------------------------------------- */

/* Establish counters for array element */

$count1 = count($ary_top1);
$count2 = count($ary_top2);
$count3 = count($ary_top3);
$count4 = count($ary_top4);
$count5 = count($ary_top5);

/* An admittedly ugly bit of coding that combines five  */
/* query result sets into one array for later use       */

$data = array();

for ($i=0; $i<$count1; $i++){
	for ($j=0; $j<$count2; $j++){	
		if ($ary_top1[$i][0] == $ary_top2[$j][0]) {
			for ($k=0; $k<$count3; $k++){	
				if ($ary_top1[$i][0] == $ary_top3[$k][0]) {
					for ($l=0; $l<$count4; $l++){	
						if ($ary_top1[$i][0] == $ary_top4[$l][0]) {
							for ($m=0; $m<$count5; $m++){	
								if ($ary_top1[$i][0] == $ary_top5[$m][0]) {
$data [] = array($ary_top1[$i][0], array($ary_top1[$i][2], $ary_top2[$j][2], $ary_top3[$k][2], $ary_top4[$l][2], $ary_top5[$m][2]));
								}
							}
						}
					}
				}
			}
		}						
	}				
}


/* Sort results array but maintain keys    */
/* Output the sorted keys to another array */
/* so that results are available greater   */
/* or lesser values                        */

$countd = count($data);

for ($d=0; $d<$countd; $d++){	

$t1 = $data[$d][1][0];
$t2 = $data[$d][1][1];
$t3 = $data[$d][1][2];
$t4 = $data[$d][1][3];
$t5 = $data[$d][1][4];

$sortme = array($t1, $t2, $t3, $t4, $t5);

sort($sortme);

$results = array();

$key = array_search($t1, $sortme);
$results[] =  $key;
$key = array_search($t2, $sortme);
$results[] =  $key;
$key = array_search($t3, $sortme);
$results[] =  $key;
$key = array_search($t4, $sortme);
$results[] =  $key;
$key = array_search($t5, $sortme);
$results[] =  $key;

/* Output a multidimensional array with the date     */
/* and associated values for each displayed colum n  */

$output [] = array($data[$d][0], array($results));

}

?>