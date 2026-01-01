@extends('layouts.store')
@section('title', $profile->store_name ?? 'Store')
@section('content')

<style>
    :root {
        --store-primary: {{ $profile->store_primary_color ?? '#10B981' }};
        --store-secondary: {{ $profile->store_secondary_color ?? '#F59E0B' }};
        --store-text: {{ $profile->store_text_color ?? '#1F2937' }};
        --store-bg: {{ $profile->store_background_color ?? '#FFFFFF' }};
    }
    
    * { box-sizing: border-box; }
    body { background: #F5F5F5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
    
    .store-app { min-height: 100vh; background: var(--store-bg); padding-bottom: 70px; }
    
    /* Mobile Header */
    .mobile-header { background: white; padding: 12px 16px; position: sticky; top: 0; z-index: 40; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .store-branding { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
    .store-logo-mobile { width: 48px; height: 48px; border-radius: 12px; overflow: hidden; flex-shrink: 0; background: #F3F4F6; display: flex; align-items: center; justify-content: center; }
    .store-logo-mobile img { width: 100%; height: 100%; object-fit: cover; }
    .store-logo-mobile i { font-size: 24px; color: var(--store-primary); }
    .store-info-mobile { flex: 1; min-width: 0; }
    .store-name-mobile { font-size: 16px; font-weight: 700; color: #1F2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .store-address-mobile { font-size: 11px; color: #6B7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .delivery-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .delivery-info { display: flex; align-items: center; gap: 10px; }
    .delivery-icon { width: 36px; height: 36px; background: var(--store-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; }
    .delivery-text { font-size: 11px; color: #6B7280; }
    .delivery-address { font-size: 14px; font-weight: 600; color: #1F2937; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .header-actions { display: flex; gap: 8px; }
    .header-btn { width: 40px; height: 40px; border-radius: 50%; background: #F3F4F6; display: flex; align-items: center; justify-content: center; color: #4B5563; border: none; cursor: pointer; position: relative; }
    .header-btn .badge { position: absolute; top: -2px; right: -2px; background: var(--store-primary); color: white; font-size: 10px; font-weight: 700; min-width: 18px; height: 18px; border-radius: 9px; display: flex; align-items: center; justify-content: center; }
    
    /* Search Bar */
    .search-bar { display: flex; align-items: center; gap: 12px; }
    .search-input-wrap { flex: 1; position: relative; }
    .search-input { width: 100%; padding: 12px 16px 12px 44px; border: 1px solid #E5E7EB; border-radius: 12px; font-size: 14px; background: #F9FAFB; }
    .search-input:focus { outline: none; border-color: var(--store-primary); background: white; }
    .search-input-wrap i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #9CA3AF; }
    .filter-btn { width: 48px; height: 48px; border: 1px solid #E5E7EB; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; color: #4B5563; cursor: pointer; }
    
    /* Banner Slider */
    .banner-slider { padding: 16px; overflow: hidden; }
    .banner-container { display: flex; gap: 12px; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none; -ms-overflow-style: none; scroll-behavior: smooth; }
    .banner-container::-webkit-scrollbar { display: none; }
    .banner-slide { min-width: calc(100% - 24px); scroll-snap-align: start; border-radius: 16px; overflow: hidden; position: relative; height: 160px; flex-shrink: 0; }
    .banner-slide img { width: 100%; height: 100%; object-fit: cover; }
    .banner-content { position: absolute; top: 0; left: 0; right: 0; bottom: 0; padding: 20px; display: flex; flex-direction: column; justify-content: center; background: linear-gradient(90deg, rgba(0,0,0,0.5), transparent); }
    .banner-tag { font-size: 11px; color: white; opacity: 0.9; margin-bottom: 4px; }
    .banner-title { font-size: 20px; font-weight: 700; color: white; line-height: 1.2; margin-bottom: 12px; }
    .banner-btn { display: inline-flex; align-items: center; padding: 8px 16px; background: var(--store-primary); color: white; font-size: 12px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; width: fit-content; }
    .banner-dots { display: flex; justify-content: center; gap: 6px; margin-top: 12px; }
    .banner-dot { width: 8px; height: 8px; border-radius: 50%; background: #D1D5DB; cursor: pointer; transition: all 0.3s; }
    .banner-dot.active { width: 24px; border-radius: 4px; background: var(--store-primary); }
    
    /* Section Headers */
    .section-header { display: flex; align-items: center; justify-content: space-between; padding: 0 16px; margin-bottom: 12px; }
    .section-title { font-size: 18px; font-weight: 700; color: #1F2937; }
    .section-subtitle { font-size: 12px; color: #6B7280; margin-top: 2px; }
    .section-link { width: 32px; height: 32px; background: var(--store-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; }
    
    /* Categories */
    .categories-scroll { padding: 16px; width: 100%; }
    .categories-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
    .category-item { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px 8px; background: white; border-radius: 12px; border: 1px solid #E5E7EB; cursor: pointer; transition: all 0.2s; text-align: center; }
    .category-item:hover, .category-item.active { border-color: var(--store-primary); background: rgba(16, 185, 129, 0.05); }
    .category-item.active .category-icon { background: var(--store-primary); }
    .category-item.active .category-icon i { color: white !important; }
    .category-icon { width: 48px; height: 48px; border-radius: 12px; overflow: hidden; background: #F3F4F6; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin: 0 auto; }
    .category-icon img { width: 100%; height: 100%; object-fit: cover; }
    .category-icon i { font-size: 20px; color: var(--store-primary); line-height: 1; }
    .category-name { font-size: 12px; font-weight: 500; color: #374151; word-break: break-word; line-height: 1.3; }
    
    /* Products Section */
    .products-section { padding: 24px 16px; }
    .products-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    
    /* Product Card */
    .product-card { background: white; border-radius: 16px; overflow: hidden; position: relative; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .product-badge { position: absolute; top: 8px; left: 8px; padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 600; z-index: 2; }
    .badge-new { background: var(--store-primary); color: white; }
    .badge-sale { background: #EF4444; color: white; }
    .product-wishlist { position: absolute; top: 8px; right: 8px; width: 32px; height: 32px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; z-index: 2; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .product-wishlist i { color: #D1D5DB; font-size: 14px; transition: color 0.2s; }
    .product-wishlist.active i { color: #EF4444; }
    .product-image { aspect-ratio: 1; background: #F9FAFB; display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer; }
    .product-image img { width: 100%; height: 100%; object-fit: cover; }
    .product-image i { font-size: 40px; color: #D1D5DB; }
    .product-info { padding: 12px; }
    .product-name { font-size: 14px; font-weight: 600; color: #1F2937; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.3; }
    .product-price { display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap; }
    .price-current { font-size: 16px; font-weight: 700; color: var(--store-primary); }
    .price-unit { font-size: 12px; color: #9CA3AF; }
    .price-original { font-size: 12px; color: #9CA3AF; text-decoration: line-through; }
    
    /* Bottom Navigation */
    .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: white; border-top: 1px solid #E5E7EB; display: flex; justify-content: space-around; padding: 8px 0; z-index: 50; padding-bottom: max(8px, env(safe-area-inset-bottom)); }
    .nav-item { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 8px 16px; cursor: pointer; position: relative; }
    .nav-item i { font-size: 20px; color: #9CA3AF; transition: color 0.2s; }
    .nav-item span { font-size: 11px; color: #9CA3AF; font-weight: 500; }
    .nav-item.active i, .nav-item.active span { color: var(--store-primary); }
    .nav-item .nav-badge { position: absolute; top: 0; right: 8px; background: var(--store-primary); color: white; font-size: 10px; font-weight: 700; min-width: 16px; height: 16px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    
    /* Filter Sidebar */
    .filter-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; opacity: 0; visibility: hidden; transition: all 0.3s; }
    .filter-overlay.active { opacity: 1; visibility: visible; }
    .filter-sidebar { position: fixed; right: 0; top: 0; bottom: 0; width: 100%; max-width: 360px; background: white; transform: translateX(100%); transition: transform 0.3s; z-index: 101; display: flex; flex-direction: column; }
    .filter-overlay.active .filter-sidebar { transform: translateX(0); }
    .filter-header { padding: 16px; border-bottom: 1px solid #E5E7EB; display: flex; align-items: center; justify-content: space-between; }
    .filter-title { font-size: 18px; font-weight: 700; }
    .filter-close { width: 36px; height: 36px; border-radius: 50%; background: #F3F4F6; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; }
    .filter-body { flex: 1; overflow-y: auto; padding: 16px; }
    .filter-section { margin-bottom: 24px; }
    .filter-section-title { font-size: 14px; font-weight: 600; color: #1F2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
    .filter-option { padding: 12px; background: #F9FAFB; border-radius: 8px; margin-bottom: 8px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: space-between; }
    .filter-option:hover { background: #F3F4F6; }
    .filter-option.active { background: var(--store-primary); color: white; }
    .filter-option input[type="radio"] { margin-right: 8px; }
    .filter-footer { padding: 16px; border-top: 1px solid #E5E7EB; display: flex; gap: 12px; }
    .filter-clear-btn { flex: 1; padding: 12px; background: #F3F4F6; color: #374151; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; }
    .filter-apply-btn { flex: 1; padding: 12px; background: var(--store-primary); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; }
    
    /* Cart Sidebar */
    .cart-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; opacity: 0; visibility: hidden; transition: all 0.3s; }
    .cart-overlay.active { opacity: 1; visibility: visible; }
    .cart-sidebar { position: fixed; right: 0; top: 0; bottom: 0; width: 100%; max-width: 400px; background: white; transform: translateX(100%); transition: transform 0.3s; z-index: 101; display: flex; flex-direction: column; }
    .cart-overlay.active .cart-sidebar { transform: translateX(0); }
    .cart-header { padding: 16px; border-bottom: 1px solid #E5E7EB; display: flex; align-items: center; justify-content: space-between; }
    .cart-title { font-size: 18px; font-weight: 700; }
    .cart-close { width: 36px; height: 36px; border-radius: 50%; background: #F3F4F6; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; }
    .cart-items { flex: 1; overflow-y: auto; padding: 16px; }
    .cart-item { display: flex; gap: 12px; padding: 12px; background: #F9FAFB; border-radius: 12px; margin-bottom: 12px; }
    .cart-item-image { width: 70px; height: 70px; border-radius: 8px; overflow: hidden; flex-shrink: 0; background: white; }
    .cart-item-image img { width: 100%; height: 100%; object-fit: cover; }
    .cart-item-info { flex: 1; }
    .cart-item-name { font-size: 14px; font-weight: 600; color: #1F2937; margin-bottom: 4px; }
    .cart-item-price { font-size: 14px; font-weight: 700; color: var(--store-primary); }
    .cart-item-qty { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    .qty-btn { width: 28px; height: 28px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; display: flex; align-items: center; justify-content: center; cursor: pointer; }
    .qty-value { font-size: 14px; font-weight: 600; min-width: 24px; text-align: center; }
    .cart-item-remove { color: #EF4444; background: none; border: none; cursor: pointer; font-size: 16px; }
    .cart-empty { text-align: center; padding: 60px 20px; color: #9CA3AF; }
    .cart-empty i { font-size: 48px; margin-bottom: 16px; }
    .cart-footer { padding: 16px; border-top: 1px solid #E5E7EB; background: white; }
    .cart-total { display: flex; justify-content: space-between; margin-bottom: 16px; }
    .cart-total-label { font-size: 16px; color: #6B7280; }
    .cart-total-value { font-size: 20px; font-weight: 700; color: #1F2937; }
    .checkout-btn { width: 100%; padding: 16px; background: #25D366; color: white; font-size: 16px; font-weight: 600; border: none; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .checkout-btn i { font-size: 20px; }
    
    /* Product Modal */
    .product-modal { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; opacity: 0; visibility: hidden; transition: all 0.3s; display: flex; align-items: flex-end; }
    .product-modal.active { opacity: 1; visibility: visible; }
    .product-modal-content { background: white; width: 100%; max-height: 90vh; border-radius: 24px 24px 0 0; transform: translateY(100%); transition: transform 0.3s; overflow-y: auto; }
    .product-modal.active .product-modal-content { transform: translateY(0); }
    .modal-image { height: 280px; background: #F9FAFB; position: relative; }
    .modal-image img { width: 100%; height: 100%; object-fit: cover; }
    .modal-close { position: absolute; top: 16px; right: 16px; width: 36px; height: 36px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .modal-body { padding: 20px; }
    .modal-name { font-size: 22px; font-weight: 700; color: #1F2937; margin-bottom: 8px; }
    .modal-price { font-size: 24px; font-weight: 700; color: var(--store-primary); margin-bottom: 16px; }
    .modal-desc { font-size: 14px; color: #6B7280; line-height: 1.6; margin-bottom: 20px; }
    .modal-qty { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
    .modal-qty-label { font-size: 14px; font-weight: 600; color: #374151; }
    .modal-qty-controls { display: flex; align-items: center; gap: 12px; background: #F3F4F6; border-radius: 12px; padding: 4px; }
    .modal-qty-btn { width: 40px; height: 40px; border-radius: 8px; background: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; }
    .modal-qty-value { font-size: 18px; font-weight: 700; min-width: 40px; text-align: center; }
    .modal-add-btn { width: 100%; padding: 16px; background: var(--store-primary); color: white; font-size: 16px; font-weight: 600; border: none; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; }
    
    /* Desktop Styles */
    @media (min-width: 768px) {
        body { background: linear-gradient(135deg, #F8FAFC 0%, #EFF6FF 100%); }
        .store-app { padding-bottom: 0; background: transparent; }
        .mobile-header { display: none; }
        .bottom-nav { display: none; }
        
        .desktop-header { display: block !important; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(229, 231, 235, 0.8); padding: 20px 0; position: sticky; top: 0; z-index: 40; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .desktop-header-inner { max-width: 1280px; margin: 0 auto; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; }
        .desktop-logo { display: flex; align-items: center; gap: 14px; cursor: pointer; transition: transform 0.2s; }
        .desktop-logo:hover { transform: scale(1.02); }
        .desktop-logo img { height: 52px; width: auto; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .desktop-logo h1 { font-size: 26px; font-weight: 800; background: linear-gradient(135deg, var(--store-primary), var(--store-secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .desktop-search { flex: 1; max-width: 600px; margin: 0 48px; position: relative; }
        .desktop-search input { width: 100%; padding: 15px 24px 15px 52px; border: 2px solid transparent; border-radius: 16px; font-size: 15px; background: #F9FAFB; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .desktop-search input:focus { outline: none; border-color: var(--store-primary); background: white; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15); }
        .desktop-search i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #9CA3AF; font-size: 18px; }
        .desktop-actions { display: flex; align-items: center; gap: 12px; }
        .desktop-btn { display: flex; align-items: center; gap: 10px; padding: 13px 22px; border-radius: 12px; background: white; color: #374151; font-weight: 600; font-size: 14px; cursor: pointer; border: 2px solid #F3F4F6; position: relative; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.04); }
        .desktop-btn:hover { background: var(--store-primary); color: white; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); border-color: var(--store-primary); }
        .desktop-btn .badge { position: absolute; top: -6px; right: -6px; background: #EF4444; color: white; font-size: 11px; font-weight: 700; min-width: 22px; height: 22px; border-radius: 11px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3); }
        
        .banner-slider { max-width: 1280px; margin: 0 auto; padding: 32px 32px 40px; }
        .banner-container { gap: 20px; }
        .banner-slide { min-width: calc(50% - 10px); height: 280px; border-radius: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); transition: all 0.4s ease; }
        .banner-slide:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(0,0,0,0.18); }
        .banner-content { background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.2) 50%, transparent 100%); padding: 32px; }
        .banner-title { font-size: 32px; margin-bottom: 16px; }
        .banner-btn { padding: 12px 28px; font-size: 15px; border-radius: 12px; font-weight: 700; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: all 0.3s; }
        .banner-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.3); }
        
        .products-section { max-width: 1280px; margin: 0 auto; padding: 40px 32px; }
        .products-grid { grid-template-columns: repeat(4, 1fr); gap: 24px; }
        .product-card { border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.4s ease; border: 1px solid #F3F4F6; overflow: hidden; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 12px 28px rgba(0,0,0,0.15); border-color: var(--store-primary); }
        .product-image { transition: transform 0.4s ease; }
        .product-card:hover .product-image img { transform: scale(1.1); }
        .product-wishlist { width: 38px; height: 38px; box-shadow: 0 2px 8px rgba(0,0,0,0.12); transition: all 0.3s; }
        .product-wishlist:hover { transform: scale(1.15); background: var(--store-primary); }
        .product-wishlist:hover i { color: white !important; }
        .product-badge { padding: 6px 12px; font-size: 11px; font-weight: 700; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.15); }
        .product-info { padding: 16px; }
        .product-name { font-size: 15px; font-weight: 700; margin-bottom: 8px; }
        .price-current { font-size: 20px; font-weight: 800; }
        .price-original { font-size: 14px; }
        
        .categories-scroll { max-width: 1280px; margin: 0 auto; padding: 0 32px; }
        .categories-list { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 20px; }
        .category-item { padding: 16px 12px; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: all 0.3s; border: 2px solid transparent; }
        .category-item:hover { transform: translateY(-4px); box-shadow: 0 6px 20px rgba(0,0,0,0.12); border-color: var(--store-primary); }
        .category-item.active { background: linear-gradient(135deg, var(--store-primary), var(--store-secondary)); border-color: var(--store-primary); box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3); }
        .category-item.active .category-name { color: white; font-weight: 700; }
        .category-icon { width: 48px; height: 48px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        .category-name { font-size: 15px; font-weight: 600; }
        .section-header { max-width: 1280px; margin: 0 auto 20px; padding: 0 32px; }
        .section-title { font-size: 28px; font-weight: 800; background: linear-gradient(135deg, #1F2937, #374151); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .section-subtitle { font-size: 14px; color: #6B7280; margin-top: 4px; }
        .section-link { width: 44px; height: 44px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2); transition: all 0.3s; }
        .section-link:hover { transform: scale(1.1) rotate(360deg); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
        
        .cart-sidebar { max-width: 440px; box-shadow: -4px 0 24px rgba(0,0,0,0.12); }
        
        .product-modal { align-items: center; justify-content: center; padding: 24px; }
        .product-modal-content { max-width: 700px; max-height: 85vh; border-radius: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    }
    
    @media (min-width: 1024px) {
        .products-grid { grid-template-columns: repeat(5, 1fr); }
        .banner-slide { min-width: calc(33.333% - 14px); height: 300px; }
    }
    
    @media (min-width: 1440px) {
        .desktop-header-inner,
        .banner-slider,
        .categories-scroll,
        .section-header,
        .products-section { max-width: 1400px; }
        .products-grid { grid-template-columns: repeat(6, 1fr); }
    }
    
    .desktop-header { display: none; }
</style>

<div class="store-app">
    <!-- Mobile Header -->
    <header class="mobile-header">
        <div class="store-branding">
            <div class="store-logo-mobile">
                @if($profile->store_logo)
                    <img src="{{ Storage::disk('public')->url($profile->store_logo) }}" alt="{{ $profile->store_name ?? 'Store' }}">
                @else
                    <i class="fas fa-store"></i>
                @endif
            </div>
            <div class="store-info-mobile">
                <div class="store-name-mobile">{{ $profile->store_name ?? 'My Store' }}</div>
                @if($profile->store_address)
                    <div class="store-address-mobile"><i class="fas fa-map-marker-alt" style="margin-right: 4px;"></i>{{ $profile->store_address }}</div>
                @endif
            </div>
            <div class="header-actions">
                <button class="header-btn" onclick="alert('Notifications coming soon!')">
                    <i class="fas fa-bell"></i>
                </button>
                <button class="header-btn" onclick="openCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge" id="header-cart-badge" style="display: none;">0</span>
                </button>
            </div>
        </div>
        <div class="search-bar">
            <div class="search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" id="search-input" placeholder="Search products..." oninput="searchProducts()">
            </div>
            <button class="filter-btn" onclick="toggleFilters()">
                <i class="fas fa-sliders-h"></i>
            </button>
        </div>
    </header>
    
    <!-- Desktop Header -->
    <header class="desktop-header">
        <div class="desktop-header-inner">
            <div class="desktop-logo">
                @if($profile->store_logo)
                    <img src="{{ Storage::disk('public')->url($profile->store_logo) }}" alt="{{ $profile->store_name }}">
                @else
                    <div style="width: 48px; height: 48px; background: var(--store-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        <i class="fas fa-store"></i>
                    </div>
                @endif
                <h1>{{ $profile->store_name ?? 'My Store' }}</h1>
            </div>
            <div class="desktop-search">
                <i class="fas fa-search"></i>
                <input type="text" id="desktop-search" placeholder="Search products..." oninput="searchProducts()">
            </div>
            <div class="desktop-actions">
                <button class="desktop-btn" onclick="openWishlist()">
                    <i class="fas fa-heart"></i> Wishlist
                    <span class="badge" id="desktop-wishlist-badge" style="display: none;">0</span>
                </button>
                <button class="desktop-btn" onclick="openCart()">
                    <i class="fas fa-shopping-cart"></i> Cart
                    <span class="badge" id="desktop-cart-badge" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Banner Slider -->
    @if(isset($banners) && $banners->count() > 0)
    <section class="banner-slider">
        <div class="banner-container" id="banner-container">
            @foreach($banners as $banner)
            <div class="banner-slide" style="background: {{ $banner->background_color }};">
                @if($banner->image)
                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}">
                @endif
                <div class="banner-content">
                    @if($banner->subtitle)
                        <div class="banner-tag">{{ $banner->subtitle }}</div>
                    @endif
                    <div class="banner-title">{{ $banner->title }}</div>
                    @if($banner->button_text)
                        <button class="banner-btn" onclick="if('{{ $banner->button_link }}') location.href='{{ $banner->button_link }}'">
                            {{ $banner->button_text }}
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @if($banners->count() > 1)
        <div class="banner-dots">
            @foreach($banners as $index => $banner)
                <div class="banner-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToBanner({{ $index }})"></div>
            @endforeach
        </div>
        @endif
    </section>
    @else
    <!-- Default Banner when no banners exist -->
    <section class="banner-slider">
        <div class="banner-container">
            <div class="banner-slide" style="background: linear-gradient(135deg, var(--store-primary), #34D399);">
                <div class="banner-content">
                    <div class="banner-tag">Welcome!</div>
                    <div class="banner-title">{{ $profile->store_name ?? 'Fresh Products Everyday' }}</div>
                    <button class="banner-btn">Shop Now</button>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Categories -->
    <section style="padding-top: 20px;">
        <div class="section-header">
            <div>
                <div class="section-title">Explore Categories</div>
                <div class="section-subtitle">Based on what is popular around you</div>
            </div>
            <div class="section-link"><i class="fas fa-arrow-right"></i></div>
        </div>
        <div class="categories-scroll">
            <div class="categories-list">
                <div class="category-item active" onclick="filterByCategory('all')" data-id="all">
                    <div class="category-icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <span class="category-name">All</span>
                </div>
                @if($categories->count() > 0)
                    @foreach($categories as $category)
                    <div class="category-item" data-id="{{ $category->id }}" onclick="filterByCategory('{{ $category->id }}')">
                        <div class="category-icon" @if($category->color) style="background-color: {{ $category->color }}20;" @endif>
                            @if($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                            @else
                                <i class="fas fa-{{ $category->icon ?? 'folder' }}" @if($category->color) style="color: {{ $category->color }};" @endif></i>
                            @endif
                        </div>
                        <span class="category-name">{{ $category->name }}</span>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="products-section">
        <div class="section-header" style="padding: 0; margin-bottom: 16px;">
            <div>
                <div class="section-title">
                    @if(($profile->featured_products_type ?? 'top_selling') === 'trending')
                        Trending Products
                    @elseif(($profile->featured_products_type ?? 'top_selling') === 'featured')
                        Featured Products
                    @else
                        Top Selling Products
                    @endif
                </div>
            </div>
            <div class="section-link"><i class="fas fa-arrow-right"></i></div>
        </div>
        
        <div class="products-grid" id="products-grid">
            @foreach($products as $index => $product)
            <div class="product-card" data-category="{{ $product->category_id }}" data-name="{{ strtolower($product->name) }}" data-price="{{ $product->price }}">
                @if($index < 3)
                    <span class="product-badge badge-new">NEW</span>
                @endif
                @if($product->original_price && $product->original_price > $product->price)
                    <span class="product-badge badge-sale">-{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%</span>
                @endif
                <button class="product-wishlist" onclick="toggleWishlist(event, {{ $product->id }})">
                    <i class="far fa-heart"></i>
                </button>
                <div class="product-image" onclick='openProductModal(@json($product))'>
                    @if($product->image)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-image"></i>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">
                        <span class="price-current">{{ $profile->currency_symbol }}{{ number_format($product->price, 0) }}</span>
                        @if($product->stock)
                            <span class="price-unit">/{{ $product->stock }} pcs</span>
                        @endif
                        @if($product->original_price && $product->original_price > $product->price)
                            <span class="price-original">{{ $profile->currency_symbol }}{{ number_format($product->original_price, 0) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($products->isEmpty())
        <div style="text-align: center; padding: 60px 20px; color: #9CA3AF;">
            <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 16px;"></i>
            <p>No products available yet</p>
        </div>
        @endif
    </section>
    
    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <div class="nav-item active">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </div>
        <div class="nav-item" onclick="scrollToCategories()">
            <i class="fas fa-th-large"></i>
            <span>Category</span>
        </div>
        <div class="nav-item" onclick="openCart()">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
            <span class="nav-badge" id="nav-cart-badge" style="display: none;">0</span>
        </div>
        <div class="nav-item" onclick="openWishlist()">
            <i class="fas fa-heart"></i>
            <span>Wishlist</span>
            <span class="nav-badge" id="nav-wishlist-badge" style="display: none;">0</span>
        </div>
        <div class="nav-item">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </div>
    </nav>
</div>

<!-- Filter Sidebar -->
<div class="filter-overlay" id="filter-overlay" onclick="closeFilters()">
    <div class="filter-sidebar" onclick="event.stopPropagation()">
        <div class="filter-header">
            <h3 class="filter-title">Filters & Sort</h3>
            <button class="filter-close" onclick="closeFilters()"><i class="fas fa-times"></i></button>
        </div>
        <div class="filter-body">
            <!-- Sort Options -->
            <div class="filter-section">
                <div class="filter-section-title">
                    <i class="fas fa-sort"></i> Sort By
                </div>
                <div class="filter-option" onclick="applySorting('name-asc')">
                    <span>Name (A-Z)</span>
                    <i class="fas fa-sort-alpha-down"></i>
                </div>
                <div class="filter-option" onclick="applySorting('name-desc')">
                    <span>Name (Z-A)</span>
                    <i class="fas fa-sort-alpha-up"></i>
                </div>
                <div class="filter-option" onclick="applySorting('price-asc')">
                    <span>Price (Low to High)</span>
                    <i class="fas fa-sort-amount-down"></i>
                </div>
                <div class="filter-option" onclick="applySorting('price-desc')">
                    <span>Price (High to Low)</span>
                    <i class="fas fa-sort-amount-up"></i>
                </div>
            </div>
            
            <!-- Category Filter -->
            @if(isset($categories) && $categories->count() > 0)
            <div class="filter-section">
                <div class="filter-section-title">
                    <i class="fas fa-folder"></i> Categories
                </div>
                <div class="filter-option" onclick="filterByCategory('all')">
                    <span>All Products</span>
                    <i class="fas fa-check" style="display: none;"></i>
                </div>
                @foreach($categories as $category)
                <div class="filter-option" onclick="filterByCategory({{ $category->id }})" data-category-id="{{ $category->id }}">
                    <span>{{ $category->name }}</span>
                    <i class="fas fa-check" style="display: none;"></i>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="filter-footer">
            <button class="filter-clear-btn" onclick="clearFilters()">
                <i class="fas fa-redo"></i> Reset
            </button>
            <button class="filter-apply-btn" onclick="closeFilters()">
                <i class="fas fa-check"></i> Apply
            </button>
        </div>
    </div>
</div>

<!-- Cart Sidebar -->
<div class="cart-overlay" id="cart-overlay" onclick="closeCart()">
    <div class="cart-sidebar" onclick="event.stopPropagation()">
        <div class="cart-header">
            <h3 class="cart-title">Shopping Cart</h3>
            <button class="cart-close" onclick="closeCart()"><i class="fas fa-times"></i></button>
        </div>
        <div class="cart-items" id="cart-items">
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <p>Your cart is empty</p>
            </div>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span class="cart-total-label">Total</span>
                <span class="cart-total-value" id="cart-total">{{ $profile->currency_symbol }}0</span>
            </div>
            <button class="checkout-btn" onclick="checkout()">
                <i class="fab fa-whatsapp"></i>
                Checkout via WhatsApp
            </button>
        </div>
    </div>
</div>

<!-- Wishlist Sidebar -->
<div class="cart-overlay" id="wishlist-overlay" onclick="closeWishlist()">
    <div class="cart-sidebar" onclick="event.stopPropagation()">
        <div class="cart-header">
            <h3 class="cart-title">My Wishlist</h3>
            <button class="cart-close" onclick="closeWishlist()"><i class="fas fa-times"></i></button>
        </div>
        <div class="cart-items" id="wishlist-items">
            <div class="cart-empty">
                <i class="fas fa-heart"></i>
                <p>Your wishlist is empty</p>
            </div>
        </div>
        <div class="cart-footer" id="wishlist-footer" style="display: none;">
            <button class="checkout-btn" onclick="viewWishlistProducts()" style="background: #EF4444;">
                <i class="fas fa-heart"></i>
                View All Items
            </button>
        </div>
    </div>
</div>

<!-- Product Modal -->
<div class="product-modal" id="product-modal" onclick="closeProductModal()">
    <div class="product-modal-content" onclick="event.stopPropagation()">
        <div class="modal-image" id="modal-image">
            <button class="modal-close" onclick="closeProductModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <h2 class="modal-name" id="modal-name"></h2>
            <div class="modal-price" id="modal-price"></div>
            <p class="modal-desc" id="modal-desc"></p>
            <div class="modal-qty">
                <span class="modal-qty-label">Quantity:</span>
                <div class="modal-qty-controls">
                    <button class="modal-qty-btn" onclick="updateModalQty(-1)"><i class="fas fa-minus"></i></button>
                    <span class="modal-qty-value" id="modal-qty">1</span>
                    <button class="modal-qty-btn" onclick="updateModalQty(1)"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <button class="modal-add-btn" onclick="addToCartFromModal()">
                <i class="fas fa-cart-plus"></i>
                Add to Cart
            </button>
        </div>
    </div>
</div>

<script>
const currencySymbol = "{{ $profile->currency_symbol ?? '$' }}";
const whatsappNumber = "{{ preg_replace('/[^0-9]/', '', $profile->store_whatsapp ?? $profile->phone ?? '') }}";
let cart = JSON.parse(localStorage.getItem('store_cart_{{ $profile->user_id }}')) || [];
let wishlist = JSON.parse(localStorage.getItem('store_wishlist_{{ $profile->user_id }}')) || [];
let currentProduct = null;
let modalQty = 1;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateCartUI();
    updateWishlistUI();
    initBannerSlider();
});

// Banner Slider
let currentBanner = 0;
function initBannerSlider() {
    const container = document.getElementById('banner-container');
    if (!container) return;
    
    setInterval(() => {
        const dots = document.querySelectorAll('.banner-dot');
        if (dots.length > 1) {
            currentBanner = (currentBanner + 1) % dots.length;
            goToBanner(currentBanner);
        }
    }, 5000);
}

function goToBanner(index) {
    const container = document.getElementById('banner-container');
    const slides = container.querySelectorAll('.banner-slide');
    const dots = document.querySelectorAll('.banner-dot');
    
    if (slides[index]) {
        container.scrollTo({ left: slides[index].offsetLeft - 16, behavior: 'smooth' });
    }
    
    dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
    currentBanner = index;
}

// Cart Functions
function openCart() { document.getElementById('cart-overlay').classList.add('active'); }
function closeCart() { document.getElementById('cart-overlay').classList.remove('active'); }

function addToCart(product, qty = 1) {
    const existing = cart.find(item => item.id === product.id);
    if (existing) {
        existing.quantity += qty;
    } else {
        cart.push({ ...product, quantity: qty });
    }
    saveCart();
    updateCartUI();
    showToast('Added to cart!');
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    updateCartUI();
}

function updateCartQty(productId, delta) {
    const item = cart.find(i => i.id === productId);
    if (item) {
        item.quantity += delta;
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            saveCart();
            updateCartUI();
        }
    }
}

function saveCart() {
    localStorage.setItem('store_cart_{{ $profile->user_id }}', JSON.stringify(cart));
}

function updateCartUI() {
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    // Update badges
    ['header-cart-badge', 'desktop-cart-badge', 'nav-cart-badge'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = count;
            el.style.display = count > 0 ? 'flex' : 'none';
        }
    });
    
    // Update total
    const totalEl = document.getElementById('cart-total');
    if (totalEl) totalEl.textContent = currencySymbol + total.toLocaleString();
    
    // Update cart items
    const container = document.getElementById('cart-items');
    if (cart.length === 0) {
        container.innerHTML = '<div class="cart-empty"><i class="fas fa-shopping-cart"></i><p>Your cart is empty</p></div>';
    } else {
        container.innerHTML = cart.map(item => `
            <div class="cart-item">
                <div class="cart-item-image">
                    ${item.image_url ? `<img src="${item.image_url}" alt="${item.name}">` : '<i class="fas fa-image" style="font-size: 24px; color: #D1D5DB; display: flex; align-items: center; justify-content: center; height: 100%;"></i>'}
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">${currencySymbol}${item.price.toLocaleString()}</div>
                    <div class="cart-item-qty">
                        <button class="qty-btn" onclick="updateCartQty(${item.id}, -1)"><i class="fas fa-minus"></i></button>
                        <span class="qty-value">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateCartQty(${item.id}, 1)"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <button class="cart-item-remove" onclick="removeFromCart(${item.id})"><i class="fas fa-trash"></i></button>
            </div>
        `).join('');
    }
}

// Checkout
function checkout() {
    if (cart.length === 0) {
        showToast('Your cart is empty!');
        return;
    }
    
    let message = "🛒 *New Order*\n\n";
    let total = 0;
    
    cart.forEach(item => {
        const subtotal = item.price * item.quantity;
        total += subtotal;
        message += `• ${item.name} x${item.quantity} - ${currencySymbol}${subtotal.toLocaleString()}\n`;
    });
    
    message += `\n*Total: ${currencySymbol}${total.toLocaleString()}*`;
    
    const url = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
}

// Wishlist Functions
function openWishlist() {
    renderWishlist();
    document.getElementById('wishlist-overlay').classList.add('active');
}

function closeWishlist() {
    document.getElementById('wishlist-overlay').classList.remove('active');
}

function renderWishlist() {
    const container = document.getElementById('wishlist-items');
    const footer = document.getElementById('wishlist-footer');
    
    if (wishlist.length === 0) {
        container.innerHTML = `
            <div class="cart-empty">
                <i class="fas fa-heart"></i>
                <p>Your wishlist is empty</p>
                <p style="font-size: 12px; color: #9CA3AF; margin-top: 8px;">Add items you love to your wishlist</p>
            </div>
        `;
        footer.style.display = 'none';
        return;
    }
    
    // Get product data from the page
    const products = [];
    document.querySelectorAll('.product-card').forEach(card => {
        const productId = parseInt(card.querySelector('.product-wishlist').onclick.toString().match(/\d+/)?.[0]);
        if (wishlist.includes(productId)) {
            const name = card.querySelector('.product-name').textContent;
            const price = card.querySelector('.price-current').textContent;
            const img = card.querySelector('.product-image img')?.src || '';
            products.push({ id: productId, name, price, img });
        }
    });
    
    container.innerHTML = products.map(item => `
        <div class="cart-item">
            <div class="cart-item-image">
                ${item.img ? `<img src="${item.img}" alt="${item.name}">` : '<i class="fas fa-image" style="font-size: 24px; color: #D1D5DB;"></i>'}
            </div>
            <div class="cart-item-info">
                <div class="cart-item-name">${item.name}</div>
                <div class="cart-item-price">${item.price}</div>
                <button onclick="removeFromWishlist(${item.id})" style="margin-top: 8px; padding: 4px 12px; background: #EF4444; color: white; border: none; border-radius: 6px; font-size: 12px; cursor: pointer;">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        </div>
    `).join('');
    
    footer.style.display = 'block';
}

function removeFromWishlist(productId) {
    wishlist = wishlist.filter(id => id !== productId);
    localStorage.setItem('store_wishlist_{{ $profile->user_id }}', JSON.stringify(wishlist));
    
    // Update the heart icon on the product card
    document.querySelectorAll('.product-wishlist').forEach(btn => {
        const btnProductId = parseInt(btn.onclick.toString().match(/\d+/)?.[0]);
        if (btnProductId === productId) {
            btn.classList.remove('active');
            btn.querySelector('i').classList.replace('fas', 'far');
        }
    });
    
    updateWishlistUI();
    renderWishlist();
    showToast('Removed from wishlist');
}

function viewWishlistProducts() {
    closeWishlist();
    // Scroll to products section
    document.querySelector('.products-section')?.scrollIntoView({ behavior: 'smooth' });
    showToast('Showing your wishlist items');
}

function toggleWishlist(event, productId) {
    event.stopPropagation();
    const btn = event.currentTarget;
    const icon = btn.querySelector('i');
    
    if (wishlist.includes(productId)) {
        wishlist = wishlist.filter(id => id !== productId);
        icon.classList.remove('fas');
        icon.classList.add('far');
        btn.classList.remove('active');
    } else {
        wishlist.push(productId);
        icon.classList.remove('far');
        icon.classList.add('fas');
        btn.classList.add('active');
    }
    
    localStorage.setItem('store_wishlist_{{ $profile->user_id }}', JSON.stringify(wishlist));
    updateWishlistUI();
}

function updateWishlistUI() {
    ['desktop-wishlist-badge', 'nav-wishlist-badge'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = wishlist.length;
            el.style.display = wishlist.length > 0 ? 'flex' : 'none';
        }
    });
    
    // Update heart icons
    document.querySelectorAll('.product-wishlist').forEach(btn => {
        const productId = parseInt(btn.onclick.toString().match(/\d+/)?.[0]);
        if (wishlist.includes(productId)) {
            btn.classList.add('active');
            btn.querySelector('i').classList.replace('far', 'fas');
        }
    });
}

// Product Modal
function openProductModal(product) {
    currentProduct = product;
    modalQty = 1;
    
    const imageContainer = document.getElementById('modal-image');
    if (product.image_url) {
        imageContainer.innerHTML = `<img src="${product.image_url}" alt="${product.name}"><button class="modal-close" onclick="closeProductModal()"><i class="fas fa-times"></i></button>`;
    } else {
        imageContainer.innerHTML = `<div style="height: 100%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-image" style="font-size: 60px; color: #D1D5DB;"></i></div><button class="modal-close" onclick="closeProductModal()"><i class="fas fa-times"></i></button>`;
    }
    
    document.getElementById('modal-name').textContent = product.name;
    document.getElementById('modal-price').textContent = currencySymbol + product.price.toLocaleString();
    document.getElementById('modal-desc').textContent = product.description || 'No description available.';
    document.getElementById('modal-qty').textContent = modalQty;
    
    document.getElementById('product-modal').classList.add('active');
}

function closeProductModal() {
    document.getElementById('product-modal').classList.remove('active');
    currentProduct = null;
}

function updateModalQty(delta) {
    modalQty = Math.max(1, modalQty + delta);
    document.getElementById('modal-qty').textContent = modalQty;
}

function addToCartFromModal() {
    if (currentProduct) {
        addToCart(currentProduct, modalQty);
        closeProductModal();
    }
}

// Search & Filter
function searchProducts() {
    const query = (document.getElementById('search-input')?.value || document.getElementById('desktop-search')?.value || '').toLowerCase();
    document.querySelectorAll('.product-card').forEach(card => {
        const name = card.dataset.name;
        card.style.display = name.includes(query) ? 'block' : 'none';
    });
}

function filterByCategory(categoryId) {
    document.querySelectorAll('.category-item').forEach(item => {
        item.classList.toggle('active', item.dataset.id === categoryId || (categoryId === 'all' && !item.dataset.id));
    });
    
    document.querySelectorAll('.product-card').forEach(card => {
        const match = categoryId === 'all' || card.dataset.category == categoryId;
        card.style.display = match ? 'block' : 'none';
    });
}

let currentSort = 'default';
let currentCategory = 'all';

function toggleFilters() {
    document.getElementById('filter-overlay').classList.add('active');
}

function closeFilters() {
    document.getElementById('filter-overlay').classList.remove('active');
}

function applySorting(sortType) {
    currentSort = sortType;
    const productsContainer = document.querySelector('.products-grid');
    const products = Array.from(document.querySelectorAll('.product-card'));
    
    // Mark active sort option
    document.querySelectorAll('.filter-option').forEach(opt => {
        if (opt.onclick && opt.onclick.toString().includes(sortType)) {
            opt.classList.add('active');
        } else if (opt.onclick && opt.onclick.toString().includes('applySorting')) {
            opt.classList.remove('active');
        }
    });
    
    products.sort((a, b) => {
        const nameA = (a.dataset.name || '').toLowerCase();
        const nameB = (b.dataset.name || '').toLowerCase();
        const priceA = parseFloat(a.dataset.price || 0);
        const priceB = parseFloat(b.dataset.price || 0);
        
        switch(sortType) {
            case 'name-asc': return nameA.localeCompare(nameB);
            case 'name-desc': return nameB.localeCompare(nameA);
            case 'price-asc': return priceA - priceB;
            case 'price-desc': return priceB - priceA;
            default: return 0;
        }
    });
    
    products.forEach(product => productsContainer.appendChild(product));
    showToast('Sorted successfully');
}

function clearFilters() {
    currentSort = 'default';
    currentCategory = 'all';
    
    // Clear active states
    document.querySelectorAll('.filter-option').forEach(opt => opt.classList.remove('active'));
    
    // Show all products
    filterByCategory('all');
    
    // Reset product order
    const productsContainer = document.querySelector('.products-grid');
    const products = Array.from(document.querySelectorAll('.product-card'));
    products.sort((a, b) => {
        return parseInt(a.dataset.originalOrder || 0) - parseInt(b.dataset.originalOrder || 0);
    });
    products.forEach(product => productsContainer.appendChild(product));
    
    showToast('Filters cleared');
}

function scrollToCategories() {
    const categoriesSection = document.querySelector('.categories-scroll');
    if (categoriesSection) {
        categoriesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        // Highlight categories briefly
        setTimeout(() => {
            categoriesSection.style.transition = 'background 0.3s';
            categoriesSection.style.background = 'rgba(16, 185, 129, 0.1)';
            setTimeout(() => {
                categoriesSection.style.background = '';
            }, 800);
        }, 500);
    } else {
        // If no categories, show products section
        const productsSection = document.querySelector('.products-section');
        if (productsSection) {
            productsSection.scrollIntoView({ behavior: 'smooth' });
            showToast('Browse all products');
        }
    }
}

// Toast
function showToast(message) {
    const toast = document.createElement('div');
    toast.style.cssText = 'position: fixed; bottom: 100px; left: 50%; transform: translateX(-50%); background: #1F2937; color: white; padding: 12px 24px; border-radius: 8px; font-size: 14px; z-index: 1000; animation: fadeIn 0.3s;';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
}
</script>

@endsection
