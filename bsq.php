<?php
class need_a_square
{
  public $nbr_ligne;
  public $size_ligne;
  public $big;
  public $first;
  public $posibility_size = false;
  public $coord_for_the_bigest_col = 0;
  public $coord_for_the_bigest_row = 0;
  public $size_of_the_bigest = 0;

  public function __construct($filePath){
    $this->load_2d_arr_from_file($filePath);
  }

  public function load_2d_arr_from_file($file){
    $handle = fopen($file, "r");
    $big = array();
    $p = '';
    $a = 0;
    $b = 0;
    $temoin = true;
    $nbr_ligne = fgets($handle);
    $this->nbr_ligne = intval($nbr_ligne);
    while (!feof($handle)) {
      $p = fgetc($handle);
      if ($p == "\n") {
        $a = 0;
        if ($temoin) {
          $this->size_ligne = count($little);
          $temoin = false;
        }
        $big[$b++] = $little;
        $little = array();
      }
      else {
        $little[$a++] = $p;
      }
    }
    fclose($handle);
    $this->big = $big;
  }

  public function is_square_of_size($row , $col , $square_size){
    $big = $this->big;

    $target = $big[$row][$col];
    $a = 0;
    while($a < $square_size){
      $o = 0;
      while($o < $square_size){
        if (isset($big[$row + $a])) {
          if (isset($big[$row + $a][$col +$o])) {
            $target = $big[$row + $a][$col +$o++];
            if ($target == "o") {

              return (0);
            }
          }
          else {
            return(0);
          }
        }
        else {
            return (0);
        }
      }
      $a++;
    }
    return (1);
  }

  public function compare_fonding_biggest_square($row , $col, $size){
    if($this->first == false){ // on trouve pour la premiere fois un carre
      $this->first = true;
      $this->coord_for_the_bigest_col = $col;
      $this->coord_for_the_bigest_row = $row;
      $this->size_of_the_bigest = $size;
      return(1);
    }
    elseif($this->size_of_the_bigest < $size){ // on a trouver un carre plus grand
      $this->coord_for_the_bigest_col = $col;
      $this->coord_for_the_bigest_row = $row;
      $this->size_of_the_bigest = $size;
      return(1);
    }
    else{ // on a trouver un carre mais c pas le plus grand
      return(0);
    }
  }

  public function print_cross_in_the_bigest(){
    $a = 0;
    while ($a < $this->size_of_the_bigest) {
      $b = 0;
      while ($b < $this->size_of_the_bigest) {
        $this->big[$a + $this->coord_for_the_bigest_row][$this->coord_for_the_bigest_col+$b++] = "x";
      }
      $a++;
    }
    $this->display();
  }
  public function display(){
    foreach ($this->big as $key => $value) {
      foreach ($value as $key2 => $value2) {
        echo($value2);
      }
      echo "\n";
    }
  }
  public function find_biggest_square(){
    $a = 0;
    $potentiel = 0;
    while (isset($this->big[$a])) {
      $b = 0;
      foreach ($this->big[$a] as $key => $value) {
        if ( $value == ".") {
          $potentiel++;
        }
        elseif($value == "o") {
          if ($this->size_of_the_bigest < $potentiel) {
            $this->posibility_size = true;
          }
          $potentiel = 0;
        }
      }
      if ($potentiel == $this->size_ligne) {
          $this->posibility_size = true;
      }
      $potentiel = 0;
      if ($this->posibility_size == true) {

        $this->posibility_size = false;
        while (isset($this->big[$a][$b])) {
          $size = $this->size_ligne;
          while ($size >0) {
            $bool = $this->is_square_of_size($a, $b, $size--);
            if($bool){
               $bool = $this->compare_fonding_biggest_square($a, $b, ($size+1));
               if($bool){
                 $size = 0;
               }
            }
          }
          $b++;
        }
      }
      if($this->size_of_the_bigest > ($this->size_ligne / 2)){
        $this->print_cross_in_the_bigest();
        return;
      }
      if($this->size_of_the_bigest > ($this->nbr_ligne / 2) || $this->size_of_the_bigest > ($this->nbr_ligne - $a)) {
        $this->print_cross_in_the_bigest();
        return;
      }
      $a++;
    }
    $this->print_cross_in_the_bigest();
  }
}

$map = new need_a_square($argv[1]);
$map->find_biggest_square();


?>
