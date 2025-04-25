<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class TransactionPayIn extends Model
{
    use Sortable;
    protected $table = "app_certi_transaction_pay_in";
    protected $primaryKey = 'id';
    protected $fillable = ['ref_id', 'table_name','certify','amount','running_no','Ref_1','Ref_2','BarCode','state','created_by','updated_by',
                            'returnCode','appno','bus_name','address','allay','village_no','road','district_id',
                            'amphur_id','province_id','postcode','email','vatid','Perpose','billNo','invoiceStartDate',
                            'invoiceEndDate','allAmountTH','barcodeString','barcodeSub','QRCodeString',
                            'app_certi_assessment_id','amount_bill','status_confirmed','auditor',
                            'BankCode','BillCreateDate','Etc1Data','Etc2Data','InvoiceCode','PaymentDate','ReceiptCode','ReceiptCreateDate','ReconcileDate','SourceID','PayAmountBill','app_no','ref1','suffix','count','CGDRef1'
                            ];
 
 public function getFormatAddressAttribute() {
    $address   = [];
    $address[] = @$this->address;

        if($this->village_no!='' && $this->village_no !='-'  && $this->village_no !='--'){
          $address[] =  "หมู่ที่ " . $this->village_no;
        }
        if($this->allay!='' && $this->allay !='-'  && $this->allay !='--'){
            $address[] = "ซอย "  . $this->allay;
        }
        if($this->road !='' && $this->road !='-'  && $this->road !='--'){
            $address[] =  "ถนน "  . $this->road;
        }
        if($this->province_id!=''){
            $address[] =  "จังหวัด " . $this->province_id;
        }
        if($this->amphur_id!=''){
            $address[] =  "เขต/อำเภอ " . $this->amphur_id;
        }
        if($this->district_id!=''){
            $address[] =  "แขวง/ตำบล " . $this->district_id;
        }
        if($this->postcode!=''){
            $address[] =  "รหัสไปรษณีย " . $this->postcode;
        }
    return implode(' ', $address);
    }
}
