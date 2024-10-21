@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mt-3 mb-3">
        <h2>Buat Order Baru</h2>
    </div>
    <div class="alert alert-secondary" role="alert">
        Setiap order hanya bisa memesan satu menu saja jika ingin menambah menu Buat Pesanan!
    </div>
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Cari nama makanan atau nama merchant..." onkeyup="searchMenuAndMerchant()">
    </div>

    @if($menus->isEmpty())
        <div class="alert alert-warning" role="alert">
            Menu belum tersedia.
        </div>
    @else
        <div class="row" id="menuCards">
            @foreach($menus as $menu)
                <div class="col-md-4 menu-card" style="margin-bottom: 30px;" 
                     data-name="{{ strtolower($menu->name) }}" 
                     data-merchant="{{ strtolower($menu->merchant ? $menu->merchant->company_name : '') }}">
                     <div class="card" style="border: 1px solid #ddd; border-radius: 10px; overflow: hidden; transition: transform 0.3s;">
                        <img src="{{ url('image/menu/' . $menu->image_path) }}" class="card-img-top" alt="{{ $menu->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 1.25rem; font-weight: bold;">{{ $menu->name }}</h5>
                            <p class="description">{{ $menu->description }}</p>
                            @if(strlen($menu->description) > 10) 
                            <span class="more-link">Selengkapnya</span>
                            @endif
                            <p class="card-text" style="font-size: 1rem; color: #28a745;">Rp{{ number_format($menu->price, 2, ',', '.') }}</p>
                            <p class="card-text" style="font-size: 0.9rem; color: #007bff;">{{ optional($menu->merchant)->company_name }}</p> 
                            <button class="btn btn-primary" style="width: 100%;" onclick="selectMenu('{{ $menu->id }}', '{{ $menu->name }}', {{ $menu->price }})">Pesan Sekarang</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="modal" id="orderForm" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog d-flex justify-content-center">
            <div class="modal-content w-75">
                <div class="modal-body p-4">
                    <div id="selectedMenuDetails" style="margin-bottom: 15px; font-weight: bold;"></div>
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <input type="hidden" id="selected_menu_id" name="menu_id" required>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label for="quantity">Jumlah Pesanan</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                        </div>
    
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label for="delivery_date">Tanggal Pengiriman</label>
                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
                        </div>
    
                        <button type="submit" class="btn btn-primary btn-block mb-2">Simpan Order</button>
                        <a href="{{ route('orders.create') }}">
                            <button type="button" class="btn btn-danger btn-block">Batal Order</button>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function searchMenuAndMerchant() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const cards = document.querySelectorAll('.menu-card');

        cards.forEach(card => {
            const menuName = card.getAttribute('data-name');
            const merchantName = card.getAttribute('data-merchant');
            if (menuName.includes(filter) || merchantName.includes(filter)) {
                card.style.display = ""; 
            } else {
                card.style.display = "none"; 
            }
        });
    }

    function selectMenu(menuId, menuName, menuPrice) {
        document.getElementById('selected_menu_id').value = menuId;
        document.getElementById('selectedMenuDetails').innerText = `Menu yang dipilih: ${menuName} - Rp${menuPrice.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        document.getElementById('quantity').value = 1; 
        document.getElementById('orderForm').style.display = 'block';
        $('#orderForm').modal('show'); 
    }

    
    document.addEventListener('DOMContentLoaded', function () {
    const descriptions = document.querySelectorAll('.description');

    descriptions.forEach(function(description) {
        const moreLink = description.nextElementSibling;

        moreLink.addEventListener('click', function() {
            if (description.classList.contains('expanded')) {
                description.classList.remove('expanded');
                moreLink.textContent = 'Selengkapnya';
            } else {
                description.classList.add('expanded');
                moreLink.textContent = 'Sembunyikan';
            }
        });
    });
});
</script>
@endsection
