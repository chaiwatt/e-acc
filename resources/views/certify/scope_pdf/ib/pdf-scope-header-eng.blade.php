
<div class="lab-header">
    <div class="main">
        <div class="inline-block  w-100 text-center float-left" >
            <span class="title" style="font-size: 24px">Scope of Accreditation for Inspection Body</span>

            <br>
            <div style="display: inline-block; height: 8px"></div>
            @php
                $certificate = "xx-IBxxxx";
                if($app_certi_ib->app_certi_ib_export != null)
                {
                    if($app_certi_ib->app_certi_ib_export->certificate != null)
                    {
                        $certificate = $app_certi_ib->app_certi_ib_export->certificate;
                    }
                }
            @endphp
            <span class="cer_no" style="line-height: 5px !important"><strong>Certificate No. {{$certificate}}</strong></span>

        </div>
    </div>



    <table style="margin-top: 15px">
        <tr>
            <td style="width:30%;vertical-align:top"><strong><span style="font-size:21px">Name of Inspection Body</span></strong></td>
            <td style="vertical-align:top"><span style="font-size:21px">: {{$app_certi_ib->name_en_unit}}</span></td>
        </tr>
    </table>


    <table>
        <tr>
            @php
            $accereditation = "INSPECTION xxxx";
                    if($app_certi_ib->app_certi_ib_export != null)
                    {
                        if($app_certi_ib->app_certi_ib_export->accereditatio_no_en != null)
                        {
                            $accereditation = $app_certi_ib->app_certi_ib_export->accereditatio_no_en;
                             
                        }
                    }
            @endphp
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:21px">Accreditation No.</span></strong></td>
            <td style="vertical-align:top"><span style="font-size:21px">: {{$accereditation}}</span>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:35%;vertical-align:top"><strong><span style="font-size:21px">Type of Inspection Body</span></strong></td>
            <td style="vertical-align:top"><span style="font-size:21px">: {{$app_certi_ib->typeUnitTitle}}</span>
            </td>
        </tr>
    </table>
 
    
</div>
