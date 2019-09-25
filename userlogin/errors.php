<?php
if (count($errors)>0 ) :
?>
<?php
foreach ($errors as $errors):
   echo "<p>$errors</p>";
endforeach;
?>
<?php endif ?>