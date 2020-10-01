<?php
ini_set('max_execution_time', 600);
$timp = microtime(true);
//https://www.nonograms.org/search?name=&colors=0&colors_min=1&colors_max=10&width_min=5&width_max=8&height_min=5&height_max=8&rating_min=1&rating_max=10&complexity_min=1&complexity_max=10&coloring_min=0&coloring_max=100&symmetry_min=0&symmetry_max=100&numgrid_min=0&numgrid_max=50&sort=0
//$col = [[], [], [], [], [], [], [], [],[],[],[],[],[],[], [], [], [], [], [], [], [],[],[],[],[],[]];

// $row = [[2,6], [4,6], [2,2,1,1], [2,2,2], [4,1,1], [5,3], [5,4], [4],[1],[2,1],[3,1],[4,1]];
// $col = [[7], [1,4,3], [8,2], [8,1], [1,3], [3], [5], [4],[2,1],[3,2],[2,1,2],[7]];
// const LEN = 12;

//$col = [ [4], [2], [3],  [3], [1] ];
//$row = [ [2], [2,1], [4], [1,1], [1,1] ];
//const LEN = 5;

//
//$row = [[2], [4], [1,3], [5,2], [2,6,2], [6,2], [5,1], [1,1],[1,1],[2,1,1,2],[9],[5]];
//$col = [[4], [2,2,1], [4,2], [5,1], [10], [3,2], [3,2], [3,2],[8],[1,1],[3,2],[3,1]];
//const LEN = 12;


//  15*15
/*
$row = [[10,4], [7,1,1,2], [8,1,1,1], [10,1,1], [10,1,1], [10,1,1], [10,1,1], [4,1,1], [4,4], [10,4],[15],[2],[10,2],[10,3],[10,3]];
$col = [[7,2,3], [7,2,3], [7,2,3], [11,3], [11,3], [11,3], [11,3], [1,5,2,3], [1,4,2,3], [7,2,3],[2],[13],[1,3,3],[2,3,2],[11,2]];
const LEN = 15; // marimea imaginii
*/

// smile 11*11  https://www.nonograms.org/nonograms/i/80
/*
$row = [[5], [7], [9], [2,1,2], [11], [11], [2,5,2], [3,3], [3,3], [7],[5]];
$col = [[5], [7], [2,2,3], [3,3,3], [3,3,2], [7,2], [3,3,2], [3,3,3], [2,2,3], [7],[5]];
const LEN = 11; // marimea imaginii
*/

// umbrela
/*
$row = [[5], [9], [2,1,1,1,2], [1,1,1,1,1], [11], [1], [1], [1], [1], [1,1],[3]];
$col = [[3], [2, 1], [1,2], [3,1], [2,1], [11], [2,1,1], [3,1,2], [1,2], [2,1],[3]];
const LEN = 11; // marimea imaginii
*/
// 10*10 profesor
//
//$row = [[3], [4], [6], [1, 6], [3, 4], [5, 2], [1, 5, 1], [10], [8], [2, 2, 2]];
//$col = [[1], [3, 1], [1, 3, 3], [1, 1, 5], [10], [3, 5], [4, 3], [4, 4], [4, 3], [6]];
//const LEN = 10; // marimea imaginii
//

//motan 9*9   https://www.nonograms.org/nonograms/i/16976
//$row = [ [1,1,1], [5,1], [1,1,1,1], [5,1], [6,1], [7], [6],[1,3],[2,4] ];
//$col = [ [4], [1,2,1], [8], [1,4], [7,1], [5], [5],[4],[6] ];
//const LEN = 9; // marimea imaginii


// masina = 7*7 https://www.nonograms.org/nonograms/i/15707

$row = [ [5], [1,1], [1,2], [7], [1,3,1], [7], [1,1] ];
$col = [ [3], [4,2], [1,3],  [1,3], [1,4], [4,2], [3] ];
const LEN = 7; // marimea imaginii


// dragon = 8*8  https://www.nonograms.org/nonograms/i/10022
/*$row = [ [5], [1,1,4], [8], [2,1,1], [2], [2,1], [8],[3] ];
$col = [ [7], [1,6], [3,2],  [1,2,2], [3,1], [2,2], [2,1],[3,1] ];
const LEN = 8; // marimea imaginii
*/

$BitRow = []; // variantele favorabile pentru ROW - pentru fiecare pozitie
$BitCol = []; // variantele favorabile pentru COL - pentru fiecare pozitie


function prelungireCode($a /*int*/){ //1011 => 0000001011
    $a=strval($a);
    return str_pad($a, LEN, '0', STR_PAD_LEFT);
}

function bitGrup($a){ //11000111001111 => [ 11, 111, 1111 ]

    $z=explode('0', $a);
    $z=array_diff($z, [null]);
    $z=array_values($z);
    return $z;
}

//repartizarea variantelor posibile

$Initial = []; // combinatia posibila care fa fi verificata
$CountCol=[]; // cite combinatii intra in fiecare masivBitCol
$CountRow=[];
for($i=0; $i<LEN; $i++){$Initial[$i]='0'; $CountCol[$i]=0; $CountRow[$i]=0;}

echo "*programa este activa distribui valorile binarice <br><br>";
for($i=0; $i<2**LEN; $i++){


    $x=prelungireCode(decbin($i)); //1011 => 0000001011
    $array=bitGrup($x);  //11000111001111 => [ 11, 111, 1111 ]

    for($j=0; $j<count($array); $j++){ 	// ['11','111','1111'] => [2,3,4]
        $array[$j]=strlen($array[$j]);
    }

    for($k=0; $k<LEN; $k++){

        if ($array==$row[$k]){$BitRow[$k][]=$x; $CountRow[$k]++; }
        if ($array==$col[$k]){$BitCol[$k][]=$x; $CountCol[$k]++;}
        //  else {  if ($array==null){ $BitCol[$k][]=prelungireCode('0'); $CountCol[$k]++;}    }
    }

}
//

$prodC = array_product($CountCol);
echo "combinatii COL - INTIAL = $prodC ->" ;
print_r($CountCol);
echo "<br><br>";


$final=[]; // se salveaza rezultatul final
#############################################################################
// Filtru   Deplasare

function bit($a,$key){
    $b='';
    for ($i=0;$i<$a; $i++){ $b .= chr(98+$key);}
    return $b;
}

function filtruDeplasare ($masiv)
{
    $ver = [];

    for ($i = 0; $i < count($masiv); $i++) {
        $ver[$i] = bit($masiv[$i], $i);
    }

    $arr = implode('0', $ver);
    $right = str_pad($arr, LEN, '0');
    $left = str_pad($arr, LEN, '0', STR_PAD_LEFT);
    $registor = [];

    for ($i = 0; $i < LEN; $i++) {
        if ($right[$i]==$left[$i] & $right[$i] != '0') {$registor[$i]= '1';} else {$registor[$i]='0';}
    }
    $res_str = implode('', $registor);

    return $res_str;
}

//filtrarea lui BitCol si BitRow
for ($i = 0; $i < LEN; $i++) {


    $regR = filtruDeplasare($row[$i]); //  principala filtrare
    $regC = filtruDeplasare($col[$i]); //

    for ($j = 0; $j < LEN; $j++) {
        if ($regR[$j] == '1') {
            for ($k = 0; $k < count($BitCol[$j]); $k++) {
                if ($regR[$j] != $BitCol[$j][$k][$i]) {
                    unset($BitCol[$j][$k]);
                    $CountCol[$j]--;
                }
            }
            $BitCol[$j] = array_values($BitCol[$j]);

            for ($k = 0; $k < count($BitCol[$j]); $k++) {
                if ($regR[$j] != $BitCol[$j][$k][$i]) {
                    unset($BitCol[$j][$k]);
                    $CountCol[$j]--;
                }
            }
            $BitCol[$j] = array_values($BitCol[$j]);

        } //final filtrarea BitCol
    }


    for ($j = 0; $j < LEN; $j++) {
        if ($regC[$j] == '1') {
            for ($k = 0; $k < count($BitRow[$j]); $k++) {
                if ($regC[$j] != $BitRow[$j][$k][$i]) {
                    unset($BitRow[$j][$k]);
                    $CountRow[$j]--;
                }
            }
            $BitRow[$j] = array_values($BitRow[$j]);

            for ($k = 0; $k < count($BitRow[$j]); $k++) {
                if ($regC[$j] != $BitRow[$j][$k][$i]) {
                    unset($BitRow[$j][$k]);
                    $CountRow[$j]--;
                }
            }
            $BitRow[$j] = array_values($BitRow[$j]);

        } //final filtrarea BitRow
    }
}

#############################################################################

$prodC = array_product($CountCol);
echo "combinatii COL - FILTRU ONE = $prodC ->" ;
print_r($CountCol);
echo "<br>"; echo "<br>";


function filtruZero($masiv){ // exemplu $BitRow[0]
    $x = [];
    for($i=0; $i<LEN; $i++){ $x[$i]=0;} //initierea masivului

    for($k=0; $k<count($masiv); $k++){ // sumeaza numerele din coloana
        for($j=0; $j<LEN; $j++){
            $x[$j] += $masiv[$k][$j];
        }
    }
    for($i=0; $i<LEN; $i++){
        if ($x[$i]!=0) {$x[$i]='a';}
    }
    return implode('', $x);
} // 000aaaa000a

//mai sus corect

for ($i = 0; $i < LEN; $i++) {

    $regR = filtruZero($BitRow[$i]); //  string aaaa0a0
 /**/ // echo $regR . "<br>";
    for ($j = 0; $j < LEN; $j++) {

        if ($regR[$j] == '0') {

            for ($k = 0; $k < count($BitCol[$j]); $k++) {
                if ( $regR[$j] != $BitCol[$j][$k][$i]) {
                    unset($BitCol[$j][$k]);
                    $CountCol[$j]--;
                }
            }
            $BitCol[$j] = array_values($BitCol[$j]);

            for ($k = 0; $k < count($BitCol[$j]); $k++) {
                if ( $regR[$j] != $BitCol[$j][$k][$i]) {
                    unset($BitCol[$j][$k]);
                    $CountCol[$j]--;
                }
            }
            $BitCol[$j] = array_values($BitCol[$j]);

        } //final filtrarea BitCol
    }
}

###############################################################################

$prodC = array_product($CountCol);
echo "combinatii COL - FILTRU ZERO = $prodC ->" ;
print_r($CountCol);
echo "<br><br>";


//verificarea variantelor veridice

for($i=$prodC-1; $i>=0; $i--){
    {

        //
        for($n=0; $n<LEN; $n++){ //
            $a=str_split($BitCol[$n][$Initial[$n]]);
            for($m=0; $m<LEN; $m++){ $final[$m][$n]=$a[$m];	}
        }

        $check=0;
        //
        for($n=0; $n<LEN; $n++){
            $help='';
            for($m=0; $m<LEN; $m++){ $help .= $final[$n][$m]; }
            if(!in_array($help, $BitRow[$n])) {$check=0; break;} else
            {$check=1;  }

        }

        if($check==1){

            for($n=0; $n<LEN; $n++){
                for($m=0; $m<LEN; $m++){

                    if ($final[$n][$m]=='1'){$final[$n][$m]='#';} else
                    {$final[$n][$m]='~';}
                    echo $final[$n][$m];
                }
                echo "<br>";
            }
            echo microtime(true)-$timp;  break;//  echo "<br>";
        }

        //
        $Initial[LEN-1]++;
        for($k=LEN-1; $k>0; $k--){

            if($Initial[$k]==$CountCol[$k]){

                $Initial[$k]=0;
                $Initial[$k-1]++;
            }
        }
    }
}

