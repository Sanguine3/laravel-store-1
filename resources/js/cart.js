import Alpine from 'alpinejs';
import { getCart, addToCart, removeFromCart } from './api';

Alpine.data('cartPage', () => ({
    items: [],
    async init() {
        await this.load();
    },
    async load() {
        this.items = await getCart();
    },
    async increment(item) {
        await addToCart(item.product_id, 1);
        await this.load();
    },
    async decrement(item) {
        await removeFromCart(item.product_id);
        await this.load();
    }
})); 