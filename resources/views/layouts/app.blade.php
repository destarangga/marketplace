<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-details">
                <div class="logo_name">Marketplace</div>
                <i class='bx bx-menu' id="btn" ></i>
            </div>
            <ul class="nav-list">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class='bx bx-home-alt'></i>
                        <span class="links_name">Home</span>
                    </a>
                    <span class="tooltip">Home</span>
                </li>
                @if (auth()->check() && auth()->user()->role === 'merchant')
                <li>
                    <a href="{{ route('menus.index') }}">
                        <i class='bx bx-grid-alt'></i>
                        <span class="links_name">Menu</span>
                    </a>
                    <span class="tooltip">Menu</span>
                </li>
                @endif
                <li>
                    <a href="{{ route('orders.index') }}">
                        <i class='bx bx-cart-alt'></i>
                        <span class="links_name">Order</span>
                    </a>
                    <span class="tooltip">Order</span>
                </li>
                <li>
                    <a href="{{ route('invoices.index') }}">
                        <i class='bx bx-food-menu'></i>
                        <span class="links_name">Lihat Invoice</span>
                    </a>
                    <span class="tooltip">Invoice</span>
                </li> 
                <li>
                    <a href="{{ route('profile.show') }}">
                        <i class='bx bx-user'></i>
                        <span class="links_name">Profil</span>
                    </a>
                    <span class="tooltip">Profil</span>
                </li>                               
                @if (auth()->check())
                <li class="profile">
                    <div class="profile-details">
                        <div class="name_job">
                            <div class="company_name">{{ auth()->user()->company_name }}</div>
                            <div class="job">{{ auth()->user()->role }}</div>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button>
                            <i class='bx bx-log-out' id="log_out"></i>
                        </button>
                    </form>
                </li>
                @endif
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container">
            @yield('content') 
        </div>
    </div>

    <script>
      let sidebar = document.querySelector(".sidebar");
      let closeBtn = document.querySelector("#btn");
      let searchBtn = document.querySelector(".bx-search");
    
      closeBtn.addEventListener("click", ()=> {
        sidebar.classList.toggle("open");
        menuBtnChange(); 
      });
    
      searchBtn.addEventListener("click", ()=> { 
        sidebar.classList.toggle("open");
        menuBtnChange();
      });
    
      function menuBtnChange() {
        if(sidebar.classList.contains("open")) {
          closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); 
        } else {
          closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); 
        }
      }
    </script>
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-ZVP8gziD15h9NUX7YgPfH+6m3uZQ4LkD3mDP5PBjGMq0PzBr64Vf8uY44S0N1Q0t" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-5c5ss5x56t/6UbR5I76sKDf8G9bNnE8+RW2nbQ+fxZBgBv1Ke5sZ9M2qeHeD4F8g" crossorigin="anonymous"></script>
</body>
</html>
