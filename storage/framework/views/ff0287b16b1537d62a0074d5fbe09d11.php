

<?php $__env->startSection('content'); ?>
    <div class="brand">Laravel SSO</div>
    <div class="hero-copy">
        <span class="eyebrow">Akses aman</span>
        <h1>Masuk ke dashboard</h1>
        <p>Gunakan akun lokal untuk mengakses aplikasi. Reset password juga tersedia jika Anda lupa kredensial.</p>
    </div>

    <?php if(session('status')): ?>
        <div class="status success">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert">
            <strong>Periksa input Anda.</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <div class="row">
            <label for="remember">
                <input id="remember" name="remember" type="checkbox">
                Ingat saya
            </label>
            <a href="<?php echo e(route('password.request')); ?>">Lupa password?</a>
        </div>

        <button class="button" type="submit">Masuk</button>
    </form>

    <div class="footer">
        Belum punya akun? <a href="<?php echo e(route('register')); ?>">Daftar</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>