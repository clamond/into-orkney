<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>


<div class="footer">
	<div class="footMenu">
		<?php 
		$as = new Area('Foot Menu');
		$as->display($c);
		?>
		<p>website by <a href="http://www.coplasystems.com" target="_blank">copla</a></p>
		<p><a title="Terms of Use" href="/terms-use">Terms of Use</a> <a title="Privacy Policy" href="/privacy-policy">Privacy Policy</a></p>		
	</div>
</div>

<script src="<?=$this->getThemePath()?>/js/plugins.js"></script>
<script src="<?=$this->getThemePath()?>/js/main.20121218.js"></script>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

<?php  Loader::element('footer_required'); ?>
</div></div>
</body>
</html>