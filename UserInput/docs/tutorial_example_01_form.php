<form action='tutorial_example_01.php'>
First name: <input type='text' name='firstName' value='<?php echo $property_firstName; ?>'/><?php echo $warning_firstName; ?><br/>
Last name: <input type='text' name='lastName' value='<?php echo $property_lastName; ?>'/><?php echo $warning_lastName; ?><br/>
Age: <input type='text' name='age' value='<?php echo $property_age; ?>'/><?php echo $warning_age; ?><br/>
E-mail: <input type='text' name='email' value='<?php echo $property_email; ?>'/><?php echo $warning_email; ?><br/>
<input type='submit' value='submit'/><br/>
</form>
<?php
// just to make my test script happy
?>
