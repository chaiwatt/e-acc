<div class="m-l-10 form-group">
    <h4 class="m-l-5">4.การปฏิบัติของห้องปฏิบัติการที่สอดคล้องตามข้อกำหนดมาตรฐานเลขที่ มอก. 17025 – 2561 (ISO/IEC 17025 : 2017)</h4>
</div>
<table class="table table-bordered" id="myTable">
    <thead>
    <tr>
        <th class="text-center col-xs-5">รายการ</th>
        <th class="text-center col-xs-1">โปรดทำเครื่องหมาย √</th>
        <th class="text-center col-xs-2">อ้างอิงตาม มอก. 17025:ข้อ</th>
        <th class="text-center text-danger col-xs-2">อ้างอิงตามชื่อเอกสารหรือชื่อหลักฐานต่างๆที่เกี่ยวข้องของห้องปฏิบัติการที่แนบ</th>
        <th class="text-center col-xs-2">หมายเหตุ (Note)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><span class="font-18" style="text-decoration: underline">(1) ข้อกำหนดทั่วไป</span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;1. ความเป็นกลาง</span><br>
            &emsp;&emsp;1.1. ดำเนินการอย่างเป็นกลาง โดยปราศจากความกดดันด้านการค้า การเงินหรือความกดดันอื่นๆเพื่อประนีประนอมความเป็นกลาง
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a1_1_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">4.1</td>
        <td class="text-center">
            <input type="text" name="a_1_text" value="{{$certi_lab_check_box->a1_1_1_name}}" disabled="">
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.2. ระบุความเสี่ยงต่อความเป็นกลางในกิจกรรมที่ทำอย่าง
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a1_1_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">4.1</td>
        <td class="text-center">
            <input type="text" name="a_2_text" value="{{$certi_lab_check_box->a1_1_2_name}}" disabled="">
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;2. การรักษาความลับ </span><br>
            &emsp;&emsp;เก็บข้อมูลของลูกค้าเป็นความลับ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a1_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">4.2</td>
        <td class="text-center">
            <input type="text" name="a_3_text" value="{{$certi_lab_check_box->a1_2_name}}" disabled="">
        </td>
        <td></td>
    </tr>
    <tr>
        <td><span class="font-18" style="text-decoration: underline">(2) ข้อกำหนดด้านโครงสร้าง</span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;1. ระบุผู้รับผิดชอบการบริหารงานทั้งหมดของห้องปฏิบัติการ</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a2_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">5.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a2_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;2. ระบุไว้เป็นเอกสารเกี่ยวกับช่วงของกิจกรรมของห้องปฏิบัติการที่เป็นไปตามมาตรฐานนี้ </span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a2_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">5.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a2_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;3. ดำเนินกิจกรรมให้สอดคล้องกับข้อกำหนดในมาตรฐานนี้ และเป็นไปตามความต้องการของลูกค้าหน่วยงานผู้มีอำนาจตามกฎหมายและองค์การที่ให้การยอมรับ</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a2_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">5.4</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a2_3_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;4. กำหนดโครงสร้างองค์การ และการบริหารงานของห้องปฏิบัติการ</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a2_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">5.5 (a)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a2_4_name }}" disabled>

        </td>
        <td class="text-center text-danger" rowspan="2">ต้องแนบผังโครงสร้างองค์กร</td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;5. ระบุความรับผิดชอบอำนาจหน้าที่ และความสัมพันธ์ระหว่างบุคลากรทั้งหมดที่ทำหน้าที่บริหารปฏิบัติการหรือทวนสอบงานที่กระทบต่อผลของกิจกรรมห้องปฏิบัติการ</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a2_5_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">5.5 (b)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a2_5_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;6. จัดทำเอกสารขั้นตอนการดำเนินงานต่างๆที่จำเป็นเพื่อให้มั่นใจว่ามีการนำไปใช้ในกิจกรรมของห้องปฏิบัติการ และให้ผลที่ใช้ได้</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a2_6_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">5.5 (c)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a2_6_name }}" disabled>

        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;7. มีบุคลากรซึ่งมีอำนาจหน้าที่ และทรัพยากรที่จำเป็นต่อการนำไปปฏิบัติรักษาไว้ และปรับปรุงระบบการบริหารงานรวมถึงชี้บ่งความเบี่ยงเบนชี้นำสู่การป้องกันรายงานต่อผู้บริหารเกี่ยวกับประสิทธิภาพของระบบการบริหารงานและทำให้มั่นใจในประสิทธิผลของกิจกรรมของห้องปฏิบัติการ</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a2_7_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">5.6</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a2_7_name }}" disabled>

        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;8. มีการสื่อสารเกี่ยวกับความมีประสิทธิผลของระบบการบริหารงาน และระบบการบริหารงานยังคงความสมบูรณ์ไว้ได้เมื่อมีการเปลี่ยนแปลงระบบการบริหารงาน ซึ่งได้มีการวางแผนและนำไปปฏิบัติแล้ว</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a2_8_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">5.7</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a2_8_name }}" disabled>

        </td>
        <td></td>
    </tr>
    <tr>
        <td><span class="font-18" style="text-decoration: underline">(3) ข้อกำหนดด้านทรัพยากร</span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;1. บุคลากร</span><br>
            &emsp;&emsp;1.1. บุคลากรทั้งหมดไม่ว่าจากภายในหรือจากภายนอก ต้องแสดงความเป็นกลาง ความสามารถและปฏิบัติงานตามระบบการบริหารงาน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_1_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.2.1</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_1_1_name }}" disabled>

        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.2. จัดทำเอกสารเกี่ยวกับข้อกำหนดความสามารถของแต่ละหน้าที่ที่มีอิทธิพลต่อผลของกิจกรรมห้องปฏิบัติการ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_1_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.2.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_1_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.3. บุคลากรมีความสามารถปฏิบัติงานในส่วนที่ตนรับผิดชอบและมีความสามารถในการประเมินความเบี่ยงเบนที่มีนัยสำคัญ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_1_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.2.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_1_3_name }}" disabled>

        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.4. สื่อสารกับบุคลากร เกี่ยวกับหน้าที่ ความรับผิดชอบและอำนาจหน้าที่
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_1_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.2.4</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_1_4_name }}" disabled>

        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.5. มีขั้นตอนการปฏิบัติงานและการเก็บรักษาบันทึกเกี่ยวกับการตรวจสอบความสามารถ การคัดเลือก การฝึกอบรม การกำกับดูแล การมอบหมายหน้าที่ และการเฝ้าระวังความสามารถของบุคลากร
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_1_5_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.2.5</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_1_5_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.6. มอบหมายงานเฉพาะแก่บุคลากรในการพัฒนา ทวนสอบ และตรวจสอบความใช้ได้ของวิธี รวมถึงวิเคราะห์ผล รายงาน ทบทวน และอนุมัติผล
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_1_6_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.2.6</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_1_6_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;2. สิ่งอำนวยความสะดวกและภาวะแวดล้อม </span><br>
            &emsp;&emsp;มีสิ่งอำนวยความสะดวกและภาวะแวดล้อมที่เหมาะสมต่อการปฏิบัติกิจกรรมของห้องปฏิบัติการ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_2_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.3.1</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_2_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-14" style="font-weight: 200;">&emsp;&emsp;โดย</span><br>
            &emsp;&emsp;• ข้อกำหนดที่จำเป็นมีการจัดทำเป็นเอกสาร
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_2_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">6.3.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_2_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• มีการควบคุม เฝ้าระวัง และบันทึกภาวะแวดล้อม
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_2_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.3.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_2_3_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• มีมาตรการควบคุม เฝ้าระวัง ทบทวนในการเข้า – ออกพื้นที่ การป้องกันการปนเปื้อน และการแบ่งแยกกิจกรรมที่เข้ากันไม่ได้
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_2_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center">6.3.4</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_2_4_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;3. เครื่องมือ </span><br>
            &emsp;&emsp;3.1. สามารถเข้าถึงเครื่องมือที่ต้องใช้สำหรับการดำเนินกิจกรรมของห้องปฏิบัติการให้ถูกต้องและที่สามารถส่งผลกระทบต่อผลการปฏิบัติงาน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.4.1</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.2. มั่นใจกรณีที่มีการใช้เครื่องมือที่อยู่นอกเหนือการควบคุมแบบถาวรเป็นไปตามข้อกำหนดของมาตรฐานนี้
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif
        </td>
        <td class="text-center">6.4.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_2_name }}" disabled>

        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.3. มีขั้นตอนการดำเนินงานเกี่ยวกับการจัดการ การเคลื่อนย้าย การเก็บรักษา การใช้ และการบำรุงรักษาเครื่องมือตามแผนที่กำหนดไว้
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">6.4.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_3_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.4. มีการทวนสอบเครื่องมือว่า เป็นไปตามข้อกำหนดเฉพาะ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif           </td>
        <td class="text-center">6.4.4</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_4_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.5. เครื่องมือที่ใช้ในการวัดสามารถให้ผลการวัดที่แม่นยำ และ/หรือให้ค่าความไม่แน่นอนตามที่ต้องการ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_5_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center">6.4.5</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_5_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.6. เครื่องมือวัดได้รับการสอบเทียบ เมื่อความแม่นยำของการวัดหรือความไม่แน่นอนของการวัดมีผลต่อความใช้ได้ของผลที่รายงาน และ/หรือ เพื่อให้ผลที่รายงานสามารถสอบกลับได้ทางมาตรวิทยา
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_6_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center">6.4.6</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_6_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.7. มีโปรแกรมการสอบเทียบเครื่องมือต่างๆ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_7_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">6.4.7</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_7_name }}" disabled>
        </td>
        <td class="text-danger text-center">ต้องแนบโปรแกรมการสอบเทียบเครื่องมือทั้งหมดที่เกี่ยวข้อง</td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.8. มีการแสดงสถานะการสอบเทียบของเครื่องมือ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_8_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center">6.4.8</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_8_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.9. มีขั้นตอนจัดการเครื่องมือซึ่งไม่เป็นไปตามเกณฑ์ที่กำหนด และตรวจสอบผลกระทบจากการบกพร่องหรือการเบี่ยงเบนจากเกณฑ์กำหนดที่ระบุไว้
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_9_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center">6.4.9</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_9_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.10. มีขั้นตอนดำเนินการตรวจสอบเครื่องมือระหว่างการใช้งาน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_10_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">6.4.10</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_10_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.11. มั่นใจว่าค่าอ้างอิงหรือค่าแก้ไขนั้น ได้รับการปรับให้ทันสมัยและถูกนำไปใช้ตามความเหมาะสม
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_11_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">6.4.11</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_11_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.12. มีมาตรการป้องกันการปรับแต่งเครื่องมือโดยไม่ตั้งใจ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_12_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">6.4.12</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_12_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;3.13. จัดเก็บบันทึกต่างๆ เกี่ยวกับประวัติเครื่องมือ รวมถึงวัสดุอ้างอิงต่างๆ อย่างครบถ้วน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_3_13_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">6.4.13</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_3_13_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;4. ความสอบกลับได้ทางมาตรวิทยา  </span><br>
            &emsp;&emsp;จัดทำและคงไว้ซึ่งความสามารถสอบกลับได้ทางมาตรวิทยาไปยัง SI units หรือสิ่งอ้างอิงที่เหมาะสม
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_4_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">6.5</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_4_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;5. ผลิตภัณฑ์และบริการจากภายนอก   </span><br>
            &emsp;&emsp;มีขั้นตอนการดำเนินงานและการจัดเก็บบันทึกต่างๆ เพื่อให้มั่นใจว่ามีการใช้ผลิตภัณฑ์และบริการจากภายนอกที่มีผลต่อกิจกรรมของห้องปฏิบัติการอย่างเหมาะสม และมีการสื่อสารความต้องการต่างๆ ให้ผู้ให้บริการจากภายนอกทราบอย่างชัดเจน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a3_5_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">6.6</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a3_5_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td><span class="font-18" style="text-decoration: underline">(4) ข้อกำหนดด้านกระบวนการ </span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;1. การทบทวนคำขอ ข้อเสนอการประมูล และข้อสัญญา </span><br>
            &emsp;&emsp;1.1. มีขั้นตอนการดำเนินงานสำหรับการทบทวนคำขอ ข้อเสนอการประมูลและข้อสัญญา
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_1_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.1.1</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_1_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.2. แจ้งให้ลูกค้าทราบ เมื่อวิธีการที่ลูกค้าร้องขอไม่เหมาะสมหรือล้าสมัย
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_1_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.1.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_1_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.3. ระบุ แจ้งและตกลงเกณฑ์การตัดสินไว้อย่างชัดเจนระหว่างห้องปฏิบัติการและลูกค้า เมื่อต้องการระบุความเป็นไปตามการทดสอบหรือการสอบเทียบ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_1_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.1.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_1_3_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.4. ข้อสัญญามีการยอมรับโดยห้องปฏิบัติการและลูกค้า การเบี่ยงเบนใดๆ จากข้อสัญญาต้องแจ้งลูกค้า และต้องไม่ส่งผลกระทบ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_1_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.1.4 - 7.1.6</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_1_4_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.5. ประสานงานกับลูกค้าหรือผู้แทนให้ชัดเจน เกี่ยวกับคำขอของลูกค้าและการเฝ้าระวังสมรรถนะของห้องปฏิบัติการในส่วนที่เกี่ยวข้องกับงานที่ทำ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_1_5_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.1.7</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_1_5_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;1.6. จัดเก็บบันทึกการทบทวน การเปลี่ยนแปลงใดๆ รวมถึงการสนทนาข้อปัญหากับลูกค้าเกี่ยวกับความต้องการของลูกค้า หรือผล
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_1_6_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.1.8</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_1_6_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;2. การเลือก การทวนสอบ และการตรวจสอบความใช้ได้ของวิธี  </span><br>
            &emsp;&emsp;2.1. ใช้วิธี ขั้นตอนการดำเนินงานและเอกสารสนับสนุนและที่เกี่ยวข้องทั้งหมดเหมาะสมสำหรับกิจกรรมของห้องปฏิบัติการ โดยปรับปรุงให้ทันสมัยอยู่เสมอและจัดให้มีไว้พร้อมสำหรับเจ้าหน้าที่ที่ใช้งาน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_2_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.2.1.1 , 7.2.1.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_2_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;2.2. มั่นใจว่าใช้วิธีที่ใช้ได้ล่าสุด (ถ้าเหมาะสมหรือทำได้) และมีรายละเอียดเพิ่มเติม (ถ้าจำเป็น) เพื่อให้นำวิธีเหล่านั้นไปใช้ได้ตรงกัน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_2_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.2.1.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_2_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;2.3. เลือกวิธีที่เหมาะสมและแจ้งให้ลูกค้าทราบ ในกรณีที่ลูกค้าไม่ได้ระบุวิธี
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_2_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.2.1.4</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_2_3_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;2.4. ทำการทวนสอบความสามารถในการปฏิบัติตามวิธี และจัดเก็บบันทึกไว้
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_2_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.2.1.5</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_2_4_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;2.5. หากต้องมีการพัฒนาวิธี ได้มีการวางแผนและมอบหมายบุคลากรที่มีความสามารถ พร้อมทรัพยากรอย่างเพียงพอ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_2_5_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.2.1.6</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_2_5_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;2.6. การเบี่ยงเบนไปจากวิธี มีการจัดทำเป็นเอกสาร ตัดสินความถูกต้องทางวิชาการ มอบหมายงาน และได้รับการยอมรับจากลูกค้าแล้ว
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_2_6_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.2.1.7</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_2_6_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;2.7 การตรวจสอบความใช้ได้ของวิธี (Validation of methods) ตรวจสอบความใช้ได้ของวิธีที่ไม่เป็นมาตรฐาน วิธีที่ห้องปฏิบัติการพัฒนาขึ้นเอง และวิธีตามมาตรฐานที่ถูกใช้นอกขอบข่ายที่กำหนดไว้หรือมีการดัดแปลงวิธี
            มาตรฐาน โดนการตรวจสอบต้องสอดคล้องกับความต้องการของลูกค้าและข้อกำหนดที่ระบุ และตรวจสอบความใช้ได้ใหม่ หากวิธีมีการเปลี่ยนแปลงและส่งผลกระทบ และจัดเก็บบันทึกการตรวจสอบความใช้ได้ไว้
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_2_7_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.2.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_2_7_name }}" disabled>
        </td>
        <td class="text-danger text-center">ต้องแนบเอกสารวิธีการและผลการตรวจสอบความใช้ได้ของวิธี กรณีใช้วิธีที่ไม่เป็นมาตรฐาน</td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;3. การชักตัวอย่าง </span><br>
            &emsp;&emsp;มีแผนการชักตัวอย่างและวิธีการที่เหมาะสม ณ สถานที่ที่ทำกิจกรรมการชักตัวอย่าง และเก็บรักษาบันทึกข้อมูลต่างๆ ในการชักตัวอย่าง
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_3_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_3_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;4. การจัดการตัวอย่างทดสอบหรือสอบเทียบ</span><br>
            &emsp;&emsp;มีขั้นตอนการดำเนินงานในการขนส่ง การรับ การจัดการ การป้องกัน การเก็บรักษา การจัดเก็บ การทำลายหรือการส่งคืนตัวอย่างสำหรับการทดสอบหรือการสอบเทียบ มีรายการชี้บ่ง
            ตัวอย่าง และบันทึกความเบี่ยงเบนจากสภาวะที่กำหนดขณะรับตัวอย่าง เก็บผลการปรึกษากับลูกค้าและบันทึกการเฝ้าระวังสภาวะการเก็บตัวอย่าง
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_4_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.4</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_4_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;5.	บันทึกทางด้านวิชาการ </span><br>
            &emsp;&emsp;การจัดเก็บและรักษาบันทึกทางด้านวิชาการประกอบด้วยข้อมูลที่เพียงพอเพื่อให้สามารถทำกิจกรรมของห้องปฏิบัติการซ้ำภายใต้ภาวะที่ใกล้เคียงกับครั้งแรกเท่าที่เป็นไปได้ และกรณีมีการแก้ไขสามารถสอบย้อนกลับไปยังข้อมูลเดิมได้
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_5_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.5</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_5_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;6. การประมาณค่าความไม่แน่นอนของการวัด</span><br>
            &emsp;&emsp;มีการระบุองค์ประกอบต่างๆ ทั้งหมด ที่มีผลต่อความไม่แน่นอนของการวัด และทำการประมาณค่าความไม่แน่นอนของการวัด โดยวิธีวิเคราะห์ที่เหมาะสม ทั้งกิจกรรมสอบเทียบ รวมถึงการสอบเทียบภายใน การทดสอบ และการชักตัวอย่าง
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_6_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.6</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_6_1_name }}" disabled>
        </td>
        <td class="text-center text-danger">ต้องแนบตัวอย่างวิธีการประมาณค่าความไม่แน่นอนของการวัดในแต่ละวิธี ทุกวิธีที่ขอการรับรอง</td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;7. การมั่นใจความใช้ได้ของผล</span><br>
            &emsp;&emsp;7.1. มีแผนและขั้นตอนการดำเนินงานในการเฝ้าระวังความใช้ได้ของผล บันทึกและทบทวนผลโดยวิธีทางสถิติที่เหมาะสม
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_7_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.7.1</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_7_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;7.2. เฝ้าระวังความสามารถโดยการเปรียบเทียบผลกับห้องปฏิบัติการอื่น ตามแผนการเข้าร่วมการทดสอบความชำนาญ และ/หรือ การเข้าร่วมในการเปรียบเทียบผลระหว่างห้องปฏิบัติการ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_7_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.7.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_7_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;7.3. ข้อมูลที่ได้จากการเฝ้าระวังมีการวิเคราะห์และดำเนินการอย่างเหมาะสม เมื่อพบว่าอยู่นอกเกณฑ์ที่กำหนดไว้ล่วงหน้า
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_7_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center">7.7.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_7_3_name }}" disabled>
        </td>
        <td></td>
    </tr>

    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;8. การรายงานผล</span><br>
            &emsp;&emsp;8.1. จัดทำรายงานอย่างถูกต้อง ชัดเจน ไม่คลุมเครือ และตรงตามวัตถุประสงค์ มีการทบทวนและอนุมัติก่อนออกรายงาน และมีข้อตกลงกับลูกค้า กรณีออกรายงานแบบง่ายๆ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_8_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.8.1</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_8_1_name }}" disabled>
        </td>
        <td class="text-danger text-center" rowspan="1">ต้องแนบตัวอย่างรายงานและกระบวนการออกรายงานผล</td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;8.2. รายงานผลการทดสอบ การสอบเทียบ หรือการชักตัวอย่าง อย่างน้อยต้องประกอบด้วยข้อมูลตาม มอก. 17025 ข้อ 7.8.2.1 และชี้บ่งอย่างชัดเจนในส่วนที่เป็นข้อมูลจากลูกค้า และห้องปฏิบัติการเป็นผู้รับผิดชอบข้อมูลทั้งหมดในรายงาน แต่ปฏิเสธความรับผิดชอบในส่วนข้อมูลที่ได้จากลูกค้า
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_8_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.8.2</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_8_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;8.3. นอกจากข้อมูลตาม มอก. 17025 ข้อ 7.8.2 แล้ว กรณีจำเป็นต้องแปลผลการทดสอบรายงานผลการทดสอบจะมีข้อมูลเพิ่มเติมตาม มอก. 17025 ข้อ 7.8.3.1 และ 7.8.5 (กรณีทำกิจกรรมชักตัวอย่าง)
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_8_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.8.3</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_8_3_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;8.4. ใบรับรองการสอบเทียบจะมีข้อมูลเพิ่มเติมตาม  มอก.17025 ข้อ 7.8.4.1 และ 7.8.5 (กรณีทำกิจกรรมชักตัวอย่าง)
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_8_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.8.4</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_8_4_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;8.5. การรายงานการชักตัวอย่างจะมีข้อมูลเพิ่มเติมตาม มอก.17025 ข้อ 7.8.5
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_8_5_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.8.5</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_8_5_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;8.6. การรายงานความสอดคล้องตามข้อกำหนดมีเกณฑ์การตัดสิน จัดทำไว้เป็นเอกสารและนำไปใช้โดยระบุในรายงานอย่างชัดเจน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_8_6_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.8.6</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_8_6_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;8.7. การรายงานข้อคิดเห็นและการแปลผล ทำโดยบุคลากรที่ได้รับมอบหมาย ภายใต้พื้นฐานการแสดงข้อคิดเห็นหรือการแปลผลที่จัดทำเป็นเอกสารไว้ ระบุอย่างชัดเจน และเก็บรักษาบันทึกการสนทนากับลูกค้า
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_8_7_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.8.7</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_8_7_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;8.8. การแก้ไขรายงานมีการระบุอย่างชัดเจน รวมถึงเหตุผล (ถ้าเหมาะสม) โดยการออกเอกสารเพิ่มเติม หรือการถ่ายโอนข้อมูล กรณีออกรายงานฉบับใหม่ทดแทน มีการชี้บ่งเฉพาะและอ้างอิงรายงานฉบับเดิม
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_8_8_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.8.8</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_8_8_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;9. ข้อร้องเรียน </span><br>
            &emsp;&emsp;มีเอกสารกระบวนการรับ ประเมิน และตัดสินข้อร้องเรียน และมีให้ผู้มีส่วนได้ส่วนเสียหากร้องขอ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_9_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">7.9</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_9_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;10. งานที่ไม่เป็นไปตามข้อกำหนด </span><br>
            &emsp;&emsp;มีขั้นตอนการดำเนินงานสำหรับจัดการงานที่ไม่เป็นไปตามข้อกำหนดที่เหมาะสมตาม มอก. 17025 ข้อ 7.10.1 และจัดเก็บบันทึกต่างๆ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_10_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">7.10</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_10_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;11. การควบคุมข้อมูลและการจัดการสารสนเทศ  </span><br>
            &emsp;&emsp;มีการเข้าถึงข้อมูลและสารสนเทศที่จำเป็นในการปฏิบัติงานกิจกรรมต่างๆของห้องปฏิบัติการ รวมถึงการคำนวณและการถ่ายโอนข้อมูลต้องได้รับการตรวจสอบอย่างเหมาะสมและเป็นระบบ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_11_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center">7.11</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_11_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• ระบบการจัดการข้อมูลมีการตรวจสอบความใช้ได้ มีระบบป้องกัน ใช้งานในสภาวะเหมาะสม บำรุงรักษา และเก็บบันทึกการแก้ไข
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_11_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center"></td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_11_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• มั่นใจว่าใช้ผู้บริการจากภายนอกในการจัดการข้อมูลหรือบำรุงรักษาที่เหมาะสม
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_11_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center"></td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_11_3_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• มั่นใจว่ามีคู่มือ ข้อมูลอ้างอิงต่างๆ พร้อมให้บุคลากรใช้งาน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a4_11_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center"></td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a4_11_4_name }}" disabled>
        </td>
        <td></td>
    </tr>

    <tr>
        <td><span class="font-18" style="text-decoration: underline">(5) ข้อกำหนดด้านระบบการบริหารงาน</span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;1. จัดทำระบบ มีเอกสาร นำไปใช้ และรักษาระบบการบริหารงานให้สอดคล้องกับข้อกำหนด </span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_1_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">8.1</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_1_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;2. จัดทำระบบ มีเอกสารและรักษานโยบายและวัตถุประสงค์ให้เป็นไปตามความมุ่งหมายของมาตรฐานนี้</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_2_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">8.2 (option A)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_2_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• มีนโยบายและวัตถุประสงค์ที่เกี่ยวกับความสามารถ ความเป็นกลาง และการปฏิบัติงานอย่างมีเสถียรภาพของห้องปฏิบัติการ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_2_2_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center"></td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_2_2_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• มีหลักฐานแสดงความมุ่งมั่นของผู้บริหารห้องปฏิบัติการ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_2_3_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center"></td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_2_3_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• เอกสาร กระบวนการ ระบบ และบันทึกทั้งหมด ต้องครอบคลุม อ้างอิง หรือเชื่อมโยงกับระบบบริหารงาน
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_2_4_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif          </td>
        <td class="text-center"></td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_2_4_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            &emsp;&emsp;• บุคลากรที่เกี่ยวข้องสามารถเข้าถึงเอกสารและข้อมูลต่างๆ ที่เกี่ยวข้องในความรับผิดชอบ
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_2_5_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center"></td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_2_5_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;3. ควบคุมเอกสารที่เกี่ยวข้อง (ทั้งภายในและภายนอก) อย่างเหมาะสม และเป็นไปตาม มอก. 17025 ข้อ 8.3.2 </span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_3_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">8.3 (option A)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_3_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;4. มีการจัดทำ และเก็บรักษาบันทึก รวมทั้งมีการควบคุมที่จำเป็นสำหรับการชี้บ่ง การเก็บรักษา การป้องกัน การสำรอง การเก็บประวัติข้อมูล การเรียกคืน ระยะเวลาการจัดเก็บ และการทำลายบันทึกของห้องปฏิบัติการ </span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_4_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">8.4 (option A)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_4_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;5. พิจารณาถึงความเสี่ยงและโอกาสที่เกี่ยวข้องกับกิจกรรมของห้องปฏิบัติการ โดยมีแผนการดำเนินการจัดการความเสี่ยง และโอกาสที่ได้สัดส่วนกับผลกระทบ และประเมินประสิทธิผล</span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_5_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">8.5 (option A)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_5_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;6. ระบุและเลือกโอกาสทำการปรับปรุงระบบโดยดำเนินการต่างๆ ที่จำเป็น และวิเคราะห์ผลสะท้อนกลับจากลูกค้า เพื่อนำไปใช้ในการปรับปรุงระบบการบริหารงาน กิจกรรมของห้องปฏิบัติการ และการบริการลูกค้า </span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_6_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">8.6 (option A)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_6_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;7. มีการปฏิบัติการแก้ไขตาม มอก. 17025 ข้อ 8.7.1 ให้เหมาะสมกับผลกระทบและเก็บบันทึกเป็นหลักฐาน </span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_7_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">8.7 (option A)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_7_1_name }}" disabled>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;8. ทำการตรวจติดตามภายใน ตามช่วงเวลาที่วางแผนไว้ โดยจัดทำโปรแกรมรายงานผลต่อผู้บริหาร ทำการแก้ไข และเก็บบันทึก </span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_8_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif        </td>
        <td class="text-center">8.8 (option A)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_8_1_name }}" disabled>
        </td>
        <td class="text-danger text-center">ต้องแนบแผน/ผลการตรวจติดตามภายใน</td>
    </tr>
    <tr>
        <td>
            <span class="font-16" style="font-weight: 500">&emsp;9. ทบทวนระบบการบริหารของห้องปฏิบัติการตามช่วงเวลาที่วางแผนไว้ และเก็บบันทึกการทบทวนให้มีข้อมูลครบถ้วนตามมอก. 17025 ข้อ 8.9.2 </span>
        </td>
        <td class="text-center">
            @if ($certi_lab_check_box->a5_9_1_check === 0)
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" checked disabled>
            @else
                <input type="checkbox" class="check" data-radio="iradio_square-green" value="0" disabled>
            @endif         </td>
        <td class="text-center">8.9 (option A)</td>
        <td class="text-center">
            <input type="text" name="a_4_text" value="{{ $certi_lab_check_box->a5_9_1_name }}" disabled>
        </td>
        <td class="text-danger text-center">ต้องแนบแผน/ผลการทบทวนระบบการบริหาร</td>
    </tr>
    </tbody>
</table>
<div class="form-group" style="margin-bottom: 10px;margin-left: 10px">
    {!! Form::label('attach', 'เอกสาร/หลักฐานอื่นๆ:', ['class' => 'm-r-15 m-t-5']) !!}
{{--    <button type="button" class="btn btn-sm btn-success" id="attach-add">--}}
{{--        <i class="icon-plus"></i>&nbsp;เพิ่ม--}}
{{--    </button>--}}
</div>

@if (!is_null($certi_lab_check_box_image) && $certi_lab_check_box_image->count() > 0)
    <div class="container-fluid">
        <div class="col-md-12" style="padding-left: 4rem;padding-right: 4rem;padding-bottom: 10px">
            <table class="table table-bordered" id="myTable_labTest">
                <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white col-xs-4">ชื่อไฟล์</th>
                    <th class="text-center text-white col-xs-3">ดาวน์โหลด</th>
                </tr>
                </thead>
                <tbody>
                @foreach($certi_lab_check_box_image as $show)
                    <tr>
                        @if ($show->path_image)
                            <td class="text-center">
                                {{$show->name}}
                            </td>
                            <td class="text-center">
                                <a href="{{url('check/files/'.basename($show->path_image))}}" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="font-size:25px; color:red" aria-hidden="true"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
