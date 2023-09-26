<?php $__env->startSection('title', 'login here'); ?>


<?php $__env->startSection('content'); ?>
<div class="container login">
<div class="row"><div class="col-lg-12 text-center"></div></div>
    <div class="row mt-5">
        <div class="col-md-8 ">
            <div class="panel panel-default" align="center">
            <img src="<?php echo e(URL::asset('images/logo-lg.svg')); ?>" /><br /><br /><br />
<br />

                <div class="panel-heading">Forget Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" id="loginForm" method="POST" action="<?php echo e(route('password.email')); ?>">
                        <?php echo e(csrf_field()); ?>

<?php if(count($errors) > 0): ?>
               <div class="alert alert-danger">
                   <strong>Whoops!</strong> There were some problems with your input.	
                   <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <p><?php echo e($error); ?></p>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
               </div>
               <?php endif; ?>
               <?php if(session()->has('message')): ?>
               <div class="alert alert-success">
                   <?php echo e(session()->get('message')); ?>

               </div>
               <?php endif; ?>
                       <input type="hidden" name="submit" value="1">
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-6 control-label">E-Mail Address</label>

                            <div class="col-md-12">
                                <input id="email" autocomplete="off" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required autofocus>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" class="btn btn-default submit">Send Password Reset Link</button>
                                <a class="btn btn-link" href="<?php echo e(route('admin.auth.login')); ?>">Login</a>
<hr>
<br />
© Copyright <?php echo date('Y');?>. enviro. All rights reserved.


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <script>
 $(document).ready(function(){
	 $('#loginForm').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
        }
    });
 })
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>