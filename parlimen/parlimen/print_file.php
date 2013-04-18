<?php

function print_file($filename)
{
    // path to your adobe executable
    $adobe_path='"C:/Program Files/Adobe/Acrobat 7.0/Reader/AcroRd32.exe"';

    $ext='';
    $ext=strrchr($filename,'.');
    $ext=substr($ext,1);
    $ext_xl=substr($ext,0,2);

    if ($ext=='pdf') {
        shell_exec ($adobe_path.' /t '.$filename);
    }
    else if ($ext=='doc'||$ext=='rtf'||$ext=='txt') {
        $word = new COM("Word.Application");
        $word->visible = true;
        $word->Documents->Open($filename);
        $word->ActiveDocument->PrintOut();
        $word->ActiveDocument->Close();
        $word->Quit();
    }
    else if ($ext_xl=='xl') {
        $excel = new COM("Excel.Application");
        $excel->visible = true;
        $excel->Workbooks->Open($filename);
        $excel->ActiveWorkBook->PrintOut();
        $excel->ActiveWorkBook->Close();
        $excel->Quit();
    }
}

// example of printing a PDF

print_file("C:/photo_gallery.pdf");

?> 

