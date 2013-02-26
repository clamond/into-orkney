<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

	<div class="mainContent">
		<div class="topArea">
			<?php 
			$as = new Area('Top Area');
			$as->display($c);
			?>		
		</div>
		<div class="mainArea">
			<?php 
			$as = new Area('Main Content');
			$as->display($c);
			?>		
		</div>

	</div>

<?php  $this->inc('elements/footer.php'); ?>