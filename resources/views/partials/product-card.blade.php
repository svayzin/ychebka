<div class="product-card">
    @if($product->is_new)
    <span class="product-badge new">Новинка</span>
    @endif
    @if($product->is_popular)
    <span class="product-badge popular">Популярное</span>
    @endif
    
    <div class="product-image">
        @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" 
             alt="{{ $product->name }}"
             onerror="this.src='https://via.placeholder.com/300x200/2A2A2A/C9A86A?text={{ urlencode($product->name) }}'">
        @else
        <div class="no-image">
            <i class="bi bi-image"></i>
        </div>
        @endif
    </div>
    
    <div class="product-info">
        <h3 class="product-name">{{ $product->name }}</h3>
        
        @if($product->description)
        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
        @endif
        
        <div class="product-meta">
            <span class="product-weight">{{ $product->weight }} {{ $product->weight_unit }}</span>
            <span class="product-price">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
        </div>
        
        <button class="btn-exact add-to-cart" data-product-id="{{ $product->id }}">
            <i class="bi bi-cart-plus"></i>
            В корзину
        </button>
    </div>
</div>

<style>
.product-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    border-color: #AD1C43;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.product-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    z-index: 1;
}

.product-badge.new {
    background: #4CAF50;
    color: white;
}

.product-badge.popular {
    background: #FF9800;
    color: black;
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.no-image {
    width: 100%;
    height: 100%;
    background: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-gray);
    font-size: 48px;
}

.product-info {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-name {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--text-light);
    line-height: 1.3;
}

.product-description {
    color: var(--text-gray);
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 15px;
    flex: 1;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.product-weight {
    color: var(--text-gray);
    font-size: 14px;
}

.product-price {
    font-size: 20px;
    font-weight: 700;
    color: #AD1C43;
}

.btn-exact.add-to-cart {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    cursor: pointer;
}
</style>