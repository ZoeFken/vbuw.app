
	<span class="h1"><?php echo $this->lang->line('welkom'); ?> </span><span class="text-muted h4"><?php echo $this->lang->line('docVersion'); ?></span>
	<?php 
		// echo '<pre>';
		// var_dump($this->session->all_userdata()); 
		// echo '</pre>';
	?>
	<br><br>
	<div id="body">
		<p><?php echo $this->lang->line('text_1'); ?></p>
		<p class="text-center"><code><a href="mailto:pieter-jan.casteels@tucrail.be"><?php echo $this->lang->line('creator'); ?></a></code></p>
		<p><?php echo $this->lang->line('reglementering'); ?></p>
		<p><?php echo $this->lang->line('melding'); ?></p>
		<div class="mail-block">
			<p>Zoals gevraagd door enkele collega's heb ik het document S505 toegevoegd aan vbuw.app. Dit is functioneel. Indien je bugs vindt of een aanpassing wenst -> mail me.</p>
		</div>
		<div class="mail-block">
			<code>10-02-2021</code>
			<p>Ik had gehoopt dat we tegen dit moment een permanente oplossing zouden gekregen hebben van Tucrail voor de support en onderhoude van de site. Spijtig genoeg is dit niet het geval. De site is niet gratis om online te blijven en kost me wel iets. Het eerste jaar heb ik dit betaalt. Maar ik hoop dat ik nu mag vragen aan de gebruikers om een kleine donatie te doen. Dit is niet verplicht, ik doe dit met alle plezier.</p>
			<div class="progress">
				<div class='money'><p>0 €</p></div>
				<div class="progress-bar">
					<span class="progress-bar-fill" style="width: 37%;">37%</span>
				</div>
				<div class='money'><p>132,91 €</p></div>
			</div><br>
			<p>Bedankt aan de enkelingen die hebben gesponserd. De totale kost voor dit jaar bedraagt 132,91 EUR.</p>
		<form action="https://www.paypal.com/donate" method="post" target="_top">
			<input type="hidden" name="business" value="pjcasteels@gmail.com" />
			<input type="hidden" name="item_name" value="upkeep en onderhoud van vbuw.app" />
			<input type="hidden" name="currency_code" value="EUR" />
			<input type="image" src="https://vbuw.app/assets/images/supportpp.jpg" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Doneren met PayPal-knop" />
			<img alt="" border="0" src="https://www.paypal.com/nl_BE/i/scr/pixel.gif" width="1" height="1" />
		</form>
		</div>
		<div class="mail-block">
			<code>21-11-2020</code>
			<p>Ik heb een rollback moeten doen van het systeem. Hierdoor zijn enkele documenten verwijderd geweest. Hiervoor mijn oprechte excuses.</p>
			<p>Normaal zou alles terug moeten functioneren zoals voordien.</p>
		</div>
	</div>