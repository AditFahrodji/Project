<div>
  {{-- Hero Section Start --}}
  <section class="px-3 py-5 bg-gradient-to-r from-white-800 via-white-700 to-white-600 lg:py-10">
    <div class="grid lg:grid-cols-2 items-center justify-items-center gap-5">
      <div class="order-2 lg:order-1 flex flex-col justify-center items-center text-center">
        <p class="text-4xl font-bold md:text-6xl text-black">Dapatkan DISKON hingga 50%</p>
        <p class="text-4xl font-bold md:text-6xl text-black">di Trend Store</p>
        <p class="mt-2 text-base md:text-lg text-black">Buruan! Penawaran terbatas.</p>
        <a href="/login" class="text-lg md:text-2xl bg-gray-800 text-white py-2 px-5 mt-10 hover:bg-gray-700 rounded-md">Shop Now</a>
      </div>
      <div class="order-1 lg:order-2">
        <img class="h-80 w-80 object-cover lg:w-[500px] lg:h-[500px] rounded-full border-4 border-white" src="https://cdn.freebiesupply.com/logos/large/2x/trend-logo-png-transparent.png" alt="Trend Store">
      </div>
    </div>
  </section>
  {{-- Hero Section End --}}
  
  {{-- Brand Section Start --}}
  <section class="py-20 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-bold text-white">Temukan Brand di TrendStore</h2>
        <p class="text-lg text-white">Jelajahi koleksi brand ternama kami yang tersedia di TrendStore.</p>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($brands as $brand)
          <a href="/produk?selected_brands[0]={{ $brand->id }}" class="group flex flex-col items-center justify-center bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105">
            <img src="{{ url('storage', $brand->logo) }}" alt="{{ $brand->nama }}" class="object-contain w-32 h-32 transition duration-300">
            <h3 class="text-lg font-semibold text-gray-800 mt-4">{{ $brand->nama }}</h3>
        </a>
        @endforeach
      </div>
    </div>
  </section>
  {{-- Brand Section End --}}

  
  {{-- Kategori Section Start --}}
  <section class="py-20 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Temukan Kategori di TrendStore</h2>
        <p class="text-lg text-white mb-12">Jelajahi berbagai kategori yang tersedia di TrendStore.</p>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($kategoris as $kategori)
          <a href="/produk?selected_kategoris[0]={{ $kategori->id }}" class="group flex flex-col items-center justify-center bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105">
            <img src="{{ url('storage', $kategori->gambar) }}" alt="{{ $kategori->nama }}" class="object-cover w-32 h-32 md:w-48 md:h-48 transition duration-300">
            <h3 class="text-lg font-semibold text-gray-800 mt-4">{{ $kategori->nama }}</h3>
          </a>
        @endforeach
      </div>
    </div>
  </section>
{{-- Kategori Section End --}}


  
</div>