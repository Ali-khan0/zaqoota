<!DOCTYPE html>
<html  lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
<meta charset="utf-8">
    <title>
        <?php echo $__env->yieldContent('title'); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/mercado_pogo/css/index.css')); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <!-- <script type="text/javascript" src="<?php echo e(asset('public/assets/mercado_pogo/js/index.js')); ?>" defer></script> -->
</head>
<body>
<main>
    <!-- Hidden input to store your integration public key -->
    <input type="hidden" id="mercado-pago-public-key" value="<?php echo e($data['public_key']); ?>">

    <!-- Payment -->
    <section class="payment-form dark">
        <div class="container__payment">
            <div class="block-heading">
                <h2>Card Payment</h2>
                <!-- <p>This is an example of a Mercado Pago integration</p> -->
            </div>
            <div class="form-payment">
                <div class="products">
                    <!-- <h2 class="title">Summary</h2> -->
                    <!-- <div class="item">
                        <span class="price" id="summary-price"></span>
                        <p class="item-name">Book x <span id="summary-quantity"></span></p>
                    </div> -->
                    <p class="alert alert-danger initial-hidden" role="alert" id="error_alert"></p>
                    <div class="total"><?php echo e(translate('messages.amount_to_be_paid')); ?><span class="price"><?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount- $order->partially_paid_amount)); ?></span></div>
                </div>
                <div class="payment-details">
                    <form id="form-checkout">
                        <h3 class="title">Buyer Details</h3>
                        <div class="row">
                            <div class="form-group col">
                                <input id="form-checkout__cardholderEmail" name="cardholderEmail" type="email" class="form-control"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <select id="form-checkout__identificationType" name="identificationType" class="form-control"></select>
                            </div>
                            <div class="form-group col-sm-7">
                                <input id="form-checkout__identificationNumber" name="docNumber" type="text" class="form-control"/>
                            </div>
                        </div>
                        <br>
                        <h3 class="title">Card Details</h3>
                        <div class="row">
                            <div class="form-group col-sm-8">
                                <input id="form-checkout__cardholderName" name="cardholderName" type="text" class="form-control"/>
                            </div>
                            <div class="form-group col-sm-4">
                                <div class="input-group expiration-date">
                                    <input id="form-checkout__cardExpirationMonth" name="cardExpirationMonth" type="text" class="form-control"/>
                                    <span class="date-separator">/</span>
                                    <input id="form-checkout__cardExpirationYear" name="cardExpirationYear" type="text" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group col-sm-8">
                                <input id="form-checkout__cardNumber" name="cardNumber" type="text" class="form-control"/>
                            </div>
                            <div class="form-group col-sm-4">
                                <input id="form-checkout__securityCode" name="securityCode" type="text" class="form-control"/>
                            </div>
                            <div id="issuerInput" class="form-group col-sm-12 hidden">
                                <select id="form-checkout__issuer" name="issuer" class="form-control"></select>
                            </div>
                            <div class="form-group col-sm-12">
                                <select id="form-checkout__installments" name="installments" type="text" class="form-control"></select>
                            </div>
                            <div class="form-group col-sm-12">
                                <br>
                                <button id="form-checkout__submit" type="submit" class="btn btn-primary btn-block">Pay</button>
                                <br>
                                <p id="loading-message">Loading, please wait...</p>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
</body>
<script>
    const publicKey = document.getElementById("mercado-pago-public-key").value;
    const mercadopago = new MercadoPago(publicKey);

    loadCardForm();
    function loadCardForm() {
        const productCost = '<?php echo e($order->order_amount- $order->partially_paid_amount); ?>';
        const productDescription = '<?php echo e('Payment for order id:'.$order->id); ?>';

        const cardForm = mercadopago.cardForm({
            amount: productCost,
            autoMount: true,
            form: {
                id: "form-checkout",
                cardholderName: {
                    id: "form-checkout__cardholderName",
                    placeholder: "<?php echo e(translate('messages.card_holder_name')); ?>",
                },
                cardholderEmail: {
                    id: "form-checkout__cardholderEmail",
                    placeholder: "<?php echo e(translate('messages.card_holder_email')); ?>",
                },
                cardNumber: {
                    id: "form-checkout__cardNumber",
                    placeholder: "<?php echo e(translate('messages.card_number')); ?>",
                },
                cardExpirationMonth: {
                    id: "form-checkout__cardExpirationMonth",
                    placeholder: "MM",
                },
                cardExpirationYear: {
                    id: "form-checkout__cardExpirationYear",
                    placeholder: "YY",
                },
                securityCode: {
                    id: "form-checkout__securityCode",
                    placeholder: "<?php echo e(translate('messages.security_code')); ?>",
                },
                installments: {
                    id: "form-checkout__installments",
                    placeholder: "<?php echo e(translate('messages.installments')); ?>",
                },
                identificationType: {
                    id: "form-checkout__identificationType",
                },
                identificationNumber: {
                    id: "form-checkout__identificationNumber",
                    placeholder: "<?php echo e(translate('messages.identification_number')); ?>",
                },
                issuer: {
                    id: "form-checkout__issuer",
                    placeholder: "<?php echo e(translate('messages.issuer')); ?>",
                },
            },
            callbacks: {
                onFormMounted: error => {
                    if (error)
                        return console.warn("Form Mounted handling error: ", error);
                    console.log("Form mounted");
                },
                onSubmit: event => {
                    event.preventDefault();
                    document.getElementById("loading-message").style.display = "block";

                    const {
                        paymentMethodId,
                        issuerId,
                        cardholderEmail: email,
                        amount,
                        token,
                        installments,
                        identificationNumber,
                        identificationType,
                    } = cardForm.getCardFormData();

                    fetch("<?php echo e(route('mercadopago.make_payment',request()->getQueryString())); ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                        },
                        body: JSON.stringify({
                            token,
                            issuerId,
                            paymentMethodId,
                            transactionAmount: Number(amount),
                            installments: Number(installments),
                            description: productDescription,
                            payer: {
                                email,
                                identification: {
                                    type: identificationType,
                                    number: identificationNumber,
                                },
                            },
                        }),
                    })
                        .then(response => {
                            return response.json();
                        })
                        .then(result => {
                            if(result.error)
                            {
                                document.getElementById("loading-message").style.display = "none";
                                document.getElementById("error_alert").innerText = result.error;
                                document.getElementById("error_alert").style.display = "block";
                                return false;
                            }
                            location.href = '<?php echo e(route('payment-success')); ?>';
                        })
                        .catch(error => {
                            document.getElementById("loading-message").style.display = "none";
                            document.getElementById("error_alert").innerHtml = error;
                            document.getElementById("error_alert").style.display = "block";
                        });
                },
                onFetching: (resource) => {
                    console.log("Fetching resource: ", resource);
                    const payButton = document.getElementById("form-checkout__submit");
                    payButton.setAttribute('disabled', true);
                    return () => {
                        payButton.removeAttribute("disabled");
                    };
                },
            },
        });
    };
</script>
</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/payment-view-marcedo-pogo.blade.php ENDPATH**/ ?>