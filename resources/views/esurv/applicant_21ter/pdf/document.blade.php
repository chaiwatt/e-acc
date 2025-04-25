<style>
    @page {
        margin:2%;padding:0;
    }
    body {
        font-family: 'THSarabunNew', sans-serif;
    }
    .content{
        padding: 6%;
        margin: 0px;
        height: 100%;
        top: 15px;
        padding-bottom: 0px;
        /* position: relative; */

    }


    h1,h2,h3,h4,h5,h6,p{
        padding: 0px;
        margin: 0px;
        line-height: 30px;
    }
    .space{
        height: 20px;
    }
    .space-mini{
        height: 10px;
    }

    .free-dot {
        border-bottom: thin dotted #000000;
        padding-bottom: 0px !important;
    }

    /* .custom-label {
        background: #ffffff;
        padding-bottom: 0px !important;
    } */

    .pull-right {
    float: right !important;
    }

    .pull-left {
    float: left;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
    text-align: right;
    }

    .text-center {
    text-align: center;
    }

   .padding-top-bottom {
        padding: 5px 0px;
    }

     /* .split-page {
            page-break-after: always !important;
        } */

        p.main {
  text-align: justify;
}

</style>

<body>
<div class="content">
    @php
    if($approved_date){
        list($day_use, $month_use, $year_use) = explode(' ',  HP::toThaiNumber(HP::formatDateThaiFull($approved_date)));
    } else {
        $day_use = '-';
        $month_use = '-';
        $year_use = '-';
    }
    @endphp
    <div style="text-align: right; padding-right: 15px; line-height: 20px;">
        เลขที่ <span class="free-dot">{{ $numberforshow }}</span>
    </div>
    <div class="text-center">
        <img src="{{ public_path('images/certificate-header.jpg') }}" width="100px"/>
    </div>
    <div class="text-center">
        <div class="space-mini"></div>
        <h3><strong>ใบรับแจ้ง</strong></h3>
        <h3><strong>การนำเข้าตามมาตรา ๒๑ ตรี</strong></h3>
        <p>อาศัยอำนาจตามความในพระราชบัญญัติมาตรฐานผลิตภัณฑ์อุตสาหกรรม พ.ศ. ๒๕๑๑</p>
        <p>แก้ไขเพิ่มเติมโดยพระราชบัญญัติมาตรฐานผลิตภัณฑ์อุตสาหกรรม (ฉบับที่ ๘) พ.ศ. ๒๕๖๒</p>
    </div>
    <div class="space-mini"></div>
        <p style="text-indent: 100px;">สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้รับแจ้งการนำเข้าผลิตภัณฑ์ตามมาตรา ๒๑ ตรี</p>

            <div class="row">
                <div style="float: left; width: 30px;">
                    จาก
                </div>
                <div style="float: left; width: auto; text-align: left; line-height: 23px;" class="free-dot">
                    {!! str_repeat("&nbsp;", 10) !!} {{ $created_name }}
                </div>
                <div style="clear: both; margin: 0pt; padding: 0pt;"></div>
            </div>
            <div class="row">
                <div style="float: left; width: 80px;">
                    ตามเลขรับที่
                </div>
                <div style="float: left; width: 200px; text-align: center; line-height: 23px;" class="free-dot">
                    {{ HP::toThaiNumber($ref_no_number) }}
                </div>
                <div style="float: left; width: 35px;">
                    วันที่
                </div>
                <div style="float: left; width: auto; text-align: center; line-height: 23px;" class="free-dot">
                    {{ HP::toThaiNumber(HP::formatDateThaiFull($approved_date)) }}
                </div>
                <div style="clear: both; margin: 0pt; padding: 0pt;"></div>
            </div>
         และได้ออกใบรับแจ้งฉบับนี้ไว้เพื่อเป็นหลักฐานการแจ้งแล้ว
        <p style="text-indent: 100px;" class="main">
            ทั้งนี้ ผู้นำเข้าต้องปฏิบัติตามหลักเกณฑ์และเงื่อนไข ตามประกาศคณะกรรมการมาตรฐาน
            ผลิตภัณฑ์อุตสาหกรรม เรื่อง หลักเกณฑ์และเงื่อนไขในการนำผลิตภัณฑ์อุตสาหกรรมเข้ามาในราชอาณาจักร
            เพื่อผลิต ผสม ประกอบ บรรจุ หรือดำเนินการด้วยวิธีอื่นใดกับผลิตภัณฑ์อุตสาหกรรมนั้นแล้วส่งออกไปนอก
            ราชอาณาจักรทั้งหมด ประกาศ ณ วันที่ ๖ สิงหาคม ๒๕๖๒ หากฝ่าฝืนไม่ปฏิบัติตามหลักเกณฑ์จะมีบทระวางโทษ
            ตามมาตรา ๔๘ ทวิ แห่งพระราชบัญญัติมาตรฐานผลิตภัณฑ์อุตสาหกรรม พ.ศ. ๒๕๑๑ และที่แก้ไขเพิ่มเติม
        </p>

                <div class="row">
                <div style="float: left; width: 200px; text-indent: 100px;">
                    ออกให้ ณ วันที่
                </div>
                <div style="float: left; width: 120px; text-align: center; line-height: 23px;" class="free-dot">
                    {{ $day_use }}
                </div>
                <div style="float: left; width: 40px;">
                    เดือน
                </div>
                <div style="float: left; width: 200; text-align: center; line-height: 23px;" class="free-dot">
                    {{ $month_use }}
                </div>
                 <div style="float: left; width: 40px;">
                    พ.ศ.
                </div>
                <div style="float: left; width: auto; text-align: center; line-height: 23px;" class="free-dot">
                    {{ $year_use }}
                </div>
                <div style="clear: both; margin: 0pt; padding: 0pt;"></div>
            </div>


        <div class="space-mini"></div>
        <p style="text-align: right; padding-right: 15px;">
            {{$signer_name}}<br>
            ตำแหน่ง {{ $signer_position }}
        </p>
        <div class="space-mini"></div>

    <p style="text-align: justify;">
        <div class="row">
            <div style="float: right; width: 170px; text-align: right;">
                เจ้าของหรือผู้รับมอบอำนาจ
            </div>
            <div style="float: left; width: 50px;">
                ข้าพเจ้า
            </div>
            <div style="float: left; width: auto; text-align: left; line-height: 23px;" class="free-dot">
                {!! str_repeat("&nbsp;", 10) !!} {{ $applicant_name }}
            </div>
            <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
        </div>
        <div class="row">
            <div style="float: right; width: 140px; text-align: right;">
                ตามหนังสือมอบอำนาจ
            </div>
            <div style="float: left; width: 138px;">
                บริษัทหรือห้างหุ้นส่วน
            </div>
            <div style="float: left; width: auto; text-align: left; line-height: 23px;" class="free-dot">
                {!! str_repeat("&nbsp;", 10) !!} {{ $created_name }}
            </div>
            <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
        </div>
        <div class="row">
            <div style="float: right; width: 302px; text-align: right;">
                ได้รับใบรับแจ้งการนำเข้าผลิตภัณฑ์อุตสาหกรรมเข้า
            </div>
            <div style="float: left; width: 48px;">
                ลงวันที่
            </div>
            <div style="float: left; width: auto; text-align: left; line-height: 23px;" class="free-dot">
                {!! str_repeat("&nbsp;", 10) !!} {{ HP::toThaiNumber(HP::formatDateThaiFull($approved_date)) }}
            </div>
            <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
        </div>
        <p class="main">
            มาในราชอาณาจักรเพื่อผลิต ผสม ประกอบ บรรจุ หรือดำเนินการด้วยวิธีอื่นใดกับผลิตภัณฑ์อุตสาหกรรมนั้นแล้ว
            ส่งออกไปนอกราชอาณาจักรทั้งหมดแล้ว และยินยอมปฏิบัติตามหลักเกณฑ์และเงื่อนไขที่คณะกรรมการมาตรฐาน
            ผลิตภัณฑ์อุตสาหกรรมกำหนดไว้ทุกประการ
        </p>

        <div class="space-mini"></div>
        <p style="text-align: right; padding-right: 15px;">{{ $applicant_name }} <br>
            ตำแหน่ง {{ $applicant_position }} <br>
            วันที่ {{ HP::toThaiNumber(HP::formatDateThaiFull($approved_date)) }}
        </p>
    </p>

    </div>

</body>
