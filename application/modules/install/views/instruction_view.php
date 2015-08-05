<img src="<?php echo base_url('assets/admin/icons');?>/calendar-icon.png" style="width:260px;height:18-px;" />
<p class="lead">Let's install BookIt with in 2 easy step :-)</p>
<ol>
	<li>Database setup</li>
	<li>Account setup</li>
</ol>
<?php 
$error = check_config();

if($error!='')
	echo $error;
else
{
	echo '<p><a class="btn" href="'.site_url('install/dbsetup').'">Continue</a> to the next step.</p>';
}
?>