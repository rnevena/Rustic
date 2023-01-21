<?php
    // $word=new COM("word.application") or die("UnabletoinstantiateWord");
    // $word->Visible=0; $word->Documents->Add(); 
    // $word->Selection->InlineShapes->AddPicture("C:/xampp/htdocs/rustic/assets/img/autor.png", False, True);
    $txt="My name is Nevena Radovanovic. I enjoy making things look nice and perform well, as much as I can. Working hard to become an efficient front-end developer. ";
    // $result = "\n".$txt."\n";
    // $word->Selection->TypeText($result); 
    // $filename=tempnam(sys_get_temp_dir(),"word");
    // $word->Documents[1]->SaveAs($filename);
    // $word->Quit();
    // $word=null;
    // header("Content-type:application/vnd.ms-word");
    // header("Content-Disposition:attachment;Filename=author_9_18.doc");
    // readfile($filename);
    // unlink($filename);
    
include("../../config/connection.php");
header("Content-Type:application/vnd.ms-word");
header("Content-Disposition:attachment;filename=author_9_18.doc");

$output=$txt;
echo $output;
?>
