<?php if(auth()->guard('admin')->guest()): ?>


<?php else: ?>

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section"> 
        <!--<h3>General</h3>-->
        <ul class="nav side-menu">
            <li class="nav-item"><a href="<?php echo e(url('/admin')); ?>" class="nav-link"><span>Dashboard</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="<?php echo e(url('/admin')); ?>" class="nav-link">Dashboard</a> </li>
                    <!-- <li class="nav-item"><a href="index.html" class="nav-link">Dashboard2</a> </li>-->

                </ul>
            </li>

            <?php if(Auth::guard('admin')->user()->admin_role==1): ?>
            <li class="nav-item"><a class="nav-link"><span>Manage Customers</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="<?php echo e(route('customer.manage',['type'=>'approve','all'])); ?>" class="nav-link">Approved</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('customer.manage',['type'=>'pending','all'])); ?>" class="nav-link">Pending</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('customer.manage',['type'=>'blocked','all'])); ?>" class="nav-link">Blocked</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('usercategory.manage')); ?>" class="nav-link">Customer's Category</a> </li>

                </ul>
            </li>
            <li class="nav-item"><a class="nav-link"><span>Customer's Group</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="<?php echo e(route('group.manage')); ?>" class="nav-link">Manage Customer's Groups</a> </li>

                </ul>
            </li>
            <li class="nav-item"><a class="nav-link"><span>Manage Orders</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="<?php echo e(route('order.manage')); ?>" class="nav-link">View Orders</a> </li>

                </ul>
            </li>
            <li class="nav-item"><a class="nav-link"><span>Manage Enquiry</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="<?php echo e(route('contact.manage')); ?>" class="nav-link">View Contact us</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('enquiry.manage')); ?>" class="nav-link">View Enquiry</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('search_nf.manage')); ?>" class="nav-link">View Search Not Found</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('newsltr.manage')); ?>" class="nav-link">View Newsletter</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('recent_search.manage')); ?>" class="nav-link">View Recent viewed products</a> </li>
                </ul>
            </li>

            <li class="nav-item"><a class="nav-link"><span>Manage Services</span></a>
                <ul class="nav child_menu">
<!--                    <li class="nav-item"><a href="<?php echo e(route('mcategory.manage')); ?>" class="nav-link">Manage Master Category</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('category.manage')); ?>" class="nav-link">Manage Category</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('make.manage')); ?>" class="nav-link">Manage  Make</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('model.manage')); ?>" class="nav-link">Manage  Model</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('proyr.manage')); ?>" class="nav-link">Manage Product  Year</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('proccm.manage')); ?>" class="nav-link">Manage Product Exact CCM</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('engcode.manage')); ?>" class="nav-link">Manage Engine Code</a> </li>-->
                   <li class="nav-item"><a href="<?php echo e(route('product.manage')); ?>" class="nav-link">Manage Product</a> </li>
                   <li class="nav-item"><a href="<?php echo e(route('productbulkimage.upload')); ?>" class="nav-link">Upload Product Bulk Image</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('spare.manage')); ?>" class="nav-link">Manage Spare </a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('spare.upload')); ?>" class="nav-link">Upload Spare </a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('crossref.manage')); ?>" class="nav-link">Manage Product Cross Reference </a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('spearService.manage')); ?>" class="nav-link">Upload Spare Service Number </a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('products.manage')); ?>" class="nav-link">Upload Product</a> </li>
                    
                    <li class="nav-item"><a href="<?php echo e(route('spearOEM.manage')); ?>" class="nav-link">Upload Spare OEM Number</a> </li>
                    
                    <li class="nav-item"><a href="<?php echo e(route('application.manage')); ?>" class="nav-link">Upload Application</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('MsCode.manage')); ?>" class="nav-link">Upload MsCode</a> </li>
                    

                </ul>
            </li>
            
<!--            <li class="nav-item"> <a class="nav-link"> <span>Service Requests & <br />
                        Assignment</span> </a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="#" class="nav-link" onclick="redirectToService()">Add Service Request</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('request.manage',['type'=>'new','all'])); ?>" class="nav-link">Open Requests </a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('request.manage',['type'=>'assigned','all'])); ?>" class="nav-link">Technician Assigned</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('requestnotaccept.manage',['type'=>'notaccept','all'])); ?>" class="nav-link">Technician Not Accepted</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('request.manage',['type'=>'work','all'])); ?>" class="nav-link"> Work in Progress</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('request.manage',['type'=>'close','all'])); ?>" class="nav-link">Closed Requests</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('request.manage',['type'=>'cancel','all'])); ?>" class="nav-link">Cancelled Requests</a> </li>
                    

                </ul>
            </li>-->
            
            
            <li class="nav-item"><a class="nav-link"><span>Manage Currency</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="<?php echo e(route('currency.manage')); ?>" class="nav-link">Manage Currency</a> </li>
                </ul>
            </li>
            
             <li class="nav-item"><a class="nav-link"><span>Manage CMS</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="<?php echo e(route('news.manage')); ?>" class="nav-link">Manage News</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('exb.manage')); ?>" class="nav-link">Manage Exhibition</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('announcement.manage')); ?>" class="nav-link">Manage Announcements</a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('catalogue.manage')); ?>" class="nav-link">Manage Flyres</a> </li>
                   
                </ul>
            </li>
             <?php /*?><li class="nav-item"><a class="nav-link"><span>Manage Reports</span></a>
                <ul class="nav child_menu">
                    <li class="nav-item"><a href="{{route('visitor.manage')}}" class="nav-link">Manage Visitor </a> </li>
                    <li class="nav-item"><a href="{{route('searchnotfound.manage')}}" class="nav-link">Manage Search Not Found </a> </li>
                </ul>
            </li><?php */?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php endif; ?>
