<?php
/*
by ：lishihao
2015-12-8
*/
set_time_limit(300);

function pdf_ini($o_file){
	$s = explode(".",$o_file)[0];
	$n_file = $s.".pdf";
	$o_dir=str_replace("\\","/",dirname(dirname(dirname(__FILE__)))."/public/home/file/");
	$n_dir=str_replace("\\","/",dirname(dirname(dirname(__FILE__)))."/public/home/swf/");
	$swftools = str_replace("/","\\",dirname(dirname(dirname(__FILE__)))."\\public\\expand\\FlexPaper\\swftools\\pdf2swf.exe");
	$system_file_dir='file:///';
	$oo_file = $system_file_dir.$o_dir.$o_file;
	$nn_file = $system_file_dir.$n_dir.$n_file;
	if(explode(".",$o_file)[1] == "pdf"){
		copy("./public/home/file/{$s}.pdf","./public/home/swf/{$s}.pdf");
		//$command = "{$swftools} {$n_dir}{$n_file} -s flashversion=9 -o {$n_dir}{$s}.swf"; 第一
		$command = "{$swftools} {$n_dir}{$n_file} -T 9 -f -q -s poly2bitmap -o {$n_dir}{$s}.swf"; //第二
		exec($command);
		unlink("./public/home/swf/{$s}.pdf");		
	}else{
		if(word2pdf($oo_file,$nn_file)){
			//$command = "{$swftools} {$n_dir}{$n_file} -s flashversion=9 -o {$n_dir}{$s}.swf"; 第一
			$command = "{$swftools} {$n_dir}{$n_file} -T 9 -f -q -s poly2bitmap -o {$n_dir}{$s}.swf"; //第二
			exec($command);
			unlink("./public/home/swf/{$s}.pdf");
		}	
	}

}
function MakePropertyValue($name, $value, $osm)
{
    $oStruct = $osm->Bridge_GetStruct("com.sun.star.beans.PropertyValue");
    $oStruct->Name  = $name;
    $oStruct->Value = $value;
    return $oStruct;
}
function word2pdf($doc_url, $output_url)
{TRY{
    $osm         = new COM("com.sun.star.ServiceManager")or die("Please be sure that OpenOffice.org is installed.n");
    $args        = array(MakePropertyValue("Hidden", true, $osm));
    $oDesktop    = $osm->createInstance("com.sun.star.frame.Desktop");
    $oWriterDoc  = $oDesktop->loadComponentFromURL($doc_url, "_blank", 0, $args);
    $export_args = array(MakePropertyValue("FilterName", "writer_pdf_Export", $osm));
    $oWriterDoc->storeToURL($output_url, $export_args);
    $oWriterDoc->close(true);
	} CATCH (Exception $e){
		echo  $e->getMessage();
		exit();
	}
	return true;
}
?>