<?php $__env->startSection('title',translate('messages.language')); ?>



<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title mr-3 mb-0">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/business.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.business_setup')); ?>

            </span>
        </h1>
        <?php echo $__env->make('admin-views.business-settings.partials.nav-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <!-- End Page Header -->

                <div class="card mb-3">
                    <div class="px-3 py-4">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 d-flex">
                                    <?php echo e(translate('language_list')); ?>

                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <div class="d-flex gap-10 justify-content-sm-end">
                                    <button class="btn btn--primary btn-icon-split" data-toggle="modal" data-target="#lang-modal">
                                        <i class="tio-add"></i>
                                        <span class="text"><?php echo e(translate('add_new_language')); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive datatable-custom" id="table-div">
                        <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                                "columnDefs": [{
                                    "targets": [],
                                    "width": "5%",
                                    "orderable": false
                                }],
                                "order": [],
                                "info": {
                                "totalQty": "#datatableWithPaginationInfoTotalQty"
                                },

                                "entries": "#datatableEntries",

                                "isResponsive": false,
                                "isShowPaging": false,
                                "paging":false
                            }'>
                            <thead class="thead-light">
                            <tr>
                                <th><?php echo e(translate('SL')); ?></th>
                                <th><?php echo e(translate('Code')); ?></th>
                                <th class="text-center"><?php echo e(translate('status')); ?></th>
                                <th class="text-center"><?php echo e(translate('default_status')); ?></th>
                                <th class="text-center"><?php echo e(translate('action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php ($language=App\Models\BusinessSetting::where('key','system_language')->first()); ?>
                            <?php if($language): ?>
                            <?php $__currentLoopData = json_decode($language['value'],true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td><?php echo e($data['code']); ?></td>
                                    <td>

                                        <?php if($data['default']): ?>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($data['id']); ?>">
                                            <input type="checkbox"  class="toggle-switch-input update-lang-status" id="stocksCheckbox<?php echo e($data['id']); ?>" <?php echo e($data['status']==1?'checked':''); ?> disabled>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <?php else: ?>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($data['id']); ?>">
                                            <input type="checkbox"
                                                   data-url="<?php echo e(route('admin.business-settings.language.update-status')); ?>"
                                                   data-id="<?php echo e($data['code']); ?>"
                                                    class="toggle-switch-input status-update" id="stocksCheckbox<?php echo e($data['id']); ?>" <?php echo e($data['status']==1?'checked':''); ?>>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="defaultCheck<?php echo e($data['id']); ?>">
                                            <input type="checkbox" class="toggle-switch-input update-default"
                                                   data-id="defaultCheck<?php echo e($data['id']); ?>"
                                                   data-url="<?php echo e(route('admin.business-settings.language.update-default-status', ['code'=>$data['code']])); ?>"
                                                   id="defaultCheck<?php echo e($data['id']); ?>" <?php echo e(((array_key_exists('default', $data) && $data['default']) ? 'checked': ((array_key_exists('default', $data) && !$data['default']) ? '' : 'disabled'))); ?>>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn--container justify-content-center">
                                            <?php if($data['code']!='en'): ?>
                                                <a class="btn btn-sm btn--primary btn-outline-primary action-btn call-demo-lang" data-toggle="modal"
                                            data-key="<?php echo e($key); ?>"
                                            data-env-mode="<?php echo e(env('APP_MODE')); ?>"
                                                    data-target="<?php echo e(( ($key == 0 ||  $key == 1 ) && env('APP_MODE') == 'demo') ? '' :'#lang-modal-update-'.$data['code']); ?>">
                                                    <i class="tio-edit"></i></a>
                                                <?php if($data['default']): ?>
                                                <?php else: ?>
                                                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn call-demo-lang <?php echo e(( ($key == 0 ||  $key == 1 ) && env('APP_MODE') == 'demo') ? '' : 'delete'); ?>"
                                                    data-key="<?php echo e($key); ?>"
                                                    data-env-mode="<?php echo e(env('APP_MODE')); ?>"
                                                    id="<?php echo e(( ($key == 0 ||  $key == 1 ) && env('APP_MODE') == 'demo')  ? 'javascript:' :route('admin.business-settings.language.delete',[$data['code']])); ?>"><i class="tio-delete-outlined"></i></a>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <a class="btn btn-sm btn--warning btn-outline-warning action-btn <?php echo e(( ($key == 0 ||  $key == 1 ) && env('APP_MODE') == 'demo') ? 'call-demo-lang' : ''); ?>"
                                                data-key="<?php echo e($key); ?>"
                                                data-env-mode="<?php echo e(env('APP_MODE')); ?>"
                                                href="<?php echo e(( ($key == 0 ||  $key == 1 ) && env('APP_MODE') == 'demo') ? 'javascript:' :route('admin.business-settings.language.translate',[$data['code']])); ?>">
                                                <i class="tio-globe"></i>

                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>


        <div class="modal fade" id="lang-modal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('new_language')); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo e(route('admin.business-settings.language.add-new')); ?>" method="post"
                          style="text-align: <?php echo e(Session::get('direction') === "rtl" ? 'right' : 'left'); ?>;">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="country-code"
                                               class="col-form-label"><?php echo e(translate('language')); ?></label>
                                               <select id="country-code" name="code" class="form-control js-select2-custom">
                                                <option value="af">Afrikaans</option>
                                                <option value="sq">Albanian - shqip</option>
                                                <option value="am">Amharic - አማርኛ</option>
                                                <option value="ar">Arabic - العربية</option>
                                                <option value="an">Aragonese - aragonés</option>
                                                <option value="hy">Armenian - հայերեն</option>
                                                <option value="ast">Asturian - asturianu</option>
                                                <option value="az">Azerbaijani - azərbaycan dili</option>
                                                <option value="eu">Basque - euskara</option>
                                                <option value="be">Belarusian - беларуская</option>
                                                <option value="bn">Bengali - বাংলা</option>
                                                <option value="bs">Bosnian - bosanski</option>
                                                <option value="br">Breton - brezhoneg</option>
                                                <option value="bg">Bulgarian - български</option>
                                                <option value="ca">Catalan - català</option>
                                                <option value="ckb">Central Kurdish - کوردی (دەستنوسی عەرەبی)</option>
                                                <option value="zh">Chinese - 中文</option>
                                                <option value="zh-HK">Chinese (Hong Kong) - 中文（香港）</option>
                                                <option value="zh-CN">Chinese (Simplified) - 中文（简体）</option>
                                                <option value="zh-TW">Chinese (Traditional) - 中文（繁體）</option>
                                                <option value="co">Corsican</option>
                                                <option value="hr">Croatian - hrvatski</option>
                                                <option value="cs">Czech - čeština</option>
                                                <option value="da">Danish - dansk</option>
                                                <option value="nl">Dutch - Nederlands</option>
                                                <option value="en-AU">English (Australia)</option>
                                                <option value="en-CA">English (Canada)</option>
                                                <option value="en-IN">English (India)</option>
                                                <option value="en-NZ">English (New Zealand)</option>
                                                <option value="en-ZA">English (South Africa)</option>
                                                <option value="en-GB">English (United Kingdom)</option>
                                                <option value="en-US">English (United States)</option>
                                                <option value="eo">Esperanto - esperanto</option>
                                                <option value="et">Estonian - eesti</option>
                                                <option value="fo">Faroese - føroyskt</option>
                                                <option value="fil">Filipino</option>
                                                <option value="fi">Finnish - suomi</option>
                                                <option value="fr">French - français</option>
                                                <option value="fr-CA">French (Canada) - français (Canada)</option>
                                                <option value="fr-FR">French (France) - français (France)</option>
                                                <option value="fr-CH">French (Switzerland) - français (Suisse)</option>
                                                <option value="gl">Galician - galego</option>
                                                <option value="ka">Georgian - ქართული</option>
                                                <option value="de">German - Deutsch</option>
                                                <option value="de-AT">German (Austria) - Deutsch (Österreich)</option>
                                                <option value="de-DE">German (Germany) - Deutsch (Deutschland)</option>
                                                <option value="de-LI">German (Liechtenstein) - Deutsch (Liechtenstein)
                                                </option>
                                                <option value="de-CH">German (Switzerland) - Deutsch (Schweiz)</option>
                                                <option value="el">Greek - Ελληνικά</option>
                                                <option value="gn">Guarani</option>
                                                <option value="gu">Gujarati - ગુજરાતી</option>
                                                <option value="ha">Hausa</option>
                                                <option value="haw">Hawaiian - ʻŌlelo Hawaiʻi</option>
                                                <option value="he">Hebrew - עברית</option>
                                                <option value="hi">Hindi - हिन्दी</option>
                                                <option value="hu">Hungarian - magyar</option>
                                                <option value="is">Icelandic - íslenska</option>
                                                <option value="id">Indonesian - Indonesia</option>
                                                <option value="ia">Interlingua</option>
                                                <option value="ga">Irish - Gaeilge</option>
                                                <option value="it">Italian - italiano</option>
                                                <option value="it-IT">Italian (Italy) - italiano (Italia)</option>
                                                <option value="it-CH">Italian (Switzerland) - italiano (Svizzera)</option>
                                                <option value="ja">Japanese - 日本語</option>
                                                <option value="kn">Kannada - ಕನ್ನಡ</option>
                                                <option value="kk">Kazakh - қазақ тілі</option>
                                                <option value="km">Khmer - ខ្មែរ</option>
                                                <option value="ko">Korean - 한국어</option>
                                                <option value="ku">Kurdish - Kurdî</option>
                                                <option value="ky">Kyrgyz - кыргызча</option>
                                                <option value="lo">Lao - ລາວ</option>
                                                <option value="la">Latin</option>
                                                <option value="lv">Latvian - latviešu</option>
                                                <option value="ln">Lingala - lingála</option>
                                                <option value="lt">Lithuanian - lietuvių</option>
                                                <option value="mk">Macedonian - македонски</option>
                                                <option value="ms">Malay - Bahasa Melayu</option>
                                                <option value="ml">Malayalam - മലയാളം</option>
                                                <option value="mt">Maltese - Malti</option>
                                                <option value="mr">Marathi - मराठी</option>
                                                <option value="mn">Mongolian - монгол</option>
                                                <option value="ne">Nepali - नेपाली</option>
                                                <option value="no">Norwegian - norsk</option>
                                                <option value="nb">Norwegian Bokmål - norsk bokmål</option>
                                                <option value="nn">Norwegian Nynorsk - nynorsk</option>
                                                <option value="oc">Occitan</option>
                                                <option value="or">Oriya - ଓଡ଼ିଆ</option>
                                                <option value="om">Oromo - Oromoo</option>
                                                <option value="ps">Pashto - پښتو</option>
                                                <option value="fa">Persian - فارسی</option>
                                                <option value="pl">Polish - polski</option>
                                                <option value="pt">Portuguese - português</option>
                                                <option value="pt-BR">Portuguese (Brazil) - português (Brasil)</option>
                                                <option value="pt-PT">Portuguese (Portugal) - português (Portugal)</option>
                                                <option value="pa">Punjabi - ਪੰਜਾਬੀ</option>
                                                <option value="qu">Quechua</option>
                                                <option value="ro">Romanian - română</option>
                                                <option value="mo">Romanian (Moldova) - română (Moldova)</option>
                                                <option value="rm">Romansh - rumantsch</option>
                                                <option value="ru">Russian - русский</option>
                                                <option value="gd">Scottish Gaelic</option>
                                                <option value="sr">Serbian - српски</option>
                                                <option value="sh">Serbo-Croatian - Srpskohrvatski</option>
                                                <option value="sn">Shona - chiShona</option>
                                                <option value="sd">Sindhi</option>
                                                <option value="si">Sinhala - සිංහල</option>
                                                <option value="sk">Slovak - slovenčina</option>
                                                <option value="sl">Slovenian - slovenščina</option>
                                                <option value="so">Somali - Soomaali</option>
                                                <option value="st">Southern Sotho</option>
                                                <option value="es">Spanish - español</option>
                                                <option value="es-AR">Spanish (Argentina) - español (Argentina)</option>
                                                <option value="es-419">Spanish (Latin America) - español (Latinoamérica)
                                                </option>
                                                <option value="es-MX">Spanish (Mexico) - español (México)</option>
                                                <option value="es-ES">Spanish (Spain) - español (España)</option>
                                                <option value="es-US">Spanish (United States) - español (Estados Unidos)
                                                </option>
                                                <option value="su">Sundanese</option>
                                                <option value="sw">Swahili - Kiswahili</option>
                                                <option value="sv">Swedish - svenska</option>
                                                <option value="tg">Tajik - тоҷикӣ</option>
                                                <option value="ta">Tamil - தமிழ்</option>
                                                <option value="tt">Tatar</option>
                                                <option value="te">Telugu - తెలుగు</option>
                                                <option value="th">Thai - ไทย</option>
                                                <option value="ti">Tigrinya - ትግርኛ</option>
                                                <option value="to">Tongan - lea fakatonga</option>
                                                <option value="tr">Turkish - Türkçe</option>
                                                <option value="tk">Turkmen</option>
                                                <option value="tw">Twi</option>
                                                <option value="uk">Ukrainian - українська</option>
                                                <option value="ur">Urdu - اردو</option>
                                                <option value="ug">Uyghur</option>
                                                <option value="uz">Uzbek - o‘zbek</option>
                                                <option value="vi">Vietnamese - Tiếng Việt</option>
                                                <option value="wa">Walloon - wa</option>
                                                <option value="cy">Welsh - Cymraeg</option>
                                                <option value="fy">Western Frisian</option>
                                                <option value="xh">Xhosa</option>
                                                <option value="yi">Yiddish</option>
                                                <option value="yo">Yoruba - Èdè Yorùbá</option>
                                                <option value="zu">Zulu - isiZulu</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="direction" class="col-form-label"><?php echo e(translate('direction')); ?> :</label>
                                        <select id="direction" class="form-control" name="direction">
                                            <option value="ltr">LTR</option>
                                            <option value="rtl">RTL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><?php echo e(translate('close')); ?></button>
                            <button type="submit" class="btn btn--primary"><?php echo e(translate('Add')); ?> <i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if($language): ?>

        <?php $__currentLoopData = json_decode($language['value'],true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="modal fade" id="lang-modal-update-<?php echo e($data['code']); ?>" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><?php echo e(\App\CentralLogics\Helpers::get_language_name($data['code'])); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo e(route('admin.business-settings.language.update')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">

                                                   <input type="hidden" name="code" value="<?php echo e($data['code']); ?>">


















































































































































                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="direction-update" class="col-form-label"><?php echo e(translate('direction')); ?> :</label>
                                            <select id="direction-update" class="form-control" name="direction">
                                                <option
                                                    value="ltr" <?php echo e(isset($data['direction'])?$data['direction']=='ltr'?'selected':'':''); ?>>
                                                   <?php echo e(translate('LTR')); ?>

                                                </option>
                                                <option
                                                    value="rtl" <?php echo e(isset($data['direction'])?$data['direction']=='rtl'?'selected':'':''); ?>>
                                                     <?php echo e(translate('RTL')); ?>

                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal"><?php echo e(translate('close')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('update')); ?> <i
                                        class="fa fa-plus"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>


    <script>
        "use strict"
            $(".delete").click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '<?php echo e(translate('Are you sure to delete this')); ?>?',
                    text: "<?php echo e(translate('You will not be able to revert this')); ?>!",
                    showCancelButton: true,
                    confirmButtonColor: 'primary',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: '<?php echo e(translate('Yes_delete it')); ?>!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = $(this).attr("id");
                    }
                })
            });


            $(".update-lang-status").click(function (e) {
                e.preventDefault();
                toastr.warning('<?php echo e(translate('default language can not be updated! to update change the default language first!')); ?>');
            });


            $(".call-demo-lang").click(function (e) {
                e.preventDefault();
                let key = $(this).data('key');
                let mode = $(this).data('env-mode');

                if(  (key === 0 ||  key === 1 ) &&  mode === 'demo' ){
                    toastr.info('<?php echo e(translate('Update option is disabled for demo!')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $(".status-update").click(function () {
                $.get({
                    url: $(this).data('url'),
                    data: {
                        code: $(this).data('id'),
                    },

                    success: function () {
                        toastr.success('<?php echo e(translate('status_updated_successfully')); ?>');
                    }
                });
            });

            $(".update-default").click(function () {
                window.location.href = $(this).data('url');
            });


    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/language/index.blade.php ENDPATH**/ ?>