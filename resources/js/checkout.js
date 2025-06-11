import Alpine from 'alpinejs';
import { checkout } from './api';

Alpine.data('checkoutPage', () => ({
    form: {
        // define form fields as needed
    },
    async submit() {
        try {
            await checkout(this.form);
            window.location.href = '/customer/orders';
        } catch (error) {
            console.error('Checkout failed:', error);
        }
    }
})); 