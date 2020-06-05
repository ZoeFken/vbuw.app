<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verdeler ES</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/tableStyle.css') ?>">
</head>
<body>
    <h1 class="center">Overdracht Buitenspanningstelling</h1>
    <table id="main" class="centertable">
        <thead>
            <tr>
                <th class='column-1 center'>E934</th>
                <th class='column-2 center'>Herkomst</th>
                <th class='column-3 center'>Volledige tekst of onderwerp van de mededeling</th>
                <th class='column-4 center'>Nr. Van de Correspondent</th>
                <th class='column-5 center'>Bestemming</th>
                <th class='column-6 center'>Uur</th>
            </tr>
		</thead>
        <tbody>
			<?php for($i = 0; $i < 4; $i++): ?>
			<tr>
                <td></td>
                <td class="center">Bediende</td>
				<td>
					<p>Ik sta af aan de opgeleide bediende.
					<br><br><br>De buitenspanningstelling van de bovenleiding van de lijn <?php echo $verdeler_lijn ?> de sporen <?php echo $verdeler_spoor ?>
					<br>Dit zijn de gevallen <?php echo $verdeler_gevallen ?>
					<br><br>Ingeschreven onder nr:
					<br><br>De spoorstaafverbindingen zijn geplaatst aan de bovenleidingspalen:
					<br><br><?php if(!empty($verdeler_geplaatstePalen)) : ?>
					<?php echo $verdeler_geplaatstePalen; ?>
					<?php else : ?>
					<br><br>
					<?php endif; ?>
				</td>
                <td></td>
                <td class="center">Verdeler</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="center">Bediende</td>
                <td>
					<p>Ik neem over van de opgeleide bediende
					<br><br><br>De buitenspanningstelling van de bovenleiding van de lijn <?php echo $verdeler_lijn ?> de sporen <?php echo $verdeler_spoor ?>
					<br>Dit zijn de gevallen <?php echo $verdeler_gevallen ?>
					<br><br>Ingeschreven onder nr:
					<br><br>De spoorstaafverbindingen zijn geplaatst aan de bovenleidingspalen:
					<br><br><?php if(!empty($verdeler_geplaatstePalen)) : ?>
					<?php echo $verdeler_geplaatstePalen; ?>
					<?php else : ?>
					<br><br>
					<?php endif; ?>
				</td>
                <td></td>
                <td class="center">Verdeler</td>
                <td></td>
			</tr>
			<?php endfor; ?>
        </tbody>
    </table>
</body>
</html>
