<?php

namespace App\Http\Controllers;

use Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ScheduleController extends Controller
{

    public function delete_uploads()
    {

        $public_uploads = Storage::disk('uploads')->getDriver()->getAdapter()->getPathPrefix();

        $it = new RecursiveDirectoryIterator($public_uploads, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
                    RecursiveIteratorIterator::CHILD_FIRST);

        $time = strtotime('-1 day');//ถ้าไฟล์มีการถึงล่าสุดน้อยกว่านี้
        $extension_excepts = ['html', 'png', 'jpeg', 'jpg'];//ไฟล์นามสกุลที่จะไม่ลบ
        foreach($files as $key => $file) {

            if ($file->isFile()){

                $del = true;

                if(in_array(strtolower($file->getExtension()), $extension_excepts)){//นามสกุลไฟล์อยู่ในข้อยกเว้นไม่ต้องลบ
                    $del = false;
                }

                if($time < $file->getATime()){//มีการเข้าถึงล่าสุดยังไม่ถึงเวลาที่กำหนด ไม่ต้องลบ
                    $del = false;
                }

                echo $key.'----'.$file->getExtension().'--'.date('Y-m-d H:i:s', $file->getATime()).'--';
                var_dump($del);
                echo '<br>';

                if($del){
                   unlink($file->getRealPath());
                }

            }

        }

    }

}
