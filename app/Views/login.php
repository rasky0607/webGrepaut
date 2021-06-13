<!--We indicate where is the layout that will use-->
<?= $this->extend('layouts/login')?>
<?= $this->section('content')?>
<?php
if (!empty($error)) {
?>
	<div class="d-flex mb-3 errormsg">
		<span><?= $error?></span>
	</div>
<?php
}
?>
<?= $this->endSection()?>  