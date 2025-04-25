<?php

use Faker\Factory;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\Permission;

class AdminSeeder extends DatabaseSeeder
{

    public function run()
    {

        $admin = User::where('agent_email','=','admin@admin.com')->first();
        if($admin == null){
            $admin = new User();
            $admin->agent_email = 'admin@admin.com';
            $admin->trader_date = date('Y-m-d');
            $admin->trader_inti = 'บริษัท จำกัด';
            $admin->trader_operater_name = 'บริษัท รามอินทราซอฟต์ จำกัด';
            $admin->trader_type = 'นิติบุคคล';
            $admin->trader_name = '';
            $admin->trader_id = '2845344898052';
            $admin->trader_id_register = date('Y-m-d');
            $admin->trader_boss = 'กรรมการผู้จัดการ';
            $admin->trader_address = '121/6';
            $admin->trader_address_soi = 'รามอินทรา 19';
            $admin->trader_address_road = 'รามอินทรา';
            $admin->trader_address_moo = '6';
            $admin->trader_address_tumbol = 'ท่าแร้ง';
            $admin->trader_address_amphur = 'บางเขน';
            $admin->trader_provinceID = 'กรุงเทพมหานคร';
            $admin->trader_address_poscode = '10220';
            $admin->trader_phone = '0-2552-8068';
            $admin->trader_phone_to = '';
            $admin->trader_fax = '';
            $admin->trader_fax_to = '';
            $admin->trader_mobile = '0811234567';
            $admin->agent_name = '';
            $admin->agent_position = '';
            $admin->agent_mobile = '';
            $admin->agent_officephone = '';
            $admin->agent_officephone_to = '';
            $admin->agent_fax = '';
            $admin->agent_offficefax_to = '';
            $admin->date_of_data = date('Y-m-d H:i:s');
            $admin->trader_password = '1234';
            $admin->trader_file_detial = '';

            $admin->save();
        }

        if($admin->profile == null){
            $profile = new \App\Profile();
            $profile->trader_id = $admin->runrecno;
            $profile->save();
        }

        //Creating Roles
        $admin_role = Role::firstOrcreate(['name' => 'admin']);
        $permission = Permission::firstOrcreate(['name' => 'All Permission']);

        if(!$admin->hasRole('admin')){
            $admin->assignRole('admin');
            $admin_role->givePermissionTo($permission);
        }

        //Assigning default permissions to Admin
        $blog_add = Permission::firstOrCreate([
            'name' => 'add-blog'
        ]);
        $blog_view = Permission::firstOrCreate([
            'name' => 'view-blog'
        ]);
        $blog_edit = Permission::firstOrCreate([
            'name' => 'edit-blog'
        ]);
        $blog_delete = Permission::firstOrCreate([
            'name' => 'delete-blog'
        ]);

        if(!$admin->hasPermission($blog_add)){
            $admin_role->givePermissionTo($blog_add);
        }

        if(!$admin->hasPermission($blog_view)) {
            $admin_role->givePermissionTo($blog_view);
        }

        if(!$admin->hasPermission($blog_edit)) {
            $admin_role->givePermissionTo($blog_edit);
        }

        if(!$admin->hasPermission($blog_delete)) {
            $admin_role->givePermissionTo($blog_delete);
        }

        $blog_category_add = Permission::firstOrCreate([
            'name' => 'add-blog-category'
        ]);
        $blog_category_view = Permission::firstOrCreate([
            'name' => 'view-blog-category'
        ]);
        $blog_category_edit = Permission::firstOrCreate([
            'name' => 'edit-blog-category'
        ]);
        $blog_category_delete = Permission::firstOrCreate([
            'name' => 'delete-blog-category'
        ]);

        if(!$admin->hasPermission($blog_category_add)) {
            $admin_role->givePermissionTo($blog_category_add);
        }
        if(!$admin->hasPermission($blog_category_view)) {
            $admin_role->givePermissionTo($blog_category_view);
        }
        if(!$admin->hasPermission($blog_category_edit)) {
            $admin_role->givePermissionTo($blog_category_edit);
        }
        if(!$admin->hasPermission($blog_category_delete)) {
            $admin_role->givePermissionTo($blog_category_delete);
        }

        //จังหวัด
        $province_add = Permission::firstOrCreate([
            'name' => 'add-provinces'
        ]);
        $province_view = Permission::firstOrCreate([
            'name' => 'view-provinces'
        ]);
        $province_edit = Permission::firstOrCreate([
            'name' => 'edit-provinces'
        ]);
        $province_delete = Permission::firstOrCreate([
            'name' => 'delete-provinces'
        ]);

        if(!$admin->hasPermission($province_add)) {
            $admin_role->givePermissionTo($province_add);
        }
        if(!$admin->hasPermission($province_view)) {
            $admin_role->givePermissionTo($province_view);
        }
        if(!$admin->hasPermission($province_edit)) {
            $admin_role->givePermissionTo($province_edit);
        }
        if(!$admin->hasPermission($province_delete)) {
            $admin_role->givePermissionTo($province_delete);
        }

        //E Surveillance แจ้งปริมาณ
        $inform_volume_add = Permission::firstOrCreate([
            'name' => 'add-inform-volume'
        ]);
        $inform_volume_view = Permission::firstOrCreate([
            'name' => 'view-inform-volume'
        ]);
        $inform_volume_edit = Permission::firstOrCreate([
            'name' => 'edit-inform-volume'
        ]);
        $inform_volume_delete = Permission::firstOrCreate([
            'name' => 'delete-inform-volume'
        ]);

        if(!$admin->hasPermission($inform_volume_add)) {
            $admin_role->givePermissionTo($inform_volume_add);
        }
        if(!$admin->hasPermission($inform_volume_view)) {
            $admin_role->givePermissionTo($inform_volume_view);
        }
        if(!$admin->hasPermission($inform_volume_edit)) {
            $admin_role->givePermissionTo($inform_volume_edit);
        }
        if(!$admin->hasPermission($inform_volume_delete)) {
            $admin_role->givePermissionTo($inform_volume_delete);
        }

        //E Surveillance แจ้งเปลี่ยนแปลง
        $inform_change_add = Permission::firstOrCreate([
            'name' => 'add-inform-change'
        ]);
        $inform_change_view = Permission::firstOrCreate([
            'name' => 'view-inform-change'
        ]);
        $inform_change_edit = Permission::firstOrCreate([
            'name' => 'edit-inform-change'
        ]);
        $inform_change_delete = Permission::firstOrCreate([
            'name' => 'delete-inform-change'
        ]);

        if(!$admin->hasPermission($inform_change_add)) {
            $admin_role->givePermissionTo($inform_change_add);
        }
        if(!$admin->hasPermission($inform_change_view)) {
            $admin_role->givePermissionTo($inform_change_view);
        }
        if(!$admin->hasPermission($inform_change_edit)) {
            $admin_role->givePermissionTo($inform_change_edit);
        }
        if(!$admin->hasPermission($inform_change_delete)) {
            $admin_role->givePermissionTo($inform_change_delete);
        }

        //E Surveillance แจ้งผลการประเมิน QC
        $inform_qc_add = Permission::firstOrCreate([
            'name' => 'add-inform-qc'
        ]);
        $inform_qc_view = Permission::firstOrCreate([
            'name' => 'view-inform-qc'
        ]);
        $inform_qc_edit = Permission::firstOrCreate([
            'name' => 'edit-inform-qc'
        ]);
        $inform_qc_delete = Permission::firstOrCreate([
            'name' => 'delete-inform-qc'
        ]);

        if(!$admin->hasPermission($inform_qc_add)) {
            $admin_role->givePermissionTo($inform_qc_add);
        }
        if(!$admin->hasPermission($inform_qc_view)) {
            $admin_role->givePermissionTo($inform_qc_view);
        }
        if(!$admin->hasPermission($inform_qc_edit)) {
            $admin_role->givePermissionTo($inform_qc_edit);
        }
        if(!$admin->hasPermission($inform_qc_delete)) {
            $admin_role->givePermissionTo($inform_qc_delete);
        }

        //E Surveillance แจ้งผลการตรวจสอบผลิตภัณฑ์
        $inform_inspection_add = Permission::firstOrCreate([
            'name' => 'add-inform-inspection'
        ]);
        $inform_inspection_view = Permission::firstOrCreate([
            'name' => 'view-inform-inspection'
        ]);
        $inform_inspection_edit = Permission::firstOrCreate([
            'name' => 'edit-inform-inspection'
        ]);
        $inform_inspection_delete = Permission::firstOrCreate([
            'name' => 'delete-inform-inspection'
        ]);

        if(!$admin->hasPermission($inform_inspection_add)) {
            $admin_role->givePermissionTo($inform_inspection_add);
        }
        if(!$admin->hasPermission($inform_inspection_view)) {
            $admin_role->givePermissionTo($inform_inspection_view);
        }
        if(!$admin->hasPermission($inform_inspection_edit)) {
            $admin_role->givePermissionTo($inform_inspection_edit);
        }
        if(!$admin->hasPermission($inform_inspection_delete)) {
            $admin_role->givePermissionTo($inform_inspection_delete);
        }

        //E Surveillance แจ้งผลการตรวจสอบผลิตภัณฑ์
        $inform_calibration_add = Permission::firstOrCreate([
            'name' => 'add-inform-calibration'
        ]);
        $inform_calibration_view = Permission::firstOrCreate([
            'name' => 'view-inform-calibration'
        ]);
        $inform_calibration_edit = Permission::firstOrCreate([
            'name' => 'edit-inform-calibration'
        ]);
        $inform_calibration_delete = Permission::firstOrCreate([
            'name' => 'delete-inform-calibration'
        ]);

        if(!$admin->hasPermission($inform_calibration_add)) {
            $admin_role->givePermissionTo($inform_calibration_add);
        }
        if(!$admin->hasPermission($inform_calibration_view)) {
            $admin_role->givePermissionTo($inform_calibration_view);
        }
        if(!$admin->hasPermission($inform_calibration_edit)) {
            $admin_role->givePermissionTo($inform_calibration_edit);
        }
        if(!$admin->hasPermission($inform_calibration_delete)) {
            $admin_role->givePermissionTo($inform_calibration_delete);
        }

        //E Surveillance แจ้งผลการประเมิน QC
        $inform_quality_control_add = Permission::firstOrCreate([
            'name' => 'add-inform-quality-control'
        ]);
        $inform_quality_control_view = Permission::firstOrCreate([
            'name' => 'view-inform-quality-control'
        ]);
        $inform_quality_control_edit = Permission::firstOrCreate([
            'name' => 'edit-inform-quality-control'
        ]);
        $inform_quality_control_delete = Permission::firstOrCreate([
            'name' => 'delete-inform-quality-control'
        ]);

        if(!$admin->hasPermission($inform_quality_control_add)) {
            $admin_role->givePermissionTo($inform_quality_control_add);
        }
        if(!$admin->hasPermission($inform_quality_control_view)) {
            $admin_role->givePermissionTo($inform_quality_control_view);
        }
        if(!$admin->hasPermission($inform_quality_control_edit)) {
            $admin_role->givePermissionTo($inform_quality_control_edit);
        }
        if(!$admin->hasPermission($inform_quality_control_delete)) {
            $admin_role->givePermissionTo($inform_quality_control_delete);
        }

        //E Surveillance แจ้งผลการสอบเทียบ
        $inform_calibrate_add = Permission::firstOrCreate([
            'name' => 'add-inform-calibrate'
        ]);
        $inform_calibrate_view = Permission::firstOrCreate([
            'name' => 'view-inform-calibrate'
        ]);
        $inform_calibrate_edit = Permission::firstOrCreate([
            'name' => 'edit-inform-calibrate'
        ]);
        $inform_calibrate_delete = Permission::firstOrCreate([
            'name' => 'delete-inform-calibrate'
        ]);

        if(!$admin->hasPermission($inform_calibrate_add)) {
            $admin_role->givePermissionTo($inform_calibrate_add);
        }
        if(!$admin->hasPermission($inform_calibrate_view)) {
            $admin_role->givePermissionTo($inform_calibrate_view);
        }
        if(!$admin->hasPermission($inform_calibrate_edit)) {
            $admin_role->givePermissionTo($inform_calibrate_edit);
        }
        if(!$admin->hasPermission($inform_calibrate_delete)) {
            $admin_role->givePermissionTo($inform_calibrate_delete);
        }

        //E Surveillance ยื่นคำขออื่นๆ
  	    $other_add = Permission::firstOrCreate([
  		    'name' => 'add-other'
  	    ]);
  	    $other_view = Permission::firstOrCreate([
  		    'name' => 'view-other'
  	    ]);
  	    $other_edit = Permission::firstOrCreate([
  		    'name' => 'edit-other'
  	    ]);
  	    $other_delete = Permission::firstOrCreate([
  		    'name' => 'delete-other'
  	    ]);

  	    if(!$admin->hasPermission($other_add)) {
  		    $admin_role->givePermissionTo($other_add);
  	    }
  	    if(!$admin->hasPermission($other_view)) {
  		    $admin_role->givePermissionTo($other_view);
  	    }
  	    if(!$admin->hasPermission($other_edit)) {
  		    $admin_role->givePermissionTo($other_edit);
  	    }
  	    if(!$admin->hasPermission($other_delete)) {
  		    $admin_role->givePermissionTo($other_delete);
  	    }

  	    //E Surveillance ยื่นคำขอการทำผลิตภัณฑ์เพื่อส่งออก (20 ตรี)
  	    $applicant_20ter_add = Permission::firstOrCreate([
  		    'name' => 'add-applicant-20ter'
  	    ]);
  	    $applicant_20ter_view = Permission::firstOrCreate([
  		    'name' => 'view-applicant-20ter'
  	    ]);
  	    $applicant_20ter_edit = Permission::firstOrCreate([
  		    'name' => 'edit-applicant-20ter'
  	    ]);
  	    $applicant_20ter_delete = Permission::firstOrCreate([
  		    'name' => 'delete-applicant-20ter'
  	    ]);

  	    if(!$admin->hasPermission($applicant_20ter_add)) {
  		    $admin_role->givePermissionTo($applicant_20ter_add);
  	    }
  	    if(!$admin->hasPermission($applicant_20ter_view)) {
  		    $admin_role->givePermissionTo($applicant_20ter_view);
  	    }
  	    if(!$admin->hasPermission($applicant_20ter_edit)) {
  		    $admin_role->givePermissionTo($applicant_20ter_edit);
  	    }
  	    if(!$admin->hasPermission($applicant_20ter_delete)) {
  		    $admin_role->givePermissionTo($applicant_20ter_delete);
  	    }

	    //E Surveillance ยื่นคำขอการทำผลิตภัณฑ์เพื่อใช้ในประเทศ (20 ทวิ)
	    $applicant_20bis_add = Permission::firstOrCreate([
		    'name' => 'add-applicant-20bis'
	    ]);
	    $applicant_20bis_view = Permission::firstOrCreate([
		    'name' => 'view-applicant-20bis'
	    ]);
	    $applicant_20bis_edit = Permission::firstOrCreate([
		    'name' => 'edit-applicant-20bis'
	    ]);
	    $applicant_20bis_delete = Permission::firstOrCreate([
		    'name' => 'delete-applicant-20bis'
	    ]);

	    if(!$admin->hasPermission($applicant_20bis_add)) {
		    $admin_role->givePermissionTo($applicant_20bis_add);
	    }
	    if(!$admin->hasPermission($applicant_20bis_view)) {
		    $admin_role->givePermissionTo($applicant_20bis_view);
	    }
	    if(!$admin->hasPermission($applicant_20bis_edit)) {
		    $admin_role->givePermissionTo($applicant_20bis_edit);
	    }
	    if(!$admin->hasPermission($applicant_20bis_delete)) {
		    $admin_role->givePermissionTo($applicant_20bis_delete);
	    }

	    //E Surveillance ยื่นคำขอการนำเข้าผลิตภัณฑ์ใช้ในประเทศ (21 ทวิ)
	    $applicant_21bis_add = Permission::firstOrCreate([
		    'name' => 'add-applicant-21bis'
	    ]);
	    $applicant_21bis_view = Permission::firstOrCreate([
		    'name' => 'view-applicant-21bis'
	    ]);
	    $applicant_21bis_edit = Permission::firstOrCreate([
		    'name' => 'edit-applicant-21bis'
	    ]);
	    $applicant_21bis_delete = Permission::firstOrCreate([
		    'name' => 'delete-applicant-21bis'
	    ]);

	    if(!$admin->hasPermission($applicant_21bis_add)) {
		    $admin_role->givePermissionTo($applicant_21bis_add);
	    }
	    if(!$admin->hasPermission($applicant_21bis_view)) {
		    $admin_role->givePermissionTo($applicant_21bis_view);
	    }
	    if(!$admin->hasPermission($applicant_21bis_edit)) {
		    $admin_role->givePermissionTo($applicant_21bis_edit);
	    }
	    if(!$admin->hasPermission($applicant_21bis_delete)) {
		    $admin_role->givePermissionTo($applicant_21bis_delete);
	    }

      //E Surveillance แจ้งปริมาณการทำผลิตภัณฑ์เพื่อส่งออก (20 ตรี)
      $volume_20ter_add = Permission::firstOrCreate([
        'name' => 'add-volume-20ter'
      ]);
      $volume_20ter_view = Permission::firstOrCreate([
        'name' => 'view-volume-20ter'
      ]);
      $volume_20ter_edit = Permission::firstOrCreate([
        'name' => 'edit-volume-20ter'
      ]);
      $volume_20ter_delete = Permission::firstOrCreate([
        'name' => 'delete-volume-20ter'
      ]);

      if(!$admin->hasPermission($volume_20ter_add)) {
        $admin_role->givePermissionTo($volume_20ter_add);
      }
      if(!$admin->hasPermission($volume_20ter_view)) {
        $admin_role->givePermissionTo($volume_20ter_view);
      }
      if(!$admin->hasPermission($volume_20ter_edit)) {
        $admin_role->givePermissionTo($volume_20ter_edit);
      }
      if(!$admin->hasPermission($volume_20ter_delete)) {
        $admin_role->givePermissionTo($volume_20ter_delete);
      }

      //E Surveillance แจ้งปริมาณการทำผลิตภัณฑ์เพื่อใช้ในประเทศ (20 ทวิ)
      $volume_20bis_add = Permission::firstOrCreate([
        'name' => 'add-volume-20bis'
      ]);
      $volume_20bis_view = Permission::firstOrCreate([
        'name' => 'view-volume-20bis'
      ]);
      $volume_20bis_edit = Permission::firstOrCreate([
        'name' => 'edit-volume-20bis'
      ]);
      $volume_20bis_delete = Permission::firstOrCreate([
        'name' => 'delete-volume-20bis'
      ]);

      if(!$admin->hasPermission($volume_20bis_add)) {
        $admin_role->givePermissionTo($volume_20bis_add);
      }
      if(!$admin->hasPermission($volume_20bis_view)) {
        $admin_role->givePermissionTo($volume_20bis_view);
      }
      if(!$admin->hasPermission($volume_20bis_edit)) {
        $admin_role->givePermissionTo($volume_20bis_edit);
      }
      if(!$admin->hasPermission($volume_20bis_delete)) {
        $admin_role->givePermissionTo($volume_20bis_delete);
      }

      //ยื่นคำขอเป็นผู้ตรวจประเมินระบบงาน (IB)
      $applicantibs_add = Permission::firstOrCreate([
        'name' => 'add-applicantibs'
      ]);
      $applicantibs_view = Permission::firstOrCreate([
        'name' => 'view-applicantibs'
      ]);
      $applicantibs_edit = Permission::firstOrCreate([
        'name' => 'edit-applicantibs'
      ]);
      $applicantibs_delete = Permission::firstOrCreate([
        'name' => 'delete-applicantibs'
      ]);

      if(!$admin->hasPermission($applicantibs_add)) {
        $admin_role->givePermissionTo($applicantibs_add);
      }
      if(!$admin->hasPermission($applicantibs_view)) {
        $admin_role->givePermissionTo($applicantibs_view);
      }
      if(!$admin->hasPermission($applicantibs_edit)) {
        $admin_role->givePermissionTo($applicantibs_edit);
      }
      if(!$admin->hasPermission($applicantibs_delete)) {
        $admin_role->givePermissionTo($applicantibs_delete);
      }

      //ยื่นคำขอเป็นผู้ตรวจประเมินระบบงาน (IB)
      $applicant_add = Permission::firstOrCreate([
        'name' => 'add-applicant'
      ]);
      $applicant_view = Permission::firstOrCreate([
        'name' => 'view-applicant'
      ]);
      $applicant_edit = Permission::firstOrCreate([
        'name' => 'edit-applicant'
      ]);
      $applicant_delete = Permission::firstOrCreate([
        'name' => 'delete-applicant'
      ]);

      if(!$admin->hasPermission($applicant_add)) {
        $admin_role->givePermissionTo($applicant_add);
      }
      if(!$admin->hasPermission($applicant_view)) {
        $admin_role->givePermissionTo($applicant_view);
      }
      if(!$admin->hasPermission($applicant_edit)) {
        $admin_role->givePermissionTo($applicant_edit);
      }
      if(!$admin->hasPermission($applicant_delete)) {
        $admin_role->givePermissionTo($applicant_delete);
      }

      //ยื่นคำขอเป็นผู้ตรวจประเมินระบบงาน (CB)
      $applicantcbs_add = Permission::firstOrCreate([
        'name' => 'add-applicantcbs'
      ]);
      $applicantcbs_view = Permission::firstOrCreate([
        'name' => 'view-applicantcbs'
      ]);
      $applicantcbs_edit = Permission::firstOrCreate([
        'name' => 'edit-applicantcbs'
      ]);
      $applicantcbs_delete = Permission::firstOrCreate([
        'name' => 'delete-applicantcbs'
      ]);

      if(!$admin->hasPermission($applicantcbs_add)) {
        $admin_role->givePermissionTo($applicantcbs_add);
      }
      if(!$admin->hasPermission($applicantcbs_view)) {
        $admin_role->givePermissionTo($applicantcbs_view);
      }
      if(!$admin->hasPermission($applicantcbs_edit)) {
        $admin_role->givePermissionTo($applicantcbs_edit);
      }
      if(!$admin->hasPermission($applicantcbs_delete)) {
        $admin_role->givePermissionTo($applicantcbs_delete);
      }

      //ดูข้อมูลใบอนุญาต
      $licenses_view = Permission::firstOrCreate([
        'name' => 'view-licenses'
      ]);
      if(!$admin->hasPermission($licenses_view)) {
        $admin_role->givePermissionTo($licenses_view);
      }

      //ดูข้อมูลใบอนุญาต
      $license_details_edit = Permission::firstOrCreate([
        'name' => 'edit-license-details'
      ]);
      if(!$admin->hasPermission($license_details_edit)) {
        $admin_role->givePermissionTo($license_details_edit);
      }

      //ระบบรับ - แจ้งผลการทดสอบ (สำหรับ LAB)
      $report_product_edit = Permission::firstOrCreate([
        'name' => 'edit-report-product'
      ]);
      $report_product_view = Permission::firstOrCreate([
        'name' => 'view-report-product'
      ]);

      if(!$admin->hasPermission($report_product_edit)) {
        $admin_role->givePermissionTo($report_product_edit);
      }
      if(!$admin->hasPermission($report_product_view)) {
        $admin_role->givePermissionTo($report_product_view);
      }

      //แจ้งใบอนุญาต
      $tisilicensenotification_add = Permission::firstOrCreate([
        'name' => 'add-tisilicensenotification'
      ]);
      $tisilicensenotification_view = Permission::firstOrCreate([
        'name' => 'view-tisilicensenotification'
      ]);
      $tisilicensenotification_edit = Permission::firstOrCreate([
        'name' => 'edit-tisilicensenotification'
      ]);
      $tisilicensenotification_delete = Permission::firstOrCreate([
        'name' => 'delete-tisilicensenotification'
      ]);
      if(!$admin->hasPermission($tisilicensenotification_add)) {
        $admin_role->givePermissionTo($tisilicensenotification_add);
      }
      if(!$admin->hasPermission($tisilicensenotification_view)) {
        $admin_role->givePermissionTo($tisilicensenotification_view);
      }
      if(!$admin->hasPermission($tisilicensenotification_edit)) {
        $admin_role->givePermissionTo($tisilicensenotification_edit);
      }
      if(!$admin->hasPermission($tisilicensenotification_delete)) {
        $admin_role->givePermissionTo($tisilicensenotification_delete);
      }

          //E Surveillance ยื่นคำขอการทำผลิตภัณฑ์เพื่อส่งออก (20 ตรี)
      $applicant_21ter_add = Permission::firstOrCreate([
        'name' => 'add-applicant-21ter'
      ]);
      $applicant_21ter_view = Permission::firstOrCreate([
        'name' => 'view-applicant-21ter'
      ]);
      $applicant_21ter_edit = Permission::firstOrCreate([
        'name' => 'edit-applicant-21ter'
      ]);
      $applicant_21ter_delete = Permission::firstOrCreate([
        'name' => 'delete-applicant-21ter'
      ]);

      if(!$admin->hasPermission($applicant_21ter_add)) {
        $admin_role->givePermissionTo($applicant_21ter_add);
      }
      if(!$admin->hasPermission($applicant_21ter_view)) {
        $admin_role->givePermissionTo($applicant_21ter_view);
      }
      if(!$admin->hasPermission($applicant_21ter_edit)) {
        $admin_role->givePermissionTo($applicant_21ter_edit);
      }
      if(!$admin->hasPermission($applicant_21ter_delete)) {
        $admin_role->givePermissionTo($applicant_21ter_delete);
      }


      $volume_21ter_add = Permission::firstOrCreate([
        'name' => 'add-volume-21ter'
      ]);
      $volume_21ter_view = Permission::firstOrCreate([
        'name' => 'view-volume-21ter'
      ]);
      $volume_21ter_edit = Permission::firstOrCreate([
        'name' => 'edit-volume-21ter'
      ]);
      $volume_21ter_delete = Permission::firstOrCreate([
        'name' => 'delete-volume-21ter'
      ]);

      if(!$admin->hasPermission($volume_21ter_add)) {
        $admin_role->givePermissionTo($volume_21ter_add);
      }
      if(!$admin->hasPermission($volume_21ter_view)) {
        $admin_role->givePermissionTo($volume_21ter_view);
      }
      if(!$admin->hasPermission($volume_21ter_edit)) {
        $admin_role->givePermissionTo($volume_21ter_edit);
      }
      if(!$admin->hasPermission($volume_21ter_delete)) {
        $admin_role->givePermissionTo($volume_21ter_delete);
      }


      $volume_21bis_add = Permission::firstOrCreate([
        'name' => 'add-volume-21bis'
      ]);
      $volume_21bis_view = Permission::firstOrCreate([
        'name' => 'view-volume-21bis'
      ]);
      $volume_21bis_edit = Permission::firstOrCreate([
        'name' => 'edit-volume-21bis'
      ]);
      $volume_21bis_delete = Permission::firstOrCreate([
        'name' => 'delete-volume-21bis'
      ]);

      if(!$admin->hasPermission($volume_21bis_add)) {
        $admin_role->givePermissionTo($volume_21bis_add);
      }
      if(!$admin->hasPermission($volume_21bis_view)) {
        $admin_role->givePermissionTo($volume_21bis_view);
      }
      if(!$admin->hasPermission($volume_21bis_edit)) {
        $admin_role->givePermissionTo($volume_21bis_edit);
      }
      if(!$admin->hasPermission($volume_21bis_delete)) {
        $admin_role->givePermissionTo($volume_21bis_delete);
      }

      $applicant_21own_add = Permission::firstOrCreate([
        'name' => 'add-applicant-21own'
      ]);
      $applicant_21own_view = Permission::firstOrCreate([
        'name' => 'view-applicant-21own'
      ]);
      $applicant_21own_edit = Permission::firstOrCreate([
        'name' => 'edit-applicant-21own'
      ]);
      $applicant_21own_delete = Permission::firstOrCreate([
        'name' => 'delete-applicant-21own'
      ]);

      if(!$admin->hasPermission($applicant_21own_add)) {
        $admin_role->givePermissionTo($applicant_21own_add);
      }
      if(!$admin->hasPermission($applicant_21own_view)) {
        $admin_role->givePermissionTo($applicant_21own_view);
      }
      if(!$admin->hasPermission($applicant_21own_edit)) {
        $admin_role->givePermissionTo($applicant_21own_edit);
      }
      if(!$admin->hasPermission($applicant_21own_delete)) {
        $admin_role->givePermissionTo($applicant_21own_delete);
      }

      $volume_21own_add = Permission::firstOrCreate([
        'name' => 'add-volume-21own'
      ]);
      $volume_21own_view = Permission::firstOrCreate([
        'name' => 'view-volume-21own'
      ]);
      $volume_21own_edit = Permission::firstOrCreate([
        'name' => 'edit-volume-21own'
      ]);
      $volume_21own_delete = Permission::firstOrCreate([
        'name' => 'delete-volume-21own'
      ]);

      if(!$admin->hasPermission($volume_21own_add)) {
        $admin_role->givePermissionTo($volume_21own_add);
      }
      if(!$admin->hasPermission($volume_21own_view)) {
        $admin_role->givePermissionTo($volume_21own_view);
      }
      if(!$admin->hasPermission($volume_21own_edit)) {
        $admin_role->givePermissionTo($volume_21own_edit);
      }
      if(!$admin->hasPermission($volume_21own_delete)) {
        $admin_role->givePermissionTo($volume_21own_delete);
      }



      $this->command->info('Admin User created with username admin@admin.com and password 1234');
    }

}
