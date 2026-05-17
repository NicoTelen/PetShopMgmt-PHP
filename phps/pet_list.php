<?php
// Static pet list since we use Node.js API now
$pets = ['Dog', 'Cat', 'Bird', 'Fish'];
foreach ($pets as $pet) {
    echo '<option value="' . $pet . '" id="' . $pet . '">' . $pet . '</option>';
}
?>