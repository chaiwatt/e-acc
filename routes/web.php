<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('std-certifies/data_list', 'StdCertifiesController@data_list');
Route::resource('std-certifies', 'StdCertifiesController');

Route::get('funtions/update_api_pid', 'Funtion\\FuntionsController@update_api_pid');
Route::get('funtions/check_api_pid', 'Funtion\\FuntionsController@check_api_pid');
Route::get('funtions/search-addreess', 'Funtion\\FuntionsController@SearchAddreess');
Route::get('funtions/get-addreess/{subdistrict_id?}', 'Funtion\\FuntionsController@GetAddreess');
Route::get('funtions/get-branch-addreess/{id?}', 'Funtion\\FuntionsController@GetBranchAddreess');

Route::get('funtions/get-view/files/{systems}/{tax_number}/{new_filename}/{filename}', function($systems,$tax_number,$new_filename,$filename)
{
    $public = public_path();
    $attach_path = 'files/'.$systems.'/'.$tax_number;
    // dd($filePath);
    if(HP::checkFileStorage($attach_path.'/'. $new_filename)){

        $file_name = $attach_path .'/'. $new_filename;
        $info = pathinfo( $file_name , PATHINFO_EXTENSION ) ;

        if( $info == "txt" || $info == "doc" || $info == "docx" || $info == "ppt" || $info == "7z" || $info == "zip"  ){
            return Storage::download($attach_path.'/'.  $new_filename);
        }else{
            HP::getFileStorage($attach_path .'/'. $new_filename);
            $filePath =  response()->file($public.'/uploads/'.$attach_path.'/'.  $new_filename);
            
            return $filePath;
        }
    }else{
        return 'ไม่พบไฟล์';
    }
});

// Test function

Route::get('/abtest','MyTestController@abTest');

Route::get('/show-lab-cal-details','MyTestController@showLabCalDetails');
Route::get('/show-lab-test-details','MyTestController@showLabTestDetails');
Route::get('/show-cb-details','MyTestController@showCbDetails');
Route::get('/show-ib-details','MyTestController@showIbDetails');
Route::get('/show-ib-report-one-details','MyTestController@showIbReportOneDetails');



Route::get('/show-cb-isic-details','MyTestController@showCbIsicDetails');



Route::post('/save-html-template','MyTestController@saveHtmlTemplate');

Route::post('/download-html-template','MyTestController@downloadHtmlTemplate');


Route::post('/export-pdf', 'MyTestController@exportPdf');

Route::get('/test','MyTestController@index');
Route::get('/add-lab-cal-scope','MyTestController@addLabCalScope');
Route::get('/get-lab-cal-scope','MyTestController@getLabCalScope');
Route::get('/get-lab-cal-scope','MyTestController@updateDistrict');
Route::get('/update13id','MyTestController@update13id');
Route::get('/generate-pdf-lab-scope','MyTestController@generatePdfLabScope');
Route::get('/generate-pdf','MyTestController@generatePDF');

Route::get('/generate-scope-pdf','MyTestController@generateScopePDF');
Route::get('/finance-data','MyTestController@financeData');
Route::get('/mail-to-scope-viewer','MyTestController@mailToScopeViewer');
Route::get('/is-request-belong','MyTestController@isRequestBelong');
Route::get('/get-attached-file-from-request','MyTestController@getAttachedFileFromRequest');
Route::get('/cb-isic-sope-pdf','MyTestController@cbIsicSopePdf');
Route::get('/ib-sope-pdf','MyTestController@ibSopePdf');
Route::get('/test-db','MyTestController@testDb');
Route::get('/certi-cb-map-req','MyTestController@certiCbMapReq');


Route::get('/delete-history','MyTestController@deleteHistory');

Route::get('/check-lab-record','MyTestController@checkLabRecord');

Route::get('/export-labscope-pdf','MyTestController@exportLabScopePdf');



//


Route::get('/',function (){
    return redirect('home');
});


Route::get('home','HomeController@index');
Route::post('home','HomeController@index');


Route::post('tisi/standard-offers/address_department','Tisi\\StandardOffersController@address_department');
Route::get('tisi/standard-offers/create','Tisi\\StandardOffersController@create')->name('tisi.standard-offers.create');
Route::get('tisi/standard-offers','Tisi\\StandardOffersController@index');
Route::post('tisi/standard-offers/store','Tisi\\StandardOffersController@store');
Route::post('tisi/standard-offers/save_department','Tisi\\StandardOffersController@save_department');

// Route to show the edit form
Route::get('tisi/standard-offers/{id}/edit', 'Tisi\\StandardOffersController@edit')->name('tisi.standard-offers.edit');

// Route to show the view page
Route::get('/{id}/view', 'Tisi\\StandardOffersController@view')->name('tisi.standard-offers.view');

// Route to update an existing standard offer
Route::put('tisi/standard-offers/{id}/update', 'Tisi\\StandardOffersController@update')->name('tisi.standard-offers.update');


    // อ่านไฟล์ที่แนบ pay-in LAB
    Route::get('certify/check/files/pay_in_lab/{filename}', function($filename)
    {
        $public = public_path();
        $attach_path = 'files/applicants/files_pay_in_lab/';
        if(HP::checkFileStorage($attach_path . $filename)){
        HP::getFileStorage($attach_path. $filename);
        $filePath =  response()->file($public.'/uploads/'.$attach_path. $filename);
            return $filePath;
        }else{
        return 'ไม่พบไฟล์';
        }
    });


    Route::get('certify/auditor/files/{path}/{filename}', function($path,$filename)
    {
        $public = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
        $filePath =  response()->download($public.'files/' . $path.'/'.$filename);
        return $filePath;
    })->name('board_auditor.file');


    Route::get('certify/check/files/assessment/{filename}', function( $filename)
    {
        $public = public_path();
        $attach_path = 'files/applicants/save_assessment/';
        if(HP::checkFileStorage($attach_path . $filename)){
            HP::getFileStorage($attach_path. $filename);
            $filePath =  response()->file($public.'/uploads/'.$attach_path. $filename);
            return $filePath;
        }else{
            return 'ไม่พบไฟล์';
        }
    });

     // อ่านไฟล์ที่แนบมา   (LAB)
     Route::get('certify/check/file_client/{app_no}/{filename}/{client_name}', function($app_no,$filename,$client_name)
     {
        $public = public_path();
        
        $attach_path = 'files/applicants/check_files/';
        // dd($attach_path. $app_no .'/'. $filename);
       if(HP::checkFileStorage($attach_path. $app_no .'/'. $filename)){
        //    if($client_name != 'null'){
                // HP::getFileStorageClientName($attach_path. $app_no .'/'. $filename,$client_name);
                // HP::getFileStorage($attach_path. $app_no .'/'. $filename);
                // $filePath =  response()->file($public.'/uploads/'.$attach_path.'/' . $app_no .'/'. $filenclient_nameame);
                // return $filePath;
        //    }else{
                HP::getFileStorage($attach_path. $app_no .'/'. $filename);
                $filePath =  response()->file($public.'/uploads/'.$attach_path.'/' . $app_no .'/'. $filename);
                return $filePath;
        //    }

       }else{
          return 'ไม่พบไฟล์';
       }
     });

     // อ่านไฟล์ที่แนบมา   (LAB)
     Route::get('certify/check/files/{app_no}/{filename}', function($app_no,$filename)
     {
        $public = public_path();
        // dd($public);
        $attach_path = 'files/applicants/check_files/';
       if(HP::checkFileStorage($attach_path. $app_no .'/'. $filename)){
           HP::getFileStorage($attach_path. $app_no .'/'. $filename);
           $filePath =  response()->file($public.'/uploads/'.$attach_path.'/' . $app_no .'/'. $filename);
            return $filePath;
       }else{
          return 'ไม่พบไฟล์';
       }
     })->name('show.file');

         // อ่านไฟล์ที่แนบมา   (IB)
         Route::get('certify/check/file_ib_client/{app_no}/{filename}/{client_name}', function($app_no,$filename,$client_name)
         {

            $public = public_path();
            $attach_path = 'files/applicants/check_files_ib/';

           if(HP::checkFileStorage($attach_path. $app_no .'/'. $filename)){
                    HP::getFileStorage($attach_path. $app_no .'/'. $filename);
                    $filePath =  response()->file($public.'/uploads/'.$attach_path.'/' . $app_no .'/'. $filename);
                    return $filePath;
           }else{
              return 'ไม่พบไฟล์';
           }
         });
    // อ่านไฟล์ที่แนบมา   (IB)
     Route::get('certify/check/files_ib/{app_no}/{filename}', function($app_no,$filename)
    {
        $public = public_path();
        $attach_path = 'files/applicants/check_files_ib/';
       if(HP::checkFileStorage($attach_path. $app_no .'/'. $filename)){
           HP::getFileStorage($attach_path. $app_no .'/'. $filename);
           $filePath =  response()->file($public.'/uploads/'.$attach_path.'/' . $app_no .'/'. $filename);
            return $filePath;
       }else{
          return 'ไม่พบไฟล์';
       }
    });

         // อ่านไฟล์ที่แนบมา   (CB)
         Route::get('certify/check/file_cb_client/{app_no}/{filename}/{client_name}', function($app_no,$filename,$client_name)
         {
            $public = public_path();
            $attach_path = 'files/applicants/check_files_cb/';

           if(HP::checkFileStorage($attach_path. $app_no .'/'. $filename)){
                    HP::getFileStorage($attach_path. $app_no .'/'. $filename);
                    $filePath =  response()->file($public.'/uploads/'.$attach_path.'/' . $app_no .'/'. $filename);
                    return $filePath;
           }else{
              return 'ไม่พบไฟล์';
           }
         });

     // อ่านไฟล์ที่แนบมา   (CB)
     Route::get('certify/check/files_cb/{app_no}/{filename}', function($app_no,$filename)
    {
        $public = public_path();
        $attach_path = 'files/applicants/check_files_cb/';
       if(HP::checkFileStorage($attach_path. $app_no .'/'. $filename)){
           HP::getFileStorage($attach_path. $app_no .'/'. $filename);
           $filePath =  response()->file($public.'/uploads/'.$attach_path.'/' . $app_no .'/'. $filename);
            return $filePath;
       }else{
          return 'ไม่พบไฟล์';
       }
    });

    Route::get('funtions/get-view-file/{filename}/{client_name}', function($filename,$client_name)
    {
       $public = public_path();
       $attach_path = base64_decode($filename);
      if(HP::checkFileStorage($attach_path)){
               HP::getFileStorage($attach_path);
               $filePath =  response()->file($public.'/uploads/'.$attach_path);
               return $filePath;
      }else{
         return 'ไม่พบไฟล์';
      }
    });

    Route::get('certify/check_files_lab/{id?}','Api\\CertificateController@check_files_lab');


Route::group(['middleware' => ['auth', 'roles'],'roles' => ['admin','user']], function () {

    // Route::get('/dashboard', function () {
    //     return view('dashboard.index');
    // });
    Route::get('account-settings','UsersController@getSettings');
    Route::post('account-settings','UsersController@saveSettings');
});

Route::group(['middleware' => 'auth'],function (){

    //Dash Board
    // Route::get('/home', function () {
    //     return view('admin.index');
    // });

    Route::get('member/index-esurv', function (){
        return view('member/index-esurv');
    });

    Route::get('member/index-certify', function (){
        return view('member/index-certify');
    });

    /*routes for blog*/
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/create','BlogController@create');
        Route::post('/create','BlogController@store');
        Route::get('delete/{id}', 'BlogController@destroy')->name('blog.delete');
        Route::get('edit/{id}', 'BlogController@edit')->name('blog.edit');
        Route::post('edit/{id}', 'BlogController@update');
        Route::get('view/{id}', 'BlogController@show');
        Route::post('{id}/storecomment', 'BlogController@storeComment')->name('storeComment');
    });
    Route::resource('blog', 'BlogController');

    /*routes for blog category*/
    Route::group(['prefix' => 'blog-category'], function () {
        Route::get('/','BlogCategoryController@getIndex');
        Route::get('/create','BlogCategoryController@create');
        Route::post('/create','BlogCategoryController@save');
        Route::get('/delete/{id}','BlogCategoryController@delete');
        Route::get('/edit/{id}','BlogCategoryController@edit');
        Route::post('/edit/{id}','BlogCategoryController@update');
    });
    Route::resource('blogcategory', 'BlogCategoryController');

});

Route::group(['middleware' => ['auth', 'roles']], function () {

    Route::get('index2', function (){
        return view('dashboard.index2');
    });
    Route::get('index3', function (){
        return view('dashboard.index3');
    });
    Route::get('index4', function (){
        return view('ecommerce.index4');
    });
    Route::get('products', function (){
        return view('ecommerce.products');
    });
    Route::get('product-detail', function (){
        return view('ecommerce.product-detail');
    });
    Route::get('product-edit', function (){
        return view('ecommerce.product-edit');
    });
    Route::get('product-orders', function (){
        return view('ecommerce.product-orders');
    });
    Route::get('product-cart', function (){
        return view('ecommerce.product-cart');
    });
    Route::get('product-checkout', function (){
        return view('ecommerce.product-checkout');
    });
    Route::get('panels-wells', function (){
        return view('ui-elements.panels-wells');
    });
    Route::get('panel-ui-block', function (){
        return view('ui-elements.panel-ui-block');
    });
    Route::get('portlet-draggable', function (){
        return view('ui-elements.portlet-draggable');
    });
    Route::get('buttons', function (){
        return view('ui-elements.buttons');
    });
    Route::get('tabs', function (){
        return view('ui-elements.tabs');
    });
    Route::get('modals', function (){
        return view('ui-elements.modals');
    });
    Route::get('progressbars', function (){
        return view('ui-elements.progressbars');
    });
    Route::get('notification', function (){
        return view('ui-elements.notification');
    });
    Route::get('carousel', function (){
        return view('ui-elements.carousel');
    });
    Route::get('user-cards', function (){
        return view('ui-elements.user-cards');
    });
    Route::get('timeline', function (){
        return view('ui-elements.timeline');
    });
    Route::get('timeline-horizontal', function (){
        return view('ui-elements.timeline-horizontal');
    });
    Route::get('range-slider', function (){
        return view('ui-elements.range-slider');
    });
    Route::get('ribbons', function (){
        return view('ui-elements.ribbons');
    });
    Route::get('steps', function (){
        return view('ui-elements.steps');
    });
    Route::get('session-idle-timeout', function (){
        return view('ui-elements.session-idle-timeout');
    });
    Route::get('session-timeout', function (){
        return view('ui-elements.session-timeout');
    });
    Route::get('bootstrap-ui', function (){
        return view('ui-elements.bootstrap');
    });
    Route::get('starter-page', function (){
        return view('pages.starter-page');
    });
    Route::get('blank', function (){
        return view('pages.blank');
    });
    Route::get('blank', function (){
        return view('pages.blank');
    });
    Route::get('search-result', function (){
        return view('pages.search-result');
    });
    Route::get('custom-scroll', function (){
        return view('pages.custom-scroll');
    });
    Route::get('lock-screen', function (){
        return view('pages.lock-screen');
    });
    Route::get('recoverpw', function (){
        return view('pages.recoverpw');
    });
    Route::get('animation', function (){
        return view('pages.animation');
    });
    Route::get('profile', function (){
        return view('pages.profile');
    });
    Route::get('invoice', function (){
        return view('pages.invoice');
    });
    Route::get('gallery', function (){
        return view('pages.gallery');
    });
    Route::get('pricing', function (){
        return view('pages.pricing');
    });
    Route::get('400', function (){
        return view('pages.400');
    });
    Route::get('403', function (){
        return view('pages.403');
    });
    Route::get('404', function (){
        return view('pages.404');
    });
    Route::get('500', function (){
        return view('pages.500');
    });
    Route::get('503', function (){
        return view('pages.503');
    });
    Route::get('form-basic', function (){
        return view('forms.form-basic');
    });
    Route::get('form-layout', function (){
        return view('forms.form-layout');
    });
    Route::get('icheck-control', function (){
        return view('forms.icheck-control');
    });
    Route::get('form-advanced', function (){
        return view('forms.form-advanced');
    });
    Route::get('form-upload', function (){
        return view('forms.form-upload');
    });
    Route::get('form-dropzone', function (){
        return view('forms.form-dropzone');
    });
    Route::get('form-pickers', function (){
        return view('forms.form-pickers');
    });
    Route::get('basic-table', function (){
        return view('tables.basic-table');
    });
    Route::get('table-layouts', function (){
        return view('tables.table-layouts');
    });
    Route::get('data-table', function (){
        return view('tables.data-table');
    });
    Route::get('bootstrap-tables', function (){
        return view('tables.bootstrap-tables');
    });
    Route::get('responsive-tables', function (){
        return view('tables.responsive-tables');
    });
    Route::get('editable-tables', function (){
        return view('tables.editable-tables');
    });
    Route::get('inbox', function (){
        return view('inbox.inbox');
    });
    Route::get('inbox-detail', function (){
        return view('inbox.inbox-detail');
    });
    Route::get('compose', function (){
        return view('inbox.compose');
    });
    Route::get('contact', function (){
        return view('inbox.contact');
    });
    Route::get('contact-detail', function (){
        return view('inbox.contact-detail');
    });
    Route::get('calendar', function (){
        return view('extra.calendar');
    });
    Route::get('widgets', function (){
        return view('extra.widgets');
    });
    Route::get('morris-chart', function (){
        return view('charts.morris-chart');
    });
    Route::get('peity-chart', function (){
        return view('charts.peity-chart');
    });
    Route::get('knob-chart', function (){
        return view('charts.knob-chart');
    });
    Route::get('sparkline-chart', function (){
        return view('charts.sparkline-chart');
    });
    Route::get('simple-line', function (){
        return view('icons.simple-line');
    });
    Route::get('fontawesome', function (){
        return view('icons.fontawesome');
    });
    Route::get('map-google', function (){
        return view('maps.map-google');
    });
    Route::get('map-vector', function (){
        return view('maps.map-vector');
    });

    #Permission management
    Route::get('permission-management','PermissionController@getIndex');
    Route::get('permission/create','PermissionController@create');
    Route::post('permission/create','PermissionController@save');
    Route::get('permission/delete/{id}','PermissionController@delete');
    Route::get('permission/edit/{id}','PermissionController@edit');
    Route::post('permission/edit/{id}','PermissionController@update');

    #Role management
    Route::get('role-management','RoleController@getIndex');
    Route::get('role/create','RoleController@create');
    Route::post('role/create','RoleController@save');
    Route::get('role/delete/{id}','RoleController@delete');
    Route::get('role/edit/{id}','RoleController@edit');
    Route::post('role/edit/{id}','RoleController@update');

    #CRUD Generator
    Route::get('/crud-generator', ['uses' => 'ProcessController@getGenerator']);
    Route::post('/crud-generator', ['uses' => 'ProcessController@postGenerator']);

    # Activity log
    Route::get('activity-log','LogViewerController@getActivityLog');
    Route::get('activity-log/data', 'LogViewerController@activityLogData')->name('activity-log.data');

    #User Management routes
    Route::get('users','UsersController@getIndex');
    Route::get('user/create','UsersController@create');
    Route::post('user/create','UsersController@save');
    Route::get('user/edit/{id}','UsersController@edit');
    Route::post('user/edit/{id}','UsersController@update');
    Route::get('user/delete/{id}','UsersController@delete');
    Route::get('user/deleted/','UsersController@getDeletedUsers');
    Route::get('user/restore/{id}','UsersController@restoreUser');

    Route::put('certify/applicantibs/update-state', 'Certify\ApplicantIBsController@update_state');
    Route::resource('certify/applicant-i-bs', 'Certify\\ApplicantIBsController');
    Route::put('certify/applicantcbs/update-state', 'Certify\ApplicantCBsController@update_state');
    Route::resource('certify/applicant-c-bs', 'Certify\\ApplicantCBsController');



});

//Log Viewer
Route::get('log-viewers', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index')->name('log-viewers');
Route::get('log-viewers/logs', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs')->name('log-viewers.logs');
Route::delete('log-viewers/logs/delete', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete')->name('log-viewers.logs.delete');
Route::get('log-viewers/logs/{date}', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show')->name('log-viewers.logs.show');
Route::get('log-viewers/logs/{date}/download', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download')->name('log-viewers.logs.download');
Route::get('log-viewers/logs/{date}/{level}', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel')->name('log-viewers.logs.filter');
Route::get('log-viewers/logs/{date}/{level}/search', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@search')->name('log-viewers.logs.search');
Route::get('log-viewers/logcheck', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@logCheck')->name('log-viewers.logcheck');

#blog routes frontend
//Route::get('/','BlogController@getBlogList');
Route::get('blogs/{slug}','BlogController@getBlog');
Route::get('blogs/category/{slug}','BlogController@getCategoryBlog');
Route::get('blogs/tag/{slug}','BlogController@getTagBlog');
Route::get('blogs/author/{slug}','BlogController@getAuthorBlog');

Route::get('auth/{provider}/','Auth\SocialLoginController@redirectToProvider');
Route::get('{provider}/callback','Auth\SocialLoginController@handleProviderCallback');
Route::get('logout','Auth\LoginController@logout');

Route::get('admin/users/savetheme/{theme_name}', 'Admin\UsersController@savetheme');
Route::get('admin/users/savefix-header/{fix_header}', 'Admin\UsersController@savefix_header');
Route::get('admin/users/savefix-sidebar/{fix_sidebar}', 'Admin\UsersController@savefix_sidebar');


//// Witty Light Applicant Route Zone ////
Route::group(['prefix'=>'certify'],function (){ // ระบบยื่นคำขอรับใบรับรองระบบงำน

    Route::group(['prefix' => 'applicant'], function () {
        Route::get('/','Certify\ApplicantController@index')->name('applicant.index');
        Route::get('/search','Certify\ApplicantController@search');
        Route::get('/create','Certify\ApplicantController@create');
        Route::get('/show/{token}','Certify\ApplicantController@show')->name('applicant.show');
        Route::get('/edit/{token}','Certify\ApplicantController@edit')->name('applicant.edit');
        Route::get('/edit-scope/{token}','Certify\ApplicantController@editScope')->name('applicant.edit_scope');
        Route::post('/update-scope/{token}','Certify\ApplicantController@updateScope');


        Route::post('/save-html-template','Certify\ApplicantController@saveHtmlTemplate')->name('certify.applicant.save-html-template');
        Route::post('/download-html-template','Certify\ApplicantController@downloadHtmlTemplate')->name('certify.applicant.download-html-template');
        

        Route::post('/store','Certify\ApplicantController@store')->name('applicant.store');
        Route::post('/update/{token}','Certify\ApplicantController@update');
        Route::post('/delete/applicant/store','Certify\ApplicantController@deleteApplicant');
        Route::post('/update/status/to/eight','Certify\ApplicantController@updateToEight');
        Route::get('/delete/file/{path}/{token}','Certify\ApplicantController@removeFilesWithMessage');
        Route::get('/delete/file_certiLab/{path}/{token}','Certify\ApplicantController@removeFilesCertiLabAttachAll');
        Route::get('/delete/file_certiLab_more/{path}/{token}','Certify\ApplicantController@removeFilesCertiLabAttachhMoreAll');
        Route::get('/delete/file_box_image/{path}/{token}','Certify\ApplicantController@removeFilesCertiLabCheckBoxImage');

        // start scope
        Route::get('/lab-scope-editor','Certify\ApplicantController@scopeEditor')->name('certify.applicant.lab-scope-editor');
        Route::get('/special-sign','Certify\ApplicantController@specialSign')->name('certify.applicant.special-sign');
        // scope end

        Route::get('/delete/certi_lab_info/{id?}/{token?}','Certify\ApplicantController@UpdateFileLabInfo');

        Route::get('/draft_pdf/{id}','Certify\ApplicantController@draft_pdf');

        Route::get('/Pay_In1/{id?}/{token?}','Certify\ApplicantController@GetPayInOne');
        Route::post('/update/status/cost/assessment/{id?}','Certify\ApplicantController@updateStatusCostAssessment'); //     1
        Route::post('/update/status/cost/certificate/{id?}','Certify\ApplicantController@updateStatusCostCertificate');
        Route::post('/update/status/certificate','Certify\ApplicantController@updateStatusStatusCertificate');
        Route::post('/update/status/notice','Certify\ApplicantController@updateStatusNotice');
        Route::post('/update/status/comment/opinion','Certify\ApplicantController@updateStatusCommentOpinion');
        Route::get('/','Certify\ApplicantController@index');

        Route::get('/generate-pdf-lab-cal-scope/{id?}','Certify\ApplicantController@generatePdfLabCalScope')->name('certify.generate_pdf_lab_cal_scope');
        Route::get('/generate-pdf-lab-test-scope/{id?}','Certify\ApplicantController@generatePdfLabTestScope')->name('certify.generate_pdf_lab_test_scope');


        Route::get('/inspection/{id?}/{token?}','Certify\ApplicantController@PassInspection'); // ผ่านการตรวจสอบประเมิน
        Route::post('inspection/assess_update/{id?}','Certify\ApplicantController@inspection_update');
        Route::get('/assess/{id?}','Certify\ApplicantController@assess'); // บันทึกผลการตรวจประเมิน (มีข้อบกพร่อง)
        Route::post('/assess_update/{token}','Certify\ApplicantController@assess_update');
        Route::post('/update/status_confirm/{id?}','Certify\ApplicantController@updateStatusReport'); // คำขอรับรับใบรับรอง

        Route::post('/confirm-notice','Certify\ApplicantController@confirmNotice')->name('certify.confirm_notice');

        Route::post('/update/status_confirm/{id?}','Certify\ApplicantController@updateStatusReport'); // คำขอรับรับใบรับรอง

        // api Lab
        Route::post('/api/test','Certify\ApplicantController@apiTest')->name('api.test');
        Route::post('/api/calibrate','Certify\ApplicantController@apiCalibrate')->name('api.calibrate');
        Route::get('/api/certificate_exports','Certify\ApplicantController@apiCertificateExports')->name('api.certificate_exports');


        

        Route::post('/api/test/item','Certify\ApplicantController@apiTestItem')->name('api.test.items');
        Route::post('/api/test/product','Certify\ApplicantController@apiTestProduct')->name('api.test.product');
        Route::post('/api/calibrate/item','Certify\ApplicantController@apiCalibrateItem')->name('api.calibrate.items');
        Route::post('/api/calibrate/list','Certify\ApplicantController@apiCalibrateList')->name('api.calibrate.list');

        Route::get('/get_app_no_and_certificate_exports_no','Certify\ApplicantController@get_app_no_and_certificate_exports_no');
        Route::get('/is-lab-type-and-standard-belong','Certify\ApplicantController@isLabTypeAndStandardBelong');
        Route::get('/get-certificate-belong','Certify\ApplicantController@getCertificatedBelong');
        Route::post('/check-transferee','Certify\ApplicantController@checkTransferee')->name('check_lab_transferee');

        Route::post('/upload-cal-lab-cmc','Certify\ApplicantController@uploadCalLabCmc')->name('upload_cal_lab_cmc');

        Route::post('/api/instrumentgroup','Certify\ApplicantController@apiInstrumentGroup')->name('api.instrumentgroup');
        Route::post('/api/instrument','Certify\ApplicantController@apiInstrumentAndParameter')->name('api.instrument_and_parameter');

        Route::post('/api/test_category','Certify\ApplicantController@apiTestCategory')->name('api.test_category');
        Route::post('/api/test_parameter','Certify\ApplicantController@apiTestParameter')->name('api.test_parameter');

        Route::post('/api/get_certificated','Certify\ApplicantController@apiGetCertificated')->name('api.get_certificated');
        Route::post('/api/get_scope','Certify\ApplicantController@apiGetScope')->name('api.get_scope');

        // api เขต แขวง
        Route::post('/api/amphur','Certify\ApplicantController@apiAmphur')->name('api.amphur');
        Route::post('/api/district','Certify\ApplicantController@apiDistrict')->name('api.district');




        Route::post('/api/get-existing-branch','Certify\ApplicantController@getExistingBranch')->name('certify.lab.getExistingBranch'); // คำขอรับรับใบรับรอง


        //การประมาณค่าใช้จ่าย
        Route::get('/cost/{token?}','Certify\ApplicantController@EditCost');
        Route::post('/update/status/cost/{id?}','Certify\ApplicantController@updateStatusCost');

         //คณะผู้ตรวจประเมิน
         Route::get('/auditor/{token?}','Certify\ApplicantController@EditAuditor');
         Route::post('/update/status/auditor/{token?}','Certify\ApplicantController@updateStatusAuditor');

         //บันทึกการแก้ไขข้อบกพร่อง / ข้อสังเกต
         Route::get('/assessment/{id?}/{token?}','Certify\ApplicantController@EditAssessment');
         Route::post('/assessment/update/{id?}','Certify\ApplicantController@UpdateAssessment');


        //  ประวัติคำขอ
         Route::get('/data_show/{token?}/{id?}','Certify\ApplicantController@DataShow');

        // Route::get('/assessment/{token?}','Certify\ApplicantController@EditAssessment');  // ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน
        Route::get('/Log-Lab/{token?}','Certify\ApplicantController@DataLogLab');


        Route::get('/get_certificate','Certify\ApplicantController@get_certificate');
        Route::get('/get_appno','Certify\ApplicantController@get_appno');


        Route::post('/assessment/ability-confirm','Certify\ApplicantController@abilityConfirm')->name('assessment.ability-confirm');

        Route::get('/delete/file_app_certi_lab_info/{id?}/{column?}/{token?}', function($id,$column,$token)
        {

            $data = App\Models\Certify\Applicant\CertiLabInfo::findOrFail($id);

            $attach_path = 'files/applicants/check_files/';

            if(  !empty($data->{$column}) && HP::checkFileStorage($attach_path. $data->{$column})){
                Storage::delete( '/'. $attach_path.$data->{$column} );
            }

            if($column == 'desc_main_file'){
                $data->update(['desc_main_file'=>null, 'activity_client_name' => null ]);
            }

            if($column == 'file_section'){
                $data->update(['file_section'=>null, 'file_client_name' => null ]);
            }
            return redirect('/certify/applicant/edit/'.$token)->with('delete_message', 'Delete Complete!');

        });

        Route::get('/delete/file_app_certi_lab_attach_all/{id?}/{token?}', function($id,$token)
        {

            $data = App\Models\Certify\Applicant\CertiLabAttachAll::findOrFail($id);

            $attach_path = 'files/applicants/check_files/';

            if(  !empty($data->file) && HP::checkFileStorage($attach_path. $data->file)){
                Storage::delete( '/'. $attach_path.$data->file );
            }
            $data->delete();

            return redirect('/certify/applicant/edit/'.$token)->with('delete_message', 'Delete Complete!');
        });

        Route::get('/delete/file_app_certi_lab_attach_more/{id?}/{token?}', function($id,$token)
        {

            $data = App\Models\Certify\Applicant\CertiLabAttachMore::findOrFail($id);

            $attach_path = 'files/applicants/check_files/';

            if(  !empty($data->file) && HP::checkFileStorage($attach_path. $data->file)){
                Storage::delete( '/'. $attach_path.$data->file );
            }
            $data->delete();

            return redirect('/certify/applicant/edit/'.$token)->with('delete_message', 'Delete Complete!');
        });

    });

    Route::group(['prefix' => 'scope-request'], function () {
        Route::group(['prefix' => 'lab-scope-request'], function () {
            Route::get('','Certify\ScopeLabRequestController@index');
        });
        Route::group(['prefix' => 'ib-scope-request'], function () {
            Route::get('','Certify\ScopeIbRequestController@index');
        });
        Route::group(['prefix' => 'cb-scope-request'], function () {
            Route::get('','Certify\ScopeCbRequestController@index');
        });

    });




    // ใบรับรองระบบงาน (CB)
    Route::post('/certi_cb/update_delete','Certify\ApplicantCBController@deleteApplicant');
    Route::get('/certi_cb/delete/{path}/{token}','Certify\ApplicantCBController@removeFilesCertiCBAttachAll');


    Route::post('/certi_cb/get-cb-isic','Certify\ApplicantCBController@cbIsicScope')->name('certi_cb.get-cb-isic');
    Route::post('/certi_cb/get-cb-ohsms','Certify\ApplicantCBController@cbOhsmsScope')->name('certi_cb.get-cb-ohsms');
    Route::post('/certi_cb/get-cb-enms','Certify\ApplicantCBController@cbEnmsScope')->name('certi_cb.get-cb-enms');
    Route::post('/certi_cb/get-cb-bcms','Certify\ApplicantCBController@cbBcmsScope')->name('certi_cb.get-cb-bcms');
    Route::post('/certi_cb/get-cb-sfms','Certify\ApplicantCBController@cbSfmsScope')->name('certi_cb.get-cb-sfms');
    Route::post('/certi_cb/get-cb-mdms','Certify\ApplicantCBController@cbMdmsScope')->name('certi_cb.get-cb-mdms');
    Route::post('/certi_cb/get-cb-corsia','Certify\ApplicantCBController@cbCorsiaScope')->name('certi_cb.get-cb-corsia');

    // Route::post('/save-html-template','Certify\ApplicantCBController@saveHtmlTemplate')->name('certi_cb.save-html-template');
    Route::post('/certi_cb/save-html-template','Certify\ApplicantCBController@saveHtmlTemplate')->name('certi_cb.save-html-template');
    Route::post('/certi_cb/download-html-template','Certify\ApplicantCBController@downloadHtmlTemplate')->name('certi_cb.download-html-template');

    Route::get('applicant-cb/delete/file_app_certi_cb_attach_all/{id?}/{token?}', function($id,$token)
    {

        $data = App\Models\Certify\ApplicantCB\CertiCBAttachAll::findOrFail($id);

        $attach_path = 'files/applicants/check_files_cb/';

        if(  !empty($data->file) && HP::checkFileStorage($attach_path. $data->file)){
            Storage::delete( '/'. $attach_path.$data->file );
        }
        $data->delete();

        return redirect('/certify/applicant-cb/'.$token.'/edit')->with('delete_message', 'Delete Complete!');
    });


    Route::get('/certi_cb/is-cb-type-and-standard-belong','Certify\ApplicantCBController@isCbTypeAndStandardBelong');
    Route::get('/certi_cb/get-certificate-belong','Certify\ApplicantCBController@getCertificatedBelong');

    Route::get('/certi_cb/applicant_cb_doc_review/{id}','Certify\ApplicantCBController@applicant_cb_doc_review');
    Route::put('/certi_cb/applicant_cb_doc_update/{id}','Certify\ApplicantCBController@applicant_cb_doc_update');

    Route::post('/certi_cb/api/get_certificated','Certify\ApplicantCBController@apiGetCertificated')->name('certi_cb.api.get_certificated');

    Route::post('/certi_cb/get_certificated','Certify\ApplicantCBController@checkTransferee')->name('certi_cb.check_cb_transferee');

    // ลบ ไฟล์แนบ
    Route::get('certi_cb/delete_file/{id?}','Certify\ApplicantCBController@delete_file');

    Route::get('/applicant-cb/draft_pdf/{id}','Certify\ApplicantCBController@draft_pdf');
    

    Route::get('/applicant-cb/cost/{token?}','Certify\ApplicantCBController@EditCost');


    Route::get('/applicant-cb/cb-scope-editor','Certify\ApplicantCBController@scopeEditor')->name('certify.applicant-cb.cb-scope-editor');

    //การประมาณค่าใช้จ่าย  (CB)
    Route::get('/applicant-cb/cost/{token?}','Certify\ApplicantCBController@EditCost');
    Route::post('/applicant-cb/update/status/cost/{token?}','Certify\ApplicantCBController@updateStatusCost');

    Route::get('/applicant-cb/{token?}/edit_scope','Certify\ApplicantCBController@editScope')->name('applicant_cb.edit_scope');
    Route::patch('/applicant-cb/update_scope/{token?}', 'Certify\ApplicantCBController@updateScope')->name('applicant_cb.update_scope');

    //ขอความเห็นแต่งคณะผู้ตรวจประเมินเอกสาร  (CB)
    Route::get('/applicant-cb/auditor_doc_review/{token?}','Certify\ApplicantCBController@EditAuditorDocReview');

    //ขอความเห็นแต่งคณะผู้ตรวจประเมิน  (CB)
    Route::get('/applicant-cb/auditor/{token?}','Certify\ApplicantCBController@EditAuditor');
    Route::post('/applicant-cb/update/status/auditor/{token?}','Certify\ApplicantCBController@updateAuditor');
   // Pat-in ครั้งที่ 1  (CB)
    Route::get('/applicant-cb/Pay_In1/{id?}/{token?}', 'Certify\ApplicantCBController@GetCBPayInOne');
    Route::post('/applicant-cb/pay-in/{id?}','Certify\ApplicantCBController@CertiCBPayInOne');

      // ผ่านการตรวจสอบประเมิน   (CB)
    Route::get('/applicant-cb/inspection/{id?}/{token?}','Certify\ApplicantCBController@EditInspectiont');
    Route::post('/applicant-cb/inspection/update/{id?}','Certify\ApplicantCBController@UpdateInspectiont');
    // แก้ไขข้อบกพร่อง/ข้อสังเกต    (CB)
    Route::get('/applicant-cb/assessment/{id?}/{token?}','Certify\ApplicantCBController@EditAssessment');
    Route::post('/applicant-cb/assessment/update/{id?}','Certify\ApplicantCBController@UpdateAssessment');
    Route::post('/applicant-cb/assessment/confirm-bug','Certify\ApplicantCBController@ConfirmBug')->name('applicant-cb.assessment.confirm-bug');
    //คำขอใบรับรอง   (CB)
    Route::post('/applicant-cb/update_report/{id?}','Certify\ApplicantCBController@UpdateReport');
    //แจ้งรายละเอียดการชำระค่าใบรับรอง (CB)
    Route::post('/applicant-cb/update/pay-in2/{id?}','Certify\ApplicantCBController@UpdatePayInTwo');
    // สาขาตามมาตรฐาน (CB)
    Route::get('/applicant-cb/formulas/{id?}','Certify\ApplicantCBController@GetFormulas');
    // สาขาตามมาตรฐาน (CB) ใหม่
    Route::get('/applicant-cb/formulas2/{id?}','Certify\ApplicantCBController@GetFormulas2');
    Route::get('/applicant-cb/formulas-get-trust-mark/{id?}','Certify\ApplicantCBController@GetTrustMark');
    // isic
    Route::post('/applicant-cb/get-cb-isic-scope','Certify\ApplicantCBController@getCbIsicScope')->name('applicant_cb.get_cb_isic_scope');
    Route::post('/applicant-cb/demo-store-cb-isic-scope','Certify\ApplicantCBController@demoStoreIsicScope')->name('applicant_cb.demo_store_cb_isic_scope');
    Route::post('/applicant-cb/get-select-cb-isic-transaction','Certify\ApplicantCBController@getCbScopeIsicTransaction')->name('applicant_cb.get_cb_isic_scope_transaction');
    // bcms
    Route::post('/applicant-cb/get-cb-bcms-scope','Certify\ApplicantCBController@getCbBcmsScope')->name('applicant_cb.get_cb_bcms_scope');
    Route::post('/applicant-cb/demo-store-cb-bcms-scope','Certify\ApplicantCBController@demoStoreBcmsScope')->name('applicant_cb.demo_store_cb_bcms_scope');
    Route::post('/applicant-cb/get-select-cb-bcms-transaction','Certify\ApplicantCBController@getCbScopeBcmsTransaction')->name('applicant_cb.get_cb_bcms_scope_transaction');
    Route::post('/applicant-cb/update-doc-review-team','Certify\ApplicantCBController@updateDocReviewTeam')->name('applicant_cb.update_doc_review_team');
    Route::get('/applicant-cb/get-cb-doc-review-auditor','Certify\ApplicantCBController@getCbDocReviewAuditor')->name('applicant_cb.ge_cb_doc_review_auditor');
    //log
    Route::get('/applicant-cb/Log-CB/{token?}','Certify\ApplicantCBController@DataLogCB');

    Route::get('/applicant-cb/get_app_no_and_certificate_exports_no','Certify\ApplicantCBController@get_app_no_and_certificate_exports_no');

    Route::post('/applicant-cb/ability-confirm','Certify\ApplicantCBController@abilityConfirm')->name('applicant-cb.ability-confirm');

    Route::resource('applicant-cb','Certify\ApplicantCBController');
      // อ่านไฟล์ที่แนบมา
    //  Route::get('check/files_cb/{filename}', function($filename)
    // {
    //  $public = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
    //   $filePath =  response()->download($public.'/files/applicants/check_files_cb/' . $filename);
    //  return $filePath;
    // });

    // ใบรับรองระบบงาน (IB)
    Route::post('/certi_ib/update_delete','Certify\ApplicantIBController@deleteApplicant');
    Route::get('/certi_ib/delete/{path}/{token}','Certify\ApplicantIBController@removeFilesCertiIBAttachAll');

    Route::post('/certi_ib/get_ib_main_category', 'Certify\ApplicantIBController@getIbMainCategory')->name('certi_ib.get-ib-main-category');
    Route::post('/certi_ib/get_ib_sub_category', 'Certify\ApplicantIBController@getIbSubCategory')->name('certi_ib.get-ib-sub-category');
    Route::post('/certi_ib/get_ib_scope_topic', 'Certify\ApplicantIBController@getIbScopeTopic')->name('certi_ib.get-ib-scope-topic');
    Route::post('/certi_ib/get_ib_scope_detail', 'Certify\ApplicantIBController@getIbScopeDetail')->name('certi_ib.get-ib-scope-detail');
    Route::get('/certi_ib/is-ib-type-and-standard-belong', 'Certify\ApplicantIBController@isIbTypeAndStandardBelong');
    Route::get('/certi_ib/get-certificate-belong', 'Certify\ApplicantIBController@getCertificatedBelong');

    Route::post('/certi_ib/api/get_certificated','Certify\ApplicantIBController@apiGetCertificated')->name('certi_ib.api.get_certificated');

    Route::post('/certi_ib/get_certificated','Certify\ApplicantIBController@checkTransferee')->name('certi_ib.check_ib_transferee');


    Route::post('/save-html-template','Certify\ApplicantIBController@saveHtmlTemplate')->name('certi_ib.save-html-template');
    Route::post('/download-html-template','Certify\ApplicantIBController@downloadHtmlTemplate')->name('certi_ib.download-html-template');


    Route::get('applicant-ib/delete/file_app_certi_ib_attach_all/{id?}/{token?}', function($id,$token)
    {

        $data = App\Models\Certify\ApplicantIB\CertiIBAttachAll::findOrFail($id);

        $attach_path = 'files/applicants/check_files_ib/';

        if(  !empty($data->file) && HP::checkFileStorage($attach_path. $data->file)){
            Storage::delete( '/'. $attach_path.$data->file );
        }
        $data->delete();

        return redirect('/certify/applicant-ib/'.$token.'/edit')->with('delete_message', 'Delete Complete!');
    });


    Route::get('/applicant-ib/ib-scope-editor','Certify\ApplicantIBController@scopeEditor')->name('certify.applicant-ib.ib-scope-editor');
    
    //การประมาณค่าใช้จ่าย  (IB)
    Route::get('/applicant-ib/cost/{token?}','Certify\ApplicantIBController@EditCost');
    Route::post('/applicant-ib/update/status/cost','Certify\ApplicantIBController@updateStatusCost');

    Route::get('/applicant-ib/{token?}/edit_scope','Certify\ApplicantIBController@editScope')->name('applicant_ib.edit_scope');
    // Route::post('/applicant-ib/update_scope','Certify\ApplicantIBController@updateScope')->name('applicant_ib.update_scope');
    Route::patch('/applicant-ib/update_scope/{token?}', 'Certify\ApplicantIBController@updateScope')->name('applicant_ib.update_scope');

    Route::post('/applicant-ib/update-doc-review-team','Certify\ApplicantIBController@updateDocReviewTeam')->name('applicant_ib.update_doc_review_team');
    Route::post('/applicant-ib/get-ib-doc-review-auditor','Certify\ApplicantIBController@getIbDocReviewAuditor')->name('applicant_ib.ge_ib_doc_review_auditor');

    //ขอความเห็นแต่งคณะผู้ตรวจประเมิน  (IB)
    Route::get('/applicant-ib/auditor/{token?}','Certify\ApplicantIBController@EditAuditor');
    Route::post('/applicant-ib/update/status/auditor/{token?}','Certify\ApplicantIBController@updateAuditor');
    // Pat-in ครั้งที่ 1  (IB)
    Route::get('/applicant-ib/Pay_In1/{id?}/{token?}', 'Certify\ApplicantIBController@GetIBPayInOne');
    Route::post('/applicant-ib/pay-in/{id?}','Certify\ApplicantIBController@CertiIBPayInOne');
    // ผ่านการตรวจสอบประเมิน   (IB)
    Route::get('/applicant-ib/inspection/{id?}/{token?}','Certify\ApplicantIBController@EditInspectiont');
    Route::post('/applicant-ib/inspection/update/{id?}','Certify\ApplicantIBController@UpdateInspectiont');
    // แก้ไขข้อบกพร่อง/ข้อสังเกต    (IB)
    Route::get('/applicant-ib/assessment/{id?}/{token?}','Certify\ApplicantIBController@EditAssessment');
    Route::post('/applicant-ib/assessment/update/{id?}','Certify\ApplicantIBController@UpdateAssessment');
    Route::post('/applicant-ib/assessment/confirm-bug','Certify\ApplicantIBController@ConfirmBug')->name('applicant-ib.assessment.confirm-bug');

    Route::post('/applicant-ib/update_report/{id?}','Certify\ApplicantIBController@UpdateReport');

    Route::post('/applicant-ib/update/pay-in2/{id?}','Certify\ApplicantIBController@UpdatePayInTwo');

    Route::get('/applicant-ib/draft_pdf/{id}','Certify\ApplicantIBController@draft_pdf');

        //log
    Route::get('/applicant-ib/Log-IB/{token?}','Certify\ApplicantIBController@DataLogIB');
    Route::get('/check_mail/{id?}','Certify\CheckController@check_mails');

    Route::get('applicant-ib/get_app_no_and_certificate_exports_no','Certify\ApplicantIBController@get_app_no_and_certificate_exports_no');

    Route::post('/applicant-ib/ability-confirm','Certify\ApplicantIBController@abilityConfirm')->name('applicant-ib.ability-confirm');

    Route::resource('applicant-ib', 'Certify\\ApplicantIBController');


    Route::group(['prefix' => 'tracking-labs'], function () {
        Route::post('/lab-ability-confirm/{id?}','Certify\ApplicantTrackingLABController@abilityConfirm')->name('tracking-lab.ability-confirm');

        Route::get('/data_list','Certify\ApplicantTrackingLABController@data_list');
        Route::get('/', 'Certify\ApplicantTrackingLABController@index');
        Route::resource('/', 'Certify\ApplicantTrackingLABController');
        // ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน lab
        Route::get('/tracking-auditor/{id?}','Certify\ApplicantTrackingLABController@auditor');
        Route::post('/update/tracking-auditor/{id?}','Certify\ApplicantTrackingLABController@updateAuditor');
        // Pay-in ครั้งที่ 1
        Route::get('/tracking-pay_in1/{id?}','Certify\ApplicantTrackingLABController@pay_in1');
        Route::post('/update/pay-in/{id?}','Certify\ApplicantTrackingLABController@update_pay_in1');
        // บันทึกผลการตรวจประเมิน
        Route::get('/assessment/{id?}','Certify\ApplicantTrackingLABController@assessment');
        Route::post('/assessment/update/{id?}','Certify\ApplicantTrackingLABController@update_assessment');
        // ผลการตรวจประเมิน
        Route::get('/evaluation/{id?}','Certify\ApplicantTrackingLABController@evaluation');
        Route::post('/evaluation/update/{id?}','Certify\ApplicantTrackingLABController@update_evaluation');
        Route::post('/evaluation/confirm-notice','Certify\ApplicantTrackingLABController@confirmNotice')->name('evaluation.confirm-notice');

        // สรุปผลตรวจประเมิน
        Route::post('/inspection/update/{id?}','Certify\ApplicantTrackingLABController@update_inspection');
        //สรุปรายงานและเสนออนุกรรมการฯ
        Route::post('/report/update/{id?}','Certify\ApplicantTrackingLABController@update_report');
          // Pay-in ครั้งที่ 2
        Route::post('/pay-in2/update/{id?}','Certify\ApplicantTrackingLABController@update_payin2');
    });

    Route::group(['prefix' => 'tracking-cb'], function () {

        Route::post('/cb-ability-confirm/{id?}','Certify\ApplicantTrackingCBController@abilityConfirm')->name('tracking-cb.ability-confirm');

        Route::get('/', 'Certify\ApplicantTrackingCBController@index');
        Route::resource('/', 'Certify\ApplicantTrackingCBController');
        // ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน lab
        Route::get('/tracking-auditor/{id?}','Certify\ApplicantTrackingCBController@auditor');
        Route::post('/update/tracking-auditor/{id?}','Certify\ApplicantTrackingCBController@updateAuditor');
        // Pay-in ครั้งที่ 1
        Route::get('/tracking-pay_in1/{id?}','Certify\ApplicantTrackingCBController@pay_in1');
        Route::post('/update/pay-in/{id?}','Certify\ApplicantTrackingCBController@update_pay_in1');

        Route::get('/assessment/{id?}','Certify\ApplicantTrackingCBController@assessment');
        Route::post('/assessment/update/{id?}','Certify\ApplicantTrackingCBController@update_assessment');
        // บันทึกผลการตรวจประเมิน
        Route::get('/evaluation/{id?}','Certify\ApplicantTrackingCBController@evaluation');
        Route::post('/evaluation/update/{id?}','Certify\ApplicantTrackingCBController@update_evaluation');

        Route::post('/evaluation/confirm-cb-bug','Certify\ApplicantTrackingCBController@confirmBug')->name('evaluation.confirm-cb-bug');
        // สรุปผลตรวจประเมิน
        Route::post('/inspection/update/{id?}','Certify\ApplicantTrackingCBController@update_inspection');
        //สรุปรายงานและเสนออนุกรรมการฯ
        Route::post('/report/update/{id?}','Certify\ApplicantTrackingCBController@update_report');
         // Pay-in ครั้งที่ 2
        Route::post('/pay-in2/update/{id?}','Certify\ApplicantTrackingCBController@update_payin2');


  Route::post('/update-doc-review-team','Certify\ApplicantTrackingCBController@updateDocReviewTeam')->name('tracking.update_cb_doc_review_team');
        Route::post('/get-doc-review-auditor','Certify\ApplicantTrackingCBController@getTrackingDocReviewAuditor')->name('tracking.get_cb_doc_review_auditor');


    });

    Route::group(['prefix' => 'tracking-ib'], function () {
        Route::post('/ib-ability-confirm/{id?}','Certify\\ApplicantTrackingIBController@abilityConfirm')->name('tracking-ib.ability-confirm');

        Route::get('/', 'Certify\\ApplicantTrackingIBController@index');
        Route::resource('/', 'Certify\\ApplicantTrackingIBController');
        // ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน lab
        Route::get('/tracking-auditor/{id?}','Certify\\ApplicantTrackingIBController@auditor');
        Route::post('/update/tracking-auditor/{id?}','Certify\\ApplicantTrackingIBController@updateAuditor');
        // Pay-in ครั้งที่ 1
        Route::get('/tracking-pay_in1/{id?}','Certify\\ApplicantTrackingIBController@pay_in1');
        Route::post('/update/pay-in/{id?}','Certify\\ApplicantTrackingIBController@update_pay_in1');

        Route::get('/assessment/{id?}','Certify\\ApplicantTrackingIBController@assessment');
        Route::post('/assessment/update/{id?}','Certify\\ApplicantTrackingIBController@update_assessment');
        // บันทึกผลการตรวจประเมิน
        Route::get('/evaluation/{id?}','Certify\\ApplicantTrackingIBController@evaluation');
        Route::post('/evaluation/update/{id?}','Certify\\ApplicantTrackingIBController@update_evaluation');
         Route::post('/evaluation/confirm-ib-bug','Certify\\ApplicantTrackingIBController@confirmBug')->name('evaluation.confirm-ib-bug');

        // สรุปผลตรวจประเมิน
        Route::post('/inspection/update/{id?}','Certify\\ApplicantTrackingIBController@update_inspection');
        //สรุปรายงานและเสนออนุกรรมการฯ
        Route::post('/report/update/{id?}','Certify\\ApplicantTrackingIBController@update_report');
         // Pay-in ครั้งที่ 2
        Route::post('/pay-in2/update/{id?}','Certify\\ApplicantTrackingIBController@update_payin2');


        Route::post('/update-doc-review-team','Certify\\ApplicantTrackingIBController@updateDocReviewTeam')->name('tracking.update_ib_doc_review_team');
        Route::post('/get-doc-review-auditor','Certify\\ApplicantTrackingIBController@getTrackingDocReviewAuditor')->name('tracking.get_ib_doc_review_auditor');

    });


});


//  Start ข้อมูลพื้นฐาน
Route::resource('admin/basic/provinces', 'Admin\Basic\\provincesController');
//  End ข้อมูลพื้นฐาน

Route::get('basic/amphur/list/{province_id}', function ($province_id){
    return response()->json(App\Models\Basic\Amphur::whereNull('state')->where('PROVINCE_ID', $province_id)->pluck('AMPHUR_NAME', 'AMPHUR_ID'));
});

Route::get('basic/district/list/{amphur_id}', function ($amphur_id){
    return response()->json(App\Models\Basic\District::whereNull('state')->where('AMPHUR_ID', $amphur_id)->pluck('DISTRICT_NAME', 'DISTRICT_ID'));
});

Auth::routes();

Route::get('basic/license-list/{tis_no}', function ($tis_no){
    return response()->json(HP::OwnLicenseByTis($tis_no));
});

Route::get('basic/license-list-nomoao5/{tis_no}', function ($tis_no) {
    return response()->json(HP::OwnLicenseByTisNoMoao5($tis_no));
});

Route::get('basic/license-detail-list/{Autono}', function ($Autono){
    return response()->json(HP::LicenseDetailByLicenseNo($Autono));
});

Route::get('basic/license-item/{Autono}', function ($Autono){
    return response()->json(HP::License($Autono));
});

//ดูข้อมูลใบอนุญาต
Route::resource('esurv/tisi_license', 'Esurv\TisiLicenseController');
//แก้ไขลำดับรายละเอียดผลิตภัณฑ์
Route::get('esurv/license_detail_edit', 'Esurv\TisiLicenseDetailController@edit');
Route::post('esurv/license_detail_edit', 'Esurv\TisiLicenseDetailController@update');

Route::put('esurv/inform_qc/update-state', 'Esurv\InformQcController@update_state');
Route::resource('esurv/inform_qc', 'Esurv\\InformQcController');

Route::put('esurv/inform_calibration/update-state', 'Esurv\InformCalibrationController@update_state');
Route::resource('esurv/inform_calibration', 'Esurv\\InformCalibrationController');

Route::get('/certify/api/test/data/api_test_item/{id?}','Certify\ApplicantController@dataApiTestItem');


Route::put('resurv/report_product/update-state', 'REsurv\ReportProductController@update_state');
Route::resource('resurv/report_product', 'REsurv\\ReportProductController');
Route::post('/resurv/report_product/update', 'REsurv\ReportProductController@update');
Route::get('/resurv/report_product/detail/{ID}', 'REsurv\ReportProductController@detail');
Route::get('/resurv/report_product/download/{NAME}', 'REsurv\ReportProductController@download_file');

Route::post('auth/checkemailexits', 'Auth\RegisterController@checkemailexits');

//ลบไฟล์ที่เก็บชั่วคราวไว้สำหรับโชว์ใน uploads
Route::get('schedule/delete-uploads', 'ScheduleController@delete_uploads');


// Route::put('admin/basic/expertgroups/update-state', 'Admin\Basic\ExpertGroupsController@update_state');
// Route::resource('admin/basic/expert-groups', 'Admin\Basic\\ExpertGroupsController');

Route::post('experts/update_document', 'ExpertsController@update_document');
// Route::post('experts/detail', 'ExpertsController@detail');

Route::put('/experts/update-state', 'ExpertsController@update_state');

Route::get('experts/getfile/{filename}', function($filename)
{
    $public = public_path();
    // $attach_path = 'files/expert/';
    if(HP::checkFileStorage($filename)){
    HP::getFileStorage($filename);
    $filePath =  response()->file($public.'/uploads/'.$filename);
        return $filePath;
    }else{
    return 'ไม่พบไฟล์';
    }
});
Route::resource('experts', 'ExpertsController');


Route::get('gta-auditors', 'AuditorsController@index');
Route::post('gta-auditors/store', 'AuditorsController@store');
Route::get('/bcertify/api/check_scope', [  // api ขอบข่าย
    'as' => 'bcertify.api.check_scope',
    'uses' => 'AuditorsController@apiScope']);
Route::post('/bcertify/api/check_inspection', [  // api ประเภทหน่วยตรวจ
        'as' => 'bcertify.api.check_inspection',
        'uses' => 'AuditorsController@apiInspection']);
Route::post('/bcertify/api/check_calibration', [  // api รายการสอบเทียบ
        'as' => 'bcertify.api.check_calibration',
        'uses' => 'AuditorsController@apiCalibration']);
Route::post('/bcertify/api/check_product', [  // api ประเภทผลิตภัณฒ์ and api รายการทดสอบ
         'as' => 'bcertify.api.check_product',
         'uses' => 'AuditorsController@apiProduct']);
   Route::POST('/bcertify/api/check_standard', [  // api มาตรฐาน
        'as' => 'bcertify.api.check_standard',
        'uses' => 'AuditorsController@apiStandard']);

// ทดสอบส่งอีเมล
Route::get('basic/mail-test', 'Basic\\MailTestController@index');
Route::POST('basic/send_mail', 'Basic\\MailTestController@send_mail');
