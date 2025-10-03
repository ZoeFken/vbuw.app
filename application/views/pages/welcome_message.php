<span class="h1"><?php echo $this->lang->line('welkom'); ?> </span><span class="text-muted h4"><?php echo $this->lang->line('docVersion'); ?></span>
<?php
// echo '<pre>';
// var_dump($this->session->all_userdata()); 
// echo '</pre>'; https://zoefken.github.io/vbuw-locations/
?>
<br><br>
<div id="body">
	<p><?php echo $this->lang->line('text_1'); ?></p>
	<p class="text-center"><code><a href="mailto:pieter-jan.casteels@tucrail.be"><?php echo $this->lang->line('creator'); ?></a></code></p>
	<p><?php echo $this->lang->line('reglementering'); ?></p>
	<p><?php echo $this->lang->line('melding'); ?></p>
	<div class="mail-block">
		<code>26-07-2025</code>
		<p>Einde van VBUW.BE</p>
		<p>Hey iedereen, het afgelopen jaar(en) zie ik een afname van gebruik op vbuw.be. Dit voornamelijk door de opkomst van prodigis.</p>
		<p>Hierdoor heb ik besloten om de website te sluiten dit vanaf 08-03-2026. De kosten gepaard met onderhoud en upkeep wegen niet op tegen het weinige gebruik ervan.</p>
		<p>Ik zie wel dat er nog veel mensen de locaties gebruiken, ik heb dit in eerste instantie aan IT tuc gevraagd om dit te hosten. Wederom is dit niet gelukt. Echter niet getreurd, ik heb dit op een gratis platform kunnen zetten en heb zelf de functionaliteit uitgebreid.</p>
		<p>Je kan de nieuwe website vinden op <a href="https://zoefken.github.io/vbuw-locations/" target="_blank">https://zoefken.github.io/vbuw-locations/</a></p>
		<p>Hier kan je de locaties vinden, maar ook de mogelijkheid om deze te filteren op regio, type en meer.</p>
		<p>Ik wil iedereen bedanken voor het gebruik van de website. Het was een plezier om deze te onderhouden en te zien groeien.</p>
		<p>Ik hoop dat iedereen de nieuwe website ook kan waarderen.</p>
		<p>Met vriendelijke groeten, Pieter-Jan Casteels</p>
	</div>
	<br>
	<div class="mail-block" style="background-color: #dd5c1c !important;">
		<code>22-01-2025</code>
		<p>De tijd is weer daar om het onderhoud van de website te betalen. Voel je aub niet verplicht een bijdrage te leveren. Maar alle kleine beetjes helpen.</p>
		<p>Mits Prodigis zo zwaar aan het uitrollen is denk ik dat dit het laatste jaar kan zijn dat ik de website host. Hangt ervan af of ik dit jaar uit de kosten geraak.</p>
		<p>Bedankt aan: Pieter-Jan, Jan, Patrick</p>
		<div class="progress">
			<div class='money'>
				<p>0 €</p>
			</div>
			<div class="progress-bar">
				<?php
				$ammount = 60; // Jan 20, Patrick 20
				$percentage = floor(($ammount / 97.9) * 100);
				?>
				<span class="progress-bar-fill" style="width: <?php echo $percentage; ?>%"><?php echo $ammount . '€ = ' . $percentage; ?>%</span>
			</div>
			<div class='money'>
				<p>97,9 €</p>
			</div>
		</div><br>
		<p>De totale kost voor dit jaar bedraagt (84,95 voor de webspace en 12,95 voor de domeinnaam) 97,9 EUR.</p>
		<form action="https://www.paypal.com/donate" method="post" target="_top">
			<input type="hidden" name="business" value="pjcasteels@gmail.com" />
			<input type="hidden" name="item_name" value="upkeep en onderhoud van vbuw.be" />
			<input type="hidden" name="currency_code" value="EUR" />
			<input type="image" src="https://vbuw.be/assets/images/supportpp.jpg" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Doneren met PayPal-knop" />
			<img alt="" border="0" src="https://www.paypal.com/nl_BE/i/scr/pixel.gif" width="1" height="1" />
		</form>
	</div>
	<br>
	<div class="mail-block">
		<code>05-03-2024</code>
		<p>Werkplannen</p>
		<p>Ik heb vandaag enkele updates gedaan in de google drive. Voornamelijk een update van de werkplannen.</p>
		<p>Ik had de burea TLNS en de SLD's gevraagd of ze mij de recentste werkplannen konden bezorgen. Hierop heb ik een negatief antwoord gekregen. Mits ze niet konden garanderen dat deze de laatste versies waren, konden ze mij deze niet bezorgen.</p>
		<p>Ik heb dan maar een andere manier gezocht. Dit was draw-in van Infrabel. Link toegevoegd aan de website. Hier kan je op zoeken klikken.</p>
		<p>Ik vond het het gemakelijkste om in vrije zoekopdracht "exploitatie" in te vullen. Hiermee vindt het meeste van regio NO voor NW is er iets meer moeite. Maar ze staan allemaal in de google drive.</p>
	</div>
	<br>
	<div class="mail-block">
		<code>28-01-2024</code>
		<p>De tijd is weer daar om het onderhoud van de website te betalen. Voel je aub niet verplicht een bijdrage te leveren. Maar alle kleine beetjes helpen.</p>
		<p>Bedankt aan: Pieter-Jan, Franky, Tom, Jan</p>
		<div class="progress">
			<div class='money'>
				<p>0 €</p>
			</div>
			<div class="progress-bar">
				<?php
				$ammount = 70; // Franky 20, PJ 20, Tom 10, Jan 20
				$percentage = floor(($ammount / 97.9) * 100);
				?>
				<span class="progress-bar-fill" style="width: <?php echo $percentage; ?>%"><?php echo $ammount . '€ = ' . $percentage; ?>%</span>
			</div>
			<div class='money'>
				<p>97,9 €</p>
			</div>
		</div><br>
		<p>De totale kost voor dit jaar bedraagt (84,95 voor de webspace en 12,95 voor de domeinnaam) 97,9 EUR.</p>
		<form action="https://www.paypal.com/donate" method="post" target="_top">
			<input type="hidden" name="business" value="pjcasteels@gmail.com" />
			<input type="hidden" name="item_name" value="upkeep en onderhoud van vbuw.be" />
			<input type="hidden" name="currency_code" value="EUR" />
			<input type="image" src="https://vbuw.be/assets/images/supportpp.jpg" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Doneren met PayPal-knop" />
			<img alt="" border="0" src="https://www.paypal.com/nl_BE/i/scr/pixel.gif" width="1" height="1" />
		</form>
	</div>
	<br>
	<div class="mail-block">
		<code>14-09-2023</code>
		<p>!!! AANPASSING VERDELER DOCUMENT !!!</p>
		<p>De nieuwe reglementering aangaande de aanvraag van de buitenspanning voor opgeleide bediende is toegevoegd. Deze is slechts actief vanaf 01/11/2023</p>
		<p>Dit houd in dat de telegrammen zijn aangepast en in theorie moet je niet langer de palen doorgeven aan de verdeler. Je kan deze nog wel altijd toevoegen, maar deze zullen enkel beschikbaar zijn op vbuw.be en niet in het afgeprinte document.</p>
	</div>
	<br>
	<div class="mail-block">
		<code>11-04-2023</code>
		<p>!!! UPDATE !!!</p>
		<p>Nieuwe functie, voor zij die niet graag met de gps van onze VW caddy rijden.</p>
		<p>Je kan nu naar Document > locaties gaan. Of indien je niet wil inloggen kan je gewoon op de locaties link duwen.</p>
		<p>Hier kan je klikken op links die je daarna doorverwijzen naar Waze!</p>
	</div>
	<br>
	<div class="mail-block">
		<code>10-03-2023</code>
		<p>!!! UPDATE !!!</p>
		<p>De vraag kwam of het mogelijk was om een naam te geven aan de documenten. Dit zodat het mogelijk is om sneller het gepaste document te vinden.</p>
		<p>Dit is toegevoegd. De oude S627 documenten kunnen niet aangepast worden voor deze naam. De verdeler documenten wel. Dus indien je een naam wilt voor een s627 doc zal je deze moeten dupliceren.</p>
		<p>Voor de s460 en s505 zal ik deze functionaliteit voorlopig niet toevoegen. Deze documenten worden te weinig aangemaakt.</p>
	</div>
	<br>
	<div class="mail-block">
		<code>13-03-2023</code>
		<p>Groot nieuw, vanaf heden kan iedereen gebruik maken van <a href="https://www.vbuw.be" target="_blank">HTTPS://WWW.VBUW.BE</a><br>Alle gegevens zijn overgezet en alles lijkt te werken. Indien je een probleem ondervindt mag je me altijd mailen.</p>
		<p>De tijd is weer daar om het onderhoud van de website te betalen. Voel je aub niet verplicht een bijdrage te leveren. Maar alle kleine beetjes helpen.</p>
		<p>Bedankt aan: Ken, Franky, Jan, Pieter-Jan</p>
		<div class="progress">
			<div class='money'>
				<p>0 €</p>
			</div>
			<div class="progress-bar">
				<?php
				$ammount = 90; // ken 20, franky 20, jan 50
				$percentage = floor(($ammount / 90) * 100);
				?>
				<span class="progress-bar-fill" style="width: <?php echo $percentage; ?>%"><?php echo $ammount . '€ = ' . $percentage; ?>%</span>
			</div>
			<div class='money'>
				<p>90 €</p>
			</div>
		</div><br>
		<p>De totale kost voor dit jaar bedraagt (76,01 voor de webspace en 10,99 voor de domeinnaam) 87 EUR.</p>
		<form action="https://www.paypal.com/donate" method="post" target="_top">
			<input type="hidden" name="business" value="pjcasteels@gmail.com" />
			<input type="hidden" name="item_name" value="upkeep en onderhoud van vbuw.app" />
			<input type="hidden" name="currency_code" value="EUR" />
			<input type="image" src="https://vbuw.be/assets/images/supportpp.jpg" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Doneren met PayPal-knop" />
			<img alt="" border="0" src="https://www.paypal.com/nl_BE/i/scr/pixel.gif" width="1" height="1" />
		</form>
	</div>
	<br>
	<div class="mail-block">
		<code>10-03-2023</code>
		<p>!!! VERANDERING HOSTING !!!</p>
		<p>De verlenging van de hosting kwam er weer aan. De prijs die ik ging moeten betalen was wederom omhoog gegaan. Daarom heb ik beslist om nu al te kijken naar een nieuwe hosting en een nieuwe domeinnaam. Hierdoor zal het waarschijnlijk mogelijk zijn om wederom via het Tucrail netwerk op vbuwdoc te geraken (geen zekerheid in dit).</p>
		<p>Zodra de nieuwe hosting up and running is zullen jullie dit hier ook kunnen terug vinden. Zodra ik de exacte kosten weet zal ik deze medelen. </p>
	</div>
	<br>
	<div class="mail-block">
		<p>Nieuwe link toegevoegd naar google drive met de info aangaande RostarCas</p>
		<p><a href="https://drive.google.com/drive/folders/1VVXU8_Kzdat8EtwjHAh6fCrv8yoMkxCR?usp=sharing" target="_blank" rel="noopener noreferrer">Google Drive -> RostarCas</a></p>
	</div>
	<br>
	<div class="mail-block">
		<p>Mag ik vragen aan iedereen om niet nutteloos blanco documenten te maken. Deze kunnen gedownload worden in de Blanco document.</p>
		<p><a href="https://drive.google.com/drive/folders/1wfK-iDhOTg_Xtzm-rLQYlmB-5gyzOYTZ" target="_blank" rel="noopener noreferrer">Google Drive -> Blanco Documenten</a></p>
	</div>
	<br>
	<div class="mail-block">
		<p>Dankzij Jan Bonnarens is er een link toegevoegd voor het terug vinden van alle BNX'en. Deze link is via het portaal van Infrabel.</p>
		<p>https://dailyin-website.infrabel.be</p>
	</div>
	<br>
</div>