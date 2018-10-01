<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<h2 class="contentheading"><?php echo $this->title; ?></h2>

<?php
if (isset($this->message) and (!empty($this->message))) {
	echo "<div class='moduletable' style='line-height: 1em; border: 1px solid #E6E3D9; padding: 8px 12px; margin: 0 10px 0 0'>
		<pre>{$this->message}</pre>
		</div>";
}

?>

<?php // echo "<pre>" . print_r($this->subst, true) . "</pre>"; ?>
<ul>
<?php

if (isset($this->results) and (!empty($this->results))) {
	echo "<div class='moduletable' style='line-height: 1em; border: 1px solid #E6E3D9; padding: 8px 12px; margin: 0 10px 0 0'>
		<pre>{$this->results}</pre>
		</div>";
}

foreach ($this->results as $key=>$listing) {
	echo "<div style='margin-top:10px;'>{$listing->title}</div>";
	// echo "<pre>" . print_r($result, true) . "</pre>";
	// $encoded_spec = urlencode($result->specialty);

/*
	if ($this->base) {
		echo "<li><a href='". 
			JRoute::_("index.php?option=com_specialty&view=speclist&specialty_id={$result->id}") .
			"'>{$result->specialty} Jobs</a></li>";
	} else {
		echo "<li><a href='" . 
			JRoute::_("index.php?option=com_specialty&view=specpage&specialty_id={$result->specialty_id}&city_id={$result->city_id}") .
			"'>{$result->specialty} Jobs in {$result->city}</a></li>";
	}
*/
}
?>
</ul>
