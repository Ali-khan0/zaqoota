

"use strict";

let editor = CKEDITOR.replace('ckeditor');

editor.on( 'change', function( evt ) {
    $('#mail-body').empty().html(evt.editor.getData());
});

$('input[data-id="mail-title"]').on('keyup', function() {
    let dataId = $(this).data('id');
    let value = $(this).val();
    $('#'+dataId).text(value);
});
$('input[data-id="mail-button"]').on('keyup', function() {
    let dataId = $(this).data('id');
    let value = $(this).val();
    $('#'+dataId).text(value);
});
$('input[data-id="mail-footer"]').on('keyup', function() {
    let dataId = $(this).data('id');
    let value = $(this).val();
    $('#'+dataId).text(value);
});
$('input[data-id="mail-copyright"]').on('keyup', function() {
    let dataId = $(this).data('id');
    let value = $(this).val();
    $('#'+dataId).text(value);
});

$('.js-email-button-toggle').on('change', function() {
    $('#action-button-preview').toggle(this.checked);
    $('.js-email-button-fields').toggle(this.checked);
});

let templateTestPanel = $('.js-email-template-test-panel');
let templatePreviewCard = templateTestPanel.closest('.left-content').children('.card').last();
if (templateTestPanel.length && templatePreviewCard.length) {
    templateTestPanel.detach().insertAfter(templatePreviewCard);
}

$('.js-template-test-email').on('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        $(this).closest('.js-email-template-test-panel').find('.js-send-template-test').trigger('click');
    }
});

$('.js-send-template-test').on('click', function() {
    let button = $(this);
    let panel = button.closest('.js-email-template-test-panel');
    let emailInput = panel.find('.js-template-test-email').get(0);
    let feedback = panel.find('.js-template-test-feedback');

    if (!emailInput.checkValidity()) {
        emailInput.reportValidity();
        return;
    }

    button.prop('disabled', true);
    feedback.addClass('d-none').removeClass('text-success text-danger').text('');

    $.ajax({
        url: panel.data('url'),
        type: 'POST',
        data: {
            _token: $('input[name="_token"]').first().val(),
            email: emailInput.value
        },
        success: function(response) {
            feedback.removeClass('d-none text-danger').addClass('text-success').text(response.message);
        },
        error: function(xhr) {
            let response = xhr.responseJSON || {};
            let emailErrors = response.errors && response.errors.email ? response.errors.email : [];
            let message = emailErrors[0] || response.message || 'Unable to send test email.';
            feedback.removeClass('d-none text-success').addClass('text-danger').text(message);
        },
        complete: function() {
            button.prop('disabled', false);
        }
    });
});

// The unified email shell uses the business logo and its own content hierarchy.
$('#mail-icon').closest('div').hide();
$('h5.card-title').filter(function() {
    return $(this).text().trim().replace(/_/g, ' ').toLowerCase() === 'header content';
}).hide();

function readURL(input, viewer) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#' + viewer).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#mail-logo").change(function() {
    readURL(this, 'logoViewer');
});

$("#mail-banner").change(function() {
    readURL(this, 'bannerViewer');
});

$("#mail-icon").change(function() {
    readURL(this, 'iconViewer');
});

$(".lang_link").click(function(event){
    event.preventDefault();
    $(".lang_link").removeClass('active');
    $(".lang_form").addClass('d-none');
    $(this).addClass('active');

    let form_id = this.id;
    let lang = form_id.substring(0, form_id.length - 5);

    $("#"+lang+"-form").removeClass('d-none');
    $("#"+lang+"-form1").removeClass('d-none');
    $("#"+lang+"-form2").removeClass('d-none');
    $("#"+lang+"-form3").removeClass('d-none');
    if(lang === 'default')
    {
        $(".default-form").removeClass('d-none');
    }
    else
    {
        $(".from_part_2").addClass('d-none');
    }
});

$('.check-mail-element').on('change', function() {
    let id = $(this).data('id');
        console.log(id);
        if ($('.' + id).is(':checked')) {
            $('#' + id).show();
        } else {
            $('#' + id).hide();
        }
});
document.getElementById('see-how-it-works').addEventListener('click', function() {
    $('#email-modal').show();
});

if(document.getElementById('rental-mail-route-selector')){
    document.getElementById('rental-mail-route-selector').addEventListener('change', function() {
        let value = this.value;
        location.href = baseUrl + '/admin/business-settings/rental-email-setup/' + value + '/' + (value === 'admin' ? 'provider-registration' : value === 'provider'?'registration':'new-order');
    });
}
if( document.getElementById('mail-route-selector')){
    document.getElementById('mail-route-selector').addEventListener('change', function() {
        let value = this.value;
        location.href = baseUrl + '/admin/business-settings/email-setup/' + value + '/' + (value === 'admin' ? 'forgot-password' : 'registration');
    });
}
