<div class="cart-price">
    @if($product->url)
        <a class="cart-btn2" target="_blank" href="{{ $product->url }}">Commander</a>
        <span class="price">{{ $product->price_cents }} CHF</span>
    @else
        @if($product->sku > 0)
            <form method="post" action="{{ url('cart/addProduct') }}" class="form-inline">{!! csrf_field() !!}
                <button type="submit" class="cart-btn2">Ajouter au panier</button>
                <span class="price">{{ $product->price_cents }} CHF</span>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            </form>
        @else
            <p class="text-muted">Ouvrage épuisé</p>
        @endif
    @endif
</div>