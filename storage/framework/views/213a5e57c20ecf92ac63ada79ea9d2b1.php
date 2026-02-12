
<?php
    $slotKey = $slot ?? 'ad_slot_1';
    $adCode = setting($slotKey . '_code', '');
    $adEnabled = setting($slotKey . '_enabled', 'true') !== 'false';
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adEnabled && $adCode): ?>
<div class="my-4">
    <div class="ad-slot rounded-xl overflow-hidden">
        <?php echo $adCode; ?>

    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\insurancesell\resources\views/components/ad-slot.blade.php ENDPATH**/ ?>