<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Maak een pdf s 460
 */
class CreateS460Pdf
{
	/**
	 * Maak de pdf
	 * @param $data collection of input data
	 * @param $sourceFile basis pdf bestands locatie
	 *  */ 
	public function create($data, $sourceFile)
	{
		require_once('PDF_Textbox.php');

		$docName = 'S460';
		$name = (!empty($data['opgemaaktDoor'])) ? '.' . $data['opgemaaktDoor'] : '';
			
		// initializeer FPDI in Portrait 
		$pdf = new PDF_TextBox('P');

		// Datum interval van 1 dag
		$interval = new DateInterval('P1D');
		
		for($i = 1; $i <= $data['hoeveelDagen']; $i++ )
		{
			// Datum
			$date = new DateTime($data['startDatum']);
			if($i > 1) $date->add($interval);
			$data['startDatum'] = $date->format('d-m-Y');

			// Set font kleur
			$pdf->SetTextColor(0, 0, 0);
			$itteration = 0;

			$fontName = 'helvetica';

			for($ix = 0; $ix <= count($data['input']); $ix++)
			{
				if($ix % 12 == 0)
				{
					// Nieuwe pagina
					$pdf->AddPage();
					$pdf->setSourceFile($sourceFile);
					$tpl = $pdf->importPage(1);
					$pdf->useTemplate($tpl, 0, 0, null, null);
					$itteration = ($ix > 0) ? $itteration + 12 : 0;
				}

				if($ix === 0)
				{
					// Datum
					$pdf->SetFont($fontName, 'B', 20);
					$pdf->Text($data['locaties']['0']['s460_y'], $data['locaties']['0']['s460_x']+10, $data['startDatum']);
					$pdf->Text($data['locaties']['12']['s460_y'], $data['locaties']['12']['s460_x']+10, '------');
					continue;
				}

				$locationIndex = $ix - $itteration;			
				
				$random = rand(1,99);
				$textbox = $data['input'][$ix-1];
				
				// $locaties = ($textbox['s460_input_verzender'] == '0') ? $data['locaties'][$locationIndex] : $data['locaties'][$locationIndex+12];
				if($data['wissel'] == 0) $locaties = ($textbox['s460_input_verzender'] == '0') ? $data['locaties'][$locationIndex] : $data['locaties'][$locationIndex+12];
				else $locaties = ($textbox['s460_input_verzender'] == '1') ? $data['locaties'][$locationIndex] : $data['locaties'][$locationIndex+12];

				$nummerLocatie = $data['locaties'][$locationIndex];
				
				$pdf->SetFont($fontName, 'B', 20);
				$pdf->Text($nummerLocatie['s460_y']-33, $nummerLocatie['s460_x']+10, $random);

				$pdf->SetFont($fontName, 'B', 8);
				$pdf->SetXY($locaties['s460_y'], $locaties['s460_x']);
				$pdf->drawTextBox(
					$textbox['s460_input_melding'], 
					$locaties['s460_w'], 
					$locaties['s460_h'], 
					$locaties['s460_align'], 
					$locaties['s460_valign'],
					0 // no border 
				);
			}
		
		}
		/* Output our new pdf into a file
		 * F = Write local file
		 * I = Send to standard output (browser)
		 * D = Download file
		 * S = Return PDF as a string */
		
		$pdf->Output(date("Y-m-d_H-i-s") . $name . '.' . $docName . '.pdf', 'D');
		return true; 
	} 
}
