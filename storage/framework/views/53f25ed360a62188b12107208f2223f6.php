

<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-12 px-4">
    <div class="max-w-3xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <a href="<?php echo e(route('home')); ?>" class="inline-block mb-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(setting('logo_path')): ?>
                    <img src="<?php echo e(asset('storage/' . setting('logo_path'))); ?>" alt="<?php echo e(setting('site_name')); ?>" class="h-12 mx-auto">
                <?php else: ?>
                    <h1 class="text-2xl font-bold text-primary"><?php echo e(setting('site_name', 'InsuranceSell')); ?></h1>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
        </div>
        
        <!-- Page Content Card -->
        <div class="glass-card rounded-2xl p-8 mb-8">
            <h1 class="text-3xl font-bold text-white mb-6 text-center"><?php echo e($page->title); ?></h1>
            
            <div class="content-wrapper text-gray-300 prose prose-invert max-w-none">
                <?php echo $page->content; ?>

            </div>
        </div>
        
        <!-- Contact Form (only on contact page) -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page->slug === 'contact'): ?>
            <div class="glass-card rounded-2xl p-8">
                <h2 class="text-xl font-bold text-white mb-6">Send Us a Message</h2>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded-lg mb-6">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                    <div class="bg-red-600/20 border border-red-500 text-red-400 p-4 rounded-lg mb-6">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <form action="<?php echo e(route('contact.store')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Name *</label>
                        <input 
                            type="text" 
                            name="name" 
                            required 
                            class="w-full bg-darker/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-primary focus:outline-none"
                            value="<?php echo e(old('name')); ?>"
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Email *</label>
                        <input 
                            type="email" 
                            name="email" 
                            required 
                            class="w-full bg-darker/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-primary focus:outline-none"
                            value="<?php echo e(old('email')); ?>"
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Subject</label>
                        <input 
                            type="text" 
                            name="subject" 
                            class="w-full bg-darker/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-primary focus:outline-none"
                            value="<?php echo e(old('subject')); ?>"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Message *</label>
                        <textarea 
                            name="message" 
                            required 
                            rows="5"
                            class="w-full bg-darker/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-primary focus:outline-none resize-none"
                        ><?php echo e(old('message')); ?></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-400 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full py-3 bg-gradient-to-r from-primary to-pink-500 text-white font-bold rounded-lg hover:opacity-90 transition-opacity"
                    >
                        Send Message
                    </button>
                </form>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <!-- Footer Links -->
        <div class="mt-10 flex flex-wrap justify-center gap-4 text-sm text-gray-500">
            <a href="<?php echo e(route('page.show', 'about')); ?>" class="hover:text-primary">About</a>
            <a href="<?php echo e(route('page.show', 'contact')); ?>" class="hover:text-primary">Contact</a>
            <a href="<?php echo e(route('page.show', 'privacy-policy')); ?>" class="hover:text-primary">Privacy Policy</a>
            <a href="<?php echo e(route('page.show', 'terms')); ?>" class="hover:text-primary">Terms</a>
            <a href="<?php echo e(route('page.show', 'disclaimer')); ?>" class="hover:text-primary">Disclaimer</a>
            <a href="<?php echo e(route('page.show', 'dmca')); ?>" class="hover:text-primary">DMCA</a>
        </div>
        
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\insurancesell\resources\views/pages/show.blade.php ENDPATH**/ ?>