<style>
    @page {
        margin:2%;padding:0;
    }
    body {
        font-family: 'THSarabunNew', sans-serif;
    }
    .content{
        /* border: 5px solid #d4af37; */
        padding: 5%;
        margin: 0px;
        height: 100%;
        top: 10%;
        position: relative;

    }
    .tc{
        text-align: center;
    }
    .tl{
        text-align: left;
    }
    div{
        width: 100%;
    }
    h1,h2,h3,h4,h5,h6,p{
        padding: 0px;
        margin: 0px;
        line-height: 2em;
    }
    .space{
        height: 20px;
    }
    .space-mini{
        height: 10px;
    }
    b{
        font-weight: bold;
    }
    h1{
        margin-bottom: 10px;
    }
    .w-100{
        width: 100%;
    }
    .tab {
        display:inline-block;
        margin-left: 40px;
    }
    .tr{
        text-align: right;
    }
    .w-66{
        width: 66%;
    }
    .w-70{
        width: 70%;
    }
    .w-33{
        width: 33%;
    }
    .w-15{
        width: 15%;
    }
    .w-50{
        width: 50%;
    }
    table{
        line-height: 2em;
        font-size: 1.2em;
    }

</style>

<body>
<p style="text-align: right; padding-right: 15px;">
    เลขที่ {{ $numberforshow }}
</p>
<div class="content">
    <div class="tc">
        <img src="{{ asset('images/certificate-header.jpg') }}" width="100px"/>
    </div>
    <div class="tc">
        <div class="space"></div>
        <h1><strong>ใบรับแจ้ง</strong></h1>
        {{-- <h3><b>อาศัยอำนาจตามความในพระราชบัญญัติการมาตรฐานแห่งชาติ พ.ศ. {{ HP::toThaiNumber('2551')}} </b></h3> --}}
        <h2><strong>การทำเพื่อการส่งออกตามมาตรา ๒๐ ตรี</strong></h2>
        <p>อาศัยอำนาจตามความในพระราชบัญญัติมาตรฐานผลิตภัณฑ์อุตสาหกรรม พ.ศ. ๒๕๑๑</p>
        <p>แก้ไขเพิ่มเติมโดยพระราชบัญญัติมาตรฐานผลิตภัณฑ์อุตสาหกรรม (ฉบับที่ ๘) พ.ศ. ๒๕๖๒</p>

    </div>
        <p style="text-indent: 100px;">สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้รับแจ้งการทำผลิตภัณฑ์ตามมาตรา ๒๐ ตรี</p>
        <p>จาก {{ $created_name }}</p>
        <p>ตามเลขรับที่  {{ HP::toThaiNumber($ref_no_number) }}  วันที่ {{ HP::toThaiNumber(HP::formatDateThaiFull($approved_date)) }}</p>

        <p>
และได้ออกใบรับแจ้งฉบับนี้ไว้เพื่อเป็นหลักฐานการแจ้งแล้ว</p>
            <p style="text-indent: 100px;">
ทั้งนี้ ผู้ทำต้องปฏิบัติตามหลักเกณฑ์และเงื่อนไข ตามประกาศคณะกรรมการมาตรฐาน<br>
ผลิตภัณฑ์อุตสาหกรรม เรื่องหลักเกณฑ์และเงื่อนไขในการทำผลิตภัณฑ์อุตสาหกรรมที่แตกต่างไปจาก<br>
มาตรฐานที่กำหนด เพื่อประโยชน์ในการส่งออก ประกาศ ณ วันที่ ๑๙ กันยายน ๒๕๖๒ หากฝ่าผืนไม่ปฏิบัติ<br>
ตามหลักเกณฑ์จะมีบทระวางโทษตามมาตรา ๓๙ ตรี มาตรา ๔๘ ทวิ มาตรา ๓๖/๑ และมาตรา ๕๕ แห่ง<br>
พระราชบัญญัติมาตรฐานผลิตภัณฑ์อุตสาหกรรม พ.ศ.  ๒๕๑๑ และที่แก้ไขเพิ่มเติม
            </p>
        <p style="text-indent: 100px;">ออกให้ ณ {{ HP::toThaiNumber(HP::formatDateThai($approved_date)) }} </p>
        <p style="text-align: right; padding-right: 15px;">นางสาวจิรกัญญา อ่อนละออ <br>
            ตำแหน่ง นักจัดการงานทั่วไปชำนาญการพิเศษ</p>
                  <p>
ข้าพเจ้า      {{ $applicant_name }}                   เจ้าของหรือผู้รับมอบอำนาจ
บริษัทหรือห้างหุ้นส่วน     {{ $created_name }}                ตามหนังสือมอบอำนาจ
ลงวันที่          {{ HP::toThaiNumber(HP::formatDateThaiFull($approved_date)) }}                 ได้รับใบรับแจ้งการทำผลิตภัณฑ์อุตสาหกรรมที่
แตกต่างไปจากมาตรฐานที่กำหนด เพื่อประโยชน์ในการส่งออก จากสำนักงานฯ เรียบร้อยแล้ว และทราบว่า
จะต้องปฏิบัติตามหลักเกณฑ์และเงื่อนไข ตามประกาศคณะกรรมการมาตรฐานผลิตภัณฑ์อุตสาหกรรม ประกาศ
ณ วันที่ ๑๙ กันยายน ๒๕๖๒
            </p>
                    <p style="text-align: right; padding-right: 15px;">{{ $applicant_name }} <br>
            ตำแหน่ง {{ $applicant_position }} <br>
                        วันที่ {{ HP::toThaiNumber(HP::formatDateThaiFull($approved_date)) }}
        </p>
        <div class="space-mini"></div>
        {{-- <div class="space-mini"></div> --}}
    </div>

</body>
