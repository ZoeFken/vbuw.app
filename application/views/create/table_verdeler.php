<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verdeler ES</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/tableStyle.css') ?>">
</head>

<body>
    <h1 class="center">Buitenspanningstelling</h1>
    <table class="centertable">
        <tbody>
            <tr>
                <td class="bold">Lijn</td>
                <td><?php echo $verdeler_lijn ?></td>
                <td class="bold">Spoor</td>
                <td><?php echo $verdeler_spoor ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="bold">Datum</td>
                <td><?php echo $verdeler_aanvangsDatum ?></td>
                <td class="bold">van</td>
                <td><?php echo $verdeler_aanvangUur ?></td>
                <td class="bold">Datum</td>
                <td><?php echo $verdeler_eindDatum ?></td>
                <td class="bold">Tot</td>
                <td><?php echo $verdeler_eindUur ?></td>
            </tr>
        </tbody>
    </table><br>
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
            <tr>
                <td></td>
                <td class="center">Bediende</td>
                <td>
                    <p>Ik vraag de buitenspanning stelling van de bovenleiding van de geval(len)
                        <br><br><?php echo $verdeler_gevallen ?>.
                        <br><br>Van lijn (station) <?php echo $verdeler_lijn ?>, spoor <?php echo $verdeler_spoor ?>.
                        <br><br>Voor werken voorzien in BNX nr <?php echo $verdeler_bnx ?>.
                        <br>En in overeenstemming met FBSS nr <?php echo $verdeler_tpo ?>.
                    </p>
                </td>
                <td></td>
                <td class="center">Verdeler</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="center">Verdeler</td>
                <td>
                    <p>Gevolg uw nr:
                        <br><br>De spanning is verbroken op de bovenleiding (en de tegenfase feeder) van de geval(len)
                        <br><br><?php echo $verdeler_gevallen ?>,
                        <br><br>van lijn (station) <?php echo $verdeler_lijn ?>, spoor <?php echo $verdeler_spoor ?>.
                        <br><br>Ik laat het plaatsen van de SSV's/UEG's toe in overeenstemming met FBSS nr <?php echo $verdeler_tpo ?>.
                        <br><br>Enkel de SSV's/UEG'S, geplaatst conform de FBSS, zorgen voor een bescherming tegen de elektrische gevaren.
                    </p>
                </td>
                <td></td>
                <td class="center">Bediende</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="center">Bediende</td>
                <td>
                    <p>De SSV's/UEG's zijn geplaatst in overeenstemming met FBSS nr <?php echo $verdeler_tpo ?>.
                </td>
                <td></td>
                <td class="center">Verdeler</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="center">Verdeler</td>
                <td>
                    <p>De buitenspanning is effectief, de werken voorzien in BNX nr <?php echo $verdeler_bnx ?> en in overeenstemming met FBSS nr <?php echo $verdeler_tpo ?> kunnen aangevangen worden op de lijn (station) <?php echo $verdeler_lijn ?>, spoor <?php echo $verdeler_spoor ?>. Tussen de geplaatste ssv's.</p>
                </td>
                <td></td>
                <td class="center">Bediende</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="center">Bediende</td>
                <td>
                    <p>Ik laat toe om de bovenleiding van de geval(len)
                        <br><br><?php echo $verdeler_gevallen ?>
                        <br><br>Lijn (station) <?php echo $verdeler_lijn ?>, spoor <?php echo $verdeler_spoor ?> terug onder spanning te stellen.
                        <br><br>De SSV's zijn weggenomen, de bovenleiding wordt beschouwd(en) als zijnde onder spanning.
                    </p>
                </td>
                <td></td>
                <td class="center">Verdeler</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>