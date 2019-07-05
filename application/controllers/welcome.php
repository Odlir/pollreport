<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->library('form_validation');
        
        $data['institucion_s']='SELECCIONE UNA OPCIÓN';
        $data['pollintereses_s']='SELECCIONE UNA OPCIÓN';
        $data['polltemperamentos_s']='SELECCIONE UNA OPCIÓN';

        $data['evaluados_s']=NULL;
        $data['seleccionados_s']=NULL;
        $data['institucion']=array();
        $data['pollintereses']=array();
        $data['polltemperamentos']=array();
        $data['reporte']=array();
        
        $data['institucion'] = $this->load_companies();

        
        if ($this->input->post('institucion')){
            $data['institucion_s'] = $this->input->post('institucion');
            $data['pollintereses'] = $this->load_poll(12);
            $data['polltemperamentos'] = $this->load_poll(13);
        }
        
        if ($this->input->post('pollintereses')){
            if (in_array($this->input->post('pollintereses'),$data['pollintereses'])){
                $data['pollintereses_s'] = $this->input->post('pollintereses');
            } 

        }

        if ($this->input->post('polltemperamentos')){
            if (in_array($this->input->post('polltemperamentos'),$data['polltemperamentos'])){
                $data['polltemperamentos_s'] = $this->input->post('polltemperamentos');
            } 

        }


        if( $this->input->post('generate_report') == 'report' ) {
            $data['reporte'] = $this->report();
        }

        
        if( $this->input->post('generate_report') == 'excel' ) {
            $institucion=$this->input->post('institucion');
            $this->excel($institucion);
            
        }

        if( $this->input->post('generate_report') == 'general' ) {

            $CompanyName = $this->input->post('institucion');
            $idPoll = $this->input->post('pollintereses');
            if(strlen($idPoll) > 2 ){
                $idPoll = trim(substr($idPoll , 0, strpos($idPoll, "-",1)));
                $filename = $CompanyName . '-' . $idPoll . '.pdf';
                $file="http://testdetalentos.upc.edu.pe/ResultadosUPC/General.aspx?id=" . $idPoll;
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                readfile($file);
            }
            
        }

        if( $this->input->post('generate_report') == 'consolidado' ) {
            $institucion=$this->input->post('institucion');
            $idPoll = $this->input->post('pollintereses');
            $this->excelConsolidado($institucion, $idPoll);
            
        }


		if( $this->input->post('generate_report') == 'zip' ) {
			$institucion = $this->input->post('institucion');
			$idPoll = $this->input->post('pollintereses');
			$idPoll = trim(substr($idPoll , 0, strpos($idPoll, "-",1)));
			$datos = $this->getLinksConsolidado($idPoll);
			$this->create_zip($datos, $institucion);
		}

		$this->load->view('welcome_message', $data);
	}
    
    function create_zip($datos, $institucion){

	    foreach($datos as $x) {
		    // Initialize a CURL session.
		    $ch = curl_init();

		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_URL, $x->consolidado);
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 9990);

		    $result = curl_exec($ch);
		    if(curl_errno($ch)){
			    throw new Exception(curl_error($ch));
		    }

		    if (!file_exists('pdfs')) {
			    mkdir('pdfs', 0777, true);
		    }

		    $archivo = fopen('pdfs/'. $x->name .'.pdf','w+');
		    fputs($archivo,$result);
		    fclose($archivo);
	    }


	// Get real path for our folder
	    $rootPath = realpath('pdfs');

	// Initialize archive object
	    $zip = new ZipArchive();
	    $zip->open($institucion.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

	    $files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
	    );

	    foreach ($files as $name => $file)
	    {
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
			    // Get real and relative path for current file
			    $filePath = $file->getRealPath();
			    $relativePath = substr($filePath, strlen($rootPath) + 1);

			    // Add current file to archive
			    $zip->addFile($filePath, $relativePath);
		    }
	    }
	    $zip->close();

	    $readableStream = fopen($institucion .'.zip', 'rb');
	    $writableStream = fopen('php://output', 'wb');

	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.$institucion.'.zip"');
	    stream_copy_to_stream($readableStream, $writableStream);
	    ob_flush();
	    flush();


	    $dir = 'pdfs';
	    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
	    $files = new RecursiveIteratorIterator($it,
		    RecursiveIteratorIterator::CHILD_FIRST);
	    foreach($files as $file) {
		    if ($file->isDir()){
			    rmdir($file->getRealPath());
		    } else {
			    unlink($file->getRealPath());
		    }
	    }
	    rmdir($dir);
    }

    function load_companies()
    {
        $arr_institucion = array();
        $arr_institucion[0] = 'SELECCIONE UNA OPCIÓN';
        

        $this->load->model('Report_model');
        $companieslist = $this->Report_model->get_companies();

        if (isset($companieslist)){
            
            foreach ($companieslist as $row)
            {
                 $arr_institucion[$row->name] = $row->name;
                
            }
        }

        return $arr_institucion;
    }

    function load_poll($polltype)
    {
        $arr_poll = array();
        $arr_poll[0] = 'SELECCIONE UNA OPCIÓN';
        

        $this->load->model('Report_model');

        $params['company'] = $this->input->post('institucion');
        $params['polltype'] = $polltype;
        //var_dump($params);

        $pollList = $this->Report_model->get_poll($params);

        if (isset($pollList)){
            
            foreach ($pollList as $row)
            {
                 $arr_poll[$row->encuesta] = $row->encuesta;
                
            }
        }

        return $arr_poll;
    }

    function report()
	{
        $arr_reporte=array();

        $this->load->model('Report_model');

        $params['pollIdInt'] = $this->input->post('pollintereses');
        $params['pollIdTemp'] = $this->input->post('polltemperamentos');

        $arr_reporte = $this->Report_model->get_report($params);
        //var_dump($arr_reporte);
        return $arr_reporte;
        // return $reporte;
	}
    
    function excel($institucion)
    {
        $datos=array();


        $datos=$this->report();

        
        $this->load->library('excel');
 

        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize' => '512MB', 'cacheTime' => '1000'); 

        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
  


        $phpExcel = new PHPExcel();
        $phpExcel->getProperties()->setCreator("Sistema de encuestas UPC");
        $phpExcel->getProperties()->setLastModifiedBy("");
        $phpExcel->getProperties()->setTitle("Links Encuestas");
        $phpExcel->getProperties()->setSubject("");
        $phpExcel->getProperties()->setDescription("Reporte de links de encuesta de intereses-talentos-temperamentos");

        $phpExcel->setActiveSheetIndex(0);
        $phpExcel->getActiveSheet()->setTitle('Link Encuestas');

        $worksheet = $phpExcel->getSheet(0);
        
        $style['general'] = array(
            'font' => array(
                'name' => 'Century Gothic',
                'size' => 9,
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array(
                        'rgb' => 'FFFFFF',
                    ),
                ),
            ),
        );
        $style['titulo_text'] = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => '2E75B6',
                ),
            ),
        );
        $style['cabecera_text'] = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => 'FFFFFF',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array(
                        'rgb' => '000000',
                    ),
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '2E75B6'
                ),
            ),
        );
        $style['detalle_text'] = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array(
                        'rgb' => '000000',
                    ),
                ),
            ),
        );



        $phpExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style['general']);

        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(145);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(140);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(145);

        $worksheet->getCellByColumnAndRow(0, 1)->setValue('NOMBRE');
        $worksheet->getCellByColumnAndRow(1, 1)->setValue('INTERESES');
        $worksheet->getCellByColumnAndRow(2, 1)->setValue('TALENTOS');
        $worksheet->getCellByColumnAndRow(3, 1)->setValue('TEMPERAMENTOS');

        $phpExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($style['cabecera_text']);
        $phpExcel->getActiveSheet()->getStyleByColumnAndRow(1, 1)->applyFromArray($style['cabecera_text']);
        $phpExcel->getActiveSheet()->getStyleByColumnAndRow(2, 1)->applyFromArray($style['cabecera_text']);
        $phpExcel->getActiveSheet()->getStyleByColumnAndRow(3, 1)->applyFromArray($style['cabecera_text']);
        
        $i=1;
        $j=0;
        foreach ($datos as $row) {
            $j++;
            /*
            $worksheet->getCellByColumnAndRow(0,$i+$j)->setValue(utf8_encode($row->name));
            $worksheet->getCellByColumnAndRow(1,$i+$j)->setValue(utf8_encode($row->intereses));
            $worksheet->getCellByColumnAndRow(2,$i+$j)->setValue(utf8_encode($row->talentos));
            $worksheet->getCellByColumnAndRow(3,$i+$j)->setValue(utf8_encode($row->temperamentos));
            */
            $worksheet->getCellByColumnAndRow(0,$i+$j)->setValue($row->name);
            $worksheet->getCellByColumnAndRow(1,$i+$j)->setValue($row->intereses);
            $worksheet->getCellByColumnAndRow(2,$i+$j)->setValue($row->talentos);
            $worksheet->getCellByColumnAndRow(3,$i+$j)->setValue($row->temperamentos);


        }
        
        $filename = preg_replace('/\s+/', '-', $institucion) . '-LINKS-ENCUESTAS.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        //header("Pragma: no-cache"); 
        //header("Expires: 0");

        $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
        $writer->save('php://output');

        $phpExcel->__destruct();
        unset($phpExcel,$writer);

        
        
        
        

    }

    function getLinksConsolidado($PollId)
    {
        $arr_reporte=array();

        $this->load->model('Report_model');

        $arr_reporte = $this->Report_model->get_linksConsolidado($PollId);
        return $arr_reporte;

    }

    function excelConsolidado($institucion, $idPoll)
    {
        $datos=array();
        $idPoll = trim(substr($idPoll , 0, strpos($idPoll, "-",1)));
        $datos=$this->getLinksConsolidado($idPoll);
        

        $this->load->library('excel');

        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize' => '512MB', 'cacheTime' => '1000'); 

        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
  


        $phpExcel = new PHPExcel();
        $phpExcel->getProperties()->setCreator("Sistema de encuestas UPC");
        $phpExcel->getProperties()->setLastModifiedBy("Sistema de encuestas UPC");
        $phpExcel->getProperties()->setTitle("Links reporte consolidado");
        $phpExcel->getProperties()->setSubject("Links reporte consolidado");
        $phpExcel->getProperties()->setDescription("Links de reporte consolidado");

        $phpExcel->setActiveSheetIndex(0);
        $phpExcel->getActiveSheet()->setTitle('Links reporte consolidado');

        $worksheet = $phpExcel->getSheet(0);
        
        $style['general'] = array(
            'font' => array(
                'name' => 'Century Gothic',
                'size' => 9,
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array(
                        'rgb' => 'FFFFFF',
                    ),
                ),
            ),
        );
        $style['titulo_text'] = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => '2E75B6',
                ),
            ),
        );
        $style['cabecera_text'] = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => 'FFFFFF',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array(
                        'rgb' => '000000',
                    ),
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '2E75B6'
                ),
            ),
        );
        $style['detalle_text'] = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array(
                        'rgb' => '000000',
                    ),
                ),
            ),
        );



        $phpExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style['general']);

        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(145);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(140);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(145);

        $worksheet->getCellByColumnAndRow(0, 1)->setValue('EMPRESA: ' . $institucion .' / ID Encuesta: ' . $idPoll);
        $worksheet->getCellByColumnAndRow(0, 3)->setValue('NOMBRE');
        $worksheet->getCellByColumnAndRow(1, 3)->setValue('LINK REPORTE CONSOLIDADO');

        $phpExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($style['titulo_text']);
        $phpExcel->getActiveSheet()->getStyleByColumnAndRow(0, 3)->applyFromArray($style['cabecera_text']);
        $phpExcel->getActiveSheet()->getStyleByColumnAndRow(1, 3)->applyFromArray($style['cabecera_text']);
        
        
        $i=3;
        $j=0;
        foreach ($datos as $row) {
            $j++;

            $worksheet->getCellByColumnAndRow(0,$i+$j)->setValue($row->name);
            $worksheet->getCellByColumnAndRow(1,$i+$j)->setValue($row->consolidado);

        }
        
        $filename = preg_replace('/\s+/', '-', $institucion) .'-'. $idPoll . '-LINKS-CONSOLIDADO-INDIVIDUALES.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        //header("Pragma: no-cache"); 
        //header("Expires: 0");

        $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
        $writer->save('php://output');

        $phpExcel->__destruct();
        unset($phpExcel,$writer);
        

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */