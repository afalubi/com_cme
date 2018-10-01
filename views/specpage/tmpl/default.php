<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<h2 class="contentheading"><?php echo "{$this->job_spec->specialty} Jobs in {$this->job_spec->city}, {$this->job_spec->state_long}"; ?></h2>

<?php
if (isset($this->message) and (!empty($this->message))) {
	echo "<div class='moduletable' style='line-height: 1em; border: 1px solid #E6E3D9; padding: 8px 12px; margin: 0 10px 0 0'>
		<pre>{$this->message}</pre>
		</div>";
	}


$i = 0;
$vowels = array('a', 'e', 'i', 'o', 'u');
$anConnector = 'a';
$start = strtolower(substr($this->job_spec->specialty, 0, 1));
if (in_array($start, $vowels)) $anConnector = 'an';

$para = "<p>{$this->job_spec->specialty} jobs in {$this->job_spec->city} {$this->subst[$i++]} {$this->subst[$i++]} as a {$this->subst[$i++]} {$this->job_spec->specialty} board certification (or eligibility) and {$this->subst[$i++]} {$this->job_spec->state_long} {$this->subst[$i++]}. {$this->subst[$i++]} {$anConnector} {$this->job_spec->specialty} residency or fellowship in {$this->job_spec->state_long} is {$this->subst[$i++]} because it {$this->subst[$i++]} the physician is {$this->subst[$i++]} {$this->job_spec->state} {$this->subst[$i++]}.</p><p>{$this->job_spec->specialty} salaries for the {$this->job_spec->direction} region of the U.S., including {$this->job_spec->city}, {$this->job_spec->state}, {$this->subst[$i++]} around \${$this->job_spec->region_salary}. {$this->subst[$i++]} the {$this->subst[$i++]} average {$this->job_spec->specialty} salary is \${$this->job_spec->salary_mean}, meaning {$this->job_spec->specialty} jobs in {$this->job_spec->city} pay {$this->subst[$i++]} {$this->job_spec->salary_percent}% of the national {$this->subst[$i++]}.</p>";
$option1 = "<p>{$this->subst[$i++]} {$this->subst[$i++]}  insurance and {$this->subst[$i++]} of {$this->job_spec->state_long}, {$this->subst[$i++]} {$this->subst[$i++]} like {$this->subst[$i++]}.</p>";
$option2 = "<p>{$this->subst[$i++]}, the effect of {$this->subst[$i++]} on {$this->subst[$i++]} for {$this->job_spec->specialty} practices is {$this->subst[$i++]}.</p>";

echo $para;
if ($this->showOption1) echo $option1;
if ($this->showOption2) echo $option2;
?>

<?php // echo "<pre>" . print_r($this->subst, true) . "</pre>"; ?>
<?php 
echo "<h2>Major well-rated {$this->job_spec->specialty} employers in {$this->job_spec->city}, {$this->job_spec->state} include:</h2>";
foreach ($this->providers as $provider) {
	echo "<div style='margin-top:10px;'><a href='{$provider->url}'>{$provider->hospital_name}</a><br/>{$provider->address1}<br/>{$provider->city}, {$provider->state} {$provider->zip_code}<br/>{$provider->phone_number}</div>";
	// echo "<pre>" . print_r($provider, true) . "</pre>";
}

echo "<h2>Other physician job resources:</h2>";
echo "<ul>";
foreach ($this->resources as $resource) {
	echo "<li><a href='{$resource->url}'>{$resource->text}</a></li>";
}
echo "</ul>";

?>

