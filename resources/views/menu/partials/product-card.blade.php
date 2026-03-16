<div class="product-card">
    <div class="product-image">
        @if($product->image)
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        @else
        <div class="no-image">
            <i class="bi bi-image"></i>
        </div>
        @endif  
    </div>
    
    <div class="product-info">
        <h3 class="product-name">{{ $product->name }}</h3>
        
        @if($product->description)
        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
        @endif
        
        <div class="product-meta">
            <span class="product-weight">{{ $product->weight_display }}</span>
            <span class="product-price">{{ $product->formatted_price }}</span>
        </div>
        
        <button class="add-to-cart btn-elegant" data-product-id="{{ $product->id }}">
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
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    border-color: #AD1C43;
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

.badge-new,
.badge-popular {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.badge-new {
    background: #4CAF50;
    color: white;
}

.badge-popular {
    background: #FF9800;
    color: black;
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

.add-to-cart {
    width: 100%;
    padding: 10px;
    font-size: 14px;
}
</style>