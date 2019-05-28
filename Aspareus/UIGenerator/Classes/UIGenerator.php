<?php
  class UIGenerator
  {
     public function GenerateInput ($type,$name,$value,$placeholder) {
         echo '<input type="'.$type.'" placeholder="'.$placeholder.'" name="'.$name.'" value="'.$value.'">';
     }

     public function GenerateInputRequired ($type,$name,$value,$placeholder) {
        echo '<input class="'.$class.'" type="'.$type.'" placeholder="'.$placeholder.'" name="'.$name.'" value="'.$value.'" required>';
     }

     public function GenerateInputWithClass ($type,$name,$value,$class,$placeholder) {
         echo '<input class="'.$class.'" placeholder="'.$placeholder.'" type="'.$type.'" name="'.$name.'" value="'.$value.'" >';
     }

     public function GenerateInputWithClassRequired ($type,$name,$value,$class,$placeholder) {
         echo '<input class="'.$class.'" placeholder="'.$placeholder.'" type="'.$type.'" name="'.$name.'" value="'.$value.'" required>';
     }

     public function GenerateCheckbox ($name,$label,$value,$checked) {
       if($checked == true)
       {
         echo '
          <input type="radio" name="'.$name.'" value="'.$value.'" checked="checked" />
          <label>'.$label.'</label>
         ';
       } else {
         echo '
          <input type="radio" name="'.$name.'" value="'.$value.'"/>
          <label>'.$label.'</label>
         ';
       }
     }

     public function GenerateCheckboxWithId ($name,$label,$value,$checked,$id) {
       if($checked == true)
       {
         echo '
          <input type="radio" name="'.$name.'" value="'.$value.'" checked="checked" id="'.$id.'"/>
          <label for="'.$id.'">'.$label.'</label>
         ';
       } else {
         echo '
          <input type="radio" name="'.$name.'" value="'.$value.'" id="'.$id.'"/>
          <label for="'.$id.'">'.$label.'</label>
         ';
       }
     }

     public function GenerateCheckboxWithClass ($name,$label,$value,$checked,$class) {
       if($checked == true)
       {
         echo '
          <input type="radio" name="'.$name.'" value="'.$value.'" class="'.$class.'" checked="checked"/>
          <label class="'.$class.'">'.$label.'</label>
         ';
       } else {
         echo '
          <input type="radio" name="'.$name.'" value="'.$value.'" class="'.$class.'"/>
          <label class="'.$class.'">'.$label.'</label>
         ';
       }
     }

     public function GenerateCheckboxWithClassWithId ($name,$label,$value,$checked,$class,$id) {
       if($checked == true)
       {
         echo '
          <input type="radio" name="'.$name.'" value="'.$value.'" class="'.$class.'" checked="checked" id="'.$id.'"/>
          <label for="'.$id.'" class="'.$class.'">'.$label.'</label>
         ';
       } else {
         echo '
          <input type="radio" name="'.$name.'" value="'.$value.'" id="'.$id.'" class="'.$class.'" />
          <label for="'.$id.'" class="'.$class.'">'.$label.'</label>
         ';
       }
     }

     public function GenerateCustomElement ($element,$value) {
         echo '<' . $element . '>' . $value .'</'.$element.'>';
     }

     public function GenerateCustomElementWithClass ($element,$value,$class) {
         echo '<' . $element . ' class="'.$class.'">' . $value .'</'.$element.'>';
     }

     public function GenerateCustomInput ($element,$custom,$value,$class) {
         echo '<' . $element . ' '.$custom.' class="'.$class.'">' . $value .'</'.$element.'>';
     }

     public function GenerateCustomInputWithClass ($element,$custom,$value,$class) {
         echo '<' . $element . ' '.$custom.' class="'.$class.'">' . $value .'</'.$element.'>';
     }

     public function GenerateCustomInputRequired ($element,$custom,$value,$class) {
         echo '<' . $element . ' '.$custom.' class="'.$class.'">' . $value .'</'.$element.' required>';
     }

     public function GenerateCustomInputWithClassRequired ($element,$custom,$value,$class) {
         echo '<' . $element . ' '.$custom.' class="'.$class.'">' . $value .'</'.$element.' required>';
     }

     public function GenerateTable ($rowTitles,$rows) {
         echo '<table>';
         $numRow = 0;

         echo '<tr>';
           foreach ($rowTitles as $rowTitle) {
             echo '<th>'.$rowTitle.'</th>';
             $numRow++;
           }
         echo '</tr>';

         for ($i=0; $i < count($rows); $i = $i + $numRow) {
           echo '<tr>';
             for ($n=0; $n < $numRow ; $n++) {
              echo ' <td>'.$rows[($i) + $n].'</td>';
             }
           echo '</tr>';
         }
         echo '</table>';
     }

     public function GenerateTableWithClass ($rowTitles,$rows,$class) {
         echo '<table class="'.$class.'" >';
         $numRow = 0;

         echo '<tr>';
           foreach ($rowTitles as $rowTitle) {
             echo '<th>'.$rowTitle.'</th>';
             $numRow++;
           }
         echo '</tr>';

         for ($i=0; $i < count($rows); $i = $i + $numRow) {
           echo '<tr>';
             for ($n=0; $n < $numRow ; $n++) {
              echo ' <td>'.$rows[($i) + $n].'</td>';
             }
           echo '</tr>';
         }
         echo '</table>';
     }

     public function GenerateLink ($url,$text) {
      echo '<a href="'.$url.'">'.$text.'</a>';
     }

     public function GenerateLinkWithClass ($url,$text,$class) {
      echo '<a href="'.$url.'" class="'.$class.'">'.$text.'</a>';
     }

     public function GenerateLinkWithIcon ($url,$text,$icon) {
      echo '<a href="'.$url.'">
      <img src="'.$icon.'" alt="'.$text.' image"> <br>
      '.$text.'
      </a>';
     }

     public function GenerateLinkWithIconWithClass ($url,$text,$icon,$class) {
       echo '<a href="'.$url.'" class="'.$class.'">
       <img src="'.$icon.'" alt="'.$text.' image"> <br>
       '.$text.'
       </a>';
     }

     public function StartFormAutomatic ($methodType) {
        $this->startForm($_SERVER['REQUEST_URI'],$methodType);
     }

     public function StartFormManual ($action,$methodType) {
         $this->startForm($action,$type);
     }

     private function startForm ($action,$methodType) {
       echo '<form action="'.$action.'" method="'.$methodType.'" >';
     }

     public function EndForm () {
        echo '</form>';
     }

     public function StartClass ($class) {
        echo '<div class="'.$class.'">';
     }

     public function EndClass () {
        echo '</div>';
     }

     public function StartGridView () {
          echo ' <div class="GridViewWrapper" ><div>';
     }

     public function EndGridView () {
          echo '</div>';
     }
  }
?>
