<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Maak een pdf voor S627 of bis
 */
class CreateS627Pdf
{
	/**
	 * Maak de pdf
	 * @param $data collection of input data
	 * @param $sourceFile basis pdf bestands locatie
	 *  */ 
	public function create($data, $sourceFile)
	{
		require_once('PDF_Textbox.php');

		switch($sourceFile) {
			case "./assets/base/S627.pdf":
				$docName = 'S627';
			break;
			case "./assets/base/S627-bis-lvhw.pdf":
				$docName = 'S627-bis-lvhw';
			break;
			case "./assets/base/S627-bis-wl.pdf":
				$docName = 'S627-bis-wl';
			break;
			default:
				$docName = 'unknown';
		}

		$name = (!empty($data['opgemaaktDoor'])) ? '.' . $data['opgemaaktDoor'] : '';
			
		// initializeer FPDI in ladnscape 
		// $pdf = new Fpdi('L');
		$pdf = new PDF_TextBox('L');
		
		for($i = 1; $i <= $data['hoeveelDagen']; $i++ )
		{
			// Set font en kleur
			$pdf->SetTextColor(0, 0, 0);
			$fontName = 'helvetica';

			// Nieuwe pagina
			$pdf->AddPage();
			$pdf->setSourceFile($sourceFile);
			$tpl = $pdf->importPage(1);
			$pdf->useTemplate($tpl, 0, 0, null, null);
			
			foreach($data['single'] as $single)
			{
				if($single['s627_name'] == 'aanvangDatum')
				{
					if (!empty($single['s627_input_input']))
					{
						$date = new DateTime($single['s627_input_input']);
						$interval = new DateInterval('P' . ($i-1) . 'D');
						$date->add($interval);
						$single['s627_input_input'] = $date->format('d-m-Y');
					}
				}

				// overdracht veld voor duidelijkheid twee velden eigenlijk alleen 7 nodig
				if($single['s627_name'] == 'ingediendDoor' && $single['s627_id'] == 7)
				{
					// indien overdracht geselecteerd maak naam veld leeg
					if($data['overdracht'] != null) $single['s627_input_input'] = ' ';
				}

				// station niet wegschrijven op doc
				if($docName != 'S627' &&  $single['s627_name'] == 'station') continue;

				$pdf->SetFont($fontName, 'B', 8);
				$pdf->SetXY($single['s627_y'], $single['s627_x']);
				$pdf->Cell($single['s627_w'], $single['s627_h'], $single['s627_input_input'], 0);
			}

			foreach($data['textbox'] as $textbox)
			{
				$pdf->SetFont($fontName, 'B', 8);
				$pdf->SetXY($textbox['s627_y'], $textbox['s627_x']);
				$pdf->drawTextBox(
					$textbox['s627_input_input'], 
					$textbox['s627_w'], 
					$textbox['s627_h'], 
					$textbox['s627_align'], 
					$textbox['s627_valign'], 
					$textbox['s627_border']
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
