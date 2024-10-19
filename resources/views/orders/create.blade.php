@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Buat Order Baru</h2>
    
    <div class="mb-3">
        <input type="text" id="searchMenu" class="form-control" placeholder="Cari nama makanan..." onkeyup="searchMenu()">
    </div>

    <div class="row" id="menuCards">
        @foreach($menus as $menu)
            <div class="col-md-4 menu-card" style="margin-bottom: 30px;" data-name="{{ strtolower($menu->name) }}">
                <div class="card" style="border: 1px solid #ddd; border-radius: 10px; overflow: hidden; transition: transform 0.3s;">
                    <img src="{{ url('image/menu/' . $menu->image_path) }}" class="card-img-top" alt="{{ $menu->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1.25rem; font-weight: bold;">{{ $menu->name }}</h5>
                        <p class="card-text" style="font-size: 1rem; color: #28a745;">Rp{{ number_format($menu->price, 2, ',', '.') }}</p>
                        <button class="btn btn-primary" style="width: 100%;" onclick="selectMenu('{{ $menu->id }}', '{{ $menu->name }}', {{ $menu->price }})">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="orderForm" style="display:none; margin-top: 20px;">
        <h4>Detail Order</h4>
        <div id="selectedMenuDetails" style="margin-bottom: 15px; font-weight: bold;"></div>
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" id="selected_menu_id" name="menu_id" required>
            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
            </div>
            <div class="form-group">
                <label for="delivery_date">Tanggal Pengiriman</label>
                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan Order</button>
        </form>
    </div>
</div>

<script>
    function searchMenu() {
        const input = document.getElementById('searchMenu');
        const filter = input.value.toLowerCase();
        const cards = document.querySelectorAll('.menu-card');

        cards.forEach(card => {
            const menuName = card.getAttribute('data-name');
            if (menuName.includes(filter)) {
                card.style.display = ""; 
            } else {
                card.style.display = "none"; 
            }
        });
    }

    function selectMenu(menuId, menuName, menuPrice) {
        document.getElementById('selected_menu_id').value = menuId;
        document.getElementById('selectedMenuDetails').innerText = `Menu yang dipilih: ${menuName} - Rp${menuPrice.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`; // Menampilkan nama menu
        document.getElementById('quantity').value = 1; 
        document.getElementById('orderForm').style.display = 'block';
    }
</script>
@endsection
