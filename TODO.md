# TODO - Kiana Furniture Enhancements (Additive)

- [ ] Add strict voucher validation: 1 user 1 voucher usage (CheckoutController@store) + persist voucher_id on successful checkout.
- [ ] Update Product model pricing display logic (only additive): ensure `final_price` + `has_discount` used.
- [ ] Update frontend product listing price (resources/views/frontend/products/index.blade.php): show normal price or (original + crossed + final_price).
- [ ] Update frontend product detail price (resources/views/frontend/products/show.blade.php): show crossed original + final_price when discount active.
- [ ] Update admin Product create/edit handling for discount fields (must not break existing discount_percentage behavior). 
- [ ] Add new migration(s) only if required (avoid editing old migrations).
- [ ] Run migrations + quick manual test checklist: voucher double-use reject; discount window price display.

