<?php
/**
 * Add a card to Stripe
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/public/partials
 */

?>
<div class="cpfs add-card">
	<h3>Add New Card</h3>
	<form id="setup-form" data-secret="<?php esc_attr_e($setupIntent->client_secret); ?>">
		<fieldset>
			<div class="field-group">
				<label for="cardholder-name">Cardholder Name</label>
				<input id="cardholder-name" type="text" autocomplete="name" required>
			</div>
			<div class="field-group">
				<div id="card-element"></div>
			</div>
			<button type="submit" id="card-button">Save Card</button>
        </fieldset>
	</form>
	<div id="card-error"></div>
	<div id="card-success"></div>
</div>

<script>
	const cardholderName = document.getElementById('cardholder-name');
	const setupForm = document.getElementById('setup-form');
	const cardError = document.getElementById('card-error');
	const cardSuccess = document.getElementById('card-success');
	const cardElementWrapper = document.getElementById('card-element');
	const cardButton = document.getElementById('card-button');

	const clientSecret = setupForm.dataset.secret;
	const stripe = Stripe('<?php esc_html_e(get_option( 'cpfs_stripe_publishable_key', '' )); ?>');
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

	setupForm.addEventListener('submit', function (ev) {
		ev.preventDefault()

		cpfs_clearError()
		cpfs_clearSuccess()
		cpfs_disableForm()

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
		).then(function (result) {
			cpfs_enableForm()
			if (result.error) {
				// console.error(result.error)
				cpfs_showError(result.error.message)
			} else {
				cpfs_setDefaultPaymentMethod(result)
				setupForm.reset()
				cardElement.clear()
				cpfs_showSuccess()
			}
		});
	});

	cpfs_disableForm = () => {
		cardholderName.disabled = true
		cardElementWrapper.disabled = true
		cardButton.disabled = true
	}

	cpfs_enableForm = () => {
		cardholderName.disabled = false
		cardElementWrapper.disabled = false
		cardButton.disabled = false
	}

	cpfs_showError = (message) => {
		cardError.innerText = message || 'Please try again'
	}

	cpfs_clearError = () => {
		cardError.innerText = ''
	}

	cpfs_showSuccess = (message) => {
		cardSuccess.innerText = message || 'Card successfully added'
	}

	cpfs_clearSuccess = (message) => {
		cardSuccess.innerText = ''
	}

	cpfs_setDefaultPaymentMethod = (result) => {
		const paymentMethod = result.setupIntent?.payment_method || null
		if (paymentMethod) {
			const ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
			jQuery.ajax({
				method: "POST",
				url: ajaxurl,
				data: {
					action: 'cpfs_setDefaultPaymentMethod',
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
