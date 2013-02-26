<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

	<div class="mainContent mainContentContact">
		<div class="info col1">
			<div class="heading">Contact Us</div>
			<div class="detail">
<img src="/themes/intoOrkney/i/c_phone.png" width="45" height="45"/>
<div class="txt"><?php $as = new Area('Phone Number'); $as->display($c);	?></div>
<div class="clearfix"></div>
			</div>
			<div class="detail">
<img src="/themes/intoOrkney/i/c_email.png" width="45" height="45"/>
<div class="txt"><?php $as = new Area('Email'); $as->display($c);	?></div>
<div class="clearfix"></div>
			</div>
			<div class="detail">
<img src="/themes/intoOrkney/i/c_mail.png" width="45" height="45"/>
<div class="txt"><?php $as = new Area('Postal'); $as->display($c);	?></div>
<div class="clearfix"></div>
			</div>
		</div>
		<div class="info col2">
			<div class="heading">...Or Get Involved</div>
			<div class="detail">
<img src="/themes/intoOrkney/i/c_flickr.png" width="75" height="75"/>
<div class="txt"><?php $as = new Area('Upload Picture'); $as->display($c);	?></div>
<div class="clearfix"></div>
			</div>
			<div class="detail">
<img src="/themes/intoOrkney/i/c_tweet.png" width="75" height="75"/>
<div class="txt"><?php $as = new Area('Tweet'); $as->display($c);	?></div>
<div class="clearfix"></div>
			</div>
			<div class="detail">
<img src="/themes/intoOrkney/i/c_video.png" width="75" height="75"/>
<div class="txt"><?php $as = new Area('Upload Video'); $as->display($c);	?></div>
<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

<?php  $this->inc('elements/footer.php'); ?>