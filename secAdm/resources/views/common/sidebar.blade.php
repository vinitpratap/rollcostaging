<?php /*?>@guest('admin')


@else<?php */?>

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section"> 
        <!--<h3>General</h3>-->
        <ul class="nav side-menu">
            <li class="nav-item"><a href="{{url('/admin')}}" class="nav-link"><span>Dashboard</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{url('/admin')}}" class="nav-link">Dashboard</a> </li>
                    <!-- <li class="nav-item"><a href="index.html" class="nav-link">Dashboard2</a> </li>-->

                </ul>
            </li>

            @if(Auth::guard('admin')->user()->admin_role==2)
            <li class="nav-item"><a class="nav-link"><span>Manage Sales Sheet</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{route('salessheet.tagging')}}" class="nav-link">Manage Sales Category Tagging</a> </li>
                    <li class="nav-item"><a href="{{route('salessheet.manage')}}" class="nav-link">Manage Front Sales Sheets</a> </li>
                    <li class="nav-item"><a href="{{route('salessheetreport.manage')}}" class="nav-link">Manage Sales Reports</a> </li>
                    

                </ul>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->admin_role==1)
            <li class="nav-item"><a class="nav-link"><span>Manage Customers</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{route('customer.manage',['type'=>'approve','all'])}}" class="nav-link">Approved</a> </li>
                    <li class="nav-item"><a href="{{route('customer.manage',['type'=>'pending','all'])}}" class="nav-link">Pending</a> </li>
                    <li class="nav-item"><a href="{{route('customer.manage',['type'=>'blocked','all'])}}" class="nav-link">Blocked</a> </li>
                    <li class="nav-item"><a href="{{route('customer.manage',['type'=>'unverified','all'])}}" class="nav-link">Unverified</a> </li>
                    
                    <li class="nav-item"><a href="{{route('tempuser.manage')}}" class="nav-link">Temp Customers</a> </li>
                    <li class="nav-item"><a href="{{route('deltempuser.manage')}}" class="nav-link">Deleted Temp Customers</a> </li>
                    <li class="nav-item"><a href="{{route('deluser.manage')}}" class="nav-link">Deleted Customers</a> </li>
                    <li class="nav-item"><a href="{{route('usercategory.manage')}}" class="nav-link">Customer's Category</a> </li>

                </ul>
            </li>
            <li class="nav-item"><a class="nav-link"><span>Manage Sales</span></a>
                <ul class="nav child_menu">  
                    <li class="nav-item"><a href="{{route('sales.manage-sales')}}" class="nav-link">Manage Sales Person</a> </li>
                    <li class="nav-item"><a href="{{route('salescat.manage')}}" class="nav-link">Manage Sales Category</a> </li>
                    <li class="nav-item"><a href="{{route('salessheet.tagging')}}" class="nav-link">Manage Sales Category Tagging</a> </li>
                    <li class="nav-item"><a href="{{route('salessheet.manage')}}" class="nav-link">Manage Front Sales Sheets</a> </li>
                    <li class="nav-item"><a href="{{route('salessheetreport.manage')}}" class="nav-link">Manage Sales Reports</a> </li>
                    <li class="nav-item"><a href="{{route('saleslog.manage')}}" class="nav-link">Manage Sales Logs</a> </li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link"><span>Customer's Group</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{route('group.manage')}}" class="nav-link">Manage Customer's Groups</a> </li>
					 <li class="nav-item"><a href="{{route('groupprice.upload')}}" class="nav-link">Upload Group Price</a> </li>

                </ul>
            </li>
            <li class="nav-item"><a class="nav-link"><span>Manage Orders</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{route('order.manage')}}" class="nav-link">View Orders</a> </li>

                </ul>
            </li>
            <li class="nav-item"><a class="nav-link"><span>Manage Enquiry</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{route('contact.manage')}}" class="nav-link">View Contact us</a> </li>
                    <li class="nav-item"><a href="{{route('enquiry.manage')}}" class="nav-link">View Enquiry</a> </li>
                    <li class="nav-item"><a href="{{route('search_nf.manage')}}" class="nav-link">View Search Not Found</a> </li>
                    <li class="nav-item"><a href="{{route('newsltr.manage')}}" class="nav-link">View Newsletter</a> </li>
                    <li class="nav-item"><a href="{{route('recent_search.manage')}}" class="nav-link">View Recent viewed products</a> </li>
                </ul>
            </li>

            <li class="nav-item"><a class="nav-link"><span>Manage Services</span></a>
                <ul class="nav child_menu">
                    <!--                    <li class="nav-item"><a href="{{route('mcategory.manage')}}" class="nav-link">Manage Master Category</a> </li>
                                        <li class="nav-item"><a href="{{route('category.manage')}}" class="nav-link">Manage Category</a> </li>
                                        <li class="nav-item"><a href="{{route('make.manage')}}" class="nav-link">Manage  Make</a> </li>
                                        <li class="nav-item"><a href="{{route('model.manage')}}" class="nav-link">Manage  Model</a> </li>
                                        <li class="nav-item"><a href="{{route('proyr.manage')}}" class="nav-link">Manage Product  Year</a> </li>
                                        <li class="nav-item"><a href="{{route('proccm.manage')}}" class="nav-link">Manage Product Exact CCM</a> </li>
                                        <li class="nav-item"><a href="{{route('engcode.manage')}}" class="nav-link">Manage Engine Code</a> </li>-->
                    <li class="nav-item"><a href="{{route('product.manage')}}" class="nav-link">Manage Products</a> </li>
					<li class="nav-item"><a href="{{route('productdesc.manage')}}" class="nav-link">Manage Products Description</a> </li>

                    <li class="nav-item"><a href="{{route('spare.manage')}}" class="nav-link">Manage Spares </a> </li>



                    <li class="nav-item"><a href="{{route('products.manage')}}" class="nav-link">Upload Products</a> </li>
                    <li class="nav-item"><a href="{{route('productbulkimage.upload')}}" class="nav-link">Upload Products Bulk Image</a> </li>
                    <li class="nav-item"><a href="{{route('crossref.manage')}}" class="nav-link">Manage/Upload Products Cross Reference </a> </li>
                    <li class="nav-item"><a href="{{route('application.manage')}}" class="nav-link">Upload Applications</a> </li>

                    <li class="nav-item"><a href="{{route('spare.upload')}}" class="nav-link">Upload Spares </a> </li>
                    <li class="nav-item"><a href="{{route('sparebulkimage.upload')}}" class="nav-link">Upload Spares Bulk Image</a> </li>

                    <li class="nav-item"><a href="{{route('spearService.manage')}}" class="nav-link">Upload Spares Service Number </a> </li>

                    <li class="nav-item"><a href="{{route('spearOEM.manage')}}" class="nav-link">Upload Spares OEM Number</a> </li>

                    <li class="nav-item"><a href="{{route('MsCode.manage')}}" class="nav-link">Upload MsCodes</a> </li>
					
					 <li class="nav-item"><a href="{{route('master.download')}}" class="nav-link">Master Download</a> </li>
                   



                </ul>
            </li>

<!--            <li class="nav-item"> <a class="nav-link"> <span>Service Requests & <br />
            Assignment</span> </a>
    <ul class="nav child_menu">
        <li class="nav-item"><a href="#" class="nav-link" onclick="redirectToService()">Add Service Request</a> </li>
        <li class="nav-item"><a href="{{route('request.manage',['type'=>'new','all'])}}" class="nav-link">Open Requests </a> </li>
        <li class="nav-item"><a href="{{route('request.manage',['type'=>'assigned','all'])}}" class="nav-link">Technician Assigned</a> </li>
        <li class="nav-item"><a href="{{route('requestnotaccept.manage',['type'=>'notaccept','all'])}}" class="nav-link">Technician Not Accepted</a> </li>
        <li class="nav-item"><a href="{{route('request.manage',['type'=>'work','all'])}}" class="nav-link"> Work in Progress</a> </li>
        <li class="nav-item"><a href="{{route('request.manage',['type'=>'close','all'])}}" class="nav-link">Closed Requests</a> </li>
        <li class="nav-item"><a href="{{route('request.manage',['type'=>'cancel','all'])}}" class="nav-link">Cancelled Requests</a> </li>
        

    </ul>
</li>-->


            <li class="nav-item"><a class="nav-link"><span>Manage Currency</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{route('currency.manage')}}" class="nav-link">Manage Currency</a> </li>
                </ul>
            </li>

            <li class="nav-item"><a class="nav-link"><span>Manage CMS</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{route('news.manage')}}" class="nav-link">Manage News</a> </li>
                    <li class="nav-item"><a href="{{route('exb.manage')}}" class="nav-link">Manage Exhibition</a> </li>
                    <li class="nav-item"><a href="{{route('announcement.manage')}}" class="nav-link">Manage Announcements</a> </li>
                    <li class="nav-item"><a href="{{route('catalogue.manage')}}" class="nav-link">Manage Flyres</a> </li>
					<li class="nav-item"><a href="{{route('category.manage')}}" class="nav-link">Manage Catalogue PDF</a> </li>
					
					<li class="nav-item"><a href="{{route('terms.manage')}}" class="nav-link">Manage Terms & Conditions</a> </li>
					<li class="nav-item"><a href="{{route('popup.manage')}}" class="nav-link">Manage Popup</a> </li>

                </ul>
            </li>
                     @endif
        </ul>
    </div>
</div>
<?php /*?>@endguest<?php */?>
