<div class="form-group">
    <label class="form-label">
        <?php echo e(translate('Page Links')); ?>

    </label>
    <ul class="page-links-checkgrp">
        <li>
            <label class="form-check form--check">
                <input class="form-check-input privacy-check check-mail-element"  data-id="privacy-check" type="checkbox" name="privacy" value ="1" <?php echo e((isset($data['privacy']) && $data['privacy'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('Privacy Policy')); ?></span>
            </label>
        </li>
        <li>
            <label class="form-check form--check">
                <input class="form-check-input refund-check check-mail-element" data-id="refund-check"  type="checkbox" name="refund" value ="1" <?php echo e((isset($data['refund']) && $data['refund'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('Refund Policy')); ?></span>
            </label>
        </li>
        <li>
            <label class="form-check form--check">
                <input class="form-check-input cancelation-check check-mail-element" data-id="cancelation-check"  type="checkbox" name="cancelation" value ="1" <?php echo e((isset($data['cancelation']) && $data['cancelation'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('Cancelation Policy')); ?></span>
            </label>
        </li>
        <li>
            <label class="form-check form--check">
                <input class="form-check-input contact-check check-mail-element" data-id="contact-check" type="checkbox" name="contact" value ="1" <?php echo e((isset($data['contact']) && $data['contact'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('Contact Us')); ?></span>
            </label>
        </li>
    </ul>
</div>
<div class="form-group">
    <label class="form-label">
        <?php echo e(translate('Social Media Links')); ?>

    </label>
    <ul class="page-links-checkgrp">
        <li>
            <label class="form-check form--check">
                <input class="form-check-input facebook-check check-mail-element" type="checkbox" data-id="facebook-check" name="facebook" value="1" <?php echo e((isset($data['facebook']) && $data['facebook'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('Facebook')); ?></span>
            </label>
        </li>
        <li>
            <label class="form-check form--check">
                <input class="form-check-input instagram-check check-mail-element" type="checkbox" data-id="instagram-check"  name="instagram" value="1" <?php echo e((isset($data['instagram']) && $data['instagram'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('Instagram')); ?></span>
            </label>
        </li>
        <li>
            <label class="form-check form--check">
                <input class="form-check-input twitter-check check-mail-element" type="checkbox" data-id="twitter-check" name="twitter" value="1" <?php echo e((isset($data['twitter']) && $data['twitter'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('Twitter')); ?></span>
            </label>
        </li>
        <li>
            <label class="form-check form--check">
                <input class="form-check-input linkedin-check check-mail-element" type="checkbox" data-id="linkedin-check"  name="linkedin" value="1" <?php echo e((isset($data['linkedin']) && $data['linkedin'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('LinkedIn')); ?></span>
            </label>
        </li>
        <li>
            <label class="form-check form--check">
                <input class="form-check-input pinterest-check check-mail-element" type="checkbox" data-id="pinterest-check"  name="pinterest" value="1" <?php echo e((isset($data['pinterest']) && $data['pinterest'] == 1)?'checked':''); ?>>
                <span class="form-check-label"><?php echo e(translate('Pinterest')); ?></span>
            </label>
        </li>
    </ul>
</div>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/email-format-setting/partials/social-media-and-footer-section.blade.php ENDPATH**/ ?>