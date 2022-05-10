<?php
/**
 * Add a card to Stripe
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Wp_Stripe_Customer_Portal
 * @subpackage Wp_Stripe_Customer_Portal/public/partials
 */
?>
<div class="wpscp add-card">
    <h3>Add New Card</h3>
    <form id="setup-form" data-secret="<?= $setupIntent->client_secret ?>">
        <fieldset>
            <div class="field-group">
                <label for="cardholder-name">Cardholder Name</label>
                <input id="cardholder-name" type="text" autocomplete="name" required>
            </div>
            <div class="field-group">
                <div id="card-element"></div>
            </div>
            <button type="submit" id="card-button">Save Card</button>
        </form>
        <div id="card-error"></div>
        <div id="card-success"></div>
    </fieldset>
</div>

<script>
    const cardholderName = document.getElementById('cardholder-name');
    const setupForm = document.getElementById('setup-form');
    const cardError = document.getElementById('card-error');
    const cardSuccess = document.getElementById('card-success');
    const cardElementWrapper = document.getElementById('card-element');
    const cardButton = document.getElementById('card-button');

    const clientSecret = setupForm.dataset.secret;
    const stripe = Stripe('<?php echo get_option('wpscp_stripe_publishable_key'); ?>');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        style: {
            base: {
                lineHeight: '1.6',
                fontSize: '1.1em',
            },
            invalid: {
                iconColor: '#FF0000',
                color: '#FF0000',
            },
        },
    });
    cardElement.mount('#card-element');

    setupForm.addEventListener('submit', function(ev) {
        ev.preventDefault()

        wpscp_clearError()
        wpscp_clearSuccess()
        wpscp_disableForm()

        stripe.confirmCardSetup(
            clientSecret,
            {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardholderName.value,
                    },
                },
            }
        ).then(function(result) {
            wpscp_enableForm()
            if (result.error) {
                // console.error(result.error)
                wpscp_showError(result.error.message)
            } else {
                wpscp_setDefaultPaymentMethod(result)
                setupForm.reset()
                cardElement.clear()
                wpscp_showSuccess()
            }
        });
    });

    wpscp_disableForm = () => {
        cardholderName.disabled = true
        cardElementWrapper.disabled = true
        cardButton.disabled = true
    }

    wpscp_enableForm = () => {
        cardholderName.disabled = false
        cardElementWrapper.disabled = false
        cardButton.disabled = false
    }

    wpscp_showError = (message) => {
        cardError.innerText = message || 'Please try again'
    }

    wpscp_clearError = () => {
        cardError.innerText = ''
    }

    wpscp_showSuccess = (message) => {
        cardSuccess.innerText = message || 'Card successfully added'
    }

    wpscp_clearSuccess = (message) => {
        cardSuccess.innerText = ''
    }

    wpscp_setDefaultPaymentMethod = (result) => {
        const paymentMethod = result.setupIntent?.payment_method || null
        if (paymentMethod) {
            var ajaxurl = "<?= admin_url('admin-ajax.php'); ?>";
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: {
                    action: 'wpscp_setDefaultPaymentMethod',
                    paymentMethod: paymentMethod,
                }
            }).done((response) => {
                // console.debug(response)
            }).fail((error) => {
                // console.error(error)
            })
        }
    }
</script>
