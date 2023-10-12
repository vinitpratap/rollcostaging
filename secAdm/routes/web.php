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

Route::get('/', 'AdminController@index')->name('admin.dashboard');

Auth::routes();

Route::POST('admin/auth', 'Auth\LoginController@login')->name('LoginProcess');

Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('login', 'Auth\Admin\LoginController@login')->name('admin.auth.login');
    Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
    Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');

    Route::get('password/reset',
            'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email',
            'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}',
            'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    Route::ANY('change-password', 'AdminController@ChangePassword')->name('admin.changePwd');

    //Route::POST('add-new-page', 'CMSController@AddNewPage')->name('page.register');
    Route::POST('edit-request-ajax', 'CustomerReqController@GetRequestData')->name('request.data');
    Route::get('view-request/type/{type}/{id}', 'CustomerReqController@Requests')->name('request.manage');
    Route::get('view-request-not-accept/type/{type}/{id}',
            'CustomerReqController@RequestNotAccepted')->name('requestnotaccept.manage');
    Route::post('edit-request', 'CustomerReqController@EditRequest')->name('request.edit');
    Route::get('delete-request/{id}', 'CustomerReqController@DeleteRequest')->name('request.delete');
    Route::get('export-request-excel/{id}',
            'CustomerReqController@exportToExcelRequest')->name('request.export');
    Route::post('servicereq-register',
            'CustomerReqController@CustRequestRegister')->name('servicereq.register');

    Route::get('filter-request', 'CustomerReqController@filterRequest')->name('request.filter');
    Route::POST('cancel-request-ajax', 'CustomerReqController@cancelRequest')->name('request.cancel');
    // Route::GET('add-request', 'CustomerReqController@AddRequest')->name('request.register');
    // rollco

    Route::POST('add-new-usercategory',
            'UserCategoryController@AddNewUserCategory')->name('usercategory.register');
    Route::get('view-usercategory', 'UserCategoryController@UserCategories')->name('usercategory.manage');
    Route::post('edit-usercategory-ajax',
            'UserCategoryController@GetUserCategoryData')->name('usercategory.data');
    Route::post('edit-usercategory', 'UserCategoryController@EditUserCategory')->name('usercategory.edit');
    Route::get('delete-usercategory/{id}',
            'UserCategoryController@DeleteUserCategory')->name('usercategory.delete');
    Route::get('export-customercat-excel',
            'UserCategoryController@exportToExcelCustomerCat')->name('customercat.export');
    Route::POST('add-new-currency', 'CurrencyController@AddNewCurrency')->name('currency.register');
    Route::get('view-currency', 'CurrencyController@Currencies')->name('currency.manage');
    Route::post('edit-currency-ajax', 'CurrencyController@GetCurrencyData')->name('currency.data');
    Route::post('edit-currency', 'CurrencyController@EditCurrency')->name('currency.edit');
    Route::get('delete-currency/{id}', 'CurrencyController@DeleteCurrency')->name('currency.delete');

    //Route::POST('check-techavail-ajax', 'CustomerReqController@CheckTechAvailability');

    Route::POST('add-new-category', 'CategoryController@AddNewCategory')->name('category.register');
    Route::get('view-category', 'CategoryController@Categories')->name('category.manage');
    Route::post('edit-category-ajax', 'CategoryController@GetCategoryData')->name('category.data');
    Route::post('edit-category', 'CategoryController@EditCategory')->name('category.edit');
    Route::get('delete-category/{id}', 'CategoryController@DeleteCategory')->name('category.delete');

    Route::POST('add-new-make', 'MakeController@AddNewMake')->name('make.register');
    Route::get('view-make', 'MakeController@Make')->name('make.manage');
    Route::POST('edit-make-ajax', 'MakeController@GetMakeData')->name('make.data');
    Route::post('edit-make', 'MakeController@EditMake')->name('make.edit');
    Route::get('delete-make/{id}', 'MakeController@DeleteMake')->name('make.delete');

    Route::POST('add-new-model', 'ModelController@AddNewModel')->name('model.register');
    Route::get('view-model', 'ModelController@Models')->name('model.manage');
    Route::POST('edit-model-ajax', 'ModelController@GetModelData')->name('model.data');
    Route::post('edit-model', 'ModelController@EditModel')->name('model.edit');
    Route::get('delete-model/{id}', 'ModelController@DeleteModel')->name('model.delete');
    Route::post('get-make-data', 'ModelController@GetMakeDataByCategory');
    Route::post('get-model-data', 'ModelController@GetModelDataByMake');
    Route::post('get-proyear-data', 'ProYearController@GetProYearDataByModel');

    Route::POST('add-new-proyr', 'ProYearController@AddNewProYear')->name('proyr.register');
    Route::get('manage-proyr', 'ProYearController@ProYears')->name('proyr.manage');
    Route::POST('edit-proyr-ajax', 'ProYearController@GetProYearData')->name('proyr.data');
    Route::post('edit-proyr', 'ProYearController@EditProYear')->name('proyr.edit');
    Route::get('delete-proyr/{id}', 'ProYearController@DeleteProYear')->name('proyr.delete');

    Route::POST('add-new-proccm', 'ProCCMController@AddNewProCCM')->name('proccm.register');
    Route::get('manage-proccm', 'ProCCMController@ProCCMs')->name('proccm.manage');
    Route::POST('edit-proccm-ajax', 'ProCCMController@GetProCCMData')->name('proccm.data');
    Route::post('edit-proccm', 'ProCCMController@EditProCCM')->name('proccm.edit');
    Route::get('delete-proccm/{id}', 'ProCCMController@DeleteProCCM')->name('proccm.delete');
    Route::post('get-proccm-data', 'ProCCMController@GetProCCMDataByYear');

    Route::POST('add-new-engcode', 'EngineCodeController@AddNewEngineCode')->name('engcode.register');
    Route::get('manage-engcode', 'EngineCodeController@EngineCodes')->name('engcode.manage');
    Route::POST('edit-engcode-ajax', 'EngineCodeController@GetEngineCodeData')->name('engcode.data');
    Route::post('edit-engcode', 'EngineCodeController@EditEngineCode')->name('engcode.edit');
    Route::get('delete-engcode/{id}', 'EngineCodeController@DeleteEngineCode')->name('engcode.delete');
    Route::post('get-engcode-data',
            'EngineCodeController@GetEngineCodeDataByCCM');

    Route::POST('add-new-product', 'ProductController@AddNewProduct')->name('product.register');
    Route::get('manage-product', 'ProductController@Products')->name('product.manage');
    Route::POST('edit-product-ajax', 'ProductController@GetProductData')->name('product.data');
    Route::post('edit-product', 'ProductController@EditProduct')->name('product.edit');
    Route::get('delete-product/{id}', 'ProductController@DeleteProduct')->name('product.delete');

    Route::POST('add-new-spare', 'SpareController@AddNewSpare')->name('spare.register');
    Route::ANY('upload-spare', 'SpareController@UploadSpare')->name('spare.upload');
    Route::get('manage-spare', 'SpareController@Spares')->name('spare.manage');
    Route::POST('edit-spare-ajax', 'SpareController@GetSpareData')->name('spare.data');
    Route::post('edit-spare', 'SpareController@EditSpare')->name('spare.edit');
    Route::get('delete-spare/{id}', 'SpareController@DeleteSpare')->name('spare.delete');
    //Route::POST('get-subcategories-ajax', 'SubCategoryController@GetSubCategoryDataByCategory');
    Route::POST('get-product-data', 'ProductController@GetProductDataByMake');

    Route::POST('add-new-crossref', 'CrossReferenceController@AddNewCrossRef')->name('crossref.register');
    Route::get('manage-crossref', 'CrossReferenceController@CrossRefs')->name('crossref.manage');
    Route::POST('edit-crossref-ajax', 'CrossReferenceController@GetCrossRefData')->name('crossref.data');
    Route::post('edit-crossref', 'CrossReferenceController@EditCrossRef')->name('crossref.edit');
    Route::get('delete-crossref/{id}', 'CrossReferenceController@DeleteCrossRef')->name('crossref.delete');
    Route::POST('delete-crossref-ajax',
            'CrossReferenceController@DeleteCrossRefAjax');
    Route::POST('changestatus-crossref-ajax',
            'CrossReferenceController@ChangeStatusCrossRefAjax');

    Route::ANY('changestatus-crossref', 'CrossReferenceController@ChangeStatusCrossRefData')->name('crossref.changestatus');

    Route::POST('add-new-sparecrossref',
            'SpareCrossReferenceController@AddNewSpareCrossRef')->name('sparecrossref.register');
    Route::get('manage-sparecrossref',
            'SpareCrossReferenceController@SpareCrossRefs')->name('sparecrossref.manage');
    Route::POST('edit-sparecrossref-ajax',
            'SpareCrossReferenceController@GetSpareCrossRefData')->name('sparecrossref.data');
    Route::post('edit-sparecrossref',
            'SpareCrossReferenceController@EditSpareCrossRef')->name('sparecrossref.edit');
    Route::get('delete-sparecrossref/{id}',
            'SpareCrossReferenceController@DeleteSpareCrossRef')->name('sparecrossref.delete');
    Route::POST('delete-sparecrossref-ajax',
            'SpareCrossReferenceController@DeleteSpareCrossRefAjax');

    Route::POST('add-new-customer', 'CustomerController@AddNewCustomer')->name('customer.register');
    Route::POST('add-customer-ajax', 'CustomerController@AddNewCustomerAjax');
    Route::POST('edit-customer', 'CustomerController@EditCustomer')->name('customer.edit');
    Route::get('view-customer/type/{type}/{id}', 'CustomerController@Customers')->name('customer.manage');
    Route::post('edit-customer-ajax', 'CustomerController@GetCustomerData')->name('customer.edit');
    Route::get('del-customer/{id}', 'CustomerController@DeleteCustomer')->name('customer.del');
    Route::POST('delete-customer-ajax',
            'CustomerController@DeleteCustomerAjax');

    Route::post('search-customer', 'CustomerController@SearchCustomer')->name('customer.search');
    Route::get('export-customer-excel',
            'CustomerController@exportToExcelCustomer')->name('customer.export');

    Route::POST('add-new-news', 'NewsController@AddNewNews')->name('news.register');
    Route::get('view-news', 'NewsController@News')->name('news.manage');
    Route::post('edit-news-ajax', 'NewsController@GetNewsData')->name('news.data');
    Route::post('edit-news', 'NewsController@EditNews')->name('news.edit');
    Route::get('delete-news/{id}', 'NewsController@DeleteNews')->name('news.delete');

    Route::POST('add-new-exb', 'ExbController@AddNewExb')->name('exb.register');
    Route::get('view-exb', 'ExbController@Exbs')->name('exb.manage');
    Route::post('edit-exb-ajax', 'ExbController@GetExbData')->name('exb.data');
    Route::post('edit-exb', 'ExbController@EditExb')->name('exb.edit');
    Route::get('delete-exb/{id}', 'ExbController@DeleteExb')->name('exb.delete');

    Route::POST('add-new-announcement',
            'AnnouncementController@AddNewAnnouncement')->name('announcement.register');
    Route::get('view-announcement', 'AnnouncementController@Announcements')->name('announcement.manage');
    Route::post('edit-announcement-ajax',
            'AnnouncementController@GetAnnouncementData')->name('announcement.data');
    Route::post('edit-announcement', 'AnnouncementController@EditAnnouncement')->name('announcement.edit');
    Route::get('delete-announcement/{id}',
            'AnnouncementController@DeleteAnnouncement')->name('announcement.delete');

    Route::get('view-visitor', 'HomeController@Visitors')->name('visitor.manage');
    Route::get('delete-visitor/{id}', 'HomeController@DeleteVisitor')->name('visitor.delete');

    Route::get('view-searchnotfound', 'HomeController@SearchNotFoundLists')->name('searchnotfound.manage');
    Route::get('delete-searchnotfound/{id}',
            'HomeController@DeleteSearchNotFound')->name('searchnotfound.delete');
    Route::get('export-searchnotfound-excel/{id}',
            'CustomerReqController@exportToExcelRequest')->name('searchnotfound.export');

    /* -----added for group----- */
    Route::POST('add-new-group', 'GroupController@AddNewGroup')->name('group.register');
    Route::get('view-group', 'GroupController@Groups')->name('group.manage');
    Route::POST('edit-group-ajax', 'GroupController@GetGroupData')->name('group.data');
    Route::post('edit-group', 'GroupController@EditGroup')->name('group.edit');
    Route::get('delete-group/{id}', 'GroupController@DeleteGroup')->name('group.delete');
    Route::get('manage-product-group/{id}', 'GroupController@ProductsGroup')->name('productgroup.manage');
    Route::get('delete-product-group/{id}/{pid}',
            'GroupController@DeleteProductsGroup')->name('productsgroup.delete');

    Route::POST('edit-product-group', 'GroupController@EditProductGroup')->name('productsgroup.edit');
    Route::POST('edit-product-group-ajax', 'GroupController@GetProductGroupData')->name('productsgroup.data');

    /* -----added for group----- */


    Route::get('upload-spare-service', 'SpareController@spearService')->name('spearService.manage');
    Route::POST('upload-spareservice', 'SpareController@uploadspearService')->name('spearService.upload');

    Route::get('upload-spare-oem', 'SpareController@spearOEM')->name('spearOEM.manage');
    Route::POST('upload-spareoem', 'SpareController@uploadspearOEM')->name('spearOEM.upload');

    Route::get('upload-application', 'ProductController@application')->name('application.manage');
    Route::POST('uploadApplication', 'ProductController@uploadapplication')->name('application.upload');

    Route::POST('delete-application-ajax',
            'ProductController@DeleteApplicationAjax');

    Route::get('manage-spare-service/{id}', 'SpareController@getspearService')->name('spare_services.manage');
    Route::POST('edit-spare-service', 'SpareController@EditSpareService')->name('spare_services.edit');
    Route::POST('edit-spare-service-ajax', 'SpareController@getspearServiceData')->name('spearService.data');
    Route::get('delete-spare-service/{id}/{pid}',
            'SpareController@DeletespearService')->name('spare_services.delete');

    Route::get('manage-spare-oem/{id}', 'SpareController@getspearOEM')->name('spare_oem.manage');
    Route::POST('edit-spare-oem', 'SpareController@EditSpareOEM')->name('spare_oem.edit');
    Route::POST('edit-spare-oem-ajax', 'SpareController@getoemData')->name('spearOEM.data');
    Route::get('delete-spare-oem/{id}/{pid}', 'SpareController@DeletespearOEM')->name('spare_oem.delete');

    Route::get('manage-product-application/{id}',
            'ProductController@getproductApplication')->name('product_application.manage');
    Route::POST('edit-product-application',
            'ProductController@EditproductApplication')->name('product_application.edit');
    Route::POST('edit-product-application-ajax',
            'ProductController@getproductApplicationData')->name('product_application.data');
    Route::get('delete-product-application/{id}/{pid}',
            'ProductController@DeleteproductApplication')->name('product_application.delete');

    Route::POST('add-new-mcategory', 'MCategoryController@AddNewMCategory')->name('mcategory.register');
    Route::get('view-mcategory', 'MCategoryController@MCategories')->name('mcategory.manage');
    Route::post('edit-mcategory-ajax', 'MCategoryController@GetMCategoryData')->name('mcategory.data');
    Route::post('edit-mcategory', 'MCategoryController@EditMCategory')->name('mcategory.edit');
    Route::get('delete-mcategory/{id}', 'MCategoryController@DeleteMCategory')->name('mcategory.delete');

    Route::post('get-category-data',
            'CategoryController@GetCategoryDataByMCategory');

    Route::get('upload-MsCode', 'ProductController@MsCode')->name('MsCode.manage');
    Route::POST('uploadMsCode', 'ProductController@uploadMsCode')->name('MsCode.upload');

    Route::get('upload-products', 'ProductController@uproducts')->name('products.manage');
    Route::POST('uploadproducts', 'ProductController@uploadproducts')->name('products.upload');

    Route::ANY('uploadproductsstock', 'ProductController@uploadproductsstock')->name('productsstock.upload');

    Route::get('view-orders', 'OrderController@Orders')->name('order.manage');
    Route::get('view-order-details/{id}', 'OrderController@OrderDetail')->name('order.details');
    Route::post('edit-orders', 'OrderController@EditOrder')->name('order.edit');
    Route::get('delete-orders/{id}', 'OrderController@DeleteOrder')->name('order.delete');

    Route::get('view-contacts', 'ContactController@Contacts')->name('contact.manage');
    Route::get('delete-contacts/{id}', 'ContactController@DeleteContact')->name('contact.delete');

    Route::get('view-enquiry', 'ContactController@Enquiries')->name('enquiry.manage');
    Route::get('delete-enquiry/{id}', 'ContactController@Deleteenquiry')->name('enquiry.delete');

    Route::get('export-contact-excel', 'ContactController@exportToExcelContact')->name('contact.export');

    Route::POST('delete-contact-ajax',
            'ContactController@DeleteContactAjax');
    Route::POST('delete-enquiry-ajax',
            'ContactController@DeleteEnquiryAjax');

    Route::get('export-enquiry-excel', 'ContactController@exportToExcelRequest')->name('enquiry.export');

    Route::get('view-search-not-found', 'ContactController@SearchNotFound')->name('search_nf.manage');
    Route::get('delete-view-search-not-found/{id}',
            'ContactController@DeleteSearchNotFound')->name('search_nf.delete');
    Route::POST('delete-snf-ajax',
            'ContactController@DeleteSearchNotFoundAjax');

    Route::get('export-search_nf-excel', 'ContactController@exportToExcelSNF')->name('search_nf.export');
    Route::get('export-search_nfall-excel', 'ContactController@exportToExcelSNFAll')->name('search_nfall.export');

    Route::get('view-recent-search', 'ContactController@SearchRecent')->name('recent_search.manage');
    Route::get('delete-view-recent-search/{id}',
            'ContactController@DeleteSearchRecent')->name('recent_search.delete');
    Route::get('export-recent-search-excel', 'ContactController@exportToExcelRP')->name('recent_search.export');

    Route::POST('delete-recent-search-ajax',
            'ContactController@DeleteSearchRecentAjax');

    Route::get('view-newsltr', 'NewsletterController@Newsletters')->name('newsltr.manage');
    Route::get('delete-newsltr/{id}', 'NewsletterController@DeleteNewsletter')->name('newsltr.delete');
    Route::get('export-newsltr-excel',
            'NewsletterController@exportToExcelNewsLtr')->name('newsltr.export');

    Route::get('export-order-excel', 'OrderController@exportToExcelOrders')->name('order.export');
    Route::get('export-orderunits-excel', 'OrderController@exportToExcelOrderUnitWise')->name('orderunitwise.export');

    Route::get('export-product-excel', 'ProductController@exportToExcelProduct')->name('product.export');
    Route::get('export-group-excel', 'GroupController@exportToExcelGroup')->name('group.export');
    Route::ANY('upload-product-bulkimage',
            'ProductController@bulkProductImageUpload')->name('productbulkimage.upload');

    Route::POST('upload-catalogue', 'CatalogueController@UploadCatalogue')->name('catalogue.upload');
    Route::get('view-catalogue', 'CatalogueController@Catalogues')->name('catalogue.manage');
    Route::POST('edit-catalogue', 'CatalogueController@EditCatalogue')->name('catalogue.edit');
    Route::POST('edit-catalogue-ajax', 'CatalogueController@getCatalogueData')->name('catalogue.data');
    Route::get('delete-catalogue/{id}', 'CatalogueController@DeleteCatalogue')->name('catalogue.delete');

    Route::get('export-crossref-excel',
            'CrossReferenceController@exportToExcelCrossRef')->name('crossref.export');

    Route::get('exportcsv-crossref-excel',
            'CrossReferenceController@exportToCsvCrossRef')->name('crossrefcsv.export');

    Route::get('delete-application/{id}', 'ProductController@DeleteApplication')->name('application.delete');

    Route::get('export-application-excel',
            'ProductController@exportToExcelApplication')->name('application.export');
    Route::get('export-spare-excel',
            'SpareController@exportToExcelSpare')->name('spare.export');

    Route::ANY('upload-spare-bulkimage',
            'SpareController@bulkSpareImageUpload')->name('sparebulkimage.upload');

    Route::ANY('upload-user', 'CustomerController@UploadUser')->name('user.upload');
    Route::ANY('upload-groupprice', 'GroupController@UploadGroupPrice')->name('groupprice.upload');

    Route::get('filter-request', 'OrderController@filterRequest')->name('request.filter');

// subadmin

    Route::get('view-sales-availability', 'SubAdminController@SubAdminAvailability')->name('sales.manage-sales');
    Route::POST('add-new-sales', 'SubAdminController@AddNewSubAdmin')->name('subadmin.subAdmin_register');
    Route::POST('edit-sales-ajax', 'SubAdminController@GetSubAdminData')->name('subAdmin.data');

    Route::post('edit-sales', 'SubAdminController@EditSubAdmin')->name('subAdmin.edit');
    Route::get('delete-sales/{id}', 'SubAdminController@DeleteSubAdmin')->name('sales.delete');
    // subadmin

    Route::POST('add-new-salescat', 'SalesCategoryController@AddNewSalesCategory')->name('salescat.register');
    Route::get('view-salescat', 'SalesCategoryController@SalesCategories')->name('salescat.manage');
    Route::post('edit-salescat-ajax', 'SalesCategoryController@GetSalesCategoryData')->name('salescat.data');
    Route::post('edit-salescat', 'SalesCategoryController@EditSalesCategory')->name('salescat.edit');
    Route::get('delete-salescat/{id}', 'SalesCategoryController@DeleteSalesCategory')->name('salescat.delete');

    Route::POST('add-new-salessheet', 'SalesSheetController@AddNewSalesSheet')->name('salessheet.register');
    Route::POST('add-new-salessheetcat', 'SalesSheetController@AddNewSalesSheetCat')->name('salessheetcat.register');
    Route::get('manage-salessheet-tagging', 'SalesSheetController@SalesTagging')->name('salessheet.tagging');

    Route::get('manage-salessheet', 'SalesSheetController@SalesSheets')->name('salessheet.manage');

    Route::post('edit-salessheet', 'SalesSheetController@EditSalesSheet')->name('salessheet.edit');
    Route::ANY('get-salessheet-data', 'SalesSheetController@GetSalesSheetData')->name('salessheet.data');
    Route::get('get-salessheet-reportdata', 'SalesSheetController@GetSalesReportData')->name('salessheetreport.manage');

    Route::post('get-salessheet-category', 'SalesSheetController@GetSalesSheetCatData');

    Route::post('getssapt-data-ajax', 'SalesSheetController@GetSalesSheetAppointmentData');

    Route::get('export-report-excel',
            'SalesSheetController@exportToExcelReort')->name('report.export');

    Route::get('export-log-excel',
            'SalesSheetController@exportSalesLog')->name('log.export');
    Route::get('export-calusers-excel',
            'SalesSheetController@exportCalenderUsers')->name('calusers.export');

    Route::get('view-tempuser', 'TempUserController@Tempusers')->name('tempuser.manage');
    Route::post('edit-tempuser-ajax', 'TempUserController@GetTempuserData')->name('tempuser.data');
    Route::post('edit-tempuser', 'TempUserController@EditTempuser')->name('tempuser.edit');
    Route::get('delete-tempuser/{id}', 'TempUserController@DeleteTempuser')->name('tempuser.delete');
    Route::get('data-tempuser/{id}', 'TempUserController@GetTempuserData1')->name('tempuser.getdata');

    Route::get('manage-saleslog', 'SalesSheetController@SalesSheetsLogs')->name('saleslog.manage');

    Route::get('export-saleslog-excel',
            'SalesSheetController@exportToExcelSalesLog')->name('saleslog.export');

    Route::ANY('resend-pwd-user',
            'CustomerController@resendPasswordCustomer');

    Route::get('manage-productdesc', 'ProductController@ProductDesc')->name('productdesc.manage');
    Route::POST('edit-productdesc-ajax', 'ProductController@GetProductDescData')->name('productdesc.data');
    Route::post('edit-productdesc', 'ProductController@EditProductDesc')->name('productdesc.edit');

    Route::get('export-mscode-excel', 'MasterDownloadController@exportToExcelMsCode')->name('mscode.export');
    Route::get('export-product-master', 'MasterDownloadController@exportToCSVProductMaster')->name('masterproduct.export');
    Route::get('export-productdetails-master', 'MasterDownloadController@exportToCSVProductDetailsMaster')->name('masterproductdetails.export');
    Route::get('export-productstock-master', 'MasterDownloadController@exportToCSVProductStockMaster')->name('masterproductstock.export');
    Route::get('export-productstatus-master', 'MasterDownloadController@exportToCSVProductStatusMaster')->name('masterproductstatus.export');
    Route::get('export-crossref-master', 'MasterDownloadController@exportToCSVCrossrefMaster')->name('mastercrossref.export');
    Route::get('export-application-master', 'MasterDownloadController@exportToCSVApplicationMaster')->name('masterapplication.export');
    Route::get('export-spare-master', 'MasterDownloadController@exportToCSVSpareMaster')->name('masterspare.export');
    Route::get('export-spareservice-master', 'MasterDownloadController@exportToCSVSpareServiceMaster')->name('masterspareservice.export');
    Route::get('export-spareoem-master', 'MasterDownloadController@exportToCSVSpareOEMMaster')->name('masterspareoem.export');
    Route::get('export-group-master', 'MasterDownloadController@exportToCSVGroupMaster')->name('mastergroupprice.export');
    Route::get('master-download', 'MasterDownloadController@MasterDownload')->name('master.download');

    /* Route::POST('add-new-privacypolicy', 'PrivacyPolicyController@AddNewPrivacyPolicy')->name('privacypolicy.register');
      Route::get('view-privacypolicy', 'PrivacyPolicyController@PrivacyPolicies')->name('privacypolicy.manage');
      Route::post('edit-privacypolicy-ajax', 'PrivacyPolicyController@GetPrivacyPolicyData')->name('privacypolicy.data');
      Route::post('edit-privacypolicy', 'PrivacyPolicyController@EditPrivacyPolicy')->name('privacypolicy.edit');
      Route::get('delete-privacypolicy/{id}', 'PrivacyPolicyController@DeletePrivacyPolicy')->name('privacypolicy.delete'); */


    Route::POST('add-new-terms', 'TermsController@AddNewTerms')->name('terms.register');
    Route::get('view-terms', 'TermsController@Terms')->name('terms.manage');
    Route::post('edit-terms-ajax', 'TermsController@GetTermsData')->name('terms.data');
    Route::post('edit-terms', 'TermsController@EditTerms')->name('terms.edit');
    Route::get('delete-terms/{id}', 'TermsController@DeleteTerms')->name('terms.delete');

    Route::POST('add-new-useraddress', 'UserAddressController@AddNewUserAddress')->name('useraddress.register');
    Route::get('view-useraddress', 'UserAddressController@UserAddress')->name('useraddress.manage');
    Route::post('edit-useraddress-ajax', 'UserAddressController@GetUserAddressData')->name('useraddress.data');
    Route::post('edit-useraddress', 'UserAddressController@EditUserAddress')->name('useraddress.edit');
    Route::get('delete-useraddress/{id}', 'UserAddressController@DeleteUserAddress')->name('useraddress.delete');

    Route::POST('add-new-popup', 'PopupController@AddNewPopups')->name('popup.register');
    Route::get('view-popup', 'PopupController@Popups')->name('popup.manage');
    Route::post('edit-popup-ajax', 'PopupController@GetPopupData')->name('popup.data');
    Route::post('edit-popup', 'PopupController@EditPopups')->name('popup.edit');
    Route::get('delete-popup/{id}', 'PopupController@DeletePopup')->name('popup.delete');

    Route::get('export-temp-cust', 'TempUserController@exportToCSVTempCust')->name('tempcust.export');

    Route::get('export-temp-salescalnotexist', 'SalesSheetController@exportSalesUserNotAvailable')->name('salescalnotavailable.export');

    Route::get('export-temp-salescalnotexistblock', 'SalesSheetController@exportSalesUserBlock')->name('salescalblock.export');

    Route::get('delete-productimage/{id}', 'ProductController@DeleteProductImage')->name('prodimage.delete');

    Route::post('delete-productimagesingle-ajax', 'ProductController@DeleteProductImageSingle')->name('prodimagesingle.delete');

    Route::get('delete-mscode/{id}', 'ProductController@DeleteMscode')->name('mscode.delete');

    Route::POST('delete-mscode-ajax',
            'ProductController@DeleteMscodeAjax');
    Route::POST('delete-product-ajax',
            'ProductController@DeleteProductAjax');

    Route::get('export-crossrefcust-excel',
            'CrossReferenceController@exportToExcelCrossRefCust')->name('crossrefcust.export');

    Route::ANY('upload-salessheetdata', 'SalesSheetController@UploadSalesSheet')->name('salessheet.upload');

    Route::get('view-deluser', 'DelUserController@DelUsers')->name('deluser.manage');
    Route::post('restore-deluser-ajax', 'DelUserController@RestoreDelUserData')->name('deluser.data');
    Route::post('edit-deluser', 'DelUserController@EditDelUser')->name('deluser.edit');
    Route::get('delete-deluser/{id}', 'DelUserController@DeleteDelUser')->name('deluser.delete');
    Route::get('data-deluser/{id}', 'DelUserController@GetDelUserData1')->name('deluser.getdata');
    Route::get('export-delcustomer-excel',
            'DelUserController@exportToExcelDelCustomer')->name('delcustomer.export');

    Route::get('view-deltempuser', 'DelTempUserController@DelTempUsers')->name('deltempuser.manage');
    Route::post('restore-deltempuser-ajax', 'DelTempUserController@RestoreDelTempUserData')->name('deltempuser.data');
    Route::post('edit-deltempuser', 'DelTempUserController@EditDelTempUser')->name('deltempuser.edit');
    Route::get('delete-deltempuser/{id}', 'DelTempUserController@DeleteDelTempUser')->name('deltempuser.delete');
    Route::get('data-deltempuser/{id}', 'DelTempUserController@GetDelTempUserData1')->name('deltempuser.getdata');
    Route::get('export-deltempuser-excel',
            'DelTempUserController@exportToExcelDelTempUser')->name('deltempuser.export');
});
