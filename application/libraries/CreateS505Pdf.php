<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Maak een pdf voor S505
 */
class CreateS505Pdf
{
	/**
	 * Maak de pdf
	 * @param $data collection of input data
	 * @param $sourceFile basis pdf bestands locatie
	 *  */ 
	public function create($data, $sourceFile)
	{
		require_once('PDF_Textbox.php');
		$docName = 'S505';

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
				if($single['s505_name'] == 'eindDatum')
				{
					if (!empty($single['s505_input_input']))
					{
						$date = new DateTime($single['s505_input_input']);
						$interval = new DateInterval('P' . ($i-1) . 'D');
						$date->add($interval);
						$single['s505_input_input'] = $date->format('d-m-Y');
					}
				}
				
				$pdf->SetFont($fontName, 'B', 8);
				$pdf->SetXY($single['s505_y'], $single['s505_x']);
				$pdf->Cell($single['s505_w'], $single['s505_h'], $single['s505_input_input'], 0);
			}

			foreach($data['textbox'] as $textbox)
			{
				$pdf->SetFont($fontName, 'B', 8);
				$pdf->SetXY($textbox['s505_y'], $textbox['s505_x']);
				$pdf->drawTextBox(
					$textbox['s505_input_input'], 
					$textbox['s505_w'], 
					$textbox['s505_h'], 
					$textbox['s505_align'], 
					$textbox['s505_valign'], 
					$textbox['s505_border']
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
