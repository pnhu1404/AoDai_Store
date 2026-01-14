<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-20">
        <a href="/" class="text-2xl font-bold serif text-red-800 tracking-tighter">
            ÁO DÀI HERITAGE
        </a>
        
        <div class="hidden md:flex space-x-8 font-medium text-stone-600">
            <a href="/" class="hover:text-red-700 transition">Trang chủ</a>
            <div class="group relative">
                <a href="#" class="hover:text-red-700 transition flex items-center">
                    Bộ sưu tập 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                <div class="absolute hidden group-hover:block bg-white shadow-lg border mt-2 py-2 w-48 transition-all">
                    <a href="#" class="block px-4 py-2 hover:bg-stone-50 hover:text-red-700">Áo dài Cưới</a>
                    <a href="#" class="block px-4 py-2 hover:bg-stone-50 hover:text-red-700">Áo dài Nữ sinh</a>
                    <a href="#" class="block px-4 py-2 hover:bg-stone-50 hover:text-red-700">Áo dài Cách tân</a>
                </div>
            </div>
            <a href="#" class="hover:text-red-700 transition">Hướng dẫn chọn size</a>
            <a href="#" class="hover:text-red-700 transition">Liên hệ</a>
        </div>

        <div class="flex items-center space-x-5">
            <button class="text-stone-600 hover:text-red-700" title="Tìm kiếm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
            <div class="relative group">
                <div class="relative group">
                    <!-- ICON -->
                    <div class="cursor-pointer text-stone-600 hover:text-red-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a4 4 0 100 8 4 4 0 000-8zm-7 16a7 7 0 0114 0H3z"/>
                        </svg>
                    </div>

                    <!-- DROPDOWN -->
                    <div
                        class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-xl
                            opacity-0 invisible group-hover:opacity-100 group-hover:visible
                            transition-all duration-150 z-50">

                        <div class="py-2">
                            @guest
                                <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-red-50">
                                    Đăng nhập
                                </a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-red-50">
                                    Đăng ký
                                </a>
                            @endguest

                            @auth
                                <div class="px-4 py-2 text-sm text-stone-500">
                                    Xin chào,<br>
                                    <span class="font-semibold text-stone-800">
                                        {{ Auth::user()->HoTen }}
                                    </span>
                                </div>

                                <a href="/profile" class="block px-4 py-2 hover:bg-red-50">
                                    Thông tin tài khoản
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left px-4 py-2 hover:bg-red-50">
                                        Đăng xuất
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
            <a href="/cart" class="relative text-stone-600 hover:text-red-700" title="Giỏ hàng">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                    2
                </span>
            </a>
            <button class="md:hidden text-stone-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </div>
</nav>